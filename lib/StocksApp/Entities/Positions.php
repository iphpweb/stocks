<?php
/**
 * Created by PhpStorm.
 * User: papilin.es
 * Date: 29.08.2019
 * Time: 19:24
 */

namespace StocksApp\Entities;

/**
 * @Entity
 * @Table(name="positions")
 */
class Position
{
    /**
     * @Id @Column(type="integer") @GeneratedValue
     * @var int
     */
    protected $id;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $quote_name;

    /**
     * @Column(type="float")
     * @var double
     */
    protected $price_avg;

    /**
     * @Column(type="float")
     * @var double
     */
    protected $price_last;

    /**
     * @Column(type="integer")
     * @var int
     */
    protected $amount;

    /**
     * @Column(type="datetime")
     * @var DateTime
     */
    protected $created_at;

    /**
     * @Column(type="datetime")
     * @var DateTime
     */
    protected $updated_at;

    public function getId()
    {
        return $this->id;
    }

    public function getQuoteName()
    {
        return $this->quote_name;
    }

    public function setQuoteName($quote_name)
    {
        $this->quote_name = $quote_name;
    }

    public function getPriceAvg()
    {
        return $this->price_avg;
    }

    public function setPriceAvg($price_avg)
    {
        $this->price_avg = $price_avg;
    }

    public function getPriceLast()
    {
        return $this->price_last;
    }

    public function setPriceLast($price_last)
    {
        $this->price_last = $price_last;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTime $created_at)
    {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(DateTime $updated_at)
    {
        $this->updated_at = $updated_at;
    }
}
