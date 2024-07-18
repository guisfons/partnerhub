<!-- Monthly Occupancy Chart -- Page 1 -->
<script>
    (function() {
    // Define variables with default values
    var xValues = [];
    var yValues = [];

    // Assign values based on the hotel_code
    <?php if (get_field('hotel_code') == 'LUPOS') { ?>
        xValues = [2024, 2023, 2022, 2021, 2020, 2019];
        yValues = [21, 36, 52, 0, 0, 94];
    <?php } ?>

    <?php if (get_field('hotel_code') == 'THANA') { ?>
        xValues = [2024, 2023];
        yValues = [38.35, 51.80];
    <?php } ?>

    <?php if (get_field('hotel_code') == 'EXA') { ?>
        xValues = [2024, 2023, 2022, 2021];
        yValues = [58, 63, 51, 50];
    <?php } ?>

    if ($('#monthlyOccupancyChart').length > 0) {
        var ctxOccupancy = document.querySelector('#monthlyOccupancyChart').getContext('2d');
    }

    if ($('#monthlyOccupancyChart1').length > 0) {
        var ctxOccupancy1 = document.querySelector('#monthlyOccupancyChart1').getContext('2d');
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

    // Custom formatter to format values as percentages
    function customPercentageFormatter(value) {
        return value.toFixed(2) + '%'; // Format value with two decimal places and add percentage sign
    }

    let data = {
        type: 'bar',
        data: {
            labels: xValues,
            datasets: [{
                label: 'Monthly Occupancy %',
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
                            return `${label}: ${customPercentageFormatter(value)}`; // Use custom formatter for tooltips
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    min: dynamicMinValue,
                    max: adjustedMax,
                    ticks: {
                        callback: function(value) {
                            return customPercentageFormatter(value); // Use custom formatter for y-axis ticks
                        }
                    }
                }
            }
        },
        plugins: [customLegendPlugin] // Add custom legend plugin
    };

    var monthlyOccupancyChart = new Chart(ctxOccupancy, data);
    var monthlyOccupancyChart1 = new Chart(ctxOccupancy1, data);
})();
</script>