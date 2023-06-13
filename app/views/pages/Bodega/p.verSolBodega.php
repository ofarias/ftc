<br/>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Lista de productos Asignados automaticamente;
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-aplicapago">
                                    <thead>
                                        <tr>
                                            <th>Impre<br/>sion</th>
                                            <th align="center">Asignacion</th>
                                            <th align="center">Identificador <br/> IDPREOC </th>
                                             <th>Clave <br/>Pegaso</th>
                                            <th>Descripcion</th>
                                            <th align="center">Cantidad <br/> Asignada </th>
                                            <th align="center">Cantidad <br/> Recibida </th>
                                            <th>Fecha del <br/> Movimiento </th>
                                            <th>Usuario de <br/> Suministros</th>
                                            <th>Cotizacion <br/> Asociada</th>
                                            <th>Status</th>
                                            <th>Ejecutar</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($solicitudes as $data):
                                                if($data->STATUS == 7){
                                                    $status ='Avisado a Bodega';
                                                }elseif($data->STATUS == 2){
                                                    $status = 'Recibido';
                                                }elseif ($data->STATUS == 3) {
                                                    $status = 'Cancelado';
                                                }elseif($data->STATUS == 4) {
                                                    $status = 'Vale Bodega';
                                                }elseif ($data->STATUS == 0) {
                                                    $status = 'En Espera de Recibirlo';
                                                }
                                              $Descripcion= '';
                                              $produ = '';
                                                if(empty($data->PROD)) $produ = $data->PRODU;
                                                  else $produ =  $data->PROD;
                                                if(empty($data->NOMPROD))$Descripcion = $data->DESCR;
                                                  else $Descripcion = $data->NOMPROD;

                                              $color = '';
                                              if($data->STATUS == 0 and $data->FOLIO_IMP == 0){
                                                $color="style='background-color:#CEE3F6;'";
                                              }elseif ($data->FOLIO_IMP > 0 ) {
                                                $color = "style='background-color:#ffe6e6;'";
                                              }
                                            ?>
                                        <tr <?php echo $color ?>>
                                            <td><input type="checkbox" name="selImpresion" value="<?php echo $data->ID?>" <?php echo ($data->FOLIO_IMP<> 0 OR $data->STATUS <>0)? 'disabled="disabled"':'' ?>></td>
                                            <td align="center"><?php echo $data->ID;?></td>
                                            <td align="center"><?php echo $data->PREOC;?></td>
                                            <td> <a href="index.php?action=verMovInventario&producto=<?php echo $produ?>" target="_blank"><?php echo $produ.'<br/>'?></a></td>
                                            <td> <?php echo $Descripcion?> </td>
                                            <td align="center"><?php echo $data->ASIGNADO;?></td>
                                            <td align="center"><?php echo $data->RECIBIDO?></td>
                                            <td><?php echo $data->FECHA_MOV ;?></td>
                                            <td><?php echo $data->USUARIO_MOV;?></td>
                                            <td><?php echo $data->COTIZA?></td>
                                            <td><?php echo $status?></td>
                                            <td>
                                                <?php if($rol != 'bodega2'){?>
                                                <input type="button" class="btn btn-info" value="Quitar" onclick="quitarSum(<?php echo $data->ID?>)" id="boton_<?php echo $data->ID?>">
                                                <input type="hidden" name="ida" id="ida_<?php echo $data->ID?>" value="<?php echo $data->ID?>">
                                                <?php }elseif($rol == 'bodega2' and $data->STATUS != 7){?>
                                                <input type="button" class="btn btn-info" value="Quitar" onclick="quitarSum(<?php echo $data->ID?>)" id="boton_<?php echo $data->ID?>" <?php echo ($data->STATUS == 2 OR $data->STATUS == 3 or $data->STATUS == 4)? '':'disabled="disabled"'?> >
                                                <input type="hidden" name="ida" id="ida_<?php echo $data->ID?>" value="<?php echo $data->ID?>">
                                                <?php }elseif($rol == 'bodega2' and $data->STATUS == 7){?>
                                                <input type="button" class="btn btn-success" name="asignar" value="Asignar" onclick="procesar(<?php echo $data->ID?>, 'a')", id='boton_a_<?php echo $data->ID?>'>
                                                <input type="button" class="btn btn-danger" name="asignar" value="Denegar" onclick="procesar(<?php echo $data->ID?>, 'd')", ID = 'boton_d_<?php echo $data->ID?>'>
                                                <?php }?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                                <input type="button" name="impresion" value="impresion" id="enviar" class="btn btn-info">
                            </div>
                      </div>
            </div>
        </div>
    </div>
<br />


<form action="index.php" method="POST" id="FORM_ACTION">
    <input type="hidden" name="folios" value="" id="items">
    <input type="hidden" name="impFoliosAsignacion" value="impFoliosAsignacion">
</form>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">


    $("#enviar").click(function (){
        var items = $("#items");
        var folios = "";
        $("input:checked").each(function(index){
            folios+= this.value+",";
        });
        folios = folios.substr(0, folios.length-1);
        console.log("FOLIOS: "+folios);
        items.val(folios);   
        $("#FORM_ACTION").submit();
    });
  
function quitarSum(ida){
    //var ida = document.getElementById('ida'_).value;
        document.getElementById('boton_'+ ida).classList.add('hide');
    $.ajax({
        url:'index.php',
        method: 'POST',
        dataType:'json',
        data:{quitarSum:ida}
    });
}

function procesar(ida, tipo){
    if(tipo == 'a'){
        if(confirm('Se Creara la asignacion para Recibo')){
                 document.getElementById('boton_a_'+ida).classList.add('hide');
                 document.getElementById('boton_d_'+ida).classList.add('hide');
                  $.ajax({
                     url:'index.php',
                     method: 'POST',
                     dataType: 'json',
                     data:{procesarAsigAuto:ida, tipo:tipo}
                  });
         }
    }else{
        if(confirm('Se Creara un vale para el Responsable de la Bodega')){
                 document.getElementById('boton_a_'+ida).classList.add('hide');
                 document.getElementById('boton_d_'+ida).classList.add('hide');
                  $.ajax({
                     url:'index.php',
                     method: 'POST',
                     dataType: 'json',
                     data:{procesarAsigAuto:ida, tipo:tipo}
                  });
         }
    }
}


</script>
