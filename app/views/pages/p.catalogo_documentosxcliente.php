<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Clientes y requisitos asociados.</h4>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="dataTables-table-3">
                        <thead>
                            <tr>
                                <th>Clave</th>
                                <th>Cliente</th>
                                <th>Pertenece a:</th>
                                <th>Requisitos asociados</th>
                                <th>Cartera Cobranza</th>
                                <th>Cartera Revision</th>
                                <th>Dias Revision</th>
                                <th>Dias Pago</th>
                                <th>Dos Pasos</th>
                                <th>Plazo</th>
                                <th>Addenda</th>
                                <th>ADD_PORTAL</th>
                                <th>ENVIO</th>
                                <th>CP</th>
                                <th>Google MAPS</th>
                                <th>Modificar</th>
                                <th>Datos Cobranza</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($exec as $row): ?>
                            <tr>
                                <td><?php echo $row->CLAVE;?></td>
                                <td><?php echo $row->NOMBRE;?></td>
                                <td><?php echo $row->MAESTRO;?></td>
                                <td><?php echo $row->DOCUMENTOS_ASOCIADOS;?></td>
                                <td><?php echo $row->CARTERA_COBRANZA;?></td>
                                <td><?php echo $row->CARTERA_REVISION;?></td>
                                <td><?php echo $row->DIAS_REVISION;?></td>
                                <td><?php echo $row->DIAS_PAGO;?></td>
                                <td><?php echo $row->REV_DOSPASOS;?></td>
                                <td><?php echo $row->PLAZO;?></td>
                                <td><?php echo $row->ADDENDA;?></td>
                                <td><?php echo $row->ADD_PORTAL;?></td>
                                <td><?php echo $row->ENVIO;?></td>
                                <td><?php echo $row->CP;?></td>
                                <td><?php echo $row->MAPS;?></td>
                               <!-- <form action="index.php" method="post"> -->
                                <!-- <input type="hidden" name="clave" value="<?php echo $row->CLAVE;?>"/> -->
                                <td><a href="index.php?action=documentosdelcliente&clave=<?php echo $row->CLAVE;?>" class="btn btn-warning">Requisitos <i class="fa fa-pencil-square-o"></i></a></td>
                                <td>
                                    <form action="index.php" method="post">
                                        <input type="hidden" name="idcliente" value="<?php echo $row->CLAVE;?>"/>
                                        <button type="submit" name="datosCarteraCliente" class="btn btn-info">Datos cartera <i class="fa fa-pencil-square-o"></i></button>
                                    </form>
                                </td>
                                <!--</form>-->
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                    <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
