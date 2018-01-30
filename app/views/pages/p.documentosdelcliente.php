<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Documentos del cliente.</h4>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="">
                        <thead>
                            <tr>
                                <th>Documento</th>
                                <th>Descripción</th>
                                <th>Copias</th>
                                <th>Requerido</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <?php foreach($exec as $row): ?> 
                           
                            <tr>
                                <td><?php echo $row->NOMBRE;?></td>
                                <td><?php echo $row->DESCRIPCION;?></td>
                                <td><?php echo $row->COPIAS;?></td>
                                <td><?php echo $row->REQUERIDO;?></td>
                             <!--<form action="index.php" method="post">
                                 <input type="hidden" name="id" value="<?php echo $row->ID;?>"/>
                                 <td><button type="submit" name="editadocumentoC" class="btn btn-warning">Editar <i class="fa fa-pencil-square-o"></i></button></td>
                                </form> -->
                            </tr>
                            
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <!-- /.table-responsive -->
                </div>
            </div>
            <div class="panel-footer text-right">
                <form action="index.php" method="post">
                    <input type="hidden" name="clave_cliente" value="<?php echo $_SESSION['ClaveCliente'];?>"/>
                    <button name="AgregarDocumentoACliente" class="btn btn-info">Agregar <i class="fa fa-plus"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>
