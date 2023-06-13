

<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Cargas de Estados de Cuenta en Excel
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="">
                                    <thead>
                                        <tr>
                                            <th>Banco</th>
                                            <th>Fecha Carga</th>
                                            <th>Usuario</th>
											<th>Archivo<br/> Trabajar</th>
                                            <th>Tipo</th>
                                            <th>Abonos<br/>Cargos</th>
                                            <th>Fecha Inicial<br/>Fecha Final</th>
                                            <th>Eliminar</th>
                                            
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($carga as $d):
                                            $FF='';
                                            if($d->FICP == ''){
                                                $FI = $d->FIG;
                                            }elseif($d->FIG == ''){
                                                $FI = $d->FICP;
                                            }elseif($d->FICP == '' AND $d->FIG == ''){
                                                $FI = '';    
                                            }else{
                                                $f1 = strtotime($d->FICP);
                                                $f2 = strtotime($d->FIG);
                                                if($f1 > $f2){
                                                    $FI = $d->FIG;
                                                }else{
                                                    $FI = $d->FICP;
                                                }
                                            }

                                            if($d->FFCP == ''){
                                                $FF = $d->FFG;
                                            }elseif($d->FFG == ''){
                                                $FF = $d->FFCP;
                                            }elseif($d->FFCP == '' AND $d->FFG == ''){
                                                $FF = '';    
                                            }else{
                                                $f1 = strtotime($d->FFCP);
                                                $f2 = strtotime( $d->FFG);
                                                if($f1 < $f2){
                                                    $FF = $d->FFG;
                                                }else{
                                                    $FF = $d->FFCP;
                                                }
                                            }
                                        ?>
                                       <tr class="<?php echo $d->STATUS?>">
                                            <td><?php echo $d->BANCO.' - '.$d->CUENTA;?></td>
                                            <td><?php echo $d->FECHA_ALTA;?></td>
                                            <td><?php echo $d->USUARIO_ALTA;?></td>
                                            <td><?php echo substr($d->NOMBRE,21);?><br/>
                                                <?php if(strtoupper(substr($d->NOMBRE, strpos($d->NOMBRE, ".")+1)) == 'PDF'){?>
                                                    <a class="btn-sm btn-info" href="index.php?">Descarga Archivo</a>
                                                <?php }elseif(strtoupper(substr($d->NOMBRE, strlen($d->NOMBRE)-4))=='XLSX' and $d->STATUS == 'A'){?>
                                                    <a class="btn-sm btn-primary" href="index.php?action=FiltrarEdoCta&mes=<?php echo date("n", strtotime($FI))?>&banco=<?php echo $d->BANCO?>&cuenta=<?php echo $d->CUENTA?>&anio=<?php echo date("Y", strtotime($FI))?>&f=si&idfl=<?php echo $d->ID?>">Trabajar Estado</a>
                                                <?php }?>

                                        </td>
                                            <td><?php echo $f=strtoupper(substr($d->NOMBRE, strpos($d->NOMBRE, ".")+1));?></td>
											<td align="right"><font color="blue"><?php echo '$ '.number_format($d->ABONOS,2);?></font><br/><font color="brown"><?php echo '$ '.number_format($d->CARGOS,2);?></font></td>
                                            <td align="right"><b><?php echo substr($FI,0,10)?><br/><?php echo substr($FF, 0,10)?></b></td>
                                            <td><?php if($d->STATUS == 'A'){?>
                                                <input type="button" reg="<?php echo $d->ID?>" t="<?php echo $f?>" value="Eliminar" class="btn-sm btn-danger del">
                                            <?php }else{?>
                                                <input type="button" value="Eliminado" disabled class="btn-sm btn-danger">
                                            <?php }?>
                                            </td>
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
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">

    $(".del").click(function(){
        var idc = $(this).attr('reg')
        var t = $(this).attr('t')
        var m = 'Se eliminara el archivo, esta seguro?'
        if(t == 'XLS' || t == 'CSV' || t == 'XLSX'){
            m = 'Al eliminar el archivo, se eliminaran los regisrtros que se cargaron con el, esta seguro?'
        }
            $.confirm({
                title: 'Eliminacion de carga de estado de cuenta',
                content:m,
                buttons:{
                    aceptar:{
                        text:'Aceptar',
                        btnClass:'btn-success',
                        action:function(){
                            $.ajax({
                                url:'index.php',
                                type:'post',
                                dataType:'json',
                                data:{delCarga:1, idc},    
                                success:function(data){
                                    alert('Se elimino el archivo y los registros')
                                }
                            })
                        }
                    },
                    cancelar:{
                        text:'Cancelar',
                        btnClass:'btn-danger',
                        action:function(){
                            return
                        }
                    },
                },
            });
    });
</script>
