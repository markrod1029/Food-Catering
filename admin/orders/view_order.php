<?php if(isset($_GET['view'])): 
require_once('../../config.php');
endif;?>
<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<?php 
if(!isset($_GET['id'])){
    $_settings->set_flashdata('error','No order ID Provided.');
    redirect('admin/?page=orders');
}
$order = $conn->query("SELECT o.*,concat(c.firstname,' ',c.lastname) as client FROM `orders` o inner join clients c on c.id = o.client_id where o.id = '{$_GET['id']}' ");
if($order->num_rows > 0){
    foreach($order->fetch_assoc() as $k => $v){
        $$k = $v;
    }
}else{
    $_settings->set_flashdata('error','Order ID provided is Unknown');
    redirect('admin/?page=orders');
}
?>
<div class="card card-outline card-primary">
    <?php if(!isset($_GET['view'])): ?>
    <div class="card-header">
        <div class="card-tools">
			<button type="button" id="print" class="btn btn-flat btn-success"><span class="fas fa-print"></span>  Print</button>
		</div>
    </div>
    <?php endif; ?>

    <div class="card-body">
        <div class="conitaner-fluid" id="printable">
            <p><b>Client Name: <?php echo $client ?></b></p>
            <p><b>Event: <?php echo $event ?></b></p>
            <p><b>Event Venue: <?php echo $venue ?></b></p>
            <p><b>Event Schedule: <?php echo date("F d, Y H:i A",strtotime($event_date)) ?></b></p>
            <table class="table-striped table table-bordered">
                <colgroup>
                    <col width="15%">
                    <col width="35%">
                    <col width="25%">
                    <col width="25%">
                </colgroup>
                <thead>
                    <tr>
                        <th>QTY</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $olist = $conn->query("SELECT o.*,p.title FROM order_list o inner join `inventory` i on i.id = o.inventory_id inner join products p on i.product_id = p.id where o.order_id = '{$id}' ");
                        while($row = $olist->fetch_assoc()):
                        foreach($row as $k => $v){
                            $row[$k] = trim(stripslashes($v));
                        }
                    ?>
                    <tr>
                        <td><?php echo $row['quantity'] ?></td>
                        <td>
                            <p class="m-0"><?php echo $row['title']?></p>
                        </td>
                        <td class="text-right"><?php echo number_format($row['price']) ?></td>
                        <td class="text-right"><?php echo number_format($row['price'] * $row['quantity']) ?></td>
                    </tr>
                    <?php endwhile; ?>
                    <tr>
                        <td>x</td>
                        <td>
                            <p class="m-0">Services and Others</p>
                        </td>
                        <td class="text-right"><?php echo number_format($additional_amount) ?></td>
                        <td class="text-right"><?php echo number_format($additional_amount) ?></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan='3'  class="text-right">Total</th>
                        <th class="text-right"><?php echo number_format($amount + $additional_amount) ?></th>
                    </tr>
                </tfoot>
            </table>
        <div class="row">
            <div class="col-6">
                <div>Additional Remarks:</div>
                <div><?php echo (!empty($additional_remarks))? $additional_remarks : "N/A" ?></div>
            </div>
            <div class="col-6 row row-cols-2">
                <div class="col-3">Reservation Status:</div>
                <div class="col-9">
                <?php 
                    switch($status){
                        case '0':
                            echo '<span class="badge badge-light text-dark">Pending</span>';
	                    break;
                        case '1':
                            echo '<span class="badge badge-primary">Confirmed</span>';
	                    break;
                        case '2':
                            echo '<span class="badge badge-success">Done</span>';
	                    break;
                        default:
                            echo '<span class="badge badge-danger">Cancelled</span>';
	                    break;
                    }
                ?>
                </div>
                <?php if(!isset($_GET['view'])): ?>
                <div class="col-3"></div>
                <div class="col">
                    <button type="button" id="update_status" class="btn btn-sm btn-flat btn-primary">Update Status</button>
                </div>
                <?php endif; ?>
                
            </div>
        </div>
        </div>
    </div>
</div>
<?php if(isset($_GET['view'])): ?>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
<style>
    #uni_modal>.modal-dialog>.modal-content>.modal-footer{
        display:none;
    }
    #uni_modal .modal-body{
        padding:0;
    }
</style>
<?php endif; ?>
<script>
    $(function(){
        $('#update_status').click(function(){
            uni_modal("Update Status", "./orders/update_status.php?oid=<?php echo $id ?>&status=<?php echo $status ?>")
        })
    $('#print').click(function(){
        start_loader();
        var _h = $('head').clone()
        var els= $('<div>')
        var output = $('#printable').clone()
            output.find('button').remove()
        els.append(_h) 
        els.append('<h3 class="text-center"><?php echo $_settings->info('name') ?></h3>') 
        els.append('<h3 class="text-center">Invoice</h3>') 
        els.append(output) 
        var nw = window.document.open("","_blank","width=900,heigth=700")
            nw.document.write(els.html())
            nw.document.close()
            nw.print()
            setTimeout(() => {
                nw.close()
                end_loader()
            }, 500);
    })
    })
</script>