<?php
/**
 * Created by PhpStorm.
 * User: Xulong
 * Date: 2017/8/27
 * Time: 22:43
 */
class MaterialAction extends Action {
    public function index() {
        echo "hello";
    }

    public function add() {
        if (IS_GET) {
            $this->display();
        }
    }
}