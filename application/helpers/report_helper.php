<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

function process_and_export_excel($headers,$cuerpo,$original=true){
	$spreadsheet = new Spreadsheet();
	$sheet = $spreadsheet->getActiveSheet();

	$fila = 2;
	$col = 'A';

	$sheet->getColumnDimension('A')->setWidth(10);
	$sheet->getColumnDimension('B')->setWidth(20);
	$sheet->getColumnDimension('C')->setWidth(20);
	$sheet->getColumnDimension('D')->setWidth(20);
	$sheet->getColumnDimension('E')->setWidth(25);
	$sheet->getColumnDimension('F')->setWidth(20);
	$sheet->getColumnDimension('G')->setWidth(10);
	$sheet->getColumnDimension('H')->setWidth(40);
	$sheet->getColumnDimension('I')->setWidth(20);
	$sheet->getColumnDimension('J')->setWidth(15);
	$sheet->getColumnDimension('K')->setWidth(20);
	$sheet->getColumnDimension('L')->setWidth(20);
	$sheet->getColumnDimension('M')->setWidth(20);
	$sheet->getColumnDimension('N')->setWidth(20);
	$sheet->getColumnDimension('O')->setWidth(20);
	$sheet->getColumnDimension('P')->setWidth(20);
	$sheet->getColumnDimension('Q')->setWidth(20);
	$sheet->getColumnDimension('R')->setWidth(20);
	$sheet->getColumnDimension('S')->setWidth(20);
	$sheet->getColumnDimension('T')->setWidth(20);

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
				$sheet->getStyle('A'.$fila.':K'.$fila)
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

	$writer = new Xlsx($spreadsheet);

	$filename = 'Listado-de-inscripciones-'.time();

	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
	header('Cache-Control: max-age=0');
	
	$writer->save('php://output'); // download file 
}

function quitar_tildes($cadena) {
	$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
	$permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
	$texto = str_replace($no_permitidas, $permitidas ,$cadena);
	return $texto;
}
