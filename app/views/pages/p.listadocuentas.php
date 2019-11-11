<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Estado de cuenta
            </div>
            <div class="panel-body">
                <div class="table-responsive">  
                    <span>Listado de cuentas bancarias</span>
                    <table class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                            <tr>
                                <th>BANCO</th>
                                <th>CUENTA</th>
                                <th>MONEDA</th>
                            </tr>
                        </thead>   
                        <tbody>
                            <?php $i=0; foreach ($exec as $data): $i++;?>
                                <tr class="odd gradeX" onmousemove="this.style.fontWeight = 'bold';
                                        this.style.cursor = 'pointer'" onmouseout="this.style.fontWeight = 'normal';
                                                this.style.cursor = 'default';"
                                    onclick="seleccionaCuenta(<?php echo $i?>);">
                                    <input name="identificador" id="<?php echo $i?>_identificador" type="hidden" value="<?php echo $data->ID; ?>"/>
                                    <input name="numero_cuenta" id="<?php echo $i?>_cuenta" type="hidden" value="<?php echo $data->NUM_CUENTA;?>"/>
                                    <input name="banco" id="<?php echo $i?>_banco" type="hidden" value="<?php echo $data->BANCO;?>"/>
                                    <td><?php echo $data->BANCO; ?></td>
                                    <td><?php echo $data->NUM_CUENTA; ?></td>
                                    <td><?php echo $data-> DESCR; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script language="javascript">
    function seleccionaCuenta(i) {
        var iden = document.getElementById(i+"_identificador").value 
        var banco = document.getElementById(i+"_banco").value
        var cuenta = document.getElementById(i+"_cuenta").value
        window.open("index.php?action=ESTADO_DE_CUENTA&identificador="+iden+"&banco="+banco+"&cuenta="+cuenta, "_self")
    }
</script>