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
        function generarGraficoSilo_G4(data, nombre_maquina) {
            const ctx = document.getElementById('graficoSilo').getContext('2d');

            console.log("Datos recibidos para el gráfico de Silo:", data);

            // Validación de datos
            if (!data.G4 || !Array.isArray(data.G4) || data.G4.length === 0) {
                console.warn("⚠️ No hay datos para el gráfico de Nivel de Silo.");

                ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
                ctx.font = "16px Arial";
                ctx.fillStyle = "#999";
                ctx.textAlign = "center";
                ctx.fillText("Sin datos disponibles", ctx.canvas.width / 2, ctx.canvas.height / 2);
                return;
            }

            // Etiquetas con fechas
            const labels = data.G4.map(item => {
                const fecha = new Date(item.dia);
                return fecha.toLocaleDateString('es-MX', {
                    day: '2-digit',
                    month: 'short'
                });
            });

            // Datos de nivel 1 y nivel 2 (cms)
            const niveles1 = data.G4.map(item => item.nivel_1 !== null ? parseFloat(item.nivel_1) : 0);
            const niveles2 = data.G4.map(item => item.nivel_2 !== null ? parseFloat(item.nivel_2) : 0);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Nivel 1',
                            data: niveles1,
                            borderColor: 'steelblue',
                            backgroundColor: 'steelblue',
                            fill: false,
                            tension: 0.3,
                            pointRadius: 0,
                            pointHoverRadius: 0,
                            pointBorderWidth: 0
                        },
                        {
                            label: 'Nivel 2',
                            data: niveles2,
                            borderColor: 'orange',
                            backgroundColor: 'orange',
                            fill: false,
                            tension: 0.3,
                            pointRadius: 0,
                            pointHoverRadius: 0,
                            pointBorderWidth: 0
                        }
                    ]
                },
                options: {
                    plugins: {
                        title: {
                            display: true,
                            color: '#000',
                            text: `${nombre_maquina} - Nivel de Silo`,
                            font: {
                                size: 18
                            }
                        },
                        legend: {
                            display: true
                        },
                        datalabels: {
                            display: true,
                            color: '#000',
                            font: {
                                weight: 'bold'
                            },
                            formatter: (value) => value !== null ? `${value} ` : ''
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
                            ticks: {
                                color: '#333',
                                callback: (value) => `${value} cms`
                            },
                            grid: {
                                drawTicks: true,
                                drawBorder: true,
                                borderColor: '#000',
                                borderWidth: 1.5
                            },
                            
                            title: {
                                display: false,
                                text: 'Nivel (cm)',
                                color: '#000'
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });
        }
    </script>

</section>