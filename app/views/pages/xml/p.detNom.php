<br/>
	<br/><br/>
    	<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        Detalle de la nomina del <?php echo $fi?> al <?php echo $ff?>
                        <br/><br/> <input type="button" class="btn-sm btn-info repNom" value="Reporte de Nomina"> <br/><br/>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-recibos-nom">
                                    <thead>
                                        <tr role="row">
                                            <!--<th class="details-control sorting_disabled" ></th>-->
                                            <th>UUID</th>
                                            <th>Numero <br/>Empleado</th>
                                            <th>Nombre <br/>Empleado</th>
                                            <?php for ($i=3; $i < count($columnas); $i++){ ?>
                                                <th>
                                                    <?php $column=explode(":", $columnas[$i]);
                                                        for ($b=0; $b < count($column) ; $b++) { 
                                                                if($b == 0){
                                                                    //echo 'Entro al if y valor de b = '.$b;
                                                                    echo $column[$b]=='P'? 'Percepción<br/>':'Deducción<br/>';
                                                                }elseif($b == 1){
                                                                    echo 'Tipo SAT : '.$column[$b].'<br/>';
                                                                }elseif ($b == 2){
                                                                    echo 'Clave : '.$column[$b].'<br/>';
                                                                }elseif ($b ==3){
                                                                    echo '<b>'.$column[$b].'</b>';
                                                                }
                                                        }
                                                    ?>
                                                </th>
                                            <?php } ?>
                                        </tr>
                                    </thead>                                   
                                            
                                  <tbody>
                                        <?php $a=0; foreach($lineas as $key): $a++;?>
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
                                                for($i=3; $i < count($columnas); $i++){ 
                                                    echo '<td align="right">';///Creamos una columna por cada linea.
                                                        foreach($datos as $d){ /// Asignamos el valor si existe.
                                                            $h++;
                                                            if($d->UUID_NOMINA == $key->UUID_NOMINA AND ( ($d->DED_PER.':'.$d->TIPO.':'.$d->CLAVE.':'.$d->CONCEPTO) == $columnas[$i]) ){
                                                                //echo '$ '.number_format($d->IMP_EXENTO + $d->IMP_GRAVADO,2);
                                                                if($d->DED_PER == 'P'){
                                                                    $color = 'green';
                                                                }else{
                                                                    $color = 'brown';
                                                                }
                                                                $a= '<b><font color='.$color.'> $ '.number_format($d->IMP_EXENTO + $d->IMP_GRAVADO,2).'</font></b>';
                                                                break;
                                                            }else{
                                                                $a = '$ '.number_format(0,2);
                                                            }
                                                        }
                                                        echo $a;
                                                    echo '</td>';
                                                }
                                            ?>
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
    alert('Reporte de la nomina' + fi)
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