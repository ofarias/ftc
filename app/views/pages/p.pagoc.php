<center><div class="alert alert-success" role="alert"><h2><?php echo $error?></h2></div></center>
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Confirmar Pagos de Suministros
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                           <th>ORDEN DE COMPRA</th>
                                            <th>PROVEEDOR</th>
                                            <th>FECHA ELABORACION</th>
                                            <th>RECOLECCION / ENTREGA</th>
                                            <th>FECHA ESTIMADA RECEPCION</th>
                                            <th>PAGO REQUERIDO</th>
                                            <th>CONFIRMADO</th>
                                            <th>URGENTE</th>
                                            <th>TIPO PAGO TESORERIA</th>
                                            <th>IMPORTE</th>
                                            <th>MONTO PAGO TESORERIA</th>
                                            <!--<th>PARA SUBIR ARCHIVO IMAGEN</th>-->
                                            <th>GUARDAR</th>
                                            <!--<th>TOTAL</th>
                                            <th>REST</th>
                                            <th>DOC ORIGEN</th>-->
                                            <!--<th>EDITAR</th>-->
                                        </tr>
                                    </thead>   
									<tfoot>
                                    <!--a.ID_PREOC, a.cve_doc, a.cve_art, d.camplib7, a.cant, a.pxr, c.nombre, a.fecha_doc_recep, a.doc_recep, a.DOC_RECEP_STATUS  -->
										<tr>
											<th colspan="11" style="text-align:right">Total:</th>
											<th></th>
										</tr>
									</tfoot>
                                  <tbody>
                                        <?php
                                        foreach ($exec as $data): 
                                            $color = $data->DIAS;
                                            $urgencia = $data->URGENTE;
                                            if ($urgencia == 'U'){
                                                $color = "style='background-color: #04C3DF;'";
                                            }elseif ($color <= 1 ){
                                               $color="style='background-color: white;'";             
                                            }elseif($color == 3 ){
                                               $color="style='background-color:#FFBF00;'";
                                            }elseif ($color > 3 and $color < 7 ){
                                            $color="style='background-color:#81DAF5;'";
                                            }elseif ($color >= 7 ){
                                            $color="style='background-color:red;'";
                                            }      
                                        ?>
                                       <!-- <tr class="odd gradeX" <?php echo $color;?>>-->
                                       <tr class="odd gradeX" <?php echo $color;?>>
                                       		 <!--<td><?php echo $data->ID_PREOC;?></td>-->
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <!--<td><?php echo $data->TE;?></td>-->
                                            <td><?php $tipo = $data->TE;
                                             $tipo = strtoupper($tipo);
                                            if ($tipo == 'E'){
                                             $tipo = 'Entrega';
                                            }elseif ($tipo == 'R'){
                                                $tipo = 'Recoleccion';
                                            }  echo $tipo;?> </td>
                                            <td><?php echo $data->FER;?></td>
                                            <td><?php 
                                                    $tipor = $data->TIPOPAGOR;
                                                    $tipor = strtoupper($tipor);
                                                    if ($tipor == 'TR'){
                                                        $tipor = 'Transferencia';
                                                        }elseif ($tipor =='CH'){
                                                        $tipor = 'Cheque';
                                                        }elseif ($tipor =='E'){
                                                        $tipor = 'Efectivo';
                                                        }elseif ($tipor =='E') {
                                                        $tipor = 'Efectivo';
                                                        }elseif($tipor == 'CR'){
                                                        $tipor = 'Credito';
                                                        }
                                                    echo $tipor;?></td>
                                            <td><?php echo $data->CONFIRMADO;?></td>
                                            <td><?php echo $data->URGENTE;?></td>
                                           <td>
                                                <form action="index.php" method="post">
                                                <input name="docu" type="hidden" value="<?php echo $data->CVE_DOC?>" />
                                                <input name="nomprov" type="hidden" value="<?php echo $data->NOMBRE?>"/>
                                                <input name="cveprov" type="hidden" value="<?php echo $data->CVE_CLPV?>"/>
                                                <input name="importe" type="hidden" value="<?php echo $data->IMPORTE?>" />
                                                 <input name="fechadoc" type="hidden" value="<?php echo $data->FECHAELAB?>"/>
                                                <select name="tipopago" required="required">
                                                    <option>--Elige tipo de pago--</option>
                                                    <option value="tr">Transferencia</option>
                                                    <option value="cr">Credito</option>
                                                    <option value="e">Efectivo</option>
                                                    <option value="ch">Cheque</option>
                                                    <option value="sf">Saldo a Favor</option>
                                                </select>
                                            </td>
                                            <td><?php echo $data->IMPORTE;?></td>
                                            <td><input name="monto" type="text" required="required" /></td>
                                            <td>
                                                <button name="fomrpago" type="submit" value="enviar" class="btn btn-warning">Pagar! <i class="fa fa-floppy-o"></i></button></td>
                                                </form>
                                             </tr>
                                            
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>