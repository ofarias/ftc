<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default" id="imprimeme">
            <div class="panel-heading">
                Documentos con contrarecibo.
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                 <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="">
                        <thead>
                            <tr>
                                <th>Pedido</th>
                                <th>Cliente</th>
                                <th>Factura</th>
                                <th>Importe Factura</th>
                                <th>Fecha Factura</th>
                                <th>Remisión</th>
                                <th>Importe Remisión</th>
                                <th>Fecha Remisión</th>
                                <th>Estatus</th>
                                <th>CR</th>
                                <th>Días</th>
                                <th>Contrarecibo</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($exec as $data):?>
                            <tr>
                                <td><?php echo $data->CVE_FACT;?></td>
                                <td><?php echo $data->CLIENTE;?></td>
                                <td><?php echo $data->FACTURA;?></td>
                                <td><?php echo "$ ".number_format($data->IMPFAC,2,".",",");?></td>
                                <td><?php echo $data->FECHAFAC;?></td>
                                <td><?php echo $data->REMISION;?></td>
                                <td><?php echo "$ ".number_format($data->IMPREM,2,".",",");?></td>
                                <td><?php echo $data->FECHAREM;?></td>
                                <td><?php echo $data->STATUS_LOG;?></td>
                                <td><?php echo $data->CARTERA_REV;?></td>
                                <td><?php echo $data->DIAS;?></td>
                                <td><?php echo $data->CONTRARECIBO_CR;?></td>
                            </tr>
                        <?php
                        endforeach; ?>
                        </tbody>
                    </table>
                    <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>

<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default" id="imprimeme">
            <div class="panel-heading">
                Documentos sin contrarecibo, capturar motivo.
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                 <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="tb1">
                        <thead>
                            <tr>
                                <th>Pedido</th>
                                <th>Cliente</th>
                                <th>Factura</th>
                                <th>Importe Factura</th>
                                <th>Fecha Factura</th>
                                <th>Remisión</th>
                                <th>Importe Remisión</th>
                                <th>Fecha Remisión</th>
                                <th>Estatus</th>
                                <th>CR</th>
                                <th>Días</th>
                                <th>Motivo</th>
                                <th>Guardar</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($nocontrarecibo as $data):?>
                            <tr>
                                <td><?php echo $data->CVE_FACT;?></td>
                                <td><?php echo $data->CLIENTE;?></td>
                                <td><?php echo $data->FACTURA;?></td>
                                <td><?php echo "$ ".number_format($data->IMPFAC,2,".",",");?></td>
                                <td><?php echo $data->FECHAFAC;?></td>
                                <td><?php echo $data->REMISION;?></td>
                                <td><?php echo "$ ".number_format($data->IMPREM,2,".",",");?></td>
                                <td><?php echo $data->FECHAREM;?></td>
                                <td><?php echo $data->STATUS_LOG;?></td>
                                <td><?php echo $data->CARTERA_REV;?></td>
                                <td><?php echo $data->DIAS;?></td>
                        <form action="index.php" method="post" name="form1">
                                <td><input type="textbox" name="motivo" placeholder="<?php echo $data->MOT;?>" value ="<?php echo $data->MOT;?>" maxlength="20"/></td>
                                <input type="hidden" name="factura" value="<?php echo $data->FACTURA;?>"/>
                                <input type="hidden" name="remision" value="<?php echo $data->REMISION;?>"/>
                                <input type="hidden" name="cr" value="<?php echo $cartera;?>" />
                                <td><button type="submit" name="salvarMotivoSinCR" class="btn btn-warning">Guardar <i class="fa fa-save"></i></button></td>
                        </form>
                            </tr>
                        <?php
                        endforeach; ?>
                        </tbody>
                    </table>
                    <!-- /.table-responsive -->
                </div>
            </div>
            <div class="panel-footer text-right">
                <form action="index.php" method="post">
                    <input type="hidden" name="cr" value="<?php echo $cartera;?>" />
                    <button name="GenerarCierreCarteraRevision" id="gccr" type="submit" id="Cierre" class="btn btn-warning" formtarget="_blank">Generar Cierre</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded",function(){    //Llama al evento
        tb = document.getElementsByName("motivo");              //guarda una referencia a los textbox con el nombre motivo y las guarda en un arreglito
        btn = document.getElementsByName("salvarMotivoSinCR");  // guarda una referencia a los botones con ese nombre y los guarda en un arreglo
        var contadorCampos = 0;
        for(campo = 0; campo < tb.length; campo ++){
            if(tb[campo].value == null || tb[campo].value == ""){   //valida si el campo esta vacio
                btn[campo].disabled = false;                        //si se cumple no hace nada con el boton
            }else{
                btn[campo].disabled = true;                         //sino se cumple deshabilita el boton y pone en solo lectura el textbox
                tb[campo].readOnly = true;
                contadorCampos += 1;                                //añade uno al contador para validar el boton de cierre
            }
        }
        if(contadorCampos != tb.length)                             //mientras que el contador de campos capturados no sea igual a la cantidad de campos el boton cierre sera deshabilitado
            document.getElementById("Cierre").disabled = true;
    });
    
    document.getElementById("gccr").addEventListener("click",function(){    //función para recargar la pagina al enviar form
        setTimeout(function(){ window.location.reload(); }, 2000);          // uwu algún día usaremos ajax.. pero no aquí
    });

</script>