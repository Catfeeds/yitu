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

        $nickname = I('nickname');
        if(isset($nickname)){
            $where  = " car_licence like '%$nickname%' ";
        }else{
            $where = " id > 0 ";
        }
        if(isset($_GET['car_status'])){
            $where .= " and car_status = {$_GET['car_status']} ";
        }

        $total = M('Attendance')->where($where)->count();
        $REQUEST    =   (array)I('request.');
        if( isset($REQUEST['r']) ){
            $listRows = (int)$REQUEST['r'];
        }else{
            $listRows = C('LIST_ROWS') > 0 ? C('LIST_ROWS') : 10;
        }
        $page = new \COM\Page($total, $listRows, $REQUEST);

        if($total>$listRows){
            $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        }
        $p =$page->show();
        $this->assign('_page', $p? $p: '');
        $this->assign('_total',$total);

        $list = M('Attendance')->where($where)->order('want_car_time desc')->select();

        $this->assign('_list', $list);

        //获取各个出行状态车辆数量
        $result = M('Attendance')->field('car_status , count(id) total')->group('car_status')->select();
        if(!empty($result)){
            $car_status = array_column($result, 'total','car_status');
            $all = array_sum(array_values($car_status));
        }
        
        //print_r($car_status);
        $this->assign('car_status',$car_status);
        $this->assign('_all',$all);
        $this->meta_title = '出勤管理';
        
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
                $row = M('Car')->where("id = {$data['car_licence']} ")->find();
                if(empty($row)) $this->error('车辆信息错误');
                $data['car_licence'] = $row['car_title'].'-'.$row['car_licence'];
                //print_r($row);die;
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

    public function edit($id){
        $row = M('Attendance')->where(" id = {$id} ")->find();
        //print_r($row);
        if(IS_POST){

            $data = I('post.');
            if(empty($data['car_licence']) || empty($data['renter']) || empty($data['telephone']) || empty($data['want_car_time'])){
                $this->error('车牌/租车人/联系电话/取车时间为必填项');
            }

            if($data['car_ownership'] == 1 && is_numeric($data['car_licence'])){
                $data['car_id'] = $data['car_licence'];
                $row_ = M('Car')->where("id = {$data['car_licence']} ")->find();
                if(empty($row_)) $this->error('车辆信息错误');
                $data['car_licence'] = $row_['car_title'].'-'.$row_['car_licence'];
                //print_r($row);die;
            }

            if(!M('Attendance')->save($data)){
                //print_r(M('Attendance')->getLastSql());die;
                $this->error('车辆出勤编辑失败！');
            }else{
                $this->success('车辆出勤编辑成功！',U('index'));
            }
        }else{

            $this->meta_title = '出勤编辑';
            $this->assign('row',$row);
            $this->display('add');
        }
    }

    public function remove(){
        $data = I('id');

        if(empty($data)){
            $this->error('请选择要删除的数据');
        }

        if(is_array($data)){
            $id = arr2str($data);
        }else{
            $id = $data;
        }

        if(!M('Attendance')->where(" id in({$id}) ")->delete()){
            $this->error('出勤删除失败！');
        }else{
            $this->success('出勤删除成功！',U('index'));
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