<br/>
<input type="button" name="" value="Liberar Recepciones" class="btn-small btn-warning lib">
<br/>
<br/>

<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Orden</th>
                                            <th>Fecha</th>
                                            <th>Proveedor</th>
                                            <th>RFC</th>
                                            <th>Cantidad <br/> Ordenada</th>
                                            <th>Cantidad <br> Recibida </th>
                                            <th>Status </th>
                                            <th>Validar</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($recepciones as $data):
                                            $color = '';
                                            $status = 'Validar';
                                            $boton = "class='btn btn-info'";
                                            if($data->STATUS == 'Completa'){
                                                $color = "style='background-color:#00C399;'";
                                            }
                                            if($data->STA == 7){
                                                $color = "style='background-color:#E6E0F8'";
                                                $status = "Autotizacion de Costos";
                                                $boton = "class='btn btn-warning'";
                                            }
                                        ?>
                                        <tr class="odd gradeX" <?php echo $color;?> >
                                            <td><?php echo $data->ORDEN;?></td>
                                            <td><?php echo $data->FECHAELAB?></td>
                                            <td><?php echo '('.$data->CVE_PROV.') '.$data->NOMBRE?></td>
                                            <td><?php echo $data->RFC?></td>
                                            <td><?php echo $data->ORIGINAL;?></td>
                                            <td><?php echo $data->RECIBIDA;?></td>  
                                            <td><?php echo $data->STATUS?></td> 
                                                <form action="index.php" method="post">
                                            <td>
                                                <input type="hidden" name="doco" value="<?php echo $data->ORDEN?>">
                                                <button name="valRecepcion" value="enviar" type="submit" <?php echo $data->STATUS_VALIDACION == 9? "class='btn btn-danger'":$boton?> <?php echo $data->STATUS_VALIDACION == 9? "disabled='disabled'":""?>  > <?php echo ($data->STATUS_VALIDACION == 9)? 'En Proceso':$status ?> </button>
                                                <br/> <?php echo !empty($data->FECHA_COSTO)? "Desde:$data->FECHA_COSTO":"" ?>
                                            </td>     
                                            </form>                                        
                                        </tr>
                                 </tbody>
                          
                                 <?php endforeach; ?>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
    </div>
<br />

<script type="text/javascript" language="JavaScript" src="app/views/bower_components/jquery/dist/jquery.min.js"></script>
<script type="text/javascript">
    
    $(".lib").click(function(){
        if(confirm('Antes de liberar revise con sus compañeros si no estan validando la Orden Deseada...')){
            $.ajax({
                url:'index.php',
                type:'post',
                dataType:'json',
                data:{libVal:1},
                success:function(data){
                    alert(data.mensaje)
                }
            })
        }else{
            return false
        }
    })

    function validador(){
        document.getElementById('val').classList.add('hide');
    }
    
    function rechazar(ids, desc){
        //var recWindow = window.open("index.php?action=verSolProdVentas","Mensaje","width=200,height=100")
        //recWindow.document.write("<p> Esta es la ventana</p>")
        var id = ids;
        alert('Se rechazara la Solicitud de alta del Producto :' + desc );
        window.open('index.php?action=rechazarSol&ids='+ids,"","width=800,height=800")
    }

    function pulsar(e) { 
        tecla = (document.all) ? e.keyCode :e.which; 
         return (tecla!=13); 
    } 



</script>
