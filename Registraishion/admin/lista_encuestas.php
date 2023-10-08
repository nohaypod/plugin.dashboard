<?php
    global $wpdb;
    $tabla = $wpdb->prefix . 
    'mi_table'; //'cf_form_entry_values';
    
    if(isset($_POST['btnguardar'])){
    print_r($_POST);
    }
    $query ="SELECT * FROM $tabla";
    $lista = $wpdb->get_results($query,ARRAY_A);
    if(empty($lista)){$lista=array();}
?>

<div class="wrap">
    <?php
            echo "<h1 class='wp-heading-inline'>" . get_admin_page_title() ."</h1>";
    ?>
    <a id="btnnuevo" class="page-title-action">Anadir Nuevo</a>
    <br><br><br>

    <table class="wp-list-table widefat fixed striped pages">
        <div class="alert alert-dark" role="alert">
            Registro de asistencias.
        </div>
        <thead>
            <th >Nombre</th>
            <th >Shortcode</th>
            <th >Ticket</th>
            <th >Acciones</th>
        </thead>
        <tbody id="the-list">
        <?php
            foreach ($lista as $key => $value) {
                $nombre = $value['Nombre'];
                $shortcode = $value['Shortcode'];
                $ticket = $value['Ticket'];
              //  $slug = $value['slug'];
                echo "
                     <tr>
                     <td>$nombre</td>
                     <td>$shortcode</td>
                     <td>$ticket</td>
                      <td>
                      <a class='btn btn-light'>Borrar</a>
                      <a class='btn btn-outline-dark' name='btnprint' id='btnprint'>Imprimir</a>
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
        <h5 class="modal-title" id="exampleModalLongTitle"> Registro </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <form method="post">
      <div class="modal-body">
        
            <div class="form-gruop">
              <label for="txtnombre" class="col-sm-4 col-form-label">Nombre</label>
              <div class="col-sm-8">
                <input type="text" id="txtnombre" name="txtnombre" style="width:100%">
              </div><br>
            </div>
            <br>
            <h6>Preguntas</h6><br>
            <table id="camposdinamicos">
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
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary" name="btnguardar" id="btnguardar">Guardar</button>
      </div>
    <form>

    </div>
  </div>
</div>