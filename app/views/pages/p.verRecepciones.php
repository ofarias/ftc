<br/>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Ver recepcion desde devoluciones.
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-aplicapago">
                                    <thead>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Nombre</th>
                                            <th>Usuario</th>
                                            <th>Fecha de envio</th>
                                            <th>Fecha de Devolucion </th>
                                            <th>Motivo de Devolucion</th>
                                            <th>Status de Aviso</th>
                                            <th>Descargar Impresion</th>
                                            <th>Dejar de Ver</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        $i=0;
                                        foreach ($recepciones as $data):
                                            $archivo = 'DEVOLUCION_'.$data->FOLIO_DEV;
                                            $i++;
                                        ?>
                                        <tr id="<?php echo $i?>">
                                            <td><?php echo $data->FOLIO_DEV;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->USUARIO_DEV ;?></td>
                                            <td><?php echo $data->FECHAEMPAQUE;?></td>
                                            <td><?php echo $data->FECHA_ULTIMA_DEV?></td>
                                            <td><?php echo $data->MOTIVO;?></td>
                                            <td><?php echo $data->IMPRESION_DEV;?></td>
                                            <td><a href='/Devoluciones/<?php echo $archivo?>.pdf' download="/Devoluciones/<?php echo $archivo?>.pdf">Ver Impresion</a></td>
                                            <td><input name="quit" type="button" value="Quitar" onclick="quitar1(<?php echo $i?>, <?php echo $data->FOLIO_DEV?>)" id="boton_<?php echo $i?>"></td>
                                                 
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
    </div>
<br />

<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Ver Recepciones desde Ordenes de compra interna.
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-aplicapago">
                                    <thead>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Proveedor</th>
                                            <th>Fecha </th>
                                            <th>Importe</th>
                                            <th>Partida</th>
                                            <th>Usuario</th>
                                            <th>Impresion</th>
                                            <th>Dejar de Ver</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        $e=0;
                                        foreach ($ingresos as $data):
                                            //$archivo = 'DEVOLUCION_'.$data->FOLIO_DEV;
                                            $e++;
                                            ?>
                                        <tr id="ln<?php echo $e?>">
                                            <td><?php echo $data->DOCUMENTO;?></td>
                                            <td><?php echo $data->PROVEEDOR;?></td>
                                            <td><?php echo $data->FECHA;?></td>
                                            <td><?php echo $data->IMPORTE;?></td>
                                            <td><?php echo $data->PARTIDAS?></td>
                                            <td><?php echo $data->USUARIO;?></td>
                                            <td><input name="quit" type="button" value="Quitar" onclick="quitar(<?php echo $e?>, '<?php echo $data->DOCUMENTO?>')" id="boci_<?php echo $e?>"></td>
                                             <td><input name="imp" type="button" value="Imprimir" onclick="imprimirOCI(<?php echo $e?>, '<?php echo $data->DOCUMENTO?>')" id="impoci_<?php echo $e?>"></td>  
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
    </div>


<form action="index.php" method="POST" id="impresion">
    <input type="hidden" name="oc" value="" id="oci">
    <input type="hidden" name="imprimirOCI" value="">
</form>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">

function quitar1(i, folio){
    if(confirm('Desea quitar de esta pantalla la Recepcion de la : ' +folio+ '?' )){
        $.ajax({
            url:'index.php',
            dataType:'json',
            method:'POST',
            data:{quitarRecepDev:1,folio:folio}
         });    
        document.getElementById('boton_'+i).classList.add('hide');      
        renglon = document.getElementById(i);
        renglon.style.background="red";  
    }
    
}

function quitar(e, folio){
    if(confirm('Desea quitar de esta pantalla la OCI:' +folio+ '?' )){
        $.ajax({
            url:'index.php',
            dataType:'json',
            method:'POST',
            data:{quitarOciImp:1,folio:folio}, 
            success:function(data){
                alert(data.mensaje);
                if(data.status=='ok'){
                    document.getElementById('boci_'+e).classList.add('hide');      
                    renglon = document.getElementById('ln'+e);
                    renglon.style.background="red";  
                    }
                }
         });    
        
    }
}

function imprimirOCI(e,folio){
    if(confirm('Desea imprimir la OCI :' +folio+ '?' )){
        document.getElementById('oci').value=folio;
        var form = document.getElementById('impresion');
        form.submit();
    }
}

</script>
