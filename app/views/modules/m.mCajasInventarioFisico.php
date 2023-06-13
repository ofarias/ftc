<style>
<?php foreach ($cajas as $data): 
 if ($data->PROCESADO > 0){
    echo ".panel-body".$data->COTIZA."{ background-color: green;}";
 }elseif ($data->NEGATIVO > 0) {
    echo ".panel-body".$data->COTIZA."{ background-color: #b3b3ff;}";
 }
?>
<?php endforeach?>
</style>
<br/>
<br/>
<div>
    <button class="btn btn-success" onclick="cerrarInv()">Cerra Inventario</button>
</div>
<div class="container">
        <!-- Marketing Icons Section -->
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                    <!--<img src="app/views/images/logob.jpg">-->
                </h3>
            </div>
            <?php foreach ($cajas as $key ): ?>    
            <div class="col-md-3">
               <div class="panel panel-default">
                   <div class="panel-heading"> 
                       <h4><center><?php echo $key->COTIZA?></center></h4>
                   </div>
                   <div class="panel-body<?php echo $key->COTIZA?>" >
                       <center><label><?php echo number_format(($key->RECEPCION / $key->TOTAL)*100,2)?>  % </label></center>
                       <center>
                       <a href="index.php?action=invPatioDetalle&caja=<?php echo $key->COTIZA?>" class="btn btn-default" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;" ><img src="app/views/images/CajaAbierta_1.jpg"></a></center>
                   </div>
               </div>
           </div>
            <?php endforeach ?>
        </div>
    </div>
    


<form action="index.php" method="POST" id="cerrar">
    <input type="hidden" name="cierreInvPatio" value="">
    <input type="hidden" name="datos" value="" id="datosCierre">
</form>

<script type="text/javascript">
  function cerrarInv(){
    if(confirm('Esta Seguro de Cerrar el Inventario? se generaran los vales y ajustes necesarios')){
      var form = document.getElementById('cerrar');
      form.submit();
    }
  }

</script>