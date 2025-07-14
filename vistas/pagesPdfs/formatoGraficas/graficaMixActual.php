<section class="grafica_grano mt-2">






    <!-- <div id="grafico-container"> -->
        <!-- <div id="texto-centro">GRAFICO 1</div> -->
        <canvas id="graficoMix" width="600" height="400"></canvas>
    <!-- </div> -->
    <script>
        const graficoMix = document.getElementById('graficoMix').getContext('2d');

        new Chart(graficoMix, {
            type: 'line',
            data: {
                labels: ["1.4", "1.18", "0.85", "0.6", "0.42", "0.3", "0.212", "0.15", "0.106", "0.075", "Polvo"],
                datasets: [{
                        label: 'Línea Azul',
                        data: [0, 0.02, 0.25, 0.5, 0.4, 0.3, 0.15, 0.05, 0.02, 0.01, 0],
                        borderColor: 'blue',
                        backgroundColor: 'blue',
                        fill: false,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBorderWidth: 2
                    },
                    {
                        label: 'Línea Roja',
                        data: [0, 0.01, 0.2, 0.55, 0.42, 0.28, 0.12, 0.03, 0.01, 0, 0],
                        borderColor: 'red',
                        backgroundColor: 'red',
                        fill: false,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBorderWidth: 2
                    }
                ]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        color: '#000',
                        text: 'CG02 Mix Actual',
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
                        formatter: value => (value !== null ? `${(value * 100).toFixed(1)}%` : '')
                    }
                },
                scales: {
                    y: {
                        grid: {
                            display: true // 👈 Oculta las líneas horizontales
                        },
                        beginAtZero: true,
                        max: 0.6,
                        title: {
                            display: false,
                            text: 'Proporción'

                        }
                    },
                    x: {
                        grid: {
                            display: false // 👈 Oculta las líneas horizontales
                        },
                        title: {
                            display: false,
                            text: 'Tamaño de partícula (mm)'
                        }

                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    </script>



</section>