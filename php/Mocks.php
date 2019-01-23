<?php
require_once('Faker/src/autoload.php');
require_once('ConexionManager.php');

class Mocks {

    public static function truncate($table) {
        $con = ConexionManager::get_conexion();
        $con->select("SET FOREIGN_KEY_CHECKS = 0;TRUNCATE $table; SET FOREIGN_KEY_CHECKS = 1;");
    }

    public static function populate($amount) {
        $books_ids = self::populate_books($amount);
        $customers_ids = self::populate_customers($amount);

        self::truncate('sale');
        self::truncate('sale_books');
    }

    public static function populate_customers($amount) {
        $con = ConexionManager::get_conexion();
        $faker = Faker\Factory::create();
        $inserted_ids = array();
        $table = "customer";

        self::truncate($table);

        for($i = 0; $i < $amount; $i++) {
            $types = array("basic", "premium");

            $firstname = $faker->firstName;
            $surname = $faker->lastName;
            $email = $faker->email;
            $type = $types[ array_rand($types) ];

            $params = array(
                "firstname" => $firstname,
                "surname" => $surname,
                "email" => $email,
                "type" => $type
            );

            $con->insert($table, $params);
            $inserted_ids[] = $con->connector->lastInsertId();
            self::write_line("Customer created with id: ".$con->connector->lastInsertId());
        }
    }

    public static function populate_books($amount) {

        $con = ConexionManager::get_conexion();
        $faker = Faker\Factory::create();
        $inserted_ids = array();
        $table = "book";

        self::truncate($table);

        for($i = 0; $i < $amount; $i++) {

            $isbn = $faker->isbn13;
            $title = $faker->realText(30);
            $author = $faker->name;
            $sinopsis = $faker->realText();
            $image = $faker->imageUrl();
            $stock = $faker->randomNumber(4);
            $price = $faker->randomFloat(2, 100, 1);

            $params = array(
                "isbn" => $isbn,
                "title" => $title,
                "author" => $author,
                "sinopsis" => $sinopsis,
                "image" => $image,
                "stock" => $stock,
                "price" => $price
            );

            $con->insert($table, $params);
            $inserted_ids[] = $con->connector->lastInsertId();
            self::write_line("Book created with id: ".$con->connector->lastInsertId());
        }

        return $inserted_ids;
    }

    public static function write_line($line) {
        echo $line."<br>";
    }
}
