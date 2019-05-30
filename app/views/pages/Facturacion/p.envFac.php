<br/>
<div class="row">
    <div class="container">
    <div class="form-horizontal col-lg-12">
        <div class="panel panel-default">
            <div class="panel panel-heading">
                <h3>Envio de factura por correo</h3>
            </div>
            <br />
            <div class="panel panel-body">
                <form action="index.cobranza.php" method="post" id="formdoc">
                        <div class="form-group">
                            <label for="descripcion" class="col-lg-2 control-label">Direccion de Correo:</label>
                                <div class="col-lg-8">
                                    <input type="email"  class="form-control" multiple list autocomplete name="correo" placeholder="Correo para mas de 2 separar con comas , " required value="<?php echo $fact->CORREO?>"/><br>
                                </div>
                        </div>
                       <div class="form-group">
                            <label for="descripcion" class="col-lg-2 control-label"></label>
                                <div class="col-lg-8">
                                    <?php echo '<b>Documento:</b> '.$fact->CVE_DOC.' <b>Cliente: </b>'.$fact->NOMBRE?><br/>
                                    <?php echo !empty($fact->CORREO)? 'Correo Predeterminado'.$fact->CORREO:''?>
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="descripcion" class="col-lg-2 control-label">Mensaje: </label>
                                <div class="col-lg-8">
                                    <textarea  class="form-control" name="mensaje" placeholder="Escriba aqui el mensaje." required cols="100" rows="5"></textarea><br>
                                </div>
                        </div>
                    <input type="hidden" name="docf" value="<?php echo $fact->CVE_DOC?>">
                   </form>
                </div>
            <div>
                <!-- Submit Button  -->
                <div class="panel-footer">
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button name="enviarFact" type="submit" value="enviar" class="btn btn-success" form="formdoc">Enviar<i class="fa fa-floppy-o"></i></button>
                            <button class="btn btn-danger" onclick="c()">Cancelar<i class="fa fa-times"></i></button>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
        <br/>
    </div>
    </div>
</div>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript">
    function c(){
        window.close();
    }

    $("#per1").autocomplete({
        source: "index.v.php?cliente=1",
        minLength: 4,
        select: function(event, ui){
        }
    })

    $("#uni1").autocomplete({
        source: "index.v.php?unidad=1",
        minLength: 3,
        select: function(event, ui){
        }
    })

    $("#clie1").autocomplete({
        source: "index.v.php?cliente=1",
        minLength: 3,
        select: function(event, ui){
        }
    })


</script>