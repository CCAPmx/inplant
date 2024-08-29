$(document).ready(function () {
	$('#tablaVisitas').bootstrapTable({
        sortable: true,
        sortOrder: 'asc',
        sortName: 'zzHcreo' // El campo por el cual quieres ordenar inicialmente
    });
  $("#tablaVisitas").css("visibility", "visible");

//   setInterval(function () {
//     $("#tablaVisitas").bootstrapTable("refresh"); // Recargar la tabla
// 	console.log("Cargando datos de la tabla");
//   }, 10000); // 300000 ms = 5 minutos

  // Refrescar la tabla cuando se cierra el modal de detalles de la visita
  $("#visitaDetailModal").on("hidden.bs.modal", function () {
    $("#tablaVisitas").bootstrapTable("refresh"); // Recargar la tabla
  });
});

$("#tablaVisitas").on("click", ".more-info", async function () {
  Swal.fire({
    title: "Cargando información...",
    allowOutsideClick: false,
    showConfirmButton: false,
    willOpen: async () => {
      Swal.showLoading();
      const pk = $(this).data("index");
      const response = await getVisitDetails(pk);
      const responseParsed = JSON.parse(response);
      const fielData = responseParsed[0].fieldData;
      const html = html4Details_v2(fielData);
      $("#visitaDetailModalBody").html("");
      $("#visitaDetailModalBody").html(html.body);
      $("#visitaDetailModalTitle").html(html.title);

      //   alert("pk" + pk);

      $("#exportpdf").data("index", pk);
      $(".updateVisit").data("record", responseParsed[0].recordId);

      // Events to change photos

      var inputElementF1 = document.querySelector('input[name="foto1"]');
      var inputElementF2 = document.querySelector('input[name="foto2"]');
      var inputElementF3 = document.querySelector('input[name="foto3"]');
      var inputElementF4 = document.querySelector('input[name="foto4"]');
      var inputElementF5 = document.querySelector('input[name="foto5"]');
      var inputElementF6 = document.querySelector('input[name="foto6"]');

      if (inputElementF1) {
        document
          .querySelector('input[name="foto1"]')
          .addEventListener("change", function () {
            previsualizarImagen(this, document.getElementById("previewPhoto1"));
          });
      }

      if (inputElementF2) {
        document
          .querySelector('input[name="foto2"]')
          .addEventListener("change", function () {
            previsualizarImagen(this, document.getElementById("previewPhoto2"));
          });
      }

      if (inputElementF3) {
        document
          .querySelector('input[name="foto3"]')
          .addEventListener("change", function () {
            previsualizarImagen(this, document.getElementById("previewPhoto3"));
          });
      }

      if (inputElementF4) {
        document
          .querySelector('input[name="foto4"]')
          .addEventListener("change", function () {
            previsualizarImagen(this, document.getElementById("previewPhoto4"));
          });
      }

      if (inputElementF5) {
        document
          .querySelector('input[name="foto5"]')
          .addEventListener("change", function () {
            previsualizarImagen(this, document.getElementById("previewPhoto5"));
          });
      }

      if (inputElementF6) {
        document
          .querySelector('input[name="foto6"]')
          .addEventListener("change", function () {
            previsualizarImagen(this, document.getElementById("previewPhoto6"));
          });
      }

      ///////
      // Obtén todas las imágenes con un determinado id (en este caso, las imágenes con id que comienza con "previewPhoto")
      var images = document.querySelectorAll('[id^="previewPhoto"]');

      // Agrega un evento clic a cada imagen para abrir el modal
      images.forEach(function (image) {
        image.addEventListener("click", function () {
          openModal(this.src);
        });
      });

      Swal.close();

      $("#visitaDetailModal").modal("toggle");

      // Refrescar la tabla cuando se cierra el modal de detalles de la visita
      $("#visitaDetailModal").on("hidden.bs.modal", function () {
        table.ajax.reload(); // Recargar la tabla
      });
    },
  });
});

$(document).on("click", "#exportpdf", async function () {
  Swal.fire({
    title: "Preparando el documento...",
    allowOutsideClick: false,
    showConfirmButton: false,
    willOpen: async () => {
      Swal.showLoading();
      document.querySelector("#closeModal").style.display = "none";
      document.querySelector("#exportpdf").style.display = "none";
      document.querySelector("#closeBottomModal").style.display = "none";
      document.querySelector(".updateVisit").style.display = "none";
      await printToPDF();
      document.querySelector("#closeModal").style.display = "inline-block";
      document.querySelector("#exportpdf").style.display = "inline-block";
      document.querySelector("#closeBottomModal").style.display =
        "inline-block";
      document.querySelector(".updateVisit").style.display = "inline-block";
      // Cierra el cargador después de que printToPDF() ha terminado
      setTimeout(() => {
        // Cierra el cargador después de un breve período de tiempo
        Swal.close();
      }, 500);
    },
  });
});
$(document).on("click", ".updateVisit", async function () {
  Swal.fire({
    title: "¿Esta seguro que quiere actualizar?",
    text: "La información será reemplazada con los nuevos cambios.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, guardar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    console.log(result);
    if (result.isConfirmed) {
      console.log("si");
      const recordId = $(this).data("record");
      console.log($(this).data());
      Swal.fire({
        title: "Preparando actualización...",
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: async () => {
          Swal.showLoading();
          try {
            const datos = await prepareDataToUpdate();
            console.log("datos", datos);
            const response = await updateVisit(datos, recordId);
            // Cierra el cargador después de un breve período de tiempo
            setTimeout(() => {
              Swal.close();
            }, 500);

            if (response.ok) {
              $("#tablaVisitas").bootstrapTable();
              $("#visitaDetailModal").modal("toggle");
              Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Your work has been saved",
                showConfirmButton: false,
                timer: 1500,
              });
            }
          } catch (error) {
            console.error(error.message);
            Swal.fire({
              icon: "error",
              title: "Error",
              text: "Hubo un error durante la actualización.",
            });
          }
        },
      });
    }
  });
});

async function prepareDataToUpdate() {
  const inputs = document
    .querySelector("#visitaDetailModalBody")
    .querySelectorAll("input, textarea");
  const datos = {};

  const compressImage = (file) => {
    return new Promise((resolve, reject) => {
      const maxSizeWithoutCompression = 700 * 1024; // 700kb
      const maxSizeForMediumCompression = 2 * 1024 * 1024; // 2mb

      if (file.size <= maxSizeWithoutCompression) {
        // Si la imagen es menor o igual a 700kb, no comprimir
        const reader = new FileReader();
        reader.onloadend = () => {
          resolve(reader.result);
        };
        reader.onerror = () => {
          reject(new Error("Error al cargar la imagen"));
        };
        reader.readAsDataURL(file);
      } else {
        let compressionQuality = 0.6; // Valor por defecto para compresión media

        if (file.size > maxSizeForMediumCompression) {
          compressionQuality = 0.4; // Si la imagen es mayor a 2mb, compresión más fuerte
        }

        new Compressor(file, {
          quality: compressionQuality,
          success(result) {
            const reader = new FileReader();
            reader.onloadend = () => {
              resolve(reader.result);
            };
            reader.onerror = () => {
              reject(new Error("Error al cargar la imagen comprimida"));
            };
            reader.readAsDataURL(result);
          },
          error(error) {
            reject(new Error("Error al comprimir la imagen: " + error.message));
          },
        });
      }
    });
  };

  const loadImagePromises = [];

  inputs.forEach((element) => {
    const nombre = element.name;
    const valor = element.value;

    if (element.type === "file") {
      if (element.files.length > 0) {
        loadImagePromises.push(
          compressImage(element.files[0])
            .then((base64Image) => {
              base64Image = base64Image.replace(
                /^data:image\/(jpg|jpeg);base64,/,
                ""
              );
              base64Image = base64Image.replace(/^data:image\/png;base64,/, "");
              datos[nombre] = base64Image;
            })
            .catch((error) => {
              console.error(error.message);
              throw error; // Propagar el error hacia arriba
            })
        );
      }
    } else {
      datos[nombre] = valor;
    }
  });

  // Esperar a que todas las promesas se resuelvan
  await Promise.all(loadImagePromises);

  return datos;
}

// Función para abrir el modal con la imagen clicada
function openModal(imageSrc) {
  // Verifica si la imagen es 'image-not-found.jpg' antes de abrir el modal
  if (imageSrc.includes("image-not-found.jpg")) {
    return;
  }

  var modal = document.getElementById("imageModal");
  var modalImg = document.getElementById("modalImage");

  modal.style.display = "block";
  modalImg.src = imageSrc;
}

// Función para cerrar el modal
function closeModal() {
  var modal = document.getElementById("imageModal");
  modal.style.display = "none";
}

// Función para previsualizar la imagen seleccionada
function previsualizarImagen(input, imagenPrevisualizacion) {
  const archivo = input.files[0];

  if (archivo) {
    const lector = new FileReader();

    lector.onload = function (e) {
      imagenPrevisualizacion.src = e.target.result;
    };

    lector.readAsDataURL(archivo);
  }
}

let printToPDF = function () {
  const iframe = document.createElement("iframe");
  document.body.appendChild(iframe);
  iframe.style.width = "100%";
  iframe.style.height = "100vh";
  iframe.style.position = "absolute";
  iframe.style.left = "-10000px"; // Ocultar el iframe visualmente

  iframe.onload = function () {
    // Ajustar el tamaño del canvas cuando se cargue el contenido del iframe
    const adjustCanvasSize = () => {
      const canvas = iframe.contentWindow.document.getElementById("myChart");
      if (canvas) {
        const container = canvas.parentElement;
        const desiredWidth = 2000; // Ancho deseado para el canvas
        const desiredHeight = 1000; // Alto deseado para el canvas

        canvas.style.width = desiredWidth + "px";
        canvas.style.height = desiredHeight + "px";
        canvas.width = desiredWidth;
        canvas.height = desiredHeight;

        // console.log(canvas.width, canvas.height);
      }
    };
    adjustCanvasSize();

    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF({
      orientation: "portrait",
      unit: "mm",
      format: "a4",
    });

    const margin = 10; // Márgenes laterales de 10mm
    const pageWidth = pdf.internal.pageSize.getWidth() - 2 * margin;
    const pageHeight = pdf.internal.pageSize.getHeight() - margin; // Ajuste para margen superior

    const content = iframe.contentWindow.document.body;
    const children = Array.from(content.children);
    let lastY = 5;

    const processElement = (index) => {
      if (index >= children.length) {
        // Añadir números de página
        let total = pdf.internal.getNumberOfPages();
        for (let i = 1; i <= total; i++) {
          pdf.setPage(i);
          pdf.setFontSize(10);
          let pageInfo = "Página " + i + " de " + total;
          let textWidth =
            (pdf.getStringUnitWidth(pageInfo) * pdf.internal.getFontSize()) /
            pdf.internal.scaleFactor;
          let textOffset = (pageWidth - textWidth) / 2; // Centrar el texto horizontalmente
          pdf.text(pageInfo, textOffset, pageHeight - 10); // Ajustar verticalmente cerca del fondo de la página
        }
        pdf.save("documento.pdf");
        document.body.removeChild(iframe);
        return;
      }
      const element = children[index];
      html2canvas(element, { scale: 1, useCORS: true })
        .then((canvas) => {
          const imgData = canvas.toDataURL("image/png");
          const imgHeight = (canvas.height * pageWidth) / canvas.width;

          try {
            if (lastY + imgHeight > pageHeight) {
              pdf.addPage();
              lastY = 5;
            }
            pdf.addImage(imgData, "JPEG", margin, lastY, pageWidth, imgHeight);
            lastY += imgHeight;
          } catch (e) {
            console.error("Error al añadir imagen al PDF:", e);
          }

          processElement(index + 1);
        })
        .catch((error) => {
          console.error("Error al capturar contenido del iframe:", error);
          processElement(index + 1);
        });
    };

    processElement(0);
  };

  // Cargar el documento HTML externo en el iframe
  iframe.src = "vistas/pagesPdfs/documento.php";
};

let printToPDF_v1 = function () {
  const iframe = document.createElement("iframe");
  iframe.style.width = "100%";
  iframe.style.height = "100vh";
  iframe.style.position = "absolute";
  iframe.style.left = "-10000px"; // Colocar fuera de la vista para evitar interfaz visual
  document.body.appendChild(iframe);

  iframe.onload = function () {
    html2canvas(iframe.contentWindow.document.body, {
      scale: 3,
      useCORS: true, // Asegúrate de que las imágenes cross-origin se carguen correctamente
    }).then((canvas) => {
      const imgData = canvas.toDataURL("image/png", 1.0);

      const { jsPDF } = window.jspdf; // Asegúrate de que jsPDF esté definido de esta manera
      const pdf = new jsPDF({
        orientation: "portrait",
        unit: "mm",
        format: "a4",
      });

      const pageWidth = pdf.internal.pageSize.getWidth();
      const pageHeight = pdf.internal.pageSize.getHeight();
      const imgWidth = canvas.width;
      const imgHeight = canvas.height;
      const imgRatio = imgWidth / imgHeight;
      const pageRatio = pageWidth / pageHeight;

      let newWidth, newHeight;

      // Ajustar la imagen para que cubra toda la página
      if (imgRatio > pageRatio) {
        newHeight = pageHeight;
        newWidth = newHeight * imgRatio;
      } else {
        newWidth = pageWidth;
        newHeight = newWidth / imgRatio;
      }

      const xOffset = (pageWidth - newWidth) / 2; // Centrar horizontalmente
      const yOffset = (pageHeight - newHeight) / 2; // Centrar verticalmente

      // Añadir la imagen al documento PDF
      pdf.addImage(imgData, "PNG", 0, 0, newWidth, newHeight);

      // pdf.addImage(imgData, "PNG", 0, 0, 210, 297);
      pdf.save("documento-externo-prueba.pdf");

      document.body.removeChild(iframe); // Limpiar después de guardar el PDF
    });
  };

  // Especifica la URL del archivo HTML externo
  iframe.src = "vistas/pagesPdfs/documento.php";
  return true;
};

let html4Details_v1 = function (fielData) {
  if (fielData.fecha) {
    // Dividir la cadena en mes, día y año
    let partesFecha = fielData.fecha.split("/");

    // Crear un objeto Date (meses en JavaScript son 0-indexados, por lo que restamos 1 al mes)
    let fechaObj = new Date(partesFecha[2], partesFecha[0] - 1, partesFecha[1]);

    // Obtener el día, mes y año con ceros a la izquierda si es necesario
    let dia = ("0" + fechaObj.getDate()).slice(-2);
    let mes = ("0" + (fechaObj.getMonth() + 1)).slice(-2);
    let año = fechaObj.getFullYear();

    // Construir la fecha formateada
    let fechaFormateada = dia + "/" + mes + "/" + año;

    // fechaFormateada ahora contiene la fecha en el formato dd/mm/yyyy
    fielData.fecha = fechaFormateada;
  } else {
    fielData.fecha = "";
  }
  const title = `	<img src="vistas/recursos/img/avatars/lersan.png" width="100">
					<div>REPORTE VISITA TÉCNICA</div>
					<img src="vistas/recursos/img/avatars/in-plant.jpeg" width="100">
					<button id="exportpdf" name="exportpdf" class="btn btn-outline-info btn-sm">
						<svg class="svg-inline--fa fa-file-pdf" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="file-pdf" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
							<path fill="currentColor" d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V304H176c-35.3 0-64 28.7-64 64V512H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128zM176 352h32c30.9 0 56 25.1 56 56s-25.1 56-56 56H192v32c0 8.8-7.2 16-16 16s-16-7.2-16-16V448 368c0-8.8 7.2-16 16-16zm32 80c13.3 0 24-10.7 24-24s-10.7-24-24-24H192v48h16zm96-80h32c26.5 0 48 21.5 48 48v64c0 26.5-21.5 48-48 48H304c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16zm32 128c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H320v96h16zm80-112c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16s-7.2 16-16 16H448v32h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H448v48c0 8.8-7.2 16-16 16s-16-7.2-16-16V432 368z"></path>
						</svg>
					</button>
					<button type="button" id="closeModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>`;

  const header = `<div class="reporte-header">
						<table class="table table-sm">
							<tbody>
								<tr>
									<td>${fielData["T16_vte_CLIENTES::Nombre"]}</td>
								</tr>
								<tr>
									<td id="nombre-maquina" data-name="${fielData["T16_vte_MAQUINAS::descripcion"]}">${fielData["T16_vte_MAQUINAS::descripcion"]}</td>
								</tr>
							</tbody>
						</table>
						<table class="table table-sm table-borderless">
							<tbody>
								<tr>
									<td>Fecha: </td>
									<td id="fecha-visita" data-date="${fielData.fecha}">${fielData.fecha}</td>
								</tr>
								<tr>
									<td>Horometro: </td>
									<td>${fielData.horometro}</td>
								</tr>
								<tr>
									<td>Stock: </td>
									<td>${fielData.stock}</td>
								</tr>
							</tbody>
						</table>
					</div>`;
  if (esDispositivoMovil()) {
    chartWidth = "50vh";
  } else {
    chartWidth = "70vh";
  }
  const body = `	<div class="reporte-body">
						<div class="row">
							<div class="col">
								<div class="chart-container" style="position: relative; width: ${chartWidth};">
									<canvas id="granulometriaChart"></canvas>
								</div>
							</div>
							<div class="col">
								<div class="tabla-turbinas table-responsive">
									<h5>Presión/Amperaje por turbina/pot</h5>
									<table class="table table-sm table-borderless">
										<tbody>
											<tr>
												<td>Turbina 1</td>
												<td>${fielData.turbina1}</td>
												<td>Turbina 7: </td>
												<td>${fielData.turbina7}</td>
											</tr>
											<tr>
												<td>Turbina 2</td>
												<td>${fielData.turbina2}</td>
												<td>Turbina 8: </td>
												<td>${fielData.turbina8}</td>
											</tr>
											<tr>
												<td>Turbina 3</td>
												<td>${fielData.turbina3}</td>
												<td>Turbina 9: </td>
												<td>${fielData.turbina9}</td>
											</tr>
												<tr>
												<td>Turbina 4</td>
												<td>${fielData.turbina4}</td>
												<td>Turbina 10: </td>
												<td>${fielData.turbina10}</td>
											</tr>
											<tr>
												<td>Turbina 5</td>
												<td>${fielData.turbina5}</td>
												<td>Turbina 11: </td>
												<td>${fielData.turbina11}</td>
											</tr>
											<tr>
												<td>Turbina 6</td>
												<td>${fielData.turbina6}</td>
												<td>Turbina 12: </td>
												<td>${fielData.turbina12}</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					`;
  const mix = `<div class="tabla-mix">
					<table class="table table-sm table-borderless">
						<tbody>
							<tr>
								<td>Mix 2.2</td>
								<td>Mix 1.7</td>
								<td>Mix 1.4</td>
								<td>Mix 1.18</td>
								<td>Mix .85</td>
								<td>Mix .6</td>
							</tr>
							<tr>
								<td>${fielData.c_2200}</td>
								<td>${fielData.c_1700}</td>
								<td>${fielData.c_1400}</td>
								<td>${fielData.c_1180}</td>
								<td>${fielData.c_850}</td>
								<td>${fielData.c_600}</td>
							</tr>
							<tr>
								<td>Mix .425</td>
								<td>Mix .3</td>
								<td>Mix .212</td>
								<td>Mix .15</td>
								<td>Mix .09</td>
								<td>Mix .5</td>
							</tr>
							<tr>
								<td>${fielData.c_425}</td>
								<td>${fielData.c_300}</td>
								<td>${fielData.c_212}</td>
								<td>${fielData.c_150}</td>
								<td>${fielData.c_09}</td>
								<td>${fielData.c_05}</td>
							</tr>
						</tbody>
					</table>
					<div>&nbsp;</div>
				</div>`;
  const fotografias = `<div class="reporte-fotografias">
							<h5>Evidencia fotografica</h5>
							<div class="row">
								<div class="col"><img width="200" src="${
                  fielData.foto1.length < 1
                    ? "vistas/recursos/img/avatars/image-not-found.jpg"
                    : `data:image/jpg;base64,${fielData.foto1}`
                }"></div>
								<div class="col"><img width="200" src="${
                  fielData.foto2.length < 1
                    ? "vistas/recursos/img/avatars/image-not-found.jpg"
                    : `data:image/jpg;base64,${fielData.foto2}`
                }"></div>
								<div class="col"><img width="200" src="${
                  fielData.foto3.length < 1
                    ? "vistas/recursos/img/avatars/image-not-found.jpg"
                    : `data:image/jpg;base64,${fielData.foto3}`
                }"></div>
							</div>
							<div class="row">
								<div class="col"><img width="200" src="${
                  fielData.foto4.length < 1
                    ? "vistas/recursos/img/avatars/image-not-found.jpg"
                    : `data:image/jpg;base64,${fielData.foto4}`
                }"></div>
								<div class="col"><img width="200" src="${
                  fielData.foto5.length < 1
                    ? "vistas/recursos/img/avatars/image-not-found.jpg"
                    : `data:image/jpg;base64,${fielData.foto5}`
                }"></div>
								<div class="col"><img width="200" src="${
                  fielData.foto6.length < 1
                    ? "vistas/recursos/img/avatars/image-not-found.jpg"
                    : `data:image/jpg;base64,${fielData.foto6}`
                }"></div>
							</div>
						</div>`;

  return {
    title: title,
    body: header + body + mix + fotografias,
  };
};

let html4Details_v2 = function (fielData) {
  if (fielData.fecha) {
    // Dividir la cadena en mes, día y año
    let partesFecha = fielData.fecha.split("/");

    // Crear un objeto Date (meses en JavaScript son 0-indexados, por lo que restamos 1 al mes)
    let fechaObj = new Date(partesFecha[2], partesFecha[0] - 1, partesFecha[1]);

    // Obtener el día, mes y año con ceros a la izquierda si es necesario
    let dia = ("0" + fechaObj.getDate()).slice(-2);
    let mes = ("0" + (fechaObj.getMonth() + 1)).slice(-2);
    let año = fechaObj.getFullYear();

    // Construir la fecha formateada
    let fechaFormateada = dia + "/" + mes + "/" + año;

    // fechaFormateada ahora contiene la fecha en el formato dd/mm/yyyy
    fielData.fecha = fechaFormateada;
  } else {
    fielData.fecha = "";
  }
  const title = `	<img src="vistas/recursos/img/avatars/lersan.png" width="100">
					<div>REPORTE VISITA TÉCNICA</div>
					<img src="vistas/recursos/img/avatars/in-plant.jpeg" width="100">
					<button id="exportpdf" name="exportpdf" class="btn btn-outline-info btn-sm">
						<svg class="svg-inline--fa fa-file-pdf" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="file-pdf" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
							<path fill="currentColor" d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V304H176c-35.3 0-64 28.7-64 64V512H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128zM176 352h32c30.9 0 56 25.1 56 56s-25.1 56-56 56H192v32c0 8.8-7.2 16-16 16s-16-7.2-16-16V448 368c0-8.8 7.2-16 16-16zm32 80c13.3 0 24-10.7 24-24s-10.7-24-24-24H192v48h16zm96-80h32c26.5 0 48 21.5 48 48v64c0 26.5-21.5 48-48 48H304c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16zm32 128c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H320v96h16zm80-112c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16s-7.2 16-16 16H448v32h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H448v48c0 8.8-7.2 16-16 16s-16-7.2-16-16V432 368z"></path>
						</svg>
					</button>
					<button type="button" id="closeModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>`;

  const secc1_bloque1 = `<div class="accordion" id="accordionPanelsStayOpenExample">
	
	<div class="accordion-item">
	  <h2 class="accordion-header">
		<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
			Información General
		</button>
	  </h2>
	  <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
		<div class="accordion-body">
		<div class="d-flex bd-highlight">
			<div class="p-2 bd-highlight">
			<span id="fecha-visita" data-date="${fielData.fecha}">
				Fecha <strong>${fielData.fecha}</strong>
			</span>
			</div>
			<div class="ms-auto p-2 bd-highlight">
				<span id="nombre-maquina" data-date="${
          fielData["T16_vte_MAQUINAS::descripcion"]
        }">
					Maquina <strong>${fielData["T16_vte_MAQUINAS::descripcion"]}</strong>
				</span>
			</div>
	  	</div>
		<div class="d-flex bd-highlight">
		  <div class="p-2 bd-highlight">
		  <span id="nombre-cliente" data-date="${fielData["T16_vte_CLIENTES::Nombre"]}">
			  Cliente <strong>${fielData["T16_vte_CLIENTES::Nombre"]}</strong>
		  </span>
		  </div>
		  <div class="ms-auto p-2 bd-highlight">
			  <span id="nombre-usuario" data-date="${fielData.nombre_usuario}">
				  Nombre_Usuario <strong>${fielData.nombre_usuario}</strong>
			  </span>
		  </div>	
		</div>
		</div>
	  </div>
	</div>

	<div class="accordion-item">
	  <h2 class="accordion-header">
		<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
		  Información Comentarios
		</button>
	  </h2>
	  <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
		<div class="accordion-body">
			<div class="row g-3">

				<div class="col-md-4">
					<label for="horometro" class="form-label">horometro</label>
					<input type="number" class="form-control" id="horometro" name="horometro" value="${
            fielData.horometro
          }">
				</div>

				<div class="col-md-4">
					<label for="stock" class="form-label">Stock</label>
					<input type="number" class="form-control" name="stock" id="stock" value="${
            fielData.stock
          }">
				</div>

				<div class="col-md-4">
					<label for="produccion" class="form-label">Producción</label>
					<input type="number" class="form-control" name="produccion" id="produccion" value="${
            fielData.produccion
          }">
				</div>

				<div class="col-md-6">
					<label for="comentario_turbinas" class="form-label">Comentario Turbinas</label>
					<textarea class="form-control" name="comentario_turbinas" id="comentario_turbinas" rows="4">${
            fielData.comentario_turbinas
          }</textarea>
				</div>

				<div class="col-md-6">
					<label for="comentario_cabina" class="form-label">Comentario Cabina</label>
					<textarea class="form-control" name="comentario_cabina" id="comentario_cabina" rows="4">${
            fielData.comentario_cabina
          }</textarea>
				</div>

				<div class="col-md-6">
					<label for="comentario_lavado" class="form-label">Comentario Lavado</label>
					<textarea class="form-control" name="comentario_lavado" id="comentario_lavado" rows="4">${
            fielData.comentario_lavado
          }</textarea>
				</div>

				<div class="col-md-6">
					<label for="comentario_colector" class="form-label">Comentario Colector</label>
					<textarea class="form-control" name="comentario_colector" id="comentario_colector" rows="4">${
            fielData.comentario_colector
          }</textarea>
				</div>

			</div>
		</div>
	  </div>
	</div>

	<div class="accordion-item">
	  <h2 class="accordion-header">
		<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
		  Información Granulometría
		</button>
	  </h2>
	  	<div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse">
			<div class="accordion-body">
				<div class="row g-3">

					<div class="col-md-3">
						<label for="polvo" class="form-label">Polvo</label>
						<input type="number" class="form-control" name="polvo" id="polvo" value="${
              fielData.polvo
            }">
					</div>

					<div class="col-md-3">
						<label for="c_05" class="form-label">c_05</label>
						<input type="number" class="form-control" name="c_05" id="c_05" value="${
              fielData.c_05
            }">
					</div>

					<div class="col-md-3">
						<label for="c_09" class="form-label">c_09</label>
						<input type="number" class="form-control" name="c_09" id="c_09" value="${
              fielData.c_09
            }">
					</div>

					<div class="col-md-3">
						<label for="c_150" class="form-label">c_150</label>
						<td><input type="number" class="form-control" name="c_150" id="c_150" value="${
              fielData.c_150
            }"></td>
					</div>

					<div class="col-md-4">
						<label for="c_212" class="form-label">c_212</label>
						<input type="number" class="form-control" name="c_212" id="c_212" value="${
              fielData.c_212
            }">
					</div>

					<div class="col-md-4">
						<label for="c_300" class="form-label">c_300</label>
						<input type="number" class="form-control" name="c_300" id="c_300" value="${
              fielData.c_300
            }">
					</div>

					<div class="col-md-4">
						<label for="c_425" class="form-label">c_425</label>
						<input type="number" class="form-control" name="c_425" id="c_425" value="${
              fielData.c_425
            }">
					</div>

					<div class="col-md-4">
						<label for="c_600" class="form-label">c_600</label>
						<input type="number" class="form-control" name="c_600" id="c_600" value="${
              fielData.c_600
            }">
					</div>

					<div class="col-md-4">
						<label for="c_850" class="form-label">c_850</label>
						<input type="number" class="form-control" name="c_850" id="c_850" value="${
              fielData.c_850
            }">
					</div>

					<div class="col-md-4">
						<label for="c_1180" class="form-label">c_1180</label>
						<input type="number" class="form-control" name="c_1180" id="c_1180" value="${
              fielData.c_1180
            }">
					</div>

					<div class="col-md-4">
						<label for="c_1400" class="form-label">c_1400</label>
						<input type="number" class="form-control" name="c_1400"  id="c_1400" value="${
              fielData.c_1400
            }">
					</div>

					<div class="col-md-4">
						<label for="c_1700" class="form-label">c_1700</label>
						<input type="number" class="form-control" name="c_1700" id="c_1700" value="${
              fielData.c_1700
            }"></td>
					</div>

					<div class="col-md-4">
						<label for="c_2200" class="form-label">c_2200</label>
						<input type="number" class="form-control" name="c_2200" id="c_2200" value="${
              fielData.c_2200
            }">
					</div>
				</div>
			</div>
	  	</div>
	</div>

	<div class="accordion-item">
	<h2 class="accordion-header">
	  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false" aria-controls="panelsStayOpen-collapseFour">
		Fotografía
	  </button>
	</h2>
		<div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse">
		  <div class="accordion-body">
			  <div class="row g-3">

				  <div class="col-md-4 text-center">
					  <label for="foto1" class="form-label">Foto 1</label>
					  <input type="file" class="form-control form-control-sm mb-2" name="foto1" accept=".jpg, .jpeg, .png">
					  <img class="img-thumbnail rounded" id="previewPhoto1" src="${
              fielData.foto1.length < 1
                ? "vistas/recursos/img/avatars/image-not-found.jpg"
                : `data:image/jpg;base64,${fielData.foto1}`
            }">
				  </div>

				  <div class="col-md-4 text-center">
						<label for="foto2" class="form-label">Foto 2</label>
						<input type="file" class="form-control form-control-sm mb-2" name="foto2" accept=".jpg, .jpeg, .png">
						<img class="img-thumbnail rounded" id="previewPhoto2" src="${
              fielData.foto2.length < 1
                ? "vistas/recursos/img/avatars/image-not-found.jpg"
                : `data:image/jpg;base64,${fielData.foto2}`
            }">
				  </div>

				  <div class="col-md-4 text-center">
				 	  <label for="foto3" class="form-label">Foto 3</label>
					  <input type="file" class="form-control form-control-sm mb-2" name="foto3" accept=".jpg, .jpeg, .png">
					  <img class="img-thumbnail rounded" id="previewPhoto3" src="${
              fielData.foto3.length < 1
                ? "vistas/recursos/img/avatars/image-not-found.jpg"
                : `data:image/jpg;base64,${fielData.foto3}`
            }">
				  </div>


				<div class="col-md-4 text-center">
				  <label for="foto4" class="form-label">Foto 4</label>
				  <input type="file" class="form-control form-control-sm mb-2" name="foto4" accept=".jpg, .jpeg, .png">
				  <img class="img-thumbnail rounded" id="previewPhoto4" src="${
            fielData.foto4.length < 1
              ? "vistas/recursos/img/avatars/image-not-found.jpg"
              : `data:image/jpg;base64,${fielData.foto4}`
          }">
			  </div>

			  <div class="col-md-4 text-center">
					<label for="foto5" class="form-label">Foto 5</label>
					<input type="file" class="form-control form-control-sm mb-2" name="foto5" accept=".jpg, .jpeg, .png">
					<img class="img-thumbnail rounded" id="previewPhoto5" src="${
            fielData.foto5.length < 1
              ? "vistas/recursos/img/avatars/image-not-found.jpg"
              : `data:image/jpg;base64,${fielData.foto5}`
          }">
			  </div>

			  <div class="col-md-4 text-center">
				   <label for="foto6" class="form-label">Foto 6</label>
				   <input type="file" class="form-control form-control-sm mb-2" name="foto6" accept=".jpg, .jpeg, .png">
				   <img class="img-thumbnail rounded" id="previewPhoto6" src="${
             fielData.foto6.length < 1
               ? "vistas/recursos/img/avatars/image-not-found.jpg"
               : `data:image/jpg;base64,${fielData.foto6}`
           }">
			  </div>

			  </div>
		  </div>
		</div>
  </div>


  <div class="accordion-item">
  <h2 class="accordion-header">
	<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapsefive" aria-expanded="false" aria-controls="panelsStayOpen-collapsefive">
	 Turbinas
	</button>
  </h2>
	  <div id="panelsStayOpen-collapsefive" class="accordion-collapse collapse">
		<div class="accordion-body">
			<div class="row g-3">

				<div class="col-md-3">
					<label for="turbina1" class="form-label">Turbina 1</label>
					<input type="number" class="form-control" name="turbina1" id="turbina1" value="${
            fielData.turbina1
          }">
				</div>

				<div class="col-md-3">
					<label for="turbina2" class="form-label">Turbina 2</label>
					<input type="number" class="form-control" name="turbina2"  id="turbina2" value="${
            fielData.turbina2
          }">
				</div>

				<div class="col-md-3">
					<label for="turbina3" class="form-label">Turbina 3</label>
					<input type="number" class="form-control" name="turbina3"  id="turbina3" value="${
            fielData.turbina3
          }">
				</div>

				<div class="col-md-3">
					<label for="turbina4" class="form-label">Turbina 4</label>
					<input type="number" class="form-control" name="turbina4" id="turbina4" value="${
            fielData.turbina4
          }">
				</div>

				<div class="col-md-3">
					<label for="turbina5" class="form-label">Turbina 5</label>
					<input type="number" class="form-control" name="turbina5" id="turbina5" value="${
            fielData.turbina5
          }">
				</div>

				<div class="col-md-3">
					<label for="turbina6" class="form-label">Turbina 6</label>
					<input type="number" class="form-control" name="turbina6" id="turbina6" value="${
            fielData.turbina6
          }">
				</div>

				<div class="col-md-3">
					<label for="turbina7" class="form-label">Turbina 7</label>
					<input type="number" class="form-control" name="turbina7" id="turbina7" value="${
            fielData.turbina7
          }">
				</div>

				<div class="col-md-3">
					<label for="turbina8" class="form-label">Turbina 8</label>
					<input type="number" class="form-control" name="turbina8" id="turbina8" value="${
            fielData.turbina8
          }">
				</div>

				<div class="col-md-3">
					<label for="turbina9" class="form-label">Turbina 9</label>
					<input type="number" class="form-control" name="turbina9" id="turbina9" value="${
            fielData.turbina9
          }">
				</div>

				<div class="col-md-3">
					<label for="turbina10" class="form-label">Turbina 10</label>
					<input type="number" class="form-control" name="turbina10" id="turbina10" value="${
            fielData.turbina10
          }">
				</div>

				<div class="col-md-3">
					<label for="turbina11" class="form-label">Turbina 11</label>
					<input type="number" class="form-control" name="turbina11" id="turbina11" value="${
            fielData.turbina11
          }">
				</div>

				<div class="col-md-3">
					<label for="turbina12" class="form-label">Turbina 12</label>
					<input type="number" class="form-control" name="turbina12" id="turbina12" value="${
            fielData.turbina12
          }">
				</div>
			</div>
		</div>
	  </div>
</div>


<div class="accordion-item">
<h2 class="accordion-header">
  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapsesix" aria-expanded="false" aria-controls="panelsStayOpen-collapsesix">
   Colector
  </button>
</h2>
	<div id="panelsStayOpen-collapsesix" class="accordion-collapse collapse">
	  <div class="accordion-body">
		  <div class="row g-3">

			  <div class="col-md-3">
				  <label for="colector_05" class="form-label">Colector_05</label>
				  <input type="number" class="form-control" name="colector_05" id="colector_05" value="${
            fielData.colector_05
          }">
			  </div>

			  <div class="col-md-3">
				  <label for="colector_09" class="form-label">Colector_09</label>
				  <input type="number" class="form-control" name="colector_09" id="colector_09" value="${
            fielData.colector_09
          }">
			  </div>

			  <div class="col-md-3">
				  <label for="colector_150" class="form-label">Colector_150</label>
				  <input type="number" class="form-control" name="colector_150" id="colector_150" value="${
            fielData.colector_150
          }">
			  </div>

			  <div class="col-md-3">
				  <label for="colector_212" class="form-label">Colector_212</label>
				  <input type="number" class="form-control" name="colector_212" id="colector_212" value="${
            fielData.colector_212
          }">
			  </div>

			  <div class="col-md-3">
				  <label for="colector_300" class="form-label">Colector_300</label>
				  <input type="number" class="form-control" name="colector_300" id="colector_300" value="${
            fielData.colector_300
          }">
			  </div>

			  <div class="col-md-3">
				  <label for="colector_425" class="form-label">Colector_425/label>
				  <input type="number" class="form-control" name="colector_425" id="colector_425" value="${
            fielData.colector_425
          }">
			  </div>

			  <div class="col-md-3">
				  <label for="colector_600" class="form-label">Colector_600</label>
				  <input type="number" class="form-control" name="colector_600" id="colector_600" value="${
            fielData.colector_600
          }">
			  </div>

			  <div class="col-md-3">
				  <label for="colector_850" class="form-label">Colector_850</label>
				  <input type="number" class="form-control" name="colector_850" id="colector_850" value="${
            fielData.colector_850
          }">
			  </div>

			  <div class="col-md-3">
				  <label for="colector_1180" class="form-label">Colector_1180</label>
				  <input type="number" class="form-control" name="colector_1180" id="colector_1180" value="${
            fielData.colector_1180
          }">
			  </div>

			  <div class="col-md-3">
				  <label for="colector_1400" class="form-label">Colector_1400</label>
				  <input type="number" class="form-control" name="colector_1400" id="colector_1400" value="${
            fielData.colector_1400
          }">
			  </div>

			  <div class="col-md-3">
				  <label for="colector_1700" class="form-label">Colector_1700</label>
				  <input type="number" class="form-control" name="colector_1700" id="colector_1700" value="${
            fielData.colector_1700
          }">
			  </div>

			  <div class="col-md-3">
				  <label for="colector_220" class="form-label">Colector_220</label>
				  <input type="number" class="form-control" name="colector_220" id="colector_220" value="${
            fielData.colector_220
          }">
			  </div>

			  <div class="d-flex justify-content-end">
			  	<div class="col-md-3">
					<label for="polvocolector" class="form-label">Polvo Colector</label>
					<input type="number" class="form-control" name="polvocolector" id="polvocolector" value="${
            fielData.polvocolector
          }">
		  		</div>
			  </div>

			 
		  </div>
	  </div>
	</div>
</div>


<div class="accordion-item">
<h2 class="accordion-header">
  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseseven" aria-expanded="false" aria-controls="panelsStayOpen-collapseseven">
   Descarte
  </button>
</h2>
	<div id="panelsStayOpen-collapseseven" class="accordion-collapse collapse">
	  <div class="accordion-body">
		  <div class="row g-3">

			  <div class="col-md-3">
				  <label for="descarte_05" class="form-label">Descarte_05</label>
				  <input type="number" class="form-control" name="descarte_05" id="descarte_05" value="${
            fielData.descarte_05
          }">
			  </div>

			  <div class="col-md-3">
				  <label for="descarte_09" class="form-label">Descarte_09</label>
				  <input type="number" class="form-control" name="descarte_09" id="descarte_09" value="${
            fielData.descarte_09
          }">
			  </div>

			  <div class="col-md-3">
				  <label for="descarte_150" class="form-label">Descarte_150</label>
				  <input type="number" class="form-control" name="descarte_150" id="descarte_150" value="${
            fielData.descarte_150
          }">
			  </div>

			  <div class="col-md-3">
				  <label for="descarte_212" class="form-label">Descarte_212</label>
				  <input type="number" class="form-control" name="descarte_212" id="descarte_212" value="${
            fielData.descarte_212
          }">
			  </div>

			  <div class="col-md-3">
				  <label for="descarte_300" class="form-label">Descarte_300</label>
				  <input type="number" class="form-control" name="descarte_300" id="descarte_300" value="${
            fielData.descarte_300
          }">
			  </div>

			  <div class="col-md-3">
				  <label for="descarte_425" class="form-label">Descarte_425/label>
				  <input type="number" class="form-control" name="descarte_425" id="descarte_425" value="${
            fielData.descarte_425
          }">
			  </div>

			  <div class="col-md-3">
				  <label for="descarte_600" class="form-label">Descarte_600</label>
				  <input type="number" class="form-control" name="descarte_600" id="descarte_600" value="${
            fielData.descarte_600
          }">
			  </div>

			  <div class="col-md-3">
				  <label for="descarte_850" class="form-label">Descarte_850</label>
				  <input type="number" class="form-control" name="descarte_850" id="descarte_850" value="${
            fielData.descarte_850
          }">
			  </div>

			  <div class="col-md-3">
				  <label for="descarte_1180" class="form-label">Descarte_1180</label>
				  <input type="number" class="form-control" name="descarte_1180" id="descarte_1180" value="${
            fielData.descarte_1180
          }">
			  </div>

			  <div class="col-md-3">
				  <label for="descarte_1400" class="form-label">Descarte_1400</label>
				  <input type="number" class="form-control" name="descarte_1400" id="descarte_1400" value="${
            fielData.descarte_1400
          }">
			  </div>

			  <div class="col-md-3">
				  <label for="descarte_1700" class="form-label">Descarte_1700</label>
				  <input type="number" class="form-control" name="descarte_1700" id="descarte_1700" value="${
            fielData.descarte_1700
          }">
			  </div>

			  <div class="col-md-3">
				  <label for="descarte_220" class="form-label">Descarte_220</label>
				  <input type="number" class="form-control" name="descarte_220" id="descarte_220" value="${
            fielData.descarte_220
          }">
			  </div>

			  
			  <div class="d-flex justify-content-end">
			  	<div class="col-md-3">
					<label for="polvodescarte" class="form-label">Polvo Descarte</label>
					<input type="number" class="form-control" name="polvodescarte" id="polvodescarte" value="${
            fielData.polvodescarte
          }">
		  		</div>
			  </div>

		  </div>
	  </div>
	</div>
</div>


  </div>`;

  const secc1_bloque1x = `<div class="reporte-body data-header">
					<table class="table table-sm table-borderless">
						<tbody>
							<tr>
								<td>Fecha</td>
								<td id="fecha-visita" data-date="${fielData.fecha}">
									<h6 style="margin: 0;">
										${fielData.fecha}
									</h6>
								</td>
							</tr>
							<!--<tr>
								<td>pk</td>
								<td><strong>${fielData.pk}</strong></td>
							</tr>
							<tr>
								<td>year_mes</td>
								<td><strong>${fielData.year_mes}</strong></td>
							</tr>
							<tr>
								<td>fkCliente</td>
								<td><strong>${fielData.fkCliente}</strong></td>
							</tr>
							<tr>
								<td>fkMaquina</td>
								<td><strong>${fielData.fkMaquina}</strong></td>
							</tr>-->
							<tr>
								<td>Cliente</td>
								<td>
									<h6 style="margin: 0;">
										${fielData["T16_vte_CLIENTES::Nombre"]}
									</h6>
								</td>
							</tr>
							<!--<tr>
								<td>porcentajecolector_600</td>
								<td><strong>${fielData.porcentajecolector_600}</strong></td>
							</tr>
							<tr>
								<td>porcentajecolector_425</td>
								<td><strong>${fielData.porcentajecolector_425}</strong></td>
							</tr>-->
						</tbody>
					</table>
					<table class="table table-sm table-borderless">
						<tbody>
							<tr>
								<td>Maquina</td>
								<td id="nombre-maquina" data-name="${fielData["T16_vte_MAQUINAS::descripcion"]}">
									<h6 style="margin: 0;">
										${fielData["T16_vte_MAQUINAS::descripcion"]}
									</h6>
								</td>
							</tr>
							<tr>
								<td>nombre_usuario</td>
								<td>
									<h6 style="margin: 0;">
										${fielData.nombre_usuario}
									</h6>
								</td>
							</tr>
							<!--<tr>
								<td>Usuario</td>
								<td><strong>${fielData.usuario}</strong></td>
							</tr>
							<tr>
								<td>porcentajecolector_cobertura</td>
								<td><strong>${fielData.porcentajecolector_cobertura}</strong></td>
							</tr>
							<tr>
								<td>porcentajedescarte_600</td>
								<td><strong>${fielData.porcentajedescarte_600}</strong></td>
							</tr>
							<tr>
								<td>porcentajedescarte_425</td>
								<td><strong>${fielData.porcentajedescarte_425}</strong></td>
							</tr>
							<tr>
								<td>porcentajedescarte_cobertura</td>
								<td><strong>${fielData.porcentajedescarte_cobertura}</strong></td>
							</tr>
							<tr>
								<td>coberturacolector</td>
								<td><strong>${fielData.coberturacolector}</strong></td>
							</tr>
							<tr>
								<td>coberturadescarte</td>
								<td><strong>${fielData.coberturadescarte}</strong></td>
							</tr>
							<tr>
								<td>porcentaje_600</td>
								<td><strong>${fielData.porcentaje_600}</strong></td>
							</tr>
							<tr>
								<td>porcentaje_425</td>
								<td><strong>${fielData.porcentaje_425}</strong></td>
							</tr>
							<tr>
								<td>porcentaje_cobertura</td>
								<td><strong>${fielData.porcentaje_cobertura}</strong></td>
							</tr>
							<tr>
								<td>cobertura</td>
								<td><strong>${fielData.cobertura}</strong></td>
							</tr>-->
						</tbody>
					</table>
				</div>`;

  const secc1_bloque2x = `<div class="reporte-body">
					<table class="table table-sm table-borderless">
						<tbody>
							<tr>
								<td>horometro</td>
								<td><input type="number" class="form-control form-control-sm" name="horometro" value="${fielData.horometro}"></td>
							</tr>
							<tr>
								<td>stock</td>
								<td><input type="number" class="form-control form-control-sm" name="stock" value="${fielData.stock}"></td>
							</tr>
							<tr>
								<td>produccion</td>
								<td><input type="number" class="form-control form-control-sm" name="produccion" value="${fielData.produccion}"></td>
							</tr>
							<tr>
								<td>comentario_turbinas</td>
								<td><textarea class="form-control form-control-sm" name="comentario_turbinas" rows="4">${fielData.comentario_turbinas}</textarea></td>
							</tr>
							<tr>
								<td>comentario_cabina</td>
								<td><textarea class="form-control form-control-sm" name="comentario_cabina" rows="4">${fielData.comentario_cabina}</textarea></td>
							</tr>
							<tr>
								<td>comentario_lavado</td>
								<td><textarea class="form-control form-control-sm" name="comentario_lavado" rows="4">${fielData.comentario_lavado}</textarea></td>
							</tr>
							<tr>
								<td>comentario_colector</td>
								<td><textarea class="form-control form-control-sm" name="comentario_colector" rows="4">${fielData.comentario_colector}</textarea></td>
							</tr>
							<tr>
								<td>polvo</td>
								<td><input type="number" class="form-control form-control-sm" name="polvo" value="${fielData.polvo}"></td>
							</tr>
						</tbody>
					</table>
					<table class="table table-sm table-borderless static">
						<tbody>
							<tr>
								<td>c_05</td>
								<td><input type="number" class="form-control form-control-sm" name="c_05" value="${fielData.c_05}"></td>
							</tr>
							<tr>
								<td>c_09</td>
								<td><input type="number" class="form-control form-control-sm" name="c_09" value="${fielData.c_09}"></td>
							</tr>
							<tr>
								<td>c_150</td>
								<td><input type="number" class="form-control form-control-sm" name="c_150" value="${fielData.c_150}"></td>
							</tr>
							<tr>
								<td>c_212</td>
								<td><input type="number" class="form-control form-control-sm" name="c_212" value="${fielData.c_212}"></td>
							</tr>
							<tr>
								<td>c_300</td>
								<td><input type="number" class="form-control form-control-sm" name="c_300" value="${fielData.c_300}"></td>
							</tr>
							<tr>
								<td>c_425</td>
								<td><input type="number" class="form-control form-control-sm" name="c_425" value="${fielData.c_425}"></td>
							</tr>
							<tr>
								<td>c_600</td>
								<td><input type="number" class="form-control form-control-sm" name="c_600" value="${fielData.c_600}"></td>
							</tr>
							<tr>
								<td>c_850</td>
								<td><input type="number" class="form-control form-control-sm" name="c_850" value="${fielData.c_850}"></td>
							</tr>
							<tr>
								<td>c_1180</td>
								<td><input type="number" class="form-control form-control-sm" name="c_1180" value="${fielData.c_1180}"></td>
							</tr>
							<tr>
								<td>c_1400</td>
								<td><input type="number" class="form-control form-control-sm" name="c_1400" value="${fielData.c_1400}"></td>
							</tr>
							<tr>
								<td>c_1700</td>
								<td><input type="number" class="form-control form-control-sm" name="c_1700" value="${fielData.c_1700}"></td>
							</tr>
							<tr>
								<td>c_2200</td>
								<td><input type="number" class="form-control form-control-sm" name="c_2200" value="${fielData.c_2200}"></td>
							</tr>
						</tbody>
					</table>
				</div>`;

  const secc2_bloque1x = `<div class="reporte-body fotografias">
				<table class="table table-sm table-borderless">
					<tbody>
						<tr>
							<td>foto 1 </td>
							<td><input type="file" class="form-control form-control-sm" name="foto1" accept=".jpg, .jpeg, .png"></td>
						</tr>
						<tr>
							<td></td>
							<td>
								<img width="200" id="previewPhoto1" src="${
                  fielData.foto1.length < 1
                    ? "vistas/recursos/img/avatars/image-not-found.jpg"
                    : `data:image/jpg;base64,${fielData.foto1}`
                }">
							</td>
						</tr>
						<tr>
							<td>foto 3 </td>
							<td><input type="file" class="form-control form-control-sm" name="foto3" accept=".jpg, .jpeg, .png"></td>
						</tr>
						<tr>
							<td></td>
							<td>
								<img width="200" id="previewPhoto3" src="${
                  fielData.foto3.length < 1
                    ? "vistas/recursos/img/avatars/image-not-found.jpg"
                    : `data:image/jpg;base64,${fielData.foto3}`
                }">
							</td>
						</tr>
						<tr>
							<td>foto 5 </td>
							<td><input type="file" class="form-control form-control-sm" name="foto5" accept=".jpg, .jpeg, .png"></td>
						</tr>
						<tr>
							<td></td>
							<td>
								<img width="200" id="previewPhoto5" src="${
                  fielData.foto5.length < 1
                    ? "vistas/recursos/img/avatars/image-not-found.jpg"
                    : `data:image/jpg;base64,${fielData.foto5}`
                }">
							</td>
						</tr>
					</tbody>
				</table>
				<table class="table table-sm table-borderless">
					<tbody>
						<tr>
							<td>foto 2 </td>
							<td><input type="file" class="form-control form-control-sm" name="foto2" accept=".jpg, .jpeg, .png"></td>
						</tr>
						<tr>
							<td></td>
							<td>
								<img width="200" id="previewPhoto2" src="${
                  fielData.foto2.length < 1
                    ? "vistas/recursos/img/avatars/image-not-found.jpg"
                    : `data:image/jpg;base64,${fielData.foto2}`
                }">
							</td>
						</tr>
						<tr>
							<td>foto 4 </td>
							<td><input type="file" class="form-control form-control-sm" name="foto4" accept=".jpg, .jpeg, .png"></td>
						</tr>
						<tr>
							<td></td>
							<td>
								<img width="200" id="previewPhoto4" src="${
                  fielData.foto4.length < 1
                    ? "vistas/recursos/img/avatars/image-not-found.jpg"
                    : `data:image/jpg;base64,${fielData.foto4}`
                }">
							</td>
						</tr>
						<tr>
							<td>foto 6 </td>
							<td><input type="file" class="form-control form-control-sm" name="foto6" accept=".jpg, .jpeg, .png"></td>
						</tr>
						<tr>
							<td></td>
							<td>
								<img width="200" id="previewPhoto6" src="${
                  fielData.foto6.length < 1
                    ? "vistas/recursos/img/avatars/image-not-found.jpg"
                    : `data:image/jpg;base64,${fielData.foto6}`
                }">
							</td>
						</tr>
					</tbody>
				</table>
			</div>`;

  const secc2_bloque2x = `<div class="reporte-body">
				<table class="table table-sm table-borderless">
					<tbody>
						<tr>
							<td>Turbina 1</td>
							<td><input type="number" class="form-control form-control-sm" name="turbina1" value="${fielData.turbina1}"></td>
						</tr>
						<tr>
							<td>Turbina 2</td>
							<td><input type="number" class="form-control form-control-sm" name="turbina2" value="${fielData.turbina2}"></td>
						</tr>
						<tr>
							<td>Turbina 3</td>
							<td><input type="number" class="form-control form-control-sm" name="turbina3" value="${fielData.turbina3}"></td>
						</tr>
						<tr>
							<td>Turbina 4</td>
							<td><input type="number" class="form-control form-control-sm" name="turbina4" value="${fielData.turbina4}"></td>
						</tr>
						<tr>
							<td>Turbina 5</td>
							<td><input type="number" class="form-control form-control-sm" name="turbina5" value="${fielData.turbina5}"></td>
						</tr>
						<tr>
							<td>Turbina 6</td>
							<td><input type="number" class="form-control form-control-sm" name="turbina6" value="${fielData.turbina6}"></td>
						</tr>
					</tbody>
				</table>
				<table class="table table-sm table-borderless">
					<tbody>
						<tr>
							<td>Turbina 7</td>
							<td><input type="number" class="form-control form-control-sm" name="turbina7" value="${fielData.turbina7}"></td>
						</tr>
						<tr>
							<td>Turbina 8</td>
							<td><input type="number" class="form-control form-control-sm" name="turbina8" value="${fielData.turbina8}"></td>
						</tr>
						<tr>
							<td>Turbina 9</td>
							<td><input type="number" class="form-control form-control-sm" name="turbina9" value="${fielData.turbina9}"></td>
						</tr>
						<tr>
							<td>Turbina 10</td>
							<td><input type="number" class="form-control form-control-sm" name="turbina10" value="${fielData.turbina10}"></td>
						</tr>
						<tr>
							<td>Turbina 11</td>
							<td><input type="number" class="form-control form-control-sm" name="turbina11" value="${fielData.turbina11}"></td>
						</tr>
						<tr>
							<td>Turbina 12</td>
							<td><input type="number" class="form-control form-control-sm" name="turbina12" value="${fielData.turbina12}"></td>
						</tr>
					</tbody>
				</table>
			</div>`;

  const secc3_bloque1x = `<div class="reporte-body">
			<table class="table table-sm table-borderless">
				<tbody>
					<tr>
						<td>colector_05</td>
						<td><input type="number" class="form-control form-control-sm" name="colector_05" value="${fielData.colector_05}"></td>
					</tr>
					<tr>
						<td>colector_09</td>
						<td><input type="number" class="form-control form-control-sm" name="colector_09" value="${fielData.colector_09}"></td>
					</tr>
					<tr>
						<td>colector_150</td>
						<td><input type="number" class="form-control form-control-sm" name="colector_150" value="${fielData.colector_150}"></td>
					</tr>
					<tr>
						<td>colector_212</td>
						<td><input type="number" class="form-control form-control-sm" name="colector_212" value="${fielData.colector_212}"></td>
					</tr>
					<tr>
						<td>colector_300</td>
						<td><input type="number" class="form-control form-control-sm" name="colector_300" value="${fielData.colector_300}"></td>
					</tr>
					<tr>
						<td>colector_425</td>
						<td><input type="number" class="form-control form-control-sm" name="colector_425" value="${fielData.colector_425}"></td>
					</tr>
					<tr>
						<td>colector_600</td>
						<td><input type="number" class="form-control form-control-sm" name="colector_600" value="${fielData.colector_600}"></td>
					</tr>
					<tr>
						<td>colector_850</td>
						<td><input type="number" class="form-control form-control-sm" name="colector_850" value="${fielData.colector_850}"></td>
					</tr>
					<tr>
						<td>colector_1180</td>
						<td><input type="number" class="form-control form-control-sm" name="colector_1180" value="${fielData.colector_1180}"></td>
					</tr>
					<tr>
						<td>colector_1400</td>
						<td><input type="number" class="form-control form-control-sm" name="colector_1400" value="${fielData.colector_1400}"></td>
					</tr>
					<tr>
						<td>colector_1700</td>
						<td><input type="number" class="form-control form-control-sm" name="colector_1700" value="${fielData.colector_1700}"></td>
					</tr>
					<tr>
						<td>colector_220</td>
						<td><input type="number" class="form-control form-control-sm" name="colector_220" value="${fielData.colector_220}"></td>
					</tr>
					<tr>
						<td>polvocolector</td>
						<td><input type="number" class="form-control form-control-sm" name="polvocolector" value="${fielData.polvocolector}"></td>
					</tr>
				</tbody>
			</table>
			<table class="table table-sm table-borderless">
				<tbody>
					<tr>
						<td>descarte_05</td>
						<td><input type="number" class="form-control form-control-sm" name="descarte_05" value="${fielData.descarte_05}"></td>
					</tr>
					<tr>
						<td>descarte_09</td>
						<td><input type="number" class="form-control form-control-sm" name="descarte_09" value="${fielData.descarte_09}"></td>
					</tr>
					<tr>
						<td>descarte_150</td>
						<td><input type="number" class="form-control form-control-sm" name="descarte_150" value="${fielData.descarte_150}"></td>
					</tr>
					<tr>
						<td>descarte_212</td>
						<td><input type="number" class="form-control form-control-sm" name="descarte_212" value="${fielData.descarte_212}"></td>
					</tr>
					<tr>
						<td>descarte_300</td>
						<td><input type="number" class="form-control form-control-sm" name="descarte_300" value="${fielData.descarte_300}"></td>
					</tr>
					<tr>
						<td>descarte_425</td>
						<td><input type="number" class="form-control form-control-sm" name="descarte_425" value="${fielData.descarte_425}"></td>
					</tr>
					<tr>
						<td>descarte_600</td>
						<td><input type="number" class="form-control form-control-sm" name="descarte_600" value="${fielData.descarte_600}"></td>
					</tr>
					<tr>
						<td>descarte_850</td>
						<td><input type="number" class="form-control form-control-sm" name="descarte_850" value="${fielData.descarte_850}"></td>
					</tr>
					<tr>
						<td>descarte_1180</td>
						<td><input type="number" class="form-control form-control-sm" name="descarte_1180" value="${fielData.descarte_1180}"></td>
					</tr>
					<tr>
						<td>descarte_1400</td>
						<td><input type="number" class="form-control form-control-sm" name="descarte_1400" value="${fielData.descarte_1400}"></td>
					</tr>
					<tr>
						<td>descarte_1700</td>
						<td><input type="number" class="form-control form-control-sm" name="descarte_1700" value="${fielData.descarte_1700}"></td>
					</tr>
					<tr>
						<td>descarte_220</td>
						<td><input type="number" class="form-control form-control-sm" name="descarte_220" value="${fielData.descarte_220}"></td>
					</tr>
					<tr>
						<td>polvodescarte</td>
						<td><input type="number" class="form-control form-control-sm" name="polvodescarte" value="${fielData.polvodescarte}"></td>
					</tr>
				</tbody>
			</table>
		</div>`;

  return {
    title: title,
    body: secc1_bloque1,
    // body: secc1_bloque1+secc1_bloque2+secc2_bloque1+secc2_bloque2+secc3_bloque1
  };
};

let getVisitDetails = async function (pk) {
  return await $.ajax({
    type: "GET",
    url: `controladores/visitas.controlador.php?action=getVisitaDetails&pk=${pk}`,
    success: function (response) {
      result = JSON.parse(response);
      if (response?.ok) {
        return result;
      } else {
        return false;
      }
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {},
  });
};

let getAllVisitsWithDetails = async function () {
  return await $.ajax({
    type: "GET",
    url: `controladores/visitas.controlador.php?action=getVisitaDetails`,
    success: function (response) {
      result = JSON.parse(response);
      if (response?.ok) {
        return result;
      } else {
        return false;
      }
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {},
  });
};
let updateVisit = async function (data, recordId) {
  const data2Send = JSON.stringify(data);
  return await $.ajax({
    type: "POST",
    url: `controladores/visitas.controlador.php`,
    data: { action: "updateVisit", data: data2Send, recordid: recordId },
    dataType: "json",
    success: function (response) {
      result = response;
      if (response?.ok) {
        return result;
      } else {
        return false;
      }
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {},
  });
};
function esDispositivoMovil() {
  return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
    navigator.userAgent
  );
}

$(document).ready(function () {
  $("#btnNuevaVisita").click(function () {
    $("#Frmusuarios").trigger("reset");
    // $(".modal-header").css("color", "#060606");
    $(".modal-title").text("Nueva Visita");
    $("#myModal").modal("show");
  });

  function mostrarLoader() {
    document.getElementById("loader").style.display = "block";
  }

  function obtenerMaq(pk) {
    $("#cbmmaquina").val(null).trigger("change");
    //   $("#cbmmaquina").select2()
    $("#cbmmaquina").empty();

    $.ajax({
      url: "modelos/obtenermaquinas.php",
      type: "POST",
      data: { pk: pk },
      dataType: "json",

      beforeSend: function (response) {
        mostrarLoader();
        // spanElement.innerText = "Buscando Información";
      },

      //  Se ejecuta cuando termino la petición
      complete: function (response) {
        // $('#exito').html('Exito...');
      },

      // se ejecuta al termino de la petición y está fue correcta
      success: function (data) {
        // console.log(data);

        if (data.length === 0) {
          $("#cbmmaquina").append(
            `<option value="Ninguno" selected="selected">sin datos</option>`
          );
        } else {
          $("#cbmmaquina").append(
            `<option value="Ninguno" selected="selected">Seleccione</option>`
          );
          for (var i = 0; i < data.length; i++) {
            $("#cbmmaquina").append(
              `<option value="${data[i].pk}">${data[i].descripcion}</option>`
            );
          }
        }

        ocultarLoader();

        // $("#cbmmaquina").append(
        //   `<option value="Ninguno"  selected="selected">Seleccione</option>`
        // );
      },
      error: function (response) {
        // window.location ="salir";
      },
    });
  }

  // Manejador de cambio para el cliente
  $("#cbmCliente").on("change", function () {
    var valorSeleccionado = this.value;
    document.getElementById("txtPkempresa_v1").value = valorSeleccionado;
    // console.log("Cliente seleccionado:", valorSeleccionado);
    obtenerMaq(valorSeleccionado);
  });

  function manejarSeleccion(valor) {
    // console.log("Has seleccionado: ", valor);
    // Aquí puedes añadir más lógica usando la variable 'valor'
  }
  // console.log("valor de pk", pk);
  // obtenerMaq(pk);
});

$(document).ready(function () {
  // Maneja el evento de clic en el botón
  $("#btnGuardarVisita").on("click", function () {
    // alert("hola");
    // Obtener los datos del formulario
    let clienteVisita = $("#cbmCliente").val();
    let maquinaVisita = $("#cbmmaquina").val();
    let fecha = $("#txtFechaVisita").val();

    // console.log(clienteVisita, maquinaVisita, fecha);

    if (clienteVisita == 0) {
      Swal.fire({
        position: "center",
        icon: "error",
        title: "se requiere seleccionar un cliente",
        showConfirmButton: false,
        timer: 1500,
      });
    }

    if (maquinaVisita.length == 0 || maquinaVisita === "Ninguno") {
      Swal.fire({
        position: "center",
        icon: "error",
        title: "se requiere seleccionar una maquina",
        showConfirmButton: false,
        timer: 1500,
      });
    }

    if (fecha.length == 0) {
      Swal.fire({
        position: "center",
        icon: "error",
        title: "se requiere seleccionar una fecha",
        showConfirmButton: false,
        timer: 1500,
      });
    }

    let url = "modelos/insertarVisita.php";

    let options = {
      method: "POST",
      headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        fkMaquina: maquinaVisita,
        fkCliente: clienteVisita,
        fecha: fecha,
      }),
    };

    ajaxParametos(url, options);
  });
});

function ajaxParametos(url, options) {
  fetch(url, options)
    .then((response) => response.json())
    .then(dataResponse)
    .catch((errorB) => console.log("error", errorB));
}

async function dataResponse(datajson) {
  console.log(datajson);
  fechaActualEvento = [];
  if (datajson.status == 200) {
    Swal.fire({
      position: "center",
      icon: "success",
      title: "Visita tecnica registrada con exito",
      showConfirmButton: false,
      timer: 1000,
    });
    document.getElementById("FrmVisitas").reset();
    // window.location.reload(true);
    $("#myModal").modal("hide");
    // Desvincular el evento para evitar múltiples llamadas
    $("#myModal").off("hidden.bs.modal");

    const id = datajson.response;
    const respuesta = await getVisitDetailsId(id);
	console.log(respuesta,id);
    const responseParsed2 = JSON.parse(respuesta);

	console.log(responseParsed2);
    const fielData2 = responseParsed2[0].fieldData;
    const html2 = html4Details_v2(fielData2);

    // console.log(respuesta);

    //   $("#visitaDetailModalBody").html("");
    //   $("#visitaDetailModalBody").html(html.body);
    //   $("#visitaDetailModalTitle").html(html.title);

    // Esperar un segundo antes de abrir el Modal 2
    setTimeout(function () {
      $("#visitaDetailModalBody").html("");
      $("#visitaDetailModalBody").html(html2.body);
      $("#visitaDetailModalTitle").html(html2.title);
      $("#visitaDetailModal").modal("toggle");
      $(".updateVisit").data("record", responseParsed2[0].recordId);
    }, 1000); // 1000 milisegundos = 1 segundo
  }
}

function formatoFecha() {
  var input = document.getElementById("txtFechaVisita").value;
  var fecha = new Date(input);
  var dia = ("0" + fecha.getDate()).slice(-2);
  var mes = ("0" + (fecha.getMonth() + 1)).slice(-2);
  var año = fecha.getFullYear();
  var fechaFormateada = mes + "/" + dia + "/" + año;
  document.getElementById("fechaFormateada").textContent = fechaFormateada;
}

document.addEventListener("DOMContentLoaded", function () {
  const fechaInput = document.getElementById("txtFechaVisita");
  const hoy = new Date();
  const unDia = 24 * 60 * 60 * 1000; // Milisegundos en un día

  // Formatear fecha como YYYY-MM-DD
  function formatearFecha(date) {
    let mes = "" + (date.getMonth() + 1),
      dia = "" + date.getDate(),
      año = date.getFullYear();

    if (mes.length < 2) mes = "0" + mes;
    if (dia.length < 2) dia = "0" + dia;

    return [año, mes, dia].join("-");
  }

  // Establecer la fecha máxima (hoy) y mínima (3 días antes)
  fechaInput.max = formatearFecha(hoy);
  fechaInput.min = formatearFecha(new Date(hoy - 3 * unDia));
  fechaInput.value = fechaInput.max; // Establece la fecha por defecto a hoy
});

function formatoFecha() {
  // Función para manejar cualquier lógica adicional cuando cambia la fecha
  const fechaSeleccionada = document.getElementById("txtFechaVisita").value;
  console.log("Fecha seleccionada:", fechaSeleccionada);
  // Aquí puedes agregar más lógica según necesites
}

let getVisitDetailsId = async function (id) {
  console.log(id);
  return await $.ajax({
    type: "GET",
    url: `controladores/visitas.controlador.php?action=getVisitaTecnicaCompletaId&id=${id}`,
    success: function (response) {
      result = JSON.parse(response);
      if (response?.ok) {
        return result;
      } else {
        return false;
      }
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {},
  });
};
