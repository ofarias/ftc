<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default" id="">
            <div class="panel-heading">
                Contactos del cliente.
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                 <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Dirección</th>
                                <th>Telefono</th>
                                <th>Email</th>
                                <th>Tipo</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($exec as $data):?>
                            <tr>
                                <td><?php echo $data->NOMBRE;?></td>
                                <td><?php echo $data->DIRECCION;?></td>
                                <td><?php echo $data->TELEFONO;?></td>
                                <td><?php echo $data->EMAIL;?></td>
                                <td><?php echo $data->TIPOCONTAC;?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                
                    <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>