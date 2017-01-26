<script>
	$(document).ready(function(argument) {
		$('#TbCatalogo').DataTable({
            "info":    false,
            "bLengthChange": false,
            "lengthMenu": [[10,20,32,100,-1], [10,20,32,100,"Todo"]],
            "language": {
                "paginate": {
                    "first":      "Primera",
                    "last":       "Última ",
                    "next":       "Siguiente",
                    "previous":   "Anterior"
                },
                "lengthMenu":"MOSTRAR _MENU_",
                "emptyTable": "No hay datos disponibles en la tabla",
                "search":     "<i class='material-icons'>search</i>" 
            }
        });
        $('#TbDetalleFactura').DataTable({
            "info":    false,
            "bLengthChange": false,
            "lengthMenu": [[10,20,32,100,-1], [10,20,32,100,"Todo"]],
            "language": {
                "paginate": {
                    "first":      "Primera",
                    "last":       "Última ",
                    "next":       "Siguiente",
                    "previous":   "Anterior"
                },
                "lengthMenu":"MOSTRAR _MENU_",
                "emptyTable": "No hay datos disponibles en la tabla",
                "search":     "<i class='material-icons'>search</i>" 
            }
        });
		$('#searchFactura').on( 'keyup', function () {
			var table = $('#TbCatalogo').DataTable();
			table.search(this.value).draw();
		});
	});
    
    $('#estadoCuenta').click(function(){//funcion para filtrar el estado de cuenta del cliente
        $('#TotalEstado').text(0+" Pts");
        var Fecha1 = $('#CXCfecha1').val();
        var Fecha2 = $('#CXCfecha2').val();
        limpiarTabla(TbCatalogo);
        $('#loadCuenta').show();
        $('#TbCatalogo').DataTable({
                "order": [[ 1, "desc" ]],
                "ajax":{
                "url": "buscarEstadoCuenta",
                "data": function ( d ) {
                        d.fecha1 = Fecha1;
                        d.fecha2 = Fecha2;
                    }
                },
                "info":    false,
                "bPaginate": false,
                "paging": false,
                "pagingType": "full_numbers",
                "lengthMenu": [[10, -1], [10, "Todo"]],
                "language": {
                    "emptyTable": "No hay datos disponibles en la tabla",
                    "lengthMenu": '_MENU_ ',
                    "search": '<i class=" material-icons">search</i>',
                    "loadingRecords": "Cargando...",
                    "paginate": {
                        "first": "Primera",
                        "last": "Última ",
                        "next":       "Siguiente",
                        "previous":   "Anterior"
                    }
                },
               columns: [
                    { "data": "FACTURA" },
                    { "data": "FECHA" },
                    { "data": "PUNTOS" },
                    { "data": "APLICADOS" },
                    { "data": "DISPONIBLE" }
              ]
            });
            $('#TbCatalogo').on( 'init.dt', function () {
                $('#loadCuenta').hide();
                var totalAcumulado=0;
                    obj = $('#TbCatalogo').DataTable();
                    obj.rows().data().each( function (index,value) {
                        totalAcumulado += parseInt(obj.row(value).data().DISPONIBLE);
                    });
                $('#TotalEstado').text(totalAcumulado+" Pts.");
            }).dataTable();
    });

	function detalleFactura(factura) {
		$('#modalDetalleFact').openModal();
		$('#loadIMG').show();
		$('#codFactura').text(factura);
		limpiarTabla(TbDetalleFactura);
		$('#TbDetalleFactura').DataTable({
                "order": [[ 1, "desc" ]],
                ajax: "detallefacturas/"+ factura,
                "info":    false,
                "bPaginate": false,
                "paging": false,
                "pagingType": "full_numbers",
                "lengthMenu": [[10, -1], [10, "Todo"]],
                "language": {
                    "emptyTable": "No hay datos disponibles en la tabla",
                    "lengthMenu": '_MENU_ ',
                    "search": '<i class=" material-icons">search</i>',
                    "loadingRecords": "cargando...",
                    "paginate": {
                        "first": "Primera",
                        "last": "Última ",
                        "next":       "Siguiente",
                        "previous":   "Anterior"
                    }
                },
               columns: [
                    { "data": "ARTICULO" },
                    { "data": "DESCRIPCION" },
                    { "data": "CANTIDAD" },
                    { "data": "PUNTOS" },
                    { "data": "TOTAL" }
              ]
            });
            $('#TbDetalleFactura').on( 'init.dt', function () {
                $('#TbDetalleFactura').show();
                $('#loadIMG').hide();
            }).dataTable();
		
	}
    function generar_reporte_pdf () {
        $('#frmEstadoCuenta').submit();
    }
	function limpiarTabla (idTabla) {
        idTabla = $(idTabla).DataTable();
        idTabla.destroy();
        idTabla.clear();
        idTabla.draw();
}
</script>