<?php
include("PHPexcel.php");
require_once("PHPExcel/IOFactory.php");
class PHPExcel_xls_inputer{
	private $data_type=false,
			$auto_rule=false,
			$alerady_set_rule=false;

	public	$data=null,
			$original_data=null,
			$helper,
			$sheet=0,
			$handler,
			$file_path='',
			$reader=false,
			$PHPExcel_readfile=false,
			$default_null=null,
			$handler_rule=array(),
			$debug=false;

	//直接給我路徑不要囉嗦
	function __construct($file_path='')
	{
		$this->helper = new helper();
		$this->handler = new handler();

		//先避免BIG5爆掉
		if(!empty($file_path))
			{$file_path = iconv("UTF-8","BIG5", $file_path);}

		$this->file_path = !empty($file_path)?$file_path:$this->file_path;

		// // 如果有給路徑，直接讀
		// if($this->file_path)
		// {
		// 	$this->read_file();
		// }
    }


    //讀取檔案，產生資料
    public function read_file($file_path='')
    {
		//先避免BIG5爆掉
		if(!empty($file_path))
			{$file_path = iconv("UTF-8","BIG5", $file_path);}

		//如果有給新路徑，以新路徑為主。
    	$this->file_path = $file_path?$file_path:$this->file_path;


    	//一定要給路徑
    	if($file_path = $this->file_path)
    	{
			$inputFileType = PHPExcel_IOFactory::identify($file_path);
			// seeData($inputFileType,1);


			//判斷要使用的閱讀器
			switch ($inputFileType)
			{
				case 'CSV':
					$objReader = PHPExcel_IOFactory::createReader('CSV')->setDelimiter(',')
														->setEnclosure('"')
														->setLineEnding("\r\n")
														->setSheetIndex(0);
					$this->source_type = 'csv';
					break;
				
				case 'excel':
				case 'Excel':
				case 'Excel5':
				case 'Excel2007':
					$objReader = PHPExcel_IOFactory::createReader($inputFileType);
					$this->source_type = 'excel';
					break;

				default:
					exit('file type doesn\'t exists.');
					break;
			}

			//將reader緩存起來。要使用可以直接呼叫
			$this->reader=$objReader;


			return $this;
    	}	
    	else
    	{
			exit('give me a path please.');
    	}
    }

    public function set_sheet($sheet)
    {
    	$this->sheet = ((int)$sheet);

    	return $this;
    }

    public function set_handler(array $handler=array(),$auto_rule=true)
    {
    	if(!empty($handler))
    	{
    		foreach ($handler as $field => $fn)
    		{
    			$this->handler->$field = $fn;
    		}

    		if(!$this->alerady_set_rule)
    			$this->auto_rule = $auto_rule;
    	}

    	return $this;
    }

    public function output($format=array(),$ignor=array(1))
    {
    	if(!$this->reader)
    	{
    		$this->read_file();
    	}

    	//產出資料
    	$this->PHPExcel_readfile = $this->reader->load($this->file_path)->getSheet(((int)$this->sheet));
		$this->original_data = $this->PHPExcel_readfile->toArray(null, true, true, true);

		
		// seeData("A",1);
		$this->data = array();			

		//如果有給格式，就產出符合格式的資料。
		if(!empty($format))
		{
			foreach ($this->original_data as $row_num => $row_data)
			{
				if(in_array($row_num,$ignor))
					continue;

				$trans_data=array();

				//處理format
				$format = $this->format_check($format);


				foreach ($format as $AZ_key => $feild)
				{
					// 如果某key已經被建立過
					if(array_key_exists($feild,$trans_data))
					{
						// 但該數值不是array，則建立為array;
						if(!is_array($trans_data[$feild]))
						{
							$trans_data[$feild] = array($trans_data[$feild]);
						}

						// 加入新數值。
						array_push($trans_data[$feild],isset($row_data[$AZ_key])?$row_data[$AZ_key]:$this->default_null);
					}
					else
					{
						$trans_data[$feild] = isset($row_data[$AZ_key])?$row_data[$AZ_key]:$this->default_null;
					}
				}

				foreach ($trans_data as $method_name => $data)
				{
					$trans_data[$method_name] = isset($this->handler->$method_name)?$this->handler->$method_name($data,$trans_data):$data;
				}


				$this->data[] = $trans_data;
			}
		}
		//如果沒給，就給原資料
		else
		{
			foreach ($this->original_data as $row_num => $row_data)
			{
				if(in_array($row_num,$ignor))
					continue;

				$this->data[] = $row_data;
			}
		}

    	return $this->data;
    }



    private function format_check($format)
    {
    	// 先設定 _first 和 _last 是哪個 KEY
    	$range = $this->PHPExcel_readfile->calculateWorksheetDimension();
    	$range = explode(':',$range);

    	foreach ($range as $dontcare => $value)
    	{
    		//濾除 非字母 形式的東西
    		$range[$dontcare] = $this->helper->field_eng_to_num(preg_replace('/[^a-zA-Z]/','',$value));
    	}

    	// 設定最大與最小範圍
    	$_first = min($range);
    	$_last = max($range);

    	// 將 _new 保留下來最後再處理
    	if(isset($format['_new']))
    	{
    		$_new = $format['_new'];
    		unset($format['_new']);
    	}
    	//setp1全數置換 _first 和 _last
    	$new_format = array();

    	
    	foreach ($format as $key => $feild)
    	{
    		// // step.0 如果是_new則設置為 _last+1 、 _last+2...
    		// if($key != ($key = str_replace('_new',$_last+$_new_row,$key)))
    		// {
    		// 	//有置換才需要加
    		// 	$_new_row++;
    		// }

    		// setp1. 把所有的_first 和 _last 轉換掉;
    		$key = str_replace('_first',$_first,$key);
    		$key = str_replace('_last',$_last,$key);

    		// step2.判斷有沒有使用 : 符號
    		if(strpos($key,':'))
    		{
    			$range = explode(':',$key);
    			foreach ($range as $dontcare => $inside_key)
    			{
    				// 將KEY裡面的英文轉換為數字
    				$convert = str_replace(preg_replace('/[^a-zA-Z]/','',$inside_key),$this->helper->field_eng_to_num(preg_replace('/[^a-zA-Z]/','',$inside_key)),$inside_key);

    				//將字串直接運算成數字
    				eval('$convert ='.$convert.';');

    				$range[$dontcare] = $convert;
    			}
    			$from = min($range);
    			$to = max($range);
    			for($num=$from;$num<=$to;$num++)
    			{
    				$new_format[$this->helper->field_num_to_eng($num)]=$feild;
    			}
    		}
    		else
    		// 如果沒有，直接把英文轉換成數字
    		$convert = str_replace(preg_replace('/[^a-zA-Z]/','',$key),$this->helper->field_eng_to_num(preg_replace('/[^a-zA-Z]/','',$key)),$key);
			eval('$convert ='.$convert.';');

    		$new_format[$this->helper->field_num_to_eng($convert)] = $feild;
    	}

    	if(isset($_new))
    	{
    		$_new_row = 1 ;
    		if(is_array($_new))
    		{
    			foreach ($_new as $key => $feild)
    			{
    				$new_format[$_last+$_new_row] = $feild;
    				$_new_row++;
    			}
    		}
    		else
    		{
    			$new_format[$_last+$_new_row] = $_new;
    		}
    	}

    	// seeData($new_format,1);
    	return $new_format;
    }

  //   //-------------------------------------------------------------------


  //   public function debug()
  //   {
  //   	$this->debug = true;
  //   	return $this;
  //   }

  //   public function set_data($datas)
  //   {
		// //如果給錯就直接報錯
		// if(!is_array($datas))
		// 	exit('it must be a array.');


		// //判斷陣列中的元素是obj還是array
		// $first_data = current($datas);

		// if(is_array($first_data))
		// 	$this->data_type = 'array';

		// elseif(is_object($first_data))
		// 	$this->data_type = 'object';

		// else
		// 	exit('data format error.');


		// $this->data = $datas;

		// return $this;
  //   }

  //   /*
		// set_handler用來設定對於特定欄位值的處理方法：

		// 例如你傳入了一筆資料，其中的每一個單一資料看起來像這樣

		// 	student Object{
		// 		[name]=>小明
		// 		[sex]=>1
		// 		[age]=>12
		// 		[idNo]=>A123456788990
		// 	}

		// 但你需要輸出的xls欄位如下

		// 	姓名 : 使用 name 欄位
		// 	性別 : 使用 sex 判斷
		// 	是否年滿18歲 : 使用age 檢核
		// 	身分證號檢核 : 使用 idNo 與 sex 雙重檢核

		// 在這筆資料之中，除了姓名其他所有的欄位都需要經過外加的function進行判斷，
		// 如果你希望你原封不動的直接把資料丟進來後，outputer就直接幫你處理，
		// 那麼這隻set_handler()會派上用場：

		// 呼叫方式：

		// 	$outputer->set_handler(array(

		// 		"要處理的欄位key值" => function($data){

		// 			..處理的方式..

		// 			return 處理結果
		// 		},

		// 		"sex" => function($data){

		// 			switch($data->sex)
		// 			{
		// 				case: '1':
		// 					$return = '男性';
		// 					break;
		// 				case: '2':
		// 					$return = '女性';
		// 					break;
		// 				default:
		// 					$return = '第三性';
		// 					break;
		// 			}

		// 			return $return;
		// 		},

		// 		.......
		// 	));
  //   */
  //   public function set_handler(array $handler=array(),$auto_rule=true)
  //   {
  //   	if(!empty($handler))
  //   	{
  //   		foreach ($handler as $field => $fn)
  //   		{
  //   			$this->handler->$field = $fn;
  //   		}

  //   		if(!$this->alerady_set_rule)
  //   			$this->auto_rule = $auto_rule;
  //   	}

  //   	return $this;
  //   }

  //   public function set_handler_rule($rule)
  //   {
  //   	if(is_array($rule))
  //   	{
  //   		$this->handler_rule = $rule;
  //   		$this->auto_rule = false;
  //   		$this->alerady_set_rule = true;
  //   	}
  //   	return $this;
  //   }



  //   public function output($title='')
  //   {
		// $objPHPExcel = new PHPExcel();


  //   	if(is_array($title))
  //   	{
  //   		$i=1;
  //   		$title_obj = new stdClass;


  //   		//設定第一行的標題，並制定欄位格式
  //   		foreach ($title as $param_name => $column_title)
  //   		{
		// 		$objPHPExcel->setActiveSheetIndex(0)
		// 		            ->setCellValue($this->helper->field_num_to_eng($i).'1',$column_title);

  //   			$title_obj->$param_name = $i;
  //   			$i++;
  //   		}

  //   		//將陣列資料逐列存入
		// 	$all_datas = $this->data;
		// 	// print_r($this->is_obj);
		// 	// die();
		// 	$max_column = count($all_datas);

		// 	$now_row = 2;

		// 	switch($this->data_type)
		// 	{
		// 		case 'array':
		// 			foreach ($all_datas as $row => $row_data)
		// 			{
		// 				foreach ($title_obj as $param_name => $title_number)
		// 				{

		// 					$field = $this->helper->field_num_to_eng($title_number).$now_row;
		// 					$method_name = isset($this->handler_rule[$param_name])?$this->handler_rule[$param_name]:$param_name;
		// 					$data = isset($row_data[$param_name])?$row_data[$param_name]:$this->default_null;

		// 					//如果指定的欄位key有對應的資料
		// 					if(isset($row_data[$param_name]))
		// 					{
		// 						$data = isset($this->handler->$method_name)?$this->handler->$method_name($data,$row_data):$data;
		// 					}
		// 					//如果是虛構欄位，但是有相應的handler
		// 					elseif(isset($this->handler->$method_name))
		// 					{
		// 						$data = $this->handler->$method_name($data,$row_data);
		// 					}
		// 					//如果都沒有
		// 					else
		// 					{
		// 						$data=$this->default_null;
		// 					}

		// 					$objPHPExcel->setActiveSheetIndex(0)
		// 					            ->setCellValue($field,$data);
		// 				}

		// 				$now_row++;
		// 			}
		// 			break;

		// 		case 'object':
		// 			foreach ($all_datas as $row => $row_data)
		// 			{
		// 				foreach ($title_obj as $param_name => $title_number)
		// 				{
		// 					$field = $this->helper->field_num_to_eng($title_number).$now_row;
		// 					$method_name = isset($this->handler_rule[$param_name])?$this->handler_rule[$param_name]:$param_name;
		// 					$data = isset($row_data->$param_name)?$row_data->$param_name:$this->default_null;

		// 					//如果指定的欄位key有對應的資料
		// 					if(isset($row_data->$param_name))
		// 					{
		// 						$data = isset($this->handler->$method_name)?$this->handler->$method_name($data,$row_data):$data;
		// 					}
		// 					//如果是虛構欄位，但是有相應的handler
		// 					elseif(isset($this->handler->$method_name))
		// 					{
		// 						$data = $this->handler->$method_name($data,$row_data);
		// 					}
		// 					//如果都沒有
		// 					else
		// 					{
		// 						$data=$this->default_null;
		// 					}

		// 					$objPHPExcel->setActiveSheetIndex(0)
		// 					            ->setCellValue($field,$data);
		// 				}
		// 				$now_row++;
		// 			}
		// 			break;
		// 		default:
		// 			exit('data format error.');
		// 	}

		// 	if(!$this->debug)
		// 	{
		// 		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		// 		header('Content-Disposition: attachment;filename="'.$this->file_name.'.xlsx"');
		// 		header('Cache-Control: max-age=0');
		// 		// If you're serving to IE 9, then the following may be needed
		// 		header('Cache-Control: max-age=1');

		// 		// If you're serving to IE over SSL, then the following may be needed
		// 		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT+8'); // always modified
		// 		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		// 		header ('Pragma: public'); // HTTP/1.0
		// 	}


		// 	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		// 	$objWriter->save('php://output');

		// 	exit;
    		
  //   	}
  //   }
}

//--------------------

class helper
{
	function field_num_to_eng($input_number='')
	{
		//不能從0開始計，而且只接受數字
		if($input_number==0 || !is_numeric($input_number))
			{return false;}

		$output='';

		$mod_array=array(
			'1'=>'A',
			'2'=>'B',
			'3'=>'C',
			'4'=>'D',
			'5'=>'E',
			'6'=>'F',
			'7'=>'G',
			'8'=>'H',
			'9'=>'I',
			'10'=>'J',
			'11'=>'K',
			'12'=>'L',
			'13'=>'M',
			'14'=>'N',
			'15'=>'O',
			'16'=>'P',
			'17'=>'Q',
			'18'=>'R',
			'19'=>'S',
			'20'=>'T',
			'21'=>'U',
			'22'=>'V',
			'23'=>'W',
			'24'=>'X',
			'25'=>'Y',
			'0'=>'Z'
			);


		$quotient=(int)($input_number/26);
		$remainder = $input_number%26;


		if($remainder == 0 )
			{$quotient--;}

		$output = $mod_array[$remainder].$output;

		if($quotient>=26)
			{$output=$this->field_num_to_eng($quotient).$output;}
		elseif($quotient!=0)
			{$output=$mod_array[$quotient].$output;}

		return $output;
	}

	function field_eng_to_num($input_eng='')
	{
		//只能給英文
		if($input_eng=='' || (!preg_match('/^[a-zA-Z]+$/', $input_eng)))
			return false;

		$A=$a=1;
		$B=$b=2;
		$C=$c=3;
		$D=$d=4;
		$E=$e=5;
		$F=$f=6;
		$G=$g=7;
		$H=$h=8;
		$I=$i=9;
		$J=$j=10;
		$K=$k=11;
		$L=$l=12;
		$M=$m=13;
		$N=$n=14;
		$O=$o=15;
		$P=$p=16;
		$Q=$q=17;
		$R=$r=18;
		$S=$s=19;
		$T=$t=20;
		$U=$u=21;
		$V=$v=22;
		$W=$w=23;
		$X=$x=24;
		$Y=$y=25;
		$Z=$z=26;

		$each_array=preg_split('//', $input_eng, -1, PREG_SPLIT_NO_EMPTY);
		$each_array=array_reverse($each_array);

		

		$output=0;
		foreach ($each_array as $poewr => $eng)
		{
			$output+=$$eng*pow(26,$poewr);
		}

		return $output;
	}
}

class handler {
    
    public function __call( $fn,$args){
    	return call_user_func_array($this->$fn,$args);
    }
}