<script>
$(document).ready(function() {
	$('#tblmonitoreo').DataTable({
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
	$('#searchDatos').on( 'keyup', function () {
        var table = $('#tblmonitoreo').DataTable();
        table.search(this.value).draw();
    });    
});
</script>