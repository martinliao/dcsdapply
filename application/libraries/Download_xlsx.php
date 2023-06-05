<?php
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Asia/Taipei');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once($_SERVER['DOCUMENT_ROOT'].'/eda/apply/resource/PHPexcel/PHPExcel_xls_outputer_ver2.php');

class Download_xlsx
{
	public function sign_log_report($info,$categoryList){
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
									 ->setLastModifiedBy("Maarten Balliauw")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Test result file");

		$objWorkSheet = $objPHPExcel->setActiveSheetIndex(0);

		$objWorkSheet->setCellValue('A1','姓名');
		$objWorkSheet->setCellValue('B1','刷卡日期');
		$objWorkSheet->setCellValue('C1','簽到時間');
		$objWorkSheet->setCellValue('D1','簽退時間');
		$objWorkSheet->setCellValue('E1','當日報名類別時數');
		$objWorkSheet->setCellValue('F1','當日報名總時數');
		$objWorkSheet->setCellValue('G1','刷卡紀錄');
		// $objWorkSheet->setCellValue('H1','實際服勤時數');
		$objWorkSheet->setCellValue('H1','當日班次');

		$k = 2;
		$total_hours = 0;
		for($i=0;$i<count($info);$i++){
          if(count($info[$i]['sign_time']) > 1){
            $sign_out_time = $info[$i]['sign_time'][count($info[$i]['sign_time'])-1];
          } else {
            $sign_out_time = '';
          }

          $category_hours = '';
          if(isset($info[$i]['category'][1])){
            $categoryList[$info[$i]['category'][1]['category_id']]['total_hours'] += $info[$i]['category'][1]['hours'];
            $category_hours .= $info[$i]['category'][1]['name'].$info[$i]['category'][1]['hours'];
            if(count($info[$i]['category']) == 2){
              $category_hours .= "\n";
            }
          }

          if(isset($info[$i]['category'][2])){
            $categoryList[$info[$i]['category'][2]['category_id']]['total_hours'] += $info[$i]['category'][2]['hours'];
            $category_hours .= $info[$i]['category'][2]['name'].$info[$i]['category'][2]['hours'];
          }

          $sign_log_list = '';
          for($j=0;$j<count($info[$i]['sign_time']);$j++){
          	$sign_log_list .= $info[$i]['sign_time'][$j];
          	if(count($info[$i]['sign_time']) != $j+1){
          		$sign_log_list .= '　'."\n";

          	}
          }

          // print_r($sign_log_list);
          // die();
          // $sign_log_list = implode("\n", $info[$i]['sign_time']);

          if(count($info[$i]['sign_time']) > 1){
          	$tmp_first_sign_time = str_replace('<font style="color:red">(補)</font>',"",$info[$i]['sign_time'][0]);
                            $tmp_last_sign_time = str_replace('<font style="color:red">(補)</font>',"",$info[$i]['sign_time'][count($info[$i]['sign_time'])-1]);

            $true_hours = (strtotime($tmp_last_sign_time) - strtotime($tmp_first_sign_time))/3600;
            // $true_hours = (strtotime($info[$i]['sign_time'][count($info[$i]['sign_time'])-1]) - strtotime($info[$i]['sign_time'][0]))/3600;
                      
            if(round($true_hours) > $true_hours){
              $true_hours = floor($true_hours)+0.5;
            } else if(round($true_hours) < $true_hours){
              $true_hours = floor($true_hours);
            }

            if($true_hours > 8){
              $true_hours = 8;
            }
          } else {
            $true_hours = 0;
          }

          $class_times = floor($true_hours/3);
          if($class_times > count($info[$i]['category'])){
            $class_times = 1;
          }
          
          $total_hours += $info[$i]['total_hours'];
          $objWorkSheet->setCellValue("A".$k,$info[$i]['name']);
          $objWorkSheet->setCellValue("B".$k,$info[$i]['sign_date']);
          $objWorkSheet->setCellValue("C".$k,$info[$i]['sign_time'][0]);
          $objWorkSheet->setCellValue("D".$k,$sign_out_time);
          $objWorkSheet->setCellValue("E".$k,$category_hours);
          $objWorkSheet->setCellValue("F".$k,$info[$i]['total_hours']);
          $objWorkSheet->setCellValue("G".$k,$sign_log_list);
          // $objWorkSheet->setCellValue("H".$k,$true_hours);
          $objWorkSheet->setCellValue("H".$k,$class_times);
          $k++;

        }

        $objWorkSheet->setCellValue('E'.$k,'總時數');
        $objWorkSheet->setCellValue('F'.$k,$total_hours);
       

        $total_true_hours = '';
        $total_class_times = '';
        $categoryList = array_values($categoryList);
        
        for($i=0;$i<count($categoryList);$i++){
          $total_true_hours .= $categoryList[$i]['name'].$categoryList[$i]['total_hours'].'小時';
          $total_class_times .= $categoryList[$i]['name'].floor($categoryList[$i]['total_hours']/3).'班次';;

          if(count($categoryList) == ($i+1)){
            $total_true_hours .= '。';
            $total_class_times .= '。';
          } else {
            $total_true_hours .= '/';
            $total_class_times .= '/';
          }
        }

        // $k = $k+2;
        // $objWorkSheet->setCellValue("A".$k,'以上各類別實際服勤總時數：'.$total_true_hours);
        // $k++;
        // $objWorkSheet->setCellValue("A".$k,'以上各類別實際服勤總班次：'.$total_class_times);

        $styleArray = array(
						 'borders' => array(
						  'allborders' => array(
						   'style' => PHPExcel_Style_Border::BORDER_THIN,
						   'color' => array('argb' => '000000'),
						  ),
						 ),
						);

		//框線設定起始欄位到最終欄位
		$objWorkSheet->getStyle('A1:I'.($k+1))->applyFromArray($styleArray);

		// Redirect output to a client’s web browser (OpenDocument)
		header('Content-Type: application/vnd.oasis.opendocument.spreadsheet');
		header('Content-Disposition: attachment;filename="signLog.ods"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'OpenDocument');
		$objWriter->save('php://output');
		exit;
	}


}