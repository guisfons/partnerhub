<!-- Monthly Rooms Sold Chart -- Page 1 -->
<script>
    (function() {
        // Define variables with default values
        var xValues = [];
        var yValues = [];

        // Assign values based on the hotel_code
        <?php if (get_field('hotel_code') == 'LUPOS') { ?>
            xValues = [2024, 2023, 2022, 2021, 2020, 2019];
            yValues = [89, 151, 217, 0, 0, 393];
        <?php } ?>

        <?php if (get_field('hotel_code') == 'THANA') { ?>
            xValues = [2024, 2023];
            yValues = [886, 1181];
        <?php } ?>

        <?php if (get_field('hotel_code') == 'LUTAN') { ?>
            xValues = [2024, 2023, 2022, 2021];
            yValues = [594, 644, 522, 513];
        <?php } ?>

        if ($('#monthlyRoomSoldChart').length > 0) {
            var ctxRoomSold = document.querySelector('#monthlyRoomSoldChart').getContext('2d');
        }

        if ($('#monthlyRoomSoldChart1').length > 0) {
            var ctxRoomSold1 = document.querySelector('#monthlyRoomSoldChart1').getContext('2d');
        }

        const getDynamicMinMax = (values) => {
            const min = Math.min(...values);
            const max = Math.max(...values);
            const dynamicMinValue = Math.floor(min * 0.4);
            const adjustedMax = Math.ceil(max * 1.15);
            return {
                dynamicMinValue,
                adjustedMax
            };
        };

        const {
            dynamicMinValue,
            adjustedMax
        } = getDynamicMinMax(yValues);

        let data = {
            type: 'bar',
            data: {
                labels: xValues,
                datasets: [{
                    label: 'Monthly Rooms Sold',
                    data: yValues,
                    backgroundColor: ['#25475C', '#5EC4C8', '#2E7C8A', '#92D1D4', '', '#BFCDD0'],
                    fill: false,
                    tension: 0.1,
                    pointRadius: 5,
                    pointHoverRadius: 10,
                    spanGaps: true,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: barChartAnimationOptions.animation,
                plugins: {
                    removeColorBoxes: {}, // Apply custom plugin
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                let value = context.raw;
                                return `${label}: ${value}`; // Show the yValues on the tooltip
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        min: dynamicMinValue,
                        max: adjustedMax,
                        ticks: {
                            stepSize: Math.ceil((adjustedMax - dynamicMinValue) / 5) // Adjust step size for readability
                        }
                    }
                }
            },
            plugins: [customLegendPlugin] // Add custom legend plugin
        };

        var monthlyRoomSoldChart = new Chart(ctxRoomSold, data);
        var monthlyRoomSoldChart1 = new Chart(ctxRoomSold1, data);
    })();
</script>