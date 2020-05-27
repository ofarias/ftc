<br/>
<br/>
<?php foreach ($a as $x){
    $cliente = $x->NOMBRE_CLIENTE;
 }?>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php if(!empty($ticket)){?>
                                Imagenes del Ticket:
                            <?php }else{?>
                                Archivos del cliente <?php echo $cliente?>
                                <br/><br/>
                                <input type="button" value="Nuevo Arvhivo" class="btn-sm btn-info nuevoArchivo">
                                &nbsp;&nbsp;&nbsp; Ver Vigentes <input type="radio" name="vistas" value="1" class="vista" <?php echo ($status==1)? 'checked':'' ?>>
                                &nbsp;&nbsp;&nbsp; Ver Bajas <input type="radio" name="vistas" value="9" class="vista" <?php echo ($status==9)? 'checked':'' ?>>
                                &nbsp;&nbsp;&nbsp; Ver Todos <input type="radio" name="vistas" value="7" class="vista" <?php echo ($status==7)? 'checked':'' ?>>
                            <?php }?>
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables">
                                    <thead>
                                        <tr>
                                            <th>Ticket</th>
                                            <th>Empresa</th>
                                            <th>Documento</th>
                                            <th>Cliente</th>
                                            <th>Fecha</th>
                                            <th>Usuario</th>
                                            <th>Origen</th>
                                            <th>Tipo <br/> Archivo</th>
                                            <th>Tipo <br/> Documento</th>
                                            <th>Version</th>
                                            <th>Observaciones</th>
                                            <th>Baja</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($a as $ar):
                                        ?>
                                       <tr>  
                                       <?php if(isset($ar->ID_SERV)){ ?> 
                                            <td><?php echo $ar->ID_SERV?></td>
                                            <td><?php echo $ar->EMPRESA;?></td>
                                            <td><a href="<?php echo '..//media//files//'.$ar->NOMBRE.'.'.$ar->TIPO_ARCHIVO?>" download><?php echo $ar->NOMBRE;?></a></td>
                                            <td><?php echo $ar->NOMBRE_CLIENTE;?></td>
                                            <td><?php echo $ar->FECHA_ALTA;?></td>
                                            <td><?php echo $ar->USUARIO ;?></td>
                                            <td><?php echo $ar->ORIGEN?></td>
                                            <td><?php echo strtoupper($ar->TIPO_ARCHIVO)?></td>
                                            <td><?php echo $ar->TIPO_DOC?></td>
                                            <td><?php echo $ar->VERSION?></td>
                                            <td><?php echo $ar->COMPLETA?></td>
                                            <td><?php if($ar->STATUS_FILE == 1){?><input type="button" class="btn-sm btn-danger baja" value="Baja" idf="<?php echo $ar->ID_SF?>"><?php }?></td>
                                        <?php }else{?>
                                            <font color="red"><label>No existen archivos.</label><font>
                                        <?php }?>
                                        </tr> 
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="hidden" id="alta">
    <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Alta de Archivo.
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables">
                                    <thead>
                                        <tr>
                                            <th>Archivo</th>
                                            <th>Tipo</th>
                                            <th>Observaciones</th>
                                            <th>Cargar</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                       <tr> 
                                            <form action="carga_archivo.php" method="post" name="formulario1" enctype="multipart/form-data">  
                                            <td><input type="file" name="fileToUpload"></td>
                                            <td>
                                                <select name="tipoArchivo" required>
                                                    <option value="">Seleccione un tipo de documento</option>
                                                    <option value="list">Check List (Instalación)</option>
                                                    <option value="guia">Guia</option>
                                                    <option value="man">Manual</option>
                                                    <option value="lic">Licencia</option>
                                                    <option value="inv">Inventario</option>
                                                    <option value="evi">Evidencia</option>
                                                    <option value="res">Evidencia de Respaldo</option>
                                                    <option value="cot">Cotizacion</option>
                                                    <option value="otr">Otros</option>
                                                </select>
                                            </td>
                                            <td><textarea name="obs" cols="70" rows="10"></textarea>
                                                <input type="hidden" name="origen" value="empresa">
                                                <input type="hidden" name="servicio" value="0">
                                                <input type="hidden" name="emp" value="<?php echo $clie?>">
                                            </td>
                                            <td><br/><input type="button" id="cargar" value="Cargar" class="btn-sm btn-info">
                                                <br/><br/>
                                                <input type="button" id="can" value="Cancelar" class="btn-sm btn-danger"></td>
                                            </form>
                                        </tr> 
                                 </tbody>
                                 </table>
                        </div>
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
    
    var cli= <?php echo $clie?>; 

    $(document).ready(function(){
        $(".fecha").datepicker({dateFormat:'dd.mm.yy'});
    });

    $(".baja").click(function(){
        var idf = $(this).attr('idf')
        alert('Se Marca como baja el archivo, para poder visualizarlo de nuevo, debe de dar click en la opcion "ver bajas"')
        $.ajax({
            url:'index.serv.php',
            type:'post',
            dataType:'json',
            data:{bajaFile:1, idf},
            success:function(data){
                if (data.status== 'ok'){
                    alert('Se ha dado de baja el archivo')
                    location.reload();
                }
            },
            error:function(){
                alert('ocurrio un error favor de revisar la información.')
            }
        })

    })

    $(".nuevoArchivo").click(function(){
        document.getElementById('alta').classList.remove('hidden')
        alert('Nuevo Archivo')
    })

    $("#can").click(function(){
        document.getElementById('alta').classList.add('hidden')
    })

    $("#cargar").click(function(){
        if(confirm('Desear cargar el arcvhivo?')){
            document.formulario1.submit()
            alert('Se ha enviado el Formulario')
        }else{
            alert('No se cargo ningun archivo')
        }
    })

    $(".vista").click(function(){
        var v = $(this).val()
        window.open('index.serv.php?action=verArchivos&clie='+cli+'&tipo=empresa&status='+v, '_SELF')
    })

</script>

