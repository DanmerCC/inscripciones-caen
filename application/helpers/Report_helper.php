<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function process_and_export_excel($headers,$cuerpo){
	$spreadsheet = new Spreadsheet();
	$sheet = $spreadsheet->getActiveSheet();

	$fila = 2;
	$col = 'A';
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
			$sheet->setCellValue($col.$fila, $value);
			$col++;
		}
		$fila++;
	}

	$spreadsheet->getActiveSheet()->setAutoFilter('A2:'.$col.$fila);

	$writer = new Xlsx($spreadsheet);

	$filename = 'Listado-de-inscripciones-'.time();

	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
	header('Cache-Control: max-age=0');
	
	$writer->save('php://output'); // download file 
}
