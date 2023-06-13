
<br/>
<div class="form-horizontal col-lg-12">
    <div class="panel panel-default">
        <div class="panel panel-heading">
            <h3>Editar cuenta de gastos.</h3>
        </div>
        <br />
        <div class="panel panel-body">
            <form action="index.php" method="post">
                <?php foreach($exec as $row): ?>
                <div class="form-group text-right">
                        <div class="col-lg-12">
                            <label for="activo" class="inline control-label">Activo: </label>
                            <input type="checkbox" class="checkbox-inline" name="activo" value="S" <?php echo (($row->ACTIVO == 'S') ? "checked" : "") ?> /><br>
                        </div>
                </div>
                <br/>
                <div class="form-group">
                    <label for="concepto" class="col-lg-2 control-label">Concepto: </label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="concepto" placeholder="Concepto de la cuenta" value="<?php echo $row->CONCEPTO; ?>" required = "required"/><br>
                        </div>
                </div>
                <div class="form-group">
                    <label for="descripcion" class="col-lg-2 control-label">Descripción: </label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="descripcion" placeholder="Descripción de la cuenta" required = "required" value="<?php echo $row->DESCRIPCION; ?>"/><br>
                        </div>
                </div>
                <div class="form-group">
                    <label for="iva" class="col-lg-2 control-label">¿Causa IVA?: </label>
                        <div class="col-lg-10">
                            <select name="iva" required="required" class="form-control">
                                <option value="SI" <?php echo ($row->CAUSA_IVA == 'SI') ? "selected" : "" ;?> >Si</option>
                                <option value="NO" <?php echo ($row->CAUSA_IVA == 'NO') ? "selected" : "" ;?>>No</option>
                            </select>
                        </div>
                </div>
                <div class="form-group">
                    <label for="centrocostos" class="col-lg-2 control-label">Centro de costos: </label>
                        <div class="col-lg-10">
                            <select class="form-control" name="centrocostos" required = "required"><br/>
                                <option value="ventas" <?php echo ($row->CENTRO_COSTOS == 'ventas') ? 'selected' : ''; ?> >Ventas</option>
                                <option value="logistica" <?php echo ($row->CENTRO_COSTOS == 'logistica') ? 'selected' : ''; ?> >Logistica</option>
                                <option value="compras" <?php echo ($row->CENTRO_COSTOS == 'compras') ? 'selected' : ''; ?> >Compras</option>
                                <option value="costos" <?php echo ($row->CENTRO_COSTOS == 'costos') ? 'selected' : ''; ?> >Costos</option>
                                <option value="tesoreria" <?php echo ($row->CENTRO_COSTOS == 'tesoreria') ? 'selected' : ''; ?> >Tesorería</option>
                                <option value="cxc" <?php echo ($row->CENTRO_COSTOS == 'cxc') ? 'selected' : ''; ?> >CXC</option>
                                <option value="recibo" <?php echo ($row->CENTRO_COSTOS == 'recibo') ? 'selected' : ''; ?> >Recibo</option>
                                <option value="empaque" <?php echo ($row->CENTRO_COSTOS == 'empaque') ? 'selected' : ''; ?> >Empaque</option>
                                <option value="bodega" <?php echo ($row->CENTRO_COSTOS == 'bodega') ? 'selected' : ''; ?> >Bodega</option>
                            </select>
                        </div>
                </div>
                <div class="form-group">
                    <label for="cuentacontable" class="col-lg-2 control-label">Cuenta Contable: </label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="cuentacontable" placeholder="###-###-###" value="<?php echo $row->CUENTA_CONTABLE;?>"/><br>
                        </div>
                </div>

                 <div class="form-group">
                    <label for="provactual" class="col-lg-2 control-label"> Proveedor Actual: </label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" readonly="readonly" name="provactual" placeholder=" <?php echo ($row->PROVEEDOR)?>"  value="<?php echo $row->PROVEEDOR;?>"/><br>
                        </div>
                </div>
                <div class="form-group">
                    <label for="cuentacontable" class="col-lg-2 control-label">Proveedor Predeterminado:</label>
                    <div class="col-lg-10">
                    <select name="proveedor" class="form-control">
                        <option value="">--Selecciona Proveedor--</option>
                            <?php foreach($provgasto as $p){
                            echo '<option value="'.$p->CLAVE.'">'.$p->CLAVE.' -- '.$p->NOMBRE.'</option>';
                                } ?>
                     </select>
                     </div>
                </div>

                <div class="form-group">
                    <label for="gasto" class="col-lg-2 control-label">Gasto: </label>
                        <div class="col-lg-10">
                            <select class="form-control" name="gasto" required = "required">
                                <option value="variable" <?php echo ($row->GASTO == 'variable') ? "selected" : "" ;?> >Variable</option>
                                <option value="fijo" <?php echo ($row->GASTO == 'fijo') ? "selected" : "" ;?> >Fijo</option>
                            </select>
                        </div>
                </div>

                 <div class="form-group">
                    <label for="gasto" class="col-lg-2 control-label">Clasificacion Gasto: </label>
                        <div class="col-lg-10">
                            <select class="form-control" name="id_cla" required = "required"><br/>
                                <option value="<?php echo $row->ID_CLA ?>" ><?php echo ($row->ID_CLA)? $row->CLASIFICACION:'Seleccione una Clasificacion'?></option>
                                <?php foreach ($tipog as $key):?>
                                <option value="<?php echo $key->ID;?>"><?php echo $key->CLASIFICACION.' <--> '.$key->DESCRIPCION;?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                </div>

                <div class="form-group">
                    <label for="cuentacontable" class="col-lg-2 control-label">Periodicidad del gasto: </label>
                        <div class="col-lg-10">
                            <select name="periodo" required>
                                <option value="<?php echo $row->PERIODO?>"><?php echo $row->PERIODO? $row->PER_PAG:'Seleccione la periodicidad del pago'?></option>
                                <?php foreach ($per as $p){?>
                                    <option value="<?php echo $p->ID_P?>"><?php echo $p->TIPO?></option>
                                <?php }?>
                            </select>
                        </div>
                </div>
                <div class="form-group">
                    <label for="cuentacontable" class="col-lg-2 control-label">Fecha Inicial / Fecha Final: </label>
                        <div class="col-lg-10">
                            <input type="date" name="fi" value="" required>&nbsp;&nbsp;&nbsp;&nbsp;<input type="date" name="ff" value="" required>
                        </div>
                </div>

                <label for="presupuesto" class="col-lg-2 control-label">Presupuesto: </label>
                        <div class="col-lg-10">
<input type="number" class="form-control" name="presupuesto" placeholder="<?php echo "$ " . number_format($row->PRESUPUESTO,2,'.',',');?>" value="<?php echo number_format($row->PRESUPUESTO,2,'.',',');?>"/>
                            <br>
                        </div>
                </div>
                <div class="text-center">
                    <h4 class="h3">Retenciones </h4>
                </div>
                <div class="form-group">
                 <div class="text-center">   
                    <div class="col-lg-4">
                        <label for="retieneiva" class="inline control-label"> IVA </label>
                        <input type="checkbox" class="checkbox-inline" name="retieneiva" value="16" <?php echo ($row->IVA != 0) ? "checked" : ""; ?> />
                    </div>
                    <div class="col-lg-4">
                        <label for="retieneisr" class="inline control-label"> ISR </label>
                        <input type="checkbox" class="checkbox-inline" name="retieneisr" value="10" <?php echo ($row->ISR != 0) ? "checked" : ""; ?>/>
                    </div>
                    <div class="col-lg-4">
                        <label for="retieneflete" class="inline control-label">Flete </label>
                        <input type="checkbox" class="checkbox-inline" name="retieneflete" value="4" <?php echo ($row->FLETE != 0) ? "checked" : ""; ?>/>
                    </div>
                </div>
                </div>
                <br/>
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button name="guardacambioscuenta" type="submit" value="enviar" class="btn btn-warning">Guardar <i class="fa fa-floppy-o"></i></button>
                            <a form="formulario1" class="btn btn-danger" href="index.php?action=Catalogo_Gastos">Cancelar <i class="fa fa-floppy-o"></i></a>
                        </div>
                    </div>
                <input type="hidden" name="id" value="<?php echo $row->ID;?>"/>
                <?php endforeach; ?>
            </form>
        </div>
    </div>
</div>

