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
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt  LGPL
 * @version    ##VERSION##, ##DATE##
 */

/*error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
require 'vendor/autoload.php';
require "setting/db.php";*/

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

date_default_timezone_set('Asia/Ho_Chi_Minh');

/** Include PHPExcel_IOFactory */
require_once 'vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php';


if (!file_exists("xlsx/phuongxa.xlsx")) {
  exit("Please run xlsx/phuongxa.php first." . EOL);
}

echo date('H:i:s') , " Load from Excel2007 file" , EOL;
$callStartTime = microtime(true);

$objPHPExcel = PHPExcel_IOFactory::load("xlsx/phuongxa.xlsx");

$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;
echo 'Call time to read Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
// Echo memory usage
echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;


echo date('H:i:s') , " Write to Excel2007 format" , EOL;
$callStartTime = microtime(true);

$sheet = $objPHPExcel->getSheet(1);
$highestRow = $sheet->getHighestRow();
$highestColumn = $sheet->getHighestColumn();
$headingsArray = $sheet->rangeToArray('A1:'.$highestColumn.'1',null, true, true, true);
$headingsArray = $headingsArray[1];

$namedDataArray = array();

$r = -1;
for ($row = 2; $row <= $highestRow; ++$row) {
    $dataRow = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row,null, true, true, true);
    if ((isset($dataRow[$row]['A'])) && ($dataRow[$row]['A'] > '')) {
        ++$r;
        foreach($headingsArray as $columnKey => $columnHeading) {
            $namedDataArray[$r][$columnHeading] = $dataRow[$row][$columnKey];
        }
    }
}
echo "<pre>";
$database->insert($sheet->getTitle(), $namedDataArray);

