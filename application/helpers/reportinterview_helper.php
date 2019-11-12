<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

function processAndExportInterviewExcel($headers,$cuerpo){
	$spreadsheet = new Spreadsheet();
	$sheet = $spreadsheet->getActiveSheet();

	$fila = 2;
	$col = 'A';

	$sheet->getColumnDimension('A')->setWidth(10);
	$sheet->getColumnDimension('B')->setWidth(20);
	$sheet->getColumnDimension('C')->setWidth(20);
	$sheet->getColumnDimension('D')->setWidth(20);
	$sheet->getColumnDimension('E')->setWidth(50);
	$sheet->getColumnDimension('F')->setWidth(20);

	foreach ($headers as $key => $val) {
		$sheet->setCellValue($col.$fila, $val);
		$col++;
	}
	$col = chr(ord($col)-1);
	$spreadsheet->getActiveSheet()->getStyle('A2:'.$col."2")->getFont()->setBold( true );

	//$spreadsheet->getActiveSheet()->getColumnDimensionByColumn("B")->setAutoSize(false);
	$fila = 3;
	foreach ($cuerpo as $key => $item) {
		$col = 'A';
		foreach ($item as $keys => $value) {
			if($key%2!=0){
				$sheet->getStyle('A'.$fila.':F'.$fila)
				->getFill()
				->setFillType(Fill::FILL_SOLID)
				->getStartColor()->setARGB('f8f2e5');
			}

			$sheet->setCellValue($col.$fila, $value);
			$col++;
		}
		$fila++;
	}
	
	
	$col = chr(ord($col)-1);
	$sheet->getStyle('A2:'.$col.$fila)->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN)
			->setColor(new Color());
    $spreadsheet->getActiveSheet()->setAutoFilter('A2:'.$col.$fila);

    $spreadsheet->getActiveSheet()->getStyle('E3:E'.$fila)->getAlignment()->setWrapText(true);

	$writer = new Xlsx($spreadsheet);

	$filename = 'Listado-de-inscritos-por-filtro-'.time();

	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
	header('Cache-Control: max-age=0');
	
	$writer->save('php://output'); // download file 
}
