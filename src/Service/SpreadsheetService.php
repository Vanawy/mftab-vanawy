<?php

namespace App\Service;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SpreadsheetService
{
	private $reader;
	private $spreadsheet;
	private $shedule;
	private $filename;


	public function open(String $filename, bool $onlydata = false)
	{
		/**  Create a new Reader of the type defined in $inputFileType  **/
   		$this->reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
		/**  Advise the Reader that we only want to load cell data  **/
		$this->reader->setReadDataOnly($onlydata);
		/**  Load $inputFileName to a Spreadsheet Object  **/
		$this->spreadsheet = $this->reader->load($filename);
		$this->filename = $filename;

		return $this;
	}

	public function parseShedule(){
		dump($this->reader->listWorksheetNames($this->filename));

		return null;
	}

	// $ss = new SpreadsheetService();

	// $inputFileName = '17.xls';
	// $spreadsheet = $ss->open($inputFileName);

	// $spreadsheet->setActiveSheetIndex(2);
	// $sheet = $spreadsheet->getActiveSheet();
	// for($col = 1; $col < 8; $col++){
	// 	for($row = 5; $row < 10; $row++){
	// 		if($sheet->getCellByColumnAndRow($col, $row)->isInMergeRange()){
	// 			$value = $ss->getMergedRangeValue($sheet, $col, $row);
	// 		}else{
	// 			$value = $sheet->getCellByColumnAndRow($col, $row)->getCalculatedValue();
	// 		}
	// 		$dataArray[$col][$row] = $value;
	// 	}
	// }
	// dump($dataArray);
	

	// $spreadsheet = new Spreadsheet();
	// $sheet = $spreadsheet->getActiveSheet();
	// $sheet->setCellValue('A1', 'Hello World !');

	// $writer = new Xlsx($spreadsheet);
	// $writer->save('hello world.xlsx');

	private function getMergedRangeValue($sheet, $col, $row)
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