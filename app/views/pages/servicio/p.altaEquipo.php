<br/>
<style type="text/css">
.comentario
    {
        font-family: Comic Sans MS;
        font-style: oblique; 
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

<div class="row">
    <div class="container"
         >
    <div class="form-horizontal col-lg-12">
        <div class="panel panel-default">
            <div class="panel panel-heading">
                <h3>Alta de Equipo en el Inventario</h3>
            </div>
            <br />
            <div class="panel panel-body">
                <form action="index.serv.php" method="post" id="formdoc">
                    <div class="form-group">
                        <label for="cliente" class="col-lg-2 control-label">Cliente: </label>
                            <div class="col-lg-8">
                                <select name="cliente" required>
                                    <?php if($clie !=''){?>
                                        <option value="<?php echo $clie?>"><?php echo $nombreC?> </option>
                                    <?php }?>
                                    <?php foreach ($cl as $cli): ?>
                                        <option value="<?php echo $cli->CLAVE_TRIM?>"><?php echo $cli->NOMBRE?></option>
                                    <?php endforeach ?>
                                </select>
                                <br>
                            </div>
                    </div>

                    <div class="form-group">
                        <label for="usuario" class="col-lg-2 control-label">Usuario: </label>
                            <div class="col-lg-8">
                                <select class="form-control" name="usuario">
                                    <option value="0">Seleccion el Usuario principal de uso</option>
                                <?php foreach($us as $usu):?>    
                                    <option value="<?php echo $usu->ID;?>" ><?php echo $usu->NOMBRE.' '.$usu->SEGUNDO.' '.$usu->PATERNO.' '.$usu->MATERNO.' '.$usu->CLIENTE;?></option>
                                <?php endforeach; ?>
                                </select>
                                <br/> <label class="comentario">Usuario del equipo, para los equipos de Red o servidores colocar el usuario encargado de los equipos</label>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="copias" class="col-lg-2 control-label">Tipo: </label>
                            <div class="col-lg-8">
                                <select name="equipo" required>
                                    <option value="">Tipo</option>
                                        <option value="escritorio">Computadora de Escritorio</option>    
                                        <option value="laptop">Computadora Portatil (Laptop)</option>
                                        <option value="servidor">Servidor</option>    
                                        <option value="router">Router (Ruteador)</option>    
                                        <option value="access">Access Point</option>    
                                        <option value="switch">Switch</option>    
                                        <option value="conmutador">Conmutador Telefonico</option>    
                                        <option value="telefono">Telefono Propietario</option>    
                                        <option value="telefonoU">Telefono Generico o Unilinea</option>    
                                        <option value="accesorio">Accesorio de Computo</option>    
                                        <option value="pantalla">Pantalla</option>    
                                        <option value="modem">Modem para Internet</option>    
                                        <option value="impresora">Impresora</option>    
                                        <option value="multifuncional">Multifuncional (Impresora / Scaner / Copias)</option>    
                                        <option value="proyector">Proyector</option>    
                                </select>    
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="requerido" class="col-lg-2 control-label">Nombre Active Directory: </label>
                            <div class="col-lg-8">
                                <input type="text" size="50" maxlength="50" name="ad_name" placeholder="Si no aplica deje en blanco" value="" >
                            </div>
                    </div>

                    <div class="form-group">
                        <label for="marca" class="col-lg-2 control-label">Marca: </label>
                            <div class="col-lg-8">
                                <select class="form-control" name="marca" required = "required">
                                    <option value="">Seleccion Una Marca</option>
                                <?php foreach($mc as $marca):?>    
                                    <option value="<?php echo $marca->ID;?>" ><?php echo $marca->NOMBRE_COMERCIAL;?></option>
                                <?php endforeach; ?>
                                </select>
                                <label class="comentario">Si la marca no existe, favor de seleccionar "FARIAS TELECOMUNICACIONES Y COMPUTO"</label>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="modelo" class="col-lg-2 control-label">Modelo: </label>
                            <div class="col-lg-8">
                                <input type="text" name="modelo" value="" placeholder="Colocar el modelo del equipo" size="20" maxlength="20">
                                <br/><label class="comentario">Solo permite 20 Caracteres</label>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="procesador" class="col-lg-2 control-label">Procesador: </label>
                            <div class="col-lg-8">
                                <select class="form-control" name="procesador" required = "required">
                                    <option value="0">No Aplica</option>
                                <?php foreach($pr as $procesador):?>    
                                    <option value="<?php echo $procesador->IDPRO;?>" ><?php echo $procesador->NOMBRE_COMERCIAL;?></option>
                                <?php endforeach; ?>
                                </select>
                                <label class="comentario">Si no aplica seleccionar No Aplica</label>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="so" class="col-lg-2 control-label">Sistema Operativo: </label>
                            <div class="col-lg-8">
                                <select class="form-control" name="so" required = "required">
                                    <option value="0">No Aplica</option>
                                <?php foreach($so as $sistema):?>
                                    <?php if ($sistema->TIPO == 1): ?>
                                        <option value="<?php echo $sistema->IDSO;?>" ><?php echo $sistema->NOMBRE_COMERCIAL;?></option>
                                    <?php endif ?>    
                                <?php endforeach; ?>
                                </select>
                                <label class="comentario">Si no aplica seleccionar "No Aplica"</label>
                                <br><input type="text" name="dom" placeholder="Dominio al que esta unido" size="50" maxlength="50">
                                <br/><label class="comentario">Nombre del dominio al que esta unido el equipo</label>
                                <br><input type="text" name="senia" placeholder="Contraseña de Windows" size="50" maxlength="50">
                                <br/><label class="comentario">Si esta en AD no es necesaria la contraseña del equipo.</label>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="Disco Duro" class="col-lg-2 control-label">Capacidad de Disco Duro: </label>
                            <div class="col-lg-8">
                                <input type="number" name="hdd_inst" value="" step="100">&nbsp; Gb
                                <br/><label class="comentario">Capacidad Total de los Dico Duro en Gigabytes en multiplos de 100</label>
                                <br/><label class="comentario">Ejemplo 120 Gb = 100 Gb, 360 Gb = 300 Gb</label>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="Disco Duro" class="col-lg-2 control-label">Tipo de Disco Duro Principal: </label>
                            <div class="col-lg-8">
                                <select class="form-control" name="dd_principal" required = "required">
                                    <option value="m_sata">HDD (Mecanico interfaz SATA)</option>
                                    <option value="s_sata">SDD (Estado Solido interfaz SATA)</option>
                                    <option value="s_sata_m2">SDD (Estado Solido interfaz M.2 SATA)</option>
                                    <option value="s_sata_pci">SDD (Estado Solido interfaz M.2 PCIe)</option>
                                    <option value="s_sata_nvme">SDD (Estado Solido interfaz M.2 NVME)</option>
                                    <option value="m_ide">HDD (Mecanico interfaz IDE)</option>
                                </select>
                                <label class="comentario"> Disco duro principal donde esta instalado el SO</label>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="memoria" class="col-lg-2 control-label">Memoria Instalada: </label>
                            <div class="col-lg-8">
                                <input type="number" name="mem_inst" value="" step="2">&nbsp; Gb
                                <br/><label class="comentario">Capacidad Total de la Memoria Instalada en Gigabytes</label>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="capacida" class="col-lg-2 control-label">Capacidad Maxima de Memoria: </label>
                            <div class="col-lg-8">
                                <input type="number" name="mem_max" value="" step="2">&nbsp; Gb
                                <br/><label class="comentario">Capacidad Total de la Memoria Instalada en Gigabytes</label>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="tipo" class="col-lg-2 control-label">Tipo de memoria: </label>
                            <div class="col-lg-8">
                                <select class="form-control" name="t_memoria" required = "required">
                                    <option value="">Seleccione el Tipo de memoria de uso</option>
                                    <option value="d16">DIMM DDR 3 hasta 1666Mhz</option>
                                    <option value="s16">SODIM DDR 3 hasta 1666Mhz<</option>
                                    <option value="d24">DIM DDR 4 hasta 2400 Mhz</option>
                                    <option value="s24">SODIM DDR4 hasta 2400 Mhz</option>
                                    <option value="otra">Otra</option>
                                </select>
                                <label class="comentario"></label>
                            </div>
                    </div>   
                    <div class="form-group">
                        <label for="usuario" class="col-lg-2 control-label">Numero de Serie: </label>
                            <div class="col-lg-8">
                                <input type="text" name="ns" value="" size="30" maxlength="30" placeholder="Numero de Serie">
                                <br/><label class="comentario">Numero de Serie</label>
                            </div>
                    </div>                    
                    <div class="form-group">
                        <label for="usuario" class="col-lg-2 control-label">Correo del usuario principal: </label>
                            <div class="col-lg-8">
                                <input type="email" name="correo" value="" size="70" maxlength="70" placeholder="Correo electronico">
                                <br/><label class="comentario">Correo electronico del usuario principal del equipo</label>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="usuario" class="col-lg-2 control-label">ID de Teamviewer: </label>
                            <div class="col-lg-8">
                                <input type="text" name="tv" value="" size="20" maxlength="20" placeholder="Id de Teamviewer">&nbsp;&nbsp;<input type="text" name="tvc" value="" size="20" placeholder="Contraseña"> 
                                <br/><label class="comentario"></label>
                            </div>
                    </div>                
                    <div class="form-group">
                        <label for="usuario" class="col-lg-2 control-label">Tipo de IP: </label>
                            <div class="col-lg-8">
                                <select name = "t_ip" required>
                                    <option value="ip_dpr" >Ip Dinamica / Privada</option>
                                    <option value="ip_dpu" >Ip Dinamica / Publica</option>
                                    <option value="ip_fpr" >Ip Fija / Privada</option>
                                    <option value="ip_fpu" >Ip Fija / Publica</option>
                                </select>
                                <br/><label class="comentario">Se selecciona una IP PUBLICA si es necesario que se conecten remotamente por RDP o algun otro servicio.</label>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="usuario" class="col-lg-2 control-label">IP ADDRESS: </label>
                            <div class="col-lg-8">
                                <input type="text" name="ip" value="" size="15" maxlength="15" placeholder="Direccion IP">&nbsp;&nbsp;
                                <br/><label class="comentario">Si es una ip Dinamica dejar el blanco.</label>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="usuario" class="col-lg-2 control-label">MAC ADDRESS: </label>
                            <div class="col-lg-8">
                                <input type="text" name="mac" value="" size="50" maxlength="50" placeholder="Mac Address">&nbsp;&nbsp;
                                <br/><label class="comentario">Separar con ":" cada valor, ejemplo AA:01:BB:00 </label>
                            </div>
                    </div>                    
                    <div class="form-group">
                        <label for="usuario" class="col-lg-2 control-label">Puerto para RDP: </label>
                            <div class="col-lg-8">
                                <input type="text" name="rdp" value="3389" size="20" maxlength="20" placeholder="Puerto RDP">&nbsp;&nbsp;
                                <br/><label class="comentario">Solo si es necesario, el puerto por defaul es el 3389</label>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="usuario" class="col-lg-2 control-label">Area: </label>
                            <div class="col-lg-8">
                                <input type="text" name="area" value="" size="20" maxlength="20" placeholder="Area de instalacion">&nbsp;&nbsp;
                                <br/><label class="comentario">En que Area se encuentra el equipo o dispositivo</label>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="usuario" class="col-lg-2 control-label">Año de compra del equipo: </label>
                            <div class="col-lg-8">
                                <input type="number" value="2019" name="anio"  step="1" >&nbsp;&nbsp;
                                <br/><label class="comentario">Año en que el equipo se adquirio o se lanzo a la venta</label>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="usuario" class="col-lg-2 control-label">Numero de puertos de red: </label>
                            <div class="col-lg-8">
                                <input type="number" value="1" name="eth"  step="1" >&nbsp;&nbsp;
                                <br/><label class="comentario">Numero de puertos de Red</label>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="usuario" class="col-lg-2 control-label">Observaciones: </label>
                            <div class="col-lg-8">
                                <textarea name="obs" cols="80" spellcheck ></textarea>
                                <br/><label class="comentario">Observaciones importantes del equipo</label>
                            </div>
                    </div>
                   </form>
                </div>
            <div>
                <div class="panel-footer">
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button title="Al Guardar se queda predeterminado el nombre del cliente" name="nuevoEquipo" type="submit" value="enviar" class="btn btn-success" form="formdoc"> Guardar <i class="fa fa-floppy-o"></i>
                            </button>
                            <a class="btn btn-info" href="index.serv.php?action=altaEquipo">Limpiar Formulario</a>
                            <a class="btn btn-danger" onclick="window.close()">Cancelar<i class="fa fa-times"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
