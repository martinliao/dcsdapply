<?php

include('PHPExcel_xls_outputer.php');


//預設資料
$example_array = array(
		array(
			'name'=>'小明',
			'sex'=>'男',
			'cellphone'=>'0911333555',
			'birthday'=>'1999-01-01',
		),
		array(
			'name'=>'小華',
			'sex'=>'女',
			'cellphone'=>'98765421',
			'birthday'=>'1997-01-02',
		),
		array(
			'name'=>'小庄',
			'sex'=>'男',
			'cellphone'=>'12345678',
			'birthday'=>'1995-01-01',
		),
	);


//-----------------------------------------------

$data_format = array(
		'name'=>'姓名',
		'sex'=>'性別',
		'cellphone'=>'手機',
		'birthday'=>'出生日期',
		'empty'=>'(空白資料範例)',
		'make_a_row'=>'(處理器範例)',
	);

// 壹、初始化，並以建構子設定輸出文件的檔名
$outputer = new PHPExcel_xls_outputer('PHPexcel_outputer 範例文件');

// 貳、設定輸出資料
$outputer->set_data($example_array);

// 参、設定處理器 (非必要)
//   處理器的名稱需與資料的KEY值相應 (否則需要使用set_handler_rule())
//   處理器會預設傳入兩個參數：1.該欄位的對應資料、2.該列的所有資料。
//   可以利用資料進行運算後回傳
$outputer->set_handler(array(
		'make_a_row'=>function($data,$rowdata){
			$str = implode(' ',$rowdata);
			return $str;
		},
	));

// 肆、制定輸出格式並輸出
$outputer->output($data_format);
