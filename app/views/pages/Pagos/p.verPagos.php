<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-pago">
                                    <thead>
                                        <tr>
                                            <th>Cliente</th>
                                            <th>Fecha<br/>Elaboracion</th>
                                            <th>Fecha <br/> Aplicacion</th>
                                            <th>Documento de Pago</th>
                                            <th>Importe</th>
                                            <th>Tipo de Pago <br/> SAT</th>
                                            <th>Concepto SAE</th>
                                            <th>Documento</th>
                                            <th>Importe Documento</th>
                                            <th>Saldo Documento </th>
                                            <th>Importe Aplicado</th>
                                            <th>Saldo Insoluto</th>
                                            <th>Seleccionar</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($pagos as $data):
                                            $saldo = 0;
                                            $saldoInsoluto=$data->IMPORTE_DOC - $data->IMPORTE;
                                        ?>
                                       <tr>
                                            <td><?php echo '('.$data->CLAVE.')'.$data->NOMBRE;?></td>
                                            <td align="center"><?php echo $data->FECHAELAB;?></td>
                                            <td align="center"><?php echo $data->FECHA_APLI?></td>
                                            <td><?php echo $data->DOCTO?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->IMPORTE,6)?></td>                                    
                                            <td align="center"><?php echo $data->TIPO_SAT?></td>
                                            <td align="center"><?php echo $data->NUM_CPTO.'-'.$data->NOM_CPTO?><br/></td>
                                            <td><?php echo $data->NO_FACTURA?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->IMPORTE_DOC,2)?></td>
                                            <td align="right"><?php echo '$ '.number_format($saldo,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->IMPORTE,6)?></td>
                                            <td align="right"><?php echo '$ '.number_format($saldoInsoluto,6);?></td>
                                            <td><input type="checkbox" name="seleccionar" 
                                                doc="<?php echo $data->NO_FACTURA?>"
                                                monto="<?php echo $data->IMPORTE?>"
                                                class="sel">
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                 </tbody>
                                 </table>
                                 <a class="btn btn-success cep" >Elaborar CEP</a>
                      </div>
            </div>
        </div>
    </div>
</div>
<form action="index.v.php" method="post" id="FORM_ACTION">
    <input type="hidden" name="fol" value="" id="folios">    
    <input type="hidden" name="realizaCEP" value="" >    

</form>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">

    var i = 0;
    
    $(".cep").click(function(){
        var docs = '';
        var folios = "";
        $("input:checked").each(function(index){
            folios+= $(this).attr('doc')+",";
        });
        folios = folios.substr(0, folios.length-1);
        alert('Se crearan los CEP de los siguientes documentos'+ folios);
        document.getElementById('folios').value=folios;
        $("#FORM_ACTION").submit();
    })
        
    
</script>
