<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                Por Cobrar Semanal .
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-verFacturas">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>Clave Maestro</th>
                                            <th>Nombre Maestro</th>
                                            <th>Cartera</th>
                                            <th>Saldo Vencido 1 a 7 dias</th>
                                            <th>Ver</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($semanal as $data):
                                        ?>
                                       <tr style="background-color:#CEE3F6" >
                                            <td><?php echo $data->CVE_MAESTRO;?></td>
                                            <td><?php echo $data->NOMBRE_MAESTRO;?></td>
                                            <td><?php echo $data->CARTERA;?></td>
                                            <td  align="right"><?php echo '$ '.number_format($data->SALDO,2);?></td>
                                            <form action = "index.php" method="post">
                                            <td>
                                                <input type="hidden" name="maestro" value="<?php echo $data->CVE_MAESTRO?>">
                                                <input type="hidden" name="status" value="1">
                                                <button value="enviar" type="submit" name="verInd" class="btn btn-info"> Ver </button>
                                            </td>
                                           </form>
                                        </tr> 
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
    </div>
</div>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                En Cobranza Restriccion.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-verFacturas">
                                    <thead>
                                        <tr>
                                            <th>Clave Maestro</th>
                                            <th>Nombre Maestro</th>
                                            <th>Cartera</th>
                                            <th>Saldo Vencido 8 a 22 dias</th>
                                            <th>Ver Detalle</th>
                                            <th>Solicitar Prorroga (7dias)</th>
                                            <th>Restringuir</th>
                                            <th>Bloquear</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($restriccion as $data):
                                        ?>
                                       <tr style="background-color:#F3E2A9">
                                            <td><?php echo $data->CVE_MAESTRO;?></td>
                                            <td><?php echo $data->NOMBRE_MAESTRO;?></td>
                                            <td><?php echo $data->CARTERA;?></td>
                                            <td align="right" ><?php echo '$ '.number_format($data->SALDO,2);?></td>
                                           <form action = "index.php" method="post">
                                            <td>
                                                <input type="hidden" name="maestro" value="<?php echo $data->CVE_MAESTRO?>">
                                                <input type="hidden" name="status" value="2">
                                                <button value="enviar" type="submit" name="verInd" class="btn btn-info"> Ver </button>
                                            </td>
                                            <td>
                                                <button name="solProrroga" type="submit" value="enviar" class="btn btn-success">Prorroga</button>
                                            </td>
                                            <td>
                                                <button name="restringuir" type="submit" value="enviar" class="btn btn-warning">Restringuir</button>
                                            </td>
                                            <td>
                                                <button name="bloquear" type="submit" value="enviar" class="btn btn-danger" >Bloquear</button>
                                            </td>
                                           </form>
                                        </tr> 
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                      </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                En Cobranza Extra Judicial.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-verFacturas">
                                    <thead>
                                        <tr>
                                            <th>Clave Maestro</th>
                                            <th>Nombre Maestro</th>
                                            <th>Cartera</th>
                                            <th>Saldo Vencido 23 a 53 dias</th>
                                            <th>Ver</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($extrajudicial as $data):
                                        ?>
                                       <tr style="background-color:#FA5858">
                                            <td><?php echo $data->CVE_MAESTRO;?></td>
                                            <td><?php echo $data->NOMBRE_MAESTRO;?></td>
                                            <td><?php echo $data->CARTERA;?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->SALDO,2);?></td>
                                          <form action = "index.php" method="post">
                                            <td>
                                                <input type="hidden" name="maestro" value="<?php echo $data->CVE_MAESTRO?>">
                                                <input type="hidden" name="status" value="4">
                                                <button value="enviar" type="submit" name="verInd" class="btn btn-info"> Ver </button>
                                            </td>
                                             <td>
                                                <button name="restringuir" type="submit" value="enviar" class="btn btn-warning">Restringuir</button>
                                            </td>
                                            <td>
                                                <button name="bloquear" type="submit" value="enviar" class="btn btn-danger" >Bloquear</button>
                                            </td>
                                           </form>
                                        </tr> 
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                      </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                En Cobranza Legal.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-verFacturas">
                                    <thead>
                                        <tr>
                                            <th>Clave Maestro</th>
                                            <th>Nombre Maestro</th>
                                            <th>Cartera</th>
                                            <th>Saldo Vencido a mas de 53 dias</th>
                                            <th>Ver</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($judicial as $data):
                                        ?>
                                       <tr style="background-color: #FFFF00">
                                            <td><?php echo $data->CVE_MAESTRO;?></td>
                                            <td><?php echo $data->NOMBRE_MAESTRO;?></td>
                                            <td><?php echo $data->CARTERA;?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->SALDO,2);?></td>    
                                          <form action = "index.php" method="post">
                                            <td>
                                                <input type="hidden" name="maestro" value="<?php echo $data->CVE_MAESTRO?>">
                                                <input type="hidden" name="status" value="5">
                                                <button value="enviar" type="submit" name="verInd" class="btn btn-info"> Ver </button>
                                            </td>
                                           </form>
                                        </tr> 
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                      </div>
            </div>
        </div>
    </div>
</div>

<script>
</script>