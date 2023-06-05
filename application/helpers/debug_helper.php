<?php
if(!function_exists('seeData'))
{
	function seeData($value='there is nothing',$die=false,$method=array())
	{
		$donot_pre=false;
		$show_type=false;
		
		if(!is_array($method))
		{
			switch ($method)
			{
				case 'show_type':
					$show_type=true;
					break;
				case 'donot_pre':
					$donot_pre=true;
					break;
				default:
					break;
			}
		}
		echo $donot_pre?"":"<pre>";
		echo $show_type?"(".get_type($value).")<br>":"";
		print_r($value);
		echo $donot_pre?"":"</pre>";

		if($die)
			die('end here');
	}
}

if(!function_exists('memory_use_now'))
{
	function memory_use_now()
	{
		$level = array('Bytes', 'KB', 'MB', 'GB');
		$n = memory_get_usage();
		for ($i=0, $max=count($level); $i<$max; $i++)
		{
			if ($n < 1024)
			{
				$n = round($n, 2);
				return "{$n} {$level[$i]}";
			}
			$n /= 1024;
		}
	}
}