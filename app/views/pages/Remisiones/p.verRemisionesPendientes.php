<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                 Remisiones Pendientes de Facturar.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-remisionesPendientes">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            
                                            <th>Remision</th>
                                            <th>Fecha Remision</th>
                                            <th>Cliente</th>
                                            <th>Pedido Cliente</th>
                                            <th>Pedido Pegaso</th>
                                            <th>Importe <br/> Pendiente</th>
                                            <th>Factura</th>
                                          <!--  <th>Comprobante</th>-->
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        $TOTAL= 0;
                                        foreach ($remisiones as $data): 
                                            $TOTAL=$TOTAL + $data->SUBTOTAL;

                                        ?>
                                       <tr>
                                            <td><a href="index.php?action=detalleRemision&docf=<?php echo $data->CVE_DOC?>"  onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;" ><?php echo $data->CVE_DOC;?></a></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td align="center"><?php echo $data->PEDIDO?></td>
                                            <td align="center"><?php echo $data->PEDIDOPEGASO;?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->IMPORTE,2)?> <br/> <font color="red"><?php echo '$ '.number_format($data->SUBTOTAL*1.16,2)?></font></td>
                                            <td><a href="index.php?action=verFacturaCompleta&docf=<?php echo $data->FACTURA?>"  onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;"><?php echo $data->FACTURA?></a></td>
                                          </tr> 
                                        <?php endforeach; ?>
                                 </tbody>
                                 <label><font size="15px">TOTAL PENDIENTE POR FACTURAR:</font> &nbsp;  &nbsp;  &nbsp; <font color="blue" size="20px"><b><?php echo '$ '.number_format($TOTAL,2)?></b></font>&nbsp;  <font color="black" size="20px"><b>IVA:&nbsp;<?php echo '$ '.number_format($TOTAL*.16,2)?></b></font><font color="red" size="20px"><b>Total:&nbsp;<?php echo '$ '.number_format($TOTAL*1.16,2)?></b></font></label>
                                 </table>

                            <!-- /.table-responsive -->
                      </div>
            </div>
            <div>
                <input type="button" name="grabar" onclick="grabar()" class="btn btn-info" value="GUARDAR INVENTARIO">
            </div>
        </div>
</div>


<FORM action="index.php" method="POST" id="gr">
    <input type="hidden" name="grabarRemisiones" value="">
</FORM>


<script>
    function grabar(){
        var f = new Date();
        if(f.getDate() != 1){
            if(confirm('Desea Grabar el Inventario?')){
                var form = document.getElementById('gr');
                form.submit();
            }
        }else{
            alert('Lo siento solo se puede grabar el primer dia de mes');
       }
        
    }

</script>