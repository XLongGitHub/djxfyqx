<?php
/**
 * Created by PhpStorm.
 * User: Xulong
 * Date: 2017/8/28
 * Time: 10:32
 */
class SettlementAction extends Action {
    public function add() {
        $Settlement = M("Settlement");
        if (IS_GET) {
            $settle_id = I("get.settle_id", "", "strval");
            //数据库中创建新的记录行
            if (empty($settle_id)) {
//                $id = 0;   //此处数据库无对应数据
                $max_result_row = $Settlement->order("id desc")->limit("1")->select();
                if (empty($max_result_row)) {
                    $max_id = 0;
                } else {
                    $max_id = $max_result_row['id'];
                }
                $new_id = $max_id + 1;
                $this->assign("settle_id", $new_id);
                $this->display();
            } else {
                $result = $Settlement->where("id = $settle_id")->select();
                if (!empty($result)) {
                    $data = $result[0];
                } else {
                    $data = null;
                }
                $Settle_material = M("Settle_material");
                $materials = $Settle_material->alias("i")
                    ->join('LEFT JOIN qx_material m on m.id = i.material_id')
                    ->field('m.number, m.name, m.unit, m.unit_price, m.nature, i.*')
                    ->where("i.settle_id = $settle_id")
                    ->select();
//                var_dump($materials);
                $this->assign("settle_id", $settle_id);
                $this->assign("materials", $materials);
                $this->assign("data", $data);
                $this->display();
            }
        } else {

        }
    }

    public function addMaterial() {
        $Settle_material = M("Settle_material");
        $new_material_id = trim(I("post.new_id", "", "strval"));
        $settle_id = I("post.settle_id", "", "strval");

        if (!empty($new_material_id) && !empty($settle_id)) {
//            var_dump($new_material_id);
//            var_dump($settle_id);
            $two_old_material_ids = $Settle_material->field("material_id")->where("settle_id = $settle_id")->order("material_id")->select();
            if ($two_old_material_ids == false) {
                $old_material_ids = array();
            }
            //降维
            for ($i = 0; $i < count($two_old_material_ids); $i++) {
                $old_material_ids[] = $two_old_material_ids[$i]['material_id'];
            }
//            var_dump($two_old_material_ids);
            $new_material_ids = explode(" ", $new_material_id);
//            $max_length = count($old_material_ids) > count($new_material_ids) ? count($old_material_ids) : count($new_material_ids);
//
////            for ($i = 0; $i < len;)
//            $old_material_pos = 0;
//            $new_material_pos = 0;
//            $same_ids = array();  //相同的material_id部分
//            while (true) {
//                if ($old_material_pos >= count($old_material_ids)) break;
//                if ($new_material_pos >= count($new_material_ids)) break;
//                if ($new_material_ids[$new_material_pos] == $old_material_ids[$old_material_pos]) {
//
//                }
//            }

//            var_dump($new_material_ids);
//            var_dump($old_material_ids);
            $same_ids = array_intersect($new_material_ids, $old_material_ids);
            $new_diff_ids = array_diff($new_material_ids, $same_ids);
            $old_diff_ids = array_diff($old_material_ids, $same_ids);

//            var_dump($same_ids);
//            var_dump($new_diff_ids);
//            var_dump($old_diff_ids);

            //此处注意，返回结果数组索引的问题
            //增加
            for ($i = 0; $i < count($new_material_ids); $i++) {
//                print_r($new_diff_ids);
                if (empty($new_diff_ids[$i])) continue;
                $data['settle_id'] = $settle_id;
                $data['material_id'] = $new_diff_ids[$i];
//                var_dump("new_id ".$new_material_ids[$i]);
                $result_id = $Settle_material->data($data)->add();

//                var_dump($result_id);
                var_dump($data);
                $data = array();

            }
            //删除
            for ($i = 0; $i < count($old_material_ids); $i++) {
                if (empty($old_material_ids[$i])) continue;
                $Settle_material->where("settle_id = $settle_id and material_id = $old_diff_ids[$i]")->delete();
            }
            //暂时不变
            for ($i = 0; $i < count($same_ids); $i++) {

            }

//            $this->display("Material/chooseMaterial");

        }



    }

    public function addService() {

    }

    public function result() {
        $this->display();
    }

}