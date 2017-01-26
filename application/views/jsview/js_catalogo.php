<script>
	$( document ).ready(function(){

$('#checkTodos').change(function () {//funcion para seleccionar todos los checks
    var oTable = $('#tblCatalogoPasado').dataTable();
    $('input', oTable.fnGetNodes()).prop('checked',this.checked);// change .attr() to .prop()
});
 $('#tblCatalogo1,#tblCatalogo2,#tblCatalogo3,#tblCatalogo4').DataTable({
            //"scrollY":        "280px",
            "scrollCollapse": true,
            "paging":         false,
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
                "emptyTable": "No hay datos disponibles en la tabla",
                "search":     "BUSCAR"
            }
        });
$('#searchCatalogo').on( 'keyup', function () {
	var table = $('#tblCatalogo1,#tblCatalogo2,#tblCatalogo3,#tblCatalogo4').DataTable();
	table.search(this.value).draw();
});
$("#aceptarIMG").click(function(){
 		$('#loadimgReplace').show();
 		$(this).hide();
        $('#formimagen').submit();
 });
});
function subirimagen()
{    
    var file2 = $('#txtimagen').val().replace(/C:\\fakepath\\/i, '');
    //alert(file);
    var codigo = file2.split(".");
    //$('#txtimagen').hide(); 
    // $('#cargar22').hide();
    $('#labelCodigo').hide();   $('#labelDescripcion').hide();
    $('#labelPuntos').hide();   $('#labelImagen').hide();
    if ($('#bandera')==0){
    if ($('#txtimagen').val()=="") {$('#labelImagen').show(); return false;}
    if(codigo[0]!=$('#codigoArto').val()){$('#labelImagen3').show();return false;}
    }
    
    if ($('#codigoArto').val()=="") {$('#labelCodigo').show();return false;}
    if ($('#NombArto').val()=="") {$('#labelDescripcion').show();return false;}
    if ($('#PtArto').val()=="") {$('#labelPuntos').show();return false;} 
    else{   
    $('#agregar').hide();$('#loadIMG').show();
    //var file = $('input[type=file]').val().replace(/C:\\fakepath\\/i, '')
            var formData = new FormData($('#formimagen')[0]);
            //alert(formData[0]);
            $.ajax({
                url: "verificarImg/"+$('#bandera').val(),
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(datos)
                {
                    if (datos!=0) {
                    $("#mensajeIMG").html(datos);
                    $('#modalIMG').openModal(); 
                    $('#agregar').show();
                    $('#loadIMG').hide();
                    }else{
                        $('#formimagen').submit();
                    }
                }
            });
        }
}

var idImagenGlobal;
var IdCatalogoGlobal;

  $("#CrearCatalogo").on('click',function(){
        $('#labelDescripcion').hide();  $('#labelFecha2').hide();
        $('#labelDescripcion2').hide();
        if ($('#descripcionCat').val()=="") {$('#labelDescripcion2').show(); return false;}   
        if ($('#fechaCat2').val()=="") {$('#labelFecha2').show();return false;}
        else{
            $('#CrearCatalogo').hide(); $('#loadCrearCatalogo').show();
            $('#formNuevoCatalogo').submit();
            }
    });

    function darBaja(idImagen,IdCatalogo){
         $('#darBaja').openModal();
         idImagenGlobal = idImagen;
         IdCatalogoGlobal = IdCatalogo;
      }
   $("#darBajaOK").on('click',function(){
   	$('#EditEstado').show();$('#darBajaOK').hide();
    var form_data = {
                idarticulo: idImagenGlobal,
                catalogo: IdCatalogoGlobal
                };
        $.ajax({
                url: "ActualizarEstadoArticulo",
                type: "post",
                async:true,
                data: form_data,
                success:
                    function(json){
                        var myVar = setInterval(myTimer3, 2000);
                    }
                });
    });
   function myTimer3() {
        mensaje("SE GUARDARON LOS CAMBIOS EN EL CATALOGO, ESPERE..","");
        $(location).attr('href',"Catalogo");
    }
    function mensaje(mensaje,clase) {
    var $toastContent = $('<span class="center">'+mensaje+'</span>');
	    if (clase == 'error'){
	        return Materialize.toast($toastContent, 3500,'rounded error');
	    }
	    return  Materialize.toast($toastContent, 3500,'rounded');    
	}
	 $('#subir').click( function () {
        $('#nuevoArticulo').openModal();$('#bandera').val(0);
        //$('#cargar22').trigger('click');
        $( 'img' ).remove( '#quitar' );
        $('#codigoArto').val("");$('#NombArto').val("");$('#PtArto').val("");
    } );

function limpiarTabla (idTabla) {
        idTabla = $(idTabla).DataTable();
        idTabla.destroy();
        idTabla.clear();
        idTabla.draw();
}
     /*metodo para guardar el catalogo, con los nuevos articulos agregados*/
    $("#guardarCatalogo").on('click',function(){
            var contador = 0; var table2 = $('#tblCatalogoActualModal').DataTable();
            var rowCount = table2.page.info().recordsTotal;
            var codigo = ""; var articulo = ""; 
            var puntos = ""; var IdCatalogoArticulo = ""; var bandera = 0; 
            var IdCatalogo = $('#IdCatalogoActual').val(); $('#guardarCatalogo').hide();
            var table = $('#tblCatalogo2').DataTable();            
            $('.progress2').show();$('#tblCatalogoActualModal').hide();
            $("#tblCatalogoActualModal tbody tr").each(function(index) {
                $(this).children("td").each(function(index2){/*metodo para recorrer la tabla*/
                    switch($(this).parent().children().index($(this))) {//obtengo el index de la columna EKISDE
                        case 0:
                            codigo = $(this).html();
                            break;
                        case 1:
                            articulo = $(this).html();
                            break;
                        case 2:
                            break;
                        case 3:
                            puntos = $(this).html().split("<");
                            puntos = puntos[0];
                            IdCatalogoArticulo = $('#'+codigo+'').val();
                            break;
                        default: 
                    }
                });
                
            table.cells().eq(0).each( function ( index ) {/*VALIDO SI EL ARTICULO YA ESTA AGREGADO EN LA TABLA*/
                var cell = table.cell(index);             
                var data = cell.data();
                if (codigo == data) {bandera=1;};
            } );
            if (bandera!=1) {
            var form_data = {
                codigo: codigo,
                puntos: puntos,
                articulo: articulo,
                IdCatalogo: IdCatalogo,
                IdCatalogoArticulo: IdCatalogoArticulo
                };
             $.ajax({
                url: "actualizarCatalogo",
                type: "post",
                async:true,
                data: form_data,
                success:
                    function(json){
                        contador++;//alert(bandera);
                        //alert(rowCount+" contador "+ contador);
                        if (contador==rowCount) {var myVar = setInterval(myTimerCatalogo, 3500);};
                    }
                });}
             else{
                var $toastContent = $('<span class="center">EL ARTICULO: <h6 class="negra noMargen">"'+articulo+'"</h6> YA EXISTE Y NO SE AGREGO</span>');
                Materialize.toast($toastContent, 3500,'rounded error');
                }
            });
    });
    function myTimerCatalogo() {
	    Materialize.toast('SE GUARDARON LOS CAMBIOS EN EL CATALOGO, ESPERE..', 3000);
	    $(location).attr('href',"Catalogo");
	}
/*funcion para mandar a traer el catalogo de productos pasado EKISDE*/
    $('#cmbCatalogos').change(function(){
        $('#checkTodos').attr('checked', false);
        limpiarTabla(tblCatalogoPasado);
            $('#tblCatalogoPasado').DataTable({
                "order": [[ 1, "desc" ]],
                ajax: "AjaxCatalogoPasado/"+ this.value,
                "info":    false,
                "bPaginate": false,
                "paging": false,
                "pagingType": "full_numbers",
                "lengthMenu": [[10, -1], [10, "Todo"]],
                "language": {
                    "emptyTable": "No hay datos disponibles en la tabla",
                    "lengthMenu": '_MENU_ ',
                    "search": '<i class=" material-icons">search</i>',
                    "loadingRecords": "",
                    "paginate": {
                        "first": "Primera",
                        "last": "Última ",
                        "next":       "Siguiente",
                        "previous":   "Anterior"
                    }
                },
               columns: [
                    { "data": "CodigoImg" },
                    { "data": "Nombre" },
                    { "data": "Imagen" },
                    { "data": "Puntos" },
                    { "data": "check" }
              ]
            });
        $('#listaArticulos').openModal();
    });
$('#guardarActiculosInactivos').click(function(){
        var table = $('#tblArticulosInactivos').DataTable();
        var rowCount = table.page.info().recordsTotal;
        var contador=0; $('#loadArticulosInactivos').show(); $('#guardarActiculosInactivos').hide();
         $("#tblArticulosInactivos input:checkbox:checked").each(function(index) {
            var valores = "";
            //var table = $('#tblCatalogoActualModal').DataTable();
            var codigo = "";            
            $(this).parents("tr").find("td").each(function(){
                switch($(this).parent().children().index($(this))) {//obtengo el index de la columna EKISDE
                    case 0:
                        codigo = $(this).html();
                        break;
                        default: break;
                }
            });

            $.ajax({//AJAX PARA TRAER LOS PUNTOS TOTALES DEL CLIENTE
                url: "activarArticulos/"+codigo,
                type: "GET",
                dataType: "json",
                contentType: false,
                processData: false,
                success: function(datos)
                {      
                    mensaje('EL ARTÍCULO "'+codigo+'" FUE ACTIVADO CORRECTAMENTE','');
                }
            });
        });
        var myVar = setInterval(myTimer3, 6000);;
         
    });
function articulosInactivos(){
    $('#listaArticulosInactivos').openModal();
    limpiarTabla(tblArticulosInactivos);
        $('#tblArticulosInactivos').DataTable({
            ajax: "getArticulosInactivos",
            "info":    false,
                "bPaginate": false,
                "paging": true,
                "pagingType": "full_numbers",
                "lengthMenu": [[10, -1], [10, "Todo"]],
                "language": {
                    "emptyTable": "No hay datos disponibles en la tabla",
                    "lengthMenu": '_MENU_ ',
                    "search": '<i class=" material-icons">search</i>',
                    "loadingRecords": "",
                    "paginate": {
                        "first": "Primera",
                        "last": "Última ",
                        "next":       "Siguiente",
                        "previous":   "Anterior"
                    }
                },
            columns: [
                { "data": "CodigoImg" },
                { "data": "Nombre" },
                { "data": "Imagen" },
                { "data": "Puntos" },
                { "data": "check" }
            ]
        });
    $('#tblArticulosInactivos').on( 'init.dt', function () {
        $("#progressFact").hide();
    }).dataTable();
}
$('#txtimagen').change(function(){
    var file = $('input[type=file]').val().replace(/C:\\fakepath\\/i, '')
    if ($('#bandera').val()==0){
        var codigo = file.split(".");$('#codigoArto').val(codigo[0]);
    }
});
function ekisde () {
    var table = $('#tblCatalogo1').DataTable();

    table.order.fixed( {
        post: [ 0, 'asc' ]
    } );
}
function editarArticulo(imagen,codigo,descripcion,puntos){
        $('#bandera').val(1);
        $('#codigoArto').val(codigo);
        $('#NombArto').val(descripcion.replace('pulg','"'));
        $('#PtArto').val(puntos);
        $('#nuevoArticulo').openModal();        
        $("#cargar22").trigger("click");
        document.getElementById("ImgContenedor").innerHTML = ['<img id="quitar" src="../assets/img/catalogo/'+imagen+'" title="', escape('Imagen_Actual'), '"/>'].join('');
    }   
function subirEXCEL() {//funcion para subir el catalogo atravez de excel
    var imagenes = $('#imagenes').val().replace(/C:\\fakepath\\/i, '');
    var excel = $('#csv').val().replace(/C:\\fakepath\\/i, '');
    var tipoExcel = excel.split(".");
    if (excel=="") {
        mensaje("SELECCIONE EL EXCEL DEL CATALOGO","error")
        return false;
    }if (tipoExcel[1]!="xls"){
        mensaje("EL ARCHIVO NO ES UN EXCEL 97-2003(xls)","error")        
        return false;
    }if (imagenes=="") {
        mensaje("SELECCIONE AL MENOS 1 IMAGEN","error")
        return false;
    }else{
        $('#agregarExcel').hide(); $('#loadArchivoExcel').show();
        $('#formVariasImagenes').submit();    
    }    
}
</script>