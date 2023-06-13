<br/>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Lista de Solicitudes de Autorizacion de Costos.
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-aplicapago">
                                    <thead>
                                        <tr>
                                            <th>Orden</th>
                                            <th>Clave / Proveedor </th>
                                            <th>Fecha OC</th>
                                            <th>Folio Pago </th>
                                            <th>Importe Pago <br/> Total de la Orden</th>
                                            <th>Clave</th>
                                            <th>Partida</th>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th><font color="blue">Precio Lista en Costos</font> <br/> ------- <br/><font color="red">  Precio Lista en Recepcion</font> </th>
                                            <th><font color="blue">Desc1</font> <br/> ------ <br/><font color="red">Desc1 Validacion </font> </th>
                                            <th><font color="blue">Desc2</font> <br/> ------ <br/><font color="red"> Desc2 Validacion</font></th>
                                            <th><font color="blue">Desc3</font> <br/> ------ <br/><font color="red"> Desc3 Validacion</font></th>
                                            <th><font color="blue">DescF</font> <br/> ------ <br/><font color="red"> Desc4 Validacion</font></th>
                                            <th><font color="blue">Iva</font> <br/> ------ <br/><font color="red"> IVA Validacion</font> </th>
                                            <th><font color="blue">Total Costo</font> <br/> ------ <br/><font color="red"> Total Costo Validacion</font> </th>
                                            <th>Ajustar Costo</th>
                                            <th>Rechazat <br/> Autorizar</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($verSolicitudes as $data):
                                            ?>
                                        <tr>
                                            <td><?php echo $data->ORDEN;?></td>
                                            <td><?php echo '('.$data->CVE_CLPV.')'.$data->PROV;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->TP_TES;?></td>
                                            <td><?php echo '$ '.number_format($data->PAGO_TES,2);?></td>
                                            <td><?php echo $data->CLAVE;?></td>
                                            <td><?php echo $data->PARTIDA;?></td>
                                            <td><?php echo $data->NOMBRE?></td>
                                            <td><?php echo $data->CANTIDAD?></td>
                                            <td><font color="blue"><?php echo '$ '.number_format($data->COSTO,2)?></font><br/> -------- <br/>
                                            <font color = "red"><?php echo '$ '.number_format($data->PRECIO_LISTA,2)?></font></td>
                                            <form action="index.php" method="post">
                                            <input name="ids" type="hidden" value="<?php echo $data->ID?>"/>
                                            <input type="hidden" name="cotizacion" value="<?php echo $data->COTIZACION?>">
                                            <input type="hidden" name="vendedor" value="<?php echo $data->VENDEDOR?>">
                                            <input type="hidden" name="descripcion" id="desc" value="<?php echo $data->GENERICO?>" >
                                            <td> <font color ="blue"><?php echo $data->DESCC1.' %'?> </font> <br/> ------ <br/> <font color ="red"><?php echo $data->DESC1.' % ($ '.number_format($data->DESC1_M,2).')'?></font>  </td>
                                            <td> <font color ="blue"><?php echo $data->DESCC2.' %'?> </font> <br/> ------ <br/> <font color ="red"><?php echo $data->DESC2.' % ($ '.number_format($data->DESC2_M,2).')'?></font>  </td>
                                            <td> <font color ="blue"><?php echo $data->DESCC3.' %'?> </font> <br/> ------ <br/> <font color ="red"><?php echo $data->DESC3.' % ($ '.number_format($data->DESC3_M,2).')'?></font>  </td>
                                            <td> <font color ="blue"><?php echo $data->DESCCF.' %'?> </font> <br/> ------ <br/> <font color ="red"><?php echo $data->DESCF.' % ($ '.number_format($data->DESCF_M,2).')'?></font>  </td>
                                            <td> <font color ="blue"><?php echo number_format($data->IMPUESTO,2)?> </font> <br/> ------ <br/> <font color ="red"><?php echo number_format(($data->TOTAL_COSTO_VAL)-($data->TOTAL_COSTO_VAL/1.16),2)?></font>  </td>
                                            <td> <font color ="blue"><?php echo $data->COSTO_T ?> </font> <br/> ------ <br/> <font color ="red"><?php echo number_format($data->TOTAL_COSTO_VAL,2)?></font> </td>
                                            <td>
                                            <a href="index.php?action=ajustaPrecioLista&ida=<?php echo $data->IDA?>&doco=<?php echo $data->ORDEN?>&par=<?php echo $data->PARTIDA?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;" class="btn btn-info"> Ajustar Costos</a>
                                            </td>
                                            <td>
                                            <form action="index.php" method="POST">
                                                <input type="hidden" name="doco" value="<?php echo $data->ORDEN?>">
                                                <input type="hidden" name="par" value="<?php echo $data->PARTIDA?>">
                                                <input type="hidden" name="costo_o" value="<?php echo $data->COSTO?>">
                                                <input type="hidden" name="costo_n" value="<?php echo $data->PRECIO_LISTA?>">
                                                <button value="enviar" type="submit" name="rechazarSol" class="btn btn-danger"> Rechazar Solicitud </button>
                                            </form>
                                            <form action="index.php" method="POST">
                                                <input type="hidden" name="doco" value="<?php echo $data->ORDEN?>">
                                                <input type="hidden" name="par" value="<?php echo $data->PARTIDA?>">
                                                <input type="hidden" name="costo_o" value="<?php echo $data->COSTO?>">
                                                <input type="hidden" name="costo_n" value="<?php echo $data->PRECIO_LISTA?>">
                                                <button value="enviar" type="submit" name="aceptarCosto" class="btn btn-success"> Aceptar Costo </button>
                                            </form>
                                            </td>
                                            </form>      
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
    </div>
<br />

<script type="text/javascript">
    
    function rechazar(ids, desc){
        //var recWindow = window.open("index.php?action=verSolProdVentas","Mensaje","width=200,height=100")
        //recWindow.document.write("<p> Esta es la ventana</p>")
        var id = ids;
        alert('Se rechazara la Solicitud de alta del Producto :' + desc );
        window.open('index.php?action=rechazarSol&ids='+ids,"","width=800,height=800")
    }

</script>
