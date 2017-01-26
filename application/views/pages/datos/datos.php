<header class="demo-header mdl-layout__header ">
    <div class="centrado  ColorHeader"><span class=" title">DATOS</span></div>
</header>
<!--  CONTENIDO PRINCIPAL -->
<main class="mdl-layout__content mdl-color--grey-100">
<div class="contenedor">        
    <div class="noMargen row TextColor center"><div class="col s12 m8 l12 offset-m1">CARGA DE DATOS</div></div>
    		<div class="Buscar row column noMargen">
                <div class="input-field col s4 m4 l3 offset-l9">
	            	<button href="#MFile" class="modal-trigger BtnBlue btn waves-effect waves-light" type="submit" name="action">SUBIR
						<i class="material-icons left">cloud_upload</i>
					</button>
				</div>
            </div>            
            <div class="noMargen Buscar row column">
                <div class="col s1 m1 l1 offset-l3 offset-s1 offset-m2">
                    <i class="material-icons ColorS">search</i>
                </div>

                <div class="input-field col s5 m4 l4">
                    <input  id="searchDatos" type="text" placeholder="Buscar" class="validate">
                    <label for="searchDatos"></label>
                </div>
            </div>            

        <table id="tblDatos" class=" TblDatos">
            <thead>
                <tr>
                    <th>FECHA</th>
                    <th>TIPO</th>
                    <th>DESCRIPCIÓN</th>
                    <th>OPCIÓN</th>
                </tr>
            </thead>
            <tbody class="center">
                <?php 
                    if (!($datos)) {}
                    else{
                        foreach ($datos as $key ) {
                            $delete = " <a  onclick='dellFrp(".'"'.$key['IdPeriodo'].'"'.")' href='#' class='Icono noHover'><i class='material-icons'>highlight_off</i></a>";
                            echo "<tr>
                                    <td>".$key['Fecha']."</td>
                                    <td class='negra'>".$key['Tipo']."</td>
                                    <td>".$key['Descripcion']."</td>
                                    <td class='center'>
                                    <a  onclick='getview(".'"'.$key['IdPeriodo'].'",'.'"'.$key['Tipo'].'"'.")' href='#' class='noHover'><i class='material-icons'>&#xE417;</i></a>
                                    </td>
                            </tr>";
                        }
                    }
                ?>                  
            </tbody>
        </table>
</div>
</main>  
<!-- FIN CONTENIDO PRINCIPAL -->


<!-- Modal #1 Modal Structure -->
<div id="MFile" class="modal">
    <div class="modal-content">
            <div class="right row noMargen">
                <a href="#!" class=" BtnClose modal-action modal-close noHover">
                    <i class="material-icons">highlight_off</i>
                </a>
            </div>
            <div class="row center">
                <span id="titulM" class="Mcolor">INGRESO DE DATOS</span>
            </div>
        <form id="formExcel" name="formExcel" enctype="multipart/form-data" class="col s6 m6 l6" action="<?PHP echo base_url('index.php/subirdatos');?>" method="post">
            <div class="row">
            	<input type="hidden" value="0" id="tipo" name="tipo">
            	<div class=" col s4 m4 l6">
			       	<div class="file-field input-field">
                        <div class="redondo waves-effect waves-light btn btnArchivo BtnBlue">
                        	<span>ARCHIVO EXCEL</span>
                            <input name='file' id="csv" type="file">
                        </div>
                        <div class="file-path-wrapper">
                        	<input class="file-path validate" type="text" placeholder"INGRESE EL ARCHIVO EXCEL">
                    	</div>
                    </div>
				</div>
				<div class="input-field col s4 m4 l6">
					<input id="fecha" name="fecha" type="date" class="datepicker">
                    <label for="fecha">FECHA:</label>
                </div>
            </div>
            <div class="row center">
            <a id="subirExcel" class="redondo waves-effect waves-light btn">GUARDAR</a>
            	<div id="loadsubir" style="display:none" class="preloader-wrapper big active">
                	<div class="spinner-layer spinner-blue-only">
                    	<div class="circle-clipper left"><div class="circle"></div></div>
                    	<div class="gap-patch"><div class="circle"></div></div>
                    	<div class="circle-clipper right"><div class="circle"></div></div>
                	</div>
            	</div>
                <div id="cargando" style="display:none;">
                        <div class="col s12 center">
                            <span class="datos1 lineas" id="cargandoLT">CARGANDO</span>
                        </div>
                </div>

        	</div>
            
		</form>
    </div>
</div>

<!-- Modal #1 Modal Structure -->
<div id="modalView" class="modal">
    <div class="modal-content">
            <div class="right row noMargen">
                <a href="#!" class=" BtnClose modal-action modal-close noHover">
                    <i class="material-icons">highlight_off</i>
                </a>
            </div>
            <div class="row center">
                <span id="titulM" class="Mcolor">DETALLE</span>
            </div>
       <div class="row" id="view">
           
       </div>
    </div>
</div>