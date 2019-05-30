
<br/>
<br/>
<div>
<form action="index.php" method="post">
<input type="hidden" name="descripcion" value="">
 <label>Nuevo Producto</label>
  <a href="index.php?action=altaProductoFTC&marca=<?php echo $marca?>&prov1=<?php echo $prov1?>&desc1=<?php echo $desc1?>&desc2=<?php echo $desc2?>&categoria=<?php echo $categoria?>&generico=<?php echo $generico?>&unidadmedida=<?php echo $unidadmedida?>" class="btn btn-success">Nuevo</a> &nbsp;&nbsp; &nbsp;&nbsp;  <input type="text" name='descripcion' id='descripcion' value='' class="text" maxlength="40" style="width: 50%" />  <button  name="buscarArticuloCatalogo" class="btn btn-info" >Buscar Articulo</button>
</form>
<!--<input type="text" class="form-control" id="prov1" name="prov1" placeholder ="Codigo proveedor1" value="<?php echo $data->CLAVE_DISTRIBUIDOR?>"/><br> -->
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
                                            <th>Cat</th>
                                            <th>Marca</th>
                                            <th>Generico / Sinonimo</th>
                                            <th>Modelo / Medida</th>
                                            <th>Proveedor <br/> Clave </th>
                                            <th>Empaque</th>
                                            <th>Clave Fabricante</th>
                                            <th>STATUS</th>
                                            <th>Seleccionar</th>
                                            <th>Datos Fiscales</th>
                                            <?php if($user=='gcompras'){?>
                                                <th>Dar de Baja</th>
                                            <?php }?>
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
                                            $a='<select name="unisat" class="unisat"  prod="'.$data->CLAVE_PEGASO.'" idp="'.$data->ID.'" orig="'.$data->CVE_UNIDAD.'" id="ln_'.$data->ID.'">
                                                <option value="a">Seleccione una Unidad</option>
                                                <option value="H87">Pieza "H87" </option>
                                                <option value="ACT">Actividad "ACT"</option>
                                                <option value="E51">Trabajo "E51"</option>
                                                <option value="E48">Unidad de servicio "E48"</option>
                                                </select>';
                                        ?>
                                        <tr <?php echo $color?> >
                                            <td><?php echo 'PGS'.$data->ID;?>
                                                <br/>
                                            <?php if($artn == ''){?>
                                            <label id="id_<?php echo $data->ID?>">Copiar <input type="checkbox" onchange="copiar(<?php echo $data->ID?>)"> </label>
                                        <?php }else{?>
                                            <label><?php echo 'PGN'.$artn?></label>
                                        <?php }?>
                                            </td>
                                            <td><?php echo $data->MARCA;?></td>
                                            <td><?php echo $data->GENERICO;?> <?php echo ($data->CALIFICATIVO == '')? '':', '.$data->CALIFICATIVO?> <?php echo ($data->SINONIMO == '')? '':', '.$data->SINONIMO?></td>
                                            <td><?php echo $data->CLAVE_PROD?> <br/>
                                            <?php echo $data->MEDIDAS.' '.$data->UM?>  </td>
                                            <td><?php echo $data->CLAVE_DISTRIBUIDOR?> <br/><p style="font-weight: bold; background-color: red"> <?php echo $data->CLAVE_FABRICANTE.' Precio Lista $ '.$data->PRECIO?> <p><p style="font-weight: bold; background-color: yellow">Costo Neto $ <?php echo $data->COSTO?> </p> </td>
                                            <td><?php echo $data->EMPAQUE?></td>
                                            <td><?php echo $data->SKU?></td>
                                            <td><?php echo $status?></td>
                                            <td><input type="button" class="btn btn-info editar" valor="<?php echo $data->ID?>" value="Editar"> </td>
                                            <td>
                                                <input type="text" name="cvesat" maxlength="20" placeholder="<?php echo empty($data->CVE_PRODSERV)? 'CLAVE SAT':$data->CVE_PRODSERV;?>" value="<?php echo $data->CVE_PRODSERV;?>" class="cvesat1" prod="<?php echo $data->CLAVE_PEGASO?>" idp="<?php echo $data->ID?>" orig="<?php echo $data->CVE_PRODSERV?>" id="ln_<?php echo $data->ID?>" <?php echo empty($data->CVE_PRODSERV)? '':''?>> 
                                                <br/><?php echo (empty($data->CVE_UNIDAD))? $a:$data->CVE_UNIDAD ?>
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



