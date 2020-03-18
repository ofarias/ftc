<div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                </h3>
            </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <center><a class="icoPre" title="ImpuestosAyuda" href="app/views/DocsAyuda/ManualImpuestos.pdf" target="_blank"><img src="app/views/images/cuestion.png" alt="ImpuestosAyuda" width="30" height="30"></a><h4>Cuentas Impuestos</h4></center>
                </div>
                <div class="panel-body">
                    <p>Configuracion</p>
                    <?php if($cnxcoi=='si'){?>
                        <center><a href="index.coi.php?action=cuentasImp" class="btn btn-default">Cuentas Impuestos</a>
                    <?php }else{?>
                        <center><a onclick="info()" class="btn btn-default">Cuentas Impuestos</a>
                    <?php }?>
                    </center>
                </div>
            </div>
        </div>    
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Trabajar XML</h4>
                </div>
                <div class="panel-body">
                    <center>Recibidos &nbsp;&nbsp;
                            <select id="per">
                            <?php foreach ($periodos as $key): ?>
                                <?php if ($key->T == 'r'){ ?>
                                    <option value="<?php echo $key->EJERCICIO?>"><?php echo $key->EJERCICIO?></option>
                                <?php }elseif($key->T != 'r' and $key->T != 'e'){ ?>
                                    <option value="">No se Encontro Infomacion.</option>
                                <?php }?>
                            <?php endforeach ?>
                            </select>                                
                            <input type="button" name="anio" id="per" onclick="ejecuta('R','per')" value="Ir" class="btn btn-success"></center>
                    <br/>
                    <center>Emitidos&nbsp;&nbsp;&nbsp;
                            <select id="peri">
                            <?php foreach ($periodos as $key): ?>
                                <?php if ($key->T == 'e'){ ?>
                                    <option value="<?php echo $key->EJERCICIO?>"><?php echo $key->EJERCICIO?></option>
                                <?php }elseif($key->T != 'r' and $key->T != 'e'){ ?>
                                    <option value="">No se Encontro Infomacion.</option>
                                <?php }?>
                            <?php endforeach ?>
                            </select>
                            <input type="button" name="anio" onclick="ejecuta('E','peri')" value="Ir" class="btn btn-success"></center>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Carga de XML</h4>
                </div>
                <div class="panel-body">
                    <p>Carga de XML</p>
                    <center><a href="index.php?action=facturaUploadFile&tipo=F" >
                        <img src="app/views/images/Xml/CargaXML.png" width="90" height="70">
                        <!--<img src="app/views/images/Xml/CargaXML.png" onMouseOver="this.src='app/views/images/Xml/XML_1.jpg'" onMouseOut="this.src='app/views/images/Xml/CargaXML.png'" style="cursor:pointer;" width="90" height="70">-->
                        </a></center>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Meta Datos</h4>
                </div>
                <div class="panel-body">
                    <center><b>Ver XML sin Procesar</b></center>
                    <center><a href="index.xml.php?action=cargaMetaDatos" >Carga de Metadatos</a></center>
                    <center><a href="index.xml.php?action=verMetaDatos" >Ver Metadatos</a></center>
                </div>
            </div>
        </div>
        <!--
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><i class="fa fa-list-alt">Carga de XML Cancelados</i></h4>
                </div>
                <div class="panel-body">
                    <p>Carga de XML</p>
                    <center><a href="index.php?action=facturaUploadFile&tipo=C" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/mcdo-design/smooth-leopard/64/Route-Folder-Blue-icon.png"></a></center>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><i class="fa fa-list-alt">Calcular Impuestos</i></h4>
                </div>
                <div class="panel-body">
                    <p>Calcular impuestos de XML</p>
                    <center><a href="index.php?action=calcularImpuestos" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/mcdo-design/smooth-leopard/64/Route-Folder-Blue-icon.png"></a></center>
                </div>
            </div>
        </div>
    -->
    <?php if($_SESSION['user']->USER_LOGIN == 'ofarias'){?>
         <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><i class="fa fa-list-alt">Descargas XML</i></h4>
                </div>
                <div class="panel-body">
                    <p>Descargas de XML</p>
                    <center><a href="index_xml.php?action=''" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/mcdo-design/smooth-leopard/64/Route-Folder-Blue-icon.png"></a></center>
                    <p><a href="index.xml.php?action=actTablas">Actualizar Tablas</a></p>
                    <p><a href="index.xml.php?action=calculaSaldo">Calcula Saldos Mizco</p>
                    <p><a class="btn-sm btn-success cargaEFOS" >Carga EFOs</a></p>
                </div>
            </div>
        </div>
    <?php }?>
        </div>
    </div>
<form action="index.php" method="post" id="migrar">
    <input type="hidden" name="docf" id="doc" value="<?php echo $docf?>">
    <input type="hidden" name="refacturarFecha" value="">
    <input type="hidden" name="opcion" value="3">
    <input type="hidden" name="nfecha" value="">
    <input type="hidden" name="obs" placeholder="Observaciones" value="X" id="obs" size="250">
</form>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">
        
        function ejecuta(tipo, anio){
            var anio = document.getElementById(anio).value
            window.open("index.php?action=mXMLSP&tipo="+tipo+"&anio="+anio, "self");
            return false;
        }

        function info(){
            $.alert('No se encontro la conexion a la BD de COI, favor de comunicarse con Soporte Tecnico al 55-5055-3392')
        }

        $(".cargaEFOS").click(function(){
            if(confirm('Carga Efos?')){
                $.ajax({
                    url:'index.xml.php',
                    type:'post',
                    dataType:'json',
                    data:{cargaEFOS:1}, 
                    success:function(data){
                        alert(data.mensaje)
                    },
                    error:function(){
                        alert('Algo no salio como se esperaba, favor de reportar a soporte tencino.')
                    }
                })
            }
        })
</script>