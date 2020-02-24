<br/>
<button id="nuevoTicket" class="btn btn-info">Nuevo Ticket</button>
<br/>
<br/>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Registro de Tickets</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="dataTables-table-3">
                        <thead>
                            <tr>
                                <th>Ln</th>
                                <th>Empresa</th>
                                <th>Reporta</th>
                                <th>Fecha</th>
                                <th>Equipo</th>
                                <th>Corta</th>
                                <th>Usuario</th>
                                <th>Estatus</th>
                                <th>Sistema</th>
                                <th>Detalle</th>   
                            </tr>
                        </thead>
                        <tbody>
                            <?php $ln=0; foreach($tcks as $row):
                            $ln++;
                            $color='';
                            $aviso='';
                            $color = "style='background-color:#D5F3DE';";
                            $aviso = "title=''";
                            ?>
                            <tr class="odd gradeX" <?php echo $color?> <?php echo $aviso?>>
                                <td><?php echo $row->ID;?></td>
                                <td><?php echo $row->NOMBRE_CLIENTE;?></td>
                                <td><?php echo $row->NOMBRE_USUARIO_REP;?></td>
                                <td><b><?php echo $row->FECHA?></b></td>
                                <td><?php echo $row->DESC_EQUIPO;?></td>
                                <td><?php echo $row->DESC_CORTA;?></td>
                                <td><b><?php echo $row->USUARIO_REGISTRA;?></b></td>
                                <td><?php echo $row->STATUS;?></td>
                                <td><?php echo $row->DESC_COMPLETA?></td>
                                <td><a href="index.serv.php?action=verDetalleTicket&id=<?php echo $row->ID?>" target="popup" onclick="window.open(this.href, this.target, 'width=2000, heigth=800')" class="btn btn-info">Ver Detalle</a></td>
                            </tr>
                            <?php endforeach ?>
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

    $("#nuevoTicket").click(function(){
        window.open("index.serv.php?action=nuevoTicket", "popup","width=1200,height=900")
    })
 
</script>