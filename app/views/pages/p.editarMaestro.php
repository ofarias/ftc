<br/>
<div class="row">
    <div class="container">
    <div class="form-horizontal col-lg-12">
        <div class="panel panel-default">
            <div class="panel panel-heading">
                <h3>Editar Maestro</h3>
            </div>
            <br />
            <div class="panel panel-body">
                <?php foreach ($datosMaestro as $key):
                    $cvem = $key->CLAVE;
                 ?>
                   <input name = "idm" type="hidden" value ="<?php echo $key->ID ?>">
                    <div class="form-group">
                        <label for="cliente" class="col-lg-2 control-label">Nombre Maestro: </label>
                            <div class="col-lg-8">
                                <form action="index.php" method="post">
                                <input type="text" class="form-control" name="cliente" value="<?php echo $key->NOMBRE;?>" readonly="true"/><br>
                                <input type="hidden" name="maestro" value="<?php echo $key->ID?>">
                                <p>Cartera Revision:</p>
                                <select class="form-control" name="revision" required="required">
                                    <option value="<?php echo !empty($key->CARTERA_REVISION)? $key->CARTERA_REVISION:''?>"> <?php echo !empty($key->CARTERA_REVISION)? $key->CARTERA_REVISION:'Seleccione una Cartera' ?> </option>
                                    <option value="R1">R1</option>
                                    <option value="R2">R2</option>
                                    <option value="R3">R3</option>
                                </select>
                                <br/>
                                <p>Cartera Cobranza:</p>
                                <select class="form-control" name="cobranza" required="required">
                                    <option value="<?php echo !empty($key->CARTERA)? $key->CARTERA:''?>"> <?php echo !empty($key->CARTERA)? $key->CARTERA:'Seleccione una Cartera' ?> </option>
                                    <option value="C1">C1</option>
                                    <option value="C2">C2</option>
                                    <option value="C3">C3</option>
                                </select>
                                <br/>
                                <button class="btn btn-success form-control" value="submit" type="submit" name="editaCarterasMaestro" >Guardar</button>
                                </form>
                            </div>
                    </div>
        <?php endforeach ?>
            </div>

                <div class="panel-footer">
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <input type="button" name="altaCCC" onclick="altaccc()" class="btn btn-success" value="Alta CC">
                            <label>Crear los Centros de Compras del Maestro.</label>
                        </div>
                    </div>
                </div>
                </div>
        </div>
    </div>
</div>



<br/>
<div class="row" style="display:none" id="altaCCC">
    <div class="container">
        <div class="form-horizontal">
            <div class="panel panel-default">
                <div class="panel panel-heading">
                    <h3>Alta de Centro de Costos</h3>
                </div>
    <div class="panel panel-body">
        
                    <form action="index.php" method="post">

                        <div class="form-group">
                                <label for="categoria" class="col-lg-2 control-label">Nombre : </label>
                                <div class="col-lg-10">
                                    <input type="text" maxlength="60" name="nombre" placeholder="Nombre del Centro de Compra" value="" class=" form form-control" required="required">
                                </div>
                        </div>
                        <div class="form-group">
                                <label for="categoria" class="col-lg-2 control-label">Contacto : </label>
                                <div class="col-lg-10">
                                    <input type="text" maxlength="60" name="contacto" placeholder="Persona de contacto" value="" class=" form form-control" required="required">
                                </div>
                        </div>
                        <div class="form-group">
                                <label for="categoria" class="col-lg-2 control-label">Telefono : </label>
                                <div class="col-lg-10">
                                    <input type="text" maxlength="60" name="telefono" placeholder="Telefono del Contacto" value="" class=" form form-control" required="required">
                                </div>

                        </div>
                        <div class="form-group">
                                <label for="categoria" class="col-lg-2 control-label">Presupuesto: </label>
                                <div class="col-lg-10">
                                    <input type="number" step="10000" name="presup" min="0" placeholder="Presupuesto Mensual" value="" class=" form form-control" required="required">
                                </div>
                        </div>

                        <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <input type="hidden" name="cvem" value ="<?php echo $cvem?>">
                                    <input type="hidden" name="idm" value ="<?php echo $idm?>">
                                    <button name="creaCC" type="submit" value="enviar" class="btn btn-warning"> Guardar <i class="fa fa-floppy-o"></i></button>
                                    <input class="btn btn-danger" type="button" name="cancelar" onclick="ocultar()" value = "Cancelar">
                                </div>
                               
                        </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if(count($ccc) > 0 ){?>
<br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           CENTROS DE COMPRA <br/>   
                           
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Contacto</th>
                                            <th>Telefono</th>
                                            <th>Presupuesto</th>
                                            <th>Asociar Clientes</th>
                                            <th>Ver Asociados</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($ccc as $data): 
                                        ?>
                                        <tr class="odd gradeX" >
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->COMPRADOR;?></td>
                                            <td><?php echo $data->TELEFONO;?></td>
                                            <td><?php echo '$ '.number_format($data->PRESUPUESTO_MENSUAL,2);?></td>
                                            <td>
                                                <input value="Asociar Cliente" type="button" class="bt btn-success" onclick="verFormCliente(<?php echo $data->ID?>, '<?php echo $data->NOMBRE?>')">
                                            </td>
                                            <td>
                                                <a href="index.php?action=verAsociados&cc=<?php echo $data->ID?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;"> Ver Asociados</a>
                                            </td>

                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                      </div>
            </div>
        </div>
</div>

<?php }?>

<br/>
<div class="row" style="display:none" id="formCliente">
    <div class="container">
        <div class="form-horizontal">
            <div class="panel panel-default">
                <div class="panel panel-heading">
                    <h3>Clientes sin Centro de Compra Asociado</h3>
                </div>
                <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Clientes <br/>   
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Clave</th>
                                            <th>Nombre</th>
                                            <th>RFC</th>
                                            <th>Direccion</th>
                                            <th>Direccion Entrega</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($clientes as $data): 
                                        ?>
                                        <tr class="odd gradeX" >
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                         <form action="index.php" method="POST">
                                            <td><?php echo $data->CLAVE;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->RFC;?></td>
                                            <td><?php echo $data->CALLE; ($data->NUMEXT)?"', '.$data->NUMEXT":'';?> </td>
                                            <td><?php echo $data->CAMPLIB7?></td>
                                            <td>
                                                <select required="required">
                                                    <option value = ""> Seleccionar Usuario </option>
                                                    <option value = "168"> Braulio Hernandez </option>
                                                    <option value = "167"> Claudia Galicia </option>
                                                    <option value = "180"> Delia Roa</option>
                                                    <option value = "179"> Karina Vite</option>
                                                    <option value = "160"> Carlos Rogrioguez</option>
                                                    <option value = "175"> Marissa Peralta </option>
                                                    <option value = "176"> Guadalupe Ramirez</option>
                                                    <option value = "182"> Miriam Salas </option>
                                                    <option value = "181"> Jose Antonio Hernandez</option>
                                                    <option value = "170"> Miguel Ambrosio</option>
                                                    <option value = "171"> Luis Miguel Galvan</option>
                                                    <option value = "172"> Magdalena Nahuatatl</option>
                                                    <option value = "177"> Monica Mendoza </option>
                                                    <option value = "174"> Jorge Luvinoff </option>
                                                    <option value = "178"> Roman Sevilla </option>
                                                    <option value = "214"> Cristobal Valdivia </option>
                                                    <option value = "213"> Diana Garcia </option>
                                                    <option value = "212"> Hector Alvarado </option>
                                                </select> 
                                            </td>
                                            <td>
                                                <input type="hidden" name="cliente" value="<?php echo $data->CLAVE?>">
                                                <input type="hidden" name="cc" class="b" value="">
                                                <input type="hidden" name="cvem" value="<?php echo $cvem?>">
                                                <input type="hidden" name="idm" value="<?php echo $idm?>">
                                                <button name="asociaCC" value="enviar" type="submit" class="btn btn-success">Asociar a: <p class="a">???</p> </button>
                                            </td>
                                            <td>
                                                <input type="button" name="cancelar" value = "cancelar" onclick="ocultarFormCliente()" class="btn btn-warning">
                                            </td>
                                            </form>
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                      </div>
            </div>
        </div>
</div>
            </div>
        </div>
    </div>
</div>


 <script type="text/javascript">
    function altaccc(){
        document.getElementById('altaCCC').style.display = 'block';}
    function ocultar(){
        document.getElementById('altaCCC').style.display='none';}
    function verFormCliente(cc, nomb){
        alert("Se selcciono el CC: " + nomb);
        var x=document.getElementsByClassName('a');
        var y=document.getElementsByClassName('b');
        for(var i = 0; i < x.length; i++){
            x[i].innerText=nomb;    // Change the content
        }
        for(var i = 0; i< y.length; i++){
            y[i].value=cc;
        }
        //document.getElementsByClassName('b').value=cc;
        document.getElementById('formCliente').style.display='block';
    function ocultarFormCliente(){
        document.getElementById('formCliente').style.display='none';}

</script>
