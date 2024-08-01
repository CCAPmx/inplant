$(document).ready(function () {
    $('#cbmNotificacion').select2({
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $('#myModal')
    });

    obtenerCombonotificacion();
   
});



  function obtenerCombonotificacion() {
    $.ajax({
      url: "ajax/notificacion.ajax.php",
      type: "POST",
      data: {
        Combo: 1
      },
      datatype: "json",
      success: function (data) {
       
        $("#cbmNotificacion").append(
          '<option value=0 selected="selected">Seleccione Tipo de Notificación</option>'
        );
        var obj = JSON.parse(data);
        obj.forEach(function (data, index) {
          $("#cbmNotificacion").append(
            "<option value=" + data.id + ">" + data.text + "</option>"
          );
        });
      },
      error: function (data) {
        // alert("Error Centro");
      },
    });
  }