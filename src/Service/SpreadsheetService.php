<?php

namespace App\Service;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use App\Entity\Shedule;
use App\Entity\Group;
use App\Entity\Course;
use App\Entity\Pair;

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
        $shedule = new Shedule();

        $courseNames = $this->reader->listWorksheetNames($this->filename);

        $courses = array();

        foreach ($courseNames as $key => $courseName) {
        	$course = new Course();
        	$course->setName($courseName);
        	$shedule->addCourse($course);

        	$courses[] = $course;
        }

        foreach ($courses as $key => $course) {
        	$this->spreadsheet->setActiveSheetIndex($key);
        	$sheet = $this->spreadsheet->getActiveSheet();

        	$col = 1;
        	$times = array();
        	for($row = 6; $row < 10; $row++){
        		
				$times[] = $this->getValue($col, $row, $sheet);
        	}

        	$row = 4;
        	$col = 2;
        	$next = true;
        	while($next){
        		$name = null;
        		$name = $this->getValue($col, $row, $sheet);
        		if($name == null){
        			$next = false;
        		}else{
        			$group = new Group();
        			$group->setName($name);

        			$pair_rows = 
        				  [  6, 7, 8, 9,
							11,12,13,14,
							16,17,18,19,
							21,22,23,24,
							26,27,28,29,
						    31,32,33,34];

					foreach ($pair_rows as $key => $pair_row) {
						$number = ($key % 4) + 1;
						$day = intdiv($key, 4) + 1;
						$text = $this->getValue($col, $pair_row, $sheet);
						$text = preg_replace('!Ф *И *З *И *Ч *Е *С *К *А *Я *К *У *Л *Ь *Т *У *Р *А!', 'ФИЗКУЛЬТУРА', $text);
						$text = $text == null ? '' : $text;

						$pair = new Pair();
						$pair->setText($text)
							 ->setNumber($number)
						     ->setDay($day); 

						$group->addPair($pair);
					}

        			$course->addGroup($group);

        			$col++;
        		}
        	}

        	$course->setTimes($times);	
        }

		return $shedule;
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

	private function getValue($col, $row, $s)
	{
		if($s->getCellByColumnAndRow($col, $row)->isInMergeRange()){
			return $this->getMergedRangeValue($s, $col, $row);
		}else{
			return $s->getCellByColumnAndRow($col, $row)->getCalculatedValue();
		}
	}

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