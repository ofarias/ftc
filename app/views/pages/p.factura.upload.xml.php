<p>
<div>&nbsp;</div>
</p>

<p>
    <b>Carga multiple de archivos de facturas (XML).</b>
<form action="index.php" method="post" enctype="multipart/form-data">
    <input type="file" id="filesToUpload" name="files[]" multiple="" onchange="makeFileList()" accept="text/xml" />
    <input type="hidden" name="FORM_ACTION_FACTURAS_UPLOAD" value="FORM_ACTION_FACTURAS_UPLOAD" />
    <input type="hidden" name="files2upload" value="" />
    <input type="submit" value="Inicar Carga"/>
    <input type="hidden" value="<?php echo $tipo?>" name="tipo">
</form>
</p>
<p>
<ul id="fileList">
    <li>No hay archivos seleccionados</li>        
</ul>
</p>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">
    function makeFileList() {
            var input = document.getElementById("filesToUpload");
            var ul = document.getElementById("fileList");
            while (ul.hasChildNodes()) {
                    ul.removeChild(ul.firstChild);
            }
            for (var i = 0; i < input.files.length; i++) {
                    var li = document.createElement("li");
                    li.innerHTML = input.files[i].name;
                    ul.appendChild(li);
            }
            if(!ul.hasChildNodes()) {
                    var li = document.createElement("li");
                    li.innerHTML = 'No hay archivos selccionados.';
                    ul.appendChild(li);
            }
            document.getElementById("files2upload").value = input.files.length;
    }
  //Cuando la página esté cargada completamente
  $(document).ready(function(){
    //Cada 10 segundos (10000 milisegundos) se ejecutará la función refrescar
    //setTimeout(refrescar, 10000);
  });
  function refrescar(){
    //Actualiza la página
    location.reload();
  }
 </script>

