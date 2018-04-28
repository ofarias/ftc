<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                Solicitudes Pendientes.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>NUMERO</th>
                                            <th>ARCHIVO</th>
                                            <th>IMPORTE</th>
                                            <th>FECHA</th>
                                            <th>USUARIO</th>
                                            <th>STATUS</th>
                                            <th>DESCARGAR</th>
                                            <th>CARGA RESPUESTA</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                       foreach ($lay as $data): 

                                            $fecha = substr($data->FECHA, 0, 10);
                                            $hora = str_replace(':', '', substr($data->FECHA, 11,6));    
                                            $importe = round($data->IMPORTE);
                                            $archivo = 'LayOut_BBVA_'.$data->NUMERO.'_'.$fecha.' CDT'.$hora.'_'.$importe.'.txt';
                                        ?>
                                       <tr>
                                         <td><?php echo $data->NUMERO;?></td>
                                            <td><?php 'LayOut_BBVA'.$data->NUMERO;?></td>
                                            <td><?php echo $data->IMPORTE;?></td>
                                            <td><?php echo $data->FECHA?></td>
                                            <td><?php echo $data->USUARIO?></td>
                                            <td><?php echo $data->STATUS?></td>
                                            <td>
                                                <a href="app/LayoutBBVA/<?php echo $archivo?>" download="<?php echo $archivo?>">Descargar </a>
                                             </td> 
                                            <td>
                                                <form action="upload_bbva.php" method="post" enctype="multipart/form-data">
                                                <input type="file" name="fileToUpload" id="fileToUpload">
                                                
                                                <input type="submit" value="Subir Respuesta" name="submit">
                                                </form>
                                            </td>
                                            </form>
                                        </tr> 
                                        <?php endforeach; 
                                        ?>
                                 </tbody>
                                 </table>
            </div>
        </div>
    </div>
</div>

<div>
    <input type="button" name="Finalizar" value="Finaliza" onclick="cerrarVentana()">
</div>

<script type="text/javascript">
    
    function cerrarVentana(){
        window.close();
    }

</script>