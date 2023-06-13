<div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                	<div id="error" class="alert-danger"><?php echo $e;?></div>
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
                                <!-- Change this to a button or input when using this as a form -->
                                <button class="btn btn-lg btn-success btn-block" type="submit">Iniciar sesión</a>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>