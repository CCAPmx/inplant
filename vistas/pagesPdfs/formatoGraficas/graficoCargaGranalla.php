<section class="grafica_grano mt-2">






    <!-- <div id="grafico-container"> -->
        <!-- <div id="texto-centro">GRAFICO 1</div> -->
        <canvas id="graficoCargaGranalla" width="600" height="400"></canvas>
    <!-- </div> -->
    <script>
        const graficoCargaGranalla = document.getElementById('graficoCargaGranalla').getContext('2d');

        new Chart(graficoCargaGranalla, {
            type: 'bar',
            data: {
                labels: ['26-ene', '19-ene', '12-ene', '5-ene'],
                datasets: [{
                        label: 'Carga 1',
                        data: [500, 500, 500, 1500],
                        backgroundColor: 'rgba(54, 162, 235, 0.7)', // azul claro
                        barThickness: 6, // 👈 MÁS DELGADA
                        datalabels: {
                            align: 'end',
                            anchor: 'end'
                        }
                    },
                    {
                        label: 'Carga 2',
                        data: [100, 500, 1000, 0],
                        backgroundColor: 'rgba(54, 162, 235, 1)', // azul oscuro
                        barThickness: 6, // 👈 MÁS DELGADA
                        datalabels: {
                            align: 'start',
                            anchor: 'start'
                        }
                    }
                ]
            },
            options: {
                indexAxis: 'y', // 👈 HORIZONTAL
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        color: '#000',
                        // text: 'CG02 Carga de Granalla',
                        text: 'CG02 Historico Carga de Granalla',
                        font: {
                            color: '#000',
                            size: 18
                        }
                    },
                    datalabels: {
                        color: '#000',
                        font: {
                            weight: 'bold',
                            size: 12
                        },
                        formatter: (value) => value !== 0 ? value.toLocaleString() : ''
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: true // 👈 Oculta las líneas horizontales
                        },
                        stacked: true,
                        title: {

                            display: false,
                            text: 'Cantidad (kg)'
                        }
                    },
                    y: {
                        grid: {
                            display: false // 👈 Oculta las líneas horizontales
                        },
                        stacked: true
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    </script>

</section>