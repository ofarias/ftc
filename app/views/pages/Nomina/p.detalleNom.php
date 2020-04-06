<br/>
	<br/><br/>
    	<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        Recibos de la nomina del <?php echo $fi?> al <?php echo $ff?>
                        <br/><br/> <input type="button" class="btn-sm btn-success detNom" value="Exportar a Excel" tipo="xls"> &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="btn-sm btn-info detNom" value="Detalle de la Nomina" tipo= 'pant'>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-recibos-nom">
                                    <thead>
                                        <tr role="row">
                                            <!--<th class="details-control sorting_disabled" ></th>-->
                                            <th>Numero Empleado</th>
                                            <th><b>Nombre</b> <br/> <font color="brown">CURP</font> <br/> <font color="green">NSS </font></th>
                                            <th>Percepciones</th>
                                            <th>Deducciones</th>
                                            <th>Fecha <br/> Inicio relacion <br/><font color="brown"> Antigüedad</font></th>
											<th>Tipo Contrato <br/> <font color="brown">Sindicalizado</font></th>
                                            <th>Tipo Jornada <br/> <font color="brown">Tipo de Regimen</font></th>
                                            <th>Departamento <br/> <font color="brown">Puesto </font></th>
                                            <th>Riesgo de Puesto<br/><font color="brown">Periodicidad</font></th>
                                            <th>Salario Base <br/><font color="brown">SDI</font></th>
                                            <th>Clave Entidad<br/><font color="brown">Estado</font></th>
                                            <th>Banco de Pago<br/><font color="blue">Cuenta</font></th>
                                            <th>UUID</th>
                                        </tr>
                                    </thead>                                   
                                            
                                  <tbody>
                                    	<?php foreach ($rec as $data): 
                                                $a = 'Total &#10; Algo mas ';
                                            ?>
                                            <tr>
                                                <td><?php echo $data->NUMEMPLEADO?></td>
                                                <td><?php echo $data->EMPLEADO.'<br/>'.$data->CURP.'<br/>'.$data->NUMSEGURIDADSOCIAL?></td>
                                                <td align="right" title="" class="infoPer" l="<?php echo $data->UUID_NOMINA?>"><?php echo '$ '.number_format($data->TOTAL_SUELDOS,2)?></td>
                                                <td align="right"><?php echo '$ '.number_format($data->TOTAL_IMP_RET + $data->TOTAL_OTRAS_DED,2)?></td>
                                                <td><?php echo $data->FECHAINICIORELLABORAL?><br/><font color="brown"><?php echo $data->ANTIGUEDAD?></font></td>
                                                <td><?php echo $data->TIPOCONTRATO.'<br/><font color="brown">'.$data->SINDICALIZADO.'</font>'?></td>
                                                <td><?php echo $data->TIPOJORNADA?><br/><font color="brown"><?php echo $data->TIPOREGIMEN?></font></td>
                                                <td><?php echo $data->DEPARTAMENTO?><br/><font color ="brown"><?php echo $data->PUESTO?></font></td>
                                                <td><?php echo $data->RIESGOPUESTO?><br/><font color="brown"><?php echo $data->PERIODICIDADPAGO?></font></td>
                                                <td align="right"><?php echo '$ '.number_format($data->SALARIOBASECOTAPOR,2)?><br/><font color="brown"><?php echo '$ '.number_format($data->SALARIODIARIOINTEGRADO,2)?></font></td>
                                                <td align="center"><?php echo $data->CLAVEENTFED?><br/><font color="brown"></font></td>
                                                <td><?php echo $data->BANCO?><br/><font color="brown"><?php echo $data->CUENTA_BANCARIA?></font></td>
                                                <td>
                                                    <a href="\\" download><b><?php echo $data->UUID_NOMINA?></b></a><br/>
                                                    <a href="index.xml.php?action=verRecibo&uuid=<?php echo $data->UUID_NOMINA ?>" target="popup"  onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;" >Detalle</a></td>
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

    var fi = <?php echo "'".$fi."'"?>;
    var ff = <?php echo "'".$ff."'"?>;

$(".repNom").click(function(){
    alert('Reporte de la nomina' + fi)
})


$(".detNom").click(function (){
    var tipo = $(this).attr('tipo')
    window.open('index.xml.php?action=detNom&fi='+fi+'&ff='+ff+'&tipo='+tipo, 'popup', 'width=1600,height=800')
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