DROP DATABASE IF EXISTS `djxfyqx`;
create database `djxfyqx`;
use `djxfyqx`;

DROP TABLE IF EXISTS `qx_material`;
CREATE TABLE `qx_material` (
  `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
  `number` VARCHAR(255) COMMENT '配件件号',
  `name` VARCHAR(255) COMMENT '配件名称',
  `unit` VARCHAR(255) COMMENT '单位',
  `unit_price` VARCHAR(255) COMMENT '单价',
  `nature` VARCHAR(255) COMMENT '性质',
  `create_time` VARCHAR(20) COMMENT '创建时间',
  `write_time` VARCHAR(20) COMMENT '修改时间'
);

DROP TABLE IF EXISTS `qx_service`;
CREATE TABLE `qx_service` (
  `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
  `project` VARCHAR(255) COMMENT '维修项目',
  `hourly_wage` VARCHAR(255) COMMENT '工时费',
  `section` VARCHAR(255) COMMENT '工段',
  `repair_man` VARCHAR(255) COMMENT '主修人',
  `nature` VARCHAR(255) COMMENT '性质',
  `create_time` VARCHAR(20) COMMENT '创建时间',
  `write_time` VARCHAR(20) COMMENT '修改时间'
);

DROP TABLE IF EXISTS `qx_settlement`;
CREATE TABLE `qx_settlement` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `repair_unit` VARCHAR(255) COMMENT '送修单位',
    `job_number` VARCHAR(255) COMMENT '工号',
    `plate_number` VARCHAR(255) COMMENT '车牌号',
    `contact_man` VARCHAR(255) COMMENT '联系人',
    `contact_phone` VARCHAR(255) COMMENT '联系电话',
    `car_type` VARCHAR(255) COMMENT '车型',
    `chassis_number` VARCHAR(255) COMMENT '底盘号',
    `engine_number` VARCHAR(255) COMMENT '发动机号',
    `start_repair_date` VARCHAR(255) COMMENT '送修日期',
    `mileage` VARCHAR(255) COMMENT '里程',
    `repair_type` VARCHAR(255) COMMENT '维修类型',
    `service_id` INT(11) COMMENT '维修内容id',
    `material_id` INT(11) COMMENT '维修材料id',
    `address` VARCHAR(255) COMMENT '地址',
    `my_contact_method` VARCHAR(255) COMMENT '我的联系方式',
    `fax` VARCHAR(255) COMMENT '传真',
    `man` VARCHAR(255) COMMENT '结算人',
    `date` VARCHAR(255) COMMENT '结算日期',
    `open_bank` VARCHAR(255) COMMENT '开户行',
    `account` VARCHAR(255) COMMENT '账号',
    `create_time` VARCHAR(20),
    `write_time` VARCHAR(20)
);