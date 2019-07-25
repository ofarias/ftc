<br/>
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
</head>
<?php header("Content-Type: text/html;charset=utf-8");?>
<?php foreach ($info as $b):
?>
<div class="row">
    <div class="container">
    <div class="form-horizontal col-lg-12">
        <div class="panel panel-default">
            <div class="panel panel-heading">
                <h3>Edicion de Cuenta Bancaria.</h3>
            </div>
            <br />
            <div class="panel panel-body">
                <form action="index.coi.php" method="post" id="form1">
                    <input type="hidden" name="idb" value="<?php echo $b->ID?>">
                    <div class="form-group">
                        <label for="cliente" class="col-lg-2 control-label">Banco: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="banco" value="<?php echo $b->BANCO;?>" readonly="true"/><br>
                            </div>
                    </div>     
                    <div class="form-group">
                        <label for="add_usuario" class="col-lg-2 control-label">No de Cuenta: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="cuenta" id="usuario" placeholder="Numero de Cuenta" required = "required" maxlength="30" value="<?php echo $b->NUM_CUENTA?>" /><br>
                            </div>
                    </div>

                    <div class="form-group">
                        <label for="add_usuario" class="col-lg-2 control-label">Clave: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" readonly id="usuario" placeholder="Clave SAT"  value="<?php echo $b->CLAVE?>"  /><br>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="add_usuario" class="col-lg-2 control-label">RFC: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="int" id="usuario" placeholder="Numero Interior" required = "required" maxlength="30" value="<?php echo $b->RFC?>"/><br>
                            </div>
                    </div>
                                        <div class="form-group">
                        <label for="add_usuario" class="col-lg-2 control-label">Razon Socila: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="col" id="usuario" placeholder="Colonia" required = "required" maxlength="30" value="<?php echo utf8_decode($b->FISCAL) ?>"  /><br>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="add_usuario" class="col-lg-2 control-label">Nombre Comercial: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="del" id="usuario" placeholder="Delegacion o Municipio" required = "required" maxlength="30" value="<?php echo html_entity_decode($b->COMERCIAL)?>"  /><br>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="add_usuario" class="col-lg-2 control-label">Dia de Corte: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="dia" id="usuario" placeholder="Dia de corte" required maxlength="30" value="<?php echo $b->DIA_CORTE?>" /><br>
                            </div>
                    </div>

                    <div class="form-group">
                        <label for="add_usuario" class="col-lg-2 control-label">Saldo Inicial: </label>
                            <div class="col-lg-8">
                                <input type="number" step="any" class="form-control" name="si" id="usuario" placeholder="Saldo Inicial" required  value="<?php echo $b->SALDOI?>"  /><br>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="add_usuario" class="col-lg-2 control-label">Tipo de Cuenta: </label>
                            <div class="col-lg-8">
                                <input type="text" maxlength="20" class="form-control" name="tipo"  placeholder="Tipo de cuenta" required  value="<?php echo $b->TIPO?>"/><br>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="add_usuario" class="col-lg-2 control-label">Cuenta Contable: </label>
                            <div class="col-lg-8" title="Esta Informacion se colocara en las polizas de Ingresos y Egresos">
                                <input type="text" name="cc" class="cuencont form-control" placeholder="<?php echo isset($b->CTA_CONTAB)? $b->CTA_CONTAB:'Cuenta Contable';?>" orig="<?php echo $b->CTA_CONTAB?>" id="<?php echo $b->ID?>">
                               <br>
                            </div>
                    </div>             
        </form>
            </div>
                <div class="panel-footer">
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button name="editaBanco" type="submit" class="btn btn-warning" form="form1">Guardar<i class="fa fa-floppy-o"></i></button>
                        </div>
                    </div>
                </div>
                </div>
        </div>
    </div>
</div>
<?php endforeach?>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script>
    
    $(".cuencont").autocomplete({
        source: "index.coi.php?cuentas=1",
        minLength: 3,
        select: function(event, ui){
        }
    })

    $(".cuencont").change(function(){
        var idc = $(this).attr('id')
        var c = $(this).attr('orig')
        var i = $(this).attr('id')
        var n = $(this).val()
        //alert('Este es el valor original '+c+' del ID '+ i + ' y este es el valor enviado' +n )
        var a=n.split(":")
        var ncta = a[7]
        $(this).val(ncta)
        ///if(confirm('Desea consevar los cambios? Anterior: '+ c + ' Nueva: '+ ncta)){
        ///    $.ajax({
        ///        url:'index.coi.php',
        ///        type:'post',
        ///        dataType:'json',
        ///        data:{actCuentaImp:ncta, idc},
        ///        success:function(data){
        ///            alert(data.mensaje)
        ///            location.reload(true)
        ///        },
        ///        error:function(data){
        ///            alert('Ocurrio un error, favor de revisar los datos.')
        ///            location.reload(true)
        ///        }
        ///    })
        ///}else{
        ///        alert('No se realizo ningun cambio')
        ///        location.reload(true)
        ///    }
    })


</script>