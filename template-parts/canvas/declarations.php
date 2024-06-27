<script>
    // Define a number formatter for Euros
    const euroFormatter = new Intl.NumberFormat('de-DE', {
        style: 'currency',
        currency: 'EUR',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });

    // Define a number formatter for Thai Baht
    const thaiBahtFormatter = new Intl.NumberFormat('th-TH', {
        style: 'currency',
        currency: 'THB',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });

    // Custom Legend Plugin
    const customLegendPlugin = {
        id: 'removeColorBoxes',
        afterUpdate: function(chart) {
            if (chart.legend) {
                const legendItems = chart.legend.legendItems;
                legendItems.forEach(item => {
                    item.fillStyle = 'transparent';
                });
            }
        }
    };

    // Function to calculate dynamic min and max values for y-axis
    function getDynamicMinMax(yValues) {
        let minValue = Math.min(...yValues);
        let maxValue = Math.max(...yValues);

        // Calculate dynamic minimum value
        let marginPercentage = 0.30; // 30% margin
        let dynamicMinValue = minValue - (minValue * marginPercentage);
        if (dynamicMinValue < 0) dynamicMinValue = 0; // Ensure min value is not less than 0

        // Set margins for the max value
        let margin = (maxValue - minValue) * marginPercentage; // 30% margin for max value
        let adjustedMax = maxValue + margin;

        return {
            dynamicMinValue,
            adjustedMax
        };
    }

    // Bar chart animation options
    const barChartAnimationOptions = {
        animation: {
            duration: 1000,
            easing: 'easeOutBounce',
            from: 'bottom'
        }
    };

    // Pie chart animation options
    const pieChartAnimationOptions = {
        animation: {
            duration: 1000,
            easing: 'easeOutBounce'
        }
    };
</script>