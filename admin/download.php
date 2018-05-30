<?php
require_once '../vendor/index.php';
require_once '../vendor/library/PHPExcel/PHPExcel.php';

// check user login status
if (!($user = \App\Auth::isLogged()) || $user->role != 'admin') {
    \App\Utils::redirect('login.php');
}

// prepare sql to get assessment
// count rating data and get counted data using left join
$sql  = 'SELECT u.id AS institute_id, u.institute, ';
$sql .= 'COALESCE( na.total_0, 0 ) AS total_0, COALESCE( na.total_1, 0 ) AS total_1, ';
$sql .= 'COALESCE( na.total_2, 0 ) AS total_2, COALESCE( na.total_3, 0 ) AS total_3 ';
$sql .= 'FROM '.\App\Auth::table.' uc ';
$sql .= 'INNER JOIN users u ON uc.id = u.user_id ';
$sql .= 'LEFT JOIN ( ';
$sql .= '    SELECT a.institute_id, ';
$sql .= '    COUNT(CASE WHEN a.rating = 0 THEN 1 ELSE NULL END ) AS total_0, ';
$sql .= '    COUNT(CASE WHEN a.rating = 1 THEN 1 ELSE NULL END ) AS total_1, ';
$sql .= '    COUNT(CASE WHEN a.rating = 2 THEN 1 ELSE NULL END ) AS total_2, ';
$sql .= '    COUNT(CASE WHEN a.rating = 3 THEN 1 ELSE NULL END ) AS total_3 ';
$sql .= '    FROM assessments a ';
$sql .= '    GROUP BY a.institute_id ';
$sql .= ') na ';
$sql .= 'ON na.institute_id = u.id ';
$sql .= 'WHERE uc.role = ?';
// execute sql
$result = R::getAll($sql, array('institute'));

$sqlD  = 'SELECT u.institute, a.rating, a.rated_at ';
$sqlD .= 'FROM assessments a ';
$sqlD .= 'INNER JOIN users u ON a.institute_id = u.id ';
$sqlD .= 'INNER JOIN '.\App\Auth::table.' uc ON uc.id = u.user_id ';
$sqlD .= 'WHERE uc.role = ?';
// execute sql
$resultDetails = R::getAll($sqlD, array('institute'));

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("EVAN UM")
    ->setLastModifiedBy("EVAN UM")
    ->setTitle("Office 2007 XLSX Test Document")
    ->setSubject("Office 2007 XLSX Test Document")
    ->setDescription("Hasil penilaian layanan um")
    ->setKeywords("office 2007 openxml php")
    ->setCategory("Report file");

$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', "No")
    ->setCellValue('B1', "Lembaga")
    ->setCellValue('C1', "Very Good")
    ->setCellValue('D1', "Good")
    ->setCellValue('E1', "Bad")
    ->setCellValue('F1', "Very Bad");
$ii = 1;
foreach ($result as $res) {
    $ii++;
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$ii, $ii-1)
        ->setCellValue('B'.$ii, $res['institute'])
        ->setCellValue('C'.$ii, $res['total_0'])
        ->setCellValue('D'.$ii, $res['total_1'])
        ->setCellValue('E'.$ii, $res['total_2'])
        ->setCellValue('F'.$ii, $res['total_3']);
}
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Penilaian');

$objWorkSheet = $objPHPExcel->createSheet(1);
$objPHPExcel->setActiveSheetIndex(1)
    ->setCellValue('A1', "No")
    ->setCellValue('B1', "Lembaga")
    ->setCellValue('C1', "Penilaian")
    ->setCellValue('D1', "Tanggal dan Jam");
$ii = 1;
foreach ($resultDetails as $res) {
    $ii++;
    $rating = '';
    switch ($res['rating']) {
        case 0:
            $rating = 'Very Good';
            break;
        case 1:
            $rating = 'Good';
            break;
        case 2:
            $rating = 'Bad';
            break;
        case 3:
            $rating = 'Very Bad';
            break;
    }
    $objPHPExcel->setActiveSheetIndex(1)
        ->setCellValue('A'.$ii, $ii-1)
        ->setCellValue('B'.$ii, $res['institute'])
        ->setCellValue('C'.$ii, $rating)
        ->setCellValue('D'.$ii, $res['rated_at']);
}
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Detail Penilaian');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$reportName = "EVAN UM Report - ".date("Y-m-d H-i-s").".xlsx";

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$reportName.'"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;