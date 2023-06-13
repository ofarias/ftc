<br/>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Busqueda de Ordenes de Compra para colocar en Edo de Cuenta.
                        </div>
<br />
<div class="row">
    <br />
</div>
<div class="row">
    <div class="col-md-6">
        <form action="index.php" method="post">
        <div class="form-group">
            <input type="text" name="campo" class="form-control" required="required" placeholder="Buscar Numero u Orden de compra"> <br/>
            <input type="hidden" name="fechaedo" value ="<?php echo $fechaedo;?>">
            <label> Ejemplo: para encontrar la Orden de compra OC1010, puede buscar por 1010 o OC o OC1010 o oc1010.</label>
        </div>
          <button type="submit" value = "enviar" name = "traeOC" class="btn btn-info">Buscar OC</button>
        </form>
    </div>
</div>
<br />



