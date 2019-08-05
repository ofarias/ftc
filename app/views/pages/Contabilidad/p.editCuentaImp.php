<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Cuentas de Impuestos
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-impuestos">
                                    <thead>
                                            <th>Ln</th>
                                            <th>Impuesto</th>
                                            <th>Cuenta Contable<br/>Nombre Cuenta</th>
                                            <th>Tipo</th>
                                            <th>Tasa</th>
                                            <th>Status</th>
                                            <th>Nombre</th>
                                            <th>Tipo de Poliza</th>
                                            <th>Factor</th>
                                            <th>Aplica a XML:</th>
                                            <th>Eliminar</th>
                                    </thead>
                                  <tbody>
                                        <?php
                                        $i= 0;
                                        foreach ($info as $data):  
                                        $i++;
                                        ?>
                                       <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?php echo $data->IMPUESTO;?></td>
                                            <td><input type="text" name="cuenta" class="cuencont" placeholder="<?php echo $data->CUENTA_COI;?>" orig="<?php echo $data->CUENTA_CONTABLE?>" id="<?php echo $data->ID?>"><br/><?php echo $data->NOMBRE_CUENTA?></td>
                                            <td><?php echo $data->TIPO;?></td>
                                            <td><?php echo number_format($data->TASA,2);?></td>
                                            <td><?php echo $data->STATUS;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->POLIZA?></td>
                                            <td><?php echo $data->FACTOR;?></td>
                                            <td><?php echo $data->TIPO_XML?></td>
                                            <td><?php if(!empty($data->CUENTA_CONTABLE)){?>
                                            <input type="button" class="btn-sm btn-danger borrar" value="Borrar Cuenta" idImp="<?php echo $data->ID?>" cta="<?php echo $data->CUENTA_COI?>" nombre="<?php echo $data->NOMBRE?>" op="Eliminar" >
                                            <?php }?>
                                            <?php if($data->STATUS == 1){?>
                                                <input type="button" class="btn-sm btn-warning borrar" value="Desactivar" idImp="<?php echo $data->ID?>" cta="<?php echo $data->CUENTA_COI?>" nombre="<?php echo $data->NOMBRE?>" op="Desactivar" >
                                            <?php }else{?>
                                                <input type="button" class="btn-sm btn-success borrar" value="Activar" idImp="<?php echo $data->ID?>" cta="<?php echo $data->CUENTA_COI?>" nombre="<?php echo $data->NOMBRE?>" op="Activar">
                                            <?php }?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>

                                </table>
                                <input type="button" value="Agregar" onclick="aimp()" class="btn btn-success">
                      </div>
            </div>
        </div>
</div>
</div>
<div class="row hide" id="nuevo">
    <div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
           Agregar Impuestos.
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <th>Ln</th>
                        <th>Impuesto</th>
                        <th>Cuenta Contable<br/>Nombre Cuenta</th>
                        <th>Tipo</th>
                        <th>Tasa</th>
                        <th>Status</th>
                        <th>Nombre</th>
                        <th>Tipo de Polizas</th>
                        <th>Factor</th>
                        <th>Aplica a XML:</th>
                        <th>Guardar</th>
                    </thead>
                    <tbody>
                        <td><?php echo ($i+1)?></td>
                        <td><select name="imp" id="imp">
                            <option value="">Clave de Impuesto</option>
                            <option value="001">ISR</option>
                            <option value="002">IVA</option>
                            <option value="003">IEPS</option>
                        </select>
                    </td>    
                    <td>
                        <input type="text" name="cccoi" class="cuencon" placeholder="Cuenta COI"  id="cccoi" required>
                    </td>
                    <td>
                        <select name="tipo" id="tipo">
                            <option value="">Tipo</option>
                            <option value="Traslado">Traslado</option>
                            <option value="Retencion">Retencion</option>
                        </select>
                    </td>
                    <td title="Tasa o Cuota a usar por ejemplo para 16% colocar .16">
                       <input type="text" name="tasa" placeholder="Tasa o Cuota" id="tasa" >
                    </td>
                    <td>
                        <select name="status" id="status">
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </td>
                    <td title="Nombre para identificar el impuesto, Ejemplo IVA por cobrar del 16%">
                        <input type="text" name="nombre" maxlength="200" minlength="10" placeholder="Nombre para identificar" id="nombre">
                    </td>
                    <td title="Seleccione en que tipo de polizas sera su principal uso">
                        <select name="usoPol" id="usoPol">
                            <option value="">Usar en Polizas de:</option>
                            <option value="Dr">(Dr) Diario</option>
                            <option value="Ig">(Ig) Ingresos</option>
                            <option value="Eg">(Eg) Egresos</option>
                        </select>
                    </td>
                    <td>
                        <select name="factor" id="factor">
                            <option value="">Factor</option>
                            <option value="Tasa">Tasa</option>
                            <option value="Cuota">Cuota</option>
                        </select>
                    </td>
                    <td>
                        <select name="aplica" id="aplica">
                            <option value="">Aplica a los XML:</option>
                            <option value="Recibido">Recibidos</option>
                            <option value="Emitido">Emitidos</option>
                        </select>
                    </td>
                    <td>
                        <input type="button" class="btn btn-success grabar" value="Grabar">
                    </td>
                    </tbody>
                </table>
            </div>  
          </div>
        </div>
    </div>
</div>
<form action="index.coi.php" method="POST" id="formImp">
    <input type="hidden" name="imp" value="" id="ni_imp">
    <input type="hidden" name="cccoi" value="" id="ni_cccoi">
    <input type="hidden" name="tipo" value="" id="ni_tipo">
    <input type="hidden" name="tasa" value="" id="ni_tasa">
    <input type="hidden" name="uso" value="" id="ni_usoPol">
    <input type="hidden" name="nombre" value="" id="ni_nombre">
    <input type="hidden" name="factor" value="" id="ni_factor">
    <input type="hidden" name="aplica" value="" id="ni_aplica">
    <input type="hidden" name="status" value="" id="ni_status">
    <input type="hidden" name="grabaImp" value="" id="ni_grabaImp">
</form>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">

function aimp(){
    document.getElementById('nuevo').classList.remove('hide')
}
$(".grabar").click(function(){
    var imp = document.getElementById('imp').value
    var tipo = document.getElementById('tipo').value
    var tasa = document.getElementById('tasa').value
    var nombre = document.getElementById('nombre').value
    var usoPol = document.getElementById('usoPol').value
    var factor = document.getElementById('factor').value
    var aplica = document.getElementById('aplica').value
    var cccoi = document.getElementById('cccoi').value
    var status = document.getElementById('status').value

    if(imp != '' & tipo != '' & tasa != '' & nombre != '' & factor != '' & aplica != '' & usoPol != '' & aplica != ''){
        $.confirm({
            title:'Alta de Impuestos',
            content:'Desea Crear el impuesto?',
            buttons:{
                ok:function(){
                    document.getElementById("ni_imp").value=imp
                    document.getElementById("ni_cccoi").value=cccoi
                    document.getElementById("ni_tipo").value=tipo
                    document.getElementById("ni_tasa").value=tasa
                    document.getElementById("ni_usoPol").value=usoPol
                    document.getElementById("ni_factor").value=factor
                    document.getElementById("ni_aplica").value=aplica
                    document.getElementById('ni_nombre').value=nombre
                    document.getElementById('status').value=status
                    $("#formImp").submit()
                },
                cancelar:function(){
                }
            }
        })
    }else{
        alert('Faltan datos, favor de llenar todos los campos')
    }
})

$(".cuencont").autocomplete({
        source: "index.coi.php?cuentas=1",
        minLength: 3,
        select: function(event, ui){
        }
})

$(".cuencon").autocomplete({
        source: "index.coi.php?cuentas=1",
        minLength: 3,
        select: function(event, ui){
        }
})

$(".cuencont").change(function(){
    var idc = $(this).attr('id')
    var c = $(this).attr('orig')
    var i = $(this).attr('id')
    var n = $(this).val()
    //alert('Este es el valor original '+c+' del ID '+ i + ' y este es el valor enviado' +n )
    var a=n.split(":")
    var ncta = a[7]
    if(confirm('Desea consevar los cambios? Anterior: '+ c + ' Nueva: '+ ncta)){
        $.ajax({
            url:'index.coi.php',
            type:'post',
            dataType:'json',
            data:{actCuentaImp:ncta, idc},
            success:function(data){
                alert(data.mensaje)
                location.reload(true)
            },
            error:function(data){
                alert('Ocurrio un error, favor de revisar los datos.')
                location.reload(true)
            }
        })
    }else{
            alert('No se realizo ningun cambio')
            location.reload(true)
        }
})

$(".borrar").click(function(){
    var idImp=$(this).attr('idImp')
    var nombre = $(this).attr('nombre')
    var cuenta = $(this).attr('cta')
    var opcion = $(this).attr('op')
    if(opcion != 'Activar'){
        a = 'no'
    }else{
        a = ''
    }
    $.confirm({
        title: opcion + ' la Cuenta Contable',
        content:'Al '+opcion+' al cuenta <b>'+cuenta+' '+nombre+'</b> de impuestos, ya <b>' + a + '</b> se crearan las partidas de los impuestos',
        buttons: {
            aceptar:function(){
                $.ajax({
                    url:'index.coi.php',
                    type:'post',
                    dataType:'json',
                    data:{borraCuenta:1, idImp, opcion},
                    success:function(data){
                        location.reload(true)
                    },
                    error:function(){
                    }
                })
            },
            cancelar:function(){
                return 
            }
        }
    })
})

</script>
