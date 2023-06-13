<br/>
<br/>
<div class="row">
                <div class="panel panel-default">
                        <div class="panel-heading">
                           Asignaciones desde bodega.
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-aplicapago">
                                    <thead>
                                        <tr>
                                            <th>Documento</th>
                                            <th>Fecha</th>
                                            <th>Cliente</th>
                                            <th>Monto NC Actual<br/>Monto NC Aplicado Actual</th>
                                            <th>Factura</th>
                                            <th>Saldo Facturas</th>
                                            <th>Usuario Recepcion</th>
                                            <th>Detalle</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        $i=0;
                                        foreach ($info as $data):
                                            $i++;   
                                            $color = "";
                                            $sf = $data->SALDO_FACT;
                                                if($sf>1){
                                                    $color="style='background-color:#aed2ec;'";
                                                }
                                            ?>
                                        <tr id="titulo_<?php echo $i?>" class="odd gradeX" <?php echo $color?>>
                                            <td><?php echo $data->DOCUMENTO?></td>
                                            <td><?php echo $data->FECHA_DOC.'<br/> UUID: '.$data->UUID;?></td>
                                            <td><?php echo $data->CLIENTE?></td>
                                            <td><?php echo '<font color="blue"> $ '.number_format($data->TOTAL,2).'</font/><br/><font color="red"> $ '.number_format($data->MONTO_NC,2).'</font>'?></td>
                                            <td><?php echo $data->NOTAS_CREDITO.'<br/>'.$data->FACTURANC?></td>
                                            <td>
                                                <?php echo 
                                                '<font color="black"> <b> $ '.number_format($data->TOTALFACTURA,2).' -> Importe Factura </b></font><br/>
                                                <font color=" #7ea522"> <b> $ '.number_format($data->PAGOS,2).' --> Pagos </b></font><br/>
                                                <font color="blue"> $ '.number_format($data->MONTO_NC,2).' --> Notas de Credito</font><br/> 
                                                $ '.number_format($data->SALDO_FACT,2).' --> Saldo Factura'?>    
                                            </td>
                                            <td><?php echo $data->USUARIO?></td>
                                            <td><a href="index.php?action=verFTCNCpendientes&docnc=<?php echo $data->DOCUMENTO?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;" class="btn btn-info">DETALLE</a><br/><br/>
                                            </td>           
                                            <td>
                                                <?php if($sf>1){?>
                                                    <a onclick="aplica('<?php echo $data->DOCUMENTO?>')" class="btn btn-info " >Aplicar</a>
                                                <?php }?>
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
<br />
<script type="text/javascript" language="JavaScript" src="app/views/bower_components/jquery/dist/jquery.min.js"></script>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">

    function aplica(docn){
        alert('Se aplicara la '+docn+' al documento relacionado');
        $.ajax({
            url:'index.v.php',
            type:'post',
            dataType:'json',
            data:{aplicaNC:docn},
            success:function(data){
                alert(data.mensaje);
            }
        })
    }

</script>
