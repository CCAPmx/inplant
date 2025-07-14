<section class="grafica_grano mt-2">




   

    <!-- <div id="grafico-container"> -->
    <!-- <div id="texto-centro">GRAFICO 1</div> -->
    <canvas id="graficoRugosidad" width="600" height="400"></canvas>
    <!-- </div> -->
    <script>
        const graficoRugosidad = document.getElementById('graficoRugosidad').getContext('2d');

        new Chart(graficoRugosidad, {
            type: 'line',
            data: {
                labels: [
                    '05-feb', '06-feb', '07-feb', '08-feb', '09-feb', '10-feb', '11-feb', '12-feb',
                    '13-feb', '14-feb', '15-feb', '16-feb', '17-feb', '18-feb', '19-feb',
                    '20-feb', '21-feb', '22-feb', '23-feb', '24-feb', '25-feb'
                ],
                datasets: [{
                        label: 'Ra Real Medición',
                        data: [null, null, null, null, null, null, null, null, null, null, null, null, null, null, 2.2, 3.0, 2.8, 2.6, null, null, null],
                        borderColor: 'blue',
                        backgroundColor: 'blue',
                        fill: false,
                        tension: 0.3,
                        pointRadius: 5,
                        pointBorderWidth: 2
                    },
                    {
                        label: 'Límite Máximo',
                        data: [null, null, null, null, null, null, null, null, null, null, null, null, null, null, 1.0, 1.0, 1.0, 1.0, 1.0, 1.0, null],
                        borderColor: 'red',
                        backgroundColor: 'red',
                        fill: false,
                        tension: 0.1,
                        pointRadius: 5,
                        pointBorderWidth: 2
                    }
                ]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        color: '#000',
                        text: 'Rugosidad',
                        font: {
                            size: 18
                        }
                    },
                    legend: {
                        display: false
                    },
                    datalabels: {
                        display: true,
                        color: 'black',
                        font: {
                            weight: 'bold'
                        },
                        formatter: (value) => value !== null ? value.toFixed(1) : ''
                    }
                },
                scales: {
                    y: {
                        grid: {
                            display: true // 👈 Oculta las líneas horizontales
                        },
                        beginAtZero: true,
                        max: 3.5,
                        title: {
                            display: false,
                            text: 'Ra (µm)'
                        }
                    },
                    x: {
                        grid: {
                            display: false // 👈 Oculta las líneas horizontales
                        },
                        title: {
                            display: false,
                            text: 'Fecha'
                        },
                        ticks: {
                            maxRotation: 90,
                            minRotation: 45
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    </script>



</section>