<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Detalle del Recibo de Nomina del Empleado <font color="blue" size="4px"><?php echo $info['emp']->NOMBRE; ?></font> durante el periodo del <font color="black" size="4px"><?php echo $info['nom']->FECHA_INICIAL?></font> al <font color="black" size="4px"><?php echo $info['nom']->FECHA_FINAL?></font>.
                        </div>
<div class="row">
    <div class="container">
    <div class="form-horizontal col-lg-12">
        <div class="panel panel-default">
            <div class="panel panel-heading">
                <h3>Datos Generales del Empleado</h3>
            </div>
            <div class="panel panel-body">
                <form action="index.serv.php" method="post" id="formdoc">
                    <div class="form-group">
                        <label for="cliente" class="col-lg-10"><font color="grey">Nombre Completo:</font> <font size="4pxs"><?php echo $info['emp']->NOMBRE?></font></label>
                    </div>
                    <div class="form-group">
                        <label for="requerido" class="col-lg-10"><font color="grey"> RFC:</font> <?php echo $info['emp']->RFC?> -&nbsp;&nbsp;<font color="grey"> CURP:</font> <?php echo $info['emp']->CURP?> -&nbsp;&nbsp;<font color="grey"> Numero Seguro Social:</font> <?php echo $info['emp']->NSS?> </label>
                    </div>
                    <div class="form-group">
                        <label for="requerido" class="col-lg-10"><font color="grey">Fecha Inicio Laboral: </font><?php echo $info['nom_emp']->FECHAINICIORELLABORAL?>&nbsp;&nbsp;<font color="grey"> Antigüedad:</font> <?php echo $info['nom_emp']->ANTIGUEDAD?></label>  
                    </div>
                    <div class="form-group">
                        <label for="requerido" class="col-lg-10"><font color="grey">Numero Empleado:</font> <?php echo $info['nom_emp']->NUMEMPLEADO?> <font color="grey">Contrato:</font> <?php echo $info['nom_emp']->TIPOCONTRATO.'- '.$info['nom_emp']->CONTRATO?> &nbsp;&nbsp;<font color="grey"> Sindicalizado:</font> <?php echo $info['nom_emp']->SINDICALIZADO?> </label>
                            
                    </div>
                    <div class="form-group">
                        <label for="requerido" class="col-lg-10"><font color="grey">Departamento:</font> <?php echo empty($info['nom_emp']->DEPARTAMENTO)? '<font color="red">Sin Informacion</font>':$info['nom_emp']->DEPARTAMENTO?> <font color="grey">Puesto:</font> <?php echo $info['nom_emp']->PUESTO?> <font color="grey">Riesgo de puesto: </font> <?php echo $info['nom_emp']->RIESGOPUESTO.' - '.$info['nom_emp']->RIESGO?></label>
                    </div>
                    <div class="form-group">
                        <label for="requerido" class="col-lg-10"> <font color="grey">Tipo Jornada:</font> <?php echo $info['nom_emp']->TIPOJORNADA.' - '.$info['nom_emp']->JORNADA?> <font color="grey">Periodo de Pago:</font> <?php echo $info['nom_emp']->PERIODICIDADPAGO.' - '.$info['nom_emp']->PERIODO?> <font color="grey">Salario Base:</font> <?php echo '$ '.number_format($info['nom_emp']->SALARIOBASECOTAPOR,2)?> <font color="grey"> S.D.I</font> <?php echo '$ '.number_format($info['nom_emp']->SALARIODIARIOINTEGRADO,2)?></label>
                    </div>
                    <div class="form-group">
                        <label for="requerido" class="col-lg-10"><font color="grey">Dias Trabajados:</font><?php echo $info['nom']->DIAS?> <font color="grey">Entidad Federativa:</font> <?php echo $info['nom_emp']->CLAVEENTFED.' - '.$info['nom_emp']->ESTADO?></label>
                    </div>
                    <div class="form-group">
                        <label for="requerido" class="col-lg-10"><font color="grey">Banco:</font> <?php echo $info['nom_emp']->BANCO.' - '.$info['nom_emp']->BANCO_SAT?> <font color="grey">Cuenta:</font> <?php echo $info['nom_emp']->CUENTA_BANCARIA?></label> 
                    </div>
                    <div class="form-group">
                        <label for="requerido" class="col-lg-10"><font color="grey">UUID:</font> <?php echo $uuid?></label> 
                    </div>
                    <div class="form-group">
                        <label for="requerido" class="col-lg-10"> <a href="/uploads/xml/<?php echo $rfcempresa?>/Nomina/<?php echo $uuid.'.xml'?>" download type='button' class="btn btn-success">Descarga de XML</a></label>
                            
                    </div>
                <!--  Botones  checar si se ocupan luego para la impresion del Recibo o para algun calculo anual, etc.... igual para el calculo del finiquito a la fecha actual.??? Tambien podemos poner los calagos del SAT, informacion fiscal....
                <div class="panel-footer">
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button title="Al Guardar se queda predeterminado el nombre del cliente" name="nuevoUsuario" type="submit" value="enviar" class="btn btn-success" form="formdoc"> Guardar <i class="fa fa-floppy-o"></i>
                            </button>
                            <a class="btn btn-info" href="index.serv.php?action=altaUsuario">Limpiar Formulario</a>
                            <a class="btn btn-danger" onclick="window.close()">Cancelar<i class="fa fa-times"></i></a>
                        </div>
                    </div>
                </div>
                -->
            </div>
        </div>
    </div>
    </div>
</div>

<!-- Inicia la tabla con los movimientos de la nomina  -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-recnom">
                                    <thead>
                                        <tr>
                                            <th>Percepcion <br/> Deduccion</th>
                                            <th>Tipo</th>
                                            <th>Clave</th>
                                            <th>Concepto</th>
                                            <th>Gravado</th>
                                            <th>Exento</th> 
                                            <th>Total Percepcion</th>
                                            <th>Total Deduccion</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        $tp = 0; $td=0;
                                        foreach ($info['datos'] as $d):
                                            $perded = ''; $color = ''; 
                                            if($d->DED_PER =='P' or $d->DED_PER=='O'){
                                                $perded = 'Percipcion';
                                                $color = "style='background-color:#E0FFFF'";
                                                $tp = $tp + ($d->IMP_GRAVADO + $d->IMP_EXENTO);
                                            }elseif ($d->DED_PER =='D'){
                                                $perded ='Deduccion';
                                                $color = "style='background-color:#F08080'";
                                                $td = $td + ($d->IMP_GRAVADO + $d->IMP_EXENTO);
                                            }

                                        ?>
                                        <tr class="odd grax" <?php echo $color?>> 
                                            <td><?php echo $perded?></td>
                                            <td><?php echo $d->TIPO?></td>
                                            <td><?php echo $d->CLAVE?></td>
                                            <td><?php echo $d->CONCEPTO?></td>
                                            <td align="right"><?php echo '$ '.number_format($d->IMP_GRAVADO,2)?></td>
                                            <td align="right"><?php echo '$ '.number_format($d->IMP_EXENTO,2)?></td>
                                            
                                            <td align="right"><?php echo ($d->DED_PER=='P' or $d->DED_PER == 'O')? '$ '.number_format($d->IMP_GRAVADO + $d->IMP_EXENTO,2):number_format(0,2)?></td>
                                            <td align="right"><?php echo $d->DED_PER=='D'? '$ '.number_format($d->IMP_GRAVADO + $d->IMP_EXENTO,2):number_format(0,2)?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <footer>
                                            <td>Total a pagar </td>
                                            <td align="right"><?php echo '$ '.number_format($tp-$td,2)?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td align="right"></td>
                                            <td align="right"><?php echo '$ '.number_format($tp,2)?></td>
                                            <td align="right"><?php echo '$ '.number_format($td,2)?></td>
                                        </footer>
                                 </tbody>
                                 </table>
                      </div>
            </div>
        </div>
</div>
    <form action ="index.php" method="POST" id='FORM_EXEC'>
        <input type="hidden" name="impPreFact" value="" id="val">
        <input type="hidden" name="docf" value="" id="docf">
        <input type="hidden" name="tipo" value="" id="">
        <input type="hidden" name="cajas" value="" id="cu">
    </form>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">
    
</script>