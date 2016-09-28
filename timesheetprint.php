<?php
require('fpdf/fpdf.php');
//sql stuff
if(isset($_POST['id']) AND isset($_POST['totalTime']) AND isset($_POST['period'])){
	//save vars and query employee data from database
	$id = $_POST['id'];
	$time = $_POST['totalTime'];
	$period = $_POST['period'];
	$period = str_replace(" ", "", $period);
	$tmp = explode("-", $period);
	$tmp[0] = explode("/", $tmp[0]);
	$tmp[1] = explode("/", $tmp[1]);
	$period = array('start'=>array('month'=>$tmp[0][0], 'day'=>$tmp[0][1]), 'end'=>array('month'=>$tmp[1][0], 'day'=>$tmp[1][1]));
	require("config.php");
	$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
	if ($conn -> connect_error) {
		die("Connection failed: " . $con -> connecterror);
	}
	$sql = "SELECT * FROM employees WHERE id = $id";
	$conn->close();
	//TODO: get the values from the db for the pdf header
}
else{
	header('Location: timesheet.php');
	exit();
}
//function to get the number of weeks in period
function numWeeks($period){
	$weekdays = array(0,0,0,0,0);
	for($i = $period['start']['day']; $i <= $period['end']['day']; $i++){
		$dayOfWeek = date('N', DateTime::createFromFormat('n/j', $period['start']['month'] . "/" . $i)->getTimestamp());
		if($dayOfWeek < 6){
			$weekdays[$dayOfWeek - 1]++;
		}
	}
	return array('weeks'=>max($weekdays), 'days'=>array_sum($weekdays));
}
function generateWeeks($numWeeks, $numDays, $time, $maxTime, $start, $end){
	//given the number of weeks to generate, distribute time in the days of the weeks
	$total = $time;
	$weeks = array();
	$val = $total / $numDays;
	$count = $start['day'];
	for($i = 0; $i < $numWeeks; $i++){
		$tmp = array(0,0,0,0,0);
		for(; $count <= $end['day'] AND date('N', DateTime::createFromFormat('n/j', $start['month'] . "/" . ($count))->getTimestamp()) < 6; $count++){
			$day = date('N', DateTime::createFromFormat('n/j', $start['month'] . "/" . ($count))->getTimestamp());
			$tmp[$day-1] = floor($val/3600);
		}
		$weeks[] = $tmp;
		$count += 2;
	}
	return $weeks;
}
//  my stuff
class PDF extends FPDF
{

}

// $name = $_POST['name'];
$name = 'David Teutli';
// $department = $_POST['department'];
$department = 'Department';
// $ut_eid = $_POST['ut_eid'];
$ut_eid = '0123456789';
// $job_title = $_POST['job_title'];
$job_title = 'El Jefe';
// $PI = $_POST['PI'];
$PI = 'Dr. Abdallah';
// $division = $_POST['division'];
$division = 'Division';
// $date = $_POST['date'];
$date = date("Y/m/d");
$days = generateWeeks(numWeeks($period)['weeks'], numWeeks($period)['days'], $time, 28, $period['start'], $period['end']);
// $days = [['6','5','6','5','6'],['6','5','6','5','6'],['6','5','6','5','6'],['6','5','6','5','6']];
// $timeperiod = $_POST['timeperiod'];
$timeperiod = ['date','date','date','date'];

$department = 'Department' . $time;

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
// Insert a dynamic image from a URL
$pdf->Image('image/timesheet.png',0,0,210,0,'PNG');
$pdf->SetFont('Times','',12);
// $pdf->Cell(Width,Height,'Text',Border,New Line);
$pdf->Cell(0,22,'',0,1); // blank space for format
$pdf->Cell(0,10,$PI,0,1,'C');  // blank space for format and PI variable
$pdf->Cell(0,2,'',0,1);  // blank space for format
$pdf->Cell(80,10,$name,0);
$pdf->Cell(25,10,' ',0);
$pdf->Cell(80,10,$job_title,0,1);

$pdf->Cell(0,4,' ',0,1);
$pdf->Cell(80,10,$department,0);
$pdf->Cell(25,10,' ',0);
$pdf->Cell(80,10,$division,0);

$pdf->Cell(0,15,' ',0,1);
$pdf->Cell(80,10,$ut_eid,0);
$pdf->Cell(25,10,' ',0);
$pdf->Cell(80,10,$date,0,1);

$pdf->Cell(0,4,'',0,1);
$pdf->Cell(28,10,'',0);
$pdf->Cell(60,10,$timeperiod[0],0);
$pdf->Cell(42,10,'',0);
$pdf->Cell(60,10,$timeperiod[1],0,1);


// **** Week 1 ****
$pdf->Cell(0,5,'',0,1);
$pdf->Cell(30,10,'',0);
for ($i=0; $i < 5; $i++) {
	if(!isset($days[0])){
			$days[0] = ['','','','',''];
	}
  $pdf->Cell(9,10,$days[0][$i],0);
}
$pdf->Cell(7,10,'',0);
$pdf->Cell(9,10,array_sum($days[0]),0);


//**** Week 2 ****
$pdf->Cell(40,10,'',0);
for ($i=0; $i < 5; $i++) {
	if(!isset($days[1])){
			$days[1] = ['','','','',''];
	}
  $pdf->Cell(9,10,$days[1][$i],0);
}
$pdf->Cell(7,10,'',0);
$pdf->Cell(9,10,array_sum($days[1]),0);

// **** Weekly Totals Week 1 & 2 ****
$pdf->Cell(0,15,'',0,1);
$pdf->Cell(82,10,'',0);
$pdf->Cell(9,10,array_sum($days[0]),0);
$pdf->Cell(92,10,'',0);
$pdf->Cell(9,10,array_sum($days[1]),0,1);

// 2nd row
$pdf->Cell(0,5,'',0,1);
$pdf->Cell(28,10,'',0);
$pdf->Cell(60,10,$timeperiod[2],0);
$pdf->Cell(40,10,'',0);
$pdf->Cell(60,10,$timeperiod[3],0,1);

// **** Week 3 ****
$pdf->Cell(0,5,'',0,1);
$pdf->Cell(30,10,'',0);
for ($i=0; $i < 5; $i++) {
	if(!isset($days[2])){
			$days[2] = ['','','','',''];
	}
  $pdf->Cell(9,10,$days[2][$i],0);
}
$pdf->Cell(7,10,'',0);
$pdf->Cell(9,10,array_sum($days[2]),0);

// **** Week 4 ****
$pdf->Cell(40,10,'',0);
for ($i=0; $i < 5; $i++) {
	if(!isset($days[3])){
			$days[3] = ['','','','',''];
	}
  $pdf->Cell(9,10,$days[3][$i],0);
}
$pdf->Cell(7,10,'',0);
$pdf->Cell(9,10,array_sum($days[3]),0);

// **** Weekly Totals Week 3 & 4 ****
$pdf->Cell(0,15,'',0,1);
$pdf->Cell(82,10,'',0);
$pdf->Cell(9,10,array_sum($days[2]),0);
$pdf->Cell(93,10,'',0);
$pdf->Cell(9,10,array_sum($days[3]),0,1);

$pdf->Output();
?>
