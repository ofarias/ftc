<br/>
<div class="form-horizontal">
    <div class="panel panel-default">
        <div class="panel panel-heading">
            <h3>Crear nueva proyeccion </h3>
        </div>
        <br />
        <div class="panel panel-body">
           
                <div class="form-group">
                    <label for="cuentacontable" class="col-lg-2 control-label">Tipo: </label>
                        <div class="col-lg-10">
                            <select id="nt">
                                <option value="">Seleccione el tipo</option>
                                <option value="gasto">Gasto</option>
                                <option value="venta">Venta</option>
                            </select>
                        </div>
                </div>
    <div class="<?php echo $tipo=='B'? 'hidden':''?>">
                 <div class="form-group">
                    <label for="concepto" class="col-lg-2 control-label">Tipo Actual: </label>
                        <div class="col-lg-10">
                            <label class="form-control"><?php echo strtoupper($tipo)?> </label>
                        </div>
                </div>
                <form action="index.php" method="post" id="formulario1">

                <div class="form-group">
                    <label for="concepto" class="col-lg-2 control-label">Concepto: </label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="concepto" placeholder="Concepto" required = "required"/><br>
                        </div>
                </div>
                <div class="form-group">
                    <label for="descripcion" class="col-lg-2 control-label">Descripción: </label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="descripcion" placeholder="Descripción de la cuenta" required = "required"/><br>
                        </div>
                </div>
                <div class="form-group">
                    <label for="iva" class="col-lg-2 control-label">¿Causa IVA?: </label>
                        <div class="col-lg-10">
                            <select name="iva" required="required" class="form-control"><br/>
                                <option value="SI">Si</option>
                                <option value="NO">No</option>
                            </select>
                        </div>
                </div>
                <div class="form-group">
                    <label for="centrocostos" class="col-lg-2 control-label">Centro de costos:</label>
                        <div class="col-lg-10">
                            <select class="form-control" name="centrocostos" required = "required"><br/>
                                <option value="ventas">Ventas</option>
                                <option value="logistica">Logistica</option>
                                <option value="compras">Compras</option>
                                <option value="costos">Costos</option>
                                <option value="tesoreria">Tesorería</option>
                                <option value="cxc">CXC</option>
                                <option value="recibo">Recibo</option>
                                <option value="empaque">Empaque</option>
                                <option value="bodega">Bodega</option>
                            </select>
                        </div>
                </div>

                <div class="form-group">
                    <label for="cuentacontable" class="col-lg-2 control-label">Cuenta Contable: </label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="cuentacontable" placeholder="###-###-###" /><br>
                        </div>
                </div>

                <div class="form-group">
                    <label for="gasto" class="col-lg-2 control-label">Clasificacion: </label>
                        <div class="col-lg-10">
                            <select class="form-control" name="id_cla" required = "required"><br/>
                                <option value="">Seleccione una clasificación</option>
                                <?php foreach ($tipog as $key):?>
                                <option value="<?php echo $key->ID;?>"><?php echo $key->CLASIFICACION.' <--> '.$key->DESCRIPCION;?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                </div>

                <div class="form-group">
                    <label for="cuentacontable" class="col-lg-2 control-label">Periodicidad: </label>
                        <div class="col-lg-10">
                            <select name="periodo" required>
                                <option value="">Seleccione la periodicidad del pago</option>
                                <?php foreach ($per as $p){?>
                                    <option value="<?php echo $p->ID_P?>"><?php echo $p->TIPO?></option>
                                <?php }?>
                            </select>
                        </div>
                </div>

                <div class="form-group">
                <label for="presupuesto" class="col-lg-2 control-label">Presupuesto: </label>
                        <div class="col-lg-10">
                            <input type="number" step="any" min="0.0" class="form-control" name="presupuesto" placeholder="0.00" required = "required"/><br>
                        </div>
                </div>
                <div class="form-group">
                    <label for="gasto" class="col-lg-2 control-label">Tipo: </label>
                        <div class="col-lg-4">
                            <select class="form-control" name="gasto" required = "required">
                                <option value="variable"> Variable</option>
                                <option value="fijo" > Fijo</option>
                            </select>
                        </div>
                </div>
                <div class="form-group">
                    <label for="cuentacontable" class="col-lg-2 control-label">Fecha Inicial / Fecha Final: </label>
                        <div class="col-lg-10">
                            <input type="date" name="fi" value="" required>&nbsp;&nbsp;&nbsp;&nbsp;<input type="date" name="ff" value="" required>
                        </div>
                </div>

                <div class="text-center">
                    <h4 class="h3">Retenciones </h4>
                </div>
                <div class="form-group">
                    <div class="text-center">   
                        <div class="col-lg-4">
                            <label for="retieneiva" class="inline control-label"> IVA </label>
                            <input type="checkbox" class="checkbox-inline" name="retieneiva" value="16"/>
                        </div>
                        <div class="col-lg-4">
                            <label for="retieneisr" class="inline control-label"> ISR </label>
                            <input type="checkbox" class="checkbox-inline" name="retieneisr" value="10"/>
                        </div>
                        <div class="col-lg-4">
                            <label for="retieneflete" class="inline control-label">Flete </label>
                            <input type="checkbox" class="checkbox-inline" name="retieneflete" value="4"/>
                        </div>
                    </div>
                </div>

                <br/>
                <input type="hidden" name="tipo" value="<?php echo $tipo?>">
            </form>
        <div class="panel-footer">
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button name="guardanuevacuenta" form="formulario1" type="submit" value="enviar" class="btn btn-primary"> Guardar <i class="fa fa-floppy-o"></i></button>
                            <a form="formulario1" class="btn btn-danger" href="index.php?action=Catalogo_Gastos&tipo=<?php echo $tipo?>">Cancelar <i class="fa fa-floppy-o"></i></a>
                        </div>
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
    
    $("#nt").change(function(){
        var t = $(this).val()
        alert("Cambia a " + t)
        window.open("index.php?action=nuevogasto&tipo="+t, "_self")
    })

</script>