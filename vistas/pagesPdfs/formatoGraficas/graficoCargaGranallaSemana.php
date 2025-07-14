<section class="grafica_grano mt-2">




   

    <!-- <div id="grafico-container"> -->
    <!-- <div id="texto-centro">GRAFICO 1</div> -->
    <canvas id="graficoCargaGranallaSemana" width="600" height="400"></canvas>
    <!-- </div> -->
    <script>
        const graficoCargaGranallaSemana = document.getElementById('graficoCargaGranallaSemana').getContext('2d');

        new Chart(graficoCargaGranallaSemana, {
            type: 'bar',
            data: {
                labels: ['Semana 6', 'Semana 5', 'Semana 4', 'Semana 3', 'Semana 2', 'Semana 1'],
                datasets: [{
                    label: 'Kg de Granalla',
                    data: [1000, 1000, 1000, 300, 1000, 1000],
                    backgroundColor: 'rgba(0, 123, 255, 0.6)', // Azul Bootstrap transparente
                    borderColor: 'rgba(0, 123, 255, 1)', // Azul sólido
                    borderWidth: 1,
                    barThickness: 12, // Delgadez de la barra
                    borderRadius: 4 // Bordes redondeados (Chart.js 4+)
                }]
            },
            options: {
                indexAxis: 'y', // Barras horizontales
                responsive: true,
                layout: {
                    padding: {
                        top: 10,
                        bottom: 10,
                        left: 10,
                        right: 10
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Carga de Granalla Kg Por Semana',
                        font: {
                            size: 20,
                            weight: 'bold'
                        },
                        color: '#333'
                    },
                    legend: {
                        display: false
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'end',
                        color: '#000',
                        font: {
                            size: 12,
                            weight: 'bold'
                        },
                        formatter: value => `${value.toLocaleString()} kg`
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            color: '#444',
                            font: {
                                size: 11
                            }
                        },
                        grid: {
                            color: '#ddd'
                        },
                        title: {
                            display: false,
                            text: 'Kilogramos',
                            color: '#000'
                        }
                    },
                    y: {
                        ticks: {
                            color: '#444',
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    </script>

</section>