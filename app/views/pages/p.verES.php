<br />
<div class="row">
    <br />
</div>
<div class="row">
    <div class="col-md-6">
        <form action="index.php" method="post">
          <div class="form-group">
            <input type="text" name="fechaini" class="form-control" placeholder="Fecha inicial" required="required"  id="date1"> <br/>
            <input type="text" name="fechafin" class="form-control" placeholder="Fecha Final" required="required" id="date2">

          </div>
          <button type="submit" value = "enviar" name="verES" class="btn btn-default">Ver Reporte de Entradas y salidas</button>
          </form>
    </div>
</div>
<br />

<?php if($es != 1 ){?>
<br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           RESUMEN DE MOVIMIENTOS DEL <?php echo $fechaini.' al '.$fechafin?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios">
                                    <thead>
                                        <tr>
                                            <th>CLAVE</th>
                                            <th>DESCRIPCION</th>
                                            <th>INICIAL</th>
                                            <th>ENTRADAS</th>
                                            <th>SALIDAS</th>
                                            <th>EXISTENCIAS FINALES</th>
                                        </tr>
                                    </thead> 
                                    <tfoot>
                                        <th colspan="11"></th>
                                        <th><button type="submit" form="productosrecibidos" name="ImpRecepVal" class ="btn btn-info" formtarget="_blank">Imprimir <i class="fa fa-print"></i></button></th>
                                    </tfoot>                                 
                                  <tbody>
                                        <?php 
                                        foreach ($es as $data): 
                                            
                                            ?>
                                        <tr>
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->CVE_ART;?></td>
                                            <td><?php echo $data->DESCR;?></td>
                                            <td><?php echo $data->INICIAL;?></td>
                                            <td><?php echo $data->ENTRADAS;?></td>
                                            <td><?php echo $data->SALIDAS;?></td>
                                            <td><?php echo $data->EXISTENCIAS;?></td>     
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
<?php }else{ }?>

<!--
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">
    
  $(document).ready(function() {
    $("#date1").datepicker({dateFormat: 'dd.mm.yy'});
  });


  $(document).ready(function() {
    $("#date2").datepicker({dateFormat: 'dd.mm.yy'});
  });


</script>
-->