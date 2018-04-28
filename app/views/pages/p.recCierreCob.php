<br/>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Lista de Documentos Pendientes de Recibir.
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>ID / FOLIO BANCO</th>
                                            <th>FECHA EDO CTA</th>
                                            <th>MONTO</th>
                                            <th>APLICACIONES</th>
                                            <th>SALDO</th>
                                            <th>BANCO</th>
                                            <th>FECHA EDO CTA</th>
                                            <th>Recibir</th>
                                            
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($documentos as $data): 
                                                
                                            if($data->CIERRE_CONTA == 4){

                                                $tipo = 'Solicitud Acreedor';
                                                $color="style='background-color:yellow;'";
                                            }elseif ($data->CIERRE_CONTA == 1) {
                                                $tipo = 'Aplicaciones';
                                                $color="style='background-color:green;'";
                                            }
                                            ?>
                                        <tr class="odd gradeX" <?php echo $color;?> >
                                            <td><?php echo $data->ID.' / '.$data->FOLIO_X_BANCO;?></td>
                                            <td><?php echo $data->FECHA_RECEP;?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->MONTO,2);?></td>
                                            <td><?php echo '$ '.number_format($data->APLICACIONES,2);?></td>
                                            <td><?php echo '$ '.number_format($data->SALDO,2);?></td>
                                            <td><?php echo $data->BANCO?></td>
                                            <form action="index.php" method="post">
                                            <td>
                                                <input type="text" name="fecha" value="<?php echo $data->FECHA_RECEP?>" class="datepicker" required="required">
                                            </td>
                                            <td>
                                                <button name="recDocCierreCob" value = "enviar" type="submit" class="btn btn-danger" id="btnRec" onclick="ocultar()" >Recibir</button>
                                            </td>
                                            <input name="idp" type="hidden" value="<?php echo $data->ID?>"/>
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

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

<script>
        
   $(document).ready(function() {
    $(".datepicker").datepicker({dateFormat:'dd.mm.yy'});
  } );



   function ocultar(){
    document.getElementById("btnRec").classList.add('hide');
   }
</script>