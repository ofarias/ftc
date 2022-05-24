
<br/>
<br/>
<div>
<form action="index.php" method="post">
<input type="hidden" name="descripcion" value="">
 <label>Nuevo Producto</label>
  <a href="index.php?action=altaProductoFTC&marca=<?php echo $marca?>&prov1=<?php echo $prov1?>&desc1=<?php echo $desc1?>&desc2=<?php echo $desc2?>&categoria=<?php echo $categoria?>&generico=<?php echo $generico?>&unidadmedida=<?php echo $unidadmedida?>" class="btn btn-success">Nuevo</a> &nbsp;&nbsp; &nbsp;&nbsp;  <input type="text" name='descripcion' id='descripcion' value='' class="text" maxlength="40" style="width: 50%" />  <button  name="buscarArticuloCatalogo" class="btn btn-info" >Buscar Articulo</button>
</form>
    <div class="col-lg-12">
        <div>
            <div class="col-lg-6">
                <label>Carga Desde Excel</label>&nbsp;&nbsp;<a href="..//layout//LayOut Productos.xlsx", download >Layout</a>
                <form action="index.v.php" method="post" enctype="multipart/form-data">
                    
                    <input type="file" name="files[]" multiple="" onchange="makeFileList()" id="filesToUpload" accept=".xls, .xlsx, .csv, .txt" >

                    <input type="hidden" name="cargaProd" value="cargaProd">
                    <input type="hidden" name="files2upload" value="" >  
                    <input type="submit" value="Carga Productos" class="btn-sm btn-success">
                </form>
                <ul id="fileList">
                    <li>No hay Archivos Seleccionados</li>
                </ul>
            </div>
            <div class="col-lg-6" >
                <label>Cargar Imagenes</label>
                <form action="index.v.php" method="post" enctype="multipart/form-data">
                    <input type="file" name="files[]" multiple="" onchange="makeFileList()" id="filesToUpload" accept=".jpg, .gif, .png, .webp" >
                    <input type="hidden" name="cargaImg" value="cargaImg">
                    <input type="hidden" name="files2upload" value="" >  
                    <input type="submit" value="Carga Imagenes" class="btn-sm btn-primary">
                </form>
                <ul id="fileList">
                    <li>No hay Archivos Seleccionados</li>
                </ul>
            </div>
        </div>
    </div>

<div>
    <input type="button" value="Mas Vendidos" class="btn-small btn-info"> 
    <input type="button" value="Sin Imagenes" class="btn-small btn-warning outImg">
    <select id="editorial">
            <option>Seleccione una opcion</option>
            <?php foreach($editorial as $e){?>
                <option><?php echo $e->EDITORIAL?></option>
            <?php }?>
    </select>
    <select id="autor">
            <option>Seleccione una opcion</option>
            <?php foreach($autor as $a){?>
                <option><?php echo $a->AUTOR?></option>
            <?php }?>
    </select>
                <input type="button" class="btn-small btn-info actImg" value="Actualiza Imagenes">
                <input type="button" class="btn-small btn-primary bfis" value="Busqueda de ISBN en Documentos Fiscales">
</div>

<br/>
<div class="row" >
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Lista de Productos de Ventas.
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-aplicapago">
                                    <thead>
                                        <tr>
                                            <th>Ln</th>
                                            <th>ISBN</th>
                                            <th>Nombre / Titulo</th>
                                            <th>Editorial</th>
                                            <th>Precios</th>
                                            <th>Autor</th>
                                            <th>Clave Proveedor</th>
                                            <th>STATUS</th>
                                            <th>Seleccionar</th>
                                            <th>Datos Fiscales</th>
                                            <th>Dar de Baja</th>
                                            
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($catProductos as $data): 
                                            $color = '';
                                            if($data->STATUS == 'A'){
                                                $status = 'Activo';
                                            }elseif ($data->STATUS == 'B') {
                                                $status = 'Baja';
                                                $color='style="background-color:#ff99cc"';
                                            }elseif($data->STATUS == 'M'){
                                                $status = 'Espera Modificacion';
                                            }
                                            $artn = $data->ARTN;
                                            $a='<select name="unisat" class="unisat"  prod="'.$data->CLAVE_PEGASO.'" idp="'.$data->ID.'" orig="'.$data->UNIDAD_SAT.'" id="ln_'.$data->ID.'">
                                                <option value="a">Seleccione una Unidad</option>
                                                <option value="H87">Pieza "H87" </option>
                                                <option value="ACT">Actividad "ACT"</option>
                                                <option value="E51">Trabajo "E51"</option>
                                                <option value="E48">Unidad de servicio "E48"</option>
                                                </select>';
                                        ?>
                                        <tr <?php echo $color?> >
                                            <td><?php echo $data->ID;?>
                                                <br/>
                                                <input type="checkbox" />
                                            <?php if($artn == ''){?>
                                            <!---- <label id="id_<?php echo $data->ID?>">Copiar <input type="checkbox" onchange="copiar(<?php echo $data->ID?>)"> </label> --->
                                        <?php }else{?>
                                            <label><?php echo $artn?></label>
                                        <?php }?>
                                            </td>
                                            <td><?php echo $data->CLAVE_PROD;?>
                                            <br/>
                                            <!--<a href="http://www.google.com/search?q=<?php echo htmlentities($data->CLAVE_PROD)?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;"> <IMG SRC="http://www.google.com/logos/Logo_40wht.gif" border="0" ALT="Google" align="absmiddle"  width="50" height="40"> </a> -->
                                            <a href="http://images.google.com/images?gbv=1&hl=en&sa=1&q=<?php echo htmlentities($data->CLAVE_PROD)?>&btnG=Search+images" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;"> <IMG SRC="http://www.google.com/logos/Logo_40wht.gif" border="0" ALT="Google" align="absmiddle"  width="50" height="40"> </a>
                                            
                                            </td>
                                            <td><a href="index.v.php?action=histProd&id=<?php echo $data->ID?>&per=t&fi=&ff=&tipo=&isbn=" onclick="window.open(this.href, this.target, 'width=1200,height=600'); return false;" ><?php echo $data->GENERICO;?> <?php echo ($data->CALIFICATIVO == '')? '':', '.$data->CALIFICATIVO?> <?php echo ($data->SINONIMO == '')? '':', '.$data->SINONIMO?></a>
                                            <br/><font color="red" size="2pxs"><?php echo $data->IMAGENES?></font>
                                            <br/><input type="text" class="obs" value="" placeholder="Escriba una Observacion" size="80" art="<?php echo $data->ID?>">
                                            <!--
                                            <br/> <img src="..//imagenes//books//<?php echo $data->CLAVE_PROD.'-mini.JPG'?>"  style="width:100px;height:100px;">
                                            <img src="..//imagenes//books//<?php echo $data->CLAVE_PROD.'-big.JPG'?>"  style="width:150px;height:100px;" />
                                            -->
                                        </td>
                                            <td><?php echo $data->MARCA?> <br/>
                                            <?php echo $data->MEDIDAS.' '.$data->UM?>  </td>
                                            <td><?php echo $data->CLAVE_DISTRIBUIDOR?> <br/><p style="font-weight: bold; background-color: red"> <?php echo $data->CLAVE_FABRICANTE.' Precio Lista $ '.$data->PRECIO?> <p><p style="font-weight: bold; background-color: yellow">Costo Neto $ <?php echo $data->COSTO?> </p> </td>
                                            <td><?php echo $data->EMPAQUE?></td>
                                            <td><?php echo $data->SKU?></td>
                                            <td><?php echo $status?></td>
                                            <td><input type="button" class="btn btn-info editar" valor="<?php echo $data->ID?>" value="Editar"> </td>
                                            <td>
                                                <input type="text" name="cvesat" maxlength="20" placeholder="<?php echo empty($data->CLAVE_SAT)? 'CLAVE SAT':$data->CLAVE_SAT;?>" value="<?php echo $data->CLAVE_SAT;?>" class="cvesat1" prod="<?php echo $data->CLAVE_PEGASO?>" idp="<?php echo $data->ID?>" orig="<?php echo $data->CLAVE_SAT?>" id="ln_<?php echo $data->ID?>" <?php echo empty($data->CLAVE_SAT)? '':''?>> 
                                                <br/><?php echo (empty($data->UNIDAD_SAT))? $a:$data->UNIDAD_SAT ?>
                                            </td>
                                            <td><button name='bajaFTCArticualo' class="btn btn-danger bajaArticulo" valor='<?php echo $data->ID?>'><?php echo ($data->STATUS == 'B')? 'Reactivar':'Baja'?></button></td>    
                                            </tr>                                       
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                      </div>
            </div>
        </div>
</div>
<br />
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="http://bootboxjs.com/bootbox.js"></script>
<script type="text/javascript">


        $(".bfis").click(function(){
            alert("Hola Doris...")
            window.open("index.v.php?action=histProd&id=1&per=t&fi=&ff=&tipo=&isbn=",  "popup", 'width=1200,height=600')
        })

        $(".actImg").click(function(){
            $.ajax({
                url:'index.php',
                type:'post',
                dataType:'json',
                data:{actImg:1},
                success:function(data){
                    alert("Se actualizaron los productos con sus imagenes...")
                },
                error:function(){

                }
            })
        })

        $(".obs").change(function(){
            var obs=$(this).val()
            var art=$(this).attr('art')
            $.ajax({
                url:'index.php',
                type:'post',
                dataType:'json',
                data:{saveObs:obs, art},
                success:function(data){
                    $(this).val('')
                },
                error:function(){
                    $(this).val('')
                }
            })
        })

        $("#editorial").change(function(){
            var edit = $(this).val()
            window.open("index.php?action=catalogoProductosFTC&marca=" + edit, "_self")        
        })

        $(".outImg").click(function(){
            window.open("index.php?action=catalogoProductosFTC&desc1=s", "_self")
        })

        function makeFileList(){
            var input = document.getElementById("filesToUpload")
            var ul = document.getElementById("fileList")
            while(ul.hasChildNodes()){
                ul.removeChild(ul.firstChild)
            }
            for(var i = 0; i < input.files.lenght; i++){
                var li = document.createElement("li")
                li.innerHtml = input.files[i].name
                ul.appendChild(li)
            }
            if(!ul.hasChildNodes()){
                var li = document.createElement("li")
                li.innerHtml = "No hay elementos seleccionados"
                ul.appendChild(li)
            }
            document.getElementById("files2upload").value = input.files.length
        }

        function copiar(idp){
            if(confirm('Desea copiar este producto al nuevo Catologo? PGS' + idp)){
                $.ajax({
                    url:"index.php",
                    type:"post",
                    dataType:"json",
                    data:{copiarProd:idp},
                    success:function(data){
                        alert('Se copio correctamente');
                        document.getElementById("id_"+idp).innerHTML= "<label><font color='blue'>PGN"+data.nuevo+"</font></label>";
                    }
                });
            }else{
                alrt('No se realizo la copia de ningun producto.');
            }
        }
        
        $(".cvesat1").autocomplete({
            source: "index.php?cvesat=1",
            minLength: 3,
            select: function(event, ui){
            }
        })

        $("select.unisat").change(function(){
            var nuni = $(this).val();
            var prod = $(this).attr('prod');
            var nvacve = '';
            var idpreoc = $(this).attr('idp');
            var cveact = $(this).attr('orig');
            if(nuni == 'a'){
                alert('Seleccione un valor');        
            }else{
                $.ajax({
                    url:'index.php',
                    type:'POST',
                    dataType:'json',
                    data:{gcvesat:prod,cvesat:nvacve,idpreoc:idpreoc,nuni:nuni,tipo:'uni'},
                    success:function(data){
                        if(data.status == 'ok'){
                            alert('Se actualizo el producto, ahora ya se puede facturar');
                            location.reload(true)
                        }else{
                            alert(data.mensaje);
                            document.getElementById('ln_'+idpreoc).value=cveact;
                        }
                    }
                });
            }
        })

        $("input.cvesat1").change(function(){
            var nuni = '';
            var prod = $(this).attr('prod');
            var nvacve = $(this).val();
            var idpreoc = $(this).attr('idp');
            var cveact = $(this).attr('orig');
            if(confirm('Desea asignar el codigo del SAT: '+ nvacve +', al producto: ' + prod)){   
                $.ajax({
                    url:'index.php',
                    type:'POST',
                    dataType:'json',
                    data:{gcvesat:prod,cvesat:nvacve,idpreoc:idpreoc, nuni:nuni, tipo:'cve'},
                    success:function(data){
                        if(data.status == 'ok'){
                            alert('Se actualizo el producto, ahora ya se puede facturar');
                            location.reload(true)
                        }else{
                            alert(data.mensaje);
                            document.getElementById('ln_'+idpreoc).value=cveact;
                        }
                    }
                });
            }else{
                document.getElementById('ln_'+idpreoc).value='';
            }
        })    

     $("#descripcion").autocomplete({
        source: "index.v.php?descAuto=1",
        minLength: 3,
        select: function(event, ui){
        }
    })

     $(".bajaArticulo").click(function(){
        var ids = $(this).attr('valor');
            if(confirm('Esta seguro de dar de baja el Articulo "PGS'+ids+'"' ))
            $.ajax({
                url:'index.php',
                type:'POST',
                dataType:'json',
                data:{editarArticulo:ids, tipo:'b'},
                success:function(data){
                    if(data.status == 'ok' && data.BAJA == 'SI'){
                        alert('Se ha eliminado el producto'); 
                        //location.reload(true);
                    }else{
                        var cotizacion = '';
                        var vendedores = '';
                        data.cotizaciones.forEach(function(element) {
                            cotizacion = cotizacion + element.cotizacion + '\n';
                            vendedores = vendedores + element.vendedor + '\n';
                        });
                        alert('El producto se encuentra en produccion en las cortizacion(es) \n'+ cotizacion + ' de los vededor(es) \n' + vendedores +'y no se puede eliminar');
                    }
                }
            });
     });

     $(".editar").click(function(){
            var ids = $(this).attr('valor');
            $.ajax({
              url:'index.php',
              type:'POST',
              dataType:'json',
              data:{editarArticulo:ids, tipo:'e'},
              success:function(data){
                  if(data.status= 'ok' && data.cotizaciones.length == 0 ){
                      window.open('index.php?action=editaFTCART&ids='+ids, 'popup', 'width=1200,height=820'); return false;
                  }else{
                        var cotizacion = '';
                        var vendedores = '';
                        window.open('index.php?action=editaFTCART&ids='+ids, 'popup', 'width=1200,height=820'); return false;
                        data.cotizaciones.forEach(function(element) {
                            cotizacion = cotizacion + element.cotizacion + '\n';
                            vendedores = vendedores + element.vendedor + '\n';
                        });
                      if(confirm("El producto esta en la(s) cotizacion(es):\n "+ cotizacion + "de lo(s) vededor(es) \n" + vendedores+ "y no se puede cambiar, desea apartarlo para que no se pueda volver Seleccionar en ventas?)")){                      
                            $.ajax({
                                url:'index.php',
                                type:'POST',
                                dataType:'json',
                                data:{editarArticulo:ids, tipo:'a'},
                                success:function(data2){
                                    if(data2.status == 'ok'){
                                        alert('El producto se ha apartado y no se podra comprar hasta su liberacion por compras');
                                        //location.reload(true);
                                    }
                                }
                            });
                        }
                 }
            }
          });
     });
</script>



