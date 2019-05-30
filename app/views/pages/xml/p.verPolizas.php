<br/>
<div style="float: left; width: 400px;">
<br/><br/>
    <p id='pol'></p>
    <br/>
</div>

<br/><br/>
 <?php foreach ($cabecera as $key0){ 
        $rfcEmpresa = $_SESSION['rfc'];
        $rfce = $key0->RFCE;
        $rfc=$key0->CLIENTE;
        $serie=$key0->SERIE;
        $folio=$key0->FOLIO;
        $uuid=$key0->UUID;
    }
?>

<?php $dig=$param->NIVELACTU;
    for ($i=1; $i <= $dig ; $i++) { 
        $a = "DIGCTA".$i;
        $c=$param->$a;    
        $p[]=($c);
    }                                                         
?>

<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div>
                                <p><?php echo 'Usuario: '.$_SESSION['user']->NOMBRE?></p>
                                <p><?php echo 'RFC seleccionado: '.$_SESSION['rfc']?>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <a href="/uploads/xml/<?php echo $rfcEmpresa.'/Recibidos/'.$rfce.'/'.$rfce.'-'.$serie.$folio.'-'.$uuid.'.xml'?>" download>  <img border='0' src='app/views/images/xml.jpg' width='55' height='60'></a>&nbsp;&nbsp;
                                        <a href="javascript:impFact(<?php echo "'".$serie.$folio."'"?>)" download><img border='0' src='app/views/images/pdf.jpg' width='55' height='60'></a>
                                </p>
                                <p><?php echo 'Empresa Seleccionada: <b>'.$_SESSION['empresa']['nombre']."</b>"?></p>  

                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>UUID</th>
                                            <th>TIPO</th>
                                            <th>DOCUMENTO</th>
                                            <th>FECHA</th>
                                            <th>RFC Emisor</th>
                                            <th>RFC Receptor</th>
                                            <th>SUBTOTAL</th>
                                            <th>DESCUENTO</th>
                                            <th>TOTAL</th>                    
                                       </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php foreach ($cabecera as $key): 
                                            $color='';
                                            if($key->TIPO == 'I'){
                                                $tipo = 'Ingreso';
                                                $color =  'style="background-color:orange"';
                                            }elseif ($key->TIPO =='E') {
                                                $tipo = 'Egreso';
                                                $color = 'style="background-color:yellow"';
                                            }
                                            $rfc=$key->CLIENTE;
                                            $rfcEmp =$_SESSION['rfc'];
                                            $cliente = '';
                                            $proveedor = '';
                                            if($rfc==$key->CLIENTE){
                                                $proveedor=$key->NOMBRE;
                                                $t='Egreso';
                                            }else{
                                                $cliente=$key->NOMBRE;
                                                $t='Ingreso';
                                            }
                                        ?>
                                        <tr class="odd gradeX" <?php echo $color ?> >
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td> <?php echo $key->UUID ?> </td>
                                            <td><?php echo $tipo?></td>
                                            <td><?php echo $key->SERIE.$key->FOLIO?></td>
                                            <td><?php echo $key->FECHA;?> </td>
                                            <td><?php echo '<b>('.$key->RFCE.')'.$proveedor."</b>"?></td>
                                            <td><?php echo '<b>('.$key->CLIENTE.')  '.$cliente."</b>";?></td>
                                            <td><?php echo '$ '.number_format($key->SUBTOTAL,2);?></td>
                                            <td><?php echo '$ '.number_format($key->DESCUENTO,2)?></td>
                                            <td><?php echo '$ '.number_format($key->IMPORTE,2);?> </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <input type="hidden" name="" id="t" value="<?php echo $t?>">
                                 </tbody>  
                                </table>
                            </div>
                      </div>
            </div>
        </div>
</div>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Poliza</th>
                                            <th>Fecha</th>
                                            <th>Part</th>
                                            <th>Cuenta</th>
                                            <th>Concepto</th>
                                            <th>Debe</th>
                                            <th>Haber</th>                                           
                                       </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php
                                            $ln= 0;
                                            foreach ($polizas as $key): 
                                                $color='';
                                                $ln++;
                                                $debe = 0;
                                                $haber = 0;
                                                if($key->DEBE_HABER== 'D'){
                                                    $debe = $key->MONTOMOV;
                                                }elseif($key->DEBE_HABER == 'H'){
                                                    $haber = $key->MONTOMOV;
                                                }

                                        ?>
                                        <tr class="odd gradeX" <?php echo $color ?> >
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $key->TIPO_POLI.$key->NUM_POLIZ?></td>
                                            <td> <?php echo $key->FECHA_POL ?> </td>
                                            <td><?php echo $key->NUM_PART;?> </td>
                                            <td><?php echo $key->NUM_CTA;?></td>
                                            <td><?php echo $key->CONCEP_PO?></td>
                                            <td><?php echo '$ '.number_format($debe,3);?></td>
                                            <td><?php echo '$ '.number_format($haber,3);?> </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <input type="hidden" name="partidas" id="partidas" value="<?php echo $ln?>">
                                 </tbody>
                                </table>
                            </div>
                      </div>
            </div>
        </div>
</div>
<input type="hidden" name="u" id='uuid' value='<?php echo $uuid?>' doc="<?php echo $serie.$folio?>">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">
   
    $(document).ready(function(){
        var boton = document.getElementById('pol');
        //alert('Entro al ready function y cargo el id pol');
        var tipo = document.getElementById('t').value;
        boton.innerHTML='<input type="button" value ="Crea Poliza de '+tipo+'" class="btn btn-success" onclick="crearPolizas()">';
    });

    function impFact(factura){
        alert('Proximamente');
        return;
            $.ajax({
                url:'index.php',
                type:'post',
                dataType:'json',
                data:{imprimeFact:1, factura:factura},
                success:function(data){
                }
            })
        }

    function crearPolizas(){
        var ent= document.getElementById('uuid');
        var uuid = ent.value;
        var docu = ent.getAttribute('doc'); 
        var tipo = document.getElementById('t').value;

        if(confirm('Desea Realizar la poliza de '+tipo+' de Documento '+ docu + '')){
            $.ajax({
                url:'index.coi.php',
                type:'post',
                dataType:'json',
                data:{creaPoliza:tipo,uuid},
                success:function(data){
                    alert(data.mensaje + ': ' + data.poliza + ' en el  Periodo ' + data.periodo + ' del Ejercicio ' + data.ejercicio + 'Favor de revisar en COI ');
                }
            })
        }else{
            alert('No se ha realizado ningun cambio');
        }
    }
        
</script>