
/**
 * Request data from the server, add it to the graph and set a timeout to request again
 */
var chart; // global
function requestData() {
$.ajax({
    url: 'test.php',
    success: function(point) {
        var series = chart.series[0],
            shift = series.data.length > 20; // shift if the series is longer than 20

        // add the point
        chart.series[0].addPoint(point, true, shift);

        // call it again after one second
        setTimeout(requestData, 1000);    
    },
    cache: false
   });
 }
 $(document).ready(function() {
   chart = new Highcharts.Chart({
      chart: {
        renderTo: 'container',
        defaultSeriesType: 'line',
        events: {
            load: requestData
        }
    },
    title: {
        text: 'BlackHawk Graphing Library Test Run #47'
    },
    xAxis: {
        type: 'datetime',
        tickPixelInterval: 100,
        maxZoom: 20 * 1000
    },

    yAxis: {
        minPadding: 5,
        maxPadding: 5,
		min: 0,
		max: 100,
        title: {
            text: 'Percent Occupied',
            margin: 80
        }
    },
	plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: true
                }
    },
    series: [{
        name: 'Live Parking Data From Garage #1',
        data: []
     }]
   });        
});
 