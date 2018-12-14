<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/13
 * Time: 12:20
 */

namespace Admin\Controller;


class AttendanceController extends AdminController
{


    public function index(){

        $this->display();
    }

    public function add(){
        if(IS_POST){

            $data = I('post.');
            if(empty($data['car_licence']) || empty($data['renter']) || empty($data['telephone']) || empty($data['want_car_time'])){
                $this->error('车牌/租车人/联系电话/取车时间为必填项');
            }

            if($data['car_ownership'] == 1 && is_numeric($data['car_licence'])){
                $data['car_id'] = $data['car_licence'];
            }
            if(!M('Attendance')->add($data)){
                $this->error('车辆出勤添加失败！');
            }else{
                $this->success('车辆出勤添加成功！',U('index'));
            }
        }else{

            $this->display();
        }
    }


    public function search(){
        $term = I('get.term');
        if(!empty($term)){
            $where = " car_licence like '%{$term}%' or car_title like '%{$term}%' ";
        }else{
            $where = 'id > 0';
        }
        $rows = M('Car')->field('id ,CONCAT_WS("-",car_title,car_licence) as text')->where($where)->limit(10)->select();
        $this->ajaxReturn($rows);
    }
}