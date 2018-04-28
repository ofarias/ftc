<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                 SALDO DE CUENTAS BANCARIAS
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables">
                                    <thead>
                                        <tr>
                                            <th>Banco</th>
                                            <th>Cuenta Bancaria</th>
                                            <th>Cuenta Contable</th>
                                            <th>Abonos Mes Actual</th>
                                            <th>Abonos Mes Anterior</th>
                                            <th>Movs. X Relac. Actual</th>
                                            <th>Movs. X Relac. Anterior</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($bancos as $data):                           
                                        ?>
                                       <tr>
                                            <td><?php echo $data->BANCO;?></td>
                                            <td><?php echo $data->NUM_CUENTA;?></td>
                                            <td><?php echo $data->CTA_CONTAB;?></td>
                                            <td><?php echo $data->ABONOS_ACTUAL;?></td>
                                            <td><?php echo $data->ABONOS_ANTERIOR;?></td>
                                            
                                            <td><?php echo $data->MOV_X_REL_AC;?></td>
                                            <td><?php echo $data->MOV_X_REL_AN;?></td>
                                            
                                        </tr> 
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>

                      </div>
            </div>
        </div>
</div>
</div>
<br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                 Captura de pagos Contabilidad.
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables">
                                    <thead>
                                        <tr>
                                            <th>Cuenta Bancaria</th>
                                            <th>Monto</th>
                                            <th>Fecha Edo Cta</th>
                                            <th>Agregar</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                       <tr>
                                          <form action="index.php" method="post">     
                                            <input type="hidden" name="ref1" value="s/r"/>
                                        <td>  
                                                <input name = 'banco2' value="<?php echo $data->BANCO.' - '.$data->NUM_CUENTA?> " >
                                        </td>
                                        <td>
                                            <input name="monto" type="number" step = "any" required="required" id="mnt" />
                                        </td>
                                        <td>
                                            <input name="fecha" type="text" required="required" class="date" value="<?php echo $fecha?>" />
                                        </td>
                                        <td>
                                            <input name="cuenta" type="hidden" value="<?php echo $data->NUM_CUENTA;?>" />
                                            <input name="banco" type="hidden" value="<?php echo $data->BANCO;?>" />
                                            <button name="ingresarPago" type="submit" value="enviar" class ="btn btn-success" onclick="ocultar(mnt.value)" id= "btnPago"  style="display:inline;">Agregar</button> 
                                        </td>
                                           
                                            </form>   
                                            
                                        </tr> 
                                        
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>
</div>

<!--
<label style="font-size: 20px"> SALDO GENERAL DE LA CUENTA: $ <?php echo number_format($data->SALDO,2) ?></label>
-->
<?php 
if (empty($pagosA)){
}else{ 
?>
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Pagos Registrados MES ACTUAL.
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables">
                                    <thead>
                                        <tr>
                                            <th>CONSECUTIVO</th>
                                            <th>FECHA REGISTRO</th>
                                            <th>MONTO</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($pagosA as $datos): ?>
                                       <tr>
                                            <td align="center"><?php echo $datos->FOLIO_X_BANCO?></td>
                                            <td align="center"><?php echo $datos->FECHA;?></td>
                                            <td align="center">$ <?php echo number_format($datos->MONTO,2);?></td>
                                        <?php endforeach ?>
                                        </tr>
                                       
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>
<?php 
} 
?>

<!--Modified by GDELEON 3/Ago/2016-->
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script>

  $(document).ready(function() {
    $(".date").datepicker({dateFormat: 'dd.mm.yy'});
  } );

  function ocultar(a){
    
    if(a == ''){
      //alert('El valor esta vacio' + a);
    }else{
      //alert('Presiono el boton con valor : '+ a);
      document.getElementById('btnPago').classList.add('hide');
      //document.getElementById('formCliente').style.display='block
    }
  }
  
</script>