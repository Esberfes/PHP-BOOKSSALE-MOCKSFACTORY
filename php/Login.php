<?php

require_once('ConexionManager.php');

class Login {

    public static function process_request() {
       
        if(isset($_POST['email'])) {
            $email = $_POST['email'];
            $con = ConexionManager::get_conexion();
            $customer = current($con->select("SELECT * FROM customer WHERE email = :email", array('email' => $email)));
            if(!empty($customer)) {
                $_SESSION['customer'] = $customer;
            }
        }

        if(isset($_POST['logout'])) unset($_SESSION['customer']);

    }
}