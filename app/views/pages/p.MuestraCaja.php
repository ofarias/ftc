<div class="row">
    <br />
</div>
<div class="row">
    <div class="col-md-6">
        <form action="index.php" method="post">
          <div class="form-group">
            <input type="text" name="MuestraCaja" class="form-control" id="pedi" placeholder="Numero de Pedido">
          </div>
          <button type="submit" id="pedi" class="btn btn-default">Buscar</button>
          </form>
    </div>
</div>

<div class="<?php (empty($exec)) ? hide : nohide;?>">
<br />
<br />
    <?php foreach ($exec as $data):
        $SL = trim($data->STATUS_LOG);
        $SA = $data->ADUANA;
        $cf = $data->FECHA_CREACION;
        $uni = $data->UNIDAD;
        $ubicacion ='';
        if($cf >= '2016-08-01'){
            if(empty($SA)){    
                if ($SL == 'Entregado' or ($SL == 'Bodega') or ($SL == 'BodegaNC') or ($SL == 'Facturado') or ($SL == 'Devuelto') or ($SL== 'Recibido')){
                    $link = 'verFacturas';
                    $ubicacion = 'Aduana';
                }elseif(empty($SL) or $SL == 'Reenviar' or $SL == 'NC'){
                    $valfecha = ' Caja en Bodega Lista para empaquetar y embalar';
                }else{
                        if ($SL == 'nuevo'){
                            $SLL = 'Asignar Unidad';
                        }elseif($SL == 'secuencia'){
                            $SLL = 'Asignar Secuencia Unidad : '.$uni;
                        }elseif($SL == 'admon'){
                            $SLL = 'Administracion de Ruta Unidad: '.$uni;
                        }
                    $valfecha = ' Caja en Logistica Pantalla: '.$SLL;
                }
            }   
        }else{
            $valfecha = 'Caja fuera de Rango de Aduana, la fecha minima de creacion debe ser Agosto del 2016';
        }
    ?>
        <!-- /*ESTE ES EL VALOR DE SA = <?php echo $SA; ?> <br/>
        ESTE ES EL VALOR DE SL = <?php echo $SL;?> <br/>
        ESTE ES EL VALOR DE LA FECHA = <?php echo $cf;?></br>
        Valor de la validacion= <?php echo $valfecha;?><br/> */-->
    <big><strong>Ubicacion Actual = <?php echo (empty($valfecha))? '':$valfecha;?> <?php echo $ubicacion;?> <a href="index.php?action=<?php echo $link;?>" class="btn btn-default" <?php echo (empty($valfecha))? '':'disabled';?> > Ir  </a></strong></big>
    <?php endforeach; ?>
    </div>
<br /><br />
<div class="<?php (empty($exec)) ? hide : nohide;?>">
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Cajas: 
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>CAJA</th>
                                            <th>Documento</th>
                                            <th>Status</th>
                                            <th>Unidad</th>
                                            <th>Status Logistica</th>
                                            <th>Fecha Logistica</th>
                                            <th>Creación Caja</th>
                                            <th>Factura</th>
                                            <th>Importe</th>
                                            <th>Fecha Fac</th>
                                            <th>Remision</th>
                                            <th>Importe</th>
                                            <th>Fecha Rec</th>
                                            <th>Aduana</th>                                           
                                            <th>Fecha Aduana</th>
                                            <th>Cartera Revision</th>
                                            <th>Cartera cobranza</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php foreach ($exec as $data):?>
                                    <tr>
                                        <td><?php echo $data->ID;?></td>                          
                                        <td><?php echo $data->CVE_FACT;?></td>
                                        <td><?php echo $data->STATUS;?></td>
                                        <td><?php echo $data->UNIDAD;?></td>
                                        <td><?php echo $data->STATUS_LOG;?></td>
                                        <td><?php echo $data->FECHA_SECUENCIA;?></td>
                                        <td><?php echo $data->FECHA_CREACION;?></td>
                                        <td><?php echo $data->FACTURA;?></td>
                                        <td><?php echo $data->IMPFAC;?></td>
                                        <td><?php echo $data->FECHAFAC;?></td>
                                        <td><?php echo $data->REMISION;?></td>
                                        <td><?php echo $data->IMPREC;?></td>
                                        <td><?php echo $data->FECHAREC;?></td>
                                        <td><?php echo $data->ADUANA;?></td>   
                                        <td><?php echo $data->FECHAA;?></td> 
                                        <td><?php echo $data->CR;?></td>
                                        <td><?php echo $data->CC;?></td>                                          
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