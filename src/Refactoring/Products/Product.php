<?php

namespace Refactoring\Products;

use Brick\Math\BigDecimal;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Product
{
    /**
     * @var UuidInterface
     */
    private $serialNumber;

    /**
     * @var BigDecimal
     */
    private $price;

    /**
     * @var string
     */
    private $desc;

    /**
     * @var string
     */
    private $longDesc;

    /**
     * @var int
     */
    private $counter;

    /**
     * Product constructor.
     * @param BigDecimal|null $price
     * @param string|null $desc
     * @param string|null $longDesc
     * @param int|null $counter
     */
    public function __construct(?BigDecimal $price, ?string $desc, ?string $longDesc, ?int $counter)
    {
        $this->serialNumber = Uuid::uuid4();
        $this->price = $price;
        $this->desc = $desc;
        $this->longDesc = $longDesc;
        $this->counter = $counter;
    }

    /**
     * @return UuidInterface
     */
    public function getSerialNumber(): UuidInterface
    {
        return $this->serialNumber;
    }

    /**
     * @return BigDecimal
     */
    public function getPrice(): BigDecimal
    {
        return $this->checkPriceNull()->checkPriceInvalid()->price;
    }

    /**
     * @return string
     */
    public function getDesc(): string
    {
        return $this->checkNullOrEmptyDesc()->desc;
    }

    /**
     * @return string
     */
    public function getLongDesc(): string
    {
        return $this->checkNullOrEmptyLongDesc()->longDesc;
    }

    /**
     * @return int
     */
    public function getCounter(): int
    {
        return $this->checkCounterNull()->checkCounterNegative()->counter;
    }

    /**
     * @throws \Exception
     */
    public function decrementCounter(): void
    {
//        if ($this->price != null && $this->price->getSign() > 0) {
//            if ($this->counter === null) {
//                throw new \Exception("null counter");
//            }
//
//            $this->counter = $this->counter - 1;
//
//            if ($this->counter < 0) {
//                throw new \Exception("Negative counter");
//            }
//        } else {
//            throw new \Exception("Invalid price");
//
//        }
        $this->counter = $this->checkPriceNull()->checkPriceInvalid()->checkCounterNull()->counter - 1;
        $this->checkCounterNegative();
    }

    /**
     * @throws \Exception
     */
    public function incrementCounter(): void
    {
//        if ($this->price != null && $this->price->getSign() > 0) {
//            if ($this->counter === null) {
//                throw new \Exception("null counter");
//            }
//
//            if ($this->counter + 1 < 0) {
//                throw new \Exception("Negative counter");
//            }
//
//            $this->counter = $this->counter + 1;
//        } else {
//            throw new \Exception("Invalid price");
//        }
        $this->counter = $this->checkPriceNull()->checkPriceInvalid()->checkCounterNull()->counter + 1;
        $this->checkCounterNegative();
    }

    /**
     * @param BigDecimal|null $newPrice
     * @throws \Exception
     */
    public function changePriceTo(?BigDecimal $newPrice): void
    {
//        if ($this->counter === null) {
//            throw new \Exception("null counter");
//        }
//
//        if ($this->counter > 0) {
//            if ($newPrice === null) {
//                throw new \Exception("new price null");
//            }
//
//            $this->price = $newPrice;
//        }
        $this->checkCounterNull()->checkNewPriceNull($newPrice);
        $this->price = $newPrice;
    }

    /**
     * @param string|null $charToReplace
     * @param string|null $replaceWith
     * @throws \Exception
     */
    public function replaceCharFromDesc(?string $charToReplace, ?string $replaceWith): void
    {
//        if ($this->longDesc === null || empty($this->longDesc) || $this->desc === null || empty($this->desc)) {
//            throw new \Exception("null or empty desc");
//        }
//
//        $this->longDesc = str_replace($charToReplace, $replaceWith, $this->longDesc);
//        $this->desc = str_replace($charToReplace, $replaceWith, $this->desc);
        $this->longDesc = str_replace($charToReplace, $replaceWith, $this->checkNullOrEmptyLongDesc()->longDesc);
        $this->desc = str_replace($charToReplace, $replaceWith, $this->checkNullOrEmptyDesc()->desc);
    }

    /**
     * @return string
     */
    public function formatDesc(): string {
//        if ($this->longDesc === null || empty($this->longDesc) || $this->desc === null || empty($this->desc)) {
//            return "";
//        }
        
        if ($this->isLongDescNull() || $this->isLongDescEmpty() || $this->isDescNull() || $this->isDescEmpty()) {
            return "";
        }

        return $this->desc . " *** " . $this->longDesc;
    }
    
    protected function checkPriceNull(){
        if($this->price === null){
            throw new \Exception("Price null");
        }
        return $this;
    }
    
    protected function checkNewPriceNull($newPrice){
        if($newPrice === null){
            throw new \Exception("new price null");
        }
        return $this;
    }
    
    protected function checkPriceInvalid(){
        if($this->price->getSign() <= 0){
            throw new \Exception("Invalid price");
        }
        return $this;
    }
    
    protected function checkCounterNull(){
        if($this->counter === null){
            throw new \Exception("null counter");
        }
        return $this;
    }
    
    protected function checkCounterNegative(){
        if($this->counter < 0){
            throw new \Exception("Negative counter");
        }
        return $this;
    }
    
    protected function isDescNull(){
        return (bool) $this->desc;
    }
    
    protected function isDescEmpty(){
        return empty($this->desc);
    }
    
    protected function isLongDescNull(){
        return (bool)$this->longDesc;
    }
    
    protected function isLongDescEmpty(){
        return empty($this->longDesc);
    }
    
    protected function checkNullOrEmptyDesc(){
        if($this->isDescNull() || $this->isDescEmpty()){
            throw new \Exception("null or empty desc");
        }
        return $this;
    }
    
    protected function checkNullOrEmptyLongDesc(){
        if($this->isLongDescNull() || $this->isLongDescEmpty()){
            throw new \Exception("null or empty longDesc");
        }
        return $this;
    }
}
