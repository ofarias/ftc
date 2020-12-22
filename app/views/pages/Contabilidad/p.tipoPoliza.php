<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Tipos de Polizas.</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="dataTables-table-3">
                        <thead>
                            <tr>
                                <th>Ln</th>
                                <th>Tipo</th>
                                <th>Descripcion</th>
                                <th>Clase SAT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $ln=0; foreach($info as $row):
                             $ln++; $clase='';
                             if($row->CLASSAT == 3){
                                $clase ='DIARIO';
                             }elseif ($row->CLASSAT == 1) {
                                $clase ='INGRESOS';
                             }elseif ($row->CLASSAT == 2) {
                                $clase ='EGRESOS';
                             }
                            ?>
                            <tr class="odd gradeX" >
                                <td><?php echo $ln;?></td>
                                <td><?php echo $row->TIPO;?></td>
                                <td><?php echo $row->DESCRIP;?></td>
                                <td><?php echo $row->CLASSAT.'  ('.$clase.')';?></td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>