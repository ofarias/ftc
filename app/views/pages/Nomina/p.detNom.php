<br/>
	<br/><br/>
    	<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        Detalle de la nomina del <?php echo $fi?> al <?php echo $ff?>
                        <br/><br/> <input type="button" class="btn-sm btn-success repNom" value="Exportar a Excel"> &nbsp;&nbsp; <input type="button" class="btn-sm btn-primary comparar" value="Comparar Excel" > <br/><br/>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-detnom">
                                    <thead>
                                        <tr role="row">
                                            <!--<th class="details-control sorting_disabled" ></th>-->
                                            <th>UUID</th>
                                            <th>Nombre <br/>Empleado</th>
                                            <th>Numero <br/>Empleado</th>

                                            <?php for ($i=3; $i < count($columnas); $i++){ $column=explode(":", $columnas[$i]);?>
                                                <?php if($column[0] == 'P'){?>
                                                <th>
                                                    <?php   for ($b=0; $b < count($column) ; $b++) { 
                                                                if($b==0){
                                                                    echo $column[$b]=='P'? 'Percepción<br/>':'Deducción<br/>';
                                                                }elseif($b==1){
                                                                    echo 'Tipo SAT : '.$column[$b].'<br/>';
                                                                }elseif ($b==2){
                                                                    echo 'Clave : '.$column[$b].'<br/>';
                                                                }elseif ($b==3){
                                                                    echo '<b>'.$column[$b].'</b>';
                                                                }
                                                        }
                                                    ?>
                                                </th>
                                                <?php }?>
                                            <?php } ?>
                                            <th>Total Percepciones</th>
                                            <?php for ($i=3; $i < count($columnas); $i++){ $column=explode(":", $columnas[$i]);?>
                                                <?php if($column[0] == 'D'){?>
                                                <th>
                                                    <?php   for ($b=0; $b < count($column) ; $b++) { 
                                                                if($b==0){
                                                                    echo $column[$b]=='P'? 'Percepción<br/>':'Deducción<br/>';
                                                                }elseif($b==1){
                                                                    echo 'Tipo SAT : '.$column[$b].'<br/>';
                                                                }elseif ($b==2){
                                                                    echo 'Clave : '.$column[$b].'<br/>';
                                                                }elseif ($b==3){
                                                                    echo '<b>'.$column[$b].'</b>';
                                                                }
                                                        }
                                                    ?>
                                                </th>
                                                <?php }?>
                                            <?php } ?>
                                            <th>Total Deducciones</th>
                                            <?php for ($i=3; $i < count($columnas); $i++){ $column=explode(":", $columnas[$i]);?>
                                                <?php if($column[0] == 'O'){?>
                                                <th>
                                                    <?php   for ($b=0; $b < count($column) ; $b++) { 
                                                                if($b==0){
                                                                    echo $column[$b]=='O'? 'Otras Percepciones<br/>':'Deducción<br/>';
                                                                }elseif($b==1){
                                                                    echo 'Tipo SAT : '.$column[$b].'<br/>';
                                                                }elseif ($b==2){
                                                                    echo 'Clave : '.$column[$b].'<br/>';
                                                                }elseif ($b==3){
                                                                    echo '<b>'.$column[$b].'</b>';
                                                                }
                                                        }
                                                    ?>
                                                </th>
                                                <?php }?>
                                            <?php } ?>
                                            
                                            <th>Total a Pagar</th>
                                        </tr>
                                    </thead>                                   
                                            
                                  <tbody>
                                        <?php $a=0;  foreach($lineas as $key): $a++; $tp= 0; $td=0; $to=0;?>
                                    	    <tr>
                                                <td><?php echo $key->UUID_NOMINA?></td>
                                                
                                                <?php foreach($datos as $d):?>
                                                    <?php if($d->UUID_NOMINA == $key->UUID_NOMINA){
                                                        echo '<td>'.$d->NOMBRE.'</td>';
                                                        break;
                                                    }
                                                ?>
                                                <?php endforeach;?>
                                                
                                                <?php foreach($datos as $d):?>
                                                    <?php if($d->UUID_NOMINA == $key->UUID_NOMINA){
                                                        echo '<td>'.$d->NUMERO.'</td>';
                                                        break;
                                                    }
                                                ?>
                                                <?php endforeach;?>


                                            <?php $c=3; $h=3;

                                                for($i=3; $i < count($columnas); $i++){ $column=explode(":", $columnas[$i]);
                                                    //echo '<br/>Column 0 valor'.$column[0].'';
                                                    if ($column[0] == 'P'){
                                                        echo '<td align="right">';///Creamos una columna por cada linea.
                                                            foreach($datos as $d){ /// Asignamos el valor si existe.
                                                                $h++;
                                                                if($d->UUID_NOMINA == $key->UUID_NOMINA AND (($d->DED_PER.':'.$d->TIPO.':'.$d->CLAVE.':'.$d->CONCEPTO) == $columnas[$i]) ){
                                                                    //echo '$ '.number_format($d->IMP_EXENTO + $d->IMP_GRAVADO,2);
                                                                    if($d->DED_PER == 'P'){
                                                                        $color = 'green';
                                                                    }else{
                                                                        $color = 'brown';
                                                                    }
                                                                    $a= '<b><font color='.$color.'> $ '.number_format($d->IMP_EXENTO + $d->IMP_GRAVADO,2).'</font></b>';
                                                                    $tp = $tp +  $d->IMP_EXENTO + $d->IMP_GRAVADO;
                                                                    break;
                                                                }else{
                                                                    $a = '$ '.number_format(0,2);
                                                                }
                                                            }
                                                            echo $a;
                                                        echo '</td>';
                                                    }
                                                }
                                            ?>
                                            <td align="right"><font color ="green"><b><?php echo '$ '.number_format($tp,2)?></b></font></td>
                                            <?php $c=3; $h=3;
                                                for($i=3; $i < count($columnas); $i++){ $column=explode(":", $columnas[$i]);
                                                    //echo '<br/>Column 0 valor'.$column[0].'';
                                                    if ($column[0] == 'D'){
                                                        echo '<td align="right">';///Creamos una columna por cada linea.
                                                            foreach($datos as $d){ /// Asignamos el valor si existe.
                                                                $h++;
                                                                if($d->UUID_NOMINA == $key->UUID_NOMINA AND (($d->DED_PER.':'.$d->TIPO.':'.$d->CLAVE.':'.$d->CONCEPTO) == $columnas[$i]) ){
                                                                    //echo '$ '.number_format($d->IMP_EXENTO + $d->IMP_GRAVADO,2);
                                                                    if($d->DED_PER == 'P'){
                                                                        $color = 'green';
                                                                    }else{
                                                                        $color = 'brown';
                                                                    }
                                                                    $a= '<b><font color='.$color.'> $ '.number_format($d->IMP_EXENTO + $d->IMP_GRAVADO,2).'</font></b>';
                                                                    $td = $td +  $d->IMP_EXENTO + $d->IMP_GRAVADO;
                                                                    break;
                                                                }else{
                                                                    $a = '$ '.number_format(0,2);
                                                                }
                                                            }
                                                            echo $a;
                                                        echo '</td>';
                                                    }
                                                }
                                            ?>

                                            <td align="right"><font color ="brown"><b><?php echo '$ '.number_format($td,2)?></b></font></td>
                                            <?php $c=3; $h=3;
                                                for($i=3; $i < count($columnas); $i++){ $column=explode(":", $columnas[$i]);
                                                    //echo '<br/>Column 0 valor'.$column[0].'';
                                                    if ($column[0] == 'O'){
                                                        echo '<td align="right">';///Creamos una columna por cada linea.
                                                            foreach($datos as $d){ /// Asignamos el valor si existe.
                                                                $h++;
                                                                if($d->UUID_NOMINA == $key->UUID_NOMINA AND (($d->DED_PER.':'.$d->TIPO.':'.$d->CLAVE.':'.$d->CONCEPTO) == $columnas[$i]) ){
                                                                    //echo '$ '.number_format($d->IMP_EXENTO + $d->IMP_GRAVADO,2);
                                                                    if($d->DED_PER == 'O'){
                                                                        $color = 'orange';
                                                                    }else{
                                                                        $color = 'brown';
                                                                    }
                                                                    $a= '<b><font color='.$color.'> $ '.number_format($d->IMP_EXENTO + $d->IMP_GRAVADO,2).'</font></b>';
                                                                    $to = $to +  $d->IMP_EXENTO + $d->IMP_GRAVADO;
                                                                    break;
                                                                }else{
                                                                    $a = '$ '.number_format(0,2);
                                                                }
                                                            }
                                                            echo $a;
                                                        echo '</td>';
                                                    }
                                                }
                                            ?>
                                            <td align="right"><font color="blue"><?php echo '$ '.number_format($tp-$td+$to,2)?> </font> </td>
                                            </tr>
                                        <?php endforeach;?>
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

var fi = <?php echo "'".$fi."'"?>;
var ff = <?php echo "'".$ff."'"?>;

$(".repNom").click(function(){
        if(confirm('Se genera el reporte en excel, por favor revise que su explorador admite descargas desde el sitio, sat2app.dyndns.org')){
            var tipo = 'xls'
            $.ajax({
                url:'index.xml.php',
                type:'post',
                dataType:'json',
                data:{detNom:1, fi, ff, tipo},
                success:function(data){
                    if(data.status == 'ok' && data.tipo == 'windows'){
                        window.open("/edoCtaXLS/"+data.archivo, 'download' );
                        alert('Revise en su carpeta de descargas el archivo "' + data.archivo +'" ')
                    }else{
                        descargarArchivo(data.ruta, data.archivo);
                    }
                },
                error:function(){
                    alert('Ocurrio un error')
                }
            })
            return false;    
        }
})

function descargarArchivo(url, archivo) {
  var xhr = new XMLHttpRequest();
  xhr.open('GET', url, true);
  xhr.responseType = 'blob';
  xhr.onload = function() {
    if (xhr.status === 200) {
      var blob = xhr.response;
      var link = document.createElement('a');
      link.href = window.URL.createObjectURL(blob);
      link.download = archivo;
      link.style.display = 'none';
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    }
  };
  xhr.send();
}




$(".comparar").click(function(){
    $.confirm({
        columnClass:'col-md-8',
        title:'Compar Reportes',
        content:'Carga de archivo' +
        '<form action="upload_rep_nom.php" method="post" enctype="multipart/form-data" class="upl"'+
        '<div class="form-group">'+
            '<br/>Archivo a comparar: <input type="file" name="fileToUpload" class="cl" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"> '+
            '<b>El archivo que carge se comparará con la nómina del ' + fi + ' al ' + ff + '</b><br/>'+
            '<input type="hidden" value="'+fi+'" name="fi">' + '<input type="hidden" value="'+ff+'" name="ff">' +
            '<br/>"El resualtado del proceso es un reporte donde se marcan los resultados de ambos archivos y se muestran las diferencias."' +
        '</form>',
        buttons:{
            formSubmit:{
                text:'Cargar Archivo', 
                btnClass:'btn-blue', 
                action: function(){
                    var file = this.$content.find('.cl').val();
                    var form = this.$content.find('.upl')
                    
                    if(file==''){
                        $.alert('Debe de seleccionar un archivo...');
                        return false;
                    }else{
                        form.submit()
                    }
                }

            },
            cancelar: function(){

            },
        } 
    })
})

/*
    $(".infoPer").mouseover(function(){
        return false
        var texto = titulo(this)
        alert(texto)
    });

    function titulo(a){
        var uuid = $(a).attr('l')
        var text = ''
        var info = ''
        $.ajax({
            url:'index.xml.php',
            type:'post',
            dataType:'json',
            data:{infoPer:1, uuid},
            success:function(data){
                var obj = data[0];
                for (const prop in obj) {
                  console.log(`${prop} = ${obj[prop]}`);
                  info = (`${prop} = ${obj[prop]}`)
                  text += info + ' <br> '
                }
                return text
            }
        })
    }
*/

/*
function format ( d ) {
    return 'Full name: '+d.first_name+' '+d.last_name+'<br>'+
        'Salary: '+d.salary+'<br>'+
        'The child row can contain any data you wish, including links, images, inner tables etc.';
}
 
$(document).ready(function() {
    var dt = $('#dataTables-recibos-nom').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "scripts/ids-objects.php",
        "columns": [
            {
                "class":          "details-control",
                "orderable":      false,
                "data":           null,
                "defaultContent": ""
            },
            { "data": "first_name" },
            { "data": "last_name" },
            { "data": "position" },
            { "data": "office" }
        ],
        "order": [[1, 'asc']]
    } );
});
 
    // Array to track the ids of the details displayed rows
    var detailRows = [];

$('#dataTables-recibos-nom').on( 'click', 'tr td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = dt.row( tr );
        var idx = $.inArray( tr.attr('id'), detailRows );
 
        if ( row.child.isShown() ) {
            tr.removeClass( 'details' );
            row.child.hide();
            // Remove from the 'open' array
            detailRows.splice( idx, 1 );
        }
        else {
            tr.addClass( 'details' );
            row.child( format( row.data() ) ).show();
            // Add to the 'open' array
            if ( idx === -1 ) {
                detailRows.push( tr.attr('id') );
            }
        }
    } );
*/

</script>