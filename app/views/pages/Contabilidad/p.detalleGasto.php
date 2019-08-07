<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        <b>Informacion del Egreso / Cargo</b>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Pago</th>
                                            <th>Fecha Creacion</th>
                                            <th><font color="blue">Referencia</font> <br/><font color ="red">Observacion</font></th>
                                            <th>Fecha Edo Cta</th>
                                            <th>Usuario</th>
                                            <th>Proveedor</th>
                                            <th>Importe</th>
                                            <th>Aplicado</th>
                                            <th style="background-color:'#ccffe6'">Saldo</th>
                                            <th>Contabilizar</th> 
                                           
                                       </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        $total = 0;
                                            $color="";
                                            foreach ($datos as $key):
                                            $idp = $key->ID; 
                                        ?>
                                        <tr class="odd gradeX" <?php echo $color ?> >
                                            <input type="hidden" name="saldoPago" value="<?php echo $key->SALDO?>" id="sp">
                                            <td> <?php echo $key->ID ?> </td>
                                            <td><?php echo $key->FECHA_CREACION?></td>
                                            <td><?php echo '<font color="blue">'.$key->REFERENCIA.'</font><br/><font color="red">'.$key->DOC.'</font>'?></td>
                                            <td><?php echo $key->FECHA_EDO_CTA;?> </td>
                                            <td><?php echo $usuario;?></td>
                                            <td><?php echo $key->PROV;?></td>
                                            <td><?php echo '$ '.number_format($key->TOTAL,2);?> </td>
                                            <td><?php echo '$ '.number_format($key->APLICADO,2);?> </td>
                                            <td><?php echo '$ '.number_format($key->SALDO,2);?></td>
                                            <td>
                                                <?php if(empty($key->CONTABILIZADO)){?>
                                                <input type="button" class="btn btn-success conta" value="Contabilizar" idp = "<?php echo $key->ID?>" val="<?php echo $key->SALDO?>">
                                            <?php }else{?>
                                               <b><?php echo $key->CONTABILIZADO?></b>
                                            <?php }?>
                                            </td>
                                        </tr>
                                        </form>
                                        <?php endforeach; ?>
                                 </tbody>
                                 
                                </table>
                            </div>
                      </div>
            </div>
        </div>
</div>
<br/>
<?php if(count($aplicaciones)>0){?>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        <b>Facturas Aplicadas</b>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Aplicacion</th>
                                            <th>Fecha Edo Cta</th>
                                            <th>Usuario</th>
                                            <th>Documento</th>
                                            <th>Proveedor</th>
                                            <th>Aplicado</th>
                                            <th>Cancelar </th>
                                       </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        $total = 0;
                                            $color="";
                                            foreach ($aplicaciones as $app):
                                            $color= $app->STATUS==0? 'blue':'red'; 
                                            $color2 = $color=='red'? 'lightsalmon':'lawngreen';
                                        ?>
                                        <tr class="odd gradeX" style='background-color:<?php echo $color2?>;'">
                                            <td><?php echo $app->ID?></td>
                                            <td><?php echo $app->FECHA?></td>
                                            <td><?php echo $app->USUARIO?></td>
                                            <td><?php echo $app->DOCUMENTO.'<br/>'.$app->UUID;?> </td>
                                            <td><?php echo $app->PROV;?><br/><a href="index.php?action=verXML&uuid=<?php echo $app->UUID?>&ide=Recibidos" class="btn-sm btn-info" target="popup" onclick="window.open(this.href, this.target, 'width=1800,height=1320'); return false;"> Clasificar UUID</a></td>
                                            <td align="right"><font color="<?php echo $color?>"><b><?php echo '$ '.number_format($app->APLICADO,2);?></b></font> </td>
                                            <td>
                                                <?php if($app->STATUS == 0 and empty($key->CONTABILIZADO)){?>
                                                <input type="button" class="btn btn-danger canapl" name="can" value="Cancelar" d="<?php echo $app->ID?>" val="<?php echo $app->APLICADO?>" ida="<?php echo $app->ID?>" uuid="<?php echo $app->UUID?>" idp="<?php echo $app->IDG?>"></td>
                                            <?php }else{?>
                                                <input type="button" class="btn btn-danger canapl" name="can" value="Cancelado" disabled ><br/><b><?php echo 'Poliza: '.$key->CONTABILIZADO?></b></td>
                                            <?php }?>
                                            <td></td>
                                        </tr>
                                        </form>
                                        <?php endforeach; ?>
                                 </tbody>
                                 <tfoot>
                                     <td></td>
                                     <td></td>
                                     <td></td>
                                     <td></td>
                                     <td></td>
                                     <td></td>
                                     <td></td>
                                     <td align="left" style="font-size: 20px"></td>
                                     <td align="right" style="font-size: 20px; color:blue"></td>
                                 </tfoot>
                                </table>
                            </div>
                      </div>
            </div>
        </div>
</div>
<?php }?>
<div>
    <label>Buscar Pagos </label> <br/>
    <label>Busqueda por Monto o Folio </label><br/>
    <form action="index.cobranza.php" method="post">
        <input type="hidden" name="items" value="<?php echo $items?>">
        <input type="hidden" name="total" value="<?php echo $total?>">
        <input type="hidden" name="seleccion_cr" value="<?php echo $seleccion_cr?>">
        <input type="text" name="pagos" placeholder="Buscar" required="required">
        <input type="hidden" name="retorno" value="<?php echo $retorno?>">
        <button name="FORM_ACTION_PAGO_FACTURAS_NUEVO" type="submit" value="enviar" class = "btn btn-info"> Buscar </button>    
    </form>
</div>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <p>Facturas Pendientes de Pago:</p>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>UUID</th>
                                            <th>Proveedor</th>
                                            <th>Fecha Edo de Cta</th>
                                            <th>Monto </th>
                                            <th>Aplicado</th>
                                            <th>Saldo Actual</th>
                                            <th>Aplicar</th>
                                            <th>Saldo Pago</th>
                                            <th>Guardar</th>
                                       </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php foreach ($facturas as $f): 
                                            $color='';
                                            if($key->SALDO == $f->IMPORTE){
                                                $color="style='background-color:green;'";
                                            }
                                            $saldo = $f->IMPORTE - $f->APLICADO;
                                        ?>
                                        <tr class="odd gradeX" <?php echo $color ?> >
                                            <td> <?php echo $f->UUID?>&nbsp;&nbsp;&nbsp;<a href="index.php?action=verXML&uuid=<?php echo $f->UUID?>&ide=Recibidos" class="btn-sm btn-info" target="popup" onclick="window.open(this.href, this.target, 'width=1800,height=1320'); return false;"> Clasificar UUID</a><br/><?php echo $f->DOCUMENTO?> </td>
                                            <td><?php echo $f->PROV?></td>
                                            <td><?php echo $f->FECHA;?> </td>
                                            <td><?php echo '$ '.number_format($f->IMPORTE,2);?></td>
                                            <td><?php echo '$ '.number_format($f->APLICADO,2);?> </td>
                                            <td>
                                                <label id="s_<?php echo $f->UUID?>" val="<?php echo number_format($saldo,2,".","")?>" class="saldar" u="<?php echo $f->UUID;?>" idp="<?php echo $idp?>"><?php echo '$ '.number_format($saldo,2);?></label> </td>
                                            <td>
                                                <input type="number" step="any" name="aplicar" value="0.00" max="<?php echo $saldo?>" min=".01" id="val_<?php echo $f->UUID?>" class="suma" val="<?php echo number_format($saldo,2,".","")?>" u="<?php echo $f->UUID;?>" idp="<?php echo $idp?>">
                                            </td>
                                            <td>
                                                <p id="sp_<?php echo $f->UUID?>"></p>
                                            </td>
                                            <td>
                                                <input type="button" id="<?php echo $f->UUID?>" value="Guardar" class="save" v="<?php echo $f->UUID?>" disabled>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
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
    
    $(".canapl").click(function(){
        alert('Cancela la Aplicacion')
        var valor = $(this).attr('val')
        var uuid = $(this).attr('uuid')
        var ida = $(this).attr('ida')
        var idp = $(this).attr('idp')
        
        $.confirm({
            title:'Cancelar Aplicacion',
            content: function(){
                var self = this
                self.setContent('revisa el flujo de la llamada')
                return  $.ajax({
                            url:'index.php',
                            type:'post',
                            dataType:'json',
                            data:{canapl:1, idp, ida, valor, uuid}
                        }).done(function(response){
                            self.setContentAppend('<div>Done</div>')
                        }).fail(function(){
                            self.setContentAppend('<div>Fail</div>')
                        }).always(function(){
                            self.setContentAppend('<div>Always</div>')
                            location.reload(true)
                        })
            }, 
            contentLoaded:function(data, status, xhr){
                self.setContentAppend('<div>Content loaded!</div>');
            },
            onContentReady:function(){
                this.setContentAppend('<div>Content Listo</div>')
            }
        })
    });

    $(".save").click(function(){
        var uuid = $(this).attr('v')
        var valor = parseFloat(document.getElementById('val_'+uuid).value)
        var saldo = parseFloat(document.getElementById('s_'+uuid).getAttribute('val'))
        if(valor <= saldo){
            var idp = document.getElementById('s_'+uuid).getAttribute('idp')
            //alert('Pasa' + idp)
            $.ajax({
                url:'index.php',
                type:'post',
                dataType:'json',
                data:{aplicaGasto:1,idp, uuid, valor},
                success:function(data){
                    if(data.status == 'no'){
                        alert(data.mensaje)
                    }else{
                        location.reload(true)
                    }
                },
                error:function(data){
                    alert('No se realizo la aplicacion'+data.mensaje)
                }
            })
        }else{
            alert('Favor de revisar la informacion')
        }
    })

    $(".suma").change(function(){
        var saldo = parseFloat($(this).val())
        var saldoPago = parseFloat(document.getElementById('sp').value)
        var uuid = $(this).attr('u')
        document.getElementById('val_'+uuid).value= saldo
        if(saldo > saldoPago){
            saldo = saldoPago
        }
        var saldoIns = saldoPago - saldo  
        //alert('Saldo insoluto ' + saldoIns)
        if(saldoIns >= 0){
            document.getElementById('val_'+uuid).value=saldo
            $("#"+uuid).prop('disabled',false)
        }else{
            document.getElementById('val_'+uuid).value=saldoPago
            saldoIns = saldo-saldoPago 
            $("#"+uuid).prop('disabled',false)
        }
        document.getElementById('sp_'+uuid).innerHTML=saldoIns
    })

    $(".saldar").click(function(){
        var saldo = $(this).attr('val')
        var saldoPago = document.getElementById('sp').value
        var uuid = $(this).attr('u')
        document.getElementById('val_'+uuid).value= saldo
        var saldoIns = saldoPago - saldo  
        if(saldoIns >= 0){
            $("#"+uuid).prop('disabled',false)
        }else{
            document.getElementById('val_'+uuid).value=saldoPago
            saldoIns = saldo-saldoPago 
            $("#"+uuid).prop('disabled',false)
        }
        document.getElementById('sp_'+uuid).innerHTML=saldoIns 
    })

    $(".conta").click(function(){
        var saldo = parseFloat($(this).attr('val'))
        if(saldo > 0){
            if(!confirm('Contabiliza el Gasto sin ser saldado?')){       
                return false;
            }
        }
        var tipo ='gasto'
        var idp =  $(this).attr('idp')
        $.confirm({
            title: 'Contabilizar Pago',
            content:function(){
                var self = this
                self.setContent('Contabiliza Gasto')
                return $.ajax({
                    url:'index.coi.php',
                    type:'post', 
                    dataType:'json', 
                    data:{contabiliza:1, tipo, idp}
                }).done(function(response){
                    self.setContentAppend('<div>Done</div>')
                }).fail(function(){
                    self.setContentAppend('<div>Fail</div>')
                }).always(function(){
                    self.setContentAppend('<div>Always</div>')
                    location.reload(true)
                })
            }, 
            contentLoaded:function(data, status, xhr){
                self.setContentAppend('<div>Content loaded!</div>');
            },
            onContentReady:function(){
                this.setContentAppend('<div>Content Listo</div>')
            }   
        })
    });

</script>

