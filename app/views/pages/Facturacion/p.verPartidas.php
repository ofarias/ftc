<br/>
<br/>
<div class="row">
                <div class="panel panel-default">
                        <div class="panel-heading">
                          Cabecera Documento
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Documento</th>
                                            <th>Fecha</th>
                                            <th>Cliente</th>
                                            <th>RFC</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        $i=0;
                                        foreach ($Cabecera as $data):
                                            $i++;   
                                            $color='';
                                        ?>
                                        <tr id="titulo_<?php echo $i?>" class="odd gradeX" <?php echo $color?>>
                                            <td><?php echo $data->CVE_FACT?></td>
                                            <td><?php echo $data->FECHA;?></td>
                                            <td><?php echo $data->NOMBRE?></td>
                                            <td><?php echo $data->RFC?></td>
                                           
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                      </div>
            </div>
        </div>
    </div>
<br />
<div class="row">
                <div class="panel panel-default">
                        <div class="panel-heading">
                          Partidas Documento
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Part</th>
                                            <th>Articulo</th>
                                            <th>Descripcion</th>
                                            <th>Cantidad</th>
                                            <th>Unidad</th>
                                            <th>Unidad <br/> SAT</th>
                                            <th>Clave <br/> SAT</th>
                                            <th>Precio<br> Sin Inpuestos</th>

                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        $i=0;
                                        foreach ($par as $data):
                                            $i++;   
                                            $color='';
                                        ?>
                                        <tr id="titulo_<?php echo $i?>" class="odd gradeX" <?php echo $color?>>
                                            <td><?php echo $i?></td>
                                            <td><?php echo $data->ARTICULO?></td>
                                            <td><?php echo $data->DESCRIPCION;?><br/><textarea placeholder="Anexar descripcion del producto" cols="60" rows="6" id="descr_<?php echo $data->PARTIDA?>"><?php echo html_entity_decode($data->ANEXO,ENT_QUOTES)?></textarea> <br/>
                                            <input type="button" onclick="anexaDesc(<?php echo $idc?>, <?php echo $data->PARTIDA?>, descr_<?php echo $data->PARTIDA?>.value, 'a')" value="Anexar">
                                            <input type="button" onclick="anexaDesc(<?php echo $idc?>, <?php echo $data->PARTIDA?>, descr_<?php echo $data->PARTIDA?>.value, 'r')" value="Restaurar"></td>
                                            <td><?php echo $data->CANTIDAD?></td>
                                            <td><?php echo $data->UM?></td>
                                            <td><?php echo $data->UNIDAD_SAT?></td>
                                            <td><?php echo $data->CLAVE_SAT?></td>
                                            <td><?php echo '$ '.number_format($data->PRECIO,2)?></td>
                                           
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                      </div>
            </div>
        </div>
    </div>
<script type="text/javascript" language="JavaScript" src="app/views/bower_components/jquery/dist/jquery.min.js"></script>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">

    function anexaDesc(idc, par, descr, t){
        if(t == 'a'){
            var mensaje="Desea Anexar a la descripcion, despues no podra modificarse?"
        }else{
            var mensaje="Desea Restuarar a la descripcion inicial, no se podran recuperar los cambios?"
        }
        if(confirm(mensaje)){
            $.ajax({
                url:'index.v.php',
                type:'post',
                dataType:'json',
                data:{anexoDescr:t, idc, par, descr},
                success:function(data){
                    alert(data.mensaje)
                    location.reload(true);
                },
                error:function(data){
                    alert('Ocurrio un problema, intente nuevamente')
                    location.reload(true);
                }
            })
        }else{
            return false
        }
    }
</script>
