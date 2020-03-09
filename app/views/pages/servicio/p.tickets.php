<br/>
<button id="nuevoTicket" class="btn btn-info">Nuevo Ticket</button>
<br/>
<br/>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Registro de Tickets</h4>
                <br/>
                Ver Todos <input type="radio" name="vista" class="vista" value="t" <?php echo $temp == 't'? 'checked':'' ?>> &nbsp;&nbsp;Ver 1 Semana <input type="radio" name="vista" class="vista" value="s" <?php echo $temp == 's'? 'checked':'' ?>> &nbsp;&nbsp; Ver 15 dias<input type="radio" name="vista" class="vista" value="q" <?php echo $temp == 'q'? 'checked':''?> > &nbsp;&nbsp; Ver 1 Mes <input type="radio" name="vista" class="vista" value="m" <?php echo $temp == 'm'? 'checked':''?>>&nbsp;&nbsp; Reporte en Excel<input type="button" id="generaRep">
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
                                <th>Archivos<br/> Avidencias</th>   
                            </tr>
                        </thead>
                        <tbody>
                            <?php $ln=0; foreach($tcks as $row):
                            $ln++;
                            $color='';
                            $aviso='';
                            if($row->STATUS == 0){
                                $color = "style='background-color:blue'";
                            }elseif ($row->STATUS == 2){
                                $color = "style='background-color:#D5F3DE';";
                            }
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
                                <td><?php echo $row->NOM_STATUS;?></td>
                                <td><?php echo $row->DESC_COMPLETA?></td>
                                <td><a href="index.serv.php?action=verDetalleTicket&id=<?php echo $row->ID?>" target="popup" onclick="window.open(this.href, this.target, 'width=2000, heigth=800')" class="btn btn-info">Ver Detalle</a></td>
                                <form action="carga_archivo.php" method="post" enctype="multipart/form-data" class="formdiot">
                                    <input type="hidden" name="servicio" value="<?php echo $row->ID?>">
                                    <input type="hidden" name="origen" value="ticket">
                                    <td align="center"> 
                                        <?php if($row->ARCHIVOS > 0){?>
                                            <font color="blue"><a href="index.serv.php?action=verArchivos&ticket=<?php echo $row->ID?>&tipo=ticket" target="popup" onclick="window.open(this.href, this.target,'width=1000,height=800'); return false;">Archivos: <?php echo $row->ARCHIVOS?></a></font><br/>
                                        <?php }?>
                                        <input type="file" name="fileToUpload">
                                        <input type="submit" value="Subir">
                                    </td>

                                </form>
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

    var temp = <?php echo $temp?> 

    $(".vista").click(function(){
        var temp = $(this).val()
        window.open("index.serv.php?action=tickets&temp=" + temp, "_self")
    })

    $("#generaRep").click(function(){
        alert('Desea el reporte de ' + temp)
    })


</script>