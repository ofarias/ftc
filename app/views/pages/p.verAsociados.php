<br/>
<div class="row">
    <div class="container">
        <div class="form-horizontal">
            <div class="panel panel-default">
                <div class="panel panel-heading">

                    <?php foreach ($asociados as $key):
                            $nombreM = $key->MAESTRO;
                            $nombreCC = $key->CCOMPRA;
                     ?>

                    <?php endforeach ?>

                    <h3>Clientes Asociados al Centro de Costo  "<?php echo $nombreCC?>"</h3>
                    <h3>Del Maestro "<?php echo $nombreM?>"</h3>

                </div>

                <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Clientes <br/>   
                           
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Clave</th>
                                            <th>Nombre</th>
                                            <th>RFC</th>
                                            <th>Direccion</th>
                                            <th>Direccion Entrega</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($asociados as $data): 
                                        ?>
                                        <tr class="odd gradeX" >
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->CLAVE;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->RFC;?></td>
                                            <td><?php echo $data->CALLE; ($data->NUMEXT)?"', '.$data->NUMEXT":'';?> </td>
                                            <td><?php echo $data->CAMPLIB7?></td>
                                            <td>
                                                <a href="index.php?action=verAsociados&cancela=1&cliente=<?php echo $data->CLAVE?>&cc=<?php echo $data->C_COMPRAS?>" class="btn btn-danger">Cancelar Asociacion </button>
                                                
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                      </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>