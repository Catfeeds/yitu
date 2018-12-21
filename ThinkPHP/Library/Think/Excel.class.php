<?php

namespace Think;

class Excel{

    /**数据导出
     * @param arr    $data      条件信息
     * @param string $type     需要导出的表数据 user order  job
     */

    public function export($data,$table=''){

        if(empty($data) || empty($table)) return -1;

        vendor("PHPExcel.PHPExcel");
        $objPHPExcel = new \PHPExcel();

        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');

        $objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal('center');
        $objPHPExcel->getDefaultStyle()->getAlignment()->setVertical('center');
        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(25);

        switch ($table) {
            case 'car':
                $thead = array(
                    array('name' => '车名', 'title' => 'car_title', 'widths' => 20),
                    array('name' => '车牌', 'title' => 'car_licence', 'widths' => 20),
                    array('name' => '归属', 'title' => 'car_ownership', 'widths' => 20),
                    array('name' => '状态', 'title' => 'car_status', 'widths' => 20),
                );
                $cellNum = count($thead);

                /*准备获取数据*/

                if (!empty($id_str)) $map[] = " id in($id_str) ";
                //查询条件
                if (isset($data['nickname'])) {
                    $map[] = " (car_title like '%{$data['nickname']}%' or car_licence like '%{$data['nickname']}%') ";
                }
                if(isset($data['car_status'])){
                    $map[] = " car_status = {$data['car_status']} ";
                }

                $where = join('and', $map);
                $list = M('Car')
                    ->field('car_title,car_licence,if(car_ownership = 1,"公司","外调") as car_ownership,case car_status when 1 then "待收车" when 2 then "待查章" when 3 then "待出租" end as car_status')
                    ->where($where)
                    ->order('id desc')
                    ->select();
                $row_1 = '车辆列表';
                //print_r($list);die;
                break;
        }

        $xlsTitle = iconv('utf-8', 'gb2312', $row_1);//文件名称
        //$fileName = 'ytzc'.date('_YmdHis');//or $xlsTitle 文件名称可根据自己情况设定

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1',$row_1 );
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(35);//第一行行高
        $objPHPExcel->getActiveSheet()->getStyle( 'A1')->getFont()->setSize(13)->setBold(true);
        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格

        for($i=0;$i<$cellNum;$i++){
            $objPHPExcel->getActiveSheet()->getColumnDimension($cellName[$i])->setWidth($thead[$i]['widths']);
            $objPHPExcel->getActiveSheet()->getStyle( $cellName[$i].'2')->getFont()->setBold(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'2', $thead[$i]['name']);
        }

        // Miscellaneous glyphs, UTF-8
        $dataNum = count($list);
        //print_r($list);die;
        for($i=0;$i<$dataNum;$i++){

            for($j=0;$j<$cellNum;$j++){
                $k = $thead[$j]['title'];
                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+3), $list[$i][$k]);
            }
        }
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
        header("Content-Disposition:attachment;filename=$xlsTitle.xls");//attachment新窗口打印inline本窗口打印

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }
}

