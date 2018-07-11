<?php
	ini_set('max_execution_time', '0');
	include_once('ThinkPHP/Library/Vendor/PHPExcel/PHPExcel.class.php');
	
	//第一种方式：创建单个sheet
	$data = array(
		array('姓名' , '昵称' , '电话'  , '爱好'),
		array('小华' , '华华' , '12345' , '吃喝'),
		array('刘一' , '一一' , '67890' , '玩乐')
    );
	
	$filename = 'demo.xls';
    $filename=str_replace('.xls', '', $filename).'.xls';
    $phpexcel = new PHPExcel();
    $phpexcel->getProperties()
        ->setCreator("Maarten Balliauw")
        ->setLastModifiedBy("Maarten Balliauw")
        ->setTitle("Demo for PHPExcel")
        ->setSubject("Office 2007 XLSX Demo Document")
        ->setDescription("Demo document for Office 2007 XLSX, generated using PHP classes.")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Demo result file");
    $phpexcel->getActiveSheet()->fromArray($data);
    $phpexcel->getActiveSheet()->setTitle('Sheet1');
    $phpexcel->setActiveSheetIndex(0);
	
    header('Content-Type: application/vnd.ms-excel'); //告诉浏览器输出excel类型文件
    header("Content-Disposition: attachment;filename=$filename"); //告诉浏览器该文件名字
    header('Cache-Control: max-age=0 , cache, must-revalidate'); //强制不缓存
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // 内容过期时间
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // 标记内容最后修改时间
    $objwriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel5');
    $objwriter->save('php://output');
	