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

        $nickname = I('nickname');
        if(isset($nickname)){
            $map['car_title']  = array('like', '%'.(string)$nickname.'%');
            $map['car_licence']  = array('like', '%'.(string)$nickname.'%');
        }
        $list   = $this->lists('Car', $map);
print_r($list);
        int_to_string($list);
        $this->assign('_list', $list);

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

}
