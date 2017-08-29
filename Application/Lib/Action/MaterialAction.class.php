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
        $result = $Material->order("id desc")->select();
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

    public function chooseMaterial() {
        if (IS_GET) {
            $settle_id = I("get.settle_id", "", "strval");

            $Material = M("Material");
            $result = $Material->order("id desc")->select();

            //预处理,判断是否已被选中
            $Settle_material = M("Settle_material");
            $two_choose_material_ids = $Settle_material->where("settle_id = $settle_id")->field("material_id as choose_material_id")->select();
            $choose_material_ids = array();
            for ($i = 0; $i < count($two_choose_material_ids); $i++) {
                $choose_material_ids[] = $two_choose_material_ids[$i]['choose_material_id'];
            }
//            var_dump($choose_material_ids);
            for ($i = 0; $i < count($result); $i++) {
                if (in_array($result[$i]['id'], $choose_material_ids)) {
                    $result[$i]['choose'] = "1";
                } else {
                    $result[$i]['choose'] = "0";
                }
            }
//            var_dump($result);
//            exit();

            $this->assign("settle_id", $settle_id);
            $this->assign("result", $result);
            $this->display();
        } else {
            var_dump(I("post.new_id"));
            exit();
        }
    }
}