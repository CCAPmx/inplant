function validarSesion() {
    // Realiza la solicitud con fetch
    fetch('modelos/validateSession.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la solicitud');
            }
            return response.json(); // Convierte la respuesta a JSON
        })
        .then(data => {
            console.log(data);                 
            if ( data != 0 ){

                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Session desabilitada",
                    showConfirmButton: false,
                    timer: 1000,
                  });

                window.location.href = "ingreso";
            } 
        })
        .catch(error => {
            console.error('Hubo un problema con la solicitud:', error);
        });

}


setInterval(validarSesion, 60000); // 60000 ms = 1 minuto