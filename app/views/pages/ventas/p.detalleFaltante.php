<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                              Detalles de Preorden.
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Partida</th>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>U M</th>
                                            <th>Ordenado</th>
                                            <th>Recepcion</th>
                                            <th>Faltante</th>
                                            <th>Empacado</th>
                                            <th>Recalcular</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($datos as $key):
                                          $color = '';
                                            if($key->CANT_ORIG < $key->ORDENADO){
                                              $color = "style='background-color:yellow'";
                                            }
                                            $rev= 0;
                                            if($key->ORDENADO > $key->CANT_ORIG){
                                              $rev= 1;
                                            }
                                          ?>
                                       <tr class="odd gradeX" <?php echo $color?>>
                                            <td><a href="index.php?action=historiaIDPREOC&amp;id=<?php echo $key->ID;?>" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;"><?php echo $key->ID;?></a></td>
                                            <td><?php echo $key->PAR;?></td>
                                            <td><?php echo $key->PROD;?></td>
                                            <td><?php echo $key->CANT_ORIG;?></td>
                                            <td><?php echo $key->UM;?></td>
                                            <td><?php echo $key->ORDENADO;?></td>
                                            <td><?php echo $key->RECEPCION;?></td>
                                            <td><?php echo $key->REC_FALTANTE;?></td>
                                            <td><?php echo $key->EMPACADO;?></td>
                                            <td>
                                              <input type="button" name="recalcularID" onclick="recalcular(<?php echo $key->ID?>)" value="Recalcular">
                                              
                                            </td>
                                           <?php endforeach ?>
                                        </tr>                                 
                                 </tbody>
                                 </table>
                      </div>
            </div>
        </div>
</div>

<script type="text/javascript">
  
    function recalcular(i){

     
        if (confirm('Recalcular el ID: ' + i + ' ?.')){
          $.ajax({
            url:"index.v.php",
            method:"POST", 
            dataType:"json",
            data:{recalcular:i, tipo:1},
            success:function(data){
              if(confirm("Se ajustara con la sigiente informacion: ordenado: "+ data.ordenado + " , recibido: " + data.recibido + ", Faltante: " +  data.pendiente + " Empacado: "+ data.empacado)){
                $.ajax({
                  url:"index.v.php",
                  method:"POST", 
                  dataType:"json",
                  data:{recalcular:i,tipo:2},
                  success:function(data){
                    location.reload(true);
                    alert(data.status);
                  }
                });
              }
            }
          })
        }else{
          alert('Se cancelo la confirmacion.');
        }  
      
      
    }
</script>