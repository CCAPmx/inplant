<section class="grafica_grano mt-2">






    <!-- <div id="grafico-container"> -->
    <!-- <div id="texto-centro">GRAFICO 1</div> -->
    <canvas id="graficoCargaGranallaSemana" width="600" height="400"></canvas>
    <!-- </div> -->
    <script>
        function graficoCargaGranallaSemana_G6(data, nombre_maquina) {
            const ctx = document.getElementById('graficoCargaGranallaSemana').getContext('2d');

            console.log("Datos recibidos para Carga Granalla Semana:", data);



            if (!Array.isArray(data) || data.length === 0) {
                console.warn("⚠️ No hay datos para la gráfica de Carga Granalla Semana.");

                // Limpia el canvas (opcional)
                ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);

                // Muestra mensaje en el canvas (opcional)
                ctx.font = "16px Arial";
                ctx.fillStyle = "#999";
                ctx.textAlign = "center";
                ctx.fillText("Sin datos disponibles", ctx.canvas.width / 2, ctx.canvas.height / 2);
                return;
            }

            // Prepara las etiquetas en formato dd-mmm (ej: 20-jun)
            const labels = data.map(item => {
                const fecha = new Date(item.dia);
                return fecha.toLocaleDateString('es-MX', {
                    day: '2-digit',
                    month: 'short'
                });
            });

            // Datos de carga (conversión a número, 0 si es null)
            const cargas = data.map(item => item.carga !== null ? parseFloat(item.carga) : 0);

            new Chart(ctx, {
                type: 'bar', // 👈 Barras verticales
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Kg de Granalla',
                        data: cargas,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)', // Azul pálido
                        barThickness: 20 // Controla el grosor de las barras
                    }]
                },
                options: {
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
                            text: ` ${nombre_maquina} - Carga de Granalla Por Día`,
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
                            formatter: value => `${value.toLocaleString()} `
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
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: '#444',
                                callback: (value) => `${value} Kg`,
                                font: {
                                    size: 12
                                }
                            },
                            grid: {
                                display: true
                            },
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });
        }
    </script>

</section>