
<div class="col center s12 l5">
    <form class="form" method="post" action="<?php echo base_url('index.php/login')?>">
        <div class="row login-logo center" style="width: 200px!important; height:200px;">
            <img  src="<?PHP echo base_url();?>assets/img/IMV.png" style="width:100%;height:100%;">
        </div>
        <div  class="row">
            <div class="col s10 m10 l6 offset-l3 offset-m1 offset-s1">  
                <input style="width: 60%;"  placeholder="USUARIO" name="txtUsuario" id="nombre" type="text" class=" validate">
            </div>
        </div>
        <div class="row">
            <div class="col s10 m10 l6 offset-l3 offset-m1 offset-s1">
                <input style="width: 60%;" placeholder="CONTRASEÑA" name="txtpassword" id="pass" type="password" class="validate">
            </div>
        </div>                                
        <div class="row center">
            <button id="Acceder" class="Btnadd modal-action modal-close btn" type="submit" name="action">ACCEDER</button>
        </div>
    </form>
</div>