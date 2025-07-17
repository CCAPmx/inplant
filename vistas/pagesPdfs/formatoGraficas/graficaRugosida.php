<section class="grafica_grano mt-2">






    <!-- <div id="grafico-container"> -->
    <!-- <div id="texto-centro">GRAFICO 1</div> -->
    <canvas id="graficoRugosidad" width="600" height="400"></canvas>
    <!-- </div> -->
    <script>
        function graficaRugosidad_G2(data, nombre_maquina) {
            console.log("Respuesta recibida grafica 2:", data);
            console.log("Nombre de la máquina:", nombre_maquina);

            const graficoRugosidad = document.getElementById('graficoRugosidad').getContext('2d');

            // Procesar las fechas y valores de rugosidad
            const labels = data.G2.map(item => {
                const fecha = new Date(item.fecha);
                return fecha.toLocaleDateString('es-MX', {
                    day: '2-digit',
                    month: 'short'
                }); // Ej: 19-jun
            });

            const rugosidadReal = data.G2.map(item => item.rugosidad !== null ? parseFloat(item.rugosidad) : 0);

            // Crear la gráfica
            new Chart(graficoRugosidad, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Rugosidad ',
                            data: rugosidadReal,
                            borderColor: 'rgba(54, 162, 235, 0.8)', // Azul pálido más oscuro
                            backgroundColor: 'rgba(54, 162, 235, 0.8)',
                            fill: false,
                            tension: 0.3,
                            pointRadius: 0, // Sin nodos
                            pointHoverRadius: 0,
                            pointBorderWidth: 0
                        },
                        // {
                        //     label: 'Límite Máximo',
                        //     data: rugosidadReal.map(value => 1.0), // Línea constante en 1.0
                        //     borderColor: 'red',
                        //     backgroundColor: 'red',
                        //     fill: false,
                        //     tension: 0.1,
                        //     pointRadius: 0,
                        //     pointHoverRadius: 0,
                        //     borderDash: [5, 5], // Línea punteada
                        //     pointBorderWidth: 0
                        // }
                    ]
                },
                options: {
                    plugins: {
                        title: {
                            display: true,
                            color: '#000',
                            text: `${nombre_maquina} - Rugosidad`,
                            font: {
                                size: 18
                            }
                        },
                        legend: {
                            display: true
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
                                display: true
                            },

                            beginAtZero: true,
                            max: 3.5,
                            title: {
                                display: true,
                                text: 'Ra (µm)'
                            },
                            title: {
                                display: false
                            },
                            ticks: {
                                color: '#333',
                                // callback: (value) => `${value} Kg` // ✅ Muestra 84 cm, 100 cm, etc. en el eje Y
                            },


                        },
                        x: {
                            grid: {
                                display: false
                            },
                            title: {
                                display: false
                            },
                            ticks: {
                                color: '#333',
                                maxRotation: 90,
                                minRotation: 45
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });
        }
    </script>


</section>