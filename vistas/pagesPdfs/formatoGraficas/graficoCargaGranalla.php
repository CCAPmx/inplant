<section class="grafica_grano mt-2">






    <!-- <div id="grafico-container"> -->
    <!-- <div id="texto-centro">GRAFICO 1</div> -->
    <canvas id="graficoCargaGranalla" width="600" height="400"></canvas>
    <!-- </div> -->
    <script>
        function graficoCargaGranalla_G5(data, nombre_maquina) {
            const ctx = document.getElementById('graficoCargaGranalla').getContext('2d');

            console.log("Datos recibidos para el gráfico de Carga Granalla:", data);

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


            // Prepara las etiquetas y los valores
            const labels = data.map(item => `Semana ${item.semana}`);
            const carga = data.map(item => item.carga !== null ? parseFloat(item.carga) : 0);

            new Chart(ctx, {
                type: 'bar', // 👈 Barras verticales por defecto
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Carga (kg)',
                        data: carga,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)', // Azul pálido
                        barThickness: 20 // Controla el grosor de las barras
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            color: '#000',
                            text: ` ${nombre_maquina} - Carga de Granalla `,
                            font: {
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
                                display: false // ❌ No mostrar líneas verticales
                            },
                            ticks: {
                                color: '#333',
                                // callback: (value) => `${value} Kg` // ✅ Muestra 84 cm, 100 cm, etc. en el eje Y
                            },
                        },
                        y: {
                            grid: {
                                display: true // ✅ Mostrar líneas horizontales
                            },
                            ticks: {
                                color: '#333',
                                callback: (value) => `${value} Kg` // ✅ Muestra 84 cm, 100 cm, etc. en el eje Y
                            },
                            beginAtZero: true
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });
        }
    </script>

</section>