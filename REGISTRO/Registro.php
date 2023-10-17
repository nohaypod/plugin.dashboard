<?php
/*
* Plugin Name:       Registro
 * Plugin URI:        https://boletos.site
 * Description:       Registra y atiende usuarios en la recepción.
 * Version:           0.0.1
 * Requires PHP:      7.2
 * Author:            boletossite
 * Author URI:        https://boletos.site/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       my-registro-plugin
 * Domain Path:       /languages
 */

function Activar(){
    global $wpdb;
    $tabla_uno = $wpdb->prefix . 
    'bosi_user';
    $tabla_dos = $wpdb->prefix . 
    'bosi_ticket';
    $tabla_tres = $wpdb->prefix . 
    'bosi_vistas';

    $sql ="CREATE TABLE IF NOT EXISTS 
        $tabla_uno(
        `id` INT(10) NOT NULL AUTO_INCREMENT , `Nombre` VARCHAR(20) NOT NULL , `Apellido` VARCHAR(20) NOT NULL , `Ticket` VARCHAR(20) NOT NULL , PRIMARY KEY (`id`)
        ); ";
    
    $wpdb->query($sql);

    $sql2 ="CREATE TABLE IF NOT EXISTS 
        $tabla_dos(
        `detalleId` INT NOT NULL AUTO_INCREMENT , `id` INT NOT NULL , `nombre` VARCHAR(20) NOT NULL , `tipo` VARCHAR(45) NULL , PRIMARY KEY (`detalleId`)
        ); ";
    
    $wpdb->query($sql2);

    $sql3 ="CREATE TABLE IF NOT EXISTS 
        $tabla_tres(
            `assid` INT NOT NULL , `asis1` INT NOT NULL , `asis2` INT NOT NULL, PRIMARY KEY (`assid`)
        ); ";

    $wpdb->query($sql3);


}


function Desactivar(){
    flush_rewrite_rules();
}


register_activation_hook(__FILE__,'Activar');
register_deactivation_hook(__FILE__,'Desactivar');
add_action('admin_menu', 'CrearMenu');

function CrearMenu(){
    add_menu_page(
        'Dashboard Recepcion', // Título página
        'Asistentes', // Título menu
        'manage_options', // Capability
        plugin_dir_path(__FILE__).'admin/registro.php', // slug
        null, // Funcion de contenido
        plugin_dir_url(__FILE__).'admin/img/icon.png',
        '6'
    );
};

function EncolarBootstrapJS($hook){
    echo "<script>console.log('$hook')</script>";
  //  if($hook != "REGISTRO/admin/Registro.php"){
  //      return ;
  //  }
    wp_enqueue_script('bootstrapJs',plugins_url('/admin/bootstrap/js/bootstrap.min.js',__FILE__),array('jquery'));
}
add_action('admin_enqueue_scripts','EncolarBootstrapJS');


function EncolarBootstrapCSS($hook){
//    if($hook != "REGISTRO/admin/Registro.php"){
//        return ;
//    }
    wp_enqueue_style('bootstrapCSS',plugins_url('/admin/bootstrap/css/bootstrap.min.css',__FILE__));
}
add_action('admin_enqueue_scripts','EncolarBootstrapCSS');

function EncolarJS($hook){
//    if($hook != "REGISTRO/admin/Registro.php"){
//        return ;
//    }
    wp_enqueue_script('JsExterno',plugins_url('/admin/js/registro.js',__FILE__),array('jquery'));
    wp_localize_script('JsExterno', 'SolicitudesAjax', [
            'url'=> admin_url('admin-ajax.php'),
            'seguridad'=> wp_create_nonce('seg')
        ]);
}

 add_action('admin_enqueue_scripts','EncolarJS');

//Ajax validación

function EliminarRegistro(){
    $nonce = $_POST['nonce'];
    if(!wp_verify_nonce($nonce, 'seg')){
        die('no hay permiso para ejecutar Ajax');
    }
    
    $id = $_POST['id'];
    global $wpdb;
    $tabla = $wpdb->prefix . 'bosi_user'; //'cf_form_entry_values';
    $table = $wpdb->prefix . 'bosi_ticket';
    $wpdb->delete($tabla, array('id' =>$id));
    $wpdb->delete($table, array('id' =>$id));
    return true;
}

add_action('wp_ajax_peticioneliminar', 'EliminarRegistro');