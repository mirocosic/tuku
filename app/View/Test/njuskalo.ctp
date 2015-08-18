<!DOCTYPE html>
<html>
    <head>
         <!-- JQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        
         <script src="/js/jquery.canvasjs.min.js"></script>
        <script type="text/javascript">
$(function () {
	//Better to construct options first and then pass it as a parameter
	var options = {
		title: {
			text: "Avg Price per Year - <?=$manufacturer;?> <?=$model;?>"
		},
                animationEnabled: true,
                axisY:{
                    interval: 20000
                },
               
                toolTip:{
                    contentFormatter: function ( e ) {
                        var price = e.entries[0].dataPoint.y;
                        return price.toFixed(2) + ' kn ('+ e.entries[0].dataPoint.count +')';
                    }  
                },
		data: [
		{
			type: "spline", //change it to line, area, column, pie, etc
                    /*    
			dataPoints: [
				{ x: 10, y: 10 },
				{ x: 20, y: 12 },
				{ x: 30, y: 8 },
				{ x: 40, y: 14 },
				{ x: 50, y: 6 },
				{ x: 60, y: 24 },
				{ x: 70, y: -4 },
				{ x: 80, y: 10 }
			]
                        
                    */
                   dataPoints : <?php echo json_encode($data);?>
                
		},
                        {
			type: "spline", //change it to line, area, column, pie, etc
                    /*    
			dataPoints: [
				{ x: 10, y: 10 },
				{ x: 20, y: 12 },
				{ x: 30, y: 8 },
				{ x: 40, y: 14 },
				{ x: 50, y: 6 },
				{ x: 60, y: 24 },
				{ x: 70, y: -4 },
				{ x: 80, y: 10 }
			]
                        
                    */
                   dataPoints : <?php echo json_encode($data2);?>
                
		}
		]
	};

	$("#chartContainer").CanvasJSChart(options);

});
</script>
    </head>
    <body>
        <div id="chartContainer" style="height: 500px; width: 90%;"></div>
        <?php echo json_encode($data);?>
    </body>
</html>
