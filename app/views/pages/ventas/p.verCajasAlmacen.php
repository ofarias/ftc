<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                Pedidos .
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-verCajasAlmacen">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>Cajas <br/><font color="red">Cotizacion</font></th>
                                            <th>Maestro</th>
                                            <th>Clave Pedido <br/><font color="darkgreen"><b>Pedido Cliente</b></font><br/> Status Cliente </th>
                                            <th>Vendedor <br/> Valor Pedido</th>
                                            <th>Partidas <br/> Credito Dispobible </th>
                                            <th>Estado <br/> Sobregiro Autorizado</th>
                                            <th>Fecha Creacion <br/> Resultado </th>
                                            <th>Ver Cotizacion</th>
                                            <th>Liberar</th>
                                            <th>Ver Pedido <br/> Cliente</th>
                                            <th>Subir Pedido</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($cajas as $data): 
                                            $status=$data->STATUS;
                                            $status_clie = '';
                                            if($status == 1){
                                                $status= 'Liberado';
                                            }
                                            $color= $data->URGENTE =='Si'?"style='background-color:red;'":"";
                                            if($data->STATUS_COBRANZA == 1 ){
                                                $color = "style='background-color:#A9D0F5;'";           
                                                $status_clie = 'CLIENTE SUSPENDIDO'; 
                                            }elseif ($data->STATUS_COBRANZA == 2) {
                                                $color = (($data->SALDO_MONTO_COBRANZA > $data->DBIMPTOT))? "style='background-color:#D0F5A9;'":"style='background-color:#A9D0F5;'";
                                                $status_clie = 'Suspendido con Prorroga';    
                                            }
                                            ?>
                                        <tr class="odd gradeX" <?php echo $color;?> >
                                            <td><?php echo empty($data->CAJA_PEGASO)? $data->IDCA:$data->CAJA_PEGASO ?><br/><font color="red"><?php echo $data->CDFOLIO?></font></td>
                                            <td><?php echo $data->CLIENTE.' Maestro:'.$data->MAESTRO?></td>
                                            <td><?php echo $data->PEDIDO;?> <br/> <font color="darkgreen"><b><?php echo $data->OC?></b></font><br/><?php echo ($status_clie)?></td>
                                            <td><?php echo $data->VENDEDOR;?> <br/><?php echo '$ '.number_format($data->DBIMPTOT,2)?></td>
                                            <td><?php echo $data->NUM_PROD;?></td>
                                            <td><?php echo $data->STATUS;?></td>
                                            <td><?php echo $data->FECHA_VENTAS;?></td>
                                            <form action="index.php" method="post">
                                            <input type="hidden" name="idca" value="<?php echo $data->IDCA;?>"/>
                                            <input type="hidden" name="idp" value="<?php echo $data->PEDIDO;?>">
                                            <input type="hidden" name="folio" value="<?php echo $data->COTIZACION?>" />
                                            <input type="hidden" name="urgente" value="<?php echo $data->URGENTE?>" />
                                            <td>
                                                <button name="verPedido" type="submit" value="enviar" class="btn btn-success"> Ver Pedido</button>
                                            </td>
                                            <?php if($letra == 'G' or $_SESSION['user']->POLIZA_TIPO == 'G'){?>
                                            <td>
                                             <button name="libPedidoFTC" type="submit" value="enviar " class= "btn btn-warning"
                                                <?php echo ($data->STATUS != 0 or empty($data->NOMBRE_ARCHIVO))? "disabled='disabled'":""?>
                                                > 
                                               <?php echo ($data->STATUS != 0)? "$status":"Liberar"?> 
                                               </button>
                                             <button name="rechazarFTC" type="submit" value="enviar" class="btn btn-danger"
                                              <?php echo (($data->STATUS != 0) or empty($data->NOMBRE_ARCHIVO))? "disabled='disabled'":""?>
                                                > 
                                               <?php echo ($data->STATUS != 0)? "$status":"Rechazar"?>   
                                             </button>
                                             </td> 
                                             <?php }else{?>
                                             <td>
                                             </td>
                                             <?php }?>
                                             </form>
                                             <td>
                                                <a href="/PedidosVentas/<?php echo substr($data->NOMBRE_ARCHIVO,30, 176)?>" download="/PedidosVentas/<?php echo substr($data->NOMBRE_ARCHIVO,30, 176)?>"><?php echo substr($data->NOMBRE_ARCHIVO,30,30)?> </a>
                                             </td>
                                             <td>
                                                <form action="upload_pedido_ventas.php" method="post" enctype="multipart/form-data">
                                                <input type="file" name="fileToUpload" id="fileToUpload">
                                                <input type="hidden" name="cotizacion" value="<?php echo $data->PEDIDO?>">
                                                <input type="submit" value="Subir Pedido" name="submit" <?php echo (!empty($data->NOMBRE_ARCHIVO))? 'disabled=disabled':'' ?>>
                                                </form>
                                             </td>
                                            
                                        </tr> 
                                        <?php endforeach; 
                                        ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
    </div>
</div>
