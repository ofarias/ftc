<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Inicie sesión con su cuenta</h3>
            </div>
            <div class="panel-body">
                <form role="form" method="post" action="index.php" id="formIni">
                    <fieldset>
                        <div class="form-group">
                            <input class="form-control" placeholder="Usuario" name="user" type="text" autofocus required="required">
                        </div>
                        <div class="form-group">
                            <input class="form-control" placeholder="Contraseña" name="contra" type="password" value="" required="required" id="contra">
                        </div>
                        <button class="btn btn-lg btn-success btn-block" onclick="enviar()"><a>Iniciar sesión</a></button>
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
