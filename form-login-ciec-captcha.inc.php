<form method="POST" class="login-form"">
  <input type="hidden" name="accion" value="login_ciecc" />
  <div class="row">
    <div class="col-sm-3 form-group">
      <label for="login-ciec-rfc">RFC</label>
      <input type="text" class="form-control" id="login-ciec-rfc" name="rfc">
    </div>
    <div class="col-sm-3 form-group">
      <label for="login-ciec-pwd">Contraseña</label>
      <input type="password" autocomplete="new-password" class="form-control" id="login-ciec-pwd" name="pwd">
    </div>
    <div class="col-sm-4 form-group">
      <label for="login-ciec-captcha">Captcha</label>
      <div class="input-group">
        <input type="text" class="form-control" autocomplete="new-password" id="login-ciec-captcha" name="captcha" placeholder="Ingrese captcha">
        <span class="input-group-addon" style="padding:0;overflow:hidden;padding:0 10px;background:#fff;">
          <img style="height:32px" src="data:image/jpeg;base64,<?php echo $descargaCfdi->obtenerCaptcha(); ?>" />
        </span>
      </div>
    </div>
    <div class="col-sm-2 form-group">
      <label>&nbsp;</label><br>
      <button type="submit" class="btn btn-success btn-block">Iniciar sesión</button>
    </div>
  </div>
  <input type="hidden" name="sesion" value="<?php echo $descargaCfdi->obtenerSesion() ?>" />
</form>