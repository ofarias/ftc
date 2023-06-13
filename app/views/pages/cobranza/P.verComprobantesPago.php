<br/>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
        	<div class="panel-heading">
        	</div>
        	<div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" >
                    <thead>
                    	<font color="blue" size='5pxs'> Comprobante de pago de la factura <?php echo $docf?> </font>
                    	<br/>
                        <tr>
                            <th>ID / Folio x Banco</th>
                            <th>Banco</th>
                            <th>Fecha Edo de Cta</th>
                            <th>Monto </th>
                            <th>Aplicado</th>
                            <th>Saldo Actual</th>
                            <th>Comprobante</th>      
                       </tr>
                    </thead>                                   
                  <tbody>
                        <?php foreach ($comprobantes as $key):
                        ?>
                        <tr class="odd gradeX">
                            <td> <?php echo $key->ID. ' / ' .$key->FOLIO_X_BANCO?> </td>
                            <td><?php echo $key->BANCO?></td>
                            <td><?php echo $key->FECHA_RECEP;?> </td>
                            <td><?php echo '$ '.number_format($key->MONTO,2);?></td>
                            <td><?php echo '$ '.number_format($key->APLICACIONES,2);?> </td>
                            <td><?php echo '$ '.number_format($key->SALDO,2);?> </td>
                            <td><a href="/ComprobantesDePago/<?php echo substr($key->ARCHIVO,35,240)?>" download="/ComprobantesDePago/<?php echo substr($key->ARCHIVO,35,240)?>"><?php echo substr($key->ARCHIVO,35,240);?></a></td>
                        </tr>
                        </form>
                        <?php endforeach; ?>
                 </tbody>
                </table>
            </div>
		</div>
	</div>
</div>