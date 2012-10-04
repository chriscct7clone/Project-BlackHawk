	$(document).ready(function() {
		//* small charts
		blackhawk_peity.init();
	    //* sortable/searchable list (used to for search on students page)
		
		//* charts
		blackhawk_charts.fl_1();
		blackhawk_charts.fl_2();
		//* responsive table
		blackhawk_media_table.init();
		//* resize elements on window resize
		var lastWindowHeight = $(window).height();
		var lastWindowWidth = $(window).width();
		$(window).on("debouncedresize",function() {
			if($(window).height()!=lastWindowHeight || $(window).width()!=lastWindowWidth){
				lastWindowHeight = $(window).height();
				lastWindowWidth = $(window).width();
			}
		});
	});
	
	//* small charts
	blackhawk_peity = {
		init: function() {
			$.fn.peity.defaults.line = {
				strokeWidth: 1,
				delimeter: ",",
				height: 32,
				max: null,
				min: 0,
				width: 50
			};
			$.fn.peity.defaults.bar = {
				delimeter: ",",
				height: 32,
				max: null,
				min: 0,
				width: 50
			};
			$(".p_bar_up").peity("bar",{
				colour: "#6cc334"
			});
			$(".p_bar_down").peity("bar",{
				colour: "#e11b28"
			});
			$(".p_line_up").peity("line",{
				colour: "#b4dbeb",
				strokeColour: "#3ca0ca"
			});
			$(".p_line_down").peity("line",{
				colour: "#f7bfc3",
				strokeColour: "#e11b28"
			});
		}
	};

	//* charts
    blackhawk_charts = {
        fl_1: function() {
            // Setup the placeholder reference
            elem = $('#fl_1');
            var var1 = [], var2 = [];
            for (var i = 0; i < 14; i += 0.5) {
                
				var1.push([i, i+1]);
                var2.push([i, Math.cos(i)]);
            }
            // Setup the flot chart using our data
            $.plot(elem, 
                [
                    { label: "line",  data: var1},
                    { label: "cos(x)",  data: var2}
                ], 
                {
                    lines: { show: true },
                    points: { show: true },
					// If we don't explicitly define the axis, the graph will be made to fit
                    //yaxis: { min: -1.2, max: 1.2 },
                    grid: {
                        hoverable: true,
                        borderWidth: 1
                    },
					colors: [ "#8cc7e0", "#2d83a6" ]
                }
            );
            // Create a tooltip on our chart
            elem.qtip({
                prerender: true,
                content: 'Loading...', // Use a loading message primarily
                position: {
                    viewport: $(window), // Keep it visible within the window if possible
                    target: 'mouse', // Position it in relation to the mouse
                    adjust: { x: 8, y: -30 } // ...but adjust it a bit so it doesn't overlap it.
                },
                show: false, // We'll show it programatically, so no show event is needed
                style: {
                    classes: 'ui-tooltip-shadow ui-tooltip-tipsy',
                    tip: false // Remove the default tip.
                }
            });
         
            // Bind the plot hover
            elem.on('plothover', function(event, coords, item) {
                // Grab the API reference
                var self = $(this),
                    api = $(this).qtip(),
                    previousPoint, content,
         
                // Setup a visually pleasing rounding function
                round = function(x) { return Math.round(x * 1000) / 1000; };
         
                // If we weren't passed the item object, hide the tooltip and remove cached point data
                if(!item) {
                    api.cache.point = false;
                    return api.hide(event);
                }
         
                // Proceed only if the data point has changed
                previousPoint = api.cache.point;
                if(previousPoint !== item.dataIndex)
                {
                    // Update the cached point data
                    api.cache.point = item.dataIndex;
         
                    // Setup new content
                    content = item.series.label + '(' + round(item.datapoint[0]) + ') = ' + round(item.datapoint[1]);
         
                    // Update the tooltip content
                    api.set('content.text', content);
         
                    // Make sure we don't get problems with animations
                    //api.elements.tooltip.stop(1, 1);
         
                    // Show the tooltip, passing the coordinates
                    api.show(coords);
                }
            });
        },
        fl_2 : function() {
            // Setup the placeholder reference
            elem = $('#fl_2');
           
			var data = [
				{
					label: "Students",
					data: 560
				},
				{
					label: "Faculty",
					data: 360
				},
                {
					label: "Misc Staff",
					data: 320
				},
				{
					label: "Visitors",
					data: 280
				},
				{
					label: "Other",
					data: 160
				}
			];
			
			// Setup the flot chart using our data
            $.plot(elem, data,         
                {
					label: "Visitors by Location",
                    series: {
                        pie: {
                            show: true,
							highlight: {
								opacity: 0.2
							}
                        }
                    },
                    grid: {
                        hoverable: true,
                        clickable: true
                    },
					//colors: [ "#b3d3e8", "#8cbddd", "#65a6d1", "#3e8fc5", "#3073a0", "#245779", "#183b52" ]
					colors: [ "#b4dbeb", "#8cc7e0", "#64b4d5", "#3ca0ca", "#2d83a6", "#22637e", "#174356", "#0c242e" ]
                }
            );
            // Create a tooltip on our chart
            elem.qtip({
                prerender: true,
                content: 'Loading...', // Use a loading message primarily
                position: {
                    viewport: $(window), // Keep it visible within the window if possible
                    target: 'mouse', // Position it in relation to the mouse
                    adjust: { x: 7 } // ...but adjust it a bit so it doesn't overlap it.
                },
                show: false, // We'll show it programatically, so no show event is needed
                style: {
                    classes: 'ui-tooltip-shadow ui-tooltip-tipsy',
                    tip: false // Remove the default tip.
                }
            });
         
            // Bind the plot hover
            elem.on('plothover', function(event, pos, obj) {
                
                // Grab the API reference
                var self = $(this),
                    api = $(this).qtip(),
                    previousPoint, content,
         
                // Setup a visually pleasing rounding function
                round = function(x) { return Math.round(x * 1000) / 1000; };
         
                // If we weren't passed the item object, hide the tooltip and remove cached point data
                if(!obj) {
                    api.cache.point = false;
                    return api.hide(event);
                }
         
                // Proceed only if the data point has changed
                previousPoint = api.cache.point;
                if(previousPoint !== obj.seriesIndex)
                {
                    percent = parseFloat(obj.series.percent).toFixed(2);
                    // Update the cached point data
                    api.cache.point = obj.seriesIndex;
                    // Setup new content
                    content = obj.series.label + ' ( ' + percent + '% )';
                    // Update the tooltip content
                    api.set('content.text', content);
                    // Make sure we don't get problems with animations
                    //api.elements.tooltip.stop(1, 1);
                    // Show the tooltip, passing the coordinates
                    api.show(pos);
                }
            });
        }
    };
	
    //* responsive tables
    blackhawk_media_table = {
        init: function() {
			$('.mediaTable').mediaTable();
        }
    };
