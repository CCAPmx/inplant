function validarSesion() {
  // Realiza la solicitud con fetch
  fetch("modelos/validateSession.php")
    .then((response) => {
      if (!response.ok) {
        throw new Error("Error en la solicitud");
      }
      return response.json(); // Convierte la respuesta a JSON
    })
    .then((data) => {
      console.log(data);
      if (data != 0) {
        // Mostrar alerta y ejecutar cierre de sesión
        Swal.fire({
          icon: "warning",
          title: "Sesión CADUCADA",
          text: "Su sesión ha sido caducado por límite de tiempo",
          confirmButtonText: "Aceptar",
          allowOutsideClick: true,
          allowEscapeKey: true,
        }).then(() => {
            window.location.href = "ingreso";
          
        });

       
      }
    })
    .catch((error) => {
      console.error("Hubo un problema con la solicitud:", error);
    });
}

setInterval(validarSesion, 60000); // 60000 ms = 1 minuto
