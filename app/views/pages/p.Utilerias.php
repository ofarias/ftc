<br/>

<label>Modulo de Utilerias.</label>
<br/>
<label> Todos los procesos de este modulo estan registrados para su conciliacion con los gerentes y el director, cualquier uso mal intencionado sera sancionado.</label> 
<br/>
<label> Usuario registrado es: <?php echo $usuario;?></label>
<br/>
<label> Fecha y hora del proceso es: <?php echo date("Y-m-d H:i:s");?></label>
<br/>
<br/>
<form action="index.php" method="post">
<input type="hidden" name="opcion" value = "1" >
<input type="text" name="docd" placeholder="Nota de Credito", required="required" >
<button name="utilerias" type="submit" value="enviar" >Libera Nota de credito</button>
<br/>
<br/>
</form>
<form action="index.php" method="post">
<input type ="text" name="docp" placeholder="Pedido a Urgencia" required="required">
<input type="hidden" name="opcion" value="2">
<button name="utilerias" type="submit" value="enviar"> Colocar a  Urgencia</button>
</form>
<br/>
<br/>
<form action="index.php" method="post">
<input type ="text" name="docp" placeholder="Pedido a Reenrutar" required="required">
<label> con la factura  </label>
<input type="text" name="docf" placeholder="Factura a Reenrutar" required="required">
<input type="hidden" name="opcion" value="3">
<button name="utilerias" type="submit" value="enviar"> Reenrutar Pedido</button>
</form>
<br>
<br/>
<form action="index.php" method="post">
<input type ="text" name="docp" placeholder="Pedido" required="required">
<label> y la clave del articulo  </label>
<input type="text" name="docf" placeholder="clave del articulo" required="required">
<input type="hidden" name="opcion" value="4">
<button name="utilerias" type="submit" value="enviar"> Revisar Descripcion</button>
</form>

<?php if($resultado and $resultado2){
?>
    <?php  foreach ($resultado as $res1):?>
        <label>Este es el pedido <?php echo $res1->COTIZA;?>  y la descripcion Actual: <?php echo $res1->NOMPROD;?></label>
    <?php endforeach ?>
    <?php foreach ($resultado2 as $key ): ?>
        <label> Este es la nueva descripcion: <?php echo $key->CAMPLIB7?> </label>
    <?php endforeach ?>

    <button> Aceptar</button>
<?php }?>
<br/>
<div>
<form action="index.php" method="post">
<input type ="text" name="docp" placeholder="Pedido" required="required">
<input type="text" name="docd" placeholder="Nota de Credito" required="required">
<input type="hidden" name="opcion" value="17">
<button name="utilerias" type="submit" value="enviar"> Liberar Pedido para Facturacion</button>
</form>
</div>



<form action="index.php" method="post">
<label>Liberacion de Facturas:</label>
<input type="text" name="docf" placeholder="Factura a liberar" required="required">
<input type="hidden" name="opcion" value="15" >
<button name="utilerias" type="submit" value="enviar" >Liberar</button>
<br/>
<label>Cancela las aplicaciones que tenga la factura y regresa el monto de la factura a la factura y al(os) pago(s). NO APLICA PARA NOTAS DE CREDITO </label>
</form>

<br/>

<form action="index.php" method="post">
<label>Ajustar Saldo por Cancelacion de NC:</label>
<input type="text" name="docf" placeholder="Nota de Credito Cancelada" required="required">
<input type="hidden" name="opcion" value="16" >
<button name="utilerias" type="submit" value="enviar"> Aplicar Cancelacion de Nota de Credito </button>
<br/>
<label>Elimina el importe de la NC como pago de la factura asociada y desasocia la NC cancelada de la Factura.</label>
</form>
<br/>
<br/>
<form action="index.php" method="POST">
	<input type="hidden" name="opcion" value="14">
	<button name="utilerias" type="submit" value="enviar"> Actualiza Pagos </button>
</form>


<br/>
<form action="index.php" method="post">
	<label>Actualizar Saldos Maestros</label>
	<select name="maestro" required="required">
			
		<option value= "">Seleccione Maestro</option>
		<option value="todos">Todos</option>
		<?php foreach ($maestros as $key): ?>
			<option value="<?php echo $key->CLAVE?>"><?php echo $key->NOMBRE?></option>	
		<?php endforeach ?>

	</select>
	<input type="hidden"  name="opcion" value="13">
	<button name="utilerias" type="submit" value="enviar" > Actualiza Maestros</button>
</form>


<br/>
<form action="index.php" method="post">
<label> Contabilizar Compras  </label>
<input type="hidden" name="opcion" value="5">
<button name="utilerias" type="submit" value="enviar"> Contabilizar Compras</button>
</form>

<br/>
<form action="index.php" method="post">
<label> Contabilizar Aplicaciones  </label>
<input type="hidden" name="opcion" value="100">
<button name="utilerias" type="submit" value="enviar"> Contabilizar Aplicaciones</button>
</form>

<br/>
<form action="index.php" method="post">
<label> Contabilizar Carga Pagos  </label>
<input type="hidden" name="opcion" value="7">
<button name="utilerias" type="submit" value="enviar"> Contabilizar Carga Pagos</button>
</form>

<br/>
<form action="index.php" method="post">
<label> Contabilizar Ventas </label>
<input type="hidden" name="opcion" value="8">
<button name="utilerias" type="submit" value="enviar"> Contabilizar Ventas 2016</button>
</form>

<br/>
<form action="index.php" method="post">
<label> Crea Cuentas Cliente </label>
<input type="hidden" name="opcion" value="9">
<button name="utilerias" type="submit" value="enviar"> Crea Cuentas cliente en COI</button>
</form>

<br/>
<form action="index.php" method="post">
<label> Crea Cuentas Proveedores </label>
<input type="hidden" name="opcion" value="10">
<button name="utilerias" type="submit" value="enviar"> Crea Cuentas Proveedores</button>
</form>

<br/>
<form action="index.php" method="post">
<label> Contabilizar Notas de Credito </label>
<input type="hidden" name="opcion" value="11">
<button name="utilerias" type="submit" value="enviar"> Contabilizar Notas de Credito</button>
</form>


<br/>
<form action="index.php" method="post">
<label> Aplicaciones a Facturas </label>
<input type="hidden" name="opcion" value="12">

<label>Fecha Inicio formato aaaa-mm-dd </label><input type="text" name="fechaIni" placeholder="Fecha Inicio" >
<label>Fecha Final formato aaaa-mm-dd </label><input type="text" name="fechaFin" placeholder="Fecha Inicio" >

<button name="utilerias" type="submit" value="enviar"> Aplicaciones a Facturas</button>
</form>


<div>
<br/>
<form action="index.php" method="post">
<label> Analisis de IDs Pedidos </label>
<input type="hidden" name="opcion" value="20">
<label>Fecha Inicio formato aaaa-mm-dd </label><input type="text" name="fechaIni" placeholder="Fecha Inicio" >
<label>Fecha Final formato aaaa-mm-dd </label><input type="text" name="fechaFin" placeholder="Fecha Inicio" >
<label> Introducir el ID del Pedido </label><input type="text" name="idpreoc" placeholder="Id del Articulo Pedido">
<button name="utilerias" type="submit" value="enviar"> Analizar ID</button>
</form>
</div>

<div>
<form action="index.php" method="post">
<label> Timbrar Doc </label>
<input type="hidden" name="opcion" value="21">
<label>Colocar el numero de Factura </label><input type="text" name="docf" placeholder="Factura" >
<button name="utilerias" type="submit" value="enviar"> Facturar</button>
</form>
	
</div>