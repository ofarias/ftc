<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Documentos del cliente.</h4>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="">
                        <thead>
                            <tr>
                                <th>Documento</th>
                                <th>Descripción</th>
                                <th>Copias</th>
                                <th>Requerido</th>
                                <th>Orden</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <?php 
                                $ln = 0;
                            foreach($exec as $row): 
                                $ln++;
                            ?>
                            <tr id = '$ln'>
                                <td><?php echo $row->NOMBRE;?></td>
                                <td><?php echo $row->DESCRIPCION;?></td>
                                <td><?php echo $row->COPIAS;?></td>
                                <td><?php echo $row->REQUERIDO;?></td>
 
                                <td><input type="number" min='0' max="10"  name="orden" id="orde_<?php echo $ln?>" value="<?php echo $row->POSICION?>" onchange="orden(<?php echo $ln?>, this.value, '<?php echo $row->CVE_CLI?>',<?php echo $row->ID_DOC?>)" actual="<?php echo $row->POSICION?>"></td>

                                <td align="center"><input type="button" class="btn btn-danger" name="Quitar" onclick="quitarReq(<?php echo $ln?>, <?php echo $row->ID_DOC?>, '<?php echo $row->CVE_CLI?>' )" value="Quitar"> </td>
                             <!--<form action="index.php" method="post">
                                 <input type="hidden" name="id" value="<?php echo $row->ID;?>"/>
                                 <td><button type="submit" name="editadocumentoC" class="btn btn-warning">Editar <i class="fa fa-pencil-square-o"></i></button></td>
                                </form> -->    

                            </tr>
                            
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <!-- /.table-responsive -->
                </div>
            </div>
            <div class="panel-footer text-right">
                
                <form action="index.php" method="post">
                    <input type="hidden" name="clave_cliente" value="<?php echo $_SESSION['ClaveCliente'];?>"/>

                <input type="button" name="actualizar" value="Actualizar" class="btn btn-info" id="actualizar" >  <button name="AgregarDocumentoACliente" class="btn btn-success">Agregar <i class="fa fa-plus"></i></button>
                </form>
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

    $('#actualizar').click(function(){
        location.reload(true);
    })  

    function orden(ln, orden, clie, iddoc ){
        //alert(''+ ln + orden);
        var actual = document.getElementById('orde_'+ln);

        if(orden <= 0 || orden >=10){
            alert('No se permite la posicion 0 o negativo, o un valor igual o mayor a 10, favor de revisar la informacion');
            document.getElementById('orde_'+ln).value=actual.getAttribute('actual');
        }else{
            $.ajax({   
            url:'index.php',
            method:'post',
            dataType:'json',
            data:{ordenaDocs:clie, iddoc:iddoc, orden:orden},
            success:function(data){
                alert('Se modifico el orden');
            }
            });    
        }
        
    } 

    function quitarReq(ln, iddoc,cl){
        alert('Desea quitar el requisito?'+ iddoc);
        $.ajax({
            url:'index.php',
            type:'post',
            dataType:'json',
            data:{quitarReq:iddoc,cl:cl},
            success:function(data){
                alert(data.mensaje);
                location.reload(true);
            }
        })
    }

</script>