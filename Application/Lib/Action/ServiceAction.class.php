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
}