<div class="row">
    <br />
</div>
<div class="row">
    <div class="col-md-6">
        <form action="index.php" method="post">
          <div class="form-group">
          <label>Seleccionar Mes a Registrar</label>
            <select name="Mes" >
                <?php foreach ($meses as $data):?>
                <option value = "<?php echo $data->NUMERO;?>" > <?php echo $data->NOMBRE;?> </option>
                <?php endforeach ?>
            </select>
          </div>
          <button type="submit"  class="btn btn-default" name="comprasXmes" value="enviar">Filtrar</button>
          </form>
          <br>
          <br>
          <?php foreach ($dato as $key): ?>
          <label style="font-size: 20px" align="center" >Se muestra el mes de <?php echo $key->NOMBRE;?> del 2016. </label>
            <?php endforeach ?>
    </div>
</div>


<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Integracion de compras al Estado de Cuenta.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Compra</th>
                                            <th>Proveedor</th>
                                            <th>Fecha</th>
                                            <th>Tipo de Pago</th>
                                            <th>Importe</th>
                                            <th>Fecha Estado de Cuenta</th>
                                            <th>Guardar</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($comp as $data):?>
                                       <tr <?php
                                            $hoy = date("Y-m-d");
                                         ?> >
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->TP_TES;?></td>
                                            <td><?php echo $data->IMPORTE;?></td>
                                            <form action="index.php" method="POST">
                                            <td>
                                                <input type="date" name="fechaedo" class="fecha" placeholder="<?php echo $hoy?>" required ="required" />
                                            </td>
                                            <td>
                                                <input type="hidden" name="mes" value="<?php echo $key->NUMERO;?>">
                                                <input type="hidden" name="docc" value="<?php echo $data->CVE_DOC;?>">
                                                <input type="hidden" name="pago" value="<?php echo $data->PAGO_TES;?>">
                                                <input type="hidden" name="tptes" value="<?php echo $data->TP_TES;?>">
                                                <input type="hidden" name="banco" value="<?php echo $data->BANCO;?>">
                                                <button name="regCompEdoCta" value="enviar" type="submit" >Guardar</button>
                                            </td>
                                            </form>
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
    </div>
</div>

 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
  <script>

  $(document).ready(function() {
    $(".fecha").datepicker({dateFormat: 'mm-dd-yy'});
  } );
  
  
  </script>
