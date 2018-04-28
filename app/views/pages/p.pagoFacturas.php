
<br>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default"> 
            <div class="panel-heading">
                A P L I C A C I O N.  
            </div>
  <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                <?php 
                                    foreach ($pago as $key):
                                ?>
                                    
                                    <label> El monto del pago es de: $ <?php echo number_format($key->MONTO,2)?> </label><br>
                                    <form action="index.php" method="post">
                                     <input type="hidden" name="idpago" value="<?php echo $key->ID?>">   
                                    
                                    <label> El saldo actual es de: $ <?php echo number_format($key->SALDO,2)?>   ---------->    </label>   <button name='imprimirComprobante' value="enviar" type="submit" class="btn btn-info">IMPRIMIR RELACION DEL PAGO</button><br> 
                                    </form>
                                    <label> El total de monto aplicado es: $ <?php echo number_format($total,2)?></label><br>
                                <?php endforeach; ?>
                                </table>
                            </div>
                    </div>
                    </div>
    </div>
</div>

<br>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default"> 
            <div class="panel-heading">
                R e l a c i o n ---  D e  ---   F a c t u r a s  ---   P a g a d a s.
            </div>
  <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>No.Aplicacion</th>
                                            <th>Clave</th>
                                            <th>CLIENTE</th>
                                            <th>Fecha Aplicacion</th>
                                            <th>Documento</th>
                                            <th>Importe</th>
                                            <th>Saldo Documento</th>
                                            <th>Monto Aplicado</th>
                                            <th>Saldo Pago</th>
                                            <th>Usuario</th>
                                            <?php if($rol == 'cxcc'){?>
                                            <th>Cancelar</th>
                                            <?php }else{?>
                                            <th>Contabilizar</th>
                                            <?php }?>
                                            <th>Imprimir</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($facturas as $data):
                                    
                                            ?>
                                        <tr>
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->CLAVE?></td>
                                            <td><?php echo $data->CLIENTE;?></td>
                                            <td><?php echo $data->FECHA;?></td>
                                            <td><?php echo $data->DOCUMENTO;?></td>
                                            <td><?php echo '$ '.number_format($data->IMPORTE,2)?></td>
                                            <td><?php echo '$ '.number_format($data->SALDO_DOC,2);?></td>
                                            <td><?php echo '$ '.number_format($data->MONTO_APLICADO,2);?></td>
                                            <td><?php echo '$ '.number_format($data->SALDO_PAGO,2)?></td>
                                            <td><?php echo $data->USUARIO?></td>
                                            <form action="index.php" method="post">
                                            <?php if($rol== 'cxcc'){?>
                                            <td>
                                            <form action="index.php" method="post">
                                                <input type="hidden" name="idp"  value="<?php echo $data->IDPAGO?>">
                                                <input type="hidden" name="ida" value="<?php echo $data->ID?>">
                                                <input type="hidden" name="docf" value="<?php echo $data->DOCUMENTO?>">
                                                <input type="hidden" name="montoap" value="<?php echo $data->MONTO_APLICADO?>">
                                                <input type="hidden" name="tipo" value="<?php echo empty($data->FORMA_PAGO)? "$data->IDPAGO":"$data->FORMA_PAGO" ?>">
                                                <button type ="submit" value="enviar" name="cancelaAplicacion" class='btn btn-danger' > Cancelar </button>
                                            </form>
                                            </td>
                                            <?php }else{?>
                                            <td>
                                                <button type ="submit" value="enviar" name="contVenta" <?php echo ($data->CONTABILIZADO == 'OK')? "class='btn btn-success'":"class='btn btn-info'"?> <?php echo ($data->CONTABILIZADO == 'OK')? "disabled = 'disabled'":"" ?> > <?php echo ($data->CONTABILIZADO == 'OK')? 'Contabilizado':'Contabilizar' ?> </button>
                                            </td>
                                            <?php }?>
                                            <td>
                                                <input type="hidden" name="ida" value ="<?php echo $data->ID?>">
                                                <input type="hidden" name="docf" value ="<?php echo $data->DOCUMENTO?>">
                                                <input type="hidden" name="idp" value ="<?php echo $idp?>">
                                                <button type="submit" value="enviar" name="impAplicacion" class="btn btn-warning"> Imprimir </button>
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


