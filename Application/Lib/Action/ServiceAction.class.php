<?php
/**
 * Created by PhpStorm.
 * User: Xulong
 * Date: 2017/8/28
 * Time: 10:18
 */
class ServiceAction extends Action {
    public function add() {
        if (IS_GET) {
            $this->display();
        } else {
            $project = I("post.project", "", "strval");
            $hourly_wage = I("post.hourly_wage", "", "strval");
            $section = I("post.section", "", "strval");
            $repair_man = I("post.repair_man", "", "strval");
            $nature = I("post.nature", "", "strval");

            $data['project'] = $project;
            $data['hourly_wage'] = $hourly_wage;
            $data['section'] = $section;
            $data['repair_man'] = $repair_man;
            $data['nature'] = $nature;

            $Service = M("Service");
            $result = $Service->data($data)->add();
            if($result) {
                $this->success("success");
            } else {
                $this->error("error");
            }
        }
    }

    public function modify() {
        $Service = M("Service");
        if (IS_GET) {
            $id = I("get.id", "", "strval");
            if (!empty($id)) {
                $result = $Service->where("id = $id")->select();
                $this->assign("item", $result[0]);
                $this->display();
            }
        } else {
            $id = I("post.id", "", "strval");
            $project = I("post.project", "", "strval");
            $hourly_wage = I("post.hourly_wage", "", "strval");
            $section = I("post.section", "", "strval");
            $repair_man = I("post.repair_man", "", "strval");
            $nature = I("post.nature", "", "strval");

            $data['project'] = $project;
            $data['hourly_wage'] = $hourly_wage;
            $data['section'] = $section;
            $data['repair_man'] = $repair_man;
            $data['nature'] = $nature;

            $Service = M("Service");
            $result = $Service->where("id = $id")->save($data);
//            var_dump($data);
//            echo $id;
            exit();
        }
    }

    public function getAll() {
        $Service = M("Service");
        $result = $Service->select();
        $this->assign("result", $result);
        $this->display();
    }

    public function delete() {
        $id = I("get.id", "", "strval");
        $Service = M("Service");
        $Service->where("id = $id")->delete();
    }

    public function chooseService()
    {
        if (IS_GET) {
            $settle_id = I("get.settle_id", "", "strval");
            $Service = M("Service");
            $result = $Service->order("id desc")->select();

            //预处理,判断是否已被选中
            $Settle_service = M("Settle_service");
            $two_choose_service_ids = $Settle_service->where("settle_id = $settle_id")
                                        ->field("service_id as choose_service_id")->select();
            $choose_service_ids = array();
            for ($i = 0; $i < count($two_choose_service_ids); $i++) {
                $choose_service_ids[] = $two_choose_service_ids[$i]['choose_service_id'];
            }
//            var_dump($choose_material_ids);
            for ($i = 0; $i < count($result); $i++) {
                if (in_array($result[$i]['id'], $choose_service_ids)) {
                    $result[$i]['choose'] = "1";
                } else {
                    $result[$i]['choose'] = "0";
                }
            }
            var_dump($result);
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