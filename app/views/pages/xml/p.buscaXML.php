<br/>
<?php echo 'Usuario:<b>'.$_SESSION['user']->NOMBRE.'</b>'?>
<br/>
<div>
    <p><b>Busca por Documento Fiscal:</b> <input type="text" name="doc" placeholder="Documento Fiscal (Facturas, Nota de Credito, Refacturacion)" size="50" class="bf" tipo="D"> Facturas, Notas de Credito, Refacturaciones.</p>
    <p><b>Busca por Documento Administrativo: </b><input type="text" name="doc" placeholder="Documento Administrativo )" size="40" class="bf" tipo="A"> Pedidos, PreFacturas.</p>

    <p><b>Traer Documentos de un Rango de Fechas: Inicial &nbsp;&nbsp;&nbsp;</b>
            <input type="date" name="doc" placeholder="Fecha inicial" id="fi" > &nbsp;&nbsp;&nbsp;<b>Final:</b>&nbsp;&nbsp;&nbsp; 
            <input type="date" name="doc" placeholder="Fecha Final" id="ff" class="bf" tipo="R"></p>
    
    <p><b>Traer Documentos por Mes y Año:</b> <input type="text" name="doc" placeholder="Mes y Año" size="20" class="bf" tipo="M"> Primero el Mes y despues el año, Ejemplo Marzo 2018</p>
    
    <p><b>Traer Todos los documentos:</b> <input type="text" name="doc" placeholder="Todos los documetos" size="20" class="bf" tipo="H"> para ejecutar coloque la palabra "si" y de enter.</p>

</div>
<?php if(count($info)>0){?>
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
                                            <th>Fecha</th>
                                            <th>UUID</th>
                                            <th>Tipo</th>
                                            <th>Folio</th>
                                            <th>Cliente</th>
                                            <th>SubTotal</th>
                                            <th>Iva</th>
                                            <th>Total</th>
                                            <th>Saldos</th>
                                            <th>Descargar</th>                                            
                                            <th>Notas de <br/>Credito</th>
                                            <th>Envio por <br/>Correo</th>
                                       </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php foreach ($info as $key): 
                                            $color='';
                                            $tipo = '';
                                            $colorFont ='';
                                            if($key->STF == 8){
                                                $tipo = 'Cancelada';
                                                $color = 'style="background-color: #dadddc "';
                                            }elseif($key->SERIE == 'FP'){
                                                $tipo = 'Ingreso';
                                                $color =  'style="background-color:#b3ffb3"';
                                            }elseif (substr($key->SERIE,0,1) == 'N') {
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
                                            if($key->SALDO_FINAL>1){
                                                $colorFont="color='red'";
                                            }
                                        ?>
                                        <tr class="odd gradeX" <?php echo $color ?> >
                                            <td><?php echo $key->FECHA;?> </td>
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php if(!empty($key->UUID)){?>
                                                <?php echo $key->UUID ?><br/>
                                                 
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
                                                <?php }else{?>
                                                    <input type="button" name="timbrar" value="Timbrar" class="btn btn-info" onclick="timbrar('<?php echo $key->SERIE.$key->FOLIO?>')" >
                                                <?php }?>
                                            </td>
                                            <td><?php echo $tipo?></td>
                                            <td><?php echo $key->SERIE.$key->FOLIO.'<br/>'.$key->CVE_FACT?><br/> <?php echo $key->PREFACT?></td>
                                            <td><?php echo '('.$key->CLIENTE.')  '.$key->NOMBRE;?><br/>
                                                <?php echo ($key->CLIENTE == 'SUB910603SB3')? '<a href="index.php?action=timbraNCDescLogSub&docf='.$key->SERIE.$key->FOLIO.'">NC Suburbia</a>':'' ?>
                                            </td>
                                            <td><?php echo '$ '.number_format($key->SUBTOTAL,2);?></td>
                                            <td><?php echo '$ '.number_format($key->IVA1,2);?></td>
                                            <td><?php echo '$ '.number_format($key->IMPORTE,2);?> </td>
                                            <td><font <?php echo $colorFont ?>><?php echo '$ '.number_format($key->SALDO_FINAL,2)?></font></td>
                                            <td>
                                            <a href="/Facturas/facturaPegaso/<?php echo $key->SERIE.$key->FOLIO.'.xml'?>" download>  <img border='0' src='app/views/images/xml.jpg' width='25' height='30'></a>
                                            
                                            <a href="index.php?action=imprimeFact&factura=<?php echo $key->SERIE.$key->FOLIO?>" onclick="alert('Se ha descargado tu factura.')"><img border='0' src='app/views/images/pdf.jpg' width='25' height='30'></a>
                                             
                                            <!--<a href="index.php?action=addenda&docf=<?php echo $key->SERIE.$key->FOLIO?>"  target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;">addenda</a>-->
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
                                            <td><a href="index.cobranza.php?action=envFac&docf=<?php echo $key->DOCUMENTO?>" onclick="window.open(this.href, this.target, 'width=1000, height=800'); return false;">Enviar por <br/>Correo</a></td>
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

<?php }?>
<form action="index.php" method="post" id="impNC">
    <input type="hidden" name="factura" value="" id="fact">
    <input type="hidden" name="imprimeFact" value="">
</form>


<script type="text/javascript" language="JavaScript" src="app/views/bower_components/jquery/dist/jquery.min.js"></script>
<script type="text/javascript">    

    function timbrar(doc){
        $.ajax({
            url:'index.php',
            type:'post',
            dataType:'json',
            data:{buscaDoc:doc},
            success:function(data){
                alert(data.mensaje)
            },
            error:function(data){

            }
        })
    }

    $(".bf").change(function(){
        var valor = $(this).val();
        var tipo = $(this).attr('tipo');
        valor = tipo+":"+valor;
        if(tipo == 'R'){
            var valor2 = document.getElementById("fi").value;
            if(valor2 ==''){
                alert ('Seleccione una fecha inicial');
                return;
            }
            valor= tipo+':'+valor2+":"+valor; 
        }
        //alert('cambio el valor' + valor);
        window.open("index.php?action=imprimeXML&uuid="+valor,"_self");
    })

    function imprimeNC(nc){
        document.getElementById('fact').value=nc; 
        form = document.getElementById("impNC");
        form.submit();
    }

    function cancelar(uuid, docf){
        if(confirm('Esta seguro de cancelar la facturas o Nota de Credito: ' +  docf + ', al cancelarla se enviara automaticamente correo a Contabiliad, Gerente de CxC, Vendedor y Sistemas')){
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