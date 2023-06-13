<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Pagos por Cheques
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios1">
                                    <thead>
                                        <tr>
                                            <th>FOLIO PEGASO</th>
                                            <th>ORDEN DE COMPRA</th>
                                            <th>BENEFICIARIO</th>
                                            <th>FECHA DE REGISTRO</th>
                                            <th></th>
                                            <th>MONTO</th>
                                            <th>ESTATUS</th>
                                            <th>BANCO</th>
                                            <th>FECHA</th>
                                            <th>FOLIOS</th>
                                            <th>IMPRIMIR CHEQUE</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php
                                        foreach ($listado as $data): 
                                              $fecha=date('d-m-Y');
                                              $i++;
                                                
                                            ?>
                                        <tr class="odd gradeX" >
                                            <td><?php echo $data->CHEQUE;?></td>
                                            <td><?php echo $data->DOCUMENTO;?></td>
                                            <td><?php echo $data->BENEFICIARIO;?></td>
                                            <td><?php echo $data->FECHA;?></td>
                                            <td><?php echo $data->FECHA_APLI;?></td>
                                            <td><?php echo $data->MONTO;?></td>
                                            <td><?php echo $data->STATUS;?></td>
                                            <td><?php echo $data->BANCO;?></td>
                                            <form action="index.php" method="POST">
                                            <td>
                                            <input type="text" class = "d" name="fechapost" value="<?php echo $fecha;?>" >
                                            </td> 
                                            <td>
                                                <input type="text" name="folion" value= "<?php echo $folios;?>" >
                                            </td>
                                            <input type="hidden" name="cheque" value="<?php echo $data->CHEQUE;?>">
                                            <input type="hidden" name="banco" value="<?php echo $data->BANCO;?>">
                                            <!--<center><a href="index.php?action=impCheque&cheque=<?php echo $data->CHEQUE;?>&banco=<?php echo $data->BANCO;?>"><i class="fa fa-print"></i></a></center></td>-->
                                            <td>
                                            <button type="submit" value="impCheque" name="impCheque"><i class="fa fa-print"></i></button>
                                            </td>
                                            </form>
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

    
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
  <script>

  $(document).ready(function() {
    $(".d").datepicker({dateFormat: 'dd-mm-yy'});
  } );
  
  
  </script>