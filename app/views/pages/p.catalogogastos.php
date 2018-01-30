<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Gastos
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                        <thead>
                            <tr>
                                <th>Clave</th>
                                <th>Concepto</th>
                                <th>Descripción</th>
                                <th>IVA</th>
                                <th>Centro de costos</th>
                                <th>Cuenta Contable</th>
                                <th>Gasto</th>
                                <th>Presupuesto</th>
                                <th>Editar</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <td colspan="8"></td>
                                <td><a target="_blank" href="index.php?action=imprimircatgastos" class="btn btn-info">Imprimir <i class="fa fa-print"></i></a></td>
                                <td><a href="index.php?action=nuevogasto" class="btn btn-info">Agregar <i class="fa fa-plus"></i></a></td>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php foreach($exec as $row): ?>
                            <tr>
                                <td><?php echo $row->CLAVE;?></td>
                                <td><?php echo $row->CONCEPTO;?></td>
                                <td><?php echo $row->DESCRIPCION;?></td>
                                <td><?php echo $row->CAUSA_IVA;?></td>
                                <td><?php echo $row->CENTRO_COSTOS;?></td>
                                <td><?php echo $row->CUENTA_CONTABLE;?></td>
                                <td><?php echo $row->GASTO;?></td>
                                <td><?php echo '$ ' . number_format($row->PRESUPUESTO,2,'.',',');?></td> 
                                <form action="index.php" method="post">
                                 <input type="hidden" name="id" value="<?php echo $row->ID;?>"/>
                                <td><button type="submit" name="editcuentagasto" class="btn btn-warning"><i class="fa fa-pencil-square-o"></i></button></td>
                                <td><button type="submit" name="delcuentagasto" class="btn btn-warning" onclick="return confirm('¿Seguro que desea eliminar la cuenta?');" ><i class="fa fa-trash"></i></button></td>
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
