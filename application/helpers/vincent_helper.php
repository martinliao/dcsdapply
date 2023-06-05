<?php


function ROCdate($format,$unixTime=null)
{
	$unixTime = $unixTime?$unixTime:time();
	$Y_exist =  strpos($format,'Y');

	if($Y_exist!==false)
	{
		$Y = date('Y',$unixTime);
		$Y = ($Y-1911)>0?$Y-1911:$Y;
		$Y = $Y_exist===false?'':$Y;
		$format = str_replace('Y',$Y,$format);
	}

	$WEEK = array(
		'Sunday' => '日',
		'Monday' => '一',
		'Tuesday' => '二',
		'Wednesday' => '三',
		'Thursday' => '四',
		'Friday' => '五',
		'Saturday' => '六',
	);

	$l_exist =  strpos($format,'l');
	if($l_exist!==false)
	{
		$l = date('l',$unixTime);
		$l = $WEEK[$l];
		$l = $l_exist===false?'':$l;
		$format = str_replace('l',$l,$format);
	}

	$return = date($format,$unixTime);

	return $return;
}

// 輸出json資料
if(!function_exists('json_response')){
	function json_response($obj, $callback = ''){
		$CI = &get_instance();
		if($callback == ''){
			$CI->output->set_output(json_encode($obj));
		}else{
			$CI->output->set_output($CI->input->get($callback) . '(' . json_encode($obj) . ')');
		}
		$CI->output->_display();
		exit();
	}
}

/**
 * 用於紀錄log再die()避免直接使用die函數時，系統會走不到HOOK  導致不能留LOG或其他操作
 */
function hook_die($value=null){
	$CI = &get_instance();	
	$CI->hooks->call_hook('post_controller');
	exit($value);
}

/**
 * JSON字串 編譯用。(用PHP印出JS的function，專門用來處理需要跳行的JS變數字串)
 * 用來會輸出一個不會受到跳行而掛掉的字串JSON字串。
 * 它利用註解的方式，來規避JS在定義變數時，如果該行程式碼有包含斷行，便會掛掉的問題。
 *
 * 注意：這隻function 只能用在 JS 裡面
 *
 * @param      Array|Obj  $var      要轉譯成文字的變數
 * @param      String     $varNmae  預設的變數名稱 (如果有填寫，則整個JS字串會被改寫為獨立的運算式，且句末會補分號)
 *
 * @return     String     回傳整個JS的程式碼，這串程式碼會負責把 原始變數 處理成 JSON字串。
 */
function jsjson_encode($var,$varNmae=''){

	$jsString = !empty($varNmae)?('var '.$varNmae.' = '):null;
	$jsString.= '(function(){
		var jsString = function(){/*'.json_encode($var).'*/}.toString();
		jsString = jsString.slice(jsString.indexOf("/*")+2,jsString.lastIndexOf("*/"));
		return jsString;
	})()';
	$jsString.= !empty($varNmae)?';':null;

	return $jsString;
}

/**
 * JS字串 編譯用。(用PHP印出JS的function，專門用來處理需要跳行的JS變數字串)
 * 用來會輸出一個不會受到跳行而掛掉的JS字串。
 * 它利用註解的方式，來規避JS在定義變數時，如果該行程式碼有包含斷行，便會掛掉的問題。
 *
 * 注意：這隻function 只能用在 JS 裡面
 *
 * @param      Array|Obj  $var      要轉譯成文字的變數
 * @param      String     $varNmae  預設的變數名稱 (如果有填寫，則整個JS字串會被改寫為獨立的運算式，且句末會補分號)
 *
 * @return     String     回傳整個JS的程式碼，這串程式碼會負責把 原始變數 處理成 JSON字串。
 */
function jsbreakline_value($var,$varNmae=''){

	$jsString = !empty($varNmae)?('var '.$varNmae.' = '):null;
	$jsString.= '(function(){
		var jsString = function(){/*'.$var.'*/}.toString();
		jsString = jsString.slice(jsString.indexOf("/*")+2,jsString.lastIndexOf("*/"));
		return jsString;
	})()';
	$jsString.= !empty($varNmae)?';':null;

	return $jsString;
}


//判斷是否在時間區間之內 (以日期為單位，從起始日期00:00 ~ 結束日期 23:59)
//給日期的str就好，function會自己轉換
function day_in_range($start='',$end='',$time='')
{
	if(empty($start))
		return false;
	if(empty($end))
		$end=$start;

	if(empty($time))
		$time=date('Y-m-d H:i:s');

	$start=strtotime($start);
	$end=strtotime($end);
	$time=strtotime($time);

	$start=strtotime(date('Y-m-d',$start)); //過濾時間單位 (僅顯示至天)

	$end=strtotime(date('Y-m-d',$end));	 //過濾時間單位 (僅顯示至天)

	$end = strtotime('+1 day',$end);

	if($start <= $time && $time < $end)
		return true;
	else
		return false;
}

//
function build_varURL($base_url='',$var='')
{
	if(!empty($base_url))
	{
		if(!empty($var))
		{
			$build_varURL = $base_url."?";
			if(is_array($var))
			{
				$tmpURL='';
				foreach ($var as $key => $value)
				{
					$tmpURL.=$key.'='.$value.'&';
				}
				$varURL=rtrim($tmpURL,'&');

				$build_varURL.=$varURL;
			}
			else
				$build_varURL .= $var;
		}

		return $build_varURL;
	}
	return false;
}



//判斷是不是POST請求
function isPOST()
{
	return strtoupper($_SERVER['REQUEST_METHOD']) === 'POST';
}

//判斷是不是為ajax請求 (且預設為POST請求)
function isAjax($default_method = 'POST')
{
	//如果額外設置 $default_method 為FALSE，則直接給過
	$method_TR = $default_method?(strtoupper($_SERVER['REQUEST_METHOD']) === strtoupper($default_method)):TRUE;
    return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && (strtolower(getenv('HTTP_X_REQUESTED_WITH')) === 'xmlhttprequest')) && $method_TR;
}


function post_curl($url,$data,$return=1)
{

	// 建立CURL連線
	$ch = curl_init();

	// 設定擷取的URL網址
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,$return); //文字輸出
	curl_setopt($ch, CURLOPT_POST, true); // 啟用POST
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'sid='.session_id());
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

	// 執行
	$result = curl_exec($ch);
	// 關閉CURL連線
	curl_close($ch);

	return $result;
}


// 擷取一段文字
if(!function_exists('str_cut')){
	function str_cut($str, $sublen, $etc = '...')
	{
			if(strlen($str)<=$sublen) {
					$rStr = $str;
			} else {
					$I = 0;
					while ($I<$sublen) {
							$StringTMP = substr($str,$I,1);

							if (ord($StringTMP)>=224) {
									$StringTMP = substr($str,$I,3);
									$I = $I + 3;
							} elseif (ord($StringTMP)>=192) {
									$StringTMP = substr($str,$I,2);
									$I = $I + 2;
							} else {
									$I = $I + 1;
							}
							$StringLast[] = $StringTMP;
					}

					$rStr = implode('',$StringLast).$etc;
			}

			return $rStr;
	}
}

//上傳檔案
function file_input($file,$base_path,$limit='20')
{
	if(!empty($file))
	{
		if(empty($file["error"]))
		{

			if($file["size"]>(1024*1024*$limit))
			{
				$data = array(
					'success'=>false,
					'error'=>'錯誤:檔案大於'.$limit.'MB。'
				);

				return $data;
			}

			//先轉成BIG5 免得中文檔名出狀況
			$file_name=$file["name"];
			$file["name"] = iconv("UTF-8","BIG5", $file_name);

			try_path($_SERVER['DOCUMENT_ROOT'].$base_path);

			if(!file_exists($_SERVER['DOCUMENT_ROOT'].$base_path))
			{
				mkdir($_SERVER['DOCUMENT_ROOT'].$base_path);
			}

			//確認檔案是不是已經存在了，存在了的話就在名稱後面加時間(年月日時分秒)
			if(file_exists($_SERVER['DOCUMENT_ROOT'].$base_path. $file["name"]))
			{
				//取得附檔名
				$old_name = $file["name"];
				$tmp = explode('.',$old_name);
				$ext = ".".end($tmp);
				//設訂新檔名
				$new_name_header = str_replace($ext,'',$old_name);
				$new_name = $new_name_header."_".date('YmdHis').$ext;

				$file_path=$_SERVER['DOCUMENT_ROOT'].$base_path.$new_name;

				//存檔
				move_uploaded_file($file["tmp_name"],$file_path);
			}
			else
			{
				//直接存檔
				$file_path=$_SERVER['DOCUMENT_ROOT'].$base_path.$file["name"];
				move_uploaded_file($file["tmp_name"],$file_path);
			}

			//雖然沒有細究為什麼要轉成BIG5又要轉回來，但先這麼做吧
			$data = array(
				'success'=>true,
				'file_name'=>iconv("BIG5","UTF-8",$file["name"]),
				'file_path'=>iconv("BIG5","UTF-8",str_replace($_SERVER['DOCUMENT_ROOT'],'',$file_path))
				);
		}
		else
		{
			$data= array(
				'success'=>false,
				'error' => $file["error"] ,
			);
		}
		return $data;
	}
	else
		return false;

}

//自動建立路徑
function try_path($path)
{
	$try = 	dirname($path);
	// 先訪問這層路徑是否存在
	// 如果不存在就
	if(!file_exists($try))
	{
		if(try_path($try))
			mkdir($try);
	}

	return true;
}


//修改排序
function check_row($original_row,$row,$table,$field='row')
{
	$CI = &get_instance();

	//修改排序
	$select_row_range=array($original_row,$row);
	sort($select_row_range);

	// seeData($select_row_range,1);

	$CI->db->select('id,'.$field)
			 ->where($field.' >='.$select_row_range[0])
			 ->where($field.' <='.$select_row_range[1]);

	if($row < $original_row)
		{$CI->db->order_by($field.' asc , id desc');}

	elseif($row > $original_row)
		{$CI->db->order_by($field.' asc , id asc');}

	$changes=$CI->db->get($table)->result_array();

	$row=$select_row_range[0];
	if(count($changes) > 0)
	{
		foreach ($changes as $key => $change)
		{
			$data=array($field=>$row);
			$CI->db->where('id ='.$change['id']);
			$CI->db->update($table,$data);
			$row++;
		}
	}
}

function necessary($array,$auto_redirect=false){
	foreach ($array as $key => $value)
	{
		if(!$value || !isset($value))
		{
			if($auto_redirect)
				redirect();
			else
				return 0;
		}
	}
	return 1;
}



function cut_phone($phone,$first='-',$last='#')
{
	$return = array(
		1=>'',
		2=>'',
		3=>'',
	);

	$phone = explode('-', $phone);

	

	if(count($phone)>1)
		$return[1] = preg_replace("/[^0-9]/",'',array_shift($phone));

	$phone = explode('#',implode($phone,''));

	if(count($phone)>1)
		$return[3] = preg_replace("/[^0-9]/",'',array_pop($phone));

	$return[2]  = preg_replace("/[^0-9]/",'',implode($phone,''));

	return $return;
}
