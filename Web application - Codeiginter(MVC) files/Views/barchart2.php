<!DOCTYPE HTML>
<html>
<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>/now/assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="<?php echo base_url(); ?>/now/assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <!-- CSS Files -->
  <link href="<?php echo base_url(); ?>/now/assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>/now/assets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="<?php echo base_url(); ?>/now/assets/demo/demo.css" rel="stylesheet" />

<script>
window.onload = function() {
 
var chart1 = new CanvasJS.Chart("chartContainer12", {
	animationEnabled: true,
	theme: "light2",
	title:{
		text: ""
	},
	axisY: {
		title: "discussed"
	},
	data: [{
		type: "column",
		yValueFormatString: "#,##0.## times",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart1.render();
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2",
	title:{
		text: ""
	},
	axisY: {
		title: "discussed"
	},
	data: [{
		type: "column",
		yValueFormatString: "#,##0.## times",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();

 
}
</script>
</head>
<div class="col-lg-12 col-md-9 ">
            <div class="widget widget-stats bg-orange-black-4">
				<div class="stats-icon"><i class="fa "></i></div>
					<div class="stats-info">
                    <h3><b>Top Discussed Persons Today</b>
					<a>sdd<a>
<div id="chartContainer12" style="height: 370px; width: 100%;"></div>
dsds
</div>
</div>
</html>  