<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Detalle del archivo de Metadatos <?php echo $archivo?></h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="dataTables-table-3">
                        <thead>
                            <tr>
                                <th>Ln</th>
                                <th>UUID</th>
                                <th>RFC <br/> Emisor</th>
                                <th>Nombre Emisor</th>
                                <th>RFC <br/> Receptor</th>
                                <th>Nombre Receptor</th>
                                <th>RFC PAC</th>
                                <th>Fecha de Emision</th>
                                <th>Fecha Certificacion</th>
                                <th>Monto</th>
                                <th>Efecto Comprobante</th>
                                <th>Status</th>
                                <th>Fecha De Cancelacion</th>
                                <th>Polizas</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $ln=0; foreach($md as $row):
                            $ln++;
                            $color='';
                            $aviso='';
                            $status = 'Cargado';
                            $color = "style='background-color:#DCE7F9';";
                            if(!empty($row->FECHA_CANCELACION)){
                                $color = "style='background-color:#DC8496';";
                            }
                            $aviso = '';
                            if($row->CARGA == 0){
                                $color = "style='background-color:red';";
                                $status = 'Falta';
                            }
                                //$color="style='background-color:brown;'";
                            ?>
                            <tr class="odd gradeX" <?php echo $color?> <?php echo $aviso?>>
                                <td><?php echo $ln;?></td>
                                <td><?php echo $row->UUID?></td>
                                <td><?php echo $row->RFCE?></td>
                                <td><?php echo $row->NOMBRE_EMISOR?></td>
                                <td><?php echo $row->RFCR?></td>
                                <td><?php echo $row->NOMBRE_RECEPTOR?></td>
                                <td><?php echo $row->RFCPAC?></td>
                                <td><?php echo $row->FECHA_EMISION?></td>
                                <td><?php echo $row->FECHA_CERTIFICACION?></td>
                                <td align="right"><?php echo '$ '.number_format($row->MONTO,2)?></td>
                                <td><?php echo $row->EFECTO_COMPROBANTE?></td>
                                <td title="Cero es Cancelado, Uno es Vigente"><?php echo $row->STATUS?></td>
                                <td><?php echo $row->FECHA_CANCELACION?></td>
                                <td><?php echo $row->POLIZA?></td>
                                <td><?php echo $status ?></td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">

 
</script>