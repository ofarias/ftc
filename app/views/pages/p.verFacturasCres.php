<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                Revision de Facturacion.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-verFacturas">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>Factura</th>
                                            <th>Fecha Factura</th>
                                            <th>Cliente</th>
                                            <th>SubTotal</th>
                                            <th>Impuestos</th>
                                            <th>Descuentos</th>
                                            <th>Total</th>
                                            <th>UUID</th>
                                            <th>RFC CLIENTE</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($facturas as $data): 
                                        ?>
                                       <tr>
                                            <td><?php echo $data->SERIE.$data->FOLIO;?></td>
                                            <td><?php echo $data->FECHA;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->SUBTOTAL;?></td>
                                            <td><?php echo $data->IVA;?></td>
                                            <td><?php echo $data->DESCUENTO;?></td>
                                            <td><?php echo $data->IMPORTE;?></td>
                                            <td><?php echo $data->UUID;?></td>
                                            <td><?php echo $data->CLIENTE;?></td>
                                             <td>
                                                <select  name="nstatus" required="required">
                                                    <option>--Elige Nuevo Status--</option>
                                                    <option value ="Reenviar">Guardar en SAE</option>
                                                    <option value ="Facturar">Rechazar Facturar</option>
                                                </select>
                                                <button>Ejecutar</button>
                                             </td>
                                             <td>
                                                 <a href="index.php?action=DetalleFactura&docf=<?php echo $sc->ID?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;"  class="btn btn-info" > Ver Factura</a>
                                             </td>
                                            </tr> 
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>

<script>
    function validarSelect(id){

        valorAduana = document.getElementById(id).value;
        select = document.getElementById('S'+id);
        //alert(valorAduana);
        switch (valorAduana){
            case 'Facturado':
                if(select.value == 'Reenviar'){
                    alert("No se puede Reenviar un documento facturado. Use Revisión o Deslinde");
                    select.selectedIndex = 0;
                }else if(select.value == 'Facturar'){
                    alert("No se puede Facturar un documento facturado. Use Revisión o Deslinde");
                    select.selectedIndex = 0;
                }else if(select.value == 'NC'){
                    alert("No se puede devolver un documento facturado. Use Revisión o Deslinde");
                    select.selectedIndex = 0;
                }else if(select.value == 'Acuse'){
                    alert("No se puede enviar acuse de un documento facturado. Use Revisión o Deslinde");
                    select.selectedIndex = 0;
                }
            break;
            
            case 'Devuelto':
            if(select.value == 'Reenviar'){
                    alert("No se puede Reenviar un documento devuelto. Use Revisión o Deslinde");
                    select.selectedIndex = 0;
                }else if(select.value == 'Facturar'){
                    alert("No se puede Facturar un documento devuelto. Use Revisión o Deslinde");
                    select.selectedIndex = 0;
                }else if(select.value == 'NC'){
                    alert("No se puede devolver un documento devuelto. Use Revisión o Deslinde");
                    select.selectedIndex = 0;
                }else if(select.value == 'Acuse'){
                    alert("No se puede enviar acuse de un documento devuelto. Use Revisión o Deslinde");
                    select.selectedIndex = 0;
                }
            break;

            case 'Acuse':
            if(select.value == 'Reenviar'){
                    alert("No se puede Reenviar un documento acuse. Use Revisión o Deslinde");
                    select.selectedIndex = 0;
                }else if(select.value == 'Facturar'){
                    alert("No se puede Facturar un documento acuse. Use Revisión o Deslinde");
                    select.selectedIndex = 0;
                }else if(select.value == 'NC'){
                    alert("No se puede devolver un documento acuse. Use Revisión o Deslinde");
                    select.selectedIndex = 0;
                }else if(select.value == 'Acuse'){
                    alert("No se puede enviar acuse de un documento que ta tiene acuse. Use Revisión o Deslinde");
                    select.selectedIndex = 0;
                }
            break;
            
            default:
            break;

        }// fin switch

    }// fin función 
</script>