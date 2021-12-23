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
 
var chart = new CanvasJS.Chart("chart-person", {
	animationEnabled: true,
	theme: "light2",
	title:{
		text: ""
	},
	axisY: {
		title: "Frequency"
	},
	data: [{
		type: "column",
		yValueFormatString: "#,##0.## times",
		dataPoints: <?php echo json_encode($dataPoints_per, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();


var chart1 = new CanvasJS.Chart("chart-org", {
	animationEnabled: true,
	theme: "light2",
	title:{
		text: ""
	},
	axisY: {
		title: "Frequency"
	},
	data: [{
		type: "column",
		yValueFormatString: "#,##0.## times",
		dataPoints: <?php echo json_encode($dataPoints_org, JSON_NUMERIC_CHECK); ?>
	}]
});
chart1.render();



var chart2 = new CanvasJS.Chart("chart-loc", {
	animationEnabled: true,
	theme: "light2",
	title:{
		text: ""
	},
	axisY: {
		title: "Frequency"
	},
	data: [{
		type: "column",
		yValueFormatString: "#,##0.## times",
		dataPoints: <?php echo json_encode($dataPoints_loc, JSON_NUMERIC_CHECK); ?>
	}]
});
chart2.render();


var chart3 = new CanvasJS.Chart("chart-product", {
	animationEnabled: true,
	theme: "light2",
	title:{
		text: ""
	},
	axisY: {
		title: "Frequency"
	},
	data: [{
		type: "column",
		yValueFormatString: "#,##0.## times",
		dataPoints: <?php echo json_encode($dataPoints_pro, JSON_NUMERIC_CHECK); ?>
	}]
});
chart3.render();



var chart4 = new CanvasJS.Chart("chart-event", {
	animationEnabled: true,
	theme: "light2",
	title:{
		text: ""
	},
	axisY: {
		title: "Frequency"
	},
	data: [{
		type: "column",
		yValueFormatString: "#,##0.## times",
		dataPoints: <?php echo json_encode($dataPoints_event, JSON_NUMERIC_CHECK); ?>
	}]
});
chart4.render();
 
}
</script>
</head>
<body>
<br></br><h3><a>Persons</a></h3>
<div id="chart-person" style="height: 370px; width: 100%;"></div>
<h3><a>Organizations</a></h3></br>
<div id="chart-org" style="height: 370px; width: 100%;"></div>
<h3><a>Geo Political Locations</a></h3></br>
<div id="chart-loc" style="height: 370px; width: 100%;"></div>
<h3><a>Products</a></h3></br>
<div id="chart-product" style="height: 370px; width: 100%;"></div>
<h3><a>Events</a></h3></br>
<div id="chart-event" style="height: 370px; width: 100%;"></div>
</body>
</html>  