<?php
include("PHPExcel.php");
require_once("PHPExcel/IOFactory.php");
class PHPExcel_xls_outputer{
	private $data_type=false,
			$auto_rule=false,
			$alerady_set_rule=false;

	public	$data,
			$helper,
			$handler,
			$file_name='',
			$default_null=null,
			$handler_rule=array(),
			$objPHPExcel=null,
			$debug=false;

	//$data必須是至少一維的陣列，陣列中的元素可以是第二維的陣列，或者是物件
	function __construct($file_name='')
	{
		$this->helper = new helper();
		$this->handler = new handler();
		$this->file_name = date('Y-m-d');

		$this->file_name = !empty($file_name)?$file_name:$this->file_name;

		$this->objPHPExcel = new PHPExcel();
    }

    public function debug()
    {
    	$this->debug = true;
    	return $this;
    }

    public function set_data($datas)
    {
		//如果給錯就直接報錯
		if(!is_array($datas))
			exit('it must be a array.');


		//判斷陣列中的元素是obj還是array
		$first_data = current($datas);


		if(is_array($first_data) || empty($first_data))
			$this->data_type = 'array';

		elseif(is_object($first_data))
			$this->data_type = 'object';

		else
			exit('data format error.');


		$this->data = $datas;

		return $this;
    }

 
    /**
     * 用於設置所有Sheet的標題
     * 建議在的開頭時就利用這隻fn設定好各sheet的index與名稱對應
     * 且『不建議』重複呼叫這隻fn
     * 因為這隻fn只會直接依順序修改sheet名稱；
     * 不會聰明到幫你把塞好資料的sheet的順序調換。
     *
     * @param      array  sheet的標題
     *
     * @return     self    ( description_of_the_return_value )
     */
    public function set_all_sheets($sheet_titles)
    {
		$objPHPExcel = &$this->objPHPExcel;

    	$sheet_titles = is_array($sheet_titles)?$sheet_titles:array($sheet_titles);
    	ksort($sheet_titles);

    	$sheet_count = count($sheet_titles);
    	$now_sheet_count = $objPHPExcel->getSheetCount();

    	// 1.判斷現存sheet夠不夠，不夠就新增
    	if($sheet_count>$now_sheet_count)
    	{
    		for($i=$sheet_count; $i>$now_sheet_count;$i--)
    		{
    			$objPHPExcel->createSheet();
    		}
    	}
    	// 2.太多就砍
    	elseif ($sheet_count<$now_sheet_count)
    	{
    		for($i=$sheet_count; $i<$now_sheet_count;$i++)
    		{
    			$objPHPExcel->removeSheetByIndex();
    		}
    	}
    	
    	// 3.設定標題
    	$index = 0;
    	foreach ($sheet_titles as $key => $title)
    	{
    		$objPHPExcel->setActiveSheetIndex($index)->setTitle($title);
    		$index++;
    	}

    	$objPHPExcel->setActiveSheetIndex(0);

    	return $this;
    }

    public function fixed_print_title($fromRow=1,$toRow=1,$sheet=null)
    {
    	// 設定要作用的頁籤，如無給定，則直接使用目前作用的葉籤
		$sheet = $this->get_sheet($sheet);
		$sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd($fromRow,$toRow);

		return $this;
    }

    /*
		set_handler用來設定對於特定欄位值的處理方法：

		例如你傳入了一筆資料，其中的每一個單一資料看起來像這樣

			student Object{
				[name]=>小明
				[sex]=>1
				[age]=>12
				[idNo]=>A123456788990
			}

		但你需要輸出的xls欄位如下

			姓名 : 使用 name 欄位
			性別 : 使用 sex 判斷
			是否年滿18歲 : 使用age 檢核
			身分證號檢核 : 使用 idNo 與 sex 雙重檢核

		在這筆資料之中，除了姓名其他所有的欄位都需要經過外加的function進行判斷，
		如果你希望你原封不動的直接把資料丟進來後，outputer就直接幫你處理，
		那麼這隻set_handler()會派上用場：

		呼叫方式：

			$outputer->set_handler(array(

				"要處理的欄位key值" => function($data){

					..處理的方式..

					return 處理結果
				},

				"sex" => function($data){

					switch($data->sex)
					{
						case: '1':
							$return = '男性';
							break;
						case: '2':
							$return = '女性';
							break;
						default:
							$return = '第三性';
							break;
					}

					return $return;
				},

				.......
			));
    */
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

    public function set_handler_rule($rule)
    {
    	if(is_array($rule))
    	{
    		$this->handler_rule = $rule;
    		$this->auto_rule = false;
    		$this->alerady_set_rule = true;
    	}
    	return $this;
    }

    public function build($title='',$sheet=null)
    {
		$objPHPExcel = &$this->objPHPExcel;

    	if(is_array($title))
    	{
    		$i=1;
    		$title_obj = new stdClass;
    		$now_sheet = $this->get_sheet($sheet);
    		// $now_sheet = $objPHPExcel->setActiveSheetIndex($sheet);


    		//設定第一行的標題，並制定欄位格式
    		foreach ($title as $param_name => $column_title)
    		{
				$now_sheet->setCellValue($this->helper->field_num_to_eng($i).'1',$column_title);

    			$title_obj->$param_name = $i;
    			$i++;
    		}

    		//將陣列資料逐列存入
			$all_datas = $this->data;
			// print_r($this->is_obj);
			// die();
			$max_column = count($all_datas);

			$now_row = 2;

			switch($this->data_type)
			{
				case 'array':
					foreach ($all_datas as $row => $row_data)
					{
						foreach ($title_obj as $param_name => $title_number)
						{

							$field = $this->helper->field_num_to_eng($title_number).$now_row;
							$method_name = isset($this->handler_rule[$param_name])?$this->handler_rule[$param_name]:$param_name;
							$data = isset($row_data[$param_name])?$row_data[$param_name]:$this->default_null;

							//如果指定的欄位key有對應的資料
							if(isset($row_data[$param_name]))
							{
								$data = isset($this->handler->$method_name)?$this->handler->$method_name($data,$row_data):$data;
							}
							//如果是虛構欄位，但是有相應的handler
							elseif(isset($this->handler->$method_name))
							{
								$data = $this->handler->$method_name($data,$row_data);
							}
							//如果都沒有
							else
							{
								$data=$this->default_null;
							}

							$now_sheet->setCellValue($field,$data);
						}

						$now_row++;
					}
					break;

				case 'object':
					foreach ($all_datas as $row => $row_data)
					{
						foreach ($title_obj as $param_name => $title_number)
						{
							$field = $this->helper->field_num_to_eng($title_number).$now_row;
							$method_name = isset($this->handler_rule[$param_name])?$this->handler_rule[$param_name]:$param_name;
							$data = isset($row_data->$param_name)?$row_data->$param_name:$this->default_null;

							//如果指定的欄位key有對應的資料
							if(isset($row_data->$param_name))
							{
								$data = isset($this->handler->$method_name)?$this->handler->$method_name($data,$row_data):$data;
							}
							//如果是虛構欄位，但是有相應的handler
							elseif(isset($this->handler->$method_name))
							{
								$data = $this->handler->$method_name($data,$row_data);
							}
							//如果都沒有
							else
							{
								$data=$this->default_null;
							}

							$now_sheet->setCellValue($field,$data);
						}
						$now_row++;
					}
					break;
				default:
					exit('data format error.');
			}
    		
    	}
		return $this;
    }

    public function output($default_reading_sheet = 0)
    {    	
		$objPHPExcel = &$this->objPHPExcel;
    	$objPHPExcel->setActiveSheetIndex($default_reading_sheet);

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$this->file_name.'.xlsx"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT+8'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, (!$this->debug?'Excel2007':'HTML'));
		$objWriter->save('php://output');
		exit();
    }

    public function get_sheet($index = null){
		$objPHPExcel = &$this->objPHPExcel;

    	if(isset($index))
    		return $objPHPExcel->setActiveSheetIndex($index);
    	else
    		return $objPHPExcel->getActiveSheet();
    }

    public function set_active_sheet($index){
		$objPHPExcel = &$this->objPHPExcel;
		$objPHPExcel->setActiveSheetIndex($index);

		return $this;
    }
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