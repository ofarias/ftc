<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Listado de cuentas bancarias
            </div>
            <div class="panel-body">
                <div class="table-responsive">  
                    <span></span>
                <?php if(count($exec) >0 ){?>
                    <table class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                            <tr>
                                <th>BANCO</th>
                                <th>CUENTA</th>
                                <th>MONEDA</th>
                            </tr>
                        </thead>   

                        <tbody>
                            <?php foreach ($exec as $data): ?>
                                <tr class="odd gradeX" onmousemove="this.style.fontWeight = 'bold';
                                        this.style.cursor = 'pointer'" onmouseout="this.style.fontWeight = 'normal';
                                                this.style.cursor = 'default';"
                                    onclick="seleccionaCuenta('<?php echo $data->ID; ?>','<?php echo $data->BANCO;?>','<?php echo $data->NUM_CUENTA;?>');">
                                    <td><?php echo $data->BANCO; ?></td>
                                    <td><?php echo $data->NUM_CUENTA; ?></td>
                                    <td><?php echo $data->DESCR; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php }else{?>
                    <div class="alert-danger"><center><h2>No existen cuentas bancarias</h2><center></div>
                <?php }?>
                </div>
            </div>
        </div>
    </div>
</div>
<form action="index.php" method="POST" id="FORM_ACTION_ESTADOCUENTA">
    <input name="identificador" id="identificador" type="hidden" value=""/>
    <input name="numero_cuenta" id="cuenta" type="hidden" value=""/>
    <input name="banco" id="banco" type="hidden" value=""/>
    <input name="ESTADO_DE_CUENTA_DOCS" type="hidden" value="ESTADO_DE_CUENTA_DOCS"/>
</form>

<script language="javascript">
    function seleccionaCuenta(identificador, banco, cuenta) {
        document.getElementById("identificador").value = identificador;
        document.getElementById("banco").value = banco;
        document.getElementById("cuenta").value = cuenta;
        var form = document.getElementById("FORM_ACTION_ESTADOCUENTA");
        form.submit();
    }
</script>