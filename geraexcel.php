<?php
include_once('conexao.php');
include('vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->getStyle('A1:C1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
$sheet->getStyle('A1:C1')->getFill()->getStartColor()->setARGB('FF09E81F'); // Corrigir formato ARGB

$sheet->setCellValue('A1', 'Nome');
$sheet->setCellValue('B1', 'Email');
$sheet->setCellValue('C1', 'Data de Nascimento');

$sql = "SELECT nome, email, data_nascimento FROM usuarios";
$usuarios = mysqli_query($conexao, $sql);

if (mysqli_num_rows($usuarios) > 0) {
    $contagem = 2;
    foreach ($usuarios as $usuario) {
        $sheet->getCell('A' . $contagem)->setValue($usuario['nome']);
        $sheet->getCell('B' . $contagem)->setValue($usuario['email']);
        $sheet->getCell('C' . $contagem)->setValue($usuario['data_nascimento']);
        $contagem++;
    }

    // Enviar o arquivo para o navegador para download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="usuarios.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');
    exit;
}

header('Location: index.php');
exit;
