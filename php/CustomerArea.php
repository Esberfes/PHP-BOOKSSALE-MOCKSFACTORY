<?php
require_once('ConexionManager.php');

class CustomerArea {

    public static function get_customer_sale_data() {
        if(!isset($_SESSION['customer'])) return array();
        $con = ConexionManager::get_conexion();
        $customer = $_SESSION['customer'];
        $data = $con->select("SELECT title, price, sale_books.amount, date
         FROM customer, book, sale_books, sale WHERE
         customer.id = :id
         AND sale_books.book_id = book.id
         AND sale_books.sale_id = sale.id
         AND sale.customer_id = customer.id
         "
         , array('id' => $customer->id));

         return $data;
    }
}