<meta http-equiv="Refresh" content="240">
<br /><br />
<div class="row">
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                 LISTA DE PEDIDOS EMBALADOS PENDIENTES POR FACTURAR o REMISIONAR.
                </div>
                        <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-table-2">
                                <thead>
                                    <tr>
                                        <th>Pedido</th>
                                        <th>Fecha Pedido</th>
                                        <th>Cliente</th>
                                        <th>Caja</th>
                                        <th>Fecha Caja</th>
                                        <th>Dias</th>
                                        <th>Docs CXC</th>
                                        <th>Recibir Documentos</th>
                                            <!--<th>No. de Factura</th>
                                            <th>Fecha Facturacion</th> -->
                                    </tr>
                                </thead>                                   
                                <tbody>
                                        <?php
                                        //var_dump($exec); 
                                        foreach ($exec as $data): ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $data->COTIZA;?></td>
                                            <td><?php echo $data->FECHAELAB?></td>
                                            <td><?php echo $data->CLIENTE?></td>
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->FECHA_CREACION;?></td>
                                            <td><?php echo $data->DIAS;?>
                                            <td><?php echo $data->DOCFACT;?></td>
                                            <td>
                                                <form action = "index.php" method="post">
                                                <input type="hidden" name="docfact" value ="si"/>
                                                <input type ="hidden" name= "idcaja" value = "<?php echo $data->ID;?>"/ >
                                                <button name = "docfact" type="submit" vale = "enviar" class="btn btn-primary" <?php echo ($data->DOCFACT == 'no')? :"disabled" ?>>Recibir </button>
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
<!--
<div class="row">
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                 PENDIENTES POR NC.
                </div>

                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-table-2">
                                <thead>
                                    <tr>
                                        <th>Factura</th>
                                        <th>Pedido</th>

                                            <th>Fecha Facturacion</th> 
                                    </tr>
                                </thead>                                   
                                <tbody>
                                        <?php
                                        //var_dump($exec); 
                                        foreach ($notascred as $data): ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $data->FACTURA;?></td>
                                            <td><?php echo $data->PEDIDO;?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
        </div>
    </div>
    
    <div class="row">
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                 PENDIENTES RE ENRUTAR.
                </div>

                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-table-2">
                                <thead>
                                    <tr>
                                        <th>Factura</th>
                                        <th>Pedido</th>
                                        <th>Caja</th>
                                        <th>Reenviar</th>

                                    </tr>
                                </thead>                                   
                                <tbody>
                                        <?php
                                        //var_dump($exec); 
                                        foreach ($reenruta as $data): ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $data->FACTURA;?></td>
                                            <td><?php echo $data->PEDIDO;?></td>
                                            <td><?php echo $data->CAJA;?></td>
                                            <form action="index-php" method="post">
                                            <input type="hidden" name="factura" value="<?php echo $data->FACTURA;?>"/>
                                            <input type="hidden" name="pedido" value="<?php echo $data->PEDIDO;?>"/>
                                            <input type="hidden" name="caja" value="<?php echo $data->CAJA;?>"/>
                                                <td><button name="reenviarcaja" class="btn btn-warning">Reenviar</button></td>
                                            </form>
                                        </tr>
                                        <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
        </div>
        -->
    </div>
</div>