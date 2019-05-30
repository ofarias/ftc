<p>
<div>&nbsp;</div>
</p>

<p>
    <b>Carga de Meta Datos del SAT.</b>
<form action="index.xml.php" method="post" enctype="multipart/form-data">
    <input type="file" id="filesToUpload" name="files[]" multiple="" onchange="makeFileList()" accept="text/plain" />
    <input type="hidden" name="UPLOAD_META_DATA" value="UPLOAD_META_DATA" />
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
 </script>

