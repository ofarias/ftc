<br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Recepciones 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-ocf">
                                    <thead>
                                        <tr>
                                            <th>Ln</th>
                                            <th>Folio<br/>Pago</th>
                                            <th>Orden de Compra</th>
                                            <th>Fecha</th>
                                            <th>Proveedor</th>
                                            <th>Confirmador Pegaso</th>
                                            <th>Motivo</th>
                                            <th>Importe<br/> Fallido</th>
                                            <th>Detalle</th>
                                            <th>Procesar</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        $i=0;
                                        foreach ($ocf as $data): 
                                           $i++; 
                                           $oc = $data['OC'];
                                        ?>
                                        <tr class="odd gradeX" >
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $i;?></td>
                                            <td><?php echo $data['TP_TES']?></td>
                                            <td> <?php echo $data['OC'];?> <br/> <a href="index.php?action=detalleOC&doco=<?php echo $oc?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;" >Ver Original</a> </td>
                                            <td><?php echo $data['FECHA'];?></td>
                                            <td><?php echo $data['PROVEEDOR'];?></td>
                                            <td><?php echo $data['USUARIO'];?></td>
                                            <td><?php echo $data['MOTIVO'];?></td>
                                            <td align="right"><?php echo '$ '.number_format($data['SUBTOTAL'],2)?></td>
                                            <td><a href="index.php?action=verDetalleOCF&oc=<?php echo $oc?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;" class="btn btn-warning">Ver Detalle</a> </td>
                                            <td>
                                                <select name="sel<?php echo $i?>" onchange="acuerdo(<?php echo $i?>, '<?php echo $oc?>', this.value)">
                                                    <option value="99">Seleccione un Acuerdo</option>
                                                    <option value="1" id='s1' label="Nota de Credito">Nota de Credito</option>
                                                    <option value="2" id='s2' label="Saldo a Favor">Saldo a Favor</option>
                                                    <option value="3" id='s3' label="Devolicion de Dinero">Devolucion de Dinero</option>
                                                </select>
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
<script type="text/javascript">

    function acuerdo(ln, oc, a){
        var test = document.getElementById('s'+a);
        var test2 = test.getAttribute('label');
        if(confirm('Se cambiar a '+ test2)){
            if(a == 1 ){
                window.open('index.php?action=acuerdoNC&oc='+oc+'&a=1', 'popup', 'width=1200,height=820');          
            }else if(a == 2){
                window.open('index.php?action=acuerdoNC&oc='+oc+'&a=2', 'popup', 'width=1200,height=820');              
            }else if(a == 3){
                window.open('index.php?action=acuerdoNC&oc='+oc+'&a=3', 'popup', 'width=1200,height=820');          
            }
        }else{
            document.getElementById('sel'+ln).value=='99';
        }
    }

</script>