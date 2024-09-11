<?php

class ShoppingCart {

    private $basket = [];
    private $db_con;

    public function __construct($db) {
        $this->db_con = $db;
    }

    public function add_to_cart(...$items) {
        $codes = $this->db_con->get_valid_codes();
        foreach($items as $item) {
            if(in_array($item, $codes)) {
                $this->basket[] = $item;
            }
        }
        
    }

    public function total() {
        $total = 0.0;
        $counts = array_count_values($this->basket);
        foreach ($counts as $code => $count) {
            $total += $this->db_con->get_price($code) * $count;
        }
        $total = $this->calc_special_offers($total);
        $total = $this->calc_delivery($total);

        return round($total, 2, PHP_ROUND_HALF_DOWN);
    }

    

    private function calc_delivery($total) {
        if($total < 50.0) {
            $total += 4.95;
        } elseif ($total < 90.0) {
            $total += 2.95;
        }
        return $total;
    }

    private function calc_special_offers($total) {
        $offers = $this->db_con->get_offers();
        foreach ($offers as $offer) {
            switch ($offer) {
                case "BOGO50R":
                    $red_count = array_count_values($this->basket)['RF1'];
                    $total -= intdiv($red_count, 2) * 0.5 * $this->db_con->get_price("RF1");
                    break;
            }
        }
        return $total;
    }
}