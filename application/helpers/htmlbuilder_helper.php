<?php
//自動生產出選單列
/*
	輸入給function這些東西就好:

	$li_list = array(

		'_active' => '要active的按鈕名稱',

		'名稱1' => '網址1',
		'名稱2'	=> '網址2',
		'名稱3'	=> '網址3',
		   .	=>	  .
		   .	=>	  .
		   .	=>	  .
		);

	//-------------

	然後這樣呼叫:

	$li_output = li_builder($li_list);
	echo li_output;

*/


function li_builder($nameORarray,$url='',$active='',$style='')
{
	if(is_array($nameORarray))
	{
		$li='';
		$li_array=$nameORarray;
		$checked=array();
		if(!empty($li_array['_active']))
			{
				$$li_array['_active']=true;
				unset($li_array['_active']);
			}
		foreach ($li_array as $name => $url)
		{
			if(!isset($$name))
				$$name='';
			$li.=li_builder($name,$url,$$name);
		}
		return $li;
	}
	else
	{
		$name=$nameORarray;
		$url=!empty($url)?'<a href="'.$url.'">':'';
		$_url=!empty($url)?'</a>':'';
		$li = '<li '.($active?'class="active"':'').(($active)?' style="border-top-color:#ff9804"':'').'>'.$url.$name.$_url.'</li>';
		return $li;
	}
}


function li_builder2($nameORarray,$url='',$active='',$style='')
{
	if(is_array($nameORarray))
	{
		$li='';
		$li_array=$nameORarray;
		$checked=array();
		if(!empty($li_array['_active']))
			{
				$$li_array['_active']=true;
				unset($li_array['_active']);
			}
		foreach ($li_array as $name => $url)
		{
			if(!isset($$name))
				$$name='';
			$li.=li_builder2($name,$url,$$name);
		}
		return $li;
	}
	else
	{
		$name=$nameORarray;
		$url=!empty($url)?'<a href="'.$url.'">':'';
		$_url=!empty($url)?'</a>':'';
		$li = '<li '.($active?'class="active"':'').'>'.$url.$name.$_url.'</li>';
		return $li;
	}
}


class top_li_obj{
	public $default_class='';
	public $class='';
	public $title='';
	public $href='';
	public $attr='';
	public $active='';

	function __construct($title='',$href='',$active=false,$attr='')
	{
		$this->class.= $this->default_class;
		$this->title=$title;
		$this->href=$href;
		$this->attr=$attr;
		$this->active=$active;
	}


	function add_class($class_name='')
	{
		if(is_string($class_name))
			$this->$class.=' '.$class_name;
		return $this;
	}
	
}

class top_ul_builder
{
	public $list=array();
	public $type;

	function __construct($type='left')
	{
		//只接受左或右的設定
		if($type!= 'left' && $type!= 'right' && $type='normal')
			return false;
		else
			$this->type=$type;
	}

    function add_li($title='',$href='',$active=0,$attr='')
    {
 		$li_obj=new top_li_obj($title,$href,$active,$attr);
    	array_push($this->list,$li_obj);
    	return $this;
    }

    function add_html($html_item)
    {
      array_push($this->list,$html_item);
      return $this;
    }

    function print_ul()
    {
      $ul='';
      $ul.='<ul class="nav nav-tabs" style="';
      $ul.=($this->type=='left')?'float:left':'';
      $ul.='">';

      echo $ul;

      $no = 1;

      foreach($this->list as $key => $item)
      {
        if(is_a($item,'top_li_obj'))
        {
        	$item->attr = is_array($item->attr)?$item->attr:array($item->attr);
			$item_str='';
			$item_str.='<li class="';
			$item_str.=$item->class;
			$item_str.=$item->active?' active':'';
			$item_str.='" ';
			$item_str.='style="';
			$item_str.=($this->type=='right')?'float:right;background-color:#ff9804;border-radius: 2px':'';
			$item_str.=($no!=1 && $item->active && $item->active!=2 && $this->type!='right')?'border-top-color:#ff9804':'';
			$item_str.='" >';
			$item_str.='<a href="';
			$item_str.=$item->href;
			$item_str.='" ';
			$item_str.=(!empty($item->attr) && is_array($item->attr))?implode(' ',$item->attr):'';
			$item_str.='style="';
			$item_str.=($this->type=='right')?'color: white':'';
			$item_str.='" >';
			$item_str.=$item->title;
			$item_str.='</a></li>';
			echo $item_str;
			$no++;
        }
        else
          echo $item;
      }
      echo "</ul>";
    }
}


/**********************************************************************************

         建立input用 new input_builder('input type','input name','預設值',是否停用)

         @ 一般input的 id 預設會等於 name
         @ radio與check的 id 會預設等於 name ."_". value
         @ 用set_id(id)改變id
         @ 用add_class(class)增加class
         @ 用add_attr(str)新增屬性
         @ 用set_option(arr)設定選項值，對於不同的input會有不同動作
         @ 用piint_html()印出

**********************************************************************************/

class input_builder
{
	public $type='text';
	public $name='';
	public $id='';
	public $class=array();
	public $attr=array();
	public $default_value='';
	public $nacami=array();
	public $html='';
	public $disable=false;
	public $style='';
	public $auto_break=false; //目前只對radio和checkbox有效
	public $ini_class=null;   //是否使用class進行初始化
	public $file_allow_list=array(); //只對file有影響
	private $print_javascript = true; //是否回傳JS
	private $datepicker_mode='days'; //datepicker 的 minViewMode參數類別，預設為date，可設為months、years，來限定操作的時間單位
	public $datepicker_format=array('days'=>'yy-mm-dd','months'=>'yy-mm','years'=>'yy'); //datepicker 的 dateFormat參數

	function __construct($type='text',$name='',$default_value=null,$disable=false)
	{
		
		$type_list=array('text','number','float','password','select','select2','radio','checkbox','textarea','ckeditor','time','date','month','file','datepicker','hidden');
		$this->name=$name;
		$this->id=$name;

		$this->default_value=$default_value;
		$this->disable=$disable;

		if(!in_array($type,$type_list))
			return false;

		if($type!='radio' && $type!='checkbox')
			$this->class=array('form-control');

		$this->type=$type;
	}

	function set_id($id='')
	{
		$this->id=$id;

		return $this;
	}

	function set_style($style='')
	{
		$this->style=$style;

		return $this;
	}
	function set_class($class='')
	{
		if(!is_array($class))
		{
			$class = explode(' ',$class);
		}

		$this->class=$class;

		return $this;
	}
	function add_class($add='')
	{
		if(is_array($add))
		{
			foreach ($add as $key => $each_single)
			{
				array_push($this->class,$each_single);
			}
		}
		else
			array_push($this->class,$add);

		return $this;
	}

	function add_attr($add)
	{
		if(is_array($add))
		{
			foreach ($add as $key => $each_single)
			{
				array_push($this->attr,$each_single);
			}
		}
		else
			array_push($this->attr,$add);

		return $this;
	}

	function default_value($default_value)
	{
		$this->default_value=$default_value;
		return $this;
	}

	function set_option($nacami='')
	{
		$this->nacami=$nacami;

		return $this;
	}

	function auto_break($auto_break='false')
	{
		$this->auto_break = $auto_break;

		return $this;
	}

	function ini_by_class($class_name)
	{
		$this->ini_class = $class_name;

		return $this;
	}

	function print_javascript($SW=true)
	{
		$this->print_javascript = $SW;

		return $this;
	}

	function return_html()
	{
		$type=$this->type;
		$this->$type();
		return $this->html;
	}

	function print_html()
	{
		$type=$this->type;
		$this->$type();
		echo $this->html;
	}

	private function text()
	{
		$html='';
		$html.='<input type="text" ';
		$html.='name="'.$this->name.'" ';
		$html.='id="'.$this->id.'" ';
		$html.='class="'.implode(' ',$this->class).'" ';
		if($this->style!='')
			{$html.='style="'.$this->style.'" ';}
		$html.=($this->disable?'disabled="disabled"':'');
		$html.=implode(' ',$this->attr);
		$html.='value="'.$this->default_value.'" ';
		$html.='>';

		$this->html=$html;
	}

	private function hidden()
	{
		$html='';
		$html.='<input type="hidden" ';
		$html.='name="'.$this->name.'" ';
		$html.='id="'.$this->id.'" ';
		$html.='class="'.implode(' ',$this->class).'" ';
		if($this->style!='')
			{$html.='style="'.$this->style.'" ';}
		$html.=($this->disable?'disabled="disabled"':'');
		$html.=implode(' ',$this->attr);
		$html.='value="'.$this->default_value.'" ';
		$html.='>';

		$this->html=$html;
	}

	private function number()
	{
		$html='';
		$html.='<input type="number" ';
		$html.='name="'.$this->name.'" ';
		$html.='id="'.$this->id.'" ';
		$html.='class="'.implode(' ',$this->class).'" ';
		if($this->style!='')
			{$html.='style="'.$this->style.'" ';}
		$html.=($this->disable?'disabled="disabled"':'');
		$html.=implode(' ',$this->attr);
		$html.='value="'.$this->default_value.'" ';
		$html.='>';

		$this->html=$html;
	}

	private function float()
	{
		$this->add_attr('step="0.1"');
		
		$html='';
		$html.='<input type="number" ';
		$html.='name="'.$this->name.'" ';
		$html.='id="'.$this->id.'" ';
		$html.='class="'.implode(' ',$this->class).'" ';
		if($this->style!='')
			{$html.='style="'.$this->style.'" ';}
		$html.=($this->disable?'disabled="disabled"':'');
		$html.=implode(' ',$this->attr);
		$html.='value="'.$this->default_value.'" ';
		$html.='>';

		$this->html=$html;
	}

	private function password()
	{
		$html='';
		$html.='<input type="password" ';
		$html.='name="'.$this->name.'" ';
		$html.='id="'.$this->id.'" ';
		$html.='class="'.implode(' ',$this->class).'" ';
		if($this->style!='')
			{$html.='style="'.$this->style.'" ';}
		$html.=($this->disable?'disabled="disabled"':'');
		$html.=implode(' ',$this->attr);
		$html.='value="'.$this->default_value.'" ';
		$html.='>';

		$this->html=$html;
	}
	private function time()
	{
		$html='';
		$html.='<input type="time" ';
		$html.='name="'.$this->name.'" ';
		$html.='id="'.$this->id.'" ';
		$html.='class="'.implode(' ',$this->class).'" ';
		if($this->style!='')
			{$html.='style="'.$this->style.'" ';}
		$html.=($this->disable?'disabled="disabled"':'');
		$html.=implode(' ',$this->attr);
		$html.='value="'.$this->default_value.'" ';
		$html.='>';

		$this->html=$html;
	}

	private function date()
	{
		$html='';
		$html.='<input type="'.$this->type.'" ';
		$html.='name="'.$this->name.'" ';
		$html.='id="'.$this->id.'" ';
		$html.='class="'.implode(' ',$this->class).'" ';
		if($this->style!='')
			{$html.='style="'.$this->style.'" ';}
		$html.='placeholder="yyyy/mm/dd" ';
		$html.=($this->disable?'disabled="disabled"':'');
		$html.=implode(' ',$this->attr);
		$html.='value="'.$this->default_value.'" ';
		$html.='>';

		$this->html=$html;
		// $this->datepicker();
	}
	private function month()
	{
		$this->datepicker_mode = 'months';
		$this->datepicker();
	}
	private function datepicker()
	{
		$datepicker_format = (is_array($this->datepicker_format)?$this->datepicker_format[$this->datepicker_mode]:$this->datepicker_format);

		$html='';
		$html.='<input type="text" ';
		$html.='name="'.$this->name.'" ';
		$html.='id="'.$this->id.'" ';
		$html.='class="'.implode(' ',$this->class).'" ';
		if($this->style!='')
			{$html.='style="'.$this->style.'" ';}
		$html.='placeholder="yyyy-mm-dd" ';
		$html.=($this->disable?'disabled="disabled"':'');
		$html.=implode(' ',$this->attr);
		$html.='value="'.$this->default_value.'" ';
		$html.='>';




		$html.='
		<script>
			$(function(){
			    $( "#'.$this->id.'" ).datepicker({
			        dateFormat: "'.(is_array($this->datepicker_format)?$this->datepicker_format[$this->datepicker_mode]:$datepicker_format).'",
					changeMonth: true,
					changeYear: true,
					yearRange: "1950:"+((new Date).getFullYear()+10),
					viewMode: "'.$this->datepicker_mode.'",
					minViewMode: "'.$this->datepicker_mode.'",
					language:"zh-TW",
					beforeShow: function() {
						if ((selDate = $(this).val()).length > 0)
						{
							var realDate = new Date(selDate);
							$(this).datepicker(\'option\',\'defaultDate\', realDate);
							$(this).datepicker(\'setDate\', realDate);
						}
					},';
		if($this->datepicker_mode=='months')
			$html.='
	    			showButtonPanel: true,
					onClose: function() {
						var iMonth = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
						var iYear = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
						$(this).datepicker(\'setDate\', new Date(iYear, iMonth, 1));
					  },
					';
		$html.='
			    });
			});
		</script>';
		// minViewMode: "'.$this->datepicker_mode.'",
		// defaultViewDate: "'.$this->default_value.'",
		// defaultDate: "'.strtotime()($this->default_value).'",

    

		$this->html=$html;
	}

	private function select($select2=false)
	{
		$nacami=$this->nacami;
		$array_switch=false;
		if(is_array($this->default_value))
		{
			$array_switch=true;
		}
		
		$html='';
		$html.='<select ';
		$html.='name="'.$this->name.'" ';
		$html.='id="'.$this->id.'" ';
		$html.='class="'.implode(' ',$this->class).'" ';
		$html.=($this->disable?'disabled="disabled"':'');
		if($select2 && $this->style!='')
			{$html.='style="display:none" ';}
		elseif($this->style!='')
			{$html.='style="'.$this->style.'" ';}
		$html.=implode(' ',$this->attr);
		// seeData($html,1);
		$html.='>';
		if(is_array($nacami))
		{
			foreach ($nacami as $value => $str)
			{
				if(is_object($obj = $str))
				{
					if((string)$value != '_disabled')
					{
						$html.='<option value="'.$value.'" ';
						if($array_switch)
						{
							$html.=isset($this->default_value[$value])?'selected="selected" ':'';
						}
						else
						{
							$html.=($value==$this->default_value && $this->default_value!==null && $this->default_value!=='')?'selected="selected" ':'';
						}
						if(isset($obj->attr))
						{
							foreach ($obj->attr as $obj_attr_name => $obj_attr_value)
							{
								$html .= $obj_attr_name.'="'.$obj_attr_value.'" ';
							}
						}
						$html.='>';
						$html.=$obj->html;
						$html.="</option>";
					}
					else
					{
						//單一disabled
						if(!is_array($str))
						{
							$html.='<option value="" ';
							$html.='disabled="disabled" '.(!isset($this->default_value)||empty($this->default_value)?'selected="selected"':'');
							$html.='>';
							$html.=$str;
							$html.="</option>";
						}
						else
						{
							foreach ($str as $disabled_value => $disabled_str)
							{
								$html.='<option value="" ';
								$html.='disabled="disabled" '.(!isset($this->default_value)||empty($this->default_value)?'selected="selected"':'');
								$html.='>';
								$html.=$disabled_str;
								$html.="</option>";
								
							}
						}
					}
				}
				else
				{
					if((string)$value != '_disabled')
					{
						$html.='<option value="'.$value.'" ';
						if($array_switch)
						{
							$html.=isset($this->default_value[$value])?'selected="selected" ':'';
						}
						else
						{
							$html.=($value==$this->default_value && $this->default_value!==null && $this->default_value!=='')?'selected="selected" ':'';
						}
						$html.='>';
						$html.=$str;
						$html.="</option>";
					}
					else
					{
						//單一disabled
						if(!is_array($str))
						{
							$html.='<option value="" ';
							$html.='disabled="disabled" '.(!isset($this->default_value)||empty($this->default_value)?'selected="selected"':'');
							$html.='>';
							$html.=$str;
							$html.="</option>";
						}
						else
						{
							foreach ($str as $disabled_value => $disabled_str)
							{
								$html.='<option value="" ';
								$html.='disabled="disabled" '.(!isset($this->default_value)||empty($this->default_value)?'selected="selected"':'');
								$html.='>';
								$html.=$disabled_str;
								$html.="</option>";
								
							}
						}
					}
				}
			}
		}
		$html.='</select>';

		if($select2)
		{
			$slector = '$("#'.$this->id.'")';

			if(isset($this->ini_class))
				$slector='$(".'.$this->ini_class.'")';

			$html.='<script>';
			$html.= $slector.'.select2({closeOnSelect:true});';
			if($this->style!='')
			{
				$style_tmp = explode(';',$this->style);
				$style = array();
				foreach ($style_tmp as $key => $tmp_str)
				{
					$break = strcspn($tmp_str,':');

					$css = trim(substr($tmp_str,0,$break));
					$value = trim(substr($tmp_str,$break+1));

					$style[$css] = $value;
				}

				//設定style
				$html.='$(function(){
					'.$slector.'.next().attr("style","'.$this->style.'");';
				if(!isset($style['height']))
				{
					$html.='var h = '.$slector.'.next().css("height");
					if(h)
					{
				 		'.$slector.'.next().find("ul").css("height",h);
					}';
				}
				else
				{
					$html.=$slector.'.next().find("ul").css("height","'.$style['height'].'");';
				}

				$html.='})';
			}
			$html.='</script>';
		}

		$this->html=$html;	
	}
	private function select2()
	{
		$this->add_class('select2');
		$this->select(1);
	}
	private function radio()
	{
		$nacami=$this->nacami;

		
		$html='';
		foreach ($nacami as $value => $str)
		{
			$html.='<label class="radio-inline input-inline">';
			$html.='<input type="radio" ';
			$html.='name="'.$this->name.'" ';
			$html.='id="'.$this->id.'_'.$value.'" ';
			$html.='class="'.implode(' ',$this->class).'" ';
			if($this->style!='')
				{$html.='style="'.$this->style.'" ';}
			$html.=($this->disable?'disabled="disabled"':'');
			$html.=implode(' ',$this->attr);
			$html.='value="'.$value.'" ';
			$html.=($value==$this->default_value && $this->default_value!==null && $this->default_value!=='')?'checked="checked" ':'';
			$html.='>';
			$html.='<span>'.$str.'</span>';
			$html.='</label>';
			$html.=($this->auto_break?'<br>':'&nbsp;&nbsp;');
		}
		$this->html=$html;	
	}
	private function checkbox()
	{
		$nacami=$this->nacami;
		$array_switch=false;
		if(is_array($this->default_value))
		{
			$array_switch=true;
		}

		
		$html='';
		foreach ($nacami as $value => $str)
		{
			$html.='<label class="checkbox-inline input-inline">';
			$html.='<input type="checkbox" ';
			$html.='name="'.$this->name.'" ';
			$html.='id="'.$this->id.'_'.$value.'" ';
			$html.='class="'.implode(' ',$this->class).'" ';
			if($this->style!='')
				{$html.='style="'.$this->style.'" ';}
			$html.=($this->disable?'disabled="disabled"':'');
			$html.=implode(' ',$this->attr);
			$html.='value="'.$value.'" ';
			if($array_switch)
			{
				$html.=isset($this->default_value[$value])?'checked="checked" ':'';
			}
			else
			{
				$html.=($value==$this->default_value && $this->default_value!==null && $this->default_value!=='')?'checked="checked" ':'';
			}
			$html.='>';
			$html.='<span>'.$str.'</span>';
			$html.='</label>';
			$html.=($this->auto_break?'<br>':'&nbsp;&nbsp;');
		}
		$this->html=$html;	
	}
	private function textarea()
	{
		$html='';
		$html.='<textarea ';
		$html.='name="'.$this->name.'" ';
		$html.='id="'.$this->id.'" ';
		$html.='warp="virtual" ';
		$html.='class="'.implode(' ',$this->class).'" ';
		if($this->style!='')
			{$html.='style="'.$this->style.'" ';}
		$html.=($this->disable?'disabled="disabled"':'');
		$html.=implode(' ',$this->attr);
		$html.='>';
		$html.=$this->default_value;
		$html.='</textarea>';

		$this->html=$html;
	}

	private function ckeditor()
	{
		$this->add_class('ckeditor');
		$this->textarea();
		$this->html.= "
		<script>
		$(function(){
			CKEDITOR.replace('".$this->id."',{
				enterMode : CKEDITOR.ENTER_BR,
				shiftEnterMode: CKEDITOR.ENTER_P
			});
			CKEDITOR.instances['".$this->id."'].on('change', function(){
				var values = this.getData();
				$('#".$this->id."').html(values);
			});
		});
		</script>
		";
	}

	public function file_allow($allow_list)
	{
		if(is_array($allow_list) && !empty($allow_list))
		{
			foreach ($allow_list as $key => &$each)
			{
				$each = '\''.$each.'\'';
			}			
			$this->file_allow_list = $allow_list;
		}
		return $this;
	}

	private function file()
	{
		$html ='<input ';
		$html.='type="file" ';
		$html.='id="'.$this->id.'" ';
		$html.='name="'.$this->name.'" ';
		$html.='class="'.implode(' ',$this->class).'" ';
		$html.='data-preview-file-type="text" ';
		if($this->style!='')
			{$html.='style="'.$this->style.'" ';}
		$html.=($this->disable?'disabled="disabled"':'');
		$html.=implode(' ',$this->attr);
		$html.='>';


		$allow = '';
		if(!empty($this->file_allow_list))
		{
			$allow = 'allowedFileExtensions:['.implode(',',$this->file_allow_list).'],';
		}

		if($this->print_javascript)
		{
			$html.='<script>
				$(function(){				
		            $("#'.$this->id.'").fileinput({
		            	language: \'zh-TW\',
		            	showUpload:false,
		            	showPreview:false,
		                uploadAsync: true,
		                overwriteInitial: false,
		                '.$allow.'
		            });
				});
			</script>';			
		}

		$this->html = $html;
	}
}