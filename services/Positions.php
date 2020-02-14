<?php

class Positions
{
    // database connection and table name
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
     * @var datetime
     */
    public $created_at;
    /**
     * @var timestamp
     */
    public $updated_at;

    private $_table_name = "positions";

    /*private $_postitions_table_sort_keys = [
        'quote' => 'quote_name',
        'amount' => 'amount',
        'created_at' => 'created_at',
        'updated_at' => 'updated_at',
    ];

    private $_positions_computed_sort_keys = [
        'profit' => 'profit_money',
        'percentale' => 'profit',
    ];*/

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param $id
     * @return Positions
     */
    public function setId($id): Positions
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return \varchar
     */
    public function getQuoteName(): \varchar
    {
        return $this->quote_name;
    }

    /**
     * @param \varchar $quote_name
     * @return Positions
     */
    public function setQuoteName(string $quote_name): Positions
    {
        $this->quote_name = $quote_name;

        return $this;
    }

    /**
     * @return float
     */
    public function getPriceAvg(): float
    {
        return $this->price_avg;
    }

    /**
     * @param float $price_avg
     * @return Positions
     */
    public function setPriceAvg(float $price_avg): Positions
    {
        $this->price_avg = $price_avg;

        return $this;
    }

    /**
     * @return float
     */
    public function getPriceCur(): float
    {
        return $this->price_cur;
    }

    /**
     * @param float $price_cur
     * @return Positions
     */
    public function setPriceCur(float $price_cur): Positions
    {
        $this->price_cur = $price_cur;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     * @return Positions
     */
    public function setAmount(int $amount): Positions
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return \timestamp
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param \timestamp $updated_at
     * @return Positions
     */
    public function setUpdatedAt($updated_at): Positions
    {
        $this->updated_at = date('Y-m-d H:i:s', $updated_at);

        return $this;
    }

    /****************************** class methods ***********************************/

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
        $query = "INSERT INTO {$this->_table_name} 
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
        $query = "SELECT id FROM {$this->_table_name} WHERE `quote_name`=:quote_name";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":quote_name", $this->quote_name);
        $stmt->execute();

        return ($stmt->rowCount() > 0) ? true : false;
    }

    /**
     * @param \StocksAPI $stocksAPI
     * @param array $params
     * @return array
     */
    public function readAll(\StocksAPI $stocksAPI, $params = []): array
    {
        $arItems = [];

        $query = "SELECT * FROM `{$this->_table_name}`";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = [];
            $item = $row;

            $item['quote_icon'] = $stocksAPI::getLogo($item['quote_name']);

            if (is_null($item['price_cur']) || (!is_null($item['price_cur']) && $item['updated_at'] < date('Y-m-d H:i:s', time() - 3600))) {
                $item['price_cur'] = $stocksAPI::getQuote($item['quote_name']);

                // TODO: re-factor this piece into a separate method
                $query = "UPDATE `{$this->_table_name}` SET `price_cur` = {$item['price_cur']}, `updated_at` = '{$this->setUpdatedAt(time())->getUpdatedAt()}' WHERE `id` = {$item['id']}";
                $stmt = $this->conn->prepare($query);
                $stmt->execute();
            }

            $item['delta_money'] = round($item['amount'] * ($item['price_cur'] - $item['price_avg']), 2);
            $item['delta_prcnt'] = round($item['delta_money'] * 100 / ($item['price_avg'] * $item['amount']), 2);

            $arItems[] = $item;
        }

        return $arItems;
    }

    public function getByID()
    {
        $query = "SELECT `quote_name`, `amount`, `price_avg` FROM `{$this->_table_name}` WHERE `id` = {$this->getId()}";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePosition(): int
    {
        $query = "UPDATE `{$this->_table_name}` SET `amount` = {$this->getAmount()}, `price_avg` = '{$this->getPriceAvg()}', `updated_at` = '{$this->getUpdatedAt()}' WHERE `id` = {$this->getId()}";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->rowCount();
    }
}

