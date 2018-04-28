<br /> <br/> <br/>

<?php if(count($paquetespar) > 0){?>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Preparar Material.
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                           <!-- <th>ID</th> -->
                                            <th>ENVIO</th>
                                            <th style="width:200px">Documento</th>
                                            <th>Caja</th>
                                            <th>Fecha</th>                                         
                                            <th>Paquete</th>
                                            <th>Paquete1</th>
                                            <th>de</th>
                                            <th>Paquete2</th>
                                            <th>Tipo</th>
                                            <th>Peso</th>
                                            <th>  </th>
                                            <th>Alto</th>
                                            <th>  </th>
                                            <th>Largo</th>
                                            <th>  </th>
                                            <th>Ancho</th>
                                            <th>  </th>
                                            <th>Peso Vol</th>
                                            <th>Embalar</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($paquetespar as $data):
                                            ?>
                                        <tr>
                                          <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                         <!--   <td><?php echo $data->ID_PREOC;?></td> -->
                                            <td><?php echo $data->TIPO_ENVIO;?></td>
                                            <td>
                                                <a class="collapsed" data-toggle="collapse" href="<?php echo '#'.$data->EMPAQUE;?>" aria-expanded="false" aria-controls="<?php echo $data->EMPAQUE;?>"><?php echo $data->DOCUMENTO;?></a>
                                                <div id="<?php echo $data->EMPAQUE;?>" class="collapse"  aria-expanded="false" aria-controls="<?php echo $data->EMPAQUE;?>">
                                                   <ul>
                                                        <?php foreach($detallepaq as $det){
                                                                echo ($det->EMPAQUE == $data->EMPAQUE & $det->IDCAJA == $data->IDCAJA) ? "<li>" . $det->ARTICULO . " " . $det->DESCRIPCION . " Cantidad: " . $det->CANTIDAD."</li>" : "";
                                                        }?>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td><?php echo $data->IDCAJA;?></td>
                                            <td><?php echo $data->FECHA_PAQUETE;?></td>
                                            <td><?php echo $data->EMPAQUE;?></td>
                                        <!--    <td><?php echo $data->ARTICULO;?></td>
                                            <td><?php echo $data->DESCRIPCION;?></td>
                                            <td><?php echo $data->CANTIDAD;?></td>    -->
                                            <form action="index.php" name="form" method="post" id="asignaembalaje">
                                            <td><input name="paquete1" type="text" required="required" size="5" /></td>
                                            <td> de </td>
                                            <td><input name="paquete2" type="text" required="required" size="5"/></td>
                                            <td><?php echo $data->TIPO_EMPAQUE;?></td>
                                            <td><input class="peso" name="peso" type="number" required="required" step="any" style="width: 70px;" /></td>
                                            <td> Kg </td>
                                            <td><input class="alto" name="alto" type="number" value = "0" step="any" style="width: 70px" /></td>
                                            <td> cm </td>
                                            <td><input class="largo" name="largo" type="number" value = "0" step="any" style="width: 70px" /></td>
                                            <td> cm </td>
                                            <td><input class="ancho" name="ancho" type="number" value = "0" step="any" style="width: 70px" /></td>
                                            <td> cm </td>
                                            <td><input class="pesovol" name="pesovol" type="number" step="any" style="width: 70px" readonly="readonly" size ="6" /></td>
                                            <td>
                                            <input name="docf" type="hidden" value="<?php echo $data->DOCUMENTO?>"/>
                                            <input name="idc" type="hidden" value="<?php echo $data->IDCAJA?>" />
                                            <input name="tipo" type= "hidden" value="<?php echo $data->TIPO_EMPAQUE?>"/>
                                            <input name="idemp" type ="hidden" value="<?php echo $data->EMPAQUE?>"/>
                                                <button name="asignaembalaje" type="submit" value="embalar" class="btn btn-warning"><i class="fa fa-check">Embalar</i></button>
                                            </td> 
                                            </form>      
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
<br/>
<?php }?>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Materiales Preparados para envio o enviados.
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Documento</th>
                                            <th>Fecha</th>                                         
                                            <th>Paquetes</th>
                                            <th>Clave</th>
                                            <th>Descripcion</th>
                                            <th>Cantidad</th>
                                            <th>Estatus Logistica</th>

                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($emba as $data):
                                            ?>
                                        <tr>
                                          <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->ID_PREOC;?></td>
                                            <td><?php echo $data->DOCUMENTO;?></td>
                                            <td><?php echo $data->FECHA_PAQUETE;?></td>
                                            <td><?php echo $data->EMPAQUE;?></td>
                                            <td><?php echo $data->ARTICULO;?></td>
                                            <td><?php echo $data->DESCRIPCION;?></td>
                                            <td><?php echo $data->CANTIDAD;?></td>
                                            <td><?php echo $data->STATUS_LOG;?></td>  
                                            <td><?php echo $data->PAQUETE1;?></td>
                                            <td> de </td>
                                            <td><?php echo $data->PAQUETE2;?></td>
                                            <td><?php echo $data->TIPO_EMPAQUE;?></td>
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
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
window.addEventListener('keypress',pvolumen,false);
function pvolumen(){
    var peso=document.getElementsByClassName('peso');
    var ancho=document.getElementsByClassName('ancho');
    var largo=document.getElementsByClassName('largo');
    var alto=document.getElementsByClassName('alto');
    var pesovol=document.getElementsByClassName('pesovol');

    for(var c= 0; c < peso.length; c++){
        ///alert(peso[c].value);
        var total = (alto[c].value * largo[c].value * ancho[c].value) / 5000;
        pesovol[c].value= total;
    
    }
}
</script>