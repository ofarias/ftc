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
                                <th>Archivos <br/> Cargados</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <?php foreach($caratula as $row): ?> 
                           
                            <tr>
                                <td><?php echo $row->NOMBRE;?></td>
                                <td><?php echo $row->DESCRIPCION;?></td>
                                <td><?php echo $row->COPIAS;?></td>
                                <td><?php echo $row->REQUERIDO;?></td>
                                <td align="center"><?php echo !empty($row->ARCHIVOS)? '<a href="index.php?action=verComprobantesRecibo&idc='.$idc.'" target="pop-up" '.'>'.$row->ARCHIVOS.' Archivos</a>':'Sin Archivos'?></td>
                                <td>
                                    <form action="upload_comprobante_recibo.php" method="post" enctype="multipart/form-data">
                                        <input type="file" name="fileToUpload" id="fileToUpload" required="required">
                                        <input type="hidden" name="idc" value="<?php echo $idc?>">
                                        <input type="hidden" name="cl" value="<?php echo $cl?>">
                                        <input type="hidden" name="fecha" value="<?php echo $fecha?>">
                                        <input type="hidden" name="iddoc" value="<?php echo $row->ID_DOC?>">
                                        <input type="submit" value="Subir Pedido" name="submit" <?php echo (!empty($data->NOMBRE_ARCHIVO))? 'disabled=disabled':'' ?>>
                                    </form>
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
