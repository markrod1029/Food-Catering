<h1 class="text-light">Welcome to <?php echo $_settings->info('name') ?></h1>
<hr>
<div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-light elevation-1"><i class="fas fa-utensils"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Menu</span>
                <span class="info-box-number">
                  <?php 
                    $inv = $conn->query("SELECT count(id) as total FROM inventory ")->fetch_assoc()['total'];
                    echo number_format($inv);
                  ?>
                  <?php ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-th-list"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Waiting fo Confirmation</span>
                <span class="info-box-number">
                  <?php 
                    $pending = $conn->query("SELECT count(id) as total FROM `orders` where status = '0' ")->fetch_assoc()['total'];
                    echo number_format($pending);
                  ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-calendar-day"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Upcoming</span>
                <span class="info-box-number">
                <?php 
                    $upcomming = $conn->query("SELECT count(id) as total FROM `orders` where status = '1' and unix_timestamp(event_date) >= '".strtotime(date('Y-m-d H:i'))."'  ")->fetch_assoc()['total'];
                    echo number_format($upcomming);
                  ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
        </div>
<div class="container">
  <?php 
    $files = array();
    $products = $conn->query("SELECT * FROM `products` order by rand() ");
    while($row = $products->fetch_assoc()){
      if(!is_dir(base_app.'uploads/product_'.$row['id']))
      continue;
      $fopen = scandir(base_app.'uploads/product_'.$row['id']);
      foreach($fopen as $fname){
        if(in_array($fname,array('.','..')))
          continue;
        $files[]= validate_image('uploads/product_'.$row['id'].'/'.$fname);
      }
    }
  ?>
  <div id="tourCarousel"  class="carousel slide" data-ride="carousel" data-interval="3000">
      <div class="carousel-inner h-100">
          <?php foreach($files as $k => $img): ?>
          <div class="carousel-item  h-100 <?php echo $k == 0? 'active': '' ?>">
              <img class="d-block w-100  h-100" style="object-fit:contain" src="<?php echo $img ?>" alt="">
          </div>
          <?php endforeach; ?>
      </div>
      <a class="carousel-control-prev" href="#tourCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#tourCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
      </a>
  </div>
</div>
