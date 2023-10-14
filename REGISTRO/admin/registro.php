<?php
    global $wpdb;
    $tabla = $wpdb->prefix . 
    'bosi_user'; //'cf_form_entry_values';
    
    $table = $wpdb->prefix . 
    'bosi_ticket';
    
    if(isset($_POST['btnguardar'])){
    
        $nombre = $_POST['txtnombre'];
        $apellido = $_POST['txtapellido'];
        $query = "SELECT id FROM $tabla ORDER BY id DESC limit 1";
        $resultado = $wpdb->get_results($query, ARRAY_A);
        $proximoId = $resultado[0]['id'] + 1;
        $ticket = "Ticket_0" . $proximoId . "";
       // $shortcode = $proximoId + 100;
        $datos = [
            'Nombre' => $nombre,
            'Apellido' => $apellido,
            'Ticket' => $ticket
            ];
        //print_r($datos);
        $respuesta = $wpdb->insert($tabla, $datos, ['%s', '%s', '%s']);
        
        if($respuesta){
            $listadatos = $_POST['name'];
            $i = 0;
            foreach($listadatos as $key => $value){
                $tipo = $_POST['type'][$i];
                $datos2 = [
                    'id' => $proximoId,
                    'Nombre' => $value,
                    'Tipo' => $tipo
                    ];
                $wpdb->insert($table, $datos2, ['%s', '%s', '%s', '%s']);
                $i++;
            }
        }
        
    }
    
    $query ="SELECT * FROM $tabla";
    $lista = $wpdb->get_results($query,ARRAY_A);
    if(empty($lista)){$lista=array();}
?>

<div class="wrap">
    <?php
            echo "<h1 class='wp-heading-inline'>" . get_admin_page_title() ."</h1>";
    ?>
    <a id="btnnuevo" class="page-title-action">Anadir Asistente</a>
    <br><br><br>
    
    <table class="wp-list-table widefat fixed striped pages">
        <div class="alert alert-dark" role="alert">
        <div class="d-flex justify-content-center">
        </div>
        <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Buscar..." aria-label="Buscar"><br>
            <button type="button" id="buscar" class="btn btn-outline-secondary" type="submit">Buscar</button>
            </div>
            
        </form>
            <div id="resultado_busqueda" style="display:none"><br>
            <a>Ticket : </a>
            <br><a>Nombre : </a>
            <br><a>Apellido : </a>
            <br><a>Tipo de Boleto : </a>
            <br><a>Correo : </a>
            <br><a>Asistencias : </a>
            </div>
        </div>
        <thead>
            <th >Nombre</th>
            <th >Ticket</th>
            <th >Acciones</th>
        </thead>
        <tbody id="the-list">
        <?php
            foreach ($lista as $key => $value) {
                $id =$value['id'];
                $nombre = $value['Nombre'];
                $apellido = $value['Apellido'];
                $ticket = $value['Ticket'];
              // $ticket = $value['Shortcode'];
              // $slug = $value['slug'];
                echo "
                    <tr>
                     <td>$nombre $apellido</td>
                     <td>$ticket</td>
                      <td>
                      <a data-nombre='$nombre' data-apellido='$apellido' data-ticket=$ticket class='btn btn-light'>Ver</a>
                      <a data-id='$id' data-nombre='$nombre' class='btn btn-outline-dark'>Borrar</a>
                      </td>
                    </tr>
                    ";
            }
        ?>
        </tbody>
    </table>

</div>

<!-- Modal -->
<div class="modal fade" id="modalnuevo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLongLabel"> Registro Nuevo </h1>
        <button style="display:none" type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
        <span style="display:none" aria-hidden="true" >&times;</span>
        </button>
      </div>
    <form method="post">
      <div class="modal-body">
        
            <div class="form-gruop">
              <label for="txtnombre" class="col-sm-4 col-form-label">Nombre</label>
              <div class="col-sm-8">
                <input type="text" id="txtnombre" name="txtnombre" style="width:100%">
              </div><br><br>
              <label for="txtapellido" class="col-sm-4 col-form-label">Apellido</label>
              <div class="col-sm-8">
                <input type="text" id="txtapellido" name="txtapellido" style="width:100%">
              </div><br>
            </div>
            <br>
            <h6 style="display:none">Preguntas</h6><br>
            <table id="camposdinamicos" style="display:none">
              <tr>
                <td>
                  <label for="txtnombre" class="col-form-label" style="margin-right:5px">Pregunta</label>
                </td>
                <td>
                  <input type="text" name="name[]" id="name" class="form-control name_list" style="margin-right:5px">
                </td>
                <td>
                    <select name="type[]" id="type" class="form-control type_list" style="margin-right:5px">
                        <option value="1" select>Si - No</option>
                        <option value="2">Rango 0 - 5</option>
                    </select>
                </td>
                <td>
                  <button name="add" id="add" class="btn btn-outline-dark" style="margin-left:5px">+</button>
                </td>
              </tr>
            </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary" name="btnguardar" id="btnguardar">Guardar</button>
      </div>
    <form>

    </div>
  </div>
</div>

<!-- Modal Ver-->
<div class="modal fade" id="modalnuevo1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Informacion de usuario</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <table id="modal_ver">
              
            </table>
      </div>
      <div class="modal-footer">
        <button id= modal_close type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button id= modal_print type="button" class="btn btn-warning">Imprimir</button>
        <button id= modal_asis type="button" class="btn btn-outline-primary">Asistencia</button>
      </div>
    </div>
  </div>
</div>