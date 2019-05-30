<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Maestros   
                            <a class="btn btn-success" href="index.php?action=nuevo_maestro" class="btn btn-success"> Crear Maestro <i class="fa fa-plus"></i></a>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Cartera</th>
                                            <th>Sucursales</th>
                                            <th>Linea de Credito <br/> Otorgada </th>
                                            <th>Linea de Credito <br/> Comprometida </th>
                                            <th>Acreedores</th>
                                            <th>Deuda Estimada</th>
                                            <th>Pedidos Pendientes</th>
                                            <th>Facturas / Remisiones <br/> En Transito </th>   <!-- En Logistica  -->
                                            <th>Facturas / Remisiones <br/> Por Revisionar </th> <!-- En Revision -->
                                            <th>Facturas en CxC </th>  <!-- En Cobranza -->
                                            <th>Editar</th>
                                            <th>CCC</th>
                                            <th>Detalle</th>
                                            <th>Baja</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($maestros as $data):
                                            if($data->ID < 206){
                                                $color = "style='background-color:grey'";
                                            }else{
                                                $color = '';
                                            }
                                        ?>
                                        <tr class="odd gradeX" <?php echo $color?> id="marca_<?php echo $data->ID?>" >
                                            <td><?php echo $data->NOMBRE.'<br/>'.$data->CLAVE;?></td>
                                            <td><?php echo $data->CARTERA;?></td>
                                            <td><?php echo $data->SUCURSALES;?></td>
                                            <td align="right" style="font-size:15px "><b><?php echo '$ '.number_format($data->LIMITE_GLOBAL,2);?></b></td>
                                            <td align="right"><?php echo '$ '.number_format(($data->REVISION + $data->COBRANZA + $data->LOGISTICA),2)?></td>
                                            <td align="right"><font color="blue"><?php echo '$ '.number_format($data->ACREEDOR,2)?></font></td>
                                            <td align="right" style="font-size:15px"><b><?php echo '$ '.number_format(($data->REVISION + $data->COBRANZA + $data->LOGISTICA)-$data->ACREEDOR,2)?></b></td>
                                            <td> Pedidos Pendientes </td>
                                            <td align="right"><?php echo '$ '.number_format($data->LOGISTICA,2);?></td>  <!-- En Logistica -->
                                            <td align="right"><?php echo '$ '.number_format($data->REVISION,2);?></td>  <!-- En Revision -->
                                            <td align="right"><font color="#58FA58"><?php echo '$ '.number_format($data->COBRANZA,2);?></font></td> <!-- En Cobranza -->
                                            <td>
                                            <form action="index.php" method="post">
                                                <input type="hidden" name="idm" value="<?php echo $data->ID?>" >
                                                <input type="hidden" name="cvem" value="<?php echo $data->CLAVE?>">
                                                <button name="editarMaestro" value="enviar" type="submit" class="btn btn-info"> Editar </button>
                                            </td>
                                            <td>
                                                <button type="submit" value="enviar" name="verCCC" class="btn btn-success"> CCC </button>
                                            </td>
                                            <td>
                                                <button type="submit" values="enviar" name="detalleMaestro" class="btn btn-info"> ver Detalle</button>
                                            </td>
                                            <td>
                                                <input type="button" onclick="baja('<?php echo $data->NOMBRE?>', '<?php echo $data->ID?>', '<?php echo $data->CLAVE?>')" class="btn-small btn-danger" value="Baja" id="boton_<?php echo $data->ID?>"></td>
                                            </td>
                                             
                                        </tr>
                                        </form>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                      </div>
            </div>
        </div>
</div>
<script type="text/javascript" language="JavaScript" src="app/views/bower_components/jquery/dist/jquery.min.js"></script>
<script type="text/javascript">
    function baja(m, idm, cvem){
        if(confirm('Desea dar de baja el Maerstro ' + m + ' ?'+ idm)){
            $.ajax({
             url:'index.php',
            type:'post',
            dataType:'json',
            data:{bajaM:idm, cvem},
            success:function(data){
                if(data.status == 'ok'){
                    alert(data.mensaje)
                    document.getElementById('marca_'+idm).style.background="red"
                    document.getElementById('boton_'+idm).classList.add("hide")
                    //location.reload(true)
                }else{
                    alert(data.mensaje)
                }
            },
            error:function(){
                alert('ocurrio un error favor de revisar en sistemas')
            }
            })    
        }   
    }

</script>