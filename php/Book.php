<?php
require_once('ConexionManager.php');

class Book {

    public static function get_all() {
        $connexion = ConexionManager::get_conexion(); 
        return $connexion->select("SELECT * FROM book");
    }
}