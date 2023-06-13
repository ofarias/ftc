<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>REGISTRO DE GASTOS POR FACTURAR</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="dataTables-gxf">
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
                                <th>Detalle</th>   
                            </tr>
                        </thead>
                        <tbody>
                            <?php $ln=0; $st=0; foreach($info as $row): $ln++; $st=($row->CANTIDAD * $row->PRECIO) - $row->DESCUENTO;?>
                            <tr class="odd gradeX linea " lin="<?php echo $ln?>" u="<?php echo $row->UUID?>" p="<?php echo $row->PARTIDA?>" >
                                <td><?php echo $ln;?></td>
                                <td title="Asocia todo el documento"><a href="index.xml.php?action=agxf&uuid=<?php echo $row->UUID?>"><?php echo $row->DOCUMENTO;?></a></td>
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
                                <td><a href="index.xml.php?action=verMetaDatosDet&archivo=<?php echo $row->ARCHIVO?>" target="popup" onclick="window.open(this.href, this.target, 'width=2000, heigth=800')" class="btn btn-success">Relaciones</a></td>
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

    $(".linea").click(function(){
        window.open("index.xml.php?action=rgxf&u="+$(this).attr('u'), "target=popup")
    })
 
</script>