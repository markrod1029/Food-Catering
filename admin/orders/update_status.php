
<?php 
require_once('../../config.php');
$order = $conn->query("SELECT o.*,concat(c.firstname,' ',c.lastname) as client FROM `orders` o inner join clients c on c.id = o.client_id where o.id = '{$_GET['oid']}' ");
if($order->num_rows > 0){
    foreach($order->fetch_assoc() as $k => $v){
        $$k = $v;
    }
}
?>
<div class="container-fluid">
    <form id="status-update-form">
        <input type="hidden" name="id" value="<?php echo $_GET['oid'] ?>">
        <div class="form-group">
            <label for="additional_amount" class="control-label">Additional Amount</label>
            <input type="number" name="additional_amount" id="additional_amount" class="form-control" step="any" value="<?php echo $additional_amount ?>">
        </div>
        <div class="form-group">
            <label for="additional_remarks" class="control-label">Additional Remarks</label>
            <textarea rows="2" name="additional_remarks" id="additional_remarks" class="form-control"><?php echo $additional_remarks ?></textarea>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Status</label>
            <select name="status" id="" class="custom-select custol-select-sm">
                <option value="0" <?php echo $_GET['status'] == 0 ? "selected" : '' ?>>Pending</option>
                <option value="1" <?php echo $_GET['status'] == 1 ? "selected" : '' ?>>Confirmed</option>
                <option value="2" <?php echo $_GET['status'] == 2 ? "selected" : '' ?>>Done</option>
                <option value="3" <?php echo $_GET['status'] == 3 ? "selected" : '' ?>>Cancelled</option>
            </select>
        </div>
    </form>
</div>
<script>
    $(function(){
        $('#status-update-form').submit(function(e){
            e.preventDefault();
            start_loader()
            $.ajax({
                url:_base_url_+"classes/Master.php?f=update_order_status",
                method:"POST",
                data:$(this).serialize(),
                dataType:"json",
                error:err=>{
                    console.log(err)
                    alert_toast("An error occured","error")
                    end_loader()
                },
                success:function(resp){
                    if(!!resp.status && resp.status =='success'){
                        location.reload()
                    }else{
                        console.log(resp)
                        alert_toast("An error occured","error")
                        end_loader()
                    }
                }
            })
        })
    })
</script>