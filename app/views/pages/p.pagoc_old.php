<center><div class="alert alert-success" role="alert"><h2><?php echo $error?></h2></div></center>
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        Pagos Enero / Febrero del 2016
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
                                            # code...
                                        
                                        //foreach ($asigna as $data):
                                        
                                            //a.ID_PREOC, a.CVE_DOC, a.PXR, a.CVE_ART, b.REC_faltante      
                                        ?>
                                       <!-- <tr class="odd gradeX" <?php echo $color;?>>-->
                                       <tr>
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
                                           <td>
                                                <form action="index.php" method="post">
                                                <input name="docuold" type="hidden" value="<?php echo $data->CVE_DOC?>" />
                                                <input name="nomprovold" type="hidden" value="<?php echo $data->NOMBRE?>"/>
                                                <input name="cveprovold" type="hidden" value="<?php echo $data->CVE_CLPV?>"/>
                                                <input name="importeold" type="hidden" value="<?php echo $data->IMPORTE;?>" />
                                                <select name="tipopagoold" required="required">
                                                    <option>--Elige tipo de pago--</option>
                                                    <option value="tr">Transferencia</option>
                                                    <option value="cr">Credito</option>
                                                    <option value="e">Efectivo</option>
                                                    <option value="ch">Cheque</option>
                                                    <option value="sf">Saldo a Favor</option>
                                                </select>
                                            </td>
                                            <td><?php echo $data->IMPORTE;?></td>
                                            <td><input name="montoold" type="text" required="required" /></td>
                                            <td>
                                                <button name="fomrpago_old" type="submit" value="enviar" class="btn btn-warning">Pagar! <i class="fa fa-floppy-o"></i></button></td>
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