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
                var_dump($max_result_row);
//                $max_id = 0;
                if (empty($max_result_row)) {
                    $max_id = 0;
                    var_dump($max_id);
                } else {
                    $max_id = $max_result_row[0]['id'];
                    var_dump($max_id);
                }
                var_dump($max_id);
                $new_id = $max_id + 1;
                $this->assign("settle_id", $new_id);
                var_dump($new_id);
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
        } else if (IS_POST){
            $repair_unit = I("post.repair_unit", "", "strval");
            $job_number = I("post.job_number", "", "strval");
            $plate_number = I("post.plate_number", "", "strval");
            $contact_man = I("post.contact_man", "", "strval");
            $contact_phone = I("post.contact_phone", "", "strval");
            $car_type = I("post.car_type", "", "strval");
            $chassis_number = I("post.chassis_number", "", "strval");
            $engine_number = I("post.engine_number", "", "strval");
            $start_repair_date = I("post.start_repair_date", "", "strval");
            $mileage = I("post.mileage", "", "strval");
            $repair_type = I("post.repair_type", "", "strval");
            $address = I("post.address", "", "strval");
            $my_contact_method = I("post.my_contact_method", "", "strval");
            $fax = I("post.fax", "", "strval");
            $settle_man = I("post.settle_man", "", "strval");
            $settle_date = I("post.settle_date", "", "strval");
            $open_bank = I("post.open_bank", "", "strval");
            $account = I("account");
            $create_time = 0;
            $write_time = 0;

            $data['repair_unit'] = $repair_unit;
            $data['job_number'] = $job_number;
            $data['plate_number'] = $plate_number;
            $data['contact_man'] = $contact_man;
            $data['contact_phone'] = $contact_phone;
            $data['car_type'] = $car_type;
            $data['chassis_number'] = $chassis_number;
            $data['engine_number'] = $engine_number;
            $data['start_repair_date'] = $start_repair_date;
            $data['mileage'] = $mileage;
            $data['repair_type'] = $repair_type;
            $data['address'] = $address;
            $data['my_contact_method'] = $my_contact_method;
            $data['fax'] = $fax;
            $data['settle_man'] = $settle_man;
            $data['settle_date'] = $settle_date;
            $data['open_bank'] = $open_bank;
            $data['account'] = $account;
            $data['create_time'] = $create_time;
            $data['write_time'] = $write_time;

            $result_id = $Settlement->data($data)->add();
            var_dump($result_id);
//            exit();

//            if ($result_id) {
//                $this->success("结算单保存成功");
//            } else {
//                $this->error("结算单保存失败");
//            }
            $data = null; //清除数据
            $result = $Settlement->where("id = $result_id")->select();
            if (!empty($result)) {
                $data = $result[0];
            } else {
                $data = null;
            }
            $Settle_material = M("Settle_material");
            $materials = $Settle_material->alias("i")
                ->join('LEFT JOIN qx_material m on m.id = i.material_id')
                ->field('m.number, m.name, m.unit, m.unit_price, m.nature, i.*')
                ->where("i.settle_id = $result_id")
                ->select();
//                var_dump($materials);
            $this->assign("settle_id", $result_id);
            $this->assign("materials", $materials);
            $this->assign("data", $data);
//            var_dump($data);
//            exit();
            $this->display();

//            echo "ser";
        }
    }

    public function addMaterial() {
        $Settle_material = M("Settle_material");
        $Settlement = M("Settlement");
        if (IS_POST) {
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
                //*********************************************************
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
                $Settle_service = M('Settle_service');
                $services = $Settle_service->alias("i")
                    ->join('LEFT JOIN qx_service s on s.id = i.service_id')
                    ->field('s.project, s.hourly_wage, s.section, s.repair_man, s.nature, i.*')
                    ->where("i.settle_id = $settle_id")
                    ->select();
                $this->assign("settle_id", $settle_id);
                $this->assign("materials", $materials);
                $this->assign("services", $services);
                $this->assign("data", $data);
                $this->display("add");
            }
        }
    }

    /**
     * 添加维修服务
     */
    public function addService() {
        $Settle_service = M("Settle_service");
        $Settlement = M("Settlement");
        if (IS_POST) {
            $new_service_id = trim(I("post.new_id", "", "strval"));
            $settle_id = I("post.settle_id", "", "strval");

            if (!empty($new_service_id) && !empty($settle_id)) {
                $two_old_service_ids = $Settle_service->field("service_id")->where("settle_id = $settle_id")->order("service_id")->select();
                if ($two_old_service_ids == false) {
                    $old_service_ids = array();
                }
                //降维
                for ($i = 0; $i < count($two_old_service_ids); $i++) {
                    $old_service_ids[] = $two_old_service_ids[$i]['service_id'];
                }
                //            var_dump($two_old_material_ids);
                $new_service_ids = explode(" ", $new_service_id);
                $same_ids = array_intersect($new_service_ids, $old_service_ids);
                $new_diff_ids = array_diff($new_service_ids, $same_ids);
                $old_diff_ids = array_diff($old_service_ids, $same_ids);

                //            var_dump($same_ids);
                //            var_dump($new_diff_ids);
                //            var_dump($old_diff_ids);

                //此处注意，返回结果数组索引的问题
                //增加
                for ($i = 0; $i < count($new_service_ids); $i++) {
                    //                print_r($new_diff_ids);
                    if (empty($new_diff_ids[$i])) continue;
                    $data['settle_id'] = $settle_id;
                    $data['service_id'] = $new_diff_ids[$i];
                    //                var_dump("new_id ".$new_material_ids[$i]);
                    $result_id = $Settle_service->data($data)->add();

                    //                var_dump($result_id);
                    var_dump($data);
                    $data = array();
                }
                //删除
                for ($i = 0; $i < count($old_service_ids); $i++) {
                    if (empty($old_service_ids[$i])) continue;
                    $Settle_service->where("settle_id = $settle_id and service_id = $old_diff_ids[$i]")->delete();
                }
                //暂时不变
                for ($i = 0; $i < count($same_ids); $i++) {

                }
                //*********************************************************
                $result = $Settlement->where("id = $settle_id")->select();
                if (!empty($result)) {
                    $data = $result[0];
                } else {
                    $data = null;
                }
//                $Settle_material = M("Settle_material");
                $services = $Settle_service->alias("i")
                    ->join('LEFT JOIN qx_service s on s.id = i.service_id')
                    ->field('s.project, s.hourly_wage, s.section, s.repair_man, s.nature, i.*')
                    ->where("i.settle_id = $settle_id")
                    ->select();
                $Settle_material = M("Settle_material");
                $materials = $Settle_material->alias("i")
                    ->join('LEFT JOIN qx_material m on m.id = i.material_id')
                    ->field('m.number, m.name, m.unit, m.unit_price, m.nature, i.*')
                    ->where("i.settle_id = $settle_id")
                    ->select();
                $this->assign("materials", $materials);
                $this->assign("settle_id", $settle_id);
                $this->assign("services", $services);
                $this->assign("data", $data);

                $this->display("add");
            }
        }
    }

    /**
     * 保存和添加结算单都在这里实现
     */
    public function modify() {
        $Settlement = M("Settlement");
        $Settle_material = M("Settle_material");
        if (IS_POST) {
            $settle_id = I("post.settle_id", "", "strval");

            $repair_unit = I("post.repair_unit", "", "strval");
            $job_number = I("post.job_number", "", "strval");
            $plate_number = I("post.plate_number", "", "strval");
            $contact_man = I("post.contact_man", "", "strval");
            $contact_phone = I("post.contact_phone", "", "strval");
            $car_type = I("post.car_type", "", "strval");
            $chassis_number = I("post.chassis_number", "", "strval");
            $engine_number = I("post.engine_number", "", "strval");
            $start_repair_date = I("post.start_repair_date", "", "strval");
            $mileage = I("post.mileage", "", "strval");
            $repair_type = I("post.repair_type", "", "strval");
            $address = I("post.address", "", "strval");
            $my_contact_method = I("post.my_contact_method", "", "strval");
            $fax = I("post.fax", "", "strval");
            $settle_man = I("post.settle_man", "", "strval");
            $settle_date = I("post.settle_date", "", "strval");
            $open_bank = I("post.open_bank", "", "strval");
            $account = I("account");
            $create_time = 0;
            $write_time = 0;

            $data['repair_unit'] = $repair_unit;
            $data['job_number'] = $job_number;
            $data['plate_number'] = $plate_number;
            $data['contact_man'] = $contact_man;
            $data['contact_phone'] = $contact_phone;
            $data['car_type'] = $car_type;
            $data['chassis_number'] = $chassis_number;
            $data['engine_number'] = $engine_number;
            $data['start_repair_date'] = $start_repair_date;
            $data['mileage'] = $mileage;
            $data['repair_type'] = $repair_type;
            $data['address'] = $address;
            $data['my_contact_method'] = $my_contact_method;
            $data['fax'] = $fax;
            $data['settle_man'] = $settle_man;
            $data['settle_date'] = $settle_date;
            $data['open_bank'] = $open_bank;
            $data['account'] = $account;
            $data['create_time'] = $create_time;
            $data['write_time'] = $write_time;
//         记录数量金额
            $two_material_ids =  $Settle_material->where("settle_id = $settle_id")->field("material_id")->select();
            $materials_ids = array();
            if ($two_material_ids) {
                for ($i = 0; $i < count($two_material_ids); $i++) {
                    $materials_ids[] = $two_material_ids[$i]['material_id'];
                }
            }
            var_dump($materials_ids);
            for ($i = 0; $i < count($materials_ids); $i++) {
                $quantity = I("post.".$materials_ids[$i]."_quantity", "", "strval");
                var_dump("post.".$i."_quantity");
                var_dump($quantity);
                $money = I("post.".$materials_ids[$i]."_money", "", "strval");
                $settle_material_data = array();
                $settle_material_data['quantity'] = $quantity;
                $settle_material_data['money'] = $money;
                $Settle_material->where("settle_id = $settle_id and material_id = $materials_ids[$i]")
                    ->save($settle_material_data);
                var_dump($settle_material_data);
            }
//            exit();

//            判断添加还是修改记录
            var_dump($settle_id);
            $is_exists = null;
            if (!empty($settle_id)) {
                $is_exists = $Settlement->where("id = $settle_id")->select();
                var_dump($is_exists);
            }
            if (empty($settle_id) || empty($is_exists)) {
                $result_id = $Settlement->data($data)->add();

                var_dump("add");
            } else {
                $result_id = $Settlement->where("id = $settle_id")->save($data);
                var_dump("save");
            }
//            var_dump($result_id);
//            exit();
//            if ($result_id) {
//                $this->success("结算单保存成功");
//            } else {
//                $this->error("结算单保存失败");
//            }
            $data = null; //清除数据
            $result = $Settlement->where("id = $settle_id")->select();
            if (!empty($result)) {
                $data = $result[0];
            } else {
                $data = null;
            }
            $materials = $Settle_material->alias("i")
                ->join('LEFT JOIN qx_material m on m.id = i.material_id')
                ->field('m.number, m.name, m.unit, m.unit_price, m.nature, i.*')
                ->where("i.settle_id = $settle_id")
                ->select();
            $Settle_service = M("Settle_service");
            $services = $Settle_service->alias("i")
                ->join('LEFT JOIN qx_service s on s.id = i.service_id')
                ->field('s.project, s.hourly_wage, s.section, s.repair_man, s.nature, i.*')
                ->where("i.settle_id = $settle_id")
                ->select();
//                var_dump($materials);
            $this->assign("settle_id", $settle_id);
            $this->assign("materials", $materials);
            $this->assign("services", $services);
            $this->assign("data", $data);
//            var_dump($data);
//            exit();
            $this->display("add");
        } else if (IS_GET) {
            $settle_id = I("get.settle_id", "", "strval");
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
            $Settle_service = M("Settle_service");
            $services = $Settle_service->alias("i")
                ->join('LEFT JOIN qx_service s on s.id = i.service_id')
                ->field('s.project, s.hourly_wage, s.section, s.repair_man, s.nature, i.*')
                ->where("i.settle_id = $settle_id")
                ->select();
            $this->assign("settle_id", $settle_id);
            $this->assign("materials", $materials);
            $this->assign("services", $services);
            $this->assign("data", $data);
            $this->display("add");
        }
    }

    /**
     * 显示数据
     */
    public function show() {
        $Settlement = M("Settlement");
        $settle_id = I("get.settle_id", "", "strval");
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
        $this->assign("settle_id", $settle_id);
        $this->assign("materials", $materials);
        $this->assign("data", $data);
        $this->display();
    }
//    public function addService() {
//
//    }

    public function result() {
        $this->display();
    }

}