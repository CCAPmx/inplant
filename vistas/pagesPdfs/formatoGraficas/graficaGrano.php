<section class="grafica_grano mt-2">






    <!-- <div id="grafico-container"> -->
    <!-- <div id="texto-centro">GRAFICO 1</div> -->
    <canvas id="graficoGrano" width="600" height="400"></canvas>
    <!-- </div> -->

    <script>
        function graficasGrano_G1(data, dataG3_b, nombre_maquina) {
            console.log("Respuesta recibida grafica 1:", data.G1);
            console.log("Respuesta recibida grafica 2 grano :", dataG3_b);

            if (!data.G1 || !Array.isArray(data.G1) || data.G1.length === 0) {
                console.warn("⚠️ No hay datos para la gráfica de % Grano.");

                const ctx = document.getElementById('graficoGrano').getContext('2d');
                ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
                ctx.font = "16px Arial";
                ctx.fillStyle = "#999";
                ctx.textAlign = "center";
                ctx.fillText("Sin datos disponibles", ctx.canvas.width / 2, ctx.canvas.height / 2);
                return;
            }

            const arrayDatos = data.G1;

            // Etiquetas de fechas
            const labels = arrayDatos.map(item => {
                const fecha = new Date(item.fecha);
                return fecha.toLocaleDateString('es-MX', {
                    day: '2-digit',
                    month: 'short'
                });
            });

            // Series reales
            const serieAzul = arrayDatos.map(item => parseFloat(item["0.600"]).toFixed(2));
            const serieRoja = arrayDatos.map(item => parseFloat(item["0.425"]).toFixed(2));

            // Obtener valores ideales de dataG3_b
            const ideal = dataG3_b[0]; // Primer elemento de tu array

            const valorIdeal425 = parseFloat(ideal.ideal_425).toFixed(2);
            const valorIdeal600 = parseFloat(ideal.ideal_600).toFixed(2);

            // Crear series horizontales con el mismo valor repetido
            const lineaIdeal425 = labels.map(() => valorIdeal425);
            const lineaIdeal600 = labels.map(() => valorIdeal600);

            const ctx = document.getElementById('graficoGrano').getContext('2d');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                            label: '0.600',
                            data: serieAzul,
                            borderColor: 'rgba(54, 162, 235, 0.8)',
                            backgroundColor: 'rgba(54, 162, 235, 0.8)',
                            fill: false,
                            tension: 0.3,
                            pointRadius: 0,
                            pointHoverRadius: 0,
                            pointStyle: 'rectRot',
                            pointBorderWidth: 1
                        },
                        {
                            label: '0.425',
                            data: serieRoja,
                            borderColor: 'red',
                            backgroundColor: 'red',
                            fill: false,
                            tension: 0.3,
                            pointRadius: 0,
                            pointHoverRadius: 0,
                            pointStyle: 'rectRot',
                            pointBorderWidth: 1
                        },
                        // Línea ideal 425 (rojo pálido)
                        {
                            label: 'Ideal 0.425',
                            data: lineaIdeal425,
                            borderColor: 'rgba(255, 99, 132, 0.3)',
                            // borderDash: [5, 5],
                            pointRadius: 0,
                            fill: false,
                            tension: 0,
                            datalabels: {
                                display: false
                            }
                        },
                        // Línea ideal 600 (azul pálido)
                        {
                            label: 'Ideal 0.600',
                            data: lineaIdeal600,
                            borderColor: 'rgba(54, 162, 235, 0.3)',
                            // borderDash: [5, 5],
                            pointRadius: 0,
                            fill: false,
                            tension: 0,
                            datalabels: {
                                display: false
                            }
                        }
                    ]
                },
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: nombre_maquina + ' % Grano',
                            font: {
                                size: 18
                            },
                            color: '#000'
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
                            formatter: (value) => value !== null ? `${parseFloat(value).toFixed(2)}` : ''
                        }
                    },
                    scales: {
                        y: {
                            ticks: {
                                color: '#333',
                                callback: (value) => value + '%'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#333',
                                maxRotation: 45,
                                minRotation: 45,
                                font: {
                                    size: 12
                                }
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });
        }
    </script>


</section>