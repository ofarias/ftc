<br /><br />
<div class="row">
        <?php if(!empty($recibedoc)){
            if($recibedoc == true){
                $alerta = "alert alert-success";
                $mensaje = "Documentos asignados correctamente.";
                }else{
                $alerta = "alert alert-error";
                $mensaje = "Los documentos no se pudieron asignar.";                    
                }
            }else{
                $alerta = "";
                $mensaje = "";
            } 
    ?>
<div class="<?php echo $alerta;?>"><center><h2><?php echo $mensaje;?></h2></center></div>
 
</div>

<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Asignacion de Unidad Entrega.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc1">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <!--<th>Or</th>-->
                                            <th>Caja</th>
                                            <th>Pedido</th>
                                            <th>Cliente</th>
                                            <th>Estado</th>
                                            <th>CP</th>
                                            <th>Fecha Factura</th>
                                            <th>Factura</th>
                                            <th>Remision</th>
                                            <th>Dias de Atraso</th>
                                            <th>Documentos</th>
                                            <th>Recibir Documentos</th>
                                            <th>Seleccionar Unidad</th>
                                           
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        $i=0;
                                        foreach ($entrega as $data): 
                                            $i++;
                                            $color = $data->DIAS;
                                            //$urgencia = $data->URGENCIA;
                                            $urgencia= 'A';
                                            if ($urgencia == 'U'){
                                                $color = "style='background-color: red;'";
                                            }elseif ($color <= 1 ){
                                               $color="style='background-color: white;'";             
                                            }elseif($color == 3 ){
                                               $color="style='background-color:#FFBF00;'";
                                            }elseif ($color > 3 and $color < 7 ){
                                            $color="style='background-color:#81DAF5;'";
                                            }elseif ($color >= 7 ){
                                            $color="style='background-color:red;'";
                                            }
                                            $var=$data->DOCS;
                                        ?>
                                       <tr class="odd gradeX" <?php echo $color;?>>
                                            <td><?php echo $data->ID;?></td>
                                            <td><a href="index.php?action=detalleOC&doco=<?php echo $data->CVE_FACT?>"><?php echo $data->CVE_FACT;?></a></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->ESTADO;?></td>
                                            <td><?php echo $data->CODIGO;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->FACTURA;?></td>
                                            <td><?php echo $data->REMISIONDOC;?></td>
                                            <td><?php echo $data->DIAS ?> 
                                                <?php if($data->VUELTAS > 0){?>
                                                <br/><b><font size="2 pxs" color="white"><a href="index.php?action=verVueltas&idcaja=<?php echo $data->ID?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;"><?php echo $data->VUELTAS ?>&nbsp;&nbsp;Vueltas</a></font></b>
                                                <?php }?>
                                            </td>
                                            <td><?php echo $data->DOCS.'UNIDAD'.$data->UNIDAD;?></td>
                                            <td>
                                                <?php if(empty($data->U_LOGISTICA)){?>
                                                <input type="button" name="recibir" value="Recibir" onclick="recibirDoc(<?php echo $i?>)" id="btn_<?php echo $i?>"></td> 
                                                <?php }else{?>
                                                <font color = "#3385ff"><?php echo $data->U_LOGISTICA.'<br/>'.$data->FECHA_U_LOGISTICA?></font>
                                                <?php }?>
                                            <td>

                                                <input name="idcaja" type = "hidden" value = "<?php echo $data->ID?>" id="idc_<?php echo $i?>"/>
                                                <input type="hidden" name="factura" value="<?php echo $data->FACTURA?>" id="docf_<?php echo $i?>">
                                                <input type="hidden" name="remision" value="<?php echo $data->REMISION?>" id="docr_<?php echo $i?>">
                                                
                                                <select name="unidad" onchange="aRuta(this.value, <?php echo $i?>)" id="selec_<?php echo $i?>">
                                                    <option value="<?php echo empty($data->UNIDAD)? 'nada':"$data->UNIDAD" ?>"><?php echo empty($data->UNIDAD)? "--Selecciona Unidad--":"$data->UNIDAD" ?></option>
                                                <?php foreach($unidad as $u):?>
                                                     <option value="<?php echo $u->NUMERO?>"><?php echo $u->NUMERO?></option>
                                                <?php endforeach ?>
                                                </select>
                                            </td>                                           
                                           
                                            </tr>   
                                         <?php endforeach ?>
                                 </tbody>
                                 </table>
                            <div>
                                <input type="button" name="guardar" value="Guardar" onclick="guardar()" class="btn btn-success">
                            </div>
                      </div>
                </div>
        </div>
    </div>
</div>

<form action="index.php" method="POST" id="formguarda">
    <input type="hidden" name="unidadentrega" value="">
    <input type="hidden" name="idcaja" value="">
    <input type="hidden" name="docu" value="">
    <input type="hidden" name="edo" value="">
    <input type="hidden" name="unidad" value="">
</form>

<script type="text/javascript">

    function guardar(){
        if(confirm("Desea guardar la informacion, los documentos asignados pasara a la ruta.")){
            var form = document.getElementById('formguarda');
            form.submit();
        }
    }
    
    function recibirDoc(i){
        var caja = document.getElementById('idc_'+ i).value;
        var docf = document.getElementById('docf_'+ i).value;
        var docr = document.getElementById('docr_'+ i).value; 
            if(docf==""){
                doc = docr;
            }else{
                doc = docf;
            }
        if(confirm('Desea Recibir el Documento: ' + doc)){
            document.getElementById("btn_"+i).classList.add('hide');
            $.ajax({
                url:"index.php",
                method:"POST",
                dataType:"json",
                data:{recibeDocRep:1,caja:caja},
                success:function(data){
                    if(data.status == 'ok'){
                        alert('Se actualizo correctamente');
                    }else if(data.status == 'no'){
                        alert('Se actualizo correctamente');
                        document.getElementById("btn_"+i).classList.remove('hide');    
                    }else if(data.status == 'okok');
                        alert('Ya se habia recibido el documento por el usuario: '.data.usuario);
                }
            })
        }
    }

    function aRuta(uni, i){
        var caja = document.getElementById('idc_'+ i).value;
        if(uni =='nada'){
            $.ajax({
                url:"index.php",
                method:"POST",
                dataType:"json",
                data:{traeUnidadActual:caja},
                success:function(data){
                    document.getElementById('selec_'+i).value = data.caja;
                    alert('Debe de seleccionar una unidad.');       
                }                
            })
        }else{
            if(confirm('Desea asignar el documento a la unidad ' + uni)){
                $.ajax({
                    url:'index.php',
                    method:"POST",
                    dataType:"json",
                    data:{aRutaRep:1,caja:caja,unidad:uni},
                    success:function(data){
                        if(data.status == 'ok1'){
                            alert(data.mensaje);
                            document.getElementById("btn2_"+i).innerHTML=data.unidad; 
                        }else if(data.status == 'ok2'){
                            alert(data.mensaje);
                        }else if(data.status == 'error'){
                            alert(data.mensaje);
                        }else if(data.status == 'na'){
                            alert(data.mensaje);
                        }else if(data.status == 'sinDocs'){
                            alert(data.mensaje);
                            document.getElementById("selec_"+i).value="nada";
                        }
                    }
                })
            }else{

            }
        }
    }
</script>