<script>
	$(document).ready(function() {
		//$('#MFile').openModal();
	$('#searchDatos').on( 'keyup', function () {
		var table = $('#tblDatos').DataTable();
		table.search(this.value).draw();
	});
		$('#tblDatos,#tblmetas,#tblcuotas').DataTable({
            "scrollCollapse": true,
            //"paging":         false,
            "info":    false,            
            "lengthMenu": [[5,10,50,100,-1], [5,10,50,100,"Todo"]],
            "language": {
                "zeroRecords": "NO HAY RESULTADOS",
                "paginate": {
                    "first":      "Primera",
                    "last":       "Última ",
                    "next":       "Siguiente",
                    "previous":   "Anterior"                    
                },
                "lengthMenu": "MOSTRAR _MENU_",
                "emptyTable": "NO HAY DATOS DISPONIBLES",
                "search":     "BUSCAR"
            }
        });
	});
	$('#subirExcel').click(function(){
		var excel = $('#csv').val().replace(/C:\\fakepath\\/i, '');
    	var tipoExcel = excel.split(".");
    	if ($("#csv").val()=="") {mensaje("SELECCIONE UN ARCHIVO EXCEL(2003)","error"); return false;}
		if ($("#fecha").val()=="") {mensaje("SELECCIONE UNA FECHA","error"); return false;}		
		if (tipoExcel[1]!="xls"){mensaje("EL ARCHIVO NO ES UN EXCEL 97-2003(xls)","error");return false;}
		else{
			$('#subirExcel').hide();
			$('#loadsubir').show();
			$('#cargando').show();
			$('#formExcel').submit();
		}
	});
	$( ".with-gap" ).change(function() {
        $('#tipo').val(($('#tipo').val() == 0) ? "1" : "0");
    });
	function mensaje(mensaje,clase) {
    	var $toastContent = $('<span class="center">'+mensaje+'</span>');
	    if (clase == 'error'){
	        return Materialize.toast($toastContent, 3500,'rounded error');
	    }
	    return  Materialize.toast($toastContent, 3500,'rounded');    
	}
	function getview (id,tipo) {            
            $("#modalView").openModal();
            if(id !=""){
            $('#loadIMG').show();
            $('#view').html('');
            $('#view').html('<table id="tblDetalleReportes" class="TblDatos center"><thead><tr></tr></thead></table>');

            var data,
                tableName= '#tblDetalleReportes',
                columns,
                str,
                jqxhr = $.ajax("viewDatos/"+id+"/"+tipo)
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
                        "emptyTable": "NO HAY DATOS DISPONIBLES",
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
        }else{mensaje("SELECCIONE UN RANGO DE FECHAS","error");}
	}
</script>