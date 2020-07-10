<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Clasificación de Documentos
            </div>
            <div class="panel-body">
                <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Clasificación</th>
                                <th>Descripción</th>
                                <th>Tipo <br/> de Documento</th>
                                <th class="text-center">Editar</th>
                                <th class="text-center">Habilitar / Deshabilitar</th>
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
                                <td><?php echo ($row->TIPO =='G')? 'Egreso':'Ingreso' ?></td>
                                <form action="index.php" method="post" id="formulario">
                                 <input type="hidden" name="id" value="<?php echo $row->ID;?>"/>
                                <td class="text-center"><button type="submit" name="editclasificaciongasto" class="btn btn-warning"><i class="fa fa-pencil-square-o"></i></button></td>
                                <td class="text-center">
                                    <button type="submit" id="cambio" name="delclasificaciongasto" class="btn btn-success" ><i class="fa fa-check"></i>
                                    </button>
                                </td>
                                </form>
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
    
    $("#cambio").click(function(){
        alert('Desea cambiar el registro?')
        var form = document.getElementByID('formulario')
        form.submit()
    })


</script>
