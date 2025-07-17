<section class="grafica_grano mt-2">






    <!-- <div id="grafico-container"> -->
    <!-- <div id="texto-centro">GRAFICO 1</div> -->
    <canvas id="graficoMix" width="600" height="400"></canvas>
    <!-- </div> -->
    <script>
        function graficoMixActual_G3(data, data2, nombre_maquina) {
            console.log("Datos recibidos para el gráfico de Mix Actual 1:", data);
            console.log("Datos recibidos para el gráfico de Mix Actual 2:", data2);

            const ctx = document.getElementById('graficoMix').getContext('2d');

            // Validación de datos
            if (!Array.isArray(data) || data.length === 0 || !Array.isArray(data2) || data2.length === 0) {
                console.warn("⚠️ No hay datos para el gráfico de Mix Actual.");

                ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
                ctx.font = "16px Arial";
                ctx.fillStyle = "#999";
                ctx.textAlign = "center";
                ctx.fillText("Sin datos disponibles", ctx.canvas.width / 2, ctx.canvas.height / 2);
                return;
            }

            // Prepara etiquetas y orden de tamices (de mayor a menor)
            const tamices = ["2.200", "1.700", "1.400", "1.180", "0.850", "0.600", "0.425", "0.300", "0.212", "0.150", "0.09", "0.05"];

            // Mapea data real (azul)
            const realData = tamices.map(tamiz => data[0][tamiz] ? parseFloat(data[0][tamiz]) / 100 : 0);

            // Mapea data ideal (rojo)
            const idealData = tamices.map(tamiz => {
                const key = "ideal_" + tamiz.replace('.', '').replace('0', '0'); // Ej: ideal_05
                return data2[0][key] ? parseFloat(data2[0][key]) / 100 : 0;
            });

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: tamices,
                    datasets: [{
                            label: 'Real',
                            data: realData,
                            borderColor: 'rgba(54, 162, 235, 0.8)',
                            backgroundColor: 'rgba(54, 162, 235, 0.8)',
                            pointRadius: 0,
                            pointHoverRadius: 0,
                            fill: false,
                            tension: 0.4,
                            pointBorderWidth: 2
                        },
                        {
                            label: 'Ideal',
                            data: idealData,
                            borderColor: 'red',
                            backgroundColor: 'red',
                            fill: false,
                            tension: 0.4,
                            pointRadius: 0,
                            pointHoverRadius: 0,
                            pointBorderWidth: 2
                        }
                    ]
                },
                options: {
                    plugins: {
                        title: {
                            display: true,
                            color: '#000',
                            text: `${nombre_maquina} - Mix Actual`,
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
                            formatter: value => (value !== null ? `${(value * 100).toFixed(1)}` : '')
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 0.6,
                            grid: {
                                display: true
                            },
                            title: {
                                display: false
                            },
                             ticks: {
                                color: '#333',
                                callback: (value) => `${value} %` // ✅ Muestra 84 cm, 100 cm, etc. en el eje 
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
                                // callback: (value) => `${value} Kg` // ✅ Muestra 84 cm, 100 cm, etc. en el eje Y
                            },
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });
        }
    </script>



</section>