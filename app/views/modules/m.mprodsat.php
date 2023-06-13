<div class="container">
        <!-- Marketing Icons Section -->
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                </h3>
            </div>

             <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Productos pendientes de facturar </h4>
                    </div>
                    <div class="panel-body">
                        <p><?php echo'('.count($prodSAT).') Pendientes' ?></p>
                        
                    </div>
                </div>
            </div>
            <br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default" id="imprimeme">
            <div class="panel-heading">
                Cartera día.
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                 <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="tb1">
                        <thead>
                            <tr>
                                <th>Clave <br/> ID</th>
                                <th>Descripcion</th>
                                <th>Cotizacion</th>
                                <th>Cantidad</th>
                                <th>Unidad <br/>medida</th>
                                <th>Clave SAT</th>
                                <th>Unidad <br/> Medida SAT</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($prodSAT as $data):?>
                            <tr>
                                <td><?php echo $data->PRODUCTO.'<br/>'.$data->IDPREOC;?></td>
                                <td><a href="http://www.google.com/search?q=<?php echo htmlentities($data->DESCRIPCION)?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;"><?php echo $data->DESCRIPCION?></a></td>
                                <td><?php echo $data->COTIZACION;?></td>
                                <td><?php echo $data->CANTIDAD;?></td>
                                <td><?php echo $data->UNI_MED;?></td>
                                <td>
                                    <input type="text" name="cvesat" maxlength="20" placeholder="<?php echo empty($data->CVE_PRODSERV)? 'CLAVE SAT':$data->CVE_PRODSERV;?>" value="<?php echo $data->CVE_PRODSERV;?>" class="cvesat1" prod="<?php echo $data->PRODUCTO?>" idp="<?php echo $data->IDPREOC?>" orig="<?php echo $data->CVE_PRODSERV?>" id="ln_<?php echo $data->IDPREOC?>"> 
                                </td>
                                <td>
                                    <select name="unisat" class="unisat"  prod="<?php echo $data->PRODUCTO?>" idp="<?php echo $data->IDPREOC?>" orig="<?php echo $data->CVE_UNIDAD?>" id="ln_<?php echo $data->IDPREOC?>">
                                        <option value="<?php echo empty($data->CVE_PRODSERV)? 'a':$data->CVE_UNIDAD;?>"><?php echo empty($data->CVE_UNIDAD)? 'Seleccione una Unidad':$data->CVE_UNIDAD;?></option>
                                        <option value="H87">Pieza "H87" </option>
                                        <option value="ACT">Actividad "ACT"</option>
                                    </select>
                                </td>
                            </tr>
                        <?php
                        endforeach; ?>
                        </tbody>
                    </table>
                    <a href="http://200.57.3.89/PyS/catPyS.aspx" target="_blank"><font color="blue">Ayuda SAT</font></a>
                    <!-- /.table-responsive -->
                </div>
            </div>
               
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
<script>
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
</script>
