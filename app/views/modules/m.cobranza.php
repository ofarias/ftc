
<div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                </h3>
            </div>
              <p id="saldoReal"></p>
              <p id="totlinea"></p>
              <p id="saldoCliente"></p>
              <p id="cobranza"></p>
              <p id="logistica"></p>
              <p><a  href="index.cobranza.php?action=verSaldosPagos&t=a" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;">Pendiente por Aplicar en Bancos:<?php echo '$ '.number_format($abonos,2 )?>&nbsp;&nbsp;&nbsp;&nbsp;</a><button class="btn btn-info" onclick="actAcr()" type="submit">Actualizar</button></p>
              <p><a href="index.cobranza.php?action=verSaldosPagos&t=i" onclick="window.open(this.href, this.target, 'width=1200, height=820'); return false;">Pendiente de Identificar en Bancos: <?php echo '$ '.number_format($pendientes,2)?></a></p>
              <p id="liberado"></p>
              <p id="revision"></p>
              <p id="lineaComprometida"></p>
              <p id= "remisiones"></p>
            <?php foreach($info as $data):?>
               <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h5><?php echo substr($data->NOMBRE,0,20)?> </h4>
                        <h6><?php echo $data->CLAVE?></h3>
                        <p>Plazo: <?php echo $data->PLAZO?></p>
                    </div>
                    <div class="panel-body">
                        <p>Linea Otorgada <font color="blue"><?php echo '$ '.number_format($data->LINEACRED_CALCULADA,2)?></font></p>
                        <p>Pendiente aplicar: <font color="green"><?php echo '$ '.number_format($data->ACREEDOR,2) ?></font></p>
                        <p>Comprometido: <font color="#cc9900"><?php echo '$ '.number_format($data->LIBERADO + $data->REVISION + $data->COBRANZA + $data->LOGISTICA ,2)?></font></p>
                        <p>Disponible <font color="green"><?php echo '$ '.number_format($data->LINEACRED_CALCULADA - ($data->LIBERADO + $data->REVISION + $data->COBRANZA + $data->LOGISTICA + $data->REMISIONES),2)?></font></p>
                        <p>Saldo Cliente:<font color="red"> <?php echo '$ '.number_format($data->REVISION + $data->COBRANZA + $data->LOGISTICA ,2)?></font></p>
                        <p>Liberado: <font color=""><?php echo '$ '.number_format($data->LIBERADO,2)?></font></p>
                        <p>Logistica: <font color=""><?php echo '$ '.number_format($data->LOGISTICA,2)?></font></p>
                        <p>Remisiones: <font color=""><?php echo '$ '.number_format($data->REMISIONES,2)?></font></p>
                        <p>Revision: <font color=""><?php echo '$ '.number_format($data->REVISION,2)?></font></p>
                        <p>Cobranza: <font color=""><?php echo '$ '.number_format($data->COBRANZA,2)?></font></p>
                        <center><a href="index.cobranza.php?action=CarteraxCliente&cve_maestro=<?php echo $data->CLAVE;?>&tipo=t&maestro=<?php echo $data->ID?>" target="popup" class="btn btn-warning" onclick="window.open(this.href, this.target, 'width=1200,height=1320'); return false;">Detalles Clientes:<?php echo $data->SUCURSALES?></a></center>
                        <?php if($data->ID < 353){?>
                        <!--<center><a class="btn btn-danger" href="index.cobranza.php?action=migraMaestro&cvemo=<?php echo $data->CLAVE?>" target="popup" onclick="window.open(this.href, this.target, 'width=800,height=320'); return false;">Migrar</a></center>-->
                        <?php }?>
                        <input type="hidden" name="valores" class="factura" 
                            cobranza="<?php echo $data->COBRANZA?>" 
                            revision="<?php echo $data->REVISION?>" 
                            logistica="<?php echo (empty($data->LOGISTICA))? 0:$data->LOGISTICA ?>" 
                            liberado="<?php echo (empty($data->LIBERADO))? 0:$data->LIBERADO?>" 
                            saldoCliente="<?php echo ($data->REVISION + $data->COBRANZA + $data->LOGISTICA)?>" 
                            lineaComprometida="<?php echo ($data->LIBERADO + $data->REVISION + $data->COBRANZA + $data->LOGISTICA)?>"
                            remisiones="<?php echo (empty($data->REMISIONES))? 0:$data->REMISIONES ?>"
                            linea="<?php echo (empty($data->LINEACRED_CALCULADA))? 0:$data->LINEACRED_CALCULADA ?>"
                            pendientes="<?php echo (empty($abonos)? 0:$abonos)?>"
                        >
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
            var cobranza  = 0;
            var logistica = 0;
            var liberado = 0;
            var revision  = 0;
            var saldoCliente = 0;
            var lineaComprometida = 0;
            var remisiones = 0;
            var lineas = 0;
            var abonos = 0;

            $("input.factura").each(function() {
                var indcobranza  =  parseFloat($(this).attr('cobranza'),2);
                var indlogistica =  parseFloat($(this).attr('logistica'),2);
                var indliberado  =  parseFloat($(this).attr('liberado'),2); 
                var indrevision  =  parseFloat($(this).attr('revision'),2);
                var indsaldoCliente =  parseFloat($(this).attr('saldoCliente'),2);
                var indlineaComprometida =  parseFloat($(this).attr('lineaComprometida'),2);
                var remision = parseFloat($(this).attr('remisiones'),2);
                var linea = parseFloat($(this).attr('linea'),2); 
                var abono = parseFloat($(this).attr('pendientes'),2);
                cobranza  = cobranza + indcobranza; 
                logistica = logistica +indlogistica; 
                liberado =  liberado + indliberado;  
                revision  =  revision + indrevision; 
                saldoCliente =  saldoCliente + indsaldoCliente; 
                lineaComprometida = lineaComprometida + indlineaComprometida;
                remisiones = remisiones + remision;
                lineas = lineas + linea;
                abonos = abono;
            });

            var saldor = saldoCliente - abonos;

            var totalLineas = String(lineas).split(".");
            var totalCobranza = String(cobranza).split(".");
            var totalLogistica = String(logistica).split(".");
            var totalliberado = String(liberado).split(".");
            var totalrevision = String(revision).split(".");
            var totalsaldoCliente = String(saldoCliente).split(".");
            var totallineaComprometida= String(lineaComprometida).split(".");
            var totalremisiones = String(remisiones).split(".");
            var saldoReal = String(saldor).split(".");

            totalLineas = formato('lin', totalLineas);
            totalCobranza = formato('cob',totalCobranza);
            totalLogistica = formato('log',totalLogistica);
            totalliberado=formato('lib',totalliberado);
            totalrevision=formato('rev',totalrevision);
            totalsaldoCliente=formato('sal',totalsaldoCliente);
            totallineaComprometida= formato('linea',totallineaComprometida);
            totalremisiones = formato('rem',totalremisiones);
            saldoReal = formato('sal',saldoReal);

            document.getElementById('cobranza').innerHTML="Total Cobranza: <font size='4pxs' color='red'>"+totalCobranza+"</font>";
            document.getElementById('logistica').innerHTML=" Total Logistica: <font size='4pxs' color='green'>"+totalLogistica+"</font>";
            document.getElementById('liberado').innerHTML=" Total Liberado: <font size='4pxs' color='green'>"+totalliberado+"</font>";
            document.getElementById('revision').innerHTML=" Total Revision: <font size='4pxs' color='green'>"+totalrevision+"</font>";
            document.getElementById('saldoCliente').innerHTML=" Total saldoCliente:       <font size='4pxs' color='green'>"+totalsaldoCliente+"</font>";
            document.getElementById('lineaComprometida').innerHTML=" Total Linea Comprometida: <font size='4pxs' color='green'>"+totallineaComprometida+"</font>";
            document.getElementById('remisiones').innerHTML="Total remisiones: " + totalremisiones; 
            document.getElementById('totlinea').innerHTML="Total Lineas de Credito: " + totalLineas;
            document.getElementById('saldoReal').innerHTML="<font size='5pxs' color='blue'>Saldo Real de Clientes: " + saldoReal+"</font>";
        });


        function formato(tipo, numero){
            var long = numero[0].length;
            //alert('Tipo: '+ tipo + 'Monto: '  + numero);
            if(numero[0].length > 6){
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
            }else if(numero[0].length > 3){
                var tipo = 'Miles';
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
                var texto = '$  '+ millones +',' + miles + '.00';
            }else if(numero[0].length > 0){
                    if (long == 3){
                    var mill = 3;
                }else if(long == 2){
                    var mill = 2;
                }else if(long == 1){
                    var mill = 1
                }
                var millones = numero[0].substring(0,mill);
                var miles = numero[0].substring(mill, mill + 3 );
                var unidades = numero[0].substring(mill + 3, mill +6);
                var texto = '$  '+ millones + '.00';
            }
            
            return texto;

        }

        function actAcr(){
            if(confirm('Este proceso tardara de 1 a 2 minutos')){
                $.ajax({
                    url:'index.cobranza.php',
                    type:'post',
                    dataType:'json',
                    data:{actAcr:1},
                    success:function(data){
                        alert(data.mensaje)
                        location.reload(true)
                    },
                    error:function(){
                        alert('Ocurrio un error favor de intentar mas tarde...')
                    }
                })
            }else{
                return false;
            }
        }


</script>
