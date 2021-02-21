<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>REGISTRO DEL GASTOS </h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="dataTables-table-3">
                        <thead>
                            <tr>
                                <th>Ln</th>
                                <th>Documento</th>
                                <th>Proveedor</th>
                                <th>Fecha</th>
                                <th>Partida</th>
                                <th>Cantidad</th>
                                <th>Descripcion</th>
                                <th>Clave SAT</th>
                                <th>Unidad SAT</th>
                                <th>Precio</th>
                                <th>Descuento</th>
                                <th>Subtotal</th>
                                <th>Seleccionar</th>   
                            </tr>
                        </thead>
                        <tbody>
                            <?php $ln=0; $st=0; foreach($info as $row): $ln++; $st=($row->CANTIDAD * $row->PRECIO) - $row->DESCUENTO;?>
                            <tr class="odd gradeX linea " lin="<?php echo $ln?>" u="<?php echo $row->UUID?>" p="<?php echo $row->PARTIDA?>" >
                                <td><?php echo $ln;?></td>
                                <td title="Asocia todo el documento"><a href="index.xml.php?action=agxf&uuid=<?php echo $row->UUID?>"><?php echo $row->DOCUMENTO;?><br/><?php echo $row->UUID?></a></td>
                                <td><?php echo $row->NOMBRE;?></td>
                                <td><b><?php echo $row->FECHA?></b></td>
                                <td><?php echo $row->PARTIDA;?></td>
                                <td><?php echo $row->CANTIDAD;?></td>
                                <td><b><?php echo $row->DESCRIPCION;?></b></td>
                                <td><?php echo $row->CLAVE_SAT;?></td>
                                <td><?php echo $row->UNIDAD_SAT?></td>
                                <td><?php echo $row->PRECIO?></td>
                                <td><?php echo $row->DESCUENTO?></td>
                                <td align="right"><?php echo '$ '.number_format($st,2)?></td>
                                <td align="center"><input type="checkbox" name=""></td>
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
                <h4>Buscar Factura o Proyecto</h4>
            </div>
            <div class="panel-body">
                <input type="text" placeholder="Factura / Proyecto / Cliente" maxlength="40" size="50" class="docs"> <input type="button" value="Obtener" class="btn-sm btn-info">
                <br/><br>
                Tare documentos y proyectos del <input type="date" class="fecha" > al <input type="date" > <input type="button" value="Traer" class="btn-sm btn-info"><br/><br/> <button class="btn-sm btn-warning">Nuevo Proyecto </button>
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

    $(".docs").autocomplete({
        source:"index.xml.php?doc=1",
        minLength:3,
        select:function(event, ui){
        }
    })
 
</script>