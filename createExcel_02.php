<?php
	ini_set('max_execution_time', '0');
	include_once('ThinkPHP/Library/Vendor/PHPExcel/PHPExcel.class.php');
	
	//第二种方式：创建多个sheet
	$data = array(
			array('username'=>'小X','age'=>'18岁','class'=>'初中一班'),
			array('username'=>'小Y','age'=>'10岁','class'=>'初中二班')
	);
	
	$phpexcel = new PHPExcel();
	for($i=1;$i<=count($data);$i++){
		if($i>1){
			$phpexcel->createSheet();//在excel中新建sheet
		}
		$phpexcel -> setActiveSheetIndex($i-1);//把新创建的sheet设定为当前活动sheet
		$objSheet = $phpexcel->getActiveSheet();//获取当前活动sheet
		$objSheet -> setTitle("人员名单".$i);//给当前活动sheet起个名称
		$objSheet -> setCellValue("A1","姓名")->setCellValue("B1","年龄")->setCellValue("C1","班级");//填充表头
		$j = 2;//从第二行开始填充数据，data若从数据库里面查询，即实现不同sheet填充不同分类数据
		foreach($data as $key=>$val){
			$objSheet->setCellValue("A".$j,$val['username'])->setCellValue("B".$j,$val['age'])->setCellValue("C".$j,$val['class']);
			$j++;
		}
	}
	
	$objWriter=PHPExcel_IOFactory::createWriter($phpexcel,'Excel5');//生成2003版本的excel文件
	browser_export('Excel5','demo.xls');//输出到浏览器
	$objWriter->save("php://output");

	function browser_export($type,$filename){
		if($type=="Excel5"){
			header('Content-Type: application/vnd.ms-excel');//告诉浏览器将要输出excel03文件
		}else{
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');//告诉浏览器数据excel07文件
		}
		header('Content-Disposition: attachment;filename="'.$filename.'"');//告诉浏览器将输出文件的名称
		header('Cache-Control: max-age=0');//禁止缓存
	}
 
	
	
	