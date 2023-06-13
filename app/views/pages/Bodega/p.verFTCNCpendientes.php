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
                                            <th>Monto</th>
                                            <th>Factura</th>
                                            <th>Usuario Recepcion</th>
                                            <th>Detalle</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        $i=0;
                                        foreach ($nc as $data):
                                            $i++;   
                                            ?>
                                        <tr id="titulo_<?php echo $i?>">
                                            <td><?php echo $data->DOCUMENTO?></td>
                                            <td><?php echo $data->FECHA_DOC;?></td>
                                            <td><?php echo $data->CLIENTE?></td>
                                            <td><?php echo '$ '.number_format($data->TOTAL)?></td>
                                            <td><?php echo $data->NOTAS_CREDITO;?></td>
                                            <td><?php echo $data->USUARIO?></td>
                                            <td><a href="index.php?action=verFTCNCpendientes&docnc=<?php echo $data->DOCUMENTO?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;" class="btn btn-info">DETALLE</a><br/><br/>
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

<form action="index.php" method="POST" id="recOC">
    <input type="hidden" value="" id="doc" name="doco">
    <input type="hiiden" value="" id="tip" name="tipo">
    <input type="hidden" value="" id="btn1" name="recibirOC">
</form>
<script type="text/javascript" language="JavaScript" src="app/views/bower_components/jquery/dist/jquery.min.js"></script>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">


</script>
