<?php

class DatabaseHandler{
    private $pdo;
    private $dsn = "mysql:host=localhost;dbname=shopping_cart";
    private $db_user = "root";
    private $db_pass = "root";

    public function __construct() {
        $this->connect();
    }

    public function connect() {
        try {
            $this->pdo = new PDO($this->dsn, $this->db_user, $this->db_pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function get_price($code) {
        $query = "SELECT price FROM catalog WHERE product_code = :code;";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":code", $code);
        $stmt->execute();

        return $stmt->fetch()[0];
    }

    public function get_offers() {
        $query = "SELECT offer FROM specials WHERE active = TRUE;";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $offers = [];

        while($row = $stmt->fetch()) {
            $offers[] = $row[0];
        }
        return $offers;
    }

    public function get_valid_codes() {
        $query = "SELECT product_code FROM catalog;";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $codes = [];

        while($row = $stmt->fetch()) {
            array_push($codes, $row[0]);
        }
        return $codes;
    }

    public function __destruct() {
        $this->pdo = NULL;
    }
}