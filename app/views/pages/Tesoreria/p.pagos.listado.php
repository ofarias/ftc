
<br/>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Confirmar Pagos
            </div>
<?php if(count($exec)>0){?>
            <div class="panel-body">
                <a href="index.php?action=pago_gastos">Ver gastos para pago</a>
                <div class="table-responsive">  
                    <span>Solicitud de pago</span>
                    <table class="table table-striped table-bordered table-hover" >
                        <thead>
                            <tr>
                                <th>PAGO <br/> BBVA</th>
                                <th>ORDEN <br/> COMPRA</th>
                                <th>PROVEEDOR</th>
                                <th>FECHA ELABORACION</th>
                                <th>RECOLECCION <br/> ENTREGA</th>
                                <th>FECHA ESTIMADA <br/> RECEPCION</th>
                                <th>PAGO REQUERIDO</th>
                                <th>CONFIRMADO</th>
                                <th>PAGO REQUERIDO</th> 
                            </tr>
                        </thead>   
                        <tfoot>
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
                                if ($urgencia == 'U') {
                                    $color = "style='background-color: #04C3DF;'";
                                } elseif ($color <= 1) {
                                    $color = "style='background-color: white;'";
                                } elseif ($color == 3) {
                                    $color = "style='background-color:#FFBF00;'";
                                } elseif ($color > 3 and $color < 7) {
                                    $color = "style='background-color:#81DAF5;'";
                                } elseif ($color >= 7) {
                                    $color = "style='background-color:red;color:#F1E2E2;opacity: 0.5;'";
                                }
                                ?>
                            <form action = "index.php" method="POST">  
                                <?php if(  ($data->BBVA != 2 and empty($data->USUARIO_PAGO)) OR strtoupper($data->TIPOPAGOR) != strtoupper('Tr') ){?>
                                <tr class="odd gradeX" <?php echo $color; ?> onmousemove="this.style.fontWeight = 'bold';
                                        this.style.cursor = 'pointer'" onmouseout="this.style.fontWeight = 'normal';
                                                this.style.cursor = 'default';" 
                                    onclick="seleccionaPago('<?php echo $data->CVE_DOC; ?>', '<?php echo $data->NOMBRE; ?>', '<?php echo $data->CVE_CLPV; ?>', '<?php echo $data->IMPORTE ?>', '<?php echo $data->FECHAELAB ?>');"
                                    >
                                <td>N/A</td>
                                <?php }elseif($data->BBVA == 2 and empty($data->USUARIO_PAGO) and ($data->TIPOPAGOR ==('Tr') OR $data->TIPOPAGOR == ('tr'))){?>
                                <tr>  
                                    <td><input type="checkbox" name="pagoLayout[]" value="<?php echo $data->CVE_DOC; ?>" id="layout" class="oc"> <br/>
                                        <a onclick="seleccionaPago('<?php echo $data->CVE_DOC; ?>', '<?php echo $data->NOMBRE; ?>', '<?php echo $data->CVE_CLPV; ?>', '<?php echo $data->IMPORTE ?>', '<?php echo $data->FECHAELAB ?>');"> Pago Directo</a>
                                    </td>
                                <?php }elseif(!empty($data->USUARIO_PAGO)){ ?> 
                                <tr  class="odd gradeX"  style='background-color:#ffe6e6'>    
                                    <td>LayOut <br/> <?php echo $data->USUARIO_PAGO?>  
                                        <br/> 
                                        <a onclick="seleccionaPago('<?php echo $data->CVE_DOC; ?>', '<?php echo $data->NOMBRE; ?>', '<?php echo $data->CVE_CLPV; ?>', '<?php echo $data->IMPORTE ?>', '<?php echo $data->FECHAELAB ?>');"> Pago Directo</a></td>

                                    <?php }?>

                                    <td><a href="index.php?action=documentodet&doc=<?php echo $data->CVE_DOC ?>"><?php echo $data->CVE_DOC; ?></a> <br/><font color="red">
                                        <?php echo (empty($data->STATUSTR) and !empty($data->USUARIO_PAGO))? 'Subir Layout':$data->STATUSTR ?></font> </td>

                                    <td><?php echo '('.$data->CVE_CLPV.') '.$data->NOMBRE?> <a href="index.php?action=verHistorialSaldo&prov=<?php echo $data->CVE_CLPV?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;" ><br/><?php echo '<font color = "red" size="2pxs"> Saldo ('.number_format($data->SALDOPROV*1.16,2).')</font>';?></a></td>
                                    
                                    <td><?php echo $data->FECHAELAB; ?></td>
                                    <td>
                                        <?php
                                        $tipo = $data->TE;
                                        $tipo = strtoupper($tipo);
                                        if ($tipo == 'REC') {
                                            $tipo = 'Recoleccion';
                                        } elseif ($tipo == 'ENT') {
                                            $tipo = 'Entrega';
                                        } echo $tipo;
                                        ?> 
                                    </td>
                                    <td><?php echo $data->FER; ?></td>
                                    <td><?php
                                        $tipor = $data->TIPOPAGOR;
                                        $tipor = strtoupper($tipor);
                                        if ($tipor == 'TR') {
                                            $tipor = 'Transferencia';
                                        } elseif ($tipor == 'CH') {
                                            $tipor = 'Cheque';
                                        } elseif ($tipor == 'E') {
                                            $tipor = 'Efectivo';
                                        } elseif ($tipor == 'CR') {
                                            $tipor = 'Credito';
                                        }
                                        echo $tipor;
                                        ?>
                                    </td>
                                    <td><?php echo $data->CONFIRMADO; ?></td>
                                    <!--<td><?php echo $data->URGENTE; ?></td>-->
                                    <td align="right"><font color="blue" size="2pxs"><?php echo "$ " . number_format($data->IMPORTE, 2, '.', ','); ?></font></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                     <button type="submit" name="layoutBBVA" value="enviar" class="btn btn-success" onclick="ocultar()" id="boton"> Generar LayOut BBVA</button> &nbsp; &nbsp;
                 </form>
                    <a href="index.php?action=verLayOut" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;" class="btn btn-success"> Ver LayOut</a>

                </div>
            </div>
<?php }?>
        </div>
    </div>
</div>
<form action="index.php" method="POST" id="FORM_ACTION_PAGOS">
    <input name="documento" id="docu" type="hidden" value=""/>
    <input name="proveedor" id="nomprov" type="hidden" value=""/>
    <input name="claveProveedor" id="cveprov" type="hidden" value=""/>
    <input name="importe" id="importe" type="hidden" value="" />
    <input name="fecha" id="fechadoc" type="hidden" value=""/>
    <input name="FORM_NAME" type="hidden" value="FORM_ACTION_PAGO"/>
</form>

<script language="javascript">

        function ocultar(){
            document.getElementById('boton').classList.add('hide');
        }
    

    function seleccionaPago(documento, proveedor, claveProveedor, importe, fecha) {
            document.getElementById("docu").value = documento;
            document.getElementById("nomprov").value = proveedor;
            document.getElementById("cveprov").value = claveProveedor;
            document.getElementById("importe").value = importe;
            document.getElementById("fechadoc").value = fecha;
            var form = document.getElementById("FORM_ACTION_PAGOS");
            form.submit();
        }
</script>