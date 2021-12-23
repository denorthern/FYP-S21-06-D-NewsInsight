
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

<div id="myPlot" style="width:100%;max-width:100%"></div>

<script>

//var xValues = [100,200,300,400,500,600,700, 800, 900, 1000];
var xValues = <?php echo json_encode($datax, JSON_NUMERIC_CHECK);?>;
var yValues = <?php echo json_encode($datay, JSON_NUMERIC_CHECK);?>;
var y1Values = <?php echo json_encode($datay2, JSON_NUMERIC_CHECK);?>;
// Define Data
var n1=<?php echo json_encode($name); ?>;
var n2=<?php echo json_encode($name2); ?>;
var data = [
  {x: xValues, y: y1Values, mode:"lines", name: n2},
  {x: xValues, y: yValues, mode:"lines", name: n1}
];

//Define Layout
var layout = {title: "khiho", showlegend:true};

// Display using Plotly
Plotly.newPlot("myPlot", data, layout);
</script>
