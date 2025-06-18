<script>
  $(document).ready(function() {
    $('#p_use').click(function() {
      uni_modal("Privacy Policy", "policy.php", "mid-large")
    })
    window.viewer_modal = function($src = '') {
      start_loader()
      var t = $src.split('.')
      t = t[1]
      if (t == 'mp4') {
        var view = $("<video src='" + $src + "' controls autoplay></video>")
      } else {
        var view = $("<img src='" + $src + "' />")
      }
      $('#viewer_modal .modal-content video,#viewer_modal .modal-content img').remove()
      $('#viewer_modal .modal-content').append(view)
      $('#viewer_modal').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,
        focus: true
      })
      end_loader()

    }
    window.uni_modal = function($title = '', $url = '', $size = "") {
      start_loader()
      $.ajax({
        url: $url,
        error: err => {
          console.log()
          alert("An error occured")
        },
        success: function(resp) {
          if (resp) {
            $('#uni_modal .modal-title').html($title)
            $('#uni_modal .modal-body').html(resp)
            if ($size != '') {
              $('#uni_modal .modal-dialog').addClass($size + '  modal-dialog-centered')
            } else {
              $('#uni_modal .modal-dialog').removeAttr("class").addClass("modal-dialog modal-md modal-dialog-centered")
            }
            $('#uni_modal').modal({
              show: true,
              backdrop: 'static',
              keyboard: false,
              focus: true
            })
            end_loader()
          }
        }
      })
    }
    window._conf = function($msg = '', $func = '', $params = []) {
      $('#confirm_modal #confirm').attr('onclick', $func + "(" + $params.join(',') + ")")
      $('#confirm_modal .modal-body').html($msg)
      $('#confirm_modal').modal('show')
    }
  })
</script>
<!-- Footer-->


<footer>
  <div class="container">
    <div class="row text-center text-md-left">
      
      <!-- Company Info -->
      <div class="col-md-4 mb-4">
        <h5>FOOD CATERING</h5>
        <p>
          Make every occasion memorable with our professional food catering services. From corporate events to private parties,
           we offer customizable menus to match your taste and budget.
            Enjoy fresh, delicious dishes beautifully prepared and served
             with care — so you can relax and savor every moment.
        </p>
      </div>

      <!-- Contact Details -->
      <div class="col-md-4 mb-4">
        <h5>CONTACT US</h5>
        <ul>
          <li><i class="fas fa-phone-alt"></i> <strong>Phone:</strong> 0930 908 8781</li>
          <li><i class="fab fa-facebook"></i> <strong>Facebook:</strong>
            <a href="https://www.facebook.com/share/12MVccM6oVf/" target="_blank">Visit our Page</a>
          </li>
        </ul>
      </div>

      <!-- Quick Links -->
      <div class="col-md-4 mb-4">
        <h5>QUICK LINKS</h5>
        <ul>
          <li><a href=".?p=home">Home</a></li>
          <li><a href=".?p=packages">Packages</a></li>
          <li><a href=".?p=about">About Us</a></li>
        </ul>
      </div>

    </div>

    <div class="footer-bottom">
      &copy; <?php echo date('Y'); ?> Food Catering. All rights reserved.
    </div>
  </div>
</footer>

<!-- Add FontAwesome if not already included -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">




<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url ?>plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url ?>plugins/sparklines/sparkline.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url ?>plugins/select2/js/select2.full.min.js"></script>
<!-- JQVMap -->
<script src="<?php echo base_url ?>plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo base_url ?>plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url ?>plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url ?>plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url ?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?php echo base_url ?>plugins/summernote/summernote-bs4.min.js"></script>
<script src="<?php echo base_url ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- overlayScrollbars -->
<!-- <script src="<?php echo base_url ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script> -->
<!-- AdminLTE App -->
<script src="<?php echo base_url ?>dist/js/adminlte.js"></script>
<div class="daterangepicker ltr show-ranges opensright">
  <div class="ranges">
    <ul>
      <li data-range-key="Today">Today</li>
      <li data-range-key="Yesterday">Yesterday</li>
      <li data-range-key="Last 7 Days">Last 7 Days</li>
      <li data-range-key="Last 30 Days">Last 30 Days</li>
      <li data-range-key="This Month">This Month</li>
      <li data-range-key="Last Month">Last Month</li>
      <li data-range-key="Custom Range">Custom Range</li>
    </ul>
  </div>
  <div class="drp-calendar left">
    <div class="calendar-table"></div>
    <div class="calendar-time" style="display: none;"></div>
  </div>
  <div class="drp-calendar right">
    <div class="calendar-table"></div>
    <div class="calendar-time" style="display: none;"></div>
  </div>
  <div class="drp-buttons"><span class="drp-selected"></span><button class="cancelBtn btn btn-sm btn-default" type="button">Cancel</button><button class="applyBtn btn btn-sm btn-primary" disabled="disabled" type="button">Apply</button> </div>
</div>
<div class="jqvmap-label" style="display: none; left: 1093.83px; top: 394.361px;">Idaho</div>

<style>
  footer {
    background-color: #212529;
    color: #fff;
    padding-top: 60px;
    padding-bottom: 40px;
    font-size: 0.95rem;
    border-top: 2px solid #444;
  }
  footer h5 {
    font-size: 1.2rem;
    font-weight: 700;
    margin-bottom: 20px;
  }
  footer ul {
    padding-left: 0;
    list-style: none;
  }
  footer ul li {
    margin-bottom: 10px;
  }
  footer a {
    color: #ccc;
    text-decoration: none;
  }
  footer a:hover {
    color: #fff;
    text-decoration: underline;
  }
  .footer-bottom {
    text-align: center;
    margin-top: 40px;
    font-size: 0.85rem;
    color: #aaa;
    border-top: 1px solid #444;
    padding-top: 20px;
  }
</style>