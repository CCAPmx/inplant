<section class="grafica_grano mt-2">




    <style>
        #grafico-container {
            position: relative;
            width: 800px;
        }

        #texto-centro {
            position: absolute;
            top: 35%;
            left: 30%;
            font-size: 36px;
            font-weight: bold;
            color: red;
            pointer-events: none;
        }
    </style>

    <!-- <div id="grafico-container"> -->
    <!-- <div id="texto-centro">GRAFICO 1</div> -->
    <canvas id="graficoSilo" width="600" height="400"></canvas>
    <!-- </div> -->
    <script>
        const graficoSilo = document.getElementById('graficoSilo').getContext('2d');

        new Chart(graficoSilo, {
            type: 'line',
            data: {
                labels: [
                    '10-feb', '11-feb', '12-feb', '13-feb', '14-feb', '15-feb', '16-feb',
                    '17-feb', '18-feb', '19-feb', '20-feb', '21-feb', '22-feb', '23-feb', '24-feb', '25-feb'
                ],
                datasets: [{
                        label: 'Nivel Medido',
                        data: [null, null, null, null, null, null, null, null, null, null, -1.52, -1.48, -1.50, -1.47, null, null],
                        borderColor: 'steelblue',
                        backgroundColor: 'steelblue',
                        fill: false,
                        tension: 0.3,
                        pointRadius: 5,
                        pointBorderWidth: 2
                    },
                    {
                        label: 'Límite Inferior',
                        data: Array(16).fill(-1.35), // Línea constante
                        borderColor: 'blue',
                        backgroundColor: 'blue',
                        borderWidth: 2,
                        borderDash: [], // línea sólida
                        fill: false,
                        pointRadius: 0,
                        pointHoverRadius: 0,
                        datalabels: {
                            display: false // 👈 Esto evita que muestre los números
                        }
                    }
                ]
            },
            options: {
                plugins: {
                    title: {
                        display: true,

                        color: '#000',
                        text: 'CG02 Nivel de Silo',
                        font: {
                            color: '#000',
                            size: 18
                        }
                    },
                    legend: {
                        display: false
                    },
                    datalabels: {
                        display: true,
                        color: '#000',
                        font: {
                            weight: 'bold'
                        },
                        formatter: (value) => value !== null ? value.toFixed(2) : ''
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#333',
                            maxRotation: 60,
                            minRotation: 60
                        },
                        grid: {
                            display: false,
                            borderColor: '#000',
                            borderWidth: 1.5
                        }
                    },
                    y: {
                        min: -1.6,
                        max: -0.8,
                        ticks: {
                            color: '#333',
                            callback: function(value) {
                                return value.toFixed(2);
                            }
                        },
                        grid: {
                            drawTicks: true,
                            drawBorder: true,
                            borderColor: '#000',
                            borderWidth: 1.5
                        },
                        title: {
                            display: false,
                            text: 'Nivel (m)',
                            color: '#000'
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    </script>

</section>