<header class="demo-header mdl-layout__header ">
    <div class="centrado  ColorHeader">
        <span class=" title">CLIENTES</span>
    </div>
</header>
<!--//////////////////////////////////////////////////////////
                CONTENIDO
///////////////////////////////////////////////////////////-->
<main class="mdl-layout__content mdl-color--grey-100">

    <div class="contenedor">

        <div class=" row TextColor center">
               CLIENTES PARA AGREGAR AL PROGRAMA DE PUNTOS
        </div>

        <div class="container">
            <div class=" Buscar row column">

                <div class="col s1 m1 l1 offset-l3 offset-s1 offset-m2">
                    <i class="material-icons ColorS">search</i>
                </div>

                <div class="input-field col s5 m4 l4">
                    <input  id="searchClientes" type="text" placeholder="Buscar" class="validate">
                    <label for="searchClientes"></label>
                </div>

                <div class="col s2 m1 l1">
                    <a href="Exp_Clientes" onclick="generar_reporte_excel(FrmClientes);"> <img src="<?PHP echo base_url();?>assets/img/icono_excel.png " width="30px"></a>
                </div>
                <div class="col s1 m1 l1 ">
                    <a href="ExpPDF" target="_blank" onclick="generar_reporte_pdf(FrmClientes);"><img src="<?PHP echo base_url();?>assets/img/icono-pdf.png " width="30px" ></a>
                </div>
            </div>
        </div>
        <!--
        <div class="right row">
                <a href="#modal1" id="btngenerar"  class="BtnBlue waves-effect  btn modal-trigger ">AGREGAR</a>
        </div>
        -->
     <form action="" name="FrmClientes" id="FrmClientes" method="post"> <!--Exportar datos a EXCEL -->
        <table id="ClienteAdd" class="table TblDatos">

            <thead>
            <tr>
                <th>CÓDIGO</th>
                <th>CLIENTE</th>
                <th>RUC</th>
                <th>DIRECCIÓN</th>
                <th>VENDEDOR</th>
            </tr>
            </thead>

            <tbody>
                <?PHP
                if(!($query)){
                    echo "fallo";
                }
                else{
                    $i=0;

                    foreach($query AS $cliente)
                    {
                        echo "<tr>
                                   <td>".$query[$i]['CLIENTE']."</td>
                                   <td id='NomCliente'>".$query[$i]['NOMBRE']."</td>
                                   <td>".$query[$i]['RUC']."</td>
                                   <td>".$query[$i]['DIRECCION']."</td>
                                   <td class='center'>".$query[$i]['VENDEDOR']."</td>
                              </tr>";
                        $i++;
                    }
                }
                ?>
            </tbody>
        </table>
        </form>
    </div><!-- Fin Contenedor -->
</main>


<!--///////////////////////////////////////////////////////////////////////
                        MODALES
////////////////////////////////////////////////////////////////////////-->

<!-- Modal #1
                Modal Structure -->
<div id="modal1" class="modal">
    <div class="modal-content">

        <div class=" row">
            <div class="right col s3 m3 l3">
                <a href="#!" class=" BtnClose modal-action modal-close ">
                    <i class="material-icons">highlight_off</i>
                </a>
            </div>
        </div>
        <div class=" row valign-wrapper">
            <div class="col s3 m3 l3">
                <h6 class="center Mcolor">DESEA AGREGAR:</h6>
            </div>
            <div class="col offset-l6 s3 m3 l3">
                <a href="#" id="btneliminar"  class="BtnBlue waves-effect  btn">ELIMINAR</a>
            </div>
        </div>
        

    <div class="row">
        <div class="col s12">
            <table id="tblModal1" class="">
                <thead>
                <tr>
                    <th>COD</th>
                    <th>CLIENTE</th>
                    <th>VENDEDOR</th>
                </tr>
                </thead>
                <tbody>
            </table>
        </div>
    </div>

    </div>
    <div class="row center">
        <div id="loadIMGaa" style="display:none" class="helpex preloader-wrapper big active">
            <div class="spinner-layer spinner-blue-only">
                    <div class="circle-clipper left"><div class="circle"></div></div>
                    <div class="gap-patch"><div class="circle"></div></div>
                    <div class="circle-clipper right"><div class="circle"></div></div>
                </div>
            </div>
            <a href="#" id="crearUsuarios" class="Btnadd btn ">GENERAR</a>
    </div>

</div>
<!-- Fin de Modal#1-->

<!--///////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////-->

<!-- Modal #2-->
<!-- Modal Structure -->
<div id="modal2" class="modal">
    <div class="modal-content">
        <div class=" row">
            <div class="right col s3 m3 l3">
                <a href="#!" class=" BtnClose modal-action modal-close ">
                    <i class="material-icons">highlight_off</i>
                </a>
            </div>
        </div>
        <h6 class="center Mcolor">CLIENTES AGREGADOS:</h6>

        <table id="tblModal2" class="TheadColor">
            <thead>
            <tr>
                <th>CLIENTE</th>
                <th>USUARIO VISYS</th>
                <th>CONTRASEÑA</th>
            </tr>
            </thead>

            <tbody>
            <tr>
                <td>xxxxxxx</td>
                <td id="black">xxxxxx</td>
                <td id="black">xxxx</td>
            </tr>
            </tbody>
        </table>

    </div>


</div>

