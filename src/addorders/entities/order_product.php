<?php

class OrderProduct{
    public $product_id;
    public $order_id;
    public $quantity;

    public function __construct($pid, $oid, $q){
        $this->product_id=$pid;
        $this->order_id=$oid;
        $this->quantity=$q;
    }
}
?>