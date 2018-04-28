<br>
<div class="form-horizontal">
<div class="panel panel-default">
	<div class="panel panel-heading">
		<h4>Busqueda</h4>
	</div>
<div class="panel panel-body">
		
		<form action="index.php" method="post"> 
			<div class ="form-group">
				<label for="motivo" class="col-lg-1 control-label">Buscar: </label>
					<div class="col-lg-5">
						<input type="text" class="form-control" name="buscar" placeholder="Busqueda por operador, unidad o documento " />	
					</div>
			</div>
  			<div class="form-group">
    			<div class="col-sm-offset-1 col-sm-10">
      				<button name="buscaoperadores" type="input" value="enviar" class="btn btn-info">Buscar <i class="fa fa-search"></i></button>
   				 </div>
   			</div>
		</form>
	</div>
</div>
</div>
<div class="<?php (empty($operador)) ? hide : nohide;?>">
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           <h4>Movimientos </h4>
                        </div>
                     
                        <div class="panel-body">
                          <h4> Ultimo operador y unidad asignados:</h4>
                        	<h5> <?php foreach($operador as $dato){
            							echo "  Operador: ". $dato[1] ."<br>";
    									     echo "  Unidad: ". $dato[2];}?></h5>
    							     </div> 


                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios1">
                                    <thead>
                                        	<th>Documento</th>
                                          <th>Proveedor</th>
                                        	<th>Tipo</th>
                                        	<th>Fecha del documento</th>
                                        	<th>Fecha de asignacion</th>
                                        	<th>Fecha solicitada</th>
                                        	<th>Forma de pago</th>
                                        	<th>Hora Inicio</th>
                                        	<th>Hora Fin</th>
                                        	<th>Resultado</th>
                                        	<th>¿Es real?</th>
                                    </thead>                                   
                                  <?php foreach($exec as $op): 
                                  		switch ($op->TIPO){
                                  			case 'o':
                                  				$tipodoc = 'Orden de compra';
                                  				break;
											case 'f':
												$tipodoc = 'Factura';
												break;
                                  		}
								  ;?>
                                  <tbody>
                                  	<tr>
                                    	<td><?php echo $op->DOCUMENTO;?></td>
                                      <td><?php echo $op->PROVEEDOR;?></td>
                                    	<td><?php echo $tipodoc;?></td>
                                    	<td><?php echo $op->FECHADOC;?></td>
                                    	<td><?php echo $op->FECHAASIG;?></td>
                                    	<td><?php echo $op->CITA;?></td>
                                    	<td><?php echo $op->FORMAPAGO;?></td>
                                    	<td><?php echo $op->HORAINI;?></td>
                                    	<td><?php echo $op->HORAFIN;?></td>
                                    	<td><?php echo $op->RESULTADO;?></td>
                                    	<td><?php echo $op->ESTVSREAL;?></td>
                                    </tr>
                                 </tbody>
                                 <?php endforeach; ?>
                                </table>
                                <div class="row">
                                <div class="col-lg-10"></div>
                                <div class="col-lg-2">
                                    <button onclick="window.print()" >Imprimir <img src="http://icons.iconarchive.com/icons/iconshow/hardware/64/Printer-icon.png"></button>
                                </div>
                                </div>
                                
                            </div>
                            <!-- /.table-responsive -->
			          </div>
			</div>
		</div>
</div>
</div>


