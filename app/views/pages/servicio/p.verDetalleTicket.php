<style type="text/css">
    .comentario{
        font-style: italic;
        color: grey;
    }
</style>
<?php if($clie !=''){
    foreach ($cl as $x){
        if($x->CLAVE_TRIM == $clie){
            $nombreC = $x->NOMBRE;
        }
    }
    }
?>
<br/>
<?php foreach($t as $tic):?>
<div class="row">
    <div class="container">
    <div class="form-horizontal col-lg-12">
        <div class="panel panel-default">
            <div class="panel panel-heading">
                <h3>Ticket No <?php echo $tic->ID?></h3>
            </div>
            <br />
            <div class="panel panel-body">
                <form action="index.serv.php" method="post" id="formdoc">
                    <div class="form-group">
                        <label for="cliente" class="col-lg-2 control-label">Cliente: </label>
                            <div class="col-lg-8">
                                <label><?php echo $tic->NOMBRE_CLIENTE?></label>
                                <br>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="usuario" class="col-lg-2 control-label">Usuario que Reporta: </label>
                            <div class="col-lg-8">
                                <select class="form-control" name="reporta" required = "required">
                                    <option value="<?php echo $tic->ID_USU_REP?>"><?php echo $tic->REPORTA?></option>
                                <?php foreach($us as $usu):?>    
                                    <option value="<?php echo $usu->ID;?>" ><?php echo $usu->NOMBRE.' '.$usu->SEGUNDO.' '.$usu->PATERNO.' '.$usu->MATERNO.' '.$usu->CLIENTE;?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="usuario" class="col-lg-2 control-label">Usuario del Equipo o Encargado: </label>
                            <div class="col-lg-8">
                                <select class="form-control" name="usuario" required = "required">
                                    <option value="<?php echo $tic->ID_USU?>"><?php echo $tic->USUARIO?></option>
                                <?php foreach($us as $usu):?>    
                                    <option value="<?php echo $usu->ID;?>" ><?php echo $usu->NOMBRE.' '.$usu->SEGUNDO.' '.$usu->PATERNO.' '.$usu->MATERNO.' '.$usu->CLIENTE;?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="copias" class="col-lg-2 control-label">Equipo: </label>
                            <div class="col-lg-8">
                                <select name="equipo" required id="equip">
                                    <option value="<?php echo $tic->ID_EQU?>"><?php echo $tic->EQUIPO?></option>
                                    <?php foreach ($eq as $equi): ?>
                                        <option value="<?php echo $equi->ID?>">
                                        <?php echo $equi->NOMBRE_AD.' '.$equi->TIPO.' Modelo: '.$equi->MODELO.' N/S: '.$equi->NS?> 
                                        </option>    
                                    <?php endforeach ?>
                                </select>    
                            </div>
                    </div>
                    <div class="form-group hidden" id="infeq">
                            <div class="col-lg-8">
                                <br/><p id="deq"></p>
                            </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="requerido" class="col-lg-2 control-label">Fecha de Reporte: </label>
                            <div class="col-lg-8">
                                <input type="date" name="fecha" value="<?php echo date("Y-m-d", strtotime($tic->FECHA_REPORTE))?>">
                                &nbsp;&nbsp;&nbsp;
                                Medio:  <select name="modo">
                                        <option value="0">Seleccione el modo de reporte</option>    
                                        <?php foreach ($md as $modo ): ?>
                                            <option value="<?php echo $modo->IDMR?>"><?php echo $modo->MODO?></option>
                                        <?php endforeach ?>
                                        </select>
                                <br/><label class="comentario">Fecha en la que se reporto en problema o incidente.</label>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="copias" class="col-lg-2 control-label">Tipo: </label>
                            <div class="col-lg-8">
                                <select name="tipo" required>
                                    <option value="">Seleccione el tipo de servicio</option>
                                    <option value="0">NO APLICA </option>
                                    <?php foreach ($tp as $tip): ?>
                                        <option value="<?php echo $tip->ID?>" title="<?php echo $tip->DESCRIPCION?>" >
                                        <?php echo $tip->NOMBRE_TIPO?> 
                                        </option>    
                                    <?php endforeach ?>
                                </select>    
                                
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="copias" class="col-lg-2 control-label">Sistema: </label>
                            <div class="col-lg-8">
                                <select name="sistema" required>
                                    <option value="">Seleccione un sistema</option>
                                    <option value="0">NO APLICA </option>
                                    <?php foreach ($so as $sis): ?>
                                        <option value="<?php echo $sis->IDSO?>">
                                        <?php echo $sis->NOMBRE_COMERCIAL?> 
                                        </option>    
                                    <?php endforeach ?>
                                </select>    
                                <br/><label class="comentario">Seleecione No Aplica en el caso de algundispositivo de red o que notenga un sistema operativo</label>
                            </div>
                    </div>

                    <div class="form-group">
                        <label for="requerido" class="col-lg-2 control-label">Breve descripcion del problema: </label>
                            <div class="col-lg-8">
                                <input type="text" size="50" maxlength="50" name="corta" placeholder="Descripcion corta">
                                <br/><label class="comentario">Ejemplo: Si el equipo no imprime, ponemos solamente, Impresion.</label>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="requerido" class="col-lg-2 control-label">Descripcion copleta del problema: </label>
                            <div class="col-lg-8">
                                <textarea name="completa" cols="100" rows="8"></textarea>
                                <br/><label class="comentario">Este campo se puede editar hasta antes de cerrar el ticket.</label>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="requerido" class="col-lg-2 control-label">Solución: </label>
                            <div class="col-lg-8">
                                <textarea name="solucion" cols="100" rows="8"></textarea>
                                <br/><label class="comentario">Este campo se puede editar hasta antes de cerrar el ticket.</label>
                            </div>
                    </div>

                   </form>
                </div>

                <div>
                <div class="panel-footer">
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button name="creaTicket" type="submit" value="g" class="btn-sm btn-info" form="formdoc">Guardar y Nuevo <i class="fa fa-floppy-o"></i></button>
                            <button name="creaTicket" type="submit" value="gc" class="btn-sm btn-success" form="formdoc">Guardar y Cerrar <i class="fa fa-floppy-o"></i></button>
                            <a class="btn-sm btn-danger" onclick="window.close()"> Cancelar Ticket <i class="fa fa-times"></i></a>
                        </div>
                    </div>
                </div>    
            </div>

        </div>
        <br/>
    </div>
    </div>
</div>
<?php endforeach;?>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">
    
    $("#t").change(function(){
        var cl = $(this).val()
        window.open("index.serv.php?action=nuevoTicket&cli="+ cl, "_self")
    })

    $("#equip").change(function(){
        var eq = $(this).val()

        document.getElementById('deq').innerHTML=   '<div class="form-group>'+
                                                    '<font color="blue">Texto de la informacion del equipo</font>'+
                                                    '</div>'
        document.getElementById('infeq').classList.remove('hidden')
                
    })

</script>