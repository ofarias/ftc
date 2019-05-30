<br/>
<br/>
<div class="container">
  <div class="row">
    <button id="openeU" class="btn btn-warning">Nuevo Usuario <i class="fa fa-plus-circle"></i></button>
  </div>
  <br />
    <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Modifica Usuarios
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios">
                                    <thead>
                                        <tr>
                                          <th>Ln</th>
                                          <th>Usuario</th>
                                          <th>Email</th>
                                          <th>Estatus</th>
                                          <th>Rol</th>                                           
                                          <th>Letra</th>
                                          <th>Modificar</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                      <?php
                                      $ln = 0;
                                      foreach ($exec as $data): 
                                        $ln++;?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $ln?></td>
                                            <td><?php echo $data->USER_LOGIN;?></td>
                                            <td><?php echo $data->USER_EMAIL;?></td>
                                            <td><?php echo $data->USER_STATUS;?></td>
                                            <td><?php echo $data->USER_ROL;?></td>
                                            <td><?php echo $data->LETRA;?></td>
                                            <td><center><a href="index.php?action=modifica&e=<?php echo $data->USER_LOGIN?>" class="btn btn-warning" role="button"><p><i class="fa fa-pencil-square-o"></i></p></a></center></td>                                  
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                </div>               
      </div>
    </div>
</div>
</div>
<!--Fancy Box para nuevo usuarios-->
<div id="dialogU" title="Nuevo Usuario">
<div class="row">
  <div class="col-lg-12">
    <h2>Formulario para Alta de Nuevo Usuario</h2>
  </div>
  <br/><br/><br/>
  <div class="col-lg-6">
    <form action="index.php" method="post" class="form-group">
      <label for="usuario">Usuario: </label>
      <input type="text" name="usuario" class="usuario" required value="" id="usr" />
      <label for="contrasena">Contraseña: </label>
      <input type="password" name="contrasena" class="form-control" required="required" />
      <label for="email">Correo Electronico: </label>
      <input type="email" name="email" class="form-control" required="required" />
      <label for="NomCom">Nombre(s): </label>
      <input type="text" name="nombre" class="form-control" required="required" />
      <label for="NomCom">Apellido Paterno: </label>
      <input type="text" name="paterno" class="form-control" required="required" />
      <label for="NomCom">Apellido Materno: </label>
      <input type="text" name="materno" class="form-control" required="required" />
      <label for="letras">Numero de Letras que vera en Ventas: </label>
      <input type="number" step="1" min="0" max="100" name="numletras" class="form-control" required="required" placeholder="99 para ver todas" />
      <label for="rol">Tipo de Rol: </label>
      <select name="rol" class="form-control">
        <option value="">Selecciona Rol</option>
        <?php foreach($roles as $data):?>
          <option value="<?php echo strtolower($data->NOMBRE)?>"><?php echo strtoupper($data->NOMBRE)?></option>
        <?php endforeach;?>
        </select>
      <label for="letra"> Letra Cotizaciones: </label>
      <input type="text" name="letra" class="form-control" >
      <br />
      <button type="submit" class="btn btn-success">Alta</button>
    </form>
  </div>
</div>
</div>
<script type="text/javascript" language="JavaScript" src="app/views/bower_components/jquery/dist/jquery.min.js"></script>
<script type="text/javascript">
    
    $('.usuario').change(function(){
        var u = $(this).val()
        $.ajax({
          url:'index.php',
          method:'post',
          dataType:'json',
          data:{valUsr:u},
          success:function(data){
            if(data.status == 'no'){
              alert('El usuario ' + u + ' ya existe. Favor de cambiar')
              document.getElementById('usr').value=''
            }
          },
          error:function(){
            alert('No se pudo validar que el usuario sea unico, favor de vericar su informacion')
            document.getElementById('usr').value=''
          }
        })  
    })
    

</script>

