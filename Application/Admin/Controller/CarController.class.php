<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Controller;
use User\Api\UserApi;

/**
 * 后台用户控制器
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */

class CarController extends AdminController {

    public function index(){
        $where = " id > 0 ";
        $data = I('get.');
        if(isset($data['nickname'])){
            $where  .= " and car_title like '%{$data['nickname']}%' or car_licence  like '%{$data['nickname']}%' ";
        }
        if(isset($data['car_status'])){
            $where  .= " and car_status={$data['car_status']} ";
        }
        $total = M('Car')->where($where)->count();
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

        $list = M('Car')->field('*,case car_status when 1 then "待收车" when 2 then "待查章" when 3 then "待出租" end as car_status')->where($where)->order('id desc')->select();

        $this->assign('_list', $list);

        //获取各个出行状态车辆数量
        $result = M('Car')->field('car_status , count(id) total')->group('car_status')->select();
        if(!empty($result)){
            $car_status = array_column($result, 'total','car_status');
            $all = array_sum(array_values($car_status));
        }
        $this->assign('car_status',$car_status);
        $this->assign('_all', $all);
        $this->meta_title = '车辆管理';
        $this->display();
    }

    public function add(){

        if(IS_POST){

            if(empty($_POST['car_title']) || empty($_POST['car_licence']) ){
                $this->error('车名/车牌为必填');
            }
            $car_licence = M('Car')->where("car_licence = '{$_POST['car_licence']}'")->getField('car_licence');
            if(!empty($car_licence)){
                $this->error('该牌照车辆已录入');
            }

            if(!empty($_FILES['file'])){
                if(empty($_FILES['file']['tmp_name'])){
                    $this->error('图片太大');
                }
                /* 调用文件上传组件上传文件 */
                $Picture = D('Picture');
                $pic_driver = C('PICTURE_UPLOAD_DRIVER');
                $car_driver = C('PICTURE_UPLOAD');
                $car_driver['rootPath'] = 'Uploads/Car/';

                $info = $Picture->upload(
                    $_FILES,
                    $car_driver,
                    C('PICTURE_UPLOAD_DRIVER'),
                    C("UPLOAD_{$pic_driver}_CONFIG")
                ); //TODO:上传到远程服务器
                if($info){
                    $_POST['car_photo'] = $info['file']['id'];
                }
            }

            if(!M('Car')->add($_POST)){
                $this->error('车辆添加失败！');
            }else{
                $this->success('车辆添加成功！',U('index'));
            }

        } else {
            $this->meta_title = '车辆新增';
            $this->display();
        }
    }


    public function edit($id){
        $row = M('Car')->where(" id = {$id} ")->find();
        if(IS_POST){

            if(empty($_POST['car_title']) || empty($_POST['car_licence']) ){
                $this->error('车名/车牌为必填');
            }
            $car_id = M('Car')->where("car_licence = '{$_POST['car_licence']}' and id != {$id}")->getField('id');

            if($car_id > 0 ){
                $this->error('该牌照车辆已录入');
            }

            if(!empty($_FILES['file'])){
                if(empty($_FILES['file']['tmp_name'])){
                    $this->error('图片太大');
                }
                /* 调用文件上传组件上传文件 */
                $Picture = D('Picture');
                $pic_driver = C('PICTURE_UPLOAD_DRIVER');
                $car_driver = C('PICTURE_UPLOAD');
                $car_driver['rootPath'] = './Uploads/Car/';

                $info = $Picture->upload(
                    $_FILES,
                    $car_driver,
                    C('PICTURE_UPLOAD_DRIVER'),
                    C("UPLOAD_{$pic_driver}_CONFIG")
                ); //TODO:上传到远程服务器
                if($info){
                    $_POST['car_photo'] = $info['file']['id'];
                }
            }

            if(!M('Car')->save($_POST)){
                $this->error('车辆编辑失败！');
            }else{
                $this->success('车辆编辑成功！',U('index'));
            }
        }else{

            $this->meta_title = '车辆编辑';
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

        if(!M('Car')->where(" id in({$id}) ")->delete()){
            $this->error('车辆删除失败！');
        }else{
            $this->success('车辆删除成功！',U('index'));
        }
    }

    /**
     * 导出
     */
    public function export($table){

        $excel = new \Think\Excel();
        $excel->export($_GET,$table);
    }
}
