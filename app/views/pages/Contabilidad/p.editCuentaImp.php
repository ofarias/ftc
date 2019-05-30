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
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                            <th>Ln</th>
                                            <th>Impuesto</th>
                                            <th>Cuenta Contable</th>
                                            <th>Tipo</th>
                                            <th>Tasa</th>
                                            <th>Status</th>
                                            <th>Nombre</th>
                                            <th>Factor</th>
                                            <th>Tipo de Poliza</th>
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
                                            <td><input type="text" name="cuenta" class="cuencont" placeholder="<?php echo $data->CUENTA_COI;?>" orig="<?php echo $data->CUENTA_CONTABLE?>" id="<?php echo $data->ID?>"></td>
                                            <td><?php echo $data->TIPO;?></td>
                                            <td><?php echo number_format($data->TASA,2);?></td>
                                            <td><?php echo $data->STATUS;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->POLIZA?></td>
                                            <td><?php echo $data->FACTOR;?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                      </div>
            </div>
        </div>
</div>
</div>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">

$(".cuencont").autocomplete({
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

</script>
