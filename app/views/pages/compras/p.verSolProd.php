<br/>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Lista de Solicitudes de Productos de Ventas.
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-aplicapago">
                                    <thead>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Cant/Sol</th>
                                            <th>Vendedor</th>
                                            <th>Categoria</th>
                                            <th>Linea</th>
                                            <th>Marca</th>
                                            <th>Generico / Sinonimo</th>
                                            <th>Clave Distribuidor</th>
                                            <th>Modelo</th>
                                            <th>Empaque</th>
                                            <th>Auxiliar</th>
                                            <th>Seleccionar</th>
                                            <th>Produccion</th>
                                            <th>Rechazar</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($verSolicitudes as $data):
                                            $ids=$data->ID;
                                            ?>
                                        <tr>
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->CANTSOL;?></td>
                                            <td><?php echo $data->VENDEDOR;?></td>
                                            <td><?php echo $data->CATEGORIA;?></td>
                                            <td><?php echo $data->LINEA;?></td>
                                            <td><?php echo $data->MARCA;?></td>
                                            <td><?php echo $data->GENERICO;?> <br/> <?php echo $data->SINONIMO?> <br/> <?php echo $data->CALIFICATIVO?></td>
                                            <td><?php echo $data->CLAVE_FABRICANTE?></td>
                                            <td><?php echo $data->SKU_CLIENTE?></td>
                                            <td><?php echo $data->EMPAQUE?></td>
                                            <td><?php echo $data->AUXILIAR?></td>
                                            <form action="index.php" method="post">
                                            <input name="ids" type="hidden" value="<?php echo $data->ID?>"/>
                                            <input type="hidden" name="cotizacion" value="<?php echo $data->COTIZACION?>">
                                            <input type="hidden" name="vendedor" value="<?php echo $data->VENDEDOR?>">
                                            <input type="hidden" name="descripcion" id="desc" value="<?php echo $data->GENERICO?>" >
                                            <td>
                                                <button name="editaFTCART" type="submit" value="enviar" class="btn btn-info"> Seleccionar</button></td>
                                            <td>
                                                <button name="produccionFTCART" type="submit" value="enviar" class="btn btn-info">
                                                   <?php echo ($data->STATUS =='A')? 'En Produccion':'Alta Produccion'?></button></td>
                                            </td>
                                            <td>
                                                <input id="bt_<?php echo $data->ID?>" class="btn btn-danger" name="verSol" onClick="rechazar(<?php echo $data->ID?>, desc.value)" value="Rechazar">
                                            </td> 
                                            </form>      
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                      </div>
            </div>
        </div>
    </div>
<br />

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">
    
    function rechazar(ids, desc){
        var id = ids;
        document.getElementById('bt_'+ids).classList.add('hidden')
        alert('Se rechazara la Solicitud de alta del Producto :' + desc );
        window.open('index.php?action=rechazarSol&ids='+ids,"","width=800,height=800")
    }

</script>
