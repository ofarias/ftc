<meta http-equiv="Refresh" content="240">
<br/>

<a href="index.serv.php?action=altaEquipo" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;" class="btn btn-success">Alta de Equipos</a>
	<br/><br/>
    	<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Equipos de Computo y Telecomunicaciones. 
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Cliente</th>
											<th>Usuario</th>
                                            <th>Tipo</th>
                                            <th>Marca</th>
                                            <th>Modelo</th>
                                            <th>SO</th>
                                            <th>HDD</th>
                                            <th>TIPO HDD</th>
                                            <th>MEMORIA</th>
                                            <th>NS</th>
                                            <th>TEAMVIEWER</th>
                                            <th>ANIO</th>
                                            <th>FECHA_MODELO</th>
                                            <th>OBSERVACIONES</th>
                                            <th>DOCUMENTOS</th>
                                            <th>DETALLES<br/>LICENCIAS</th>
                                            <th>EDITAR</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php
                                    	foreach ($eq as $data): 
                                            $tipo_hdd = '';
                                            $tipo_memoria = '';
                                            switch ($data->TIPO_HDD) {
                                                case 'm_sata':
                                                    $tipo_hdd = 'HDD (Mecanico interfaz SATA)';
                                                    break;
                                                case 's_sata':
                                                    $tipo_hdd = 'SDD (Estado Solido interfaz SATA)';
                                                    break;
                                                case 's_sata_m2':
                                                    $tipo_hdd = 'SDD (Estado Solido interfaz M.2 SATA)';
                                                    break;
                                                case 's_sata_pci':
                                                    $tipo_hdd = 'SDD (Estado Solido interfaz M.2 PCIe)';
                                                    break;
                                                case 's_sata_nvme':
                                                    $tipo_hdd = 'SDD (Estado Solido interfaz M.2 NVME)';
                                                    break;
                                                case 'm_ide':
                                                    $tipo_hdd = 'HDD (Mecanico interfaz IDE)';
                                                    break;
                                                default:
                                                    # code...
                                                    break;
                                            }

                                            switch ($data->MEMORIA_TIPO) {
                                                case 'd16':
                                                    $tipo_memoria = 'DIMM DDR 3 hasta 1666Mhz';
                                                    break;
                                                case 's16':
                                                    $tipo_memoria = 'SODIMM DDR 3 hasta 1666Mhz';
                                                    break;
                                                case 'd24':
                                                    $tipo_memoria = 'DIM DDR 4 hasta 2400 Mhz';
                                                    break;
                                                case 's24':
                                                    $tipo_memoria = 'SODIM DDR4 hasta 2400 Mhz';
                                                    break;
                                                case 'otra':
                                                    $tipo_memoria = 'Otra';
                                                    break;
                                                default:
                                                    # code...
                                                    break;
                                            }
                                        ?>                 
                                        <tr>
                                            <td><?php echo $data->ID?></td>
                                            <td><?php echo $data->NOMBRE_CLIENTE ?></td>
                                            <td><?php echo $data->NOMBRE_USUARIO ?></td>
                                            <td><?php echo $data->TIPO?></td>
                                            <td><?php echo $data->NOMBRE_MARCA?></td>
                                            <td><a href="http://www.google.com/search?q=<?php echo htmlentities($data->NOMBRE_MARCA.' '.$data->MODELO)?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;"><?php echo $data->MODELO?></a></td>
                                            <td><?php echo $data->NOMBRE_SO ?></td>
                                            <td><?php echo $data->HDD_CAPACIDAD.' Gb' ?></td>
                                            <td><?php echo $tipo_hdd?></td>
                                            <td><?php echo $data->MEMORIA_C_I.' Gb '.$tipo_memoria ?></td>
                                            <td align="right"><font color="red"><?php echo $data->NS?></font></td>
                                            <td align="right" title="Contraseña: <?php echo $data->CONTRASENIA_TV?>"><font color="blue"><?php echo $data->TEAMVIEWER?></font></td>
                                            <td><?php echo $data->ANIO?></td>
                                            <td><?php echo $data->FECHA_MODELO?></td>
                                            <td title="<?php echo $data->OBSERVACIONES?>"><?php echo substr($data->OBSERVACIONES, 0, 10).'...'?></td>
                                            <td></td>
                                            <td><a onclick="alert('Proximamente')" class="btn-sm btn-info">Detalles</a><br/>
                                                <br/><a onclick="alert('Proximamente')" class="btn-sm btn-success">Licencias</a></td>
                                            <td><a onclick="alert('Proximamente')" class="btn-sm btn-warning">Editar</a></td>
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
			          </div>
			</div>
		</div>
</div>