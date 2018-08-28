<?php

namespace App\Service;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SpreadsheetService
{
	public function open(String $filename, bool $onlydata = false)
	{
		/**  Create a new Reader of the type defined in $inputFileType  **/
   		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
		/**  Advise the Reader that we only want to load cell data  **/
		$reader->setReadDataOnly($onlydata);
		/**  Load $inputFileName to a Spreadsheet Object  **/
		$spreadsheet = $reader->load($filename);

		return $spreadsheet;
	}

	// $spreadsheet = new Spreadsheet();
	// $sheet = $spreadsheet->getActiveSheet();
	// $sheet->setCellValue('A1', 'Hello World !');

	// $writer = new Xlsx($spreadsheet);
	// $writer->save('hello world.xlsx');

	public function getMergedRangeValue($sheet, $col, $row)
	{
		while(!$sheet->getCellByColumnAndRow($col, $row)->isMergeRangeValueCell()){
			if($sheet->getCellByColumnAndRow($col-1, $row)->isInMergeRange()){
				$col--;
			}else{
				$row--;
			}
		}
		return $sheet->getCellByColumnAndRow($col, $row)->getCalculatedValue();
	}

}