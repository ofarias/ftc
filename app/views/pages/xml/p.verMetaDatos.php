<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>REGISTRO DE METADATOS</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="dataTables-table-3">
                        <thead>
                            <tr>
                                <th>Ln</th>
                                <th>Archivo</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Final</th>
                                <th>Regsitros</th>
                                <th>Fecha Cancelacion</th>
                                <th>Cancelados</th>
                                <th>Usuario</th>
                                <th>Fecha de Carga</th>
                                <th>Ver Detalle</th>   
                            </tr>
                        </thead>
                        <tbody>
                            <?php $ln=0; foreach($md as $row):
                            $ln++;
                            $color='';
                            $aviso='';
                            $color = "style='background-color:#D5F3DE';";
                           
                            $aviso = "title='Los Metadados se cargan Cada fin de semana de forma en automatica y reflejan los Documentos cancelados en el SAT'";
                                //$color="style='background-color:brown;'";
                            ?>
                            <tr class="odd gradeX" <?php echo $color?> <?php echo $aviso?>>
                                <td><?php echo $ln;?></td>
                                <td><?php echo $row->ARCHIVO;?></td>
                                <td><?php echo $row->FECHA_INI;?></td>
                                <td><b><?php echo $row->FECHA_FIN?></b></td>
                                <td><?php echo $row->REGISTROS;?></td>
                                <td><?php echo $row->FECHA_CANCELACION;?></td>
                                <td><b><?php echo $row->CANCELADOS;?></b></td>
                                <td><?php echo $row->USUARIO;?></td>
                                <td><?php echo $row->FECHA_CARGA?></td>
                                <td><a href="index.xml.php?action=verMetaDatosDet&archivo=<?php echo $row->ARCHIVO?>" target="popup" onclick="window.open(this.href, this.target, 'width=2000, heigth=800')" class="btn btn-info">Ver Detalle</a></td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">

 
</script>