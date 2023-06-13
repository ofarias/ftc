<br/>
<br/>
<div class="row">

    <?php if($rol != 'bodega2'){?>
                <div class="col-lg-12">
                <div>
                <label> Impresion de Recepciones</label>
                <a class="btn btn-success" href="index.php?action=impresionRecepcion" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;" > Imprimir Recepcion</a>
                </div> 
                <br/>
                <?php if(!empty($asignaciones)){?>
                <div>
                    <label> Asignaciones desde Bodega </label>
                    <a href="index.php?action=asignacionesBodega" target="popup" onclick="window.open(this.href, this.target, 'width=1400,height=820'); return false;"  class="btn btn-info"?> Ver <?php echo count($asignaciones)?> Asignaciones Pendientes </a>
                </div>
                <br/>
                <?php }?>
<?php }?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Lista de Solicitudes de Productos de Ventas.
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-aplicapago">
                                    <thead>
                                        <tr>
                                            <th>Orde de <br/> compra</th>
                                            <th>Fecha de OC</th>
                                            <th>Clave / Nombre </th>
                                            <th>Usuario</th>
                                            <th>Unidad</th>
                                            <th>Operador</th>
                                            <th>Cantidad Solicitada <br/> Cantidad Pendiente</th>
                                            <th>Costo <br/> Bruto </th>
                                            <th>Valor IVA</th>
                                            <th>Costo Neto</th>
                                            <th>Recibir <br/> Mercancia</th>
                                            <th>Rechazar <br/> Orden de Compra</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        $fes= 0;
                                        foreach ($ordenes as $data):
                                                $color = '';
                                                if($data->VUELTAS == 0){
                                                    $pre='Pre-Ruta';
                                                    $color="style='background-color:#e8d1cf'";
                                                }else{
                                                    $pre ='';
                                                }
                                                $fe='';
                                                $hoy = date("Y-m-d");
                                                if($data->FECHA_ENTREGA > $hoy){
                                                    $color = "style='background-color: #b3d9ff'";
                                                    $fe = '<b>'.$data->FECHA_ENTREGA.'</b>';
                                                    $fes = 1;
                                                }

                                            ?>
                                        <tr class="odd gradex" <?php echo $color?> >
                                            <td><?php echo $data->CVE_DOC;?> <br/><?php echo $pre?></td>
                                            <td><?php echo $data->FECHAOC.'<br/>'.$fe?></td>
                                            <td><?php echo $data->CVE_CLPV. '/ '.$data->NOMBRE;?></td>
                                            <td><?php echo $data->USUARIO ;?></td>
                                            <td><?php echo $data->UNIDAD?></td>
                                            <td><?php echo $data->OPERADOR?></td>
                                            <td><?php echo $data->CANTIDAD.' / '.$data->PXR?></td>
                                            <td><?php echo '$ '.number_format($data->COSTO,2);?></td>
                                            <td><?php echo '$ '.number_format($data->COSTO *.16,2);?></td>
                                            <td><?php echo '$ '.number_format($data->COSTO * 1.16,2);?></td>
                                            <td>
                                                <!--<form action="index.php" method="post">-->
                                                    <input name="doco" type="hidden" value="<?php echo $data->CVE_DOC?>" id="doc_<?php echo $data->CVE_DOC?>"/>
                                                    
                                                    <button name="recibirOC" type="submit" value="enviar" <?php echo $data->STATUS_RECEPCION==9? 'class="btn btn-danger"':'class="btn btn-info"'?>  <?php echo ($data->STATUS_RECEPCION ==9 )? '':''?> onclick="Test1(<?php echo empty($data->STATUS_RECEPCION)? '0':$data->STATUS_RECEPCION?>, '<?php echo $data->CVE_DOC?>')" > <?php echo ($data->STATUS_RECEPCION == 9)? 'EN USO ':'Recibir Mercancia'?> </button>
                                                    <br/>
                                               <!-- </form> -->   
                                            </td>
                                            <td>
                                                <form action="index.php" method="post">
                                                    <input type="hidden" name="doco" value="<?php echo $data->CVE_DOC?>" />
                                                    <button name="rechazarOC" type="submit" value="enviar" class="btn btn-danger"  <?php echo ($data->STATUS_RECEPCION ==9 or $data->VUELTAS == 0 or $fes == 1)? 'disabled=disabled':''?>  >
                                                        Rechazar OC
                                                    </button>
                                                </form>
                                            </td>                       
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
    </div>
<br />

<form action="index.php" method="POST" id="recOC">
    <input type="hidden" value="" id="doc" name="doco">
    <input type="hiiden" value="" id="tip" name="tipo">
    <input type="hidden" value="" id="btn1" name="recibirOC">
</form>


<script type="text/javascript" language="JavaScript" src="app/views/bower_components/jquery/dist/jquery.min.js"></script>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">

            $(document).ready(function () {
                                           $('#pop').hide();
                                        });

    function Test1(n, b){
                               
        if(n == 9){
            var a = confirm('Desea desbloquear la orden?');
            if(a== true){  
                var c = document.getElementById('doc_'+b).value;
                document.getElementById('doc').value = c;
                document.getElementById('tip').value = 'enUso';
                var form = document.getElementById("recOC");
                form.submit();
            }
        }else{
            var c = document.getElementById('doc_'+b).value;
            document.getElementById('doc').value = c;
            document.getElementById('tip').value = 'Inicial';
            var form = document.getElementById("recOC");
            form.submit();
        }

    }
    
    function rechazar(ids, desc){
        //var recWindow = window.open("index.php?action=verSolProdVentas","Mensaje","width=200,height=100")
        //recWindow.document.write("<p> Esta es la ventana</p>")
        var id = ids;
        alert('Se rechazara la Solicitud de alta del Producto :' + desc );
        window.open('index.php?action=rechazarSol&ids='+ids,"","width=800,height=800")
    }

</script>
