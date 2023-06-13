<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Catalogo de requisitos.</h4>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Modificar</th>
                                
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <td colspan="3"></td>
                                <td><a href="index.php?action=nuevo_documentoC" class="btn btn-info">Agregar <i class="fa fa-plus"></i></a></td>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php foreach($exec as $row): ?>
                            <tr>
                                    <td><?php echo $row->ID;?></td>
                                    <td><?php echo $row->NOMBRE;?></td>
                                    <td><?php echo $row->DESCRIPCION;?></td>
                                    <form action="index.php" method="post">
                                     <input type="hidden" name="id" value="<?php echo $row->ID;?>"/>
                                     <td><button type="submit" name="editadocumentoC" class="btn btn-warning">Editar <i class="fa fa-pencil-square-o"></i></button></td>
                                   
                                 </form>
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