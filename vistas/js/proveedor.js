$(document).ready(function () {
    let tbprov = $("#tbprov").DataTable({
        responsive: true,
        paging      : true,
        retrieve: true,
        pageLength  : 10,
        lengthChange: false,
        dom: "Bfrtip",
        ordering    : true,
        serverSide	: false,
        fixedHeader : true,
        orderCellsTop: true,
        info		: true,
        select      : false,
        stateSave	: false, 
        order       : [ [ 0, 'asc' ] ],	
        buttons: [

            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i>',
                title: 'REPORTE DE REFERENCIAS ',
                filename: 'REFERENCIAS',
                titleAttr: 'Excel'
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i>',
                orientation: 'portrait',
                pageSize: 'letter',
                title: 'REPORTE DE REFERENCIAS ',
                filename: 'REFERENCIAS',
                titleAttr: 'PDF'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i>',
                titleAttr: 'Imprimir'
              },
              'pageLength'
              
        ],
        language : {
            processing:     "Procesando...",
            zeroRecords:    "No se encontraron resultados",
            emptyTable:     "Ningún dato disponible en esta tabla",
            info:           "Mostrando _START_ al _END_ de _TOTAL_ registros",
            infoEmpty:      "No hay registros disponibles",
            infoFiltered:   "(filtrado de un total de _MAX_ registros)",
            infoPostFix:    "",
            search:         "Buscar:",
            url:            "",
            infoThousands:  ",",
            loadingRecords: "Cargando...",
            oPaginate: {
                   sFirst : "Primero",
                   sLast  : "Último",
                   sNext  : "<span class='fa fa-chevron-right fa-w-10'></span>",
                   sPrevious : "<span class='fa fa-chevron-left fa-w-10'></span>"
               },
            select: {
                rows: "" 
            },
            searchBuilder: {
                add: 'Agregar Filtro',
                condition: 'Operador',
                clearAll: 'Limpiar',
                delete: 'Borrar',
                deleteTitle: 'Borrar Titulo',
                data: 'Columna',
                left: 'Izquierda',
                leftTitle: 'Titulo Izquierdo',
                logicAnd: 'And',
                logicOr: 'or',
                right: 'Derecho',
                rightTitle: 'Titulo Derecho',
                title: {
                    0: '',
                    _: 'Filtros (%d)'
                },
                value: 'Opción',
                valueJoiner: 'et',
                conditions :{
                    string: {
                        contains: 'Contiene',
                        empty: 'Vacío',
                        endsWith: 'Termina con',
                        equals: 'Igual a',
                        not: 'Diferente de',
                        notContains: 'No Contiene',
                        notEmpty: 'No Vacío',
                        notEndsWith: 'No Termina con',
                        notStartsWith: 'No Inicia con',
                        startsWith: 'Inicia con'
                    },
                    number: {
                        equals: 'Igual a',
                        not: 'Diferente de',
                        gt: 'Mayor a',
                        gte: 'Mayor o igual a',
                        lt: 'Menor a',
                        lte: 'Menor o igual a',
                        between: 'Entre',
                        notBetween: 'No entre',
                        empty: 'Vacío',
                        notEmpty: 'No vacío'
                    },
                    date: {
                        before: 'Antes',
                        after: 'Después',
                        equals: 'Igual a',
                        not: 'Diferente de',
                        between: 'Entre',
                        notBetween: 'No entre',
                        empty: 'Vacío',
                        notEmpty: 'No vacío'
                    },
                    moment: {
                        before: 'Antes',
                        after: 'Después',
                        equals: 'Igual a',
                        not: 'Diferente de',
                        between: 'Entre',
                        notBetween: 'No entre',
                        empty: 'Vacío',
                        notEmpty: 'No vacío'
                    }
                }
            }
        },
       "ajax": {
           "method": "POST",
           "url": "ajax/tableproveedor.ajax.php"
       
       },
       "columnDefs": [{
        "targets": -1,
        "data": null,
        "defaultContent": '<div class="btn-group" style="margin: auto; display: flex;flex-direction: row;justify-content: center;" ><button class="btn btn-warning btn-xs BtnMod" Idprov data-toggle="modal" data-target="#modalEditarProv" style="margin-right:10px;"><i class="fas fa-pen"></i></button><button class="btn btn-danger btn-xs BtnEli" Idprov><i class="fas fa-times" aria-hidden="true"></i></button></div>'
  
  
      }]
    });
   
});