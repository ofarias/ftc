<br/>
<div class="row">
    <div class="container">
    <div class="form-horizontal col-lg-12">
        <div class="panel panel-default">
            <div class="panel panel-heading">
                <h3>Alta de Proveedor</h3>
            </div>
            <br />
            <div class="panel panel-body">
                <?php 
                    $nombre= "";
                    $rfc = "";
                    $marca = "";
                    $telefono ="";
                    $calle ="";
                    $ext = "";
                    $int = "";
                    $ciudad = "";
                    $cp = "";
                    $pais = "";
                    $deleg = "";
                    $mun = "";
                    $correoGen = "";
                    $contPrim = "";
                    if(isset($proveedor)){
                        foreach($proveedor as $data){
                           $nombre = $data->NOMBRE;
                           $rfc =$data->RFC;
                           $marca =$data->MARCA;
                           $telefono = $data->TELEFONO;
                           $calle =$data->CALLE;
                           $ext =$data->EXT;
                           $int =$data->INT;
                           $ciudad =$data->CIUDAD;
                           $cp =$data->CP;
                           $pais =$data->PAIS;
                           $deleg =$data->DELEG;
                           $mun =$data->MUN;
                           $correoGen =$data->CORREOGEN;
                           $contPrim =$data->CONTPRIM;
                        }
                    }

                ?>
                <form action="index.php" method="post" id="form-clasif">
                   <div class="form-group ">
                            <label for="activo" class="col-lg-2 control-label">Nombre : </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" minlength="10" maxlength="50" name="nombre" value="<?php echo $nombre?>" placeholder="Nombre del proveedor" required><br>
                            </div>
                    </div> 
                    <br/>
                    <div class="form-group">
                        <label for="clasificacion" class="col-lg-2 control-label">RFC: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="rfc" value="<?php echo $rfc ?>" placeholder="RFC sin espacion ni guiones ejemplo XXX010101XXX" required="required" minlength="12" maxlength="13" onchange="valida(this.value)"/><br>
                            </div>
                    </div>
                        <div class="form-group">
                            <label for="descripcion" class="col-lg-2 control-label">Marca: </label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="marca" value="<?php echo $marca ?>" placeholder="Marca del Proveedor" maxlength="50"/><br>
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="descripcion" class="col-lg-2 control-label">Telefono: </label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="telefono" value="<?php echo $telefono ?>" placeholder="Telefono" required = "required" maxlength="25"/><br>
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="descripcion" class="col-lg-2 control-label">Calle: </label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="calle" value="<?php echo $calle ?>" placeholder="Calle" required = "required" maxlength="50"/><br>
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="descripcion" class="col-lg-2 control-label">Numero Exterior: </label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="ext" value="<?php echo $ext ?>" placeholder="Numero Exterior" required = "required" maxlength="15"/><br>
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="descripcion" class="col-lg-2 control-label">Numero Interior: </label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="int" value="<?php echo $int ?>" placeholder="Numero Interior" required = "required" maxlength="15"/><br>
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="descripcion" class="col-lg-2 control-label">Ciudad: </label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="ciudad" value="<?php echo $ciudad ?>" placeholder="Ciudad " required = "required" maxlength="50"/><br>
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="descripcion" class="col-lg-2 control-label">Codigo Postal: </label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="cp" value="<?php echo $cp ?>" placeholder="Codigo Postal" required = "required" maxlength="5"/><br>
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="descripcion" class="col-lg-2 control-label">Clave del Pais: </label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="pais" value="<?php echo $pais ?>" placeholder="Pais" required = "required" maxlength="2"/><br>
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="descripcion" class="col-lg-2 control-label">Delegacion: </label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="deleg" value="<?php echo $deleg ?>" placeholder="Delgacion o Municipio" required = "required" maxlength="50"/><br>
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="descripcion" class="col-lg-2 control-label">Municipio o Colonia: </label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="mun" value="<?php echo $deleg ?>" placeholder="Delgacion o Municipio" required = "required" maxlength="50"/><br>
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="descripcion" class="col-lg-2 control-label">Correo General del Proveedor: </label>
                                <div class="col-lg-8">
                                    <input type="email" class="form-control" name="correoGen" value="<?php echo $correoGen ?>" placeholder="Correo General" required = "required" maxlength="100"/><br>
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="descripcion" class="col-lg-2 control-label">Contacto Principal: </label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="contPrim" value="<?php echo $contPrim ?>" placeholder="Correo General" required = "required" maxlength="50"/><br>
                                </div>
                        </div>
                   </form>
                </div>
            <div>
                <div class="panel-footer">
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button name="guardaProveedor" type="submit" value="enviar" class="btn btn-success" form="form-clasif" >Guardar<i class="fa fa-floppy-o"></i></button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <br/>
    </div>
    </div>
</div>
<script type="text/javascript">
    function valida(rfc){
        $.ajax({
            url:'index.php',
            type:'post',
            dataType:"json",
            data:{validaRFC:rfc, tipo:'Proveedor'},
            success:function(data){
                if(data.status=='ok'){

                }else{
                    alert(data.aviso);
                }
            }
        });
    }
</script>