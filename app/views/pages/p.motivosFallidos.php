

<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Motivos de Fallo de la Orden de compra <font color="red" size="3pxs"><?php echo $oc?></font>.
                        </div>
                        <!-- /.panel-heading -->
                        <?php if(count($motivos)>0){?>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                            <th>Orden</th>
                                            <th>Usuario</th>
                                            <th>Motivo</th>
                                            <th>Fecha</th>
                                            <th>Archivos</th>
                                            <th>Partidas</th>
                                            <th>Estatus Original</th>
                                            <th>Estatus Nuevo </th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($motivos as $data):  
                                        ?>
                                       <tr>
                                            <td><?php echo $data->OC;?></td>
                                            <td><?php echo $data->USUARIO;?></td>
                                            <td><?php echo $data->MOTIVO?></td>
                                            <td><?php echo $data->FECHA;?></td>
											<td><?php echo $data->ARCHIVOS;?></td>
                                            <td><?php echo $data->PARTIDA;?></td>
                                            <td><?php echo $data->STATUS_O;?></td>
                                            <td><?php echo $data->STATUS_N;?></td>
                                            <!--
                                            <td><a href="index.php?action=motivosFallidos&oc=<?php echo $data->CVE_DOC?>" targe="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;"> Ver y Capturar Motivos </a>
                                            </td>-->
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
            <?php }else{?>
                <div class="alert-danger"><center><h2>Aun no se han capturado Motivos</h2></center></div>
            <?php }?>
        </div>
</div>
</div>

<div class="row">
    <h3>Ingresar Motivo del Fallo</h3>
</div>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Motivos de Fallo de la Orden de compra <font color="red" size="3pxs"><?php echo $oc?></font>.
                            <input type="hidden" name="oc" value="<?php echo $oc?>" id="oc">
                        </div>
                <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Partida</th>
                                            <th>Descripcion</th>
                                            <th>Cantidad <br/><font color="blue"> PXR</font></th>
                                            <th>Cliente <br/><font color="red"> Cotizacion</font></th>
                                            <th>Motivo del Rechazo </th>
                                            <th>Procesar <br/> como:</th>
                                           
                                        </tr>
                                    </thead>
                                  <tbody>


                                        <?php
                                        $i = 0;
                                        foreach ($partidas as $data):  
                                        $i+=1;
                                        ?>
                                       <tr>
                                            <td><?php echo $data->PARTIDA.'<br/>'.$data->ART.'<br/>'.$data->IDPREOC;?></td>
                                            <td><?php echo $data->DESCRIPCION;?></td>
                                            <td><?php echo $data->CANTIDAD.'<br/><font color="blue">'.$data->PXR.'</font>';?></td>
                                            <td><?php echo $data->CLIENTE;?><br/><font color="red"><?php echo $data->COTIZACION;?></font></td>
                                            <td>
                                                 <textarea class="form-control, motivos" name='descripcion' rows="5" cols="40" id='motivo<?php echo $i?>'> Motivo del fallo general: </textarea><br/>
                                                 <br/>
                                                 <?php if(count($partidas)>1 and $i == 1 ){ ?>
                                                    <input type="button" name="copiar" onclick="copiar(<?php echo $i?>)" class="btn btn-warning" value="copiar motivo">
                                                 <?php } ?>
                                            </td>
                                            <td>
                                                <select name='statusn' id="sel<?php echo $i?>">
                                                        <option value=""> Seleccione una opcion </option>
                                                        <option value="reenrutar"> Reenrutar </option>
                                                        <option value="fallar">Fallar (se envia a Suministros)</option>
                                                        <!--<option value="noreq"> Ya no es requerido</option>-->
                                               </select>
                                                    <br/> 
                                                <font color="orange"><?php echo 'Vueltas: '.$data->VUELTAS?></font>
                                                <br/>
                                                <?php if($data->PXR > 0){?>
                                                <input type="button" name="valida" value="Ejecuta Individual" onclick="ejecuta(<?php echo $i?>, <?php echo $data->IDPREOC?>, 'ind', <?php echo $data->PARTIDA?>)" class="btn btn-success">
                                                <br/>
                                                <input type="button" name="valida" value="Ejecuta General" onclick="ejecuta(<?php echo $i?>, <?php echo $data->IDPREOC?>, 'gen',<?php echo $data->PARTIDA?>)" class="btn btn-info">
                                                <?php }?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <input type="hidden" value="<?php echo $i?>" id="totpar">
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

    function ejecuta(p, idp, tipo, par){
        var m = document.getElementById('motivo'+p).value;
        var e = document.getElementById('sel'+p).value;
        var oc = document.getElementById('oc').value;

        $.ajax({
            url:'index.php',
            method:'post',
            dataType:'json', 
            data:{ejecutaOC:1, tipo:tipo, motivo:m, final:e, oc:oc, partida:par},
            success:function(data){
                alert(data.mensaje);
                if(data.status== 'ok'){
                    location.reload(true);
                }
            }
        });
    }

    function copiar(p){
        var m = document.getElementById('motivo'+p).value;
        alert('Se colocara el motivo a todos los' + m);
        var pt = document.getElementById('totpar').value;
        
        for(i=1;i<=pt;i++){
            document.getElementById('motivo'+i).value=m;    
        }
    }

</script>