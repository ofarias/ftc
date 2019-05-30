<?php
$meses = array(
	'1'=>'Enero',
	'2'=>'Febrero',
	'3'=>'Marzo',
	'4'=>'Abril',
	'5'=>'Mayo',
	'6'=>'Junio',
	'7'=>'Julio',
	'8'=>'Agosto',
	'9'=>'Septiembre',
	'10'=>'Octubre',
	'11'=>'Noviembre',
	'12'=>'Diciembre'
);
$dias = range(1, 31);
$anios = range(date('Y')-1, date('Y'));
?>
<form class="form-inline" method="POST" id="recibidos-form">
  <input type="hidden" name="accion" value="buscar-recibidos" />
  <input type="hidden" name="sesion" class="sesion-ipt" />
  <div class="form-group">
    <label for="dia">Día</label>
    <select class="form-control" id="dia" name="dia">
    <?php
    echo '<option value="0">Todos</option>';
    foreach ($dias as $value) {
    	echo '<option value="'.$value.'">'.$value.'</option>';
    } ?>
    </select>
  </div>
  <div class="form-group">
    <label for="mes">Mes</label>
    <select class="form-control" id="mes" name="mes">
    <?php foreach ($meses as $key => $value) {
    	echo '<option value="'.$key.'">'.$value.'</option>';
    } ?>
    </select>
  </div>
  <div class="form-group">
    <label for="anio">Año</label>
    <select class="form-control" id="anio" name="anio">
    <?php foreach ($anios as $value) {
    	echo '<option value="'.$value.'">'.$value.'</option>';
    } ?>
    </select>
  </div>
  <button type="submit" class="btn btn-primary">Buscar</button>
</form>