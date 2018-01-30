<br/>

<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Datos de la Pre Orden <?php echo $doco?>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Pre Orden</th>
                                            <th>Fecha</th>
                                            <th>Proveedor</th>
                                            <th>RFC</th>
                                            <th>SubTotal</th>
                                            <th>IVA </th>
                                            <th>Total </th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($cabecera as $data):
                                        ?>
                                        <tr>
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->FECHA_ELAB?></td>
                                            <td><?php echo '('.$data->CVE_PROV.') '.$data->NOMBRE?></td>
                                            <td><?php echo $data->RFC?></td>
                                            <td><?php echo '$ '.number_format($data->COSTO,2);?></td>
                                            <td><?php echo '$ '.number_format(($data->TOTAL_IVA),2);?></td>  
                                            <td><?php echo '$ '.number_format($data->COSTO_TOTAL,2)?></td>                                              
                                        </tr>
                                 </tbody>
                                 <tfoot>
                                    <tr>
                                        <th>Dias de Credito: </th>
                                        <th><?php echo $data->DIASCRED?></th>
                                    </tr>
                                     <tr>
                                         <th>Direccion</th>
                                         <th> <?php echo $data->CALLE.', '.$data->NUMEXT.', '.$data->COLONIA.', '.$data->CP?> </th>
                                     </tr>
                                     <tr>
                                         <th>Acepta Efectivo: </th>
                                         <th><?php echo (empty($data->TP_EFECTIVO))? 'No definido':$data->TP_EFECTIVO?></th>
                                     </tr>
                                     <tr>
                                         <th>Acepta Credito: </th>
                                         <th><?php echo empty($data->TP_CREDITO)? 'No definido':$data->TP_CREDITO ?></th>
                                     </tr>
                                     <tr>
                                         <th>Acepta Cheque: </th>
                                         <th><?php echo empty($data->TP_CHEQUE)? 'No definido':$data->TP_CHEQUE?></th>
                                     </tr>
                                     <tr>
                                         <th>Acepta Efectivo: </th>
                                         <th><?php echo empty($data->TP_TRANSFERENCIA)? 'No definido':$data->TP_TRANSFERENCIA?></th>
                                         <th title="Numero de cuenta" > <?php echo empty($data->CUENTA)? 'No definido':$data->CUENTA ?></th>
                                         <th title="Banco"> <?php echo empty($data->BANCO)? 'No definido':$data->BANCO?></th>
                                     </tr>
                                 </tfoot>
                                 <?php endforeach; ?>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
    </div>
<br />
<div>
<?php foreach($detalle as $d){
        $hoy =$d->HOY;
}?>

    <form action="index.php" method="post">


    <label> Tiempo de entrega </label>
    <input type="text" name="fechaEntrega" class="date" value="<?php echo $hoy ?>" onchange="defineFecha(this.value)" id="fe">
    <label>Tipo de Pago: </label>
    <select name="tptes" required="required">
        <option value=""> Tipo de Pago</option>
        <option value="Tr"> Transferencia</option>
        <option value="Ch"> Cheque </option>
        <option value="Cr"> Credito </option>
        <option value="Efe"> Efectivo </option>
    </select>
    <label> Recoleccion / Entrega :</label>
    <select name="tipo" required="required">
        <option value = ""> Tipo Entrega </option>
        <option value="Rec"> Recoleccion </option>
        <option value="Ent"> Entrega </option>
    </select>
    <label> Confirmado con: </label>
    <input type="text" maxlength="80" size="100" name="conf" value="" placeholder="Nombre de la persona" required="required">
</div>
<br>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Productos de la Preorden de compra.
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-aplicapago">
                                    <thead>
                                        <tr>
                                            <th>Partida</th>
                                            <th>Clave</th>
                                            <th>Descripcion</th>
                                            <th>Cantidad</th>
                                            <th>Costo <br/> Unitario Bruto </th>
                                            <th>Costo <br> Total Bruto</th>
                                            <th>Descuento</th>
                                            <th>Valor IVA</th>
                                            <th>Costo Neto</th>
                                            <th>Unidad <br/> de Medida </th>
                                            <th>Clave <br/> Proveedor</th>
                                            <th>Identificador <br/> Unico Ventas</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 

                                            $subtotal = 0;
                                            $iva = 0;
                                            $total =0;
                                            $descuento=0;
                                            $i= 0;
                                        foreach ($detalle as $data):
                                            $ids=$data->ID;
                                            $subtotal += ($data->COSTO_TOTAL);
                                            $descuento += $data->DESCUENTO;
                                            $hoy = $data->HOY;
                                            $i++;
                                            ?>
                                        <tr title="<?php echo 'Cliente del Pedido: '.$data->CLIENTE.' de la cotizacion '.$data->COTIZACION.' con Fecha del '.$data->FECHASOL?>">

                                            <td align="center" >
                                                    <?php echo $data->PARTIDA;?> <br/> 
                                                    <a id="editar_<?php echo $i?>"
                                                     href="index.php?action=editaPreoc&idd=<?php echo $data->ID?>" 
                                                    target="popup" 
                                                    onclick="validador(); window.open(this.href, this.target, 'width=1800,height=1020'); return false"> 
                                                    Editar</a>        
                                            </td>
                                            <td><?php echo $data->ART?></td>
                                            <td><?php echo $data->DESCRIPCION?></td>
                                            <td><?php echo $data->CANTIDAD ;?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->COSTO,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->COSTO_TOTAL,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->DESCUENTO,2)?></td>
                                            <td align="right"><?php echo '$ '.number_format(($data->COSTO_TOTAL-$data->DESCUENTO) * .16 ,2);?></td>  
                                            <td align="right"><?php echo '$ '.number_format(($data->COSTO_TOTAL - $data->DESCUENTO)*1.16,2)?></td>      
                                            <td><?php echo $data->UM?></td>
                                            <td><?php echo $data->CVE_PROD?></td>
                                            <td><a href="index.php?action=historiaIDPREOC&id=<?php echo $data->IDPREOC?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;"> <?php echo $data->IDPREOC?></a></td>                                      
                                        </tr>
                                        <?php endforeach; ?>
                                        
                                 </tbody>
                                 <tfoot>
                                     <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><input type="hidden" name="partidas" value="<?php echo $i?>" id="totPar"></td>
                                            <td align="right">SubTotal</td>
                                            <td align="right"><?php echo '$ '.number_format($subtotal,2)?></td>
                                     </tr>
                                     <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td align="right">Descuento</td>
                                            <td align="right"><?php echo '$ '.number_format($descuento,2)?></td>
                                     </tr>
                                     <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td align="right">IVA</td>
                                            <td align="right"><?php echo '$ '.number_format(($subtotal-$descuento )*.16,2)?></td>
                                     </tr>
                                     <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td align="right">Total</td>
                                            <td align="right"><?php echo '$ '.number_format(($subtotal-$descuento)*1.16,2)?></td>
                                     </tr>
                                 </tfoot>
                                </table>
                            </div>
                      </div>
            </div>
        </div>
    </div>
<br />

<div>
    <button onclick="refrescar()"> Refrescar </button>
    
    <input type="hidden" name="doco" value="<?php echo $doco?>" >
    <input type="hidden" name="fechaEntrega" value="<?php echo $hoy?>" id="dfe">
    <button name="ConfirmaPreOrden" value="enviar" type="submit" id="val" > Crear Orden </button>
    
</div>

    </form>


<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script src="http://momentjs.com/downloads/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script type="text/javascript">

    function defineFecha(a){
        var f = new Date();
        mes = f.getMonth() + 1;
        var fn = a.split("-");
        f1 = new Date(f.getFullYear()+','+ mes +','+ f.getDate());
        f2 = new Date(fn[0] + ',' + fn[1]+',' + fn[2]);
        var hoy = (f.getFullYear()+'-'+ mes +'-'+ f.getDate());
        var fecha1= moment(f1);
        var fecha2= moment(f2);
        var b = fecha2.diff(fecha1,'days');
        document.getElementById('dfe').value=a;
        if(f2 < f1){
            alert('La fecha de entrega seleccionada, es menor a la fecha Actual');
        }else if(b > 60){
            alert('La fecha de entrega no puede ser mayor a 60 dias');
            document.getElementById('fe').value=hoy;
            document.getElementById('dfe').value=hoy;
        }else{
        document.getElementById('dfe').value=a;
        alert('Se Ha cambiado la fecha de entrega para el, ' + a);    
        }
    }

  $(document).ready(function() {
    $(".date").datepicker({dateFormat: 'yy-mm-dd'});
  } );

    function refrescar(){
        location.reload();
    }

    function validador(){
        document.getElementById('val').classList.add('hide');
        var b = document.getElementById('totPar').value;
        for(var i=1; i<=b; i++){
           document.getElementById('editar_'+i).classList.add('hide');
        }
    }
    
    function rechazar(ids, desc){
        //var recWindow = window.open("index.php?action=verSolProdVentas","Mensaje","width=200,height=100")
        //recWindow.document.write("<p> Esta es la ventana</p>")
        var id = ids;
        alert('Se rechazara la Solicitud de alta del Producto :' + desc );
        window.open('index.php?action=rechazarSol&ids='+ids,"","width=800,height=800")
    }

</script>
