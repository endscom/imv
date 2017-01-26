<script>
	$(document).ready(function () {
		var rutaGlobal = "";

        $('#searchReporte').on( 'keyup', function () {
            var table = $('#tblDetalleReportes').DataTable();
            table.search(this.value).draw();
        });

		$('#generarCtaXcte').click(function(){		
			var idCliente = $('#ListCliente').val();
            var Fecha1 = $('#CXCfecha1').val();
            var Fecha2 = $('#CXCfecha2').val();
            $('#CXCdetallefecha1').val(Fecha1);
            $('#CXCdetallefecha2').val(Fecha2);
            $('#CXCdetalleCodigo').val($('#ListCliente option:selected').text());
            if (idCliente==null) {mensaje("SELECCIONE UN CLIENTE","error");}
            else{
        	$('#CtaXcte').openModal();
            limpiarTabla(tblcuentaXcliente);
        	$('#tblcuentaXcliente').DataTable({
                "order": [[ 1, "desc" ]],
                "ajax":{
                "url": "cuentaXcliente",
                "data": function ( d ) {
                        d.codigo = idCliente;
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
                "dom": 'T<"clear">lfrtip',
                "tableTools": {
                    "sSwfPath": "<?php echo base_url(); ?>assets/data/swf/copy_csv_xls_pdf.swf",
                },
               columns: [
                    { "data": "FACTURA" },
                    { "data": "FECHA" },
                    { "data": "PUNTOS" },
                    { "data": "APLICADOS" },
                    { "data": "DISPONIBLE" }
              ]
            });
                    $.ajax({
                        url: "datosCliente/"+idCliente,
                        type: "GET",
                        dataType: "json",
                        contentType: false,
                        processData: false,
                        success: function(datos)
                        {      
                            $.each( datos, function( key, value ) {
                                $('#CXCdetalleRUC').text(value.RUC);
                                $('#CXCdetalleDIR').text(value.DIRECCION);
                            });
                        }
                    });
                $('#tblcuentaXcliente').on( 'init.dt', function () {
                    var totalAcumulado=0;
                    obj = $('#tblcuentaXcliente').DataTable();
                    obj.rows().data().each( function (index,value) {
                        totalAcumulado += parseInt(obj.row(value).data().DISPONIBLE);
                    });
                    $('#CXCdetalleTotal').text(totalAcumulado);
                    
                }).dataTable();
            }
    	});
        
        
        function limpiarTabla (idTabla) {
                idTabla = $(idTabla).DataTable();
                idTabla.destroy();
                idTabla.clear();
                idTabla.draw();
        }
});
        function PrintPDF(targetURL){
            var a = document.createElement('a');
            a.target = '_blank';
            var idCliente = $('#ListCliente').val();
                Fecha1 = ($('#CXCfecha1').val()=="") ? "null" : $('#CXCfecha1').val()
                Fecha2 = ($('#CXCfecha2').val()=="") ? "null" : $('#CXCfecha2').val()
            switch(targetURL) {
                case cuentaXcliente:
                    a.href = "pdfCTAxCLIENTE/"+idCliente+"/"+Fecha1+"/"+Fecha2;
                break;
                case 'CXCprint':
                    a.href = "CXCprint/"+idCliente+"/"+Fecha1+"/"+Fecha2;
                break;
                default:
                    mensaje("ERROR...","error");
            }
            window.open(a);
        }
        function generarExcel(formulario){
            document.getElementById('CXCexcel').submit();
        }
        function FiltrarReporte(titulo,ruta) {
            rutaGlobal=ruta;
            $('#modalFiltrado').openModal();
            $('#tituloFiltrado').text(titulo);
            $('#tituloFiltrado2').text(titulo);
        }
        
        $("#geninformeFactura").click(function(){                       
            var f1 = $('#ListFact').val()
            $('#informeDetalle').openModal();
            idTabla = $('#tblInformeFactura').DataTable();
                idTabla.destroy();
                idTabla.clear();
                idTabla.draw();
                $('#tblInformeFactura').DataTable({
                    ajax: "informeFactura/"+ f1,
                    "info":    false,
                    "bPaginate": false,
                    "paging": false,
                    "pagingType": "full_numbers",
                    "emptyTable": "No hay datos disponibles en la tabla",
                    "dom": 'T<"clear">lfrtip',
                    "tableTools": {
                        "sSwfPath": "<?php echo base_url(); ?>assets/data/swf/copy_csv_xls_pdf.swf",
                    },
                    columns: [
                    { "data": "FACTURA" },
                    { "data": "CLIENTE" },
                    { "data": "FECHA" },
                    { "data": "CODIGO" },
                    { "data": "PUNTOS" },
                    { "data": "APLICADO" },
                    { "data": "VER" }
                    ]
                });
        });

        $("#generarDetalleReporte").click(function(){
            var f1 = $('#fecha1').val()
            var f2 = $('#fecha2').val()
            $("#Total2").hide();
            if(f1!="" || f2!=""){
            $("#f1Detail").text(f1);
            $("#f2Detail").text(f2);
            $('#loadIMG').show();
            $('#miTablaReportes').html('');
            $('#miTablaReportes').html('<table id="tblDetalleReportes" class="TblDatos center"><thead><tr></tr></thead></table>');

            var data,
                tableName= '#tblDetalleReportes',
                columns,
                str,
                jqxhr = $.ajax(rutaGlobal+"/"+f1+"/"+f2)
                        .done(function () {
                            data = JSON.parse(jqxhr.responseText);
                $.each(data.columns, function (k, colObj) {
                    str = '<th>' + colObj.name + '</th>';
                    $(str).appendTo(tableName+'>thead>tr');
                });
                data.columns[3].render = function (data, type, row) {
                    return data;
                }
                $(tableName).dataTable({
                    "dom": 'T<"clear">lfrtip',
                    "tableTools": {
                        "sSwfPath": "<?php echo base_url(); ?>assets/data/swf/copy_csv_xls_pdf.swf",
                    },
                    "data": data.data,
                    "columns": data.columns,
                    "info":false,
                    "order": [[ 1, "desc" ]],
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
                    "fnInitComplete": function () {
                    $('#tblDetalleReportes').on( 'init.dt', function () {
                        $('#loadIMG').hide();
                        var totalAcumulado = 0;
                        obj = $('#tblDetalleReportes').DataTable();
                        obj.rows().data().each( function (index,value) {
                            if (rutaGlobal=="masterClientes") {
                               totalAcumulado += parseInt(obj.row(value).data().PUNTOS.replace(".000000",""));
                            }
                        });
                        if (rutaGlobal=="masterClientes") {
                            $("#Total2").show();
                            $('#spanTotal').text(totalAcumulado);
                        };                        
                    }).dataTable();
                    }
                });
            })
            .fail(function (jqXHR, exception) {
                            var msg = '';
                            if (jqXHR.status === 0) {
                                msg = 'Not connect.\n Verify Network.';
                            } else if (jqXHR.status == 404) {
                                msg = 'Requested page not found. [404]';
                            } else if (jqXHR.status == 500) {
                                msg = 'Internal Server Error [500].';
                            } else if (exception === 'parsererror') {
                                msg = 'Requested JSON parse failed.';
                            } else if (exception === 'timeout') {
                                msg = 'Time out error.';
                            } else if (exception === 'abort') {
                                msg = 'Ajax request aborted.';
                            } else {
                                msg = 'Uncaught Error.\n' + jqXHR.responseText;
                            }
                console.log(msg);
                mensaje(msg,"error");
            });
        $('#SPdet').openModal();
        }else{mensaje("SELECCIONE UN RANGO DE FECHAS","error");}
        });
</script>