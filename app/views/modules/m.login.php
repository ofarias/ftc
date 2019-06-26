<div class="row">
    <img class="logo-s animated slower zoomInUp"src="app\views\images\Logos\sat2app.png">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel-acceso panel panel-default">
            <div class="panel-cabeza">
                <h3 class="panel-title">Iniciar sesión</h3>
            </div>
            <div class="panel-body">
                <form role="form" method="post" action="index.php" id="formIni">
                    <fieldset>
                        <div class="form-group">
                            <input class="form-control-user animated fast slideInLeft" placeholder="Usuario" name="user" type="text" autofocus required="required">
                        </div>
                        <div class="form-group">
                            <input class="form-control-pass animated fast slideInRight" placeholder="Contraseña" name="contra" type="password" value="" required="required" id="contra">
                        </div>
                        <button class="btn-login" onclick="enviar()"><a>Iniciar sesión</a></button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="app/views/dist/js_md5/md5.min.js"></script>
<script>
    function enviar(){
        pwd = document.getElementById('contra').value
        pwd = document.getElementById('contra').value=md5(pwd);
        var form = document.getElementById().value
        form.submit();
    }
</script>
