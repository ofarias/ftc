<br/>
<br/>
<?php echo 'Usuario:<b>'.$_SESSION['user']->NOMBRE.'</b>'?>
<br/>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-facturasxml">
                                    <thead>
                                        <tr>
                                            <th>UUID</th>
                                            <th>TIPO</th>
                                            <th>FOLIO</th>
                                            <th>FECHA</th>
                                            <th>CLIENTE</th>
                                            <th>SUBTOTAL</th>
                                            <th>IVA</th>
                                            <th>TOTAL</th>
                                            <th>Descargar</th>                                            
                                            <th>Notas de <br/>Credito</th>
                                       </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php foreach ($info as $key): 
                                            $color='';
                                            if($key->STF == 8){
                                                $tipo = 'Cancelada';
                                                $color = 'style="background-color: #dadddc "';
                                            }elseif($key->SERIE == 'FP'){
                                                $tipo = 'Ingreso';
                                                $color =  'style="background-color:#b3ffb3"';
                                            }elseif ($key->SERIE =='NCR') {
                                                $tipo = 'Egreso';
                                                $color = 'style="background-color:#ffcccc"';
                                            }elseif ($key->SERIE =='RFP') {
                                                $tipo = 'Ingreso';
                                                $color = 'style="background-color:#b3e6ff"';
                                            }elseif($key->STF == 8){
                                                $tipo = 'Cancelada';
                                                $color = 'style="background-color:RED"';
                                            }
                                            $file = substr($key->FILE,36,100);
                                            $ncs=explode(",", $key->NOTAS);

                                        ?>
                                        <tr class="odd gradeX" <?php echo $color ?> >
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $key->UUID ?><br/> 
                                                <?php if($key->STF == 8){?>
                                                Acuse de Cancelacion &nbsp;&nbsp;&nbsp;<a href="index.php?action=imprimeAcuse&docf=<?php echo $key->SERIE.$key->FOLIO?>"><img border='0' src='app/views/images/pdf.jpg' width='25' height='30'></a>&nbsp;&nbsp;&nbsp;<a ><img border="0" src="app/views/images/xml.jpg" width="25" height="30"></a>
                                                <?php }else{ 
                                                    if(!empty($key->POLIZA)){
                                                ?>
                                                        <?php echo 'Poliza: '.$key->POLIZA?>  
                                                <?php }else{?>

                                                      <a onclick="cancelar('<?php echo $key->UUID?>', '<?php echo $key->SERIE.$key->FOLIO?>')">Cancelar</a>
                                                
                                                <?php } 
                                                    }?>
                                            </td>
                                            <td><?php echo $tipo?></td>
                                            <td><?php echo $key->SERIE.$key->FOLIO.'<br/>'.$key->CVE_FACT?><br/> <?php echo $key->PREFACT?></td>
                                            <td><?php echo $key->FECHA;?> </td>
                                            <td><?php echo '('.$key->CLIENTE.')  '.$key->NOMBRE;?><br/>
                                                <?php echo ($key->CLIENTE == 'SUB910603SB3')? '<a href="index.php?action=timbraNCDescLogSub&docf='.$key->SERIE.$key->FOLIO.'">NC Suburbia</a>':'' ?>
                                            </td>
                                            <td><?php echo '$ '.number_format($key->SUBTOTAL,2);?></td>
                                            <td><?php echo '$ '.number_format($key->IVA1,2);?></td>
                                            <td><?php echo '$ '.number_format($key->IMPORTE,2);?> </td>
                                            <td>
                                                <a href="/Facturas/facturaPegaso/<?php echo $key->SERIE.$key->FOLIO.'.xml'?>" download>  <img border='0' src='app/views/images/xml.jpg' width='25' height='30'></a>
                                            
                                            <form action="index.php" method="POST">
                                                <input type="hidden" name="factura" value="<?php echo $key->SERIE.$key->FOLIO?>">
                                                <button name="imprimeFact" value="enviar" type="submit"><img border='0' src='app/views/images/pdf.jpg' width='25' height='30'></button>
                                            </form>
                                            <a href="index.php?action=imprimeFact&factura<?php echo $key->SERIE.$key->FOLIO?>" onclick="alert('Se ha descargado tu factura.')"><img border='0' src='app/views/images/pdf.jpg' width='25' height='30'>ghduigdiy</a>
                                             
                                            <a href="index.php?action=addenda&docf=<?php echo $key->SERIE.$key->FOLIO?>"  target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;">addenda</a>
                                            </td>
                                            <td>  
                                                <?php 
                                                    for ($i=0; $i<count($ncs); $i++) { 
                                                        $nc = "'".$ncs[$i]."'";
                                                    if(strlen($nc)>2){
                                                        echo '<a href="javascript:imprimeNC('.$nc.')">'.$ncs[$i].'<img border="0" src="app/views/images/pdf.jpg" width="25" height="30"><a/>XML<a href="/Facturas/facturaPegaso/'.$ncs[$i].'.xml" download ><img border="0" src="app/views/images/xml.jpg" width="25" height="30"></a><br/>'; 
                                                    }
                                                }?>
                                            </td>
                                        </tr>
                                        </form>
                                        <?php endforeach; ?>
                                    </tbody>  
                                </table>
                            </div>
                      </div>
            </div>
        </div>
</div>
<form action="index.php" method="post" id="impNC">
    <input type="hidden" name="factura" value="" id="fact">
    <input type="hidden" name="imprimeFact" value="">
</form>
<script type="text/javascript">    
    function imprimeNC(nc){
        document.getElementById('fact').value=nc; 
        form = document.getElementById("impNC");
        form.submit();
    }

    function cancelar(uuid, docf){
        if(confirm('Esta seguro de cancelar la facturas ' +  docf + ', al cancelarla se enviara automaticamente correo a Contabiliad, Gerente de CxC, Vendedor y Sistemas')){
            alert('Inicia proceso de cancelacion');
            $.ajax({
                url:'index.v.php',
                type:'POST',
                dataType:'json',
                data:{cancelar:uuid, docf:docf},
                success:function(data){
                    alert(data.motivo);
                },
                error:function(data){
                    alert(data.motivo);
                }
            });
        }
    }

</script>