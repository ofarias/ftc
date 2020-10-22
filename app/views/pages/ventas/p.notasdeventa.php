<br /><br />
<!--
<style type="text/css">
    td.details-control {
        background: url('app/views/images/cuadre.jpg') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('app/views/images/cuadre.jpg') no-repeat center center;
    }
</style>
-->
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           <font size="5px"> Notas de venta </font>
                           <br/>
                           Semana <input type="radio" name="p1" class="temp" value="s" <?php echo $p == 's'? 'checked':''?>> &nbsp;&nbsp;
                           Mes <input type="radio" name="p1" class="temp" value="m" <?php echo $p == 'm'? 'checked':''?> > &nbsp;&nbsp;
                           Año <input type="radio" name="p1" class="temp" value="a" <?php echo $p == 'a'? 'checked':''?> > &nbsp;&nbsp;
                           Todas <input type="radio" name="p1" class="temp" value="t"  <?php echo $p == 't'? 'checked':''?>> &nbsp;&nbsp;
                           Del &nbsp;&nbsp;<font color ="black"><input type="date" name="fi" id="fi" value="01.01.1990"></font> &nbsp;&nbsp; al &nbsp;&nbsp;<font color ="black"><input type="date" name="ff" value="01.01.1990" id="ff"></font>&nbsp;&nbsp;<label class="ir">Ir</label>
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-nv">
                                    <thead>
                                        <tr>
                                            <th> S </th>
                                            <th> F </th>
                                            <th> Nota  </th>
                                            <th> Cliente </th>
                                            <th> Fecha Doc<br/><font color="blue">Fecha Elab</font> </th>
                                            <th> Status </th>
                                            <th> Productos <br/> Partidas </th>
                                            <th> Piezas </th>
                                            <th> Subtotal </th>
                                            <th> IVA </th>
                                            <th> IEPS </th>
                                            <th> Descuentos </th>
                                            <th> Total </th>
                                            <th> Saldo </th>
                                            <th> Forma de Pago </th>
                                            <th> Factura </th>
                                            <th> Vendedor </th><
                                            <th> Reimpresion </th>

                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($info as $i):
                                        ?>
                                       <tr>
                                            <td WIDTH="1"><?php echo $i->SERIE?></td>
                                            <td WIDTH="1"><?php echo $i->FOLIO?></td>
                                            <td WIDTH="3" class="details-control detalles" ><?php echo $i->DOCUMENTO?> </td>
                                            <td ><?php echo '('.$i->CLIENTE.') '.$i->NOMBRE?><br/></td>
                                            <td><?php echo $i->FECHA_DOC?><br/><font color="blue"><?php echo $i->FECHAELAB?></font></td>
                                            <td WIDTH="3"><?php echo $i->STATUS?></td>
                                            <td align="center" WIDTH="3"><?php echo $i->PROD?></td>
                                            <td align="center" WIDTH="3"><?php echo $i->PIEZAS?> </td>
                                            <td align="right"><?php echo '$ '.number_format($i->SUBTOTAL,2)?></td>
                                            <td align="right"><?php echo '$ '.number_format($i->IVA,2)?></td>
                                            <td align="right"><?php echo '$ '.number_format($i->IEPS,2)?></td>
                                            <td align="right"><?php echo '$ '.number_format($i->DESC1,2)?></td>
                                            <td align="right"><?php echo '$ '.number_format($i->TOTAL,2)?></td>
                                            <td align="right"><?php echo '$ '.number_format($i->SALDO_FINAL,2)?></td>
                                            <td align="center"><?php echo $i->FP?></td>
                                            <td align="center"><button>Facturar</button></td>
                                            <td><?php echo $i->USUARIO?></td>
                                            <td><input type="button" name="" value="Reimpresion" class="btn-sm  btn-primary"></td>
                                        </tr>               
                                        <?php endforeach; ?>

                                 </tbody>
                                 </table>
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

    var p = '';
    $(".ir").click(function(){
        var fi = document.getElementById('fi').value
        var ff = document.getElementById('ff').value
        var p = $(".temp:checked").val()
        if(fi != ""){
            p = 'p'
        }
        window.open("index.v.php?action=verNV&p="+p+"&fi="+ fi + "&ff="+ff, "_self" )
    })

    $(".detalles").click(function(){

    })

    /*
    $(document).ready(function(){
        var table = $('#dataTables-nv')
            $('#dataTables-nv tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );
         
                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( format(row.data()) ).show();
                    tr.addClass('shown');
                }
            });
    });
    */
</script>