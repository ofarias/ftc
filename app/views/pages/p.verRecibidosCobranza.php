<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                Ruta Cobranza
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-verFacturas">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>Factura</th>
                                            <th>Vencimiento</th>
                                            <th>Cliente</th>
                                            <th>Importe</th>
                                            <th>Saldo</th>
                                            <th>Docs en Cobranza</th>
                                            <th>Prorroga</th>
                                            <th>Folio Cierre</th>
                                            <th>Cartera</th>
                                            <th>Contra Recibo</th>
                                            <th>Secuencia</th>
                                            
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($recibidos as $data): 
                                        ?>
                                       <tr>
                                            <td><?php echo $data->FACTURA;?></td>
                                            <td><?php echo $data->FECHA_VENCIMIENTO?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo '$ '.number_format($data->IMPORTE,2);?></td>
                                            <td><?php echo '$ '.number_format($data->SALDOFINAL,2);?></td>
                                            <td><?php echo $data->DOCS_COBRANZA;?></td>
                                            <td><?php echo $data->PRORROGA;?></td>
                                            <td><?php echo $data->FOLIO_REC_COBRANZA;?></td>
                                            <td><?php echo $data->CC;?></td>
                                            <td><?php echo $data->CREC;?></td>
                                            <form action="index.php" method ="post">
                                            <td>
                                                <input type="number" name="secuencia" placeholder="secuencia" value="<?php echo $data->SECUENCIA?>" required="required">
                                                <input type="hidden" name="idc" value="<?php echo $data->ID?>">
                                                <button name="guardaSecuencia" value="enviar" type="submit"> <i class="fa fa-save"></i></button>
                                            </td>
                                            </form>
                                        </tr> 
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>

                            <!-- /.table-responsive -->
                      </div>
                      <label>Pendientes por imprimir: <?php echo $habilitaImpresion;?> </label>
                      <form action = "index.php" method="post">
                        <button name= "impRutaCobranza" value = "enviar" class="btn btn-warning" <?php echo  (($habilitaImpresion>=1)? '':'disabled') ?>  id="gccr" > Imprimir Ruta </button>  
                      </form>
                        
            </div>
        </div>
</div>

<script>

    document.getElementById("gccr").addEventListener("click",function(){    //función para recargar la pagina al enviar form
        setTimeout(function(){ window.location.reload(); }, 45000);          // uwu algún día usaremos ajax.. pero no aquí
    });

</script>