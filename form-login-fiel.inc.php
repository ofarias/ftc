<form method="POST" class="login-form"">
  <input type="hidden" name="accion" value="login_fiel" />
  <div class="row">
    <div class="col-sm-3 form-group">
      <label for="key">Archivo .KEY</label>
      <input type="file" class="form-control" id="login-fiel-key" name="key" accept=".key">
    </div>
    <div class="col-sm-3 form-group">
      <label for="cer">Archivo .CER</label>
      <input type="file" class="form-control" id="login-fiel-cer" name="cer" accept=".cer">
    </div>
    <div class="col-sm-3 form-group">
      <label for="login-fiel-pwd">Contraseña</label>
      <input type="password" autocomplete="new-password" class="form-control" id="login-fiel-pwd" name="pwd">
    </div>
    <div class="col-sm-3 form-group">
      <label>&nbsp;</label><br>
      <button type="submit" class="btn btn-success btn-block">Iniciar sesión</button>
    </div>
  </div>
</form>