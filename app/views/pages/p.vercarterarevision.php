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
                                <th>Solucion Deslinde</th>
                                <th>Avanzar a:</th>
                                <th>Contrarecibo / Motivo </th>
                                <th>Avanzar</th>
                                <th>Imprimir</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($carteradia as $data):
                            if($data->DIAS >= 10)
                                $color = "background-color: #ff8080";
                            elseif($data->CAJA == 'Total Cliente')
                                $color = "background-color: #99d6ff";
                            else $color = "";
                        ?>
                            <tr style="<?php echo $color;?>" >

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
                                <td><?php echo $data->SOL_DESLINDE;?></td>  
                                  <form action="index.php" method="post">
                                <td><select name="avanzarevision" required="required">
                                        <option>--Avanzar a: --</option>
                                        <option value="Des"> Deslinde </option>
                                        <option value="Cob"> Cobranza </option>
                                    </select>
                                </td>
                                      <td><input type="text" name="contraRecibo" value="<?php echo $data->CONTRARECIBO_CR?>" maxlength="20"  <?php echo (empty($data->CONTRARECIBO_CR))?"":"readonly";?>/></td>
                                      <input type="hidden" name="caja" value="<?php echo $data->CAJA?>" />
                                      <input type="hidden" name="factura" value="<?php echo $data->FACTURA?>" />
                                      <input type="hidden" name="remision" value="<?php echo $data->REMISION?>" />
                                      <input type="hidden" name="cr" value="<?php echo $data->CARTERA_REV?>" />
                                      <td><button type="submit" name="salvaContrarecibo" class="btn btn-warning" <?php echo (empty($data->CONTRARECIBO_CR))?"":"disabled";?> >Avanzar <i class="fa fa-save"></i></button></td>
                                      <td><button type="submit" name="imprimeContrarecibo" onclick="refrescar()" class="btn btn-warning" formtarget="_blank" <?php echo (empty($data->CONTRARECIBO_CR))?"disabled":"";?>>Imprimir <i class="fa fa-print"></i></button></td>
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
                <a class="btn btn-info" target="_blank" href="index.php?action=ImprmirCarteraDia&cr=<?php echo $cart;?>">Imprimir <i class="fa fa-print"></i></a>
            </div>
        </div>
    </div>
</div>

<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Cartera revisión.
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                 <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="tb2">
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
                                <th>Solucion Deslinde</th>
                                <th>Anvanzar a:</th>
                                <th>Contrarecibo / Motivo</th>
                                <th>Avanzar</th>
                                <th>Imprimir</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($exec as $data):
                            if($data->DIAS >= 10)
                                $color = "background-color: #ff8080";
                            elseif($data->CAJA == 'Total Cliente')
                                $color = "background-color: #99d6ff";
                            else $color = "";
                        ?>
                            <tr style="<?php echo $color;?>" >
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
                                <td><?php echo $data->SOL_DESLINDE;?></td>
                                  <form action="index.php" method="post">
                                <td><select name="avanzarevision" required="required">
                                        <option>--Avanzar a: --</option>
                                        <option value="Des"> Deslinde </option>
                                        <option value="Cob"> Cobranza </option>
                                    </select>
                                </td>
                                      <td><input type="text" name="contraRecibo" value="<?php echo $data->CONTRARECIBO_CR?>" maxlength="20"  <?php echo (empty($data->CONTRARECIBO_CR))?"":"readonly";?>/></td>
                                      <input type="hidden" name="caja" value="<?php echo $data->CAJA?>" />
                                      <input type="hidden" name="factura" value="<?php echo $data->FACTURA?>" />
                                      <input type="hidden" name="remision" value="<?php echo $data->REMISION?>" />
                                      <input type="hidden" name="cr" value="<?php echo $data->CARTERA_REV?>" />
                                      <td><button type="submit" name="salvaContrarecibo" class="btn btn-warning" <?php echo (empty($data->CONTRARECIBO_CR))?"":"disabled";?> >Avanzar <i class="fa fa-save"></i></button></td>
                                      <td><button type="submit" name="imprimeContrarecibo" onclick="refrescar()" class="btn btn-warning" formtarget="_blank" <?php echo (empty($data->CONTRARECIBO_CR))?"disabled":"";?>>Imprimir <i class="fa fa-print"></i></button></td>
                                  </form>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <!-- /.table-responsive -->
                </div>
            </div>

        </div>
    </div>
</div>

<br /><br />
<div class="row" style="display:<?php echo (empty($sincartera))?"none":"block";?> ">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Documentos sin cartera de revisión asignada.
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                 <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="tb3">
                        <thead>
                            <tr >
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
                                <th>Avanzar a:</th>
                                <th>Contrarecibo / Motivo</th>
                                <th>Avanzar</th>
                                <th>Imprimir</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($sincartera as $data):                             
                            if($data->DIAS >= 10)
                                $color = "background-color: #ff8080";
                            elseif($data->CAJA == 'Total Cliente')
                                $color = "background-color: #99d6ff";
                            else $color = "";
                        ?>
                            <tr style="<?php echo $color;?>" >

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
                                <form action="index.php" method="post">
                                <td><select name="avanzarevision" required="required">
                                        <option>--Avanzar a: --</option>
                                        <option value="Des"> Deslinde </option>
                                        <option value="Cob"> Cobranza </option>
                                    </select>
                                </td>
                                      <td><input type="text" name="contraRecibo" value="<?php echo $data->CONTRARECIBO_CR?>" maxlength="20"  <?php echo (empty($data->CONTRARECIBO_CR))?"":"readonly";?>/></td>
                                      <input type="hidden" name="caja" value="<?php echo $data->CAJA?>" />
                                      <input type="hidden" name="factura" value="<?php echo $data->FACTURA?>" />
                                      <input type="hidden" name="remision" value="<?php echo $data->REMISION?>" />
                                      <input type="hidden" name="cr" value="<?php echo $data->CARTERA_REV?>" />
                                      <td><button type="submit" name="salvaContrarecibo" class="btn btn-warning" <?php echo (empty($data->CONTRARECIBO_CR))?"":"disabled";?> >Avanzar <i class="fa fa-save"></i></button></td>
                                      <td><button type="submit" name="imprimeContrarecibo" onclick="refrescar()" class="btn btn-warning" formtarget="_blank" <?php echo (empty($data->CONTRARECIBO_CR))?"disabled":"";?>>Imprimir <i class="fa fa-print"></i></button></td>
                                  </form>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded",function(){
        t1 = document.getElementById("tb1");
        t2 = document.getElementById("tb2");
        t3 = document.getElementById("tb3");
        var campo,campo2,campo3;
        for(campo = 0; campo < t1.rows.length; campo ++){
            if(t1.rows[campo].cells[0].innerHTML == 'Total Cliente' || t1.rows[campo].cells[0].innerHTML == 'Total General'){
                t1.rows[campo].cells[11].innerHTML = "";
                t1.rows[campo].cells[12].innerHTML = "";
                t1.rows[campo].cells[13].innerHTML = "";
            }
        }

        for(campo2 = 0; campo2 < t2.rows.length; campo2 ++){
            if(t2.rows[campo2].cells[0].innerHTML == 'Total Cliente' || t2.rows[campo2].cells[0].innerHTML == 'Total General'){
                t2.rows[campo2].cells[11].innerHTML = "";
                t2.rows[campo2].cells[12].innerHTML = "";
                t2.rows[campo2].cells[13].innerHTML = "";
            }
        }

        for(campo3 = 0; campo3 < t3.rows.length; campo3 ++){
            if(t3.rows[campo3].cells[0].innerHTML == 'Total Cliente' || t3.rows[campo3].cells[0].innerHTML == 'Total General'){
                t3.rows[campo3].cells[11].innerHTML = "";
                t3.rows[campo3].cells[12].innerHTML = "";
                t3.rows[campo3].cells[13].innerHTML = "";
            }
        }
    });

    function refrescar() {
        setTimeout(function(){ window.location.reload(); }, 2000);
    }



</script>