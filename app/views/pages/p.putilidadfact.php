<br><br>
<div class="form-horizontal">
<div class="panel panel-default">
    <div class="panel panel-heading">
        <h4>Busqueda</h4>
    </div>
<div class="panel panel-body">
        
        <form action="index.php" method="get"> 
            <div class ="form-group">
                <label for="fechaini" class="col-lg-1 control-label">Fecha Inicial: </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" id="datepicker2" name="fechaini"/>   
                    </div>
                <label for="fechafin" class="col-lg-1 control-label">Fecha Final: </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" id="datepicker1" name="fechafin"/>   
                    </div>
            </div>

            <div class="form-group">
                <label for="rangoutil" class="col-lg-1 control-label">Rango Utilidad: </label>
                    <div class="col-lg-3">
                        <select name="rangoutil" class="form-control">
                            <option value=">=">Mayor o igual</option>
                            <option value="<=">Menor o igual</option>
                        </select>   
                    </div>
                <label for="utilidad" class="col-lg-1 control-label">al %</label>    
                <div class="col-lg-3">
                    <input type="number" step="any" min=-100 max=100 name="utilidad" class="form-control" required="true">
                </div>
            </div>
            
            <div class="form-group">
                <label for="letras" class="col-lg-1 control-label">Letras</label>    
                <div class="col-lg-3">
                    <input type="text" maxlength="11" name="letras" class="form-control" pattern="[A-Z',]+$">
                </div> 
                <div class=" text text-info">
                    <i class="fa fa-info-circle"></i><em>Elegir un máximo de 6 letras mayúsculas, entre apostrofe ' o dejar vacío para todos. Separar las letras con comas "," y no utilizar espacios. <br>Ejemplo 1: 'A'  Ejemplo 2: 'A','K','R'</em>
                </div>
            </div>
            
            <div class="form-group">
                <label for="status" class="col-lg-1 control-label">Status</label>    
                <div class="col-lg-3">
                    <input type="text" maxlength="7" name="status" id="status" class="form-control" pattern="('E'|'C'|'E','C'|'C','E')" onkeyup="convertirCadena()">
                </div> 
                <div class=" text text-info">
                    <i class="fa fa-info-circle"></i><em>Elegir un máximo de 2 status 'E' = emitido, 'C' = cancelado, mayúsculas entre apostrofe ' o dejar vacío para todos. Separar las letras con comas "," y no utilizar espacios. <br>Ejemplo 1: 'C','E' Ejemplo 2: 'E'</em>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-1 col-sm-10">
                    <button type="submit" value="utilidadFacturas" name="action" class="btn btn-info">Buscar <i class="fa fa-search"></i></button>
                 </div>
            </div>
        </form>
    </div>
</div>
</div>

<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Facturación
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Factura</th>
                                            <th>Status</th>
                                            <th>Pedido</th>
                                            <th>NC</th>
                                            <th>Vendedor</th>
                                            <th>Clave</th>
                                            <th>Nombre</th>
                                            <th>RFC</th>
                                            <th>Fecha Documento</th>
                                        <!--    <th>IVA</th> -->
                                            <th>Importe</th>
                                            <th>Costo</th>
                                            <th>$ Utilidad</th>
                                            <th>% Utilidad</th>
                                            <th>Importe Total</th>
                                            <th>Cobrado</th>
                                            <th>Saldo</th>
                                            <th>Fecha ven</th>
                                            >
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <?php foreach($total as $data):
                                           if($data->UTILIDADP == 100){
                                                $color = " #E7AE18";
                                            }else{
                                                if($data->UTILIDADP < 0) $color = "#FF4000";
                                                    elseif($data->UTILIDADP > 0 && $data->UTILIDADP < 25) $color = "#81BEF7";
                                                        elseif($data->UTILIDADP >= 25) $color ="#04B431";
                                            }    
                                        ?>
                                        <tr style="background-color:<?php echo $color;?>">
                                            <td colspan="9"></td>
                                            <td class="text-right"><?php echo "$ ". number_format($data->IMPORTE,2,".",",");?></td>
                                            <td class="text-right"><?php echo "$ ". number_format($data->COSTO,2,".",",");?></td>
                                            <td class="text-right"><?php echo "$ ". number_format($data->UTILIDAD_MONTO,2,".",",");?></td>
                                            <td class="text-right"><?php echo number_format($data->UTILIDADP,2,".",",");?></td>
                                            <td class="text-right"><?php echo "$ ". number_format($data->IMPORTE_TOTAL,2,".",",");?></td>
                                            <td class="text-right"><?php echo "$ ". number_format($data->COBRADO,2,".",",");?></td>
                                            <td class="text-right"><?php echo "$ ". number_format($data->SALDO,2,".",",");?></td>
                                        </tr>
                                        <?php endforeach;?>
                                    </tfoot>
                                  <tbody>
                                        <?php
                                            foreach ($exec as $data): 
                                            if($data->STATUS === 'C'){
                                                $color2 = '#ff1a1a';
                                            }else{$color2 = '';}
                                        ?>
                                       <tr style="background-color:<?php echo $color2;?>">
                                            <td><a href="index.php?action=utilidadXfactura&fact=<?php echo $data->CVE_DOC;?>"><?php echo $data->CVE_DOC;?></a></td>
                                            <td><?php echo $data->STATUS;?></td>
                                            <td><?php echo $data->PEDIDO;?></td>
                                            <td><a href="index.php?action=utilidadXfactura&fact=<?php echo $data->NC;?>"><?php echo $data->NC;?></a></td>
                                            <td><?php echo substr($data->PEDIDO,1,1);?></td>
                                            <td><?php echo $data->CVE_CLPV;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->RFC;?></td>
                                            <td><?php echo $data->FECHA_DOC;?></td>
                                        <!--    <td><?php echo $data->IMP_TOT4;?></td> -->
                                            <td class="text-right"><?php echo "$ ". number_format($data->CAN_TOT,2,".",",");?></td>
                                            <td class="text-right"><?php echo "$ ". number_format($data->COSTO,2,".",",");?></td>
                                            <td class="text-right"><?php echo "$ ". number_format($data->MONTO_UTILIDAD,2,".",",");?></td>
                                            <td class="text-right"><?php echo $data->UTILIDAD;?></td>
                                            <td class="text-right"><?php echo "$ ". number_format($data->IMPORTE_TOTAL,2,".",",");?></td>
                                            <td class="text-right"><?php echo "$ ". number_format($data->COBRADO,2,".",",");?></td>
                                            <td class="text-right"><?php echo "$ ". number_format($data->SALDO,2,".",",");?></td>
                                            <td><?php echo $data->FECHA_VENCIMIENTO;?></td>
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

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker1" ).datepicker({dateFormat: 'dd-mm-yy'});
    $( "#datepicker2" ).datepicker({dateFormat: 'dd-mm-yy'});   
  } );
  
 /* function convertirCadena(){
      var status = document.getElementById("status");
      var letras = status.value.split(",");
      var letras1 = ["E","C","e","c"];
      var lastchain = "";
      for(var i = 0; i < letras.length; i++){
          for(var e = 0; e < letras1.length; e++){
              if(letras[i] == letras1[e]){
                  lastchain = "'" + letras[i] + "'"
              }
          }
         
      }
  } */


  
  </script>