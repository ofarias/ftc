<br /><br />
<div>
    <?php if($_SESSION['user']->USER_LOGIN == 'ofarias'){?>
        <form action="upload_txt.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="fileToUpload" id="fileToUpload" required="required">
            <input type="submit" value="Catalogos de cuentas" name="submit">
        </form>
    <br/>
        <form action="upload_xls.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="fileToUpload" id="fileToUpload" required="required" accept=".xls, .xlsx">
            <input type="submit" value="Poliza Contpaq" name="submit">
        </form>
    <?php }?>
</div>
<br/>
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
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Periodos Detectados</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-folios_pol">
                        <thead>
                            <tr>
                                <th align="center">Ln</th>
                                <th align="center">Ejercicio</th>
                                <th align="center">Periodo</th>
                                <th align="center">Status</th>
                                <?php foreach ($info as $row2):?>
                                    <th align="center" ><?php echo 'Polizas de '.$row2->TIPO.' Calculadas'?></th>
                                <?php endforeach?>
                                <th align="center">Actualizar Folios</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $ln=0; foreach($admper as $per):
                             $ln++;
                            ?>
                            <tr class="odd gradeX" >
                                <td align="center"><?php echo $ln;?></td>
                                <td align="center"><?php echo $per->EJERCICIO;?></td>
                                <td align="center"><?php echo $per->PERIODO;?></td>
                                <td align="center"><?php echo $per->CERRADO?></td>
                                <?php $a = 0; for($i=0; $i<count($info);$i++ ){ $a++; $c='A'.$a;?>
                                    <td align="center"><?php echo $per->$c?></td>
                                <?php }?>
                                <td align="center"><input type="button" name="acomodar" class="acomodar"></td>
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

    $(".acomodar").click(function(){
        alert('Acomodo de Folios de Polizas')
        $.ajax({
            url:'index.coi.php',
            type:'post',
            dataType:'json',
            data:{ctrlFol:1},
            success:function(data){
                alert('Se han actualizado todos los folios')
            },
            error:function(){
                alert('Favor de revisar en COI')
            }
        })
    })
    
</script>