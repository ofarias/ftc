<br/><br/>
<?php ?>
        <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Liberar partidas
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-verDeudores">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>ORDEN DE COMPRA</th>
                                            <th>FECHA</th>
                                            <th>CLAVE PRODUCTO</th>
                                            <th>NOMBRE PRODUCTO</th>
                                            <th>CANTIDAD</th>
                                            <th>PENDIENTE</th>
                                            <th>PROVEEDOR</th>
                                            <th>FECHA DE RECEPCION</th>
                                            <th>RECEPCION</th>
                                            <th>ESTATUS RECEPCION</th>
                                            <th>DIAS</th>
                                            <th>Vueltas Producto</th>
                                            <th>LIBERAR</th>
                                            <th>Reenrutar</th>
                                            <?php if($usuario == 'Alejandro Perla'){?>
                                            <th>Cancelar</th>
                                            <?php }?>
                                        </tr>
                                    </thead>   
                                  <tbody>
                                        <?php
                                        $i = 0;
                                        foreach ($deudores as $data): 
                                            $i=$i+1;
                                        ?>                                            
                                       <tr>
                                            <td><?php echo $data->ID_PREOC;?> <a href="index.php?action=historiaIDPREOC&id=<?php echo $data->ID_PREOC?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;"> Historial</a> </td>
                                            <td><?php echo $data ->CVE_DOC;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->CVE_ART;?></td>
                                            <td><?php echo $data->CAMPLIB7;?></td>
                                            <td><?php echo $data->CANT;?></td>
                                            <td><?php echo $data->PXR;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->FECHA_DOC_RECEP;?></td>
                                            <td><?php echo $data->DOC_RECEP;?></td>
                                            <td><?php echo $data->DOC_RECEP_STATUS;?></td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <td><?php echo $data->VUELTA;?></td>
                                            <td>
                                              <!--  <input type="button" value="Liberar" class="btn btn-warning" onclick="liberar(<?php echo $i?>, 'liberaPendientes')" >  -->
                                                <a href="index.php?action=liberaPendientes&doco=<?php echo $data->CVE_DOC?>&pxr=<?php echo $data->PXR?>&id_preoc=<?php echo $data->ID_PREOC?>&par=<?php echo $data->NUM_PAR?>" id = "aa_<?php echo $i?>"  class="btn btn-warning" onclick="ocultar(<?php echo $i?>)" target="el-iframe">Liberar</a>
                                            </td>
                                            <td>
                                                 <input type="button" value="Re-Enrutar" class="btn btn-success"  onclick="liberar(<?php echo $i?>, 'reEnrutar')" id="bb_<?php echo $i?>"/>
                                            </td>
                                            <input type="hidden" id="iterador" name="iterado" value="<?php echo $i?>">
                                            <input type="hidden" id="doco_<?php echo $i ?>" name="doc" value = "<?php echo $data->CVE_DOC?>" >
                                            <input type="hidden" id="pxr_<?php echo $i?>" name="pxr" value="<?php echo $data->PXR?>">
                                            <input type="hidden" id="idpreoc_<?php echo $i?>" name="idpreoc" value="<?php echo $data->ID_PREOC?>">   
                                            <?php if($usuario == 'Alejandro Perla'){?>
                                                
                                            <td>
                                                <input type="hidden" name="idpreoc" value ="<?php echo $data->ID_PREOC?>">
                                                <a  href="index.php?action=liberaPendientes&doco=<?php echo 'AAA'.$data->CVE_DOC?>&pxr=<?php echo $data->PXR?>&id_preoc=<?php echo $data->ID_PREOC?>&par=<?php echo $data->NUM_PAR?>" id = "aa_<?php echo $i?>" class="btn btn-danger" onclick="ocultar(<?php echo $i?>)" target = "el-iframe">Cancelar</button>     
                                            </td>
                                                
                                            <?php }?>
                                        </tr>
                                            <?php endforeach; ?>

                                    </tbody>                    
                                </table>
                            </div>
                  </div>
            </div>
        </div>
</div>

        <form action="index.php" method="POST" id="FORM_ACTION">
            <input type="hidden" name="doco" id="odoc" value="" />
            <input type="hidden" name="id_preoc" id="oidpreoc" value="" />
            <input type="hidden" name="pxr" id="opxr" value="" />
            <input type="hidden" name="" id="f" />
        </form>

<iframe name="el-iframe" type="hidden"></iframe>


<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="http://bootboxjs.com/bootbox.js"></script>
<script type="text/javascript">

function ocultar(i){
    document.getElementById('aa_'+i).classList.add('hide');
    document.getElementById('bb_'+i).classList.add('hide');
  }


function cancelar(id){
    var a = confirm('Desea Cancelar el ID, '+ id +', ya no aparecera en Suministros y se marca como cancelado?');

    if(a == true){
        alert('procede con la cancelacion');
    }else{
        alert('Se cancela la cancelacion');
    }

}

function liberar(i, tipo){
    var doco = document.getElementById('doco_'+i).value;
    var pxr = document.getElementById('pxr_'+i).value;
    var idpreoc = document.getElementById('idpreoc_'+i).value;
    document.getElementById('aa_'+i).classList.add('hide');
    document.getElementById('bb_'+i).classList.add('hide');
    

    if(tipo == 'reEnrutar'){
        if(!(confirm('Se reenrutaran todas las partidas de la orden de compra: '+ doco +' ,esta seguro?'))){
        }else{
        document.getElementById('odoc').value = doco;
        document.getElementById('oidpreoc').value = idpreoc;
        document.getElementById('opxr').value=pxr;
        document.getElementById('f').name=tipo;
        form = document.getElementById("FORM_ACTION");
        form.submit();
        }
    }else{
        document.getElementById('odoc').value = doco;
        document.getElementById('oidpreoc').value = idpreoc;
        document.getElementById('opxr').value=pxr;
        document.getElementById('f').name=tipo;
        form = document.getElementById("FORM_ACTION");
        form.submit();
    }
}

   
</script>