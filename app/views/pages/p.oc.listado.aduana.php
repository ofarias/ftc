<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Registro de aduana a Ordenes de compra
            </div>
            <!-- /.panel-heading -->
            <?php
                $fecha = getdate();
                $mes = $fecha['mon'];
                $anio = $fecha['year'];
                if(isset($_POST['mes'])) $mes = $_POST['mes'];
                if(isset($_POST['anio'])) $anio = $_POST['anio'];
                //echo "mes/anio = $mes/$anio";
            ?>
            <div class="panel-body">             
                <div class="table-responsive">  
                    <span>Seleccione el mes de trabajo</span>
                    <form action="index.php" method="post">
                        <input type="hidden" name="FORM_ACTION_OC_ADUANA_LISTA" value="FORM_ACTION_OC_ADUANA_LISTA" />
                        <select name="mes">
                            <option value="-">seleccione</option>
                            <option value="1" <?php echo ($mes==1)?"selected":"";?>>Enero</option>
                            <option value="2" <?php echo ($mes==2)?"selected":"";?>>Febrero</option>
                            <option value="3" <?php echo ($mes==3)?"selected":"";?>>Marzo</option>
                            <option value="4" <?php echo ($mes==4)?"selected":"";?>>Abril</option>
                            <option value="5" <?php echo ($mes==5)?"selected":"";?>>Mayo</option>
                            <option value="6" <?php echo ($mes==6)?"selected":"";?>>Junio</option>
                            <option value="7" <?php echo ($mes==7)?"selected":"";?>>Julio</option>
                            <option value="8" <?php echo ($mes==8)?"selected":"";?>>Agosto</option>
                            <option value="9" <?php echo ($mes==9)?"selected":"";?>>Septiembre</option>
                            <option value="10" <?php echo ($mes==10)?"selected":"";?>>Octubre</option>
                            <option value="11" <?php echo ($mes==11)?"selected":"";?>>Noviembre</option>
                            <option value="12" <?php echo ($mes==12)?"selected":"";?>>Diciembre</option>
                        </select>
                        <input type="text" name="anio" value="2016" maxlength="4" style="width: 70px;text-align: center;" />
                        <input type="submit" name="FORM_ACTIO_OC_ADUANA" value="Filtrar" />
                    </form>
                    <table class="table table-striped table-bordered table-hover" id="dataTables-oc-aduana">
                        <thead>
                            <tr>
                                <th>IDENTIFICADOR</th>
                                <th>PROVEEDOR</th>
                                <th>FECHA PAGO</th>
                                <th>IMPORTE</th>
                                <th>ADUANA</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>   
                        <tbody>

                            <?php
                            if ($exec != null) {
                                foreach ($exec as $data):
                                    ?>
                                <form action="index.php" method="post">
                                    <input type="hidden" name="FORM_ACTION_OC_ADUANA_REGISTRO" value="FORM_ACTION_OC_ADUANA_REGISTRO" />
                                    <tr class="odd gradeX">
                                        <td><?php echo $data->IDENTIFICADOR; ?>
                                            <input type="hidden" name="identificador" value="<?php echo $data->IDENTIFICADOR; ?>" />
                                            <input type="hidden" name="mes" value="<?php echo $mes;?>" />
                                            <input type="hidden" name="anio" value="<?php echo $anio;?>" />
                                        </td>
                                        <td><?php echo $data->NOMBRE; ?></td>
                                        <td><?php echo $data->FECHA_DOCUMENTO; ?></td>
                                        <td><?php echo "$ " . number_format($data->MONTO, 2, '.', ','); ?></td>
                                        <td>
                                            <select name="aduana" id="aduana">
                                                <option value="--">SELECCIONE</option>
                                                <option value="ACREEDOR">Acreedor</option>
                                                <option value="DEUDOR">Deudor</option>
                                                <option value="SALDADO">Saldado</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="submit" name="FORM_ACTION_OC_ADUANA" value="Actualizar" />
                                        </td>
                                    </tr>
                                </form>
                                <?php
                            endforeach;
                        } else {
                            ?>                               
                            <tr class="odd gradeX">
                                <td colspan="6">No hay datos</td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
