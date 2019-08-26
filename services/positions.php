<?php

class Positions
{
    // database connection and table name
    private $conn;
    private $table_name = "positions";

    /**
     * @var primary key
     */
    public $id;

    /**
     * @var varchar
     */
    public $quote_name;

    /**
     * @var double
     */
    public $price_avg;

    /**
     * @var double
     */
    public $price_cur;

    /**
     * @var int
     */
    public $amount;

    /**
     * @var int
     */
    public $portfolio_id;

    /**
     * @var datetime
     */
    public $created_at;

    /**
     * @var timestamp
     */
    public $updated_at;

    /**
     * @var timestamp
     */
    public $timestamp;

    /**
     * Positions constructor.
     * @param $db
     * get DB instance
     */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        //write query
        $query = "INSERT INTO {$this->table_name} 
                  SET quote_name=:quote_name, price_avg=:price_avg, amount=:amount, created_at=:created_at";
        $stmt = $this->conn->prepare($query);

        // posted values
        $this->quote_name = htmlspecialchars(strip_tags($this->quote_name));
        $this->price_avg = htmlspecialchars(strip_tags($this->price_avg));
        $this->amount = htmlspecialchars(strip_tags($this->amount));
        //$this->portfolio_id = htmlspecialchars(strip_tags($this->portfolio_id));

        $this->timestamp = date('Y-m-d H:i:s');

        $stmt->bindParam(":quote_name", $this->quote_name);
        $stmt->bindParam(":price_avg", $this->price_avg);
        $stmt->bindParam(":amount", $this->amount);
        //$stmt->bindParam(":portfolio_id", $this->portfolio_id);
        $stmt->bindParam(":created_at", $this->timestamp);

        return ($stmt->execute()) ? true : false;
    }

    public function isExists()
    {
        $query = "SELECT id FROM {$this->table_name} WHERE `quote_name`=:quote_name";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":quote_name", $this->quote_name);
        $stmt->execute();

        return ($stmt->rowCount() > 0) ? true : false;
    }

    public function readAll()
    {
        $query = "SELECT id, `quote_name`, `amount`, `price_avg` FROM `{$this->table_name}` ORDER BY `quote_name` ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}

