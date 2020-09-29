<br/>
<button id="nuevoTicket" class="btn btn-info">Nuevo Ticket</button>
<br/>
<br/>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <center><h1>Registro de Tickets</h1></center>
                <br/>
                Ver Todos <input type="radio" name="vista" id="b1" class="vista" value="t" <?php echo $temp == 't'? 'checked':'' ?>> &nbsp;&nbsp;Ver 1 Semana <input type="radio" name="vista" id="b2" class="vista" value="s" <?php echo $temp == 's'? 'checked':'' ?>> &nbsp;&nbsp; Ver 15 dias<input type="radio" name="vista" id="b3" class="vista" value="q" <?php echo $temp == 'q'? 'checked':''?> > &nbsp;&nbsp; Ver 1 Mes <input type="radio" name="vista" id="b4" class="vista" value="m" <?php echo $temp == 'm'? 'checked':''?>>&nbsp;&nbsp;<br/><br/>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <font color="white"><i class="fa fa-user fa-fw"></i>Reportes </font> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li class="divider"></li>
                        <li>
                        <a class="rep" value="1" > Usuario</a>
                        </li>
                        <li>
                        <a class="rep" value="2" > Cliente</a>
                        </li>
                        <li>
                        <a class="rep" value="3"> Cliente / Usuario</a>
                        </li>
                        <li>
                        <a class="rep" value="4"> Usuario / Cliente</a>
                        </li>
                        <li>
                        <a class="rep" value="5"> Otros</a>
                        </li>
                    </ul>
                </li>
            </div>
            <div class="panel-body">
                <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="dataTables-table-4">
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
                                <th>Imprimir</th>   
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
                                <td><a href="index.serv.php?action=verArchivos&clie=<?php echo $row->CLIENTE?>&tipo=ticket" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;"><?php echo $row->NOMBRE_CLIENTE;?></a></td>
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
                                <td><input type="button" class="btn-sm btn-primary impresion" value="Imprimir" idt="<?php echo $row->ID?>"></td>
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

    $(".impresion").click(function(){
        var idt = $(this).attr('idt');
        alert('Impresion del ticket ' + idt)
        $.ajax({
            url:'index.serv.php',
            type:'POST',
            dataType:'json',
            data:{impTick:1, idt},
            success:function(data){
                window.open('..//media//tickets//Ticket '+idt+'.pdf', 'download')
            },      
            error:function(){
                alert('Lo sentimos ocurrio un error, intentelo mas tarde') 
            }
        })
    })

    $("#nuevoTicket").click(function(){
        window.open("index.serv.php?action=nuevoTicket", "popup","width=1200,height=900")
    })

    var temp = <?php echo "'".$temp."'"?> 

    $(".vista").click(function(){
        var temp = $(this).val()
        window.open("index.serv.php?action=tickets&temp=" + temp, "_self")
    })

    $("#generaRep").click(function(){
      //  alert('Desea el reporte de ' + temp)
    })

    $(".rep").click(function(){
        var tipo = $(this).attr('value')
        if(confirm('Desea ver el reporte por usuario?')){
            for (var i = 1; i <= 4; i++) {
                var bt = document.getElementById('b' + i)
                if(bt.checked){
                    var periodo = bt.value;
                   // alert('El boton ' + i + '  es el que esta seleccionado, el valor es ' + periodo + ' con el tipo' + tipo)
                }
            }
            $.ajax({
                url:'index.serv.php',
                type:'post',
                dataType:'json', 
                data:{reporteServ:1, periodo, tipo}, 
                success:function(data){
                 //   alert('Se ejecuto correctamente el proceso')
                }, 
                error:function(){
                  //  alert('Ocurrio un error, favor de revisar la informacion.')
                }
            })
            
        }else{
            return false
        }
    })

</script>