<form method="POST" class="login-form"">
  <input type="hidden" name="accion" value="login_ciec" />
  <div class="row">
    <div class="col-sm-3 form-group">
      <label for="login-ciec-rfc">RFC</label>
      <input type="text" class="form-control" id="login-ciec-rfc" name="rfc">
    </div>
    <div class="col-sm-3 form-group">
      <label for="login-ciec-pwd">Contraseña</label>
      <input type="password" autocomplete="new-password" class="form-control" id="login-ciec-pwd" name="pwd">
    </div>
    <div class="col-sm-2 form-group">
      <label>&nbsp;</label><br>
      <button type="submit" class="btn btn-success btn-block">Iniciar sesión</button>
    </div>
  </div>
</form>