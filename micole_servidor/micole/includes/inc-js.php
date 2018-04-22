<!-- inject:js -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery-nicescroll.min.js"></script>
<script src="js/autosize.min.js"></script>
<script src="js/jquery-ui.js"></script>
<!-- endinject -->

<!--highcharts-->
<script src="js/highcharts.js"></script>
<script src="js/highcharts-more.js"></script>
<script src="js/exporting.js"></script>
<!--polar-chart init-->

<!--sparkline-->
<script src="js/jquery-sparkline-retina.js"></script>
<script src="js/init-sparkline.js"></script>

<!--echarts-->
<script type="text/javascript" src="js/echarts-all-3.js"></script>


<!--easypiechart-->
<script src="js/jquery-easypiechart.js"></script>

<!--horizontal-timeline-->
<script src="js/jquery-mobile-custom.min.js"></script>
<script src="js/main.js"></script>

<!-- Common Script   -->
<script src="js/main1.js"></script>

<!-- Leaflet -->
<script src="leaflet/leaflet.js"></script>
<script src="/includes/plugin/leaflet.wmslegend.js"></script>
<script src="/includes/plugin/L.Control.Layers.Tree.js"></script>

<!-- Toastr Notifications Dependencies -->
<script src="js/toastr.js"></script>
<script src="js/init-toastr-notification.js"></script>
<script type="text/javascript">
toastr.options = {
  "closeButton": true,
  "debug": false,
  "newestOnTop": false,
  "progressBar": true,
  "positionClass": "toast-bottom-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}
function sleep (time) {
  return new Promise((resolve) => setTimeout(resolve, time));
}
</script>
