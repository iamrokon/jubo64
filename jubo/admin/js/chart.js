		var color = Chart.helpers.color;
        var barChartData = {
            labels: [	"Jan"
					],
            datasets: [{
                label: 'Fragrances',
                backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
                borderColor: window.chartColors.red,
                borderWidth: 1,
                data: [
                    "<?php echo $nsept1; ?>"
                ]
            }
		
			]

        };

        window.onload = function() {
            var ctx = document.getElementById("canvas").getContext("2d");
            window.myBar = new Chart(ctx, {
                type: 'bar',
                data: barChartData,
                options: {
                    responsive: true,
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Product Sales Per Month'
                    }
                }
            });

        };