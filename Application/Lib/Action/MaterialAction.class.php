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
        } else {
            $number = I("post.number", "", "strval");
            $name = I("post.name", "", "strval");
            $unit = I("post.unit", "", "strval");
            $unit_price = I("post.unit_price", "", "strval");
            $nature = I("post.nature", "", "strval");

            $data['number'] = $number;
            $data['name'] = $name;
            $data['unit'] = $unit;
            $data['unit_price'] = $unit_price;
            $data['nature'] = $nature;
            $data['create_time'] = date();
            $Material = M("Material");
            $result = $Material->add($data);
            if ($result) {
                $this->success("success");
            } else {
                $this->error("error");
            }
        }
    }

    public function modify() {
        $Material = M("Material");
        if (IS_GET) {
            $id = I("get.id", "", "strval");
            if (!empty($id)) {
                $result = $Material->where("id = $id")->select();
                var_dump($result);
            }
//            exit();
            $this->assign("item", $result[0]);
            $this->display();
        } else {
            $id = I("post.id", "", "strval");
            $number = I("post.number", "", "strval");
            $name = I("post.name", "", "strval");
            $unit = I("post.unit", "", "strval");
            $unit_price = I("post.unit_price", "", "strval");
            $nature = I("post.nature", "", "strval");


            $data['number'] = $number;
            $data['name'] = $name;
            $data['unit'] = $unit;
            $data['unit_price'] = $unit_price;
            $data['nature'] = $nature;
            $data['create_time'] = date();
            echo $id;
            $result = $Material->where("id = $id")->save($data);
            exit();
        }
    }

    public function getAll() {
        $Material = M("Material");
        $result = $Material->select();
        $this->assign("result", $result);
        $this->display();
    }

    public function delete() {
        $id = I("get.id", "", "strval");
        if (!empty($id)) {
            $Material = M("Material");
            $Material->where("id = $id")->delete();
        }
    }
}