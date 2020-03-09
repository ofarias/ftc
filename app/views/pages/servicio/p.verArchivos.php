<br/>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                 Imagenes del Ticket:
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables">
                                    <thead>
                                        <tr>
                                            <th>Ticket</th>
                                            <th>Empresa</th>
                                            <th>Documento</th>
                                            <th>Cliente</th>
                                            <th>Fecha</th>
                                            <th>Usuario</th>
                                            <th>Origen</th>
                                            <th>Tipo</th>
                                            <th>Version</th>
                                            <th>Ver</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($a as $ar):
                                        ?>
                                       <tr>  
                                            <td><?php echo $ar->ID_SERV?></td>
                                            <td><?php echo $ar->EMPRESA;?></td>
                                            <td><a href="<?php echo '..//media//files//'.$ar->NOMBRE.'.'.$ar->TIPO_ARCHIVO?>" download><?php echo $ar->NOMBRE;?></a></td>
                                            <td><?php echo $ar->NOMBRE_CLIENTE;?></td>
                                            <td><?php echo $ar->FECHA_ALTA;?></td>
                                            <td><?php echo $ar->USUARIO ;?></td>
                                            <td><?php echo $ar->ORIGEN?></td>
                                            <td><?php echo strtoupper($ar->TIPO_ARCHIVO)?></td>
                                            <td><?php echo $ar->VERSION?></td>
                                            <td><?php echo $ar->COMPLETA?></td>
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
    $(document).ready(function() {
    $(".fecha").datepicker({dateFormat:'dd.mm.yy'});
  } );

</script>

