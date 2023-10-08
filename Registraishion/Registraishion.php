<?php
/*
Plugin Name: Registraishon
Plugin URL: htttps//edgardo.arquitecturainteligente.com
Description: Super plugin de registro locoshon
Version: 0.0.1
*/

function Activarr(){
    global $wpdb;
    $tabla_uno = $wpdb->prefix . 
    'mi_table';
    $tabla_dos = $wpdb->prefix . 
    'mi_tablo';
    $tabla_tres = $wpdb->prefix . 
    'mi_tablu';

    $sql ="CREATE TABLE IF NOT EXISTS 
        $tabla_uno(
        `id` INT(10) NOT NULL , `Nombre` VARCHAR(20) NOT NULL , `Ticket` VARCHAR(20) NOT NULL , `Shortcode` INT NOT NULL, PRIMARY KEY (id)
        ); ";
    
    $wpdb->query($sql);

    $sql2 ="CREATE TABLE IF NOT EXISTS 
        $tabla_dos(
        `tid` INT NOT NULL , `nombre` VARCHAR(20) NOT NULL , `apellido` VARCHAR(20) NOT NULL, PRIMARY KEY (tid)
        ); ";
    
    $wpdb->query($sql2);

    $sql3 ="CREATE TABLE IF NOT EXISTS 
        $tabla_tres(
            `assid` INT NOT NULL , `asis1` INT NOT NULL , `asis2` INT NOT NULL, PRIMARY KEY (assid)
        ); ";

    $wpdb->query($sql3);


}


function Desactivarr(){
    flush_rewrite_rules();
}


register_activation_hook(__FILE__,'Activarr');
register_deactivation_hook(__FILE__,'Desactivarr');
add_action('admin_menu', 'CrearMenu1');

function CrearMenu1(){
    add_menu_page(
        'Dashboard Registro', // Título página
        'Registro', // Título menu
        'manage_options', // Capability
        plugin_dir_path(__FILE__).'admin/lista_encuestas.php', // slug
        null, // Funcion de contenido
        plugin_dir_url(__FILE__).'admin/img/icon.png',
        '6'
    );
   //add_submenu_page(
   //    "sp_menu", // parent slug
   //    "Ajustes", // Título Pagina
   //    "Ajustes", // Titulo manu
   //    "manage_options",
   //    "sp_menu_ajustes",
   //    "Submenu1"

   //);
};

function MostrarContenido1(){
    echo "<h1>Contenido Locoshon</h1>";
}

function EncolarBootstrapJS($hook){
    //echo "<script>console.log('$hook')</script>";
    if($hook != "Registraishion/admin/lista_encuestas.php"){
        return ;
    }
    wp_enqueue_script('bootstrapJs',plugins_url('admin/bootstrap/js/bootstrap.min.js',__FILE__),array('jquery'));
}
add_action('admin_enqueue_scripts','EncolarBootstrapJS');


function EncolarBootstrapCSS($hook){
    if($hook != "Registraishion/admin/lista_encuestas.php"){
        return ;
    }
    wp_enqueue_style('bootstrapCSS',plugins_url('admin/bootstrap/css/bootstrap.min.css',__FILE__));
}
add_action('admin_enqueue_scripts','EncolarBootstrapCSS');

function EncolarJS($hook){
    if($hook != "Registraishion/admin/lista_encuestas.php"){
        return ;
    }
    wp_enqueue_script('JsExterno',plugins_url('admin/js/lista_encuestas.js',__FILE__),array('jquery'));
}
add_action('admin_enqueue_scripts','EncolarJS');