<br/><br/>
<?php foreach($prod as $pro){} ?>

<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           <font size="5px"> Historico del producto " <?php echo $pro->GENERICO?> " ISBN (<?php echo $pro->CLAVE_PROD?>)</font>
                           <br/>
                           <br/>
                            <div>
                                <b>Buscar de ISBN en Documentos Fiscales:</b> <font color ="black"><input type="text" placeholder="ISBN" class="search" ></font> <input type="button" class="btn-small btn-success exe" value=">">
                            </div>
                           <br/>
                           Semana <input type="radio" name="p1" class="temp" value="s" <?php echo $per == 's'? 'checked':''?>> &nbsp;&nbsp;
                           Mes <input type="radio" name="p1" class="temp" value="m" <?php echo $per == 'm'? 'checked':''?> > &nbsp;&nbsp;
                           Año <input type="radio" name="p1" class="temp" value="a" <?php echo $per == 'a'? 'checked':''?> > &nbsp;&nbsp;
                           Todas <input type="radio" name="p1" class="temp" value="t"  <?php echo $per == 't'? 'checked':''?>> &nbsp;&nbsp;
                           Del &nbsp;&nbsp;<font color ="black"><input type="date" name="fi" id="fi" value="01.01.1990"></font> &nbsp;&nbsp; al &nbsp;&nbsp;<font color ="black">
                            <input type="date" name="ff" value="01.01.1990" id="ff"></font>&nbsp;&nbsp;<label class="ir">Ir</label>
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-nv">
                                    <thead>
                                        <tr>
                                            <th> Tipo </th>
                                            <th> Documento </th>
                                            <th> <font color="green">Cliente</font> /<font color="blue"> Proveedor</font></th>
                                            <th> Descripcion</th>
                                            <th> Fecha </th>
                                            <th> Cantidad </th>
                                            <th> Precio </th>
                                            <th> SubTotal </th>
                                            <th> Iva </th>
                                            <th> IEPS </th>
                                            <th> Descuentos </th>
                                            <th> Total </th>
                                        <?php if($tipo != 'f'){?>
                                            <th> Saldo </th>
                                            <th> Vendedor </th>
                                            <th> OC / Observaciones </th>
                                        <?php }?>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php foreach ($info as $i):?>
                                        <tr>
                                            <td WIDTH="1"> <?php echo $i->TIPO?> </td>
                                            <td WIDTH="1"> <?php echo $i->DOCUMENTO?> </td>
                                            <td WIDTH="1"> 
                                            <font color="green"><?php echo $i->CLIENTE?></font>
                                            <?php if($tipo == 'f'){?>
                                               <br/> <font color="blue"><b><?php echo $i->PROVEEDOR?></b></font> 
                                            <?php }?>
                                            </td>
                                            <td WIDTH="1"> <b><?php echo $i->DESCRIPCION.' <br/><font color="red">isbn:</font> '.$i->IDENTIFICADOR?></b></td> 
                                            <td WIDTH="1"> <?php echo $i->FECHA_DOC?> </td>
                                            <td WIDTH="1"> <?php echo $i->CANTIDAD?> </td>
                                            <td WIDTH="1"> <?php echo '$ '.number_format($i->PRECIO,2)?> </td>
                                            <td WIDTH="1"> <?php echo '$ '.number_format($i->CANTIDAD * $i->PRECIO,2)?> </td>
                                            <td WIDTH="1"> <?php echo '$ '.number_format(($i->IMP1 / 100) * ($i->CANTIDAD * $i->PRECIO),2)?> </td>
                                            <td WIDTH="1"> <?php echo '$ '.number_format(($i->IMP2 / 100) * ($i->CANTIDAD * $i->PRECIO),2)?> </td>
                                            <td WIDTH="1"> <?php echo '$ '.number_format($i->DESCUENTO,2)?> </td>
                                            <td WIDTH="1"> <?php echo '$ '.number_format($i->TOTAL,2)?> </td>
                                        <?php if($tipo != 'f'){?>
                                            
                                            <td WIDTH="1"> <?php echo '$ '.number_format($i->SALDO,2)?> </td>
                                            <td><?php echo $i->USUARIO?></td>
                                            <td><?php echo $i->OC?></td>
                                        <?php }?>
                                        
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                      </div>
            </div>
        </div>
    </div>
</div>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">  

    var p = '';
    var id = <?php echo $id?>;

    $(".exe").click(function(){
        var isbn = $(".search").val()
        var fi = document.getElementById('fi').value
        var ff = document.getElementById('ff').value
        var p = $(".temp:checked").val()
        if(fi != ""){
            p = 'p'
        }
        $.ajax({
            url:'index.v.php',
            type:'post',
            dataType:'json',
            data:{sisbn:isbn},
            success:function(data){
                if(data.status=='ok'){
                    window.open("index.v.php?action=histProd&id=1&per="+p+"&fi="+ fi + "&ff="+ff+"&tipo=f"+"&isbn="+isbn, "_self")
                }
            },
            error:function(){

            }
        })
        
    })

    
    $(".ir").click(function(){
        var fi = document.getElementById('fi').value
        var ff = document.getElementById('ff').value
        var p = $(".temp:checked").val()
        if(fi != ""){
            p = 'p'
        }
        window.open("index.v.php?action=histProd&id="+id+"&per="+p+"&fi="+ fi + "&ff="+ff, "_self" )
    })

    $(".detalles").click(function(){

    })

    $(".copiar").click(function(){
        var doc = $(this).attr('doc')
        $.confirm({
            title: 'Copia de Nota de Venta',
            content: '¿Seguro que deseas copiar la nota de venta '+ doc+ ' ?',
            buttons: {
                Si: function () {
                    $.ajax({
                        type: "POST",
                        url: 'index.v.php',
                        dataType: "json",
                        data: {copiaNV:1, doc},
                        success: function (data)
                        {
                            if (data.status == "ok") {
                                setTimeout(alert(data.Mensaje),4000)
                                location.reload(); 
                            } else {
                                $.alert('Algo salió mal, favor de verificarlo con el administrador de sistema, código de error: ' + data.response);
                                console.log("XML:"+data.status);
                            }
                        }
                    });
                },
                Cancelar: {
                }
            }
        });
    })

</script>