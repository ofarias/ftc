<p>Usuario registrado: <?php echo $usuario?></p>
<p>Cartera: <?php echo $tipoUsuario?></p>


<p id="Total"></p>
<p id="comp"></p>
<p id="ej"></p>
<div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                </h3>
            </div>
            <?php foreach($datos as $data):
                $maestro = $data['maestro'];
                ?>
                    <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> <?php echo '('.$data['maestro'].')'.$data['nombre']?></h4>
                    </div>
                    <div class="panel-body">
                        <p>Documentos a 7 dias: <font color="red"><?php echo $data['semanal'].'  --->$ '.number_format($data['montoSemanal'])?></font></p>
                        <p>Documentos de 8 a 28 dias: <font color = "blue"> <?php echo $data['documentos'].'  --->$ '.number_format($data['mensual'],2)?></font></p>
                        <p>Documentos Extra Judicial: <font color="blue"><?php echo $data['documentos'].'  --->$ '.number_format($data['ej'])?></font></p>
                        <center><a href="index.cobranza.php?action=CarteraxCliente&cve_maestro=<?php echo $maestro?>" class="btn btn-default" target="_blank"><img src="app/views/images/pesos.png"></a></center>
                        <input type="hidden" name="datos" class="montos" semanal="<?php echo (empty($data['montoSemanal']))? 0:$data['montoSemanal']?>"  total="<?php echo (empty($data['mensual']))? 0:$data['mensual']?>" ej="<?php echo (empty($data['ej'])? 0:$data['ej'])?>">
                    </div>
                </div>
            </div> 
            <?php endforeach;?>
        </div>
</div>


<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">
    
        $(document).ready(function() {
            var semanal = 0;
            var total = 0;      
            var totalej= 0;     
            $("input.montos").each(function() {
                    var sem = parseFloat($(this).attr("semanal"),2);
                    semanal = semanal + sem;
                    var monTotal = parseFloat($(this).attr("total"),2);
                    total = total + monTotal;  
                    var ej = ej = parseFloat($(this).attr("ej"),2);
                    totalej = totalej + ej;
            });
            var numero = String(semanal).split(".");
            var numero2 = String(total).split(".");
            var numero3 = String(totalej).split(".");
            var texto = format(numero);
            var texto2 = format(numero2);
            var texto3 = format(numero3);
            document.getElementById('Total').innerHTML="Por cobrar a 7 dias: <font size='4pxs' color='red'>"+texto+"</font>";
            document.getElementById('comp').innerHTML=" Por Cobrar de 8 a 28 dias: <font size='4pxs' color='blue'>"+texto2+"</font>";
            document.getElementById('ej').innerHTML=" Por Cobrar Extra Judicial: <font size='4pxs' color='purple'>"+texto3+"</font>";
        });

        function format(numero){
            var long  = numero[0].length;
            if(long > 6){
                var tipo = 'Millones';
                if (long == 9){
                    var mill = 3;
                }else if(long == 8){
                    var mill = 2;
                }else if(long == 7){
                    var mill = 1
                }
                var millones = numero[0].substring(0,mill);
                var miles = numero[0].substring(mill, mill + 3 );
                var unidades = numero[0].substring(mill + 3, mill +6);
                var texto = '$  '+ millones + ',' + miles + ','+ unidades + '.00';
            }else if(long > 3){
                if (long == 6){
                    var mill = 3;
                }else if(long == 5){
                    var mill = 2;
                }else if(long == 4){
                    var mill = 1
                }
                var millones = numero[0].substring(0,mill);
                var miles = numero[0].substring(mill, mill + 3 );
                var unidades = numero[0].substring(mill + 3, mill +6);
                var texto = '$  '+ millones + ',' + miles + '.00';
            }else if(long > 0){
                var tipo = 'Ciento';
                var texto = 'No se ha seleccionado ningun valor';
            }
            return (texto);
        } 

</script>