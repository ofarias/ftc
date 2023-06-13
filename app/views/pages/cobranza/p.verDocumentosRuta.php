<br />
<?php  if($cierre=='1'){ ?>
    
        <label> Generar Cierre : <br/> Al generar el cierre los docuemntos No cobrados se liberan para poder ser reenrutados hasta 3 prorrogas automaticas, posteriormente se pasaran a la ventana de ExtraJudicial. </label> <br/>
        <form action="index.php" method="post">
        <input type="hidden" name="idf" value="<?php echo $idf?>">
        <button value="enviar" type="submit" name="cierreCC" class="btn btn-danger"> Cerrar Ruta </button>
        </form>
<?php 
}
?>
<br/>

<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                Ruta Cobranza
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-RutasActivas">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>Folio</th>
                                            <th>Cliente</th>
                                            <th>Documento</th>
                                            <th>importe</th>
                                            <th>Aplicado</th>
                                            <th>Saldo</th>
                                            <th>Fecha Doc</th>
                                            <th>Prorrogas</th>
                                            <th>Secuencia</th>
                                            <th>Contrarecibo</th>
                                            <th>Pagar</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($foliosRuta as $data): 
                                        ?>
                                       <tr>
                                            <td><?php echo $data->FOLIO;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->DOCUMENTO;?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->IMPORTE,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->APLICADO,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->SALDOFINAL,2);?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->PRORROGA;?></td>
                                            <td><?php echo $data->SECUENCIA;?></td>
                                            <td><?php echo $data->CONTRARECIBO_CR?></td>
                                            <form action="index.php" method ="post">
                                            <td>
                                                <input type="hidden" name="docf" value="<?php echo $data->DOCUMENTO?>">
                                                <input type="hidden" name="maestro" value="<?php echo $data->MAESTRO?>">
                                                <input type="hidden" name="tipo" value="R">
                                                <button name="pagoFacturaMaestro" value="enviar" type="submit"> Aplicar Pago <i class="fa fa-file"></i></button>
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
                            <!-- /.table-responsive -->
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                Documentos Pagados.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-RutasActivas">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>Folio</th>
                                            <th>Cliente</th>
                                            <th>Documento</th>
                                            <th>importe</th>
                                            <th>Aplicado</th>
                                            <th>Saldo</th>
                                            <th>Fecha Doc</th>
                                            <th>Prorrogas</th>
                                            <th>Secuencia</th>
                                            <th>Contrarecibo</th>
                                            <th>Pagar</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($foliosPagados as $data): 
                                        ?>
                                       <tr>
                                            <td><?php echo $data->FOLIO;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->DOCUMENTO;?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->IMPORTE,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->APLICADO,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->SALDOFINAL,2);?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->PRORROGA;?></td>
                                            <td><?php echo $data->SECUENCIA;?></td>
                                            <td><?php echo $data->CONTRARECIBO_CR?></td>
                                            <form action="index.php" method ="post">
                                            <td>
                                                <input type="hidden" name="docf" value="<?php echo $data->DOCUMENTO?>">
                                                <input type="hidden" name="maestro" value="<?php echo $data->MAESTRO?>">
                                                <input type="hidden" name="tipo" value="R">
                                                <button name="pagoFacturaMaestro" value="enviar" type="submit"> Aplicar Pago <i class="fa fa-file"></i></button>
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