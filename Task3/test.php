<?php
require_once 'Patient.php';
require_once 'Insurance.php';

$user = 'root';
$password = ''; 
$database = 'task_hospital'; 
$port = NULL;
$mysqli = new mysqli('127.0.0.1', $user, $password, $database, $port);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}

// echo '<p>Connection OK '. $mysqli->host_info.'</p>';
// echo '<p>Server '.$mysqli->server_info.'</p>';
// echo '<p>Initial charset: '.$mysqli->character_set_name().'</p>';


$patientsQuery = "SELECT * FROM patient";
$result = $mysqli->query($patientsQuery);

$patientsArr = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $patient = new Patient(
            $row['_id'],
            $row['pn'],
            $row['first'],
            $row['last']
            // $row['dob']
        );

        $insQuery = "SELECT * FROM insurance WHERE patient_id = {$row['_id']}";
        $insResult = $mysqli->query($insQuery);

        if ($insResult->num_rows > 0) {
            while ($insRow = $insResult->fetch_assoc()) {
                $insurance = new Insurance(
                    $insRow['_id'],
                    $insRow['patient_id'],
                    $insRow['iname'],
                    $insRow['from_date'],
                    $insRow['to_date']
                );
                $patient->getInsurances($insurance);
            }
        }

        $patientsArr[] = $patient;
    }
}


$mysqli->close();

$todayDate = (new DateTime())->format('m-d-y');
// echo $todayDate
usort($patientsArr, function($a, $b) {
    return strcmp($a->getPatientNumber(), $b->getPatientNumber());
});
foreach ($patientsArr as $patient) {
    $patient->printInsTable($todayDate);
}

?>
