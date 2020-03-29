<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Detalle del Recibo de Nomina del Empleado <font color="blue"><?php echo $info['emp']->NOMBRE; ?></font> durante el periodo del <font color="black"><?php echo $info['nom']->FECHA_INICIAL?></font> al <font color="black"><?php echo $info['nom']->FECHA_FINAL?></font>.
                        </div>
<!-- Inicia los datos del empleado -->

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
                        <label for="cliente" class="col-lg-8 ">Nombre Completo: <?php echo $info['emp']->NOMBRE?></label>
                    </div>
                    <div class="form-group">
                        <label for="requerido" class="col-lg-8 ">RFC: <?php echo $info['emp']->RFC?> -&nbsp;&nbsp;- CURP: <?php echo $info['emp']->CURP?> -&nbsp;&nbsp;- Numero Seguro Social: <?php echo $info['emp']->NSS?> </label>
                    </div>
                    <div class="form-group">
                        <label for="requerido" class="col-lg-8 ">Fecha Inicio Laboral: <?php echo $info['nom_emp']->FECHAINICIORELLABORAL?>&nbsp;&nbsp;-- Antigüedad: <?php echo $info['nom_emp']->ANTIGUEDAD?></label>  
                    </div>
                    <div class="form-group">
                        <label for="requerido" class="col-lg-8 ">Numero Empleado: <?php echo $info['nom_emp']->NUMEMPLEADO?> Contrato: <?php echo $info['nom_emp']->TIPOCONTRATO?> &nbsp;&nbsp; Sindicalizado: <?php echo $info['nom_emp']->SINDICALIZADO?> </label>
                            
                    </div>
                    <div class="form-group">
                        <label for="requerido" class="col-lg-8 ">Departamento: <?php echo empty($info['nom_emp']->DEPARTAMENTO)? '<font color="red">Sin Informacion</font>':$info['nom_emp']->DEPARTAMENTO?> Puesto: <?php echo $info['nom_emp']->PUESTO?> Riesgo de puesto: <?php echo $info['nom_emp']->RIESGOPUESTO?></label>
                    </div>
                    <div class="form-group">
                        <label for="requerido" class="col-lg-8 "> Tipo Jornada: <?php echo $info['nom_emp']->TIPOJORNADA?> Periodo de Pago: <?php echo $info['nom_emp']->PERIODICIDADPAGO?> Salario Base: <?php echo '$ '.number_format($info['nom_emp']->SALARIOBASECOTAPOR,2)?> S.D.I <?php echo '$ '.number_format($info['nom_emp']->SALARIODIARIOINTEGRADO,2)?></label>
                                                </div>
                    <div class="form-group">
                        <label for="requerido" class="col-lg-8 ">Entidad Federativa: <?php echo $info['nom_emp']->CLAVEENTFED?> Banco: <?php echo $info['nom_emp']->BANCO?> Cuenta: <?php echo $info['nom_emp']->CUENTA_BANCARIA?></label>
                            
                    </div>
                    <div class="form-group">
                        <label for="requerido" class="col-lg-8 "><a href="" type='button' class="btn btn-success">Descarga de XML</a></label>
                            
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
                                            if($d->DED_PER =='P'){
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
                                            <td align="right"><?php echo $d->DED_PER=='P'? '$ '.number_format($d->IMP_GRAVADO + $d->IMP_EXENTO,2):number_format(0,2)?></td>
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