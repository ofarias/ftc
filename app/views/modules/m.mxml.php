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
  <?php if($_SESSION['empresa']['noi'] == 1){?>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><i class="fa fa-list-alt">NOMINAS XML</i></h4>
                </div>
                <div class="panel-body">

                    <p>Ejercicio: 
                        <select id=anio >
                            <?php foreach($nomina as $n):?>
                            <option value="<?php echo $n->ANIO?>"><?php echo $n->ANIO?></option>
                        <?php endforeach;?>
                        </select>
                    </p>
                    <p>Periodo (Mes)
                        <select id=mes>
                            <option value="<?php echo 0?>">Todos</option>
                            <?php foreach ($meses as $m): ?>
                                <option value="<?php echo $m->NUMERO?>"><?php echo $m->NOMBRE?></option>
                            <?php endforeach ?>
                        </select></p>
                    <center>
                        <a class="btn btn-primary verNomina" <?php echo (count($nomina)>0)? '':'disabled'?> tipo="v"> Ver Nominas</a>
                        <br/>
                        <a class="btn btn-primary verNomina" <?php echo (count($nomina)>0)? '':'disabled'?> tipo="r"> Reporte de Nominas</a>
                    </center>
                </div>
            </div>
        </div>
    <?php }?>
    <?php if($_SESSION['empresa']['impuestos'] ==1){?>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Impuestos</h4>
                </div>
                <div class="panel-body">
                    <p>Impuestos y Declaraciones</p>
                    <p>Ejercicio: <select id="impAnio">
                                    <option value="2020">2020</option>
                                    <option value="2019">2019</option>
                                </select></p>
                    <p>Periodo (Mes)
                        <select id=impMes>
                            <option value="<?php echo 0?>">Todos</option>
                            <?php foreach ($meses as $m): ?>
                                <option value="<?php echo $m->NUMERO?>"><?php echo $m->NOMBRE?></option>
                            <?php endforeach ?>
                        </select></p>
                    <p><center><a class="btn-sm btn-primary ci"  >Cualculo ISR</a></center></p>
                    <p><center><a class="btn-sm btn-primary civa">Calculo IVA</a></center></p>
                    <p><center><a class="btn-sm btn-primary diot">Calculo DIOT</a></center></p>
                    <p><center><a class="btn-sm btn-primary dec" >Ver Declaraciones</a></center></p>
                </div>
            </div>
        </div>
    <?php }?>
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
                    <p><a class="btn-sm btn-primary sincronizar">Sincronizar Datos</a></p>
                    <p><a href="index.php?action=millon" class="btn-sm btn-primary unmillon">Un Millon de Nombres</a></p>
                    <!-- <p><input type="file" webkitdirectory mozdirectory msdirectory odirectory directory  id="folder"></p>-->
                    <p><input type="button" class="dir" value="acomodar" t="1"></p>
                    <p><input type="button" class="dir" value="analizarXmls" t="2"></p>
                    <p><input type="button" class="dir" value="Nombra Imagenes" t="3"></p>
                    <p><input type="button" class="dir" value="Revisa Imagenes" t="4"></p>

                </div>
            </div>
        </div>
    <?php }?>
    <?php if($_SESSION['empresa']['retenciones'] == 'S'){ ?>
        <div class="col-md-4" title="Genera reporte en execel de las retenciones por un rango de fecha">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><i class="fa fa-list-alt">Reporte Retenciones</i></h4>
                </div>
                <div class="panel-body">
                    <p><label>Seleccione la fecha</label></p>
                    <label>Inicial:</label> &nbsp;<input type="date" name="fi" id="rFi"><br/>
                    <label>Final: </label> &nbsp;&nbsp;&nbsp;<input type="date" name="ff" id="rFf"> <input type="button" name="exe" class="btn-small btn-primary ret" value="Ejecutar">
                </div>
            </div>
        </div>
    <?php } ?>
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


        $(".dir").click(function(){
            var opc = $(this).attr('t')
            $.ajax({
                url:'index.xml.php',
                type:'get',
                dataType:'json',
                data:{action:'acomoda', opc},
                success:function(data){
                    alert("Se acomodaron: " + data.archivos)
                },
                error:function(){
                }
            })
        })


        $(".ret").click(function(){
            var fi = document.getElementById('rFi').value
            var ff = document.getElementById('rFf').value
            $.ajax({
                url:'index.xml.php',
                type:'post',
                dataType:'json',
                data:{repRet:1, fi, ff},
                success:function(data){
                    var archivo = data.archivo
                    alert("Se genero el archivo" +  archivo)
                    window.open(data.htmlPath, "download")
                },
                error:function(){

                }

            })
        })

        $(".sincronizar").click(function(){
            //$.confirm("desea continuar?")
            $.ajax({
                url:'index.mobile.php',
                type:'post',
                dataType:'json',
                data:{sync:1},
                success:function(data){
                    alert('Se ha sincronizado correctamente')
                },
                error:function(){
                    alert('Se ha producido un error')
                }
            })
        })

        $(".ci").click(function(){
            var mes = document.getElementById('impMes').value
            var anio = document.getElementById('impAnio').value
            window.open("index.xml.php?action=calImp&mes="+mes+"&anio="+anio, "popup", 'width=1200,height=600');
            return false;
        })

        $(".civa").click(function(){
            var mes = document.getElementById('impMes').value
            var anio = document.getElementById('impAnio').value
            window.open("index.xml.php?action=calImpIva&mes="+mes+"&anio="+anio, "popup", 'width=1200, height=600')
        })

        $(".diot").click(function(){
            var mes = document.getElementById('impMes').value
            var anio = document.getElementById('impAnio').value
            window.open("index.xml.php?action=calDiot&mes="+mes+"&anio="+anio, "popup", 'width=1200, height=600')
        })

        $(".dec").click(function(){
            alert('Ver Declaraciones')
        })        

        $(".verNomina").click(function(){
            var a = document.getElementById("anio").value
            var m = document.getElementById("mes").value
            var t = $(this).attr("tipo")
            if(t == 'v'){
                window.open("index.xml.php?action=nomXML&anio="+a+"&mes="+m+"&tipo="+t,  "_self")
            }else{

                    $.confirm({
                        content: function () {
                            var self = this;
                            return $.ajax({
                                        url:'index.xml.php', 
                                        type:'get', 
                                        dataType:'json', 
                                        data:{action:'nomXML', anio:a, mes:m, tipo:t}
                                }).done(function (data) {
                                        self.setContent('Archivo generado' );
                                        self.setContentAppend('<br>' + data.archivo);
                                        self.setTitle('Archivo de Nominas');
                                        descargarArchivo(data.ruta, data.archivo);
                                }).fail(function(){
                                        self.setContent('Something went wrong.');
                                });
                        }
                    });
                


            }
        })

        function descargarArchivo(url, archivo) {
          var xhr = new XMLHttpRequest();
          xhr.open('GET', url, true);
          xhr.responseType = 'blob';
          xhr.onload = function() {
            if (xhr.status === 200) {
              var blob = xhr.response;
              var link = document.createElement('a');
              link.href = window.URL.createObjectURL(blob);
              link.download = archivo;
              link.style.display = 'none';
              document.body.appendChild(link);
              link.click();
              document.body.removeChild(link);
            }
          };
          xhr.send();
        }

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