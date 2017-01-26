</div>

<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="<?PHP echo base_url();?>assets/js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="<?PHP echo base_url();?>assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?PHP echo base_url();?>assets/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?PHP echo base_url();?>assets/js/extensions/dataTables.colVis.min.js"></script>
<script type="text/javascript" src="<?PHP echo base_url();?>assets/js/extensions/dataTables.tableTools.min.js"></script>


<!--
<script type="text/javascript" src="//code.jquery.com/jquery-1.12.3.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
-->

<script src="<?PHP echo base_url();?>assets/js/JS.js"></script>
<script src="<?PHP echo base_url();?>assets/js/material.min.js"></script>
<script src="<?PHP echo base_url();?>assets/js/materialize.js"></script>
<script src="<?PHP echo base_url();?>assets/js/bootstrap.js"></script>

<script src="<?PHP echo base_url();?>assets/js/chosen.jquery.js"></script>
<script>
    $('.datepicker1').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year
        format: 'dd-mm-yyyy',// Formats dateformat:dd/mm/yyyy
        monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        weekdaysFull: ['DO','LU','MA','MI','JU','VI','SA'],
        weekdaysShort: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
        //showMonthsShort: true,
        showWeekdaysFull: true,
        today: 'Hoy',
        clear: 'Borrar',
        close: 'Cerrar'
    });
    
    var config = {
        '.chosen-select'           : {

        }
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
</script>
</body>
</html>