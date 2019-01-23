<?php
require_once('ConexionManager.php');

class Buy {

    public static function process_request() {
        if(isset($_POST['id']) && isset($_POST['amount']) && $_SESSION['customer']) {
            $con = ConexionManager::get_conexion();
            $customer = $_SESSION['customer'];
            $id_book = $_POST['id'];
            $id_customer = $customer->id;
            $amount = $_POST['amount'];

            $book = current($con->select("SELECT * FROM book WHERE id = :id", array('id' => $id_book)));
            if(empty($book)) exit("Book not found!");
            if($book->stock <= 0) exit("Book not in stock!");

            $stock = $book->stock - $amount;
            if($book->stock < 0) exit("Not enought books in stock!");

            $con->update("UPDATE book set stock = :stock_book WHERE id = :id_book", array(':stock_book' => $stock, ':id_book' => $id_book));

            $params_sale = array(
                "customer_id" => $id_customer,
                "date" => (new DateTime())->format('Y-m-d H:i:s'),
            );

            $con->insert('sale', $params_sale);
            $id_sale = $con->connector->lastInsertId();

            $params_sale_books = array(
                "book_id" => $id_book,
                "sale_id" => $id_sale,
                "amount" => $amount
            );

            $con->insert('sale_books', $params_sale_books);
        }
    }
}