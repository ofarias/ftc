<br/>
<br/>
<div class="row">
                <div class="col-lg-12">
                <br/>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Lista de Solicitudes de Productos de Ventas.
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-aplicapago">
                                    <thead>
                                        <tr>
                                            <th>Orde de <br/> compra</th>
                                            <th>Numero de <br/> Recepcion </th>
                                            <th>Proveedor</th>
                                            <th>Usuario <br/> Fecha Recepcion  </th>
                                            <th>Partidas</th>
                                            <th>Cantidad</th>
                                            <th>Impresion</th>
                                            <th>Recibir</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                            $i = 0;
                                        foreach ($recibo as $data):
                                            $i = $i + 1; 
                                            $color = '';
                                            if(empty($data->ID_RECEPCION) or $data->ID_RECEPCION == 0){
                                                $id = 'Rechazo - '.$data->RECHAZO;
                                                 $color = "style='background-color:#F6CED8'"; 
                                            }else{
                                                $id = 'Recibo-'.$data->ID_RECEPCION;
                                            }
                                            
                                            if($data->IMPRESION == 1){
                                                $imp = 'Si';
                                            }elseif($data->IMPRESION > 1){
                                                $imp = 'Reimpresion';
                                            }elseif ($data->IMPRESION == 0) {
                                                $imp = 'No Impreso';
                                            }

                                            ?>
                                        <tr class="odd gradex" <?php echo $color?>>
                                            <td><?php echo $data->ORDEN;?> </td>
                                            <td><?php echo $id?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo '<b>'.$data->USUARIO.'</b> <br/> '.$data->FECHA ;?></td>
                                            <td><?php echo $data->PARTIDA?></td>
                                            <td><?php echo $data->CANTIDAD_REC?></td>
                                            <td align="center"><?php echo $imp?></td>
                                            <td align="center">
                                               <input type="checkbox" name="docs[]" value="<?php echo $data->ORDEN.'-'.$id?>" onclick="sel(this.value, <?php echo $i?>)" class="docu" id="doc_<?php echo $i?>" >
                                            </td>
                                                                   
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
    </div>
<br />
<form action="index.php" method="POST" id="recbirRecepcion">
    <input type="hidden" value="" id="doc" name="doco">
    <input type="hiiden" value="" id="tip" name="tipo">
    <input type="hidden" value="" id="btn1" name="recibirOC">
</form>

<<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script src="http://bootboxjs.com/bootbox.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script type="text/javascript">

    function sel(id, i){
        alert('Se selecciono este documento' + i);
        var ch = document.getElementById('doc_'+i);

        if(ch.checked == true){
            $.ajax({
                type:'POST',
                url:'index.php',
                dataType:'json',
                data:{recibeRec:'recibeRec', id:id, tipo:'Seleccion'},
                success: function(data)
                {
                    if(data.status == "ok"){    
                        alert('Se recibio el documento');
                    }else{
                        document.getElementById('doc_'+i).checked=0
                        alert('Ya se habia recibido por el usuario :'+ data.response );
                    }
                }
            });
        }else{
            $.ajax({
                type:'POST',
                url:'index.php',
                dataType:'json',
                data:{recibeRec:'recibeRec', id:id, tipo:'NoSeleccionado'},
                success: function(data)
                {
                    if(data.status == "ok"){    
                        alert('Se desmarco el documento.');
                    }else{
                        alert('Ya se habia sido desmarcado por el usuario :'+ data.response );
                    }
                }
            });
        }
    }
</script>
