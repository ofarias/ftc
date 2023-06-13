<br />
<br />
<div class="col-lg-12">
<form action="index.php" method="post">
<label for="articulo">Articulo: </label><br />
<input class="list-group-item" id="art" type="text" name="articulo">
<br />
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default text-center">
                    <div class="panel-heading">
                        <h3 class="panel-title">Proveedor 1</h3>
                    </div>
                    <div class="panel-body">
                        <input type="text" name="p1cr">
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item"><input type="text" name="p1ce"></li>
                        <li class="list-group-item"><input type="text" name="p1des"></li>
                        <li class="list-group-item"><input type="text" name="p1existe"></li>
                        <li class="list-group-item"><input type="text" name="p1campl1"></li>
                        <li class="list-group-item"><input type="text" name="p1campl2"></li>
                        <li class="list-group-item"><input type="text" name="p1campl3"></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default text-center">
                    <div class="panel-heading">
                        <h3 class="panel-title">Proveedor 2</h3>
                    </div>
                    <div class="panel-body">
                        <input type="text" name="p2cr">
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item"><input type="text" name="p2ce"></li>
                        <li class="list-group-item"><input type="text" name="p2des"></li>
                        <li class="list-group-item"><input type="text" name="p2existe"></li>
                        <li class="list-group-item"><input type="text" name="p2campl1"></li>
                        <li class="list-group-item"><input type="text" name="p2campl2"></li>
                        <li class="list-group-item"><input type="text" name="p2campl3"></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default text-center">
                    <div class="panel-heading">
                        <h3 class="panel-title">Proveedor 3</h3>
                    </div>
                    <div class="panel-body">
                        <input type="text" name="p3cr">
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item"><input type="text" name="p3ce"></li>
                        <li class="list-group-item"><input type="text" name="p3des"></li>
                        <li class="list-group-item"><input type="text" name="p3existe"></li>
                        <li class="list-group-item"><input type="text" name="p3campl1"></li>
                        <li class="list-group-item"><input type="text" name="p3campl2"></li>
                        <li class="list-group-item"><input type="text" name="p3campl3"></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /.row -->
</form>
</div>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <style>
  .ui-autocomplete-loading {
    background: white url("images/ui-anim_basic_16x16.gif") right center no-repeat;
  }
  </style>
<!--Script para autocompletar-->
<script>
  /*$(function() {
    /*function log( message ) {
      $( "<div>" ).text( message ).prependTo( "#log" );
      $( "#log" ).scrollTop( 0 );
    }*
 
    $( "#art" ).autocomplete({
      source: "app/controller/autocomp.php",
      //minLength: 2,
      select: function( event, ui ) {
        log( ui.item ?
          "Selected: " + ui.item.value + " aka " + ui.item.id :
          "Nothing selected, input was " + this.value );
      }
    });
  });*/
  
  </script>

 