<?php

namespace PES;

class Positions
{
    // database connection and table name
    private $conn;
    private $table_name = "positions";

    // object properties
    public $id;
    public $quote_name;
    public $price_avg;
    public $price_cur;
    public $amount;
    public $portfolio_id;
    public $created_at;
    public $updated_at;
    public $timestamp;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // create product
    public function create()
    {
        //write query
        $query = "INSERT INTO {$this->table_name} SET
                    quote_name=:quote_name, price_avg=:price_avg, amount=:amount, created_at=:created_at";
        $stmt = $this->conn->prepare($query);

        // posted values
        $this->quote_name = htmlspecialchars(strip_tags($this->quote_name));
        $this->price_avg = htmlspecialchars(strip_tags($this->price_avg));
        $this->amount = htmlspecialchars(strip_tags($this->amount));
        //$this->portfolio_id = htmlspecialchars(strip_tags($this->portfolio_id));

        // to get timestamp for 'created' field
        $this->timestamp = date('Y-m-d H:i:s');

        // bind values 
        $stmt->bindParam(":quote_name", $this->quote_name);
        $stmt->bindParam(":price_avg", $this->price_avg);
        $stmt->bindParam(":amount", $this->amount);
        //$stmt->bindParam(":portfolio_id", $this->portfolio_id);
        $stmt->bindParam(":created_at", $this->timestamp);

        return ($stmt->execute()) ? true : false;
    }

    public function readAll() : object {
        $query = "SELECT
                    id, `quote_name`, `amount`, `price_avg`
                FROM
                    `{$this->table_name}`
                ORDER BY
                    `quote_name` ASC";
     
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
     
        return $stmt;
    }
}

