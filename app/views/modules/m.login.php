<div class="row">

            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Inicie sesión con su cuenta</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post" action="index.php">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Usuario" name="user" type="text" autofocus required="required">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Contraseña" name="contra" type="password" value="" required="required">
                                </div>
                                <button class="btn btn-lg btn-success btn-block" type="submit">Iniciar sesión</a>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<div class="col-md-4 col-md-offset-4">
    <div class="login-panel panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"> Si pertenece a Logistica de click en la opcion para registrar sus documentos</h3>
         <div class="panel-body">
                    <input type="button" name="boton1" value="Acceso Logistica Recoleccion" class="btn btn-warning btn-block log"  >
                    <input type="button" name="boton2" value="Acceso Logistica Reparto" class="btn btn-info btn-block log"  >
        </div>
        </div>
    </div>
</div>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">
   $(".log").click(function(){
        if(confirm('Desea dirigirse a la Documentacion de la ruta?')){
            window.location.href = "index_log.php?action=scaneaDocumentoRep";
    
        }
        
   })
</script>