<?php wp_footer(); ?>
    </main>
    <footer class="footer">
        <div class="loading-screen">
            <div class="loading-spinner"></div>
        </div>
    </footer>

    <!-- Include Chart.js and the datalabels plugin -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

    <script>
        let xValues = [];
        let yValues = [];

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

            return { dynamicMinValue, adjustedMax };
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

        // THIS STARTS PAGE 1

        // Monthly Rooms Sold Chart -- Page 1

        (function() {
            // Define variables with default values
            var xValues = [];
            var yValues = [];

            // Assign values based on the hotel_code
            <?php if(get_field('hotel_code') == 'LUPOS'){ ?>
                xValues = [2024, 2023, 2022, 2021, 2020, 2019];
                yValues = [89, 151, 217, 0, 0, 393];    
            <?php } ?>

            <?php if(get_field('hotel_code') == 'THANA'){ ?>
                xValues = [2024, 2023];
                yValues = [886, 1181];    
            <?php } ?>

            <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
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
                return { dynamicMinValue, adjustedMax };
            };

            const { dynamicMinValue, adjustedMax } = getDynamicMinMax(yValues);

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

            
        // Monthly Occupancy Chart -- Page 1

        (function() {
            // Define variables with default values
            var xValues = [];
            var yValues = [];

            // Assign values based on the hotel_code
            <?php if(get_field('hotel_code') == 'LUPOS'){ ?>
                xValues = [2024, 2023, 2022, 2021, 2020, 2019];
                yValues = [21, 36, 52, 0, 0, 94];
            <?php } ?>

            <?php if(get_field('hotel_code') == 'THANA'){ ?>
                xValues = [2024, 2023];
                yValues = [38.35, 51.80];
            <?php } ?>

            <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
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
                return { dynamicMinValue, adjustedMax };
            };

            const { dynamicMinValue, adjustedMax } = getDynamicMinMax(yValues);

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

        // Monthly LOS Chart - Page 1

        (function() {
            // Define variables with default values
            var xValues = [];
            var yValues = [];

            // Assign values based on the hotel_code
            <?php if(get_field('hotel_code') == 'LUPOS'){ ?>
                xValues = [2024, 2023, 2022, 2021, 2020];
                yValues = [1.81, 2.29, 2.13, 0, 0];
            <?php } ?>

            <?php if(get_field('hotel_code') == 'THANA'){ ?>
                xValues = [0, 0];
                yValues = [0, 0];
            <?php } ?>

            <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
                xValues = [2024, 2023, 2022, 2021];
                yValues = [1.82, 1.95, 2.22, 1.79];
            <?php } ?>

            if($('#monthlyLosChart').length > 0) {
                var ctxLos = document.querySelector('#monthlyLosChart').getContext('2d');
            }

            if($('#monthlyLosChart1').length > 0) {
                var ctxLos1 = document.querySelector('#monthlyLosChart1').getContext('2d');
            }

            const getDynamicMinMax = (values) => {
                const min = Math.min(...values);
                const max = Math.max(...values);
                const dynamicMinValue = Math.floor(min * 0.4);
                const adjustedMax = Math.ceil(max * 1.15);
                return { dynamicMinValue, adjustedMax };
            };

            const { dynamicMinValue, adjustedMax } = getDynamicMinMax(yValues);

            let data = {
                type: 'bar',
                data: {
                    labels: xValues,
                    datasets: [{
                        label: 'Monthly LOS',
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
                            max: adjustedMax
                        }
                    }
                },
                plugins: [customLegendPlugin] // Add custom legend plugin
            };

            var monthlyLosChart = new Chart(ctxLos, data);
            var monthlyLosChart1 = new Chart(ctxLos1, data);
        })();

        // Monthly ADR Chart - Page 1

        (function() {
            // Define variables with default values
            var xValues = [];
            var yValues = [];
            var formatter;

            // Assign values based on the hotel_code
            <?php if(get_field('hotel_code') == 'LUPOS'){ ?>
                xValues = [2024, 2023, 2022, 2021, 2020, 2019];
                yValues = [105.43, 74.69, 54.63, 0, 0, 15.43];
                formatter = new Intl.NumberFormat('de-DE', {
                    style: 'currency',
                    currency: 'EUR',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            <?php } ?>

            <?php if(get_field('hotel_code') == 'THANA'){ ?>
                xValues = [2024, 2023];
                yValues = [5694.94, 5835.52];
                formatter = new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            <?php } ?>

            <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
                xValues = [2024, 2023, 2022, 2021];
                yValues = [116.57, 110.08, 104.13, 117.98];
                formatter = new Intl.NumberFormat('de-DE', {
                    style: 'currency',
                    currency: 'EUR',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            <?php } ?>

            if ($('#monthlyAdrChart').length > 0) {
                var ctxAdr = document.querySelector('#monthlyAdrChart').getContext('2d');
            }

            if ($('#monthlyAdrChart1').length > 0) {
                var ctxAdr1 = document.querySelector('#monthlyAdrChart1').getContext('2d');
            }

            const getDynamicMinMax = (values) => {
                const min = Math.min(...values);
                const max = Math.max(...values);
                const dynamicMinValue = Math.floor(min * 0.4);
                const adjustedMax = Math.ceil(max * 1.15);
                return { dynamicMinValue, adjustedMax };
            };

            const { dynamicMinValue, adjustedMax } = getDynamicMinMax(yValues);

            // Custom formatter to add a space between the currency symbol and the number
            function customCurrencyFormatter(value, formatter) {
                const formattedValue = formatter.format(value);
                const parts = formatter.formatToParts(value);
                const currencySymbol = parts.find(part => part.type === 'currency').value;
                return formattedValue.replace(currencySymbol, currencySymbol + ' ');
            }

            let data = {
                type: 'bar',
                data: {
                    labels: xValues,
                    datasets: [{
                        label: 'Monthly ADR',
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
                                    return `${label}: ${customCurrencyFormatter(value, formatter)}`; // Use custom formatter for tooltips
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
                                    return customCurrencyFormatter(value, formatter); // Use custom formatter
                                }
                            }
                        }
                    }
                },
                plugins: [customLegendPlugin] // Add custom legend plugin
            };

            let monthlyAdrChart = new Chart(ctxAdr, data);
            let monthlyAdrChart1 = new Chart(ctxAdr1, data);
        })();

        // Monthly RevPAR Chart - Page 1 

        (function() {
            // Define variables with default values
            var xValues = [];
            var yValues = [];
            var formatter;

            // Assign values based on the hotel_code
            <?php if(get_field('hotel_code') == 'LUPOS'){ ?>
                xValues = [2024, 2023, 2022, 2021, 2020, 2019];
                yValues = [22.34, 26.86, 28.22, 0, 0, 14.44];
                formatter = new Intl.NumberFormat('de-DE', {
                    style: 'currency',
                    currency: 'EUR',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            <?php } ?>

            <?php if(get_field('hotel_code') == 'THANA'){ ?>
                xValues = [2024, 2023];
                yValues = [2184.29, 3022.70];
                formatter = new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            <?php } ?>

            <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
                xValues = [2024, 2023, 2022, 2021];
                yValues = [67.89, 69.50, 53.29, 59.34];
                formatter = new Intl.NumberFormat('de-DE', {
                    style: 'currency',
                    currency: 'EUR',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            <?php } ?>

            if ($('#monthlyRevPar').length > 0) {
                var ctxRevPar = document.querySelector('#monthlyRevPar').getContext('2d');
            }

            if ($('#monthlyRevPar1').length > 0) {
                var ctxRevPar1 = document.querySelector('#monthlyRevPar1').getContext('2d');
            }

            const getDynamicMinMax = (values) => {
                const min = Math.min(...values);
                const max = Math.max(...values);
                const dynamicMinValue = Math.floor(min * 0.4);
                const adjustedMax = Math.ceil(max * 1.15);
                return { dynamicMinValue, adjustedMax };
            };

            const { dynamicMinValue, adjustedMax } = getDynamicMinMax(yValues);

            // Custom formatter to add a space between the currency symbol and the number
            function customCurrencyFormatter(value, formatter) {
                const formattedValue = formatter.format(value);
                const parts = formatter.formatToParts(value);
                const currencySymbol = parts.find(part => part.type === 'currency').value;
                return formattedValue.replace(currencySymbol, currencySymbol + ' ');
            }

            let data = {
                type: 'bar',
                data: {
                    labels: xValues,
                    datasets: [{
                        label: 'Monthly RevPAR',
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
                                    return `${label}: ${customCurrencyFormatter(value, formatter)}`; // Use custom formatter for tooltips
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
                                    return customCurrencyFormatter(value, formatter); // Use custom formatter
                                }
                            }
                        }
                    }
                },
                plugins: [customLegendPlugin] // Add custom legend plugin
            };

            let monthlyRevPar = new Chart(ctxRevPar, data);
            let monthlyRevPar1 = new Chart(ctxRevPar1, data);
        })();

        // Monthly Room Rev Chart - Page 1

        (function() {
            // Define variables with default values
            var xValues = [];
            var yValues = [];
            var formatter;

            // Assign values based on the hotel_code
            <?php if(get_field('hotel_code') == 'LUPOS'){ ?>
                xValues = [2024, 2023, 2022, 2021, 2020, 2019];
                yValues = [9382.90, 11278.00, 11854.00, 0, 0, 6064.00];
                formatter = new Intl.NumberFormat('de-DE', {
                    style: 'currency',
                    currency: 'EUR',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            <?php } ?>

            <?php if(get_field('hotel_code') == 'THANA'){ ?>
                xValues = [2024, 2023];
                yValues = [5045717.11, 6891754.67];
                formatter = new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            <?php } ?>

            <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
                xValues = [2024, 2023, 2022, 2021];
                yValues = [69244.76, 70889.94, 54357.90, 60526.30];
                formatter = new Intl.NumberFormat('de-DE', {
                    style: 'currency',
                    currency: 'EUR',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            <?php } ?>

            if ($('#monthlyRoomRev').length > 0) {
                var ctxMonthlyRoomRev = document.querySelector('#monthlyRoomRev').getContext('2d');
            }

            if ($('#monthlyRoomRev1').length > 0) {
                var ctxMonthlyRoomRev1 = document.querySelector('#monthlyRoomRev1').getContext('2d');
            }

            const getDynamicMinMax = (values) => {
                const min = Math.min(...values);
                const max = Math.max(...values);
                const dynamicMinValue = Math.floor(min * 0.4);
                const adjustedMax = Math.ceil(max * 1.15);
                return { dynamicMinValue, adjustedMax };
            };

            const { dynamicMinValue, adjustedMax } = getDynamicMinMax(yValues);

            // Custom formatter to add a space between the currency symbol and the number
            function customCurrencyFormatter(value, formatter) {
                const formattedValue = formatter.format(value);
                const parts = formatter.formatToParts(value);
                const currencySymbol = parts.find(part => part.type === 'currency').value;
                return formattedValue.replace(currencySymbol, currencySymbol + ' ');
            }

            let data = {
                type: 'bar',
                data: {
                    labels: xValues,
                    datasets: [{
                        label: 'Monthly Room Revenue',
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
                                    return `${label}: ${customCurrencyFormatter(value, formatter)}`; // Use custom formatter for tooltips
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
                                    return customCurrencyFormatter(value, formatter); // Use custom formatter
                                }
                            }
                        }
                    }
                },
                plugins: [customLegendPlugin] // Add custom legend plugin
            };

            let monthlyRoomRev = new Chart(ctxMonthlyRoomRev, data);
            let monthlyRoomRev1 = new Chart(ctxMonthlyRoomRev1, data);
        })();


        // THIS STARTS PAGE 2

        // Year-to-Date Rooms Sold Chart -- Page 2

        (function() {
            // Define variables with default values
            var xValues = [];
            var yValues = [];

            // Assign values based on the hotel_code
            <?php if(get_field('hotel_code') == 'LUPOS'){ ?>
                xValues = [2024, 2023, 2022, 2021, 2020, 2019];
                yValues = [89, 151, 217, 0, 0, 393];    
            <?php } ?>

            <?php if(get_field('hotel_code') == 'THANA'){ ?>
                xValues = [2024, 2023];
                yValues = [4259, 4455];    
            <?php } ?>

            <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
                xValues = [2024, 2023, 2022, 2021];
                yValues = [1692, 1952, 1528, 1363];    
            <?php } ?>

            if ($('#ytdRoomSoldChart').length > 0) {
                var ctxYtdRoomSold = document.querySelector('#ytdRoomSoldChart').getContext('2d');
            }

            if ($('#ytdRoomSoldChart1').length > 0) {
                var ctxYtdRoomSold1 = document.querySelector('#ytdRoomSoldChart1').getContext('2d');
            }

            const getDynamicMinMax = (values) => {
                const min = Math.min(...values);
                const max = Math.max(...values);
                const dynamicMinValue = Math.floor(min * 0.95); // Adjusted dynamic min value
                const adjustedMax = Math.ceil(max * 1.05); // Adjusted dynamic max value
                return { dynamicMinValue, adjustedMax };
            };

            const { dynamicMinValue, adjustedMax } = getDynamicMinMax(yValues);

            let data = {
                type: 'bar',
                data: {
                    labels: xValues,
                    datasets: [{
                        label: 'Year-to-Date Rooms Sold',
                        data: yValues,
                        backgroundColor: ['#25475C', '#5EC4C8', '#2E7C8A', '#92D1D4', '', '#BFCDD0'], 
                        fill: false,
                        tension: 0.1,
                        pointStyle: false,
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

            var ytdRoomSoldChart = new Chart(ctxYtdRoomSold, data);
            var ytdRoomSoldChart1 = new Chart(ctxYtdRoomSold1, data);
        })();


        // Year-to-Date Occupancy Percentage Chart -- Page 2

        (function() {
            // Define variables with default values
            var xValues = [];
            var yValues = [];

            // Assign values based on the hotel_code
            <?php if(get_field('hotel_code') == 'LUPOS'){ ?>
                xValues = [2024, 2023, 2022, 2021, 2020, 2019];
                yValues = [21, 36, 52, 0, 0, 94];
            <?php } ?>

            <?php if(get_field('hotel_code') == 'THANA'){ ?>
                xValues = [2024, 2023];
                yValues = [45.71, 47.90];
            <?php } ?>

            <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
                xValues = [2024, 2023, 2022, 2021];
                yValues = [41, 48, 37, 33];    
            <?php } ?>

            if ($('#ytdOccupancyChart').length > 0) {
                var ctxYtdOccupancy = document.querySelector('#ytdOccupancyChart').getContext('2d');
            }

            if ($('#ytdOccupancyChart1').length > 0) {
                var ctxYtdOccupancy1 = document.querySelector('#ytdOccupancyChart1').getContext('2d');
            }

            const getDynamicMinMax = (values) => {
                const min = Math.min(...values);
                const max = Math.max(...values);
                const dynamicMinValue = Math.floor(min * 0.95); // Adjusted dynamic min value
                const adjustedMax = Math.ceil(max * 1.05); // Adjusted dynamic max value
                return { dynamicMinValue, adjustedMax };
            };

            const { dynamicMinValue, adjustedMax } = getDynamicMinMax(yValues);

            // Custom formatter to format values as percentages
            function customPercentageFormatter(value) {
                return value.toFixed(2) + '%'; // Format value with two decimal places and add percentage sign
            }

            let data = {
                type: 'bar',
                data: {
                    labels: xValues,
                    datasets: [{
                        label: 'Year-to-Date Occupancy %',
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

            var ytdOccupancyChart = new Chart(ctxYtdOccupancy, data);
            var ytdOccupancyChart1 = new Chart(ctxYtdOccupancy1, data);
        })();

        // Year-to-Date LOS Chart -- Page 2

        (function() {
            // Define variables with default values
            var xValues = [];
            var yValues = [];

            // Assign values based on the hotel_code
            <?php if(get_field('hotel_code') == 'LUPOS'){ ?>
                xValues = [2024, 2023, 2022, 2021, 2020, 2019];
                yValues = [1.81, 2.29, 2.13, 0, 0, 0];
            <?php } ?>

            <?php if(get_field('hotel_code') == 'THANA'){ ?>
                xValues = [2024, 2023];
                yValues = [0, 0];
            <?php } ?>

            <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
                xValues = [2024, 2023, 2022, 2021];
                yValues = [1.73, 1.74, 1.26, 1.62];    
            <?php } ?>

            if ($('#ytdLosChart').length > 0) {
                var ctxYtdLos = document.querySelector('#ytdLosChart').getContext('2d');
            }

            if ($('#ytdLosChart1').length > 0) {
                var ctxYtdLos1 = document.querySelector('#ytdLosChart1').getContext('2d');
            }

            const getDynamicMinMax = (values) => {
                const min = Math.min(...values);
                const max = Math.max(...values);
                const dynamicMinValue = Math.floor(min * 0.95); // Adjusted dynamic min value
                const adjustedMax = Math.ceil(max * 1.05); // Adjusted dynamic max value
                return { dynamicMinValue, adjustedMax };
            };

            const { dynamicMinValue, adjustedMax } = getDynamicMinMax(yValues);

            let data = {
                type: 'bar',
                data: {
                    labels: xValues,
                    datasets: [{
                        label: 'Year-to-Date LOS',
                        data: yValues,
                        backgroundColor: ['#25475C', '#5EC4C8', '#2E7C8A', '#92D1D4', '', '#BFCDD0'], 
                        fill: false,
                        tension: 0.1,
                        pointStyle: false,
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
                            max: adjustedMax
                        }
                    }
                },
                plugins: [customLegendPlugin] // Add custom legend plugin
            };

            var ytdLosChart = new Chart(ctxYtdLos, data);
            var ytdLosChart1 = new Chart(ctxYtdLos1, data);
        })();

        // Year-to-Date ADR Chart -- Page 2

        (function() {
            // Define variables with default values
            var xValues = [];
            var yValues = [];
            var formatter;

            // Assign values based on the hotel_code
            <?php if(get_field('hotel_code') == 'LUPOS'){ ?>
                xValues = [2024, 2023, 2022, 2021, 2020, 2019];
                yValues = [105.43, 74.69, 54.63, 0, 0, 15.43];
                formatter = new Intl.NumberFormat('de-DE', {
                    style: 'currency',
                    currency: 'EUR',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            <?php } ?>

            <?php if(get_field('hotel_code') == 'THANA'){ ?>
                xValues = [2024, 2023];
                yValues = [5536.84, 5029.35];
                formatter = new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            <?php } ?>

            <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
                xValues = [2024, 2023, 2022, 2021];
                yValues = [110.28, 103.08, 93.90, 108.04];
                formatter = new Intl.NumberFormat('de-DE', {
                    style: 'currency',
                    currency: 'EUR',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            <?php } ?>

            if ($('#ytdAdrChart').length > 0) {
                var ctxYtdAdr = document.querySelector('#ytdAdrChart').getContext('2d');
            }

            if ($('#ytdAdrChart1').length > 0) {
                var ctxYtdAdr1 = document.querySelector('#ytdAdrChart1').getContext('2d');
            }

            const getDynamicMinMax = (values) => {
                const min = Math.min(...values);
                const max = Math.max(...values);
                const dynamicMinValue = Math.floor(min * 0.95); // Adjusted dynamic min value
                const adjustedMax = Math.ceil(max * 1.05); // Adjusted dynamic max value
                return { dynamicMinValue, adjustedMax };
            };

            const { dynamicMinValue, adjustedMax } = getDynamicMinMax(yValues);

            // Custom formatter to add a space between the currency symbol and the number
            function customCurrencyFormatter(value, formatter) {
                const formattedValue = formatter.format(value);
                const parts = formatter.formatToParts(value);
                const currencySymbol = parts.find(part => part.type === 'currency').value;
                return formattedValue.replace(currencySymbol, currencySymbol + ' ');
            }

            let data = {
                type: 'bar',
                data: {
                    labels: xValues,
                    datasets: [{
                        label: 'Year-to-Date ADR',
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
                                    return `${label}: ${customCurrencyFormatter(value, formatter)}`; // Use custom formatter for tooltips
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
                                    return customCurrencyFormatter(value, formatter); // Use custom formatter
                                }
                            }
                        }
                    }
                },
                plugins: [customLegendPlugin] // Add custom legend plugin
            };

            var ytdAdrChart = new Chart(ctxYtdAdr, data);
            var ytdAdrChart1 = new Chart(ctxYtdAdr1, data);
        })();

        // Year-to-Date RevPAR Chart - Page 2

        (function() {
            // Define variables with default values
            var xValues = [];
            var yValues = [];
            var formatter;

            // Assign values based on the hotel_code
            <?php if(get_field('hotel_code') == 'LUPOS'){ ?>
                xValues = [2024, 2023, 2022, 2021, 2020, 2019];
                yValues = [22.34, 26.86, 28.22, 0, 0, 14.44];
                formatter = new Intl.NumberFormat('de-DE', {
                    style: 'currency',
                    currency: 'EUR',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            <?php } ?>

            <?php if(get_field('hotel_code') == 'THANA'){ ?>
                xValues = [2024, 2023];
                yValues = [2531.01, 2409.22];
                formatter = new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            <?php } ?>

            <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
                xValues = [2024, 2023, 2022, 2021];
                yValues = [45.37, 49.32, 35.17, 36.09];
                formatter = new Intl.NumberFormat('de-DE', {
                    style: 'currency',
                    currency: 'EUR',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            <?php } ?>

            if ($('#ytdRevPar').length > 0) {
                var ctxYtdRevPar = document.querySelector('#ytdRevPar').getContext('2d');
            }

            if ($('#ytdRevPar1').length > 0) {
                var ctxYtdRevPar1 = document.querySelector('#ytdRevPar1').getContext('2d');
            }

            const getDynamicMinMax = (values) => {
                const min = Math.min(...values);
                const max = Math.max(...values);
                const dynamicMinValue = Math.floor(min * 0.95); // Adjusted dynamic min value
                const adjustedMax = Math.ceil(max * 1.05); // Adjusted dynamic max value
                return { dynamicMinValue, adjustedMax };
            };

            const { dynamicMinValue, adjustedMax } = getDynamicMinMax(yValues);

            // Custom formatter to add a space between the currency symbol and the number
            function customCurrencyFormatter(value, formatter) {
                const formattedValue = formatter.format(value);
                const parts = formatter.formatToParts(value);
                const currencySymbol = parts.find(part => part.type === 'currency').value;
                return formattedValue.replace(currencySymbol, currencySymbol + ' ');
            }

            let data = {
                type: 'bar',
                data: {
                    labels: xValues,
                    datasets: [{
                        label: 'Year-to-Date RevPAR',
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
                                    return `${label}: ${customCurrencyFormatter(value, formatter)}`; // Use custom formatter for tooltips
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
                                    return customCurrencyFormatter(value, formatter); // Use custom formatter
                                }
                            }
                        }
                    }
                },
                plugins: [customLegendPlugin] // Add custom legend plugin
            };

            let ytdRevPar = new Chart(ctxYtdRevPar, data);
            let ytdRevPar1 = new Chart(ctxYtdRevPar1, data);
        })();

        // Year-to-Date Room Revenue Chart - Page 2

        (function() {
            // Define variables with default values
            var xValues = [];
            var yValues = [];
            var formatter;

            // Assign values based on the hotel_code
            <?php if(get_field('hotel_code') == 'LUPOS'){ ?>
                xValues = [2024, 2023, 2022, 2021, 2020, 2019];
                yValues = [9382.90, 11278.00, 11854.00, 0, 0, 6064.00];
                formatter = new Intl.NumberFormat('de-DE', {
                    style: 'currency',
                    currency: 'EUR',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            <?php } ?>

            <?php if(get_field('hotel_code') == 'THANA'){ ?>
                xValues = [2024, 2023];
                yValues = [23581416.86, 22405764.36];
                formatter = new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            <?php } ?>

            <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
                xValues = [2024, 2023, 2022, 2021];
                yValues = [189593.00, 201219.74, 143476.74, 147258.42];
                formatter = new Intl.NumberFormat('de-DE', {
                    style: 'currency',
                    currency: 'EUR',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            <?php } ?>

            if ($('#ytdRoomRev').length > 0) {
                var ctxYtdRoomRev = document.querySelector('#ytdRoomRev').getContext('2d');
            }

            if ($('#ytdRoomRev1').length > 0) {
                var ctxYtdRoomRev1 = document.querySelector('#ytdRoomRev1').getContext('2d');
            }

            const getDynamicMinMax = (values) => {
                const min = Math.min(...values);
                const max = Math.max(...values);
                const dynamicMinValue = Math.floor(min * 0.95); // Adjusted dynamic min value
                const adjustedMax = Math.ceil(max * 1.05); // Adjusted dynamic max value
                return { dynamicMinValue, adjustedMax };
            };

            const { dynamicMinValue, adjustedMax } = getDynamicMinMax(yValues);

            // Custom formatter to add a space between the currency symbol and the number
            function customCurrencyFormatter(value, formatter) {
                const formattedValue = formatter.format(value);
                const parts = formatter.formatToParts(value);
                const currencySymbol = parts.find(part => part.type === 'currency').value;
                return formattedValue.replace(currencySymbol, currencySymbol + ' ');
            }

            let data = {
                type: 'bar',
                data: {
                    labels: xValues,
                    datasets: [{
                        label: 'Year-to-Date Room Revenue',
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
                                    return `${label}: ${customCurrencyFormatter(value, formatter)}`; // Use custom formatter for tooltips
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
                                    return customCurrencyFormatter(value, formatter); // Use custom formatter
                                }
                            }
                        }
                    }
                },
                plugins: [customLegendPlugin] // Add custom legend plugin
            };

            let ytdRoomRev = new Chart(ctxYtdRoomRev, data);
            let ytdRoomRev1 = new Chart(ctxYtdRoomRev1, data);
        })();

        // 
        // THIS STARTS PAGE 3
        // 

        // Monthly Production per Channel - Page 3

            (function() {
        // Define variables with default values
        var monthlyValues = [];
        var dataHotelDirect = [];
        var dataHotelWebDirect = [];
        var dataAgoda = [];
        var dataBooking = [];
        var dataCtrip = [];
        var dataExpedia = [];
        var dataHotelbeds = [];

        // Assign values based on the hotel_code
        <?php if(get_field('hotel_code') == 'THANA'){ ?>
            monthlyValues = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            dataHotelDirect = [638, 874, 569, 512, 196, 43, 59, 26, 12, 31, 65, 175];
            dataHotelWebDirect = [134, 195, 110, 102, 33, 4, 15, 10, 0, 0, 0, 5];
            dataAgoda = [40, 35, 11, 21, 8, 0, 0, 0, 0, 0, 0, 0];
            dataBooking = [234, 136, 96, 124, 84, 17, 38, 17, 0, 2, 30, 134];
            dataCtrip = [5, 22, 9, 53, 7, 0, 5, 0, 0, 0, 0, 0];
            dataExpedia = [78, 74, 50, 67, 6, 5, 11, 6, 0, 1, 1, 5];
            dataHotelbeds = [25, 6, 7, 2, 0, 0, 0, 0, 20, 0, 0, 0];
        <?php } ?>

        <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
            monthlyValues = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            dataHotelDirect = [142, 97, 171, 254, 220, 166, 51, 99, 90, 115, 2, 9];
            dataHotelWebDirect = [18, 36, 45, 57, 61, 15, 0, 11, 10, 0, 0, 4];
            dataAgoda = [];
            dataBooking = [124, 150, 201, 222, 255, 153, 90, 42, 25, 0, 0, 11];
            dataCtrip = [];
            dataExpedia = [15, 11, 8, 18, 24, 9, 19, 6, 1, 0, 0, 0];
            dataHotelbeds = [];
        <?php } ?>

        if($('#monthlyChannelProduction').length > 0) {
            var ctxMonthlyChannel = document.querySelector('#monthlyChannelProduction').getContext('2d');
        }

        const getDynamicMinMax = (values) => {
            const min = Math.min(...values);
            const max = Math.max(...values);
            const dynamicMinValue = Math.floor(min * 0.9); // Example dynamic min value
            const adjustedMax = Math.ceil(max * 1.1); // Example dynamic max value
            return { dynamicMinValue, adjustedMax };
        };

        // Create an array of dataset objects
        const datasets = [
            {
                label: 'Hotel Direct',
                data: dataHotelDirect,
                backgroundColor: '#25475C'
            },
            {
                label: 'Hotelweb Direct',
                data: dataHotelWebDirect,
                backgroundColor: '#2E7C8A'
            },
            {
                label: 'Agoda',
                data: dataAgoda,
                backgroundColor: '#5EC4C8'
            },
            {
                label: 'Booking.com',
                data: dataBooking,
                backgroundColor: '#92D1D4'
            },
            {
                label: 'Ctrip/Trip.com',
                data: dataCtrip,
                backgroundColor: '#AAA'
            },
            {
                label: 'Expedia',
                data: dataExpedia,
                backgroundColor: '#BFCDD0'
            },
            {
                label: 'Hotelbeds',
                data: dataHotelbeds,
                backgroundColor: '#CCC'
            }
        ];

        // Filter out datasets with no data
        const filteredDatasets = datasets.filter(dataset => dataset.data.some(value => value !== 0));

        const allValues = filteredDatasets.flatMap(dataset => dataset.data);

        const { dynamicMinValue, adjustedMax } = getDynamicMinMax(allValues);

        let data = {
            type: 'bar',
            data: {
                labels: monthlyValues,
                datasets: filteredDatasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 1000,
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            color: '#000' // Legend text color
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.raw; // Show the yValues on the tooltip
                            }
                        }
                    },
                },
                scales: {
                    x: {
                        stacked: false,
                    },
                    y: {
                        beginAtZero: true,
                        stacked: false,
                        min: dynamicMinValue,
                        max: adjustedMax
                    }
                }
            }
        };

        var monthlyChannelProduction = new Chart(ctxMonthlyChannel, data);
    })();

    // Monthly Rooms Sold per Channel 1 - Page 3

    (function() {
        // Define variables with default values
        var channelLabels = [];
        var data2021 = [];
        var data2022 = [];
        var data2023 = [];
        var data2024 = [];

        // Assign values based on the hotel_code
        <?php if(get_field('hotel_code') == 'THANA'){ ?>
            channelLabels = ['Hotel Direct', 'Hotelweb Direct', 'Agoda', 'Booking.com', 'Ctrip/Trip.com', 'Expedia'];
            data2023 = [866, 107, 61, 112, 4, 31];
            data2024 = [512, 102, 21, 124, 53, 67];
        <?php } ?>

        <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
            channelLabels = ['Hotel Direct', 'Hotelweb Direct', 'Booking.com', 'Expedia'];
            data2021 = [186, 166, 153, 6];
            data2022 = [131, 55, 285, 8];
            data2023 = [201, 54, 317, 25];
            data2024 = [254, 57, 222, 18];
        <?php } ?>

        if($('#monthlyRoomSoldChannel').length > 0) {
            var ctxRoomSoldChannel = document.querySelector('#monthlyRoomSoldChannel').getContext('2d');
        }

        if($('#monthlyRoomSoldChannel1').length > 0) {
            var ctxRoomSoldChannel1 = document.querySelector('#monthlyRoomSoldChannel1').getContext('2d');
        }

        const getDynamicMinMax = (values) => {
            const min = Math.min(...values);
            const max = Math.max(...values);
            const dynamicMinValue = Math.floor(min * 0.9); // Example dynamic min value
            const adjustedMax = Math.ceil(max * 1.1); // Example dynamic max value
            return { dynamicMinValue, adjustedMax };
        };

        // Create an array of dataset objects
        const datasets = [
            {
                label: '2021',
                data: data2021,
                backgroundColor: '#BFCDD0'
            },
            {
                label: '2022',
                data: data2022,
                backgroundColor: '#2E7C8A'
            },
            {
                label: '2023',
                data: data2023,
                backgroundColor: '#25475C'
            },
            {
                label: '2024',
                data: data2024,
                backgroundColor: '#5EC4C8'
            }
        ];

        // Filter out datasets with no data
        const filteredDatasets = datasets.filter(dataset => dataset.data.some(value => value !== 0));

        const allValues = filteredDatasets.flatMap(dataset => dataset.data);

        if (allValues.length > 0) {
            const { dynamicMinValue, adjustedMax } = getDynamicMinMax(allValues);

            let data = {
                type: 'bar',
                data: {
                    labels: channelLabels,
                    datasets: filteredDatasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1000,
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                color: '#000' // Legend text color
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.raw; // Show the yValues on the tooltip
                                }
                            }
                        },
                    },
                    scales: {
                        x: {
                            stacked: false,
                        },
                        y: {
                            beginAtZero: true,
                            stacked: false,
                            min: dynamicMinValue,
                            max: adjustedMax
                        }
                    }
                }
            };

            var monthlyRoomSoldChannel = new Chart(ctxRoomSoldChannel, data);
            var monthlyRoomSoldChannel1 = new Chart(ctxRoomSoldChannel1, data);
        } else {
            console.error('No data available to plot');
        }
    })();

    // Monthly ADR per Channel - Page 3

    (function() {
        // Define variables with default values
        var channelLabels = [];
        var data2021 = [];
        var data2022 = [];
        var data2023 = [];
        var data2024 = [];
        var formatter;

        // Assign values based on the hotel_code
        <?php if(get_field('hotel_code') == 'THANA'){ ?>
            channelLabels = ['Hotel Direct', 'Hotelweb Direct', 'Agoda', 'Booking.com', 'Ctrip/Trip.com', 'Expedia'];
            data2023 = [5925.10, 4447.64, 5053.18, 6438.85, 3916.91, 7730.84];
            data2024 = [5589.18, 6049.79, 4214.65, 6217.26, 3687.06, 6738.44];
            
            // Define a number formatter for Thai Baht
            formatter = new Intl.NumberFormat('th-TH', {
                style: 'currency',
                currency: 'THB',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        <?php } ?>

        <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
            channelLabels = ['Hotel Direct', 'Hotelweb Direct', 'Booking.com', 'Expedia'];
            data2021 = [78.46, 153.30, 124.91, 197.33];
            data2022 = [67.14, 146.40, 110.21, 116.75];
            data2023 = [80.38, 123.46, 124.64, 120.80];
            data2024 = [92.66, 147.95, 131.30, 113.78];
            
            // Define a number formatter for Euros
            formatter = new Intl.NumberFormat('de-DE', {
                style: 'currency',
                currency: 'EUR',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        <?php } ?>

        if($('#monthlyAdrChannel').length > 0) {
            var ctxAdrChannel = document.querySelector('#monthlyAdrChannel').getContext('2d');
        }

        const getDynamicMinMax = (values) => {
            const min = Math.min(...values);
            const max = Math.max(...values);
            const dynamicMinValue = Math.floor(min * 0.9); // Example dynamic min value
            const adjustedMax = Math.ceil(max * 1.1); // Example dynamic max value
            return { dynamicMinValue, adjustedMax };
        };

        // Create an array of dataset objects
        const datasets = [
            {
                label: '2021',
                data: data2021,
                backgroundColor: '#BFCDD0'
            },
            {
                label: '2022',
                data: data2022,
                backgroundColor: '#2E7C8A'
            },
            {
                label: '2023',
                data: data2023,
                backgroundColor: '#25475C'
            },
            {
                label: '2024',
                data: data2024,
                backgroundColor: '#5EC4C8'
            }
        ];

        // Filter out datasets with no data
        const filteredDatasets = datasets.filter(dataset => dataset.data.some(value => value !== 0));

        const allValues = filteredDatasets.flatMap(dataset => dataset.data);

        if (allValues.length > 0) {
            const { dynamicMinValue, adjustedMax } = getDynamicMinMax(allValues);

            let data = {
                type: 'bar',
                data: {
                    labels: channelLabels,
                    datasets: filteredDatasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1000,
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                color: '#000' // Legend text color
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    // Use the formatter if it is defined
                                    if (formatter) {
                                        return formatter.format(tooltipItem.raw);
                                    }
                                    return tooltipItem.raw; // Show the yValues on the tooltip
                                }
                            }
                        },
                    },
                    scales: {
                        x: {
                            stacked: false,
                        },
                        y: {
                            beginAtZero: true,
                            stacked: false,
                            min: dynamicMinValue,
                            max: adjustedMax,
                            ticks: {
                                callback: function(value) {
                                    // Use the formatter if it is defined
                                    if (formatter) {
                                        return formatter.format(value);
                                    }
                                    return value;
                                }
                            }
                        }
                    }
                }
            };

            var monthlyAdrChannel = new Chart(ctxAdrChannel, data);
        } else {
            console.error('No data available to plot');
        }
    })();

    // Monthly Revenue per Channel - Page 3

    (function() {
        // Define variables with default values
        var channelLabels = [];
        var data2021 = [];
        var data2022 = [];
        var data2023 = [];
        var data2024 = [];
        var formatter;

        // Assign values based on the hotel_code
        <?php if(get_field('hotel_code') == 'THANA'){ ?>
            channelLabels = ['Hotel Direct', 'Hotelweb Direct', 'Agoda', 'Booking.com', 'Ctrip/Trip.com', 'Expedia'];
            data2023 = [5131138.64, 475897.27, 308243.94, 721151.16, 15667.63, 239656.03];
            data2024 = [2861661.05, 617078.43, 88507.57, 770939.72, 195414.25, 451475.22];
            
            // Define a number formatter for Thai Baht
            formatter = new Intl.NumberFormat('th-TH', {
                style: 'currency',
                currency: 'THB',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        <?php } ?>

        <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
            channelLabels = ['Hotel Direct', 'Hotelweb Direct', 'Booking.com', 'Expedia'];
            data2021 = [14594.10, 25447, 19111.30, 1184];
            data2022 = [8794.70, 8052, 31409.50, 934];
            data2023 = [16156.34, 6667, 39510.10, 3020];
            data2024 = [23535.90, 8433, 29148.60, 2048];
            
            // Define a number formatter for Euros
            formatter = new Intl.NumberFormat('de-DE', {
                style: 'currency',
                currency: 'EUR',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        <?php } ?>

        if($('#monthlyRevenueChannel').length > 0) {
            var ctxRevenueChannel = document.querySelector('#monthlyRevenueChannel').getContext('2d');
        }

        const getDynamicMinMax = (values) => {
            const min = Math.min(...values);
            const max = Math.max(...values);
            const dynamicMinValue = Math.floor(min * 0.9); // Example dynamic min value
            const adjustedMax = Math.ceil(max * 1.1); // Example dynamic max value
            return { dynamicMinValue, adjustedMax };
        };

        // Create an array of dataset objects
        const datasets = [
            {
                label: '2021',
                data: data2021,
                backgroundColor: '#BFCDD0'
            },
            {
                label: '2022',
                data: data2022,
                backgroundColor: '#2E7C8A'
            },
            {
                label: '2023',
                data: data2023,
                backgroundColor: '#25475C'
            },
            {
                label: '2024',
                data: data2024,
                backgroundColor: '#5EC4C8'
            }
        ];

        // Filter out datasets with no data
        const filteredDatasets = datasets.filter(dataset => dataset.data.some(value => value !== 0));

        const allValues = filteredDatasets.flatMap(dataset => dataset.data);

        if (allValues.length > 0) {
            const { dynamicMinValue, adjustedMax } = getDynamicMinMax(allValues);

            let data = {
                type: 'bar',
                data: {
                    labels: channelLabels,
                    datasets: filteredDatasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1000,
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                color: '#000' // Legend text color
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    // Use the appropriate formatter if it is defined
                                    if (formatter) {
                                        return formatter.format(tooltipItem.raw);
                                    }
                                    return tooltipItem.raw.toLocaleString(); // Show the yValues with comma separators on the tooltip
                                }
                            }
                        },
                    },
                    scales: {
                        x: {
                            stacked: false,
                        },
                        y: {
                            beginAtZero: true,
                            stacked: false,
                            min: dynamicMinValue,
                            max: adjustedMax,
                            ticks: {
                                callback: function(value) {
                                    // Use the appropriate formatter if it is defined
                                    if (formatter) {
                                        return formatter.format(value);
                                    }
                                    return value.toLocaleString(); // Format y-axis values with comma separators
                                }
                            }
                        }
                    }
                }
            };

            var monthlyRevenueChannel = new Chart(ctxRevenueChannel, data);
        } else {
            console.error('No data available to plot');
        }
    })();

    // Monthly Percentage Rooms Sold per Channel Type 1 - Page 3

    (function() {
        // Define variables with default values
        var channelLabels = [];
        var data2021 = [];
        var data2022 = [];
        var data2023 = [];
        var data2024 = [];

        // Assign values based on the hotel_code
        <?php if(get_field('hotel_code') == 'THANA'){ ?>
            channelLabels = ['Hotel Direct', 'Hotelweb Direct', 'Agoda', 'Booking.com', 'Ctrip/Trip.com', 'Expedia'];
            data2023 = [73, 9, 5, 9, 0, 3];
            data2024 = [58, 12, 2, 14, 6, 8];
        <?php } ?>

        <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
            channelLabels = ['Hotel Direct', 'Hotelweb Direct', 'Booking.com', 'Expedia'];
            data2021 = [36, 32, 30, 1];
            data2022 = [25, 11, 55, 2];
            data2023 = [31, 8, 49, 4];
            data2024 = [43, 10, 37, 3];
        <?php } ?>

        if($('#monthlyPerChannelType1').length > 0) {
            var ctxPerChannelType1 = document.querySelector('#monthlyPerChannelType1').getContext('2d');
        }

        const getDynamicMinMax = (values) => {
            const min = Math.min(...values);
            const max = Math.max(...values);
            const dynamicMinValue = Math.floor(min * 0.9); // Example dynamic min value
            const adjustedMax = Math.ceil(max * 1.1); // Example dynamic max value
            return { dynamicMinValue, adjustedMax };
        };

        // Create an array of dataset objects
        const datasets = [
            {
                label: '2021',
                data: data2021,
                backgroundColor: '#BFCDD0'
            },
            {
                label: '2022',
                data: data2022,
                backgroundColor: '#2E7C8A'
            },
            {
                label: '2023',
                data: data2023,
                backgroundColor: '#25475C'
            },
            {
                label: '2024',
                data: data2024,
                backgroundColor: '#5EC4C8'
            }
        ];

        // Filter out datasets with no data
        const filteredDatasets = datasets.filter(dataset => dataset.data.some(value => value !== 0));

        const allValues = filteredDatasets.flatMap(dataset => dataset.data);

        if (allValues.length > 0) {
            const { dynamicMinValue, adjustedMax } = getDynamicMinMax(allValues);

            let data = {
                type: 'bar',
                data: {
                    labels: channelLabels,
                    datasets: filteredDatasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1000,
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                color: '#000' // Legend text color
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.raw + '%'; // Show the yValues with percentage sign on the tooltip
                                }
                            }
                        },
                    },
                    scales: {
                        x: {
                            stacked: false,
                        },
                        y: {
                            beginAtZero: true,
                            stacked: false,
                            min: dynamicMinValue,
                            max: adjustedMax,
                            ticks: {
                                callback: function(value) {
                                    return value + '%'; // Format y-axis values with percentage sign
                                }
                            }
                        }
                    }
                }
            };

            var monthlyPerChannelType1 = new Chart(ctxPerChannelType1, data);
        } else {
            console.error('No data available to plot');
        }
    })();


    // Monthly Percentage Rooms Sold per Channel Type 2 - Page 3

    (function() {
        // Define variables with default values
        var channelLabels = [];
        var dataHotelDirect = [];
        var dataHotelWebDirect = [];
        var dataBooking = [];
        var dataExpedia = [];
        var dataOther = [];

        // Assign values based on the hotel_code
        <?php if(get_field('hotel_code') == 'THANA'){ ?>
            channelLabels = ['2024', '2023'];
            dataHotelDirect = [58, 73];
            dataHotelWebDirect = [12, 9];
            dataOther = [31, 18];
        <?php } ?>

        <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
            channelLabels = ['2024', '2023', '2022', '2021'];
            dataHotelDirect = [43, 31, 25, 36];
            dataHotelWebDirect = [10, 8, 11, 32];
            dataBooking = [37, 49, 55, 30];
            dataExpedia = [3, 4, 2, 1];
            dataOther = [7, 9, 8, 1];
        <?php } ?>

        if($('#monthlyPerChannelType2').length > 0) {
            var ctxPerChannelType2 = document.querySelector('#monthlyPerChannelType2').getContext('2d');
        }

        const datasets = [];

        // Add datasets based on the hotel code
        <?php if(get_field('hotel_code') == 'THANA'){ ?>
            datasets.push(
                {
                    label: 'Hotel Direct',
                    data: dataHotelDirect,
                    backgroundColor: '#25475C'
                },
                {
                    label: 'Hotelweb Direct',
                    data: dataHotelWebDirect,
                    backgroundColor: '#2E7C8A'
                },
                {
                    label: 'Other',
                    data: dataOther,
                    backgroundColor: '#BFCDD0'
                }
            );
        <?php } ?>

        <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
            datasets.push(
                {
                    label: 'Hotel Direct',
                    data: dataHotelDirect,
                    backgroundColor: '#25475C'
                },
                {
                    label: 'Hotelweb Direct',
                    data: dataHotelWebDirect,
                    backgroundColor: '#2E7C8A'
                },
                {
                    label: 'Booking.com',
                    data: dataBooking,
                    backgroundColor: '#5EC4C8'
                },
                {
                    label: 'Expedia',
                    data: dataExpedia,
                    backgroundColor: '#AAA'
                },
                {
                    label: 'Other',
                    data: dataOther,
                    backgroundColor: '#BFCDD0'
                }
            );
        <?php } ?>

        let data = {
            type: 'bar',
            data: {
                labels: channelLabels,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 1000,
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            color: '#000' // Legend text color
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.raw + '%'; // Show the yValues with percentage sign on the tooltip
                            }
                        }
                    },
                    datalabels: {
                        display: true,
                        color: 'white',
                        formatter: function(value, context) {
                            return value + '%';
                        },
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        beginAtZero: true,
                        stacked: true,
                        max: 100, // Set max value to 100 for percentage
                        ticks: {
                            callback: function(value) {
                                return value + '%'; // Format y-axis values with percentage sign
                            }
                        }
                    }
                }
            },
            plugins: [ChartDataLabels] // Enable the datalabels plugin
        };

        var monthlyPerChannelType2 = new Chart(ctxPerChannelType2, data);
    })();

    // Monthly Rooms Sold per Channel - Page 3

    (function() {
        // Define variables with default values
        var channelLabels = [];
        var data2024 = [];

        // Assign values based on the hotel_code
        <?php if(get_field('hotel_code') == 'THANA'){ ?>
            channelLabels = ['Hotel Direct', 'Hotelweb Direct', 'Agoda', 'Booking.com', 'Ctrip/Trip.com', 'Expedia', 'Airbnb', 'Hotelbeds', 'Tiket', 'Traveloka'];
            data2024 = [58, 12, 2, 0, 6, 8, 0, 0, 0, 0];
        <?php } ?>

        <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
            channelLabels = ['Hotel Direct', 'Hotelweb Direct', 'Booking.com', 'Expedia', 'Other'];
            data2024 = [43, 10, 37, 3, 7];
        <?php } ?>

        if($('#monthlyPercentageRoomChannel').length > 0) {
            var ctxPercentageRoomChannel = document.querySelector('#monthlyPercentageRoomChannel').getContext('2d');
        }

        // Filter out 0% values and corresponding labels
        const filteredLabels = [];
        const filteredData = [];
        for (let i = 0; i < data2024.length; i++) {
            if (data2024[i] > 0) {
                filteredLabels.push(channelLabels[i]);
                filteredData.push(data2024[i]);
            }
        }

        // Create datasets based on the filtered data
        const datasets = [];
        <?php if(get_field('hotel_code') == 'THANA'){ ?>
            datasets.push({
                label: '2024',
                data: filteredData,
                backgroundColor: [
                    '#25475C', '#2E7C8A', '#5EC4C8', '#92D1D4', '#BFCDD0',
                    '#FF5733', '#C70039', '#900C3F', '#581845', '#DAF7A6'
                ].slice(0, filteredData.length),
                borderWidth: 0 // Remove borders
            });
        <?php } ?>

        <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
            datasets.push({
                label: '2024',
                data: filteredData,
                backgroundColor: ['#25475C', '#2E7C8A', '#5EC4C8', '#AAA', '#BFCDD0'].slice(0, filteredData.length),
                borderWidth: 0 // Remove borders
            });
        <?php } ?>

        let data = {
            type: 'pie', // Ensure the chart type is 'pie' for a full pie chart
            data: {
                labels: filteredLabels,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        top: 30,
                        bottom: 20 // Add padding to the bottom for the legend
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            color: '#000', // Legend text color
                            padding: 20 // Add padding to the legend labels
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + '%'; // Show the label and percentage on the tooltip
                            }
                        }
                    },
                    datalabels: {
                        formatter: function(value, context) {
                            return value + '%'; // Display percentage inside the pie slices
                        },
                        color: '#000',
                        align: 'end',
                        anchor: 'end',
                        offset: 10,
                        font: {
                            weight: 'bold'
                        },
                        clip: false
                    }
                }
            },
            plugins: [ChartDataLabels] // Enable the datalabels plugin
        };

        var monthlyPercentageRoomChannel = new Chart(ctxPercentageRoomChannel, data);
    })();


        //
        // THIS STARTS PAGE 4
        //

    // Yearly Rooms Sold per Channel 1 - Page 4

    (function() {
        // Define variables with default values
        var channelLabels = [];
        var data2023 = [];
        var data2024 = [];
        var data2021 = [];
        var data2022 = [];

        // Assign values based on the hotel_code
        <?php if(get_field('hotel_code') == 'THANA'){ ?>
            channelLabels = ['Hotel Direct', 'Hotelweb Direct', 'Agoda', 'Booking.com', 'Ctrip/Trip.com', 'Expedia'];
            data2023 = [2969, 520, 225, 593, 8, 136];
            data2024 = [2593, 541, 107, 590, 89, 269];
        <?php } ?>

        <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
            channelLabels = ['Hotel Direct', 'Hotelweb Direct', 'Booking.com', 'Expedia'];
            data2021 = [594, 367, 366, 28];
            data2022 = [514, 166, 709, 21];
            data2023 = [641, 214, 873, 60];
            data2024 = [664, 156, 697, 52];
        <?php } ?>

        if($('#ytdRoomSoldChannel').length > 0) {
            var ctxRoomSoldChannel = document.querySelector('#ytdRoomSoldChannel').getContext('2d');
        }

        const datasets = [];

        // Add datasets based on the hotel code
        <?php if(get_field('hotel_code') == 'THANA'){ ?>
            datasets.push(
                {
                    label: '2023',
                    data: data2023,
                    backgroundColor: '#25475C'
                },
                {
                    label: '2024',
                    data: data2024,
                    backgroundColor: '#5EC4C8'
                }
            );
        <?php } ?>

        <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
            datasets.push(
                {
                    label: '2021',
                    data: data2021,
                    backgroundColor: '#BFCDD0'
                },
                {
                    label: '2022',
                    data: data2022,
                    backgroundColor: '#2E7C8A'
                },
                {
                    label: '2023',
                    data: data2023,
                    backgroundColor: '#25475C'
                },
                {
                    label: '2024',
                    data: data2024,
                    backgroundColor: '#5EC4C8'
                }
            );
        <?php } ?>

        const allValues = datasets.flatMap(dataset => dataset.data);

        if (allValues.length > 0) {
            const { dynamicMinValue, adjustedMax } = getDynamicMinMax(allValues);

            let data = {
                type: 'bar',
                data: {
                    labels: channelLabels,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1000,
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                color: '#000' // Legend text color
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.raw; // Show the yValues on the tooltip
                                }
                            }
                        },
                    },
                    scales: {
                        x: {
                            stacked: false,
                        },
                        y: {
                            beginAtZero: true,
                            stacked: false,
                            min: dynamicMinValue,
                            max: adjustedMax
                        }
                    }
                }
            };

            var ytdRoomSoldChannel = new Chart(ctxRoomSoldChannel, data);
        } else {
            console.error('No data available to plot');
        }
    })();


    // Yearly ADR per Channel - Page 4

    (function() {
        // Define variables with default values
        var channelLabels = [];
        var data2023 = [];
        var data2024 = [];
        var data2021 = [];
        var data2022 = [];
        var formatter;

        // Assign values based on the hotel_code
        <?php if(get_field('hotel_code') == 'THANA'){ ?>
            channelLabels = ['Hotel Direct', 'Hotelweb Direct', 'Agoda', 'Booking.com', 'Ctrip/Trip.com', 'Expedia'];
            data2023 = [4690.32, 4768.96, 5658.61, 6274.02, 6458.53, 6913.96];
            data2024 = [5355.88, 5768.32, 7963.97, 6016.40, 3934.84, 5650.00];
            
            // Define a number formatter for Thai Baht
            formatter = new Intl.NumberFormat('th-TH', {
                style: 'currency',
                currency: 'THB',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        <?php } ?>

        <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
            channelLabels = ['Hotel Direct', 'Hotelweb Direct', 'Booking.com', 'Expedia'];
            data2021 = [76.64, 149.54, 116.28, 115.39];
            data2022 = [62.15, 141.89, 102.29, 109.57];
            data2023 = [77.64, 126.56, 111.40, 115.83];
            data2024 = [86.29, 144.62, 120.54, 114.04];
            
            // Define a number formatter for Euros
            formatter = new Intl.NumberFormat('de-DE', {
                style: 'currency',
                currency: 'EUR',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        <?php } ?>

        if($('#ytdAdrChannel').length > 0) {
            var ctxAdrChannel = document.querySelector('#ytdAdrChannel').getContext('2d');
        }

        const datasets = [];

        // Add datasets based on the hotel code
        <?php if(get_field('hotel_code') == 'THANA'){ ?>
            datasets.push(
                {
                    label: '2023',
                    data: data2023,
                    backgroundColor: '#25475C'
                },
                {
                    label: '2024',
                    data: data2024,
                    backgroundColor: '#5EC4C8'
                }
            );
        <?php } ?>

        <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
            datasets.push(
                {
                    label: '2021',
                    data: data2021,
                    backgroundColor: '#BFCDD0'
                },
                {
                    label: '2022',
                    data: data2022,
                    backgroundColor: '#2E7C8A'
                },
                {
                    label: '2023',
                    data: data2023,
                    backgroundColor: '#25475C' 
                },
                {
                    label: '2024',
                    data: data2024,
                    backgroundColor: '#5EC4C8'
                }
            );
        <?php } ?>

        const allValues = datasets.flatMap(dataset => dataset.data);

        if (allValues.length > 0) {
            const { dynamicMinValue, adjustedMax } = getDynamicMinMax(allValues);

            let data = {
                type: 'bar',
                data: {
                    labels: channelLabels,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1000,
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                color: '#000' // Legend text color
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    // Use the appropriate formatter if it is defined
                                    if (formatter) {
                                        return formatter.format(tooltipItem.raw);
                                    }
                                    return tooltipItem.raw.toLocaleString(); // Show the yValues with comma separators on the tooltip
                                }
                            }
                        },
                    },
                    scales: {
                        x: {
                            stacked: false,
                        },
                        y: {
                            beginAtZero: true,
                            stacked: false,
                            min: dynamicMinValue,
                            max: adjustedMax,
                            ticks: {
                                callback: function(value) {
                                    // Use the appropriate formatter if it is defined
                                    if (formatter) {
                                        return formatter.format(value);
                                    }
                                    return value.toLocaleString(); // Format y-axis values with comma separators
                                }
                            }
                        }
                    }
                }
            };

            var ytdAdrChannel = new Chart(ctxAdrChannel, data);
        } else {
            console.error('No data available to plot');
        }
    })();

    // Yearly Revenue per Channel - Page 4

    (function() {
        // Define variables with default values
        var channelLabels = [];
        var data2023 = [];
        var data2024 = [];
        var data2021 = [];
        var data2022 = [];
        var formatter;

        // Assign values based on the hotel_code
        <?php if(get_field('hotel_code') == 'THANA'){ ?>
            channelLabels = ['Hotel Direct', 'Hotelweb Direct', 'Agoda', 'Booking.com', 'Ctrip/Trip.com', 'Expedia'];
            data2023 = [13925572.92, 2479857.48, 1273186.84, 3720492.92, 51668.24, 940297.96];
            data2024 = [13887787.38, 3120663.57, 852144.79, 3549677.83, 350200.66, 1519850.19];
            
            // Define a number formatter for Thai Baht
            formatter = new Intl.NumberFormat('th-TH', {
                style: 'currency',
                currency: 'THB',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        <?php } ?>

        <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
            channelLabels = ['Hotel Direct', 'Hotelweb Direct', 'Booking.com', 'Expedia'];
            data2021 = [45522.82, 54883.00, 42557.00, 3321.00];
            data2022 = [31946.94 , 23554.00, 72526.20, 2301.00];
            data2023 = [49768.67, 27084.00, 97251.67, 6950.00];
            data2024 = [57295.29, 22561.00, 84015.25, 5930.00];
            
            // Define a number formatter for Euros
            formatter = new Intl.NumberFormat('de-DE', {
                style: 'currency',
                currency: 'EUR',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        <?php } ?>

        if($('#ytdRevenueChannel').length > 0) {
            var ctxRevenueChannel = document.querySelector('#ytdRevenueChannel').getContext('2d');
        }

        const datasets = [];

        // Add datasets based on the hotel code
        <?php if(get_field('hotel_code') == 'THANA'){ ?>
            datasets.push(
                {
                    label: '2023',
                    data: data2023,
                    backgroundColor: '#25475C'
                },
                {
                    label: '2024',
                    data: data2024,
                    backgroundColor: '#5EC4C8'
                }
            );
        <?php } ?>

        <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
            datasets.push(
                {
                    label: '2021',
                    data: data2021,
                    backgroundColor: '#BFCDD0'
                },
                {
                    label: '2022',
                    data: data2022,
                    backgroundColor: '#2E7C8A'
                },
                {
                    label: '2023',
                    data: data2023,
                    backgroundColor: '#25475C'
                },
                {
                    label: '2024',
                    data: data2024,
                    backgroundColor: '#5EC4C8'
                }
            );
        <?php } ?>

        const allValues = datasets.flatMap(dataset => dataset.data);

        if (allValues.length > 0) {
            const { dynamicMinValue, adjustedMax } = getDynamicMinMax(allValues);

            let data = {
                type: 'bar',
                data: {
                    labels: channelLabels,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1000,
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                color: '#000' // Legend text color
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    // Use the appropriate formatter if it is defined
                                    if (formatter) {
                                        return formatter.format(tooltipItem.raw);
                                    }
                                    return tooltipItem.raw.toLocaleString(); // Show the yValues with comma separators on the tooltip
                                }
                            }
                        },
                    },
                    scales: {
                        x: {
                            stacked: false,
                        },
                        y: {
                            beginAtZero: true,
                            stacked: false,
                            min: dynamicMinValue,
                            max: adjustedMax,
                            ticks: {
                                callback: function(value) {
                                    // Use the appropriate formatter if it is defined
                                    if (formatter) {
                                        return formatter.format(value);
                                    }
                                    return value.toLocaleString(); // Format y-axis values with comma separators
                                }
                            }
                        }
                    }
                }
            };

            var ytdRevenueChannel = new Chart(ctxRevenueChannel, data);
        } else {
            console.error('No data available to plot');
        }
    })();


    // Monthly Percentage Rooms Sold per Channel Type 1 - Page 4

    (function() {
        // Define variables with default values
        var channelLabels = [];
        var data2023 = [];
        var data2024 = [];
        var data2021 = [];
        var data2022 = [];

        // Assign values based on the hotel_code
        <?php if(get_field('hotel_code') == 'THANA'){ ?>
            channelLabels = ['Hotel Direct', 'Hotelweb Direct', 'Agoda', 'Booking.com', 'Ctrip/Trip.com', 'Expedia'];
            data2023 = [5, 10, 3, 15, 2, 6];
            data2024 = [60, 12, 8, 20, 10, 15];
        <?php } ?>

        <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
            channelLabels = ['Hotel Direct', 'Hotelweb Direct', 'Booking.com', 'Expedia'];
            data2021 = [44, 27, 27, 2];
            data2022 = [34, 11, 46, 1];
            data2023 = [33, 11, 45, 3];
            data2024 = [39, 9, 41, 3];
        <?php } ?>

        if($('#ytdPerChannelType1').length > 0) {
            var ctxPerChannelType1 = document.querySelector('#ytdPerChannelType1').getContext('2d');
        }

        const datasets = [];

        // Add datasets based on the hotel code
        <?php if(get_field('hotel_code') == 'THANA'){ ?>
            datasets.push(
                {
                    label: '2023',
                    data: data2023,
                    backgroundColor: '#25475C'
                },
                {
                    label: '2024',
                    data: data2024,
                    backgroundColor: '#5EC4C8'
                }
            );
        <?php } ?>

        <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
            datasets.push(
                {
                    label: '2021',
                    data: data2021,
                    backgroundColor: '#BFCDD0'
                },
                {
                    label: '2022',
                    data: data2022,
                    backgroundColor: '#2E7C8A'
                },
                {
                    label: '2023',
                    data: data2023,
                    backgroundColor: '#25475C'
                },
                {
                    label: '2024',
                    data: data2024,
                    backgroundColor: '#5EC4C8'
                }
            );
        <?php } ?>

        const allValues = datasets.flatMap(dataset => dataset.data);

        if (allValues.length > 0) {
            const { dynamicMinValue, adjustedMax } = getDynamicMinMax(allValues);

            let data = {
                type: 'bar',
                data: {
                    labels: channelLabels,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1000,
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                color: '#000' // Legend text color
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.raw + '%'; // Show the yValues with percentage sign on the tooltip
                                }
                            }
                        },
                    },
                    scales: {
                        x: {
                            stacked: false,
                        },
                        y: {
                            beginAtZero: true,
                            stacked: false,
                            min: dynamicMinValue,
                            max: adjustedMax,
                            ticks: {
                                callback: function(value) {
                                    return value + '%'; // Format y-axis values with percentage sign
                                }
                            }
                        }
                    }
                }
            };

            var ytdPerChannelType1 = new Chart(ctxPerChannelType1, data);
        } else {
            console.error('No data available to plot');
        }
    })();


    // Yearly Percentage Rooms Sold per Channel Type 2 - Page 4

    (function() {
        // Define variables with default values
        var channelLabels = [];
        var dataHotelDirect = [];
        var dataHotelWebDirect = [];
        var dataOther = [];
        var dataBooking = [];
        var dataExpedia = [];
        var data2024 = [];
        
        // Assign values based on the hotel_code
        <?php if(get_field('hotel_code') == 'THANA'){ ?>
            channelLabels = ['2024', '2023'];
            dataHotelDirect = [61, 67];
            dataHotelWebDirect = [13, 12];
            dataOther = [26, 22];
        <?php } ?>

        <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
            channelLabels = ['2024', '2023', '2022', '2021'];
            dataHotelDirect = [39, 33, 34, 44];
            dataHotelWebDirect = [9, 11, 11, 27];
            dataBooking = [41, 45, 46, 27];
            dataExpedia = [3, 3, 1, 2];
            dataOther = [8, 8, 8, 0];
        <?php } ?>

        if($('#ytdPerChannelType2').length > 0) {
            var ctxPerChannelType2 = document.querySelector('#ytdPerChannelType2').getContext('2d');
        }

        const datasets = [];

        // Add datasets based on the hotel code
        <?php if(get_field('hotel_code') == 'THANA'){ ?>
            datasets.push(
                {
                    label: 'Hotel Direct',
                    data: dataHotelDirect,
                    backgroundColor: '#25475C'
                },
                {
                    label: 'Hotelweb Direct',
                    data: dataHotelWebDirect,
                    backgroundColor: '#2E7C8A'
                },
                {
                    label: 'Other',
                    data: dataOther,
                    backgroundColor: '#BFCDD0'
                }
            );
        <?php } ?>

        <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
            datasets.push(
                {
                    label: 'Hotel Direct',
                    data: dataHotelDirect,
                    backgroundColor: '#25475C'
                },
                {
                    label: 'Hotelweb Direct',
                    data: dataHotelWebDirect,
                    backgroundColor: '#2E7C8A'
                },
                {
                    label: 'Booking.com',
                    data: dataBooking,
                    backgroundColor: '#5EC4C8'
                },
                {
                    label: 'Expedia',
                    data: dataExpedia,
                    backgroundColor: '#92D1D4'
                },
                {
                    label: 'Other',
                    data: dataOther,
                    backgroundColor: '#BFCDD0'
                }
            );
        <?php } ?>

        let data = {
            type: 'bar',
            data: {
                labels: channelLabels,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 1000,
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            color: '#000' // Legend text color
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.raw + '%'; // Show the yValues with percentage sign on the tooltip
                            }
                        }
                    },
                    datalabels: {
                        display: true,
                        color: 'white',
                        formatter: function(value, context) {
                            return value + '%';
                        },
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        beginAtZero: true,
                        stacked: true,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%'; // Format y-axis values with percentage sign
                            }
                        }
                    }
                }
            },
            plugins: [ChartDataLabels] // Enable the datalabels plugin
        };

        var ytdPerChannelType2 = new Chart(ctxPerChannelType2, data);
    })();

    // Rooms Sold per Channel - Page 4

    (function() {
        // Define variables with default values
        var channelLabels = [];
        var data2024 = [];

        // Assign values based on the hotel_code
        <?php if(get_field('hotel_code') == 'THANA'){ ?>
            channelLabels = ['Hotel Direct', 'Hotelweb Direct', 'Agoda', 'Booking.com', 'Ctrip/Trip.com', 'Expedia', 'Airbnb', 'Hotelbeds', 'Tiket', 'Traveloka', 'Wholesalers/Agents', 'Corporate', 'Group'];
            data2024 = [61, 13, 2, 14, 2, 6, 0, 6, 1, 0, 0, 0, 0];
        <?php } ?>

        <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
            channelLabels = ['Hotel Direct', 'Hotelweb Direct', 'Booking.com', 'Expedia', 'Other'];
            data2024 = [39, 9, 41, 3, 8];
        <?php } ?>

        if($('#ytdPercentageRoomChannel').length > 0) {
            var ctxPercentageRoomChannel = document.querySelector('#ytdPercentageRoomChannel').getContext('2d');
        }

        // Filter out 0% values and corresponding labels
        const filteredLabels = [];
        const filteredData = [];
        for (let i = 0; i < data2024.length; i++) {
            if (data2024[i] > 0) {
                filteredLabels.push(channelLabels[i]);
                filteredData.push(data2024[i]);
            }
        }

        // Create datasets based on the filtered data
        const datasets = [];
        <?php if(get_field('hotel_code') == 'THANA'){ ?>
            datasets.push({
                label: '2024',
                data: filteredData,
                backgroundColor: [
                    '#25475C', '#2E7C8A', '#5EC4C8', '#92D1D4', '#BFCDD0',
                    '#A9BFC2', '#B7E1E7', '#8FAABD', '#739AA1', '#6D8D96',
                    '#607D86', '#708B95', '#789EA9'
                ].slice(0, filteredData.length),
                borderWidth: 0 // Remove borders
            });
        <?php } ?>

        <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
            datasets.push({
                label: '2024',
                data: filteredData,
                backgroundColor: ['#25475C', '#2E7C8A', '#5EC4C8', '#AAA', '#BFCDD0'].slice(0, filteredData.length),
                borderWidth: 0 // Remove borders
            });
        <?php } ?>

        let data = {
            type: 'pie', // Ensure the chart type is 'pie' for a full pie chart
            data: {
                labels: filteredLabels,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        top: 30,
                        bottom: 10 // Add padding to the bottom for the legend
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            color: '#000', // Legend text color
                            padding: 20 // Add padding to the legend labels
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + '%'; // Show the label and percentage on the tooltip
                            }
                        }
                    },
                    datalabels: {
                        formatter: function(value, context) {
                            return value + '%'; // Display percentage inside the pie slices
                        },
                        color: '#000',
                        align: 'end',
                        anchor: 'end',
                        offset: 10,
                        font: {
                            weight: 'bold'
                        },
                        clip: false
                    }
                }
            },
            plugins: [ChartDataLabels] // Enable the datalabels plugin
        };

        var ytdPercentageRoomChannel = new Chart(ctxPercentageRoomChannel, data);
    })();



        //
        // THIS STARTS PAGE 5
        //

        // Rooms Sold - Full Year - Page 5

        (function() {
            var monthlyValues, yValues2021, yValues2022, yValues2023, yValues2024;

            // Assign values based on the hotel_code
            <?php if(get_field('hotel_code') == 'THANA'){ ?>
                monthlyValues = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                yValues2023 = [1138, 1105, 1031, 1181, 504, 544, 1019, 694, 452, 697, 758, 1227];
                yValues2024 = [1167, 1343, 863, 886, 306, 74, 116, 57, 12, 34, 70, 274];
            <?php } ?>

            <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
                monthlyValues = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                yValues2021 = [156, 304, 390, 513, 620, 327, 745, 894, 756, 603, 396, 361];
                yValues2022 = [267, 377, 362, 522, 654, 744, 937, 987, 816, 684, 660, 568];
                yValues2023 = [380, 502, 426, 644, 760, 795, 924, 938, 815, 739, 384, 558];
                yValues2024 = [316, 326, 456, 594, 578, 349, 162, 166, 130, 115, 2, 25];
            <?php } ?>

            if($('#yearlyRoomsSoldChart').length > 0) {
                var ctxLos = document.querySelector('#yearlyRoomsSoldChart').getContext('2d');
            }

            if($('#yearlyRoomsSoldChart1').length > 0) {
                var ctxLos1 = document.querySelector('#yearlyRoomsSoldChart1').getContext('2d');
            }

            const getDynamicMinMax = (values) => {
                const min = Math.min(...values);
                const max = Math.max(...values);
                const dynamicMinValue = Math.floor(min * 0.95); // Adjusted dynamic min value
                const adjustedMax = Math.ceil(max * 1.05); // Adjusted dynamic max value
                return { dynamicMinValue, adjustedMax };
            };

            const allValues = [
                ...(yValues2021 || []),
                ...(yValues2022 || []),
                ...(yValues2023 || []),
                ...(yValues2024 || [])
            ];

            if (allValues.length > 0) {
                const { dynamicMinValue, adjustedMax } = getDynamicMinMax(allValues);

                let data = {
                    type: 'line',
                    data: {
                        labels: monthlyValues,
                        datasets: [
                            yValues2021 && {
                                label: '2021',
                                data: yValues2021,
                                borderColor: '#BFCDD0',
                                backgroundColor: 'rgba(191, 205, 208, 0.5)',
                                fill: false,
                                tension: 0.1,
                                pointRadius: 3,
                                pointHoverRadius: 10,
                                spanGaps: true,
                            },
                            yValues2022 && {
                                label: '2022',
                                data: yValues2022,
                                borderColor: '#5EC4C8',
                                backgroundColor: 'rgba(94, 196, 200, 0.5)',
                                fill: false,
                                tension: 0.1,
                                pointRadius: 3,
                                pointHoverRadius: 10,
                                spanGaps: true,
                            },
                            yValues2023 && {
                                label: '2023',
                                data: yValues2023,
                                borderColor: '#2E7C8A',
                                backgroundColor: 'rgba(46, 124, 138, 0.5)',
                                fill: false,
                                tension: 0.1,
                                pointRadius: 3,
                                pointHoverRadius: 10,
                                spanGaps: true,
                            },
                            yValues2024 && {
                                label: '2024',
                                data: yValues2024,
                                borderColor: '#25475C',
                                backgroundColor: 'rgba(37, 71, 92, 0.5)',
                                fill: false,
                                tension: 0.1,
                                pointRadius: 3,
                                pointHoverRadius: 10,
                                spanGaps: true,
                            }
                        ].filter(Boolean) // Filter out undefined datasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            duration: 1000, // You can customize this
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    color: '#000' // Legend text color
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (tooltipItem) {
                                        return tooltipItem.raw; // Show the yValues on the tooltip
                                    }
                                }
                            },
                        },
                        scales: {
                            y: {
                                beginAtZero: false,
                                min: dynamicMinValue,
                                max: adjustedMax
                            }
                        },
                    }
                };

                var yearlyRoomsSoldChart = new Chart(ctxLos, data);
                var yearlyRoomsSoldChart1 = new Chart(ctxLos1, data);
            } else {
                console.warn('No data available to plot');
            }
        })();


        // Annual ADR Sold -- Page 5

        (function() {
            var monthlyValues, yValues2021, yValues2022, yValues2023, yValues2024;
            var formatter;

            // Assign values based on the hotel_code
            <?php if(get_field('hotel_code') == 'THANA'){ ?>
                monthlyValues = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                yValues2023 = [5148.45, 4214.96, 4847.27, 5835.52 , 4654.18, 4800.48, 5206.47 , 5660.83 , 4152.22, 4821.77, 4035.19, 5849.93];
                yValues2024 = [5736.76 , 5779.33, 4726.83, 5694.94, 5164.97, 5026.19 , 4953.32, 9106.84, 4054.36 , 3519.78, 6117.45, 7722.61];

                // Define a number formatter for Thai Baht
                formatter = new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            <?php } ?>

            <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
                monthlyValues = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                yValues2021 = [98.15, 113.05, 95.01, 117.98, 110.01, 111.68, 107.53, 107.86, 104.78, 100.70, 96.78, 103.88];
                yValues2022 = [92.15, 90.15, 84.33, 104.13, 102.52, 106.86, 118.05, 117.48, 108.95, 107.92, 100.73, 112.00];
                yValues2023 = [92.59, 105.25, 99.32, 110.08, 111.91, 111.91, 125.35, 126.56, 120.73, 113.47, 99.26, 129.39];
                yValues2024 = [95.45, 112.97, 110.43, 116.57, 134.95, 128.43, 143.95, 138.48, 152.13, 130.77, 43.00, 130.14];

                // Define a number formatter for Euros
                formatter = new Intl.NumberFormat('de-DE', {
                    style: 'currency',
                    currency: 'EUR',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            <?php } ?>

            if($('#yearAdr').length > 0) {
                var ctxAdr = document.querySelector('#yearAdr').getContext('2d');
            }

            if($('#yearAdr1').length > 0) {
                var ctxAdr1 = document.querySelector('#yearAdr1').getContext('2d');
            }

            const getDynamicMinMax = (values) => {
                const min = Math.min(...values);
                const max = Math.max(...values);
                const dynamicMinValue = Math.floor(min * 0.9); // Adjusted dynamic min value
                const adjustedMax = Math.ceil(max * 1.1); // Adjusted dynamic max value
                return { dynamicMinValue, adjustedMax };
            };

            const allValues = [
                ...(yValues2021 || []),
                ...(yValues2022 || []),
                ...(yValues2023 || []),
                ...(yValues2024 || [])
            ];

            if (allValues.length > 0) {
                const { dynamicMinValue, adjustedMax } = getDynamicMinMax(allValues);

                let data = {
                    type: 'line',
                    data: {
                        labels: monthlyValues,
                        datasets: [
                            yValues2021 && {
                                label: '2021',
                                data: yValues2021,
                                borderColor: '#BFCDD0',
                                backgroundColor: 'rgba(191, 205, 208, 0.5)',
                                fill: false,
                                tension: 0.1,
                                pointRadius: 3,
                                pointHoverRadius: 10,
                                spanGaps: true,
                            },
                            yValues2022 && {
                                label: '2022',
                                data: yValues2022,
                                borderColor: '#5EC4C8',
                                backgroundColor: 'rgba(94, 196, 200, 0.5)',
                                fill: false,
                                tension: 0.1,
                                pointRadius: 3,
                                pointHoverRadius: 10,
                                spanGaps: true,
                            },
                            yValues2023 && {
                                label: '2023',
                                data: yValues2023,
                                borderColor: '#2E7C8A',
                                backgroundColor: 'rgba(46, 124, 138, 0.5)',
                                fill: false,
                                tension: 0.1,
                                pointRadius: 3,
                                pointHoverRadius: 10,
                                spanGaps: true,
                            },
                            yValues2024 && {
                                label: '2024',
                                data: yValues2024,
                                borderColor: '#25475C',
                                backgroundColor: 'rgba(37, 71, 92, 0.5)',
                                fill: false,
                                tension: 0.1,
                                pointRadius: 3,
                                pointHoverRadius: 10,
                                spanGaps: true,
                            }
                        ].filter(Boolean) // Filter out undefined datasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            duration: 1000, // You can customize this
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    color: '#000' // Legend text color
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (tooltipItem) {
                                        // Use the appropriate formatter if it is defined
                                        if (formatter) {
                                            return formatter.format(tooltipItem.raw);
                                        }
                                        return tooltipItem.raw; // Show the yValues on the tooltip
                                    }
                                }
                            },
                        },
                        scales: {
                            y: {
                                beginAtZero: false,
                                min: dynamicMinValue,
                                max: adjustedMax,
                                ticks: {
                                    callback: function(value) {
                                        // Use the appropriate formatter if it is defined
                                        if (formatter) {
                                            return formatter.format(value);
                                        }
                                        return value;
                                    }
                                }
                            }
                        },
                    }
                };

                var yearAdr = new Chart(ctxAdr, data);
                var yearAdr1 = new Chart(ctxAdr1, data);
            } else {
                console.warn('No data available to plot');
            }
        })();


        // Annual Rev -- Page 5
        (function() {
            var monthlyValues, yValues2021, yValues2022, yValues2023, yValues2024;
            var formatter;

            // Assign values based on the hotel_code
            <?php if(get_field('hotel_code') == 'THANA'){ ?>
                monthlyValues = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                yValues2023 = [5858937.79, 4657534.29, 4997537.61, 6891754.67, 2345706.16, 2611461.48, 5305393.60, 3928613.86, 1876802.61, 3360773.19, 3058671.75, 7177868.35];
                yValues2024 = [6694796.26, 7761645.09, 4079258.40, 5045717.11, 1580482.09, 371938.27, 574584.65, 519089.70, 48652.36, 119672.68, 428221.15, 2115995.90];

                // Define a number formatter for Thai Baht
                formatter = new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            <?php } ?>

            <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
                monthlyValues = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                yValues2021 = [15311.21, 34368.21, 37052.71, 60526.30, 68204.30, 36519.45, 80110.50, 96431.03, 79211.75, 60719.74, 38323.50, 37499.10];
                yValues2022 = [24603.50, 33986.98, 30528.37, 54357.90, 67047.80, 79500.40, 110614.75, 115925.55, 88902.27, 73817.09, 66481.50, 63617.70];
                yValues2023 = [35185.00, 53833.60, 43311.21, 70889.94, 85049.01, 88625.53, 115825.00, 11709.40, 98397.48, 83857.61, 38115.80, 72197.78];
                yValues2024 = [30161.85, 36829.17, 50357.22, 69244.76, 77999.68, 44820.70, 23320.05, 22988.00, 19776.40, 15038.00, 86.01, 3253.40];

                // Define a number formatter for Euros
                formatter = new Intl.NumberFormat('de-DE', {
                    style: 'currency',
                    currency: 'EUR',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            <?php } ?>

            if ($('#yearRev').length > 0) {
                var ctxRev = document.querySelector('#yearRev').getContext('2d');
            }

            if ($('#yearRev1').length > 0) {
                var ctxRev1 = document.querySelector('#yearRev1').getContext('2d');
            }

            const getDynamicMinMax = (values) => {
                const min = Math.min(...values);
                const max = Math.max(...values);
                const dynamicMinValue = Math.floor(min * 0.9); // Adjusted dynamic min value
                const adjustedMax = Math.ceil(max * 1.1); // Adjusted dynamic max value
                return { dynamicMinValue, adjustedMax };
            };

            const allValues = [
                ...(yValues2021 || []),
                ...(yValues2022 || []),
                ...(yValues2023 || []),
                ...(yValues2024 || [])
            ];

            if (allValues.length > 0) {
                const { dynamicMinValue, adjustedMax } = getDynamicMinMax(allValues);

                let data = {
                    type: 'line',
                    data: {
                        labels: monthlyValues,
                        datasets: [
                            yValues2021 && {
                                label: '2021',
                                data: yValues2021,
                                borderColor: '#BFCDD0',
                                backgroundColor: 'rgba(191, 205, 208, 0.5)',
                                fill: false,
                                tension: 0.1,
                                pointRadius: 3,
                                pointHoverRadius: 10,
                                spanGaps: true,
                            },
                            yValues2022 && {
                                label: '2022',
                                data: yValues2022,
                                borderColor: '#5EC4C8',
                                backgroundColor: 'rgba(94, 196, 200, 0.5)',
                                fill: false,
                                tension: 0.1,
                                pointRadius: 3,
                                pointHoverRadius: 10,
                                spanGaps: true,
                            },
                            yValues2023 && {
                                label: '2023',
                                data: yValues2023,
                                borderColor: '#2E7C8A',
                                backgroundColor: 'rgba(46, 124, 138, 0.5)',
                                fill: false,
                                tension: 0.1,
                                pointRadius: 3,
                                pointHoverRadius: 10,
                                spanGaps: true,
                            },
                            yValues2024 && {
                                label: '2024',
                                data: yValues2024,
                                borderColor: '#25475C',
                                backgroundColor: 'rgba(37, 71, 92, 0.5)',
                                fill: false,
                                tension: 0.1,
                                pointRadius: 3,
                                pointHoverRadius: 10,
                                spanGaps: true,
                            }
                        ].filter(Boolean) // Filter out undefined datasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            duration: 1000, // You can customize this
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    color: '#000' // Legend text color
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (tooltipItem) {
                                        // Use the appropriate formatter if it is defined
                                        if (formatter) {
                                            return formatter.format(tooltipItem.raw);
                                        }
                                        return tooltipItem.raw; // Show the yValues on the tooltip
                                    }
                                }
                            },
                        },
                        scales: {
                            y: {
                                beginAtZero: false,
                                min: dynamicMinValue,
                                max: adjustedMax,
                                ticks: {
                                    callback: function(value) {
                                        // Use the appropriate formatter if it is defined
                                        if (formatter) {
                                            return formatter.format(value);
                                        }
                                        return value;
                                    }
                                }
                            }
                        },
                    }
                };

                var yearRev = new Chart(ctxRev, data);
                var yearRev1 = new Chart(ctxRev1, data);
            } else {
                console.warn('No data available to plot');
            }
        })();

    // Yearly LOS -- Page 5
    
    (function() {
        var monthlyValues, yValues2021, yValues2022, yValues2023, yValues2024;

        // Assign values based on the hotel_code
        <?php if(get_field('hotel_code') == 'LUTAN'){ ?>
            monthlyValues = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            yValues2021 = [1.39, 1.47, 1.64, 1.79, 1.68, 1.78, 2.16, 2.30, 2.35, 2.28, 1.95, 2.09];
            yValues2022 = [1.85, 1.36, 1.51, 2.22, 2.17, 2.07, 1.98, 2.42, 2.31, 1.90, 1.89, 2.20];
            yValues2023 = [1.55, 1.57, 1.79, 1.95, 2.10, 1.93, 1.91, 1.91, 2.13, 1.90, 1.79, 1.65];
            yValues2024 = [1.67, 1.51, 1.86, 1.82, 2.56, 2.64, 3.03, 2.68, 3.00, 0.00, 0.00, 2.50];
        <?php } ?>

        if ($('#yearLos').length > 0) {
            var ctxLos = document.querySelector('#yearLos').getContext('2d');
        }

        const getDynamicMinMax = (values) => {
            const min = Math.min(...values);
            const max = Math.max(...values);
            const dynamicMinValue = Math.floor(min * 0.9); // Adjusted dynamic min value
            const adjustedMax = Math.ceil(max * 1.1); // Adjusted dynamic max value
            return { dynamicMinValue, adjustedMax };
        };

        const allValues = [
            ...(yValues2021 || []),
            ...(yValues2022 || []),
            ...(yValues2023 || []),
            ...(yValues2024 || [])
        ];

        if (allValues.length > 0) {
            const { dynamicMinValue, adjustedMax } = getDynamicMinMax(allValues);

            let data = {
                type: 'line',
                data: {
                    labels: monthlyValues,
                    datasets: [
                        yValues2021 && {
                            label: '2021',
                            data: yValues2021,
                            borderColor: '#BFCDD0',
                            backgroundColor: 'rgba(191, 205, 208, 0.5)',
                            fill: false,
                            tension: 0.1,
                            pointRadius: 3,
                            pointHoverRadius: 10,
                            spanGaps: true,
                        },
                        yValues2022 && {
                            label: '2022',
                            data: yValues2022,
                            borderColor: '#5EC4C8',
                            backgroundColor: 'rgba(94, 196, 200, 0.5)',
                            fill: false,
                            tension: 0.1,
                            pointRadius: 3,
                            pointHoverRadius: 10,
                            spanGaps: true,
                        },
                        yValues2023 && {
                            label: '2023',
                            data: yValues2023,
                            borderColor: '#2E7C8A',
                            backgroundColor: 'rgba(46, 124, 138, 0.5)',
                            fill: false,
                            tension: 0.1,
                            pointRadius: 3,
                            pointHoverRadius: 10,
                            spanGaps: true,
                        },
                        yValues2024 && {
                            label: '2024',
                            data: yValues2024,
                            borderColor: '#25475C',
                            backgroundColor: 'rgba(37, 71, 92, 0.5)',
                            fill: false,
                            tension: 0.1,
                            pointRadius: 3,
                            pointHoverRadius: 10,
                            spanGaps: true,
                        }
                    ].filter(Boolean) // Filter out undefined datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1000, // You can customize this
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                color: '#000' // Legend text color
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (tooltipItem) {
                                    return tooltipItem.raw; // Show the yValues on the tooltip
                                }
                            }
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            min: dynamicMinValue,
                            max: adjustedMax
                        }
                    },
                }
            };

            var yearLos = new Chart(ctxLos, data);
        } else {
            console.warn('No data available to plot');
        }
    })();

        // Website Traffic per Quarter - WEBSITE SECTION

    (function() {
        // Data for the first quarter of 2024
        var daysOfQuarter = Array.from({ length: 91 }, (_, i) => (i + 1).toString());
        var usersData = [162, 141, 112, 85, 111, 89, 83, 97, 134, 49, 57, 76, 45, 54, 73, 50, 43, 70, 66, 90, 73, 188, 129, 86, 83, 75, 78, 60, 78, 47, 127, 29, 37, 65, 105, 120, 111, 99, 114, 111, 119, 112, 117, 83, 67, 58, 47, 42, 70, 51, 33, 47, 40, 44, 51, 51, 60, 61, 54, 62, 70, 71, 67, 54, 36, 41, 80, 62, 65, 50, 53, 56, 42, 48, 59, 71, 82, 70, 42, 50, 57, 46, 81, 89, 61, 57, 45, 58, 83, 74, 57];
        var newUsersData = [154, 121, 91, 67, 94, 77, 73, 87, 124, 47, 54, 66, 41, 53, 66, 41, 39, 64, 56, 80, 65, 175, 117, 74, 73, 68, 71, 50, 71, 40, 110, 20, 31, 50, 97, 105, 99, 91, 100, 95, 110, 100, 105, 64, 51, 45, 37, 37, 56, 43, 28, 40, 31, 35, 41, 44, 48, 52, 47, 46, 55, 56, 57, 39, 29, 38, 71, 53, 55, 43, 45, 49, 39, 35, 46, 62, 72, 60, 32, 42, 51, 39, 68, 74, 52, 44, 35, 44, 60, 62, 43];

        if ($('#trafficChartQ1').length > 0) {
            var ctxTrafficQ1 = document.querySelector('#trafficChartQ1').getContext('2d');
        }

        const getDynamicMinMax = (values) => {
            const min = Math.min(...values);
            const max = Math.max(...values);
            const dynamicMinValue = Math.floor(min * 0.9); // Adjusted dynamic min value
            const adjustedMax = Math.ceil(max * 1.1); // Adjusted dynamic max value
            return { dynamicMinValue, adjustedMax };
        };

        const allValues = [
            ...usersData,
            ...newUsersData
        ];

        if (allValues.length > 0) {
            const { dynamicMinValue, adjustedMax } = getDynamicMinMax(allValues);

            let data = {
                type: 'line',
                data: {
                    labels: daysOfQuarter,
                    datasets: [
                        {
                            label: 'Total Users',
                            data: usersData,
                            borderColor: '#25475C',
                            backgroundColor: '#25475C',
                            fill: false,
                            tension: 0.1,
                            pointRadius: 1, // Remove points
                            pointHoverRadius: 5, // Remove hover points
                        },
                        {
                            label: 'New Users',
                            data: newUsersData,
                            borderColor: '#5EC4C8',
                            backgroundColor: '#5EC4C8',
                            fill: false,
                            tension: 0.1,
                            pointRadius: 1, // Remove points
                            pointHoverRadius: 5, // Remove hover points
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1000, // You can customize this
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                color: '#000', // Legend text color
                                boxWidth: 25, // Make legend boxes rectangular
                                boxHeight: 10, // Make legend boxes rectangular
                                usePointStyle: false, // Use rectangular boxes instead of point style
                                borderColor: '#000',
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (tooltipItem) {
                                    return tooltipItem.raw; // Show the yValues on the tooltip
                                }
                            }
                        },
                        customLegendPlugin // Use the custom legend plugin
                    },
                    scales: {
                        x: {
                            ticks: {
                                callback: function(value, index, values) {
                                    if (index === 0) return 'Jan';
                                    if (index === 31) return 'Feb';
                                    if (index === 59) return 'Mar';
                                    return '';
                                },
                                autoSkip: false,
                                maxRotation: 0,
                                minRotation: 0
                            }
                        },
                        y: {
                            beginAtZero: false,
                            min: dynamicMinValue,
                            max: adjustedMax
                        }
                    },
                }
            };

            var trafficChartQ1 = new Chart(ctxTrafficQ1, data);
        } else {
            console.warn('No data available to plot');
        }
    })();

        // WEBSITE TRAFFIC PER CHANNEL - WEBSITE SECTION

        (function() {
        // Data for the pie chart
        var channelLabels = ['Direct', 'Organic Search', 'Referral', 'Organic Social', 'Other'];
        var dataUsers = [2201, 1614, 1333, 612, 207];

        if ($('#trafficPieChart').length > 0) {
            var ctxTrafficPieChart = document.querySelector('#trafficPieChart').getContext('2d');
        }

        // Filter out 0% values and corresponding labels
        const filteredLabels = [];
        const filteredData = [];
        for (let i = 0; i < dataUsers.length; i++) {
            if (dataUsers[i] > 0) {
                filteredLabels.push(channelLabels[i]);
                filteredData.push(dataUsers[i]);
            }
        }

        // Define background colors for the pie chart
        const backgroundColors = [
            '#25475C', '#2E7C8A', '#5EC4C8', '#92D1D4', '#BFCDD0'
        ].slice(0, filteredData.length);

        // Create the dataset object
        const datasets = [{
            label: 'Users',
            data: filteredData,
            backgroundColor: backgroundColors,
            borderWidth: 0 // Remove borders
        }];

        // Chart configuration
        let data = {
            type: 'pie', // Ensure the chart type is 'pie' for a full pie chart
            data: {
                labels: filteredLabels,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        top: 40,
                        bottom: 40,
                        left: 60,
                        right: 50 // Add padding to the bottom for the legend
                    }
                },
                plugins: {
                    legend: {
                        display: false // Hide the external legend
                    },
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw; // Show the label and users on the tooltip
                            }
                        }
                    },
                    datalabels: {
                        formatter: function (value, context) {
                            const total = context.chart.data.datasets[0].data.reduce((sum, val) => sum + val, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return context.chart.data.labels[context.dataIndex] + '\n' + percentage + '%'; // Add a line break between label and percentage
                        },
                        color: '#000',
                        align: 'end',
                        anchor: 'end',
                        offset: 5,
                        font: {
                            weight: 'bold',
                            size: 12
                        }
                    }
                }
            },
            plugins: [ChartDataLabels] // Enable the datalabels plugin
        };

        var trafficPieChart = new Chart(ctxTrafficPieChart, data);
    })();

    // IBE Sales Graph

    (function() {
            var ctxQuarterlyIbeChart = document.querySelector('#quarterlyIbeChart').getContext('2d');

            var xValues = ['Rooms Sold (IBE)', 'Revenue (IBE)', 'Total Website Traffic'];
            var yValuesQ1_2024 = [99, 14128, 5805];
            var yValuesQ1_2023 = [160, 20417, 5284];

            // Function to dynamically calculate min and max values
            const getDynamicMinMax = (values) => {
                const min = Math.min(...values);
                const max = Math.max(...values);
                const dynamicMinValue = Math.floor(min * 0.95);
                const adjustedMax = Math.ceil(max * 1.05);
                return { dynamicMinValue, adjustedMax };
            };

            // Calculate dynamic min and max values for both datasets
            const { dynamicMinValue: minRoomsSold, adjustedMax: maxRoomsSold } = getDynamicMinMax([yValuesQ1_2024[0], yValuesQ1_2023[0]]);
            const { dynamicMinValue: minRevenue, adjustedMax: maxRevenue } = getDynamicMinMax([yValuesQ1_2024[1], yValuesQ1_2023[1]]);
            const { dynamicMinValue: minTraffic, adjustedMax: maxTraffic } = getDynamicMinMax([yValuesQ1_2024[2], yValuesQ1_2023[2]]);

            let data = {
                labels: xValues,
                datasets: [
                    {
                        label: 'Q1 2024',
                        data: yValuesQ1_2024,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                    },
                    {
                        label: 'Q1 2023',
                        data: yValuesQ1_2023,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                    }
                ]
            };

            let options = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        suggestedMin: Math.min(minRoomsSold, minRevenue, minTraffic),
                        suggestedMax: Math.max(maxRoomsSold, maxRevenue, maxTraffic),
                        ticks: {
                            callback: function(value, index, values) {
                                if (value >= 1000) {
                                    return '€' + (value / 1000).toLocaleString() + 'k';
                                }
                                return value.toLocaleString();
                            }
                        },
                        title: {
                            display: true,
                            text: 'Values'
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                let value = context.raw;
                                if (context.label.includes('Revenue')) {
                                    return `${label}: €${value.toLocaleString()}`;
                                } else {
                                    return `${label}: ${value.toLocaleString()}`;
                                }
                            }
                        }
                    }
                }
            };

            new Chart(ctxQuarterlyIbeChart, {
                type: 'bar',
                data: data,
                options: options
            });
        })();

        (function() {
            var ctxRoomsSoldChart = document.querySelector('#roomsSoldChart').getContext('2d');

            var xValues = ['Rooms Sold (IBE)'];
            var yValuesQ1_2024 = [99];
            var yValuesQ1_2023 = [160];

            const getDynamicMinMax = (values) => {
                const min = Math.min(...values);
                const max = Math.max(...values);
                const dynamicMinValue = Math.floor(min * 0.95);
                const adjustedMax = Math.ceil(max * 1.05);
                return { dynamicMinValue, adjustedMax };
            };

            const { dynamicMinValue, adjustedMax } = getDynamicMinMax([...yValuesQ1_2024, ...yValuesQ1_2023]);

            let data = {
                labels: xValues,
                datasets: [
                    {
                        label: 'Q1 2024',
                        data: yValuesQ1_2024,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                    },
                    {
                        label: 'Q1 2023',
                        data: yValuesQ1_2023,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                    }
                ]
            };

            let options = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        min: dynamicMinValue,
                        max: adjustedMax,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString();
                            }
                        },
                        title: {
                            display: true,
                            text: 'Number of Rooms Sold'
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                let value = context.raw;
                                return `${label}: ${value.toLocaleString()}`;
                            }
                        }
                    }
                }
            };

            new Chart(ctxRoomsSoldChart, {
                type: 'bar',
                data: data,
                options: options
            });
        })();

        (function() {
            var ctxRevenueTrafficChart = document.querySelector('#revenueTrafficChart').getContext('2d');

            var xValues = ['Revenue (IBE)', 'Total Website Traffic'];
            var yValuesQ1_2024 = [14128, 5805];
            var yValuesQ1_2023 = [20417, 5284];

            const getDynamicMinMax = (values) => {
                const min = Math.min(...values);
                const max = Math.max(...values);
                const dynamicMinValue = Math.floor(min * 0.95);
                const adjustedMax = Math.ceil(max * 1.05);
                return { dynamicMinValue, adjustedMax };
            };

            const { dynamicMinValue, adjustedMax } = getDynamicMinMax([...yValuesQ1_2024, ...yValuesQ1_2023]);

            let data = {
                labels: xValues,
                datasets: [
                    {
                        label: 'Q1 2024',
                        data: yValuesQ1_2024,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                    },
                    {
                        label: 'Q1 2023',
                        data: yValuesQ1_2023,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                    }
                ]
            };

            let options = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        min: dynamicMinValue,
                        max: adjustedMax,
                        ticks: {
                            callback: function(value) {
                                if (xValues.includes('Revenue (IBE)')) {
                                    return '€' + value.toLocaleString();
                                } else {
                                    return value.toLocaleString();
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: 'Values'
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                let value = context.raw;
                                if (context.label === 'Revenue (IBE)') {
                                    return `${label}: €${value.toLocaleString()}`;
                                } else {
                                    return `${label}: ${value.toLocaleString()}`;
                                }
                            }
                        }
                    }
                }
            };

            new Chart(ctxRevenueTrafficChart, {
                type: 'bar',
                data: data,
                options: options
            });
        })();


    /*
        //Website Traffic Page (1 Month)

        (function() {
        // Data for website traffic
        var daysOfMonth = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30'];
        var usersData = [48, 76, 45, 58, 53, 41, 61, 57, 36, 31, 58, 36, 41, 59, 52, 58, 64, 56, 67, 51, 46, 45, 54, 47, 64, 40, 71, 91, 84, 65];
        var newUsersData = [40, 62, 28, 43, 40, 29, 47, 48, 28, 28, 48, 26, 33, 47, 46, 46, 54, 51, 53, 44, 37, 39, 47, 41, 55, 32, 63, 80, 81, 56];

        if ($('#trafficChart').length > 0) {
            var ctxTraffic = document.querySelector('#trafficChart').getContext('2d');
        }

        const getDynamicMinMax = (values) => {
            const min = Math.min(...values);
            const max = Math.max(...values);
            const dynamicMinValue = Math.floor(min * 0.9); // Adjusted dynamic min value
            const adjustedMax = Math.ceil(max * 1.1); // Adjusted dynamic max value
            return { dynamicMinValue, adjustedMax };
        };

        const allValues = [
            ...usersData,
            ...newUsersData
        ];

        if (allValues.length > 0) {
            const { dynamicMinValue, adjustedMax } = getDynamicMinMax(allValues);

            let data = {
                type: 'line',
                data: {
                    labels: daysOfMonth,
                    datasets: [
                        {
                            label: 'Users',
                            data: usersData,
                            borderColor: '#25475C',
                            backgroundColor: 'rgba(191, 205, 208, 0.5)',
                            fill: false,
                            tension: 0.1,
                            pointRadius: 3,
                            pointHoverRadius: 10,
                        },
                        {
                            label: 'New Users',
                            data: newUsersData,
                            borderColor: '#5EC4C8',
                            backgroundColor: 'rgba(94, 196, 200, 0.5)',
                            fill: false,
                            tension: 0.1,
                            pointRadius: 3  ,
                            pointHoverRadius: 10,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1000, // You can customize this
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                color: '#000' // Legend text color
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (tooltipItem) {
                                    return tooltipItem.raw; // Show the yValues on the tooltip
                                }
                            }
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            min: dynamicMinValue,
                            max: adjustedMax
                        }
                    },
                }
            };

            var trafficChart = new Chart(ctxTraffic, data);
        } else {
            console.warn('No data available to plot');
        }
    })();
    */



</script>

</body>
</html>