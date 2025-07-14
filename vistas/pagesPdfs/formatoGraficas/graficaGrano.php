<section class="grafica_grano mt-2">






    <!-- <div id="grafico-container"> -->
        <!-- <div id="texto-centro">GRAFICO 1</div> -->
        <canvas id="graficoGrano" width="600" height="400"></canvas>
    <!-- </div> -->
    <script>
        const ctx = document.getElementById('graficoGrano').getContext('2d');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    '05-feb', '06-feb', '07-feb', '08-feb', '09-feb', '10-feb', '11-feb', '12-feb',
                    '13-feb', '14-feb', '15-feb', '16-feb', '17-feb', '18-feb', '19-feb',
                    '20-feb', '21-feb', '22-feb', '23-feb', '24-feb', '25-feb'
                ],
                datasets: [{
                        label: 'Serie Azul',
                        data: [null, null, null, null, null, null, null, null, null, null, null, null, null, null, 21, 50, 43, 36, null, null, null],
                        borderColor: 'blue',
                        // borderWidth: 3,
                        backgroundColor: 'blue',
                        fill: false,
                        tension: 0.3,
                        pointRadius: 5,
                        pointStyle: 'rectRot',
                        pointBorderWidth: 1
                    },
                    {
                        label: 'Serie Roja',
                        data: [null, null, null, null, null, null, null, null, null, null, null, null, null, null, 6, 6, 6, 6, 6, 6, null],
                        borderColor: 'red',
                        // borderWidth: 1.5,
                        backgroundColor: 'red',
                        fill: false,
                        tension: 0.3,
                        pointRadius: 2,
                        pointStyle: 'rectRot',
                        pointBorderWidth: 1
                    }
                ]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        color: '#000', // Color
                        text: 'CG02 % Grano',
                        font: {
                            size: 18
                        }
                    },
                    legend: {
                        display: false,
                        position: 'top'
                    },
                    datalabels: {
                        // color: '#000', // color negro para las líneas horizontales
                        lineWidth: 1,
                        display: true,
                        color: 'black',
                        font: {
                            weight: 'bold'
                        },
                        formatter: (value) => (value !== null ? `${value}%` : '')
                    }
                },
                scales: {
                    y: {
                        grid: {
                            display: true,
                            // drawOnChartArea: true,
                            // drawTicks: true,
                            // drawBorder: true,
                            // color: '#000',
                            // borderColor: 'blue', // ✅ Línea del eje Y azul
                            // borderWidth: 2
                        },
                        ticks: {
                            // color: '#000',
                            callback: function(value) {
                                return value + '%'; // ✅ Agrega % a cada número
                            }
                        },
                        title: {
                            display: false,
                            // color: '#000',
                            text: 'Porcentaje (%)'
                        }
                    },
                    x: {
                        grid: {
                            drawOnChartArea: false,
                            // drawTicks: false,
                            // drawBorder: true,
                            // borderColor: '#000', // ✅ Línea del eje X negra
                            // borderWidth: 1.5
                        },
                        ticks: {
                            // color: '#000', // Color gris medio como en tu imagen
                            maxRotation: 45, // Rota las fechas en ángulo
                            minRotation: 45,
                            font: {
                                size: 12,
                                weight: 'normal'
                            }
                        },
                        title: {
                            display: false
                        }
                    }
                },



            },
            plugins: [ChartDataLabels]
        });
    </script>



</section>