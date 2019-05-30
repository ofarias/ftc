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
<form class="form-inline" method="POST" id="emitidos-form">
  <input type="hidden" name="accion" value="buscar-emitidos" />
  <input type="hidden" name="sesion" class="sesion-ipt" />
  <div class="form-group">
    <label for="dia-e1">Fecha Inicial</label>
    <select class="form-control" id="dia-e1" name="dia_i">
    <?php
    foreach ($dias as $value) {
      echo '<option value="'.$value.'">'.$value.'</option>';
    } ?>
    </select>
  </div>
  <div class="form-group">
    <label class="sr-only" for="mes-e1">Mes</label>
    <select class="form-control" id="mes-e1" name="mes_i">
    <?php foreach ($meses as $key => $value) {
      echo '<option value="'.$key.'">'.$value.'</option>';
    } ?>
    </select>
  </div>
  <div class="form-group">
    <label class="sr-only" for="anio-e">anio</label>
    <select class="form-control" id="anio-e1" name="anio_i">
    <?php foreach ($anios as $value) {
      echo '<option value="'.$value.'">'.$value.'</option>';
    } ?>
    </select>
  </div>
  <div class="form-group">
    <label for="dia-e2">Fecha Final</label>
    <select class="form-control" id="dia-e2" name="dia_f">
    <?php
    foreach ($dias as $value) {
    	echo '<option value="'.$value.'">'.$value.'</option>';
    } ?>
    </select>
  </div>
  <div class="form-group">
    <label class="sr-only" for="mes-e2">Mes</label>
    <select class="form-control" id="mes-e2" name="mes_f">
    <?php foreach ($meses as $key => $value) {
    	echo '<option value="'.$key.'">'.$value.'</option>';
    } ?>
    </select>
  </div>
  <div class="form-group">
    <label class="sr-only" for="anio-e2">anio</label>
    <select class="form-control" id="anio-e2" name="anio_f">
    <?php foreach ($anios as $value) {
    	echo '<option value="'.$value.'">'.$value.'</option>';
    } ?>
    </select>
  </div>
  <button type="submit" class="btn btn-primary">Buscar</button>
</form>