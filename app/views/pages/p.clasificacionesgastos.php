<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Clasificación de gastos 
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Clasificación</th>
                                <th>Descripción</th>
                                <th class="text-center">Editar</th>
                                <th class="text-center">Eliminar</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <td colspan="4"></td>
                                <td class="text-right"><a href="index.php?action=nuevaclagasto" class="btn btn-info">Agregar <i class="fa fa-plus"></i></a></td>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php foreach($exec as $row): ?>
                            <tr>
                                <td><?php echo $row->ID;?></td>
                                <td><?php echo $row->CLASIFICACION;?></td>
                                <td><?php echo $row->DESCRIPCION;?></td>
                                <form action="index.php" method="post">
                                 <input type="hidden" name="id" value="<?php echo $row->ID;?>"/>
                                <td class="text-center"><button type="submit" name="editclasificaciongasto" class="btn btn-warning"><i class="fa fa-pencil-square-o"></i></button></td>
                                <td class="text-center"><button type="submit" name="delclasificaciongasto" class="btn btn-warning" onclick="return confirm('¿Seguro que desea eliminar la cuenta?');" ><i class="fa fa-trash"></i></button></td>
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
