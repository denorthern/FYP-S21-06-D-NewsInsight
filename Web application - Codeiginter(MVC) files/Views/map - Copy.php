

<html>
  <head>
  
    <title>JavaScript Flow Map</title>
    <script src="https://cdn.anychart.com/releases/8.10.0/js/anychart-core.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.10.0/js/anychart-map.min.js"></script>

    <script src="https://cdn.anychart.com/geodata/latest/custom/world/world.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.3.15/proj4.js"></script>

    <script src="https://cdn.anychart.com/releases/8.10.0/js/anychart-data-adapter.min.js"></script>

    <style type="text/css">      
      html, body, #container { 
        width: 100%; height: 100%; margin: 0; padding: 0; 
      } 
    </style>
  </head>
  <body>  
    <div id="container"></div>
    <script>
	  anychart.onDocumentReady(function () {
    anychart.data.loadJsonFile(    '',
	function (data) {
	
	data=<?php echo json_encode($data1, JSON_NUMERIC_CHECK);?>;
		

	


      // Creates map chart
      var map = anychart.connector();

      // Sets settings for map chart
      map.geoData('anychart.maps.world');

      map
        .unboundRegions()
        .enabled(true)
        .fill('#E1E1E1')
        .stroke('#D2D2D2');

     // Sets title for map chart and customizes it
      map
        .title()
        .enabled(true)
        .useHtml(true)
        .padding([0, 0, 40, 0])
        .text(
          '<span style="color:#212121;">Map of countries mentioned in the news sources of </span><br/>' +
          '<span style="font-size: 14px;"></span>'+<?php echo "'<span>".$country."</span>'";?>
        );
    
      // Display all labels even if there is an overlap
      map. 
        overlapMode("allow-overlap");
    
      // Helper function to create several series
       var createSeries = function (name, data, color) {
        
        // Creates connector series for destinations and customizes them
        var connectorSeries = map
          .connector(data)
          .name(name)
          .fill(color)
          .stroke({
            color: color,
            thickness: 2
          });
        
        connectorSeries
          .hovered()
          .stroke('1.5 #212121')
          .fill('#212121');
         
        connectorSeries
          .markers()
          .position('100%')
          .fill(color)
          .stroke({
            color: color
          })
          .size(8);
         
         connectorSeries
          .hovered()
          .markers()
          .position('100%')
          .size(10)
          .fill('#212121')
          .stroke('2 #455a64');
		


		
        // Sets labels for the source countries
		
        connectorSeries
          .labels()
		  .position('100%')
          .enabled(true)
          .format(function () {
            return this.getData('to');
          })
         .fontColor('#212121');
		 
		
		 
        // Sets the width of the line based on data
        if (name === 'More than 1000') {
          connectorSeries.startSize(5).endSize(2);
        } else if (name === '100 to 1000') {
          connectorSeries.startSize(3.5).endSize(1.5);
        } else if (name === '50 to 100') {
          connectorSeries.startSize(3).endSize(1);
        } else if (name === '10 to 50') {
          connectorSeries.startSize(2).endSize(0.5);
        } else {
          connectorSeries.startSize(1).endSize(0);
        }
         
         // Sets settings for legend items
         connectorSeries
          .legendItem()
          .iconType('square')
          .iconFill(color)
          .iconStroke(false);
      
         // sets tooltip setting for the series
         connectorSeries
          .tooltip()
          .useHtml(true)
          .format(function () {
            return (
              '<h4 style="font-size:14px; font-weight:400; margin: 0.25rem                 0;">Origin:<b> ' + this.getData('from') +  '</b></h4>' +
              '<h4 style="font-size:14px; font-weight:400; margin: 0.25rem                 0;">Total Mentions::<b> ' +        this.getData('total').toLocaleString() + '</b></h4>'
            );
          });

      };

      // Creates Dataset in required format from the data
      var dataSet = anychart.data.set(data).mapAs();
//'#81d4fa',
  //        '#4fc3f7',
    //      '#29b6f6',
      //    '#039be5',
        //  '#0288d1',
          //'#0277bd',
			//'#01579b'
      // Creates 6 series, filtering the data by the number of mentions
      createSeries(
        'Less than 10',
        dataSet.filter('total', filterFunction(1, 10)),
        '#4fc3f7'
      );
      createSeries(
        '10 to 50',
        dataSet.filter('total', filterFunction(10, 50)),
        '#29b6f6'
      );
      createSeries(
        '50 to 100',
        dataSet.filter('total', filterFunction(50, 100)),
        '#039be5'
      );
      createSeries(
        '100 to 1000',
        dataSet.filter('total', filterFunction(100, 1000)),
        '#0288d1'
      );
      createSeries(
        'More than 1000',
        dataSet.filter('total', filterFunction(1000, 100000)),
        '#0277bd'
      );

      // Turns on the legend
      map
        .legend()
        .enabled(true)
        .position('bottom')
        .padding([0, 0, 20, 0])
        .fontSize(10);

      map
        .legend()
        .title()
        .enabled(true)
        .fontSize(13)
        .padding([0, 0, 5, 0])
        .text('Mentions');
    

      // Sets container id for the chart
      map.container('container');

      // Initiates chart drawing
      map.draw();
    }
	
	
	
	
  );
});

// Helper function to bind data field to the local var.
function filterFunction(val1, val2) {
  if (val2) {
    return function (fieldVal) {
      return val1 <= fieldVal && fieldVal < val2;
    };
  }
  return function (fieldVal) {
    return val1 <= fieldVal;
  };
}
    </script>
	
  </body>
</html>