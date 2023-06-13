<div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Cambio de Contraseña</h3>
                    </div>
                    <div class="panel-body">
                        <form class="pure-form" action="index.php" method="post">
                        
                        <fieldset>
                            <legend>Cambiar Contraseña </legend>
                            <input type="text" placeholder="Usuario" name ="u">
                            <br/>
                            <br/>
                            <input type="password" placeholder="Contraseña Actual" name ="actualSenia">
                            <br/>
                            <label>Colocar la contraseña Actual</label>
                            <br/>
                            <input type="password" placeholder="Nueva Contraseña" id="password" required name="nuevaSenia" maxlength="15" minlength="6">
                            <br/>
                            <label> Minimo 6 caracteres y Maximo de 15, la contraseña es sensible a mayusculas y minusculas, no se permite el uso de  comillas dobles " o comillas simples ' </label>
                            <br/>
                            <input type="password" placeholder="Confirmar Contraseña" id="confirm_password" required>
                            <br/>
                            <br/>
                            <button type="submit" class="pure-button pure-button-primary" name="cambioSenia">Cambiar</button>
                        </fieldset>
                    </form>
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
<script>    
    var password = document.getElementById("password")
  , confirm_password = document.getElementById("confirm_password");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("El password no coincide");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;
</script>