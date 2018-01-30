<br>
<div class="row">
<div class="container">
<div class="form-horizontal">
    <div class="panel panel-default">
        <div class="panel panel-heading">
            <h4>Filtro de documentos</h4>
        </div>
        <div class="panel panel-body">
            <form action="index.php" method="get"> 
                <div class ="form-group">
                    <label for="fechainicial" class="col-lg-1 control-label">Desde:</label>
                    <div class="col-lg-2">
                        <input type="date" class="form-control" name="fechainicial" required placeholder="fecha"/>  
                    </div>
                                    <label for="fechafinal" class="col-lg-1 control-label">Hasta:</label>
                    <div class="col-lg-2">
                        <input type="date" class="form-control" name="fechafinal" required placeholder="fecha"/>    
                    </div>
                </div>
                <div class ="form-group">
                    <label for="vendedor" class="col-lg-1 control-label">Vendedor:</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="vendedor" placeholder="Letra del vendedor o vacio para todos." />  
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-1 col-sm-10">
                                <button name="action" type="submit" value="ventVScobr" class="btn btn-info">Filtrar <i class="fa fa-search"></i></button>
                            </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
<br/>
<div id ="envoltura" style="display:<?php echo (empty($ventcob)) ? "none" : "block";?>">

<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Reporte de vendido contra cobrado.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-ventasvscobrado">
                                    <thead>
                                        <tr>
                                            <th>Cliente</th>
                                            <th>Referencia</th>
                                            <th>NC</th>
                                            <th>Fecha elabioración</th>
                                            <th>Importe vendido </th>
                                            <th>Base comision = <br/> Importe Documento sin IVA </th>
                                            <th>Importe cobrado</th>
                                            <th>Importe NC</th>
                                            <th>Saldo</th>
                                            <th>Comision</th>
                                            <th>Vendedor</th>  
                                            <th>Documento Origen</th>
                                        </tr>
                                    </thead>   
                                  <tbody>
                                        <?php
                                        foreach ($ventcob as $data):
                                            $comision = 0;
                                                if($data->IMPORTE_NC <= 1){
                                                    $comision = ($data->IMPORTE * 0.01) / 1.16;
                                                }
                                            ?>
                                        <tr>                                            
                                            <td><?php echo '('.$data->CVE_CLPV.')'.$data->NOMBRE;?></td>
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->NC_APLICADAS;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->IMPORTE,2,'.',',');?></td>
                                            <td> <?php echo '$ '.number_format($data->IMPORTE / 1.16,2)?></td>
                                            <td><?php echo '$ '.number_format($data->PAGOS,2,'.',',');?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->IMPORTE_NC,2,'.',',');?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->SALDOFINAL,2,'.',',');?></td>
                                            <td align="right"><?php echo '$ '.number_format($comision,2,'.',',');?></td>
                                            <td><?php echo $data->NOMBREVENDEDOR;?></td>
                                            <td><?php echo $data->DOC_ANT?></td>
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
</div>