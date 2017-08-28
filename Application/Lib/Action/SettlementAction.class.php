<?php
/**
 * Created by PhpStorm.
 * User: Xulong
 * Date: 2017/8/28
 * Time: 10:32
 */
class SettlementAction extends Action {
    public function add() {
        if (IS_GET) {
            $this->display();
        }
    }

    public function result() {
        $this->display();
    }

}