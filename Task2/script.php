<?php
$user = 'root';
$password = ''; 
$database = 'task_hospital';
$port = NULL; 
$mysqli = new mysqli('127.0.0.1', $user, $password, $database, $port);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}
echo "Connection OK: " . $mysqli->host_info . "\n";
echo "Server: " . $mysqli->server_info . "\n";
echo "Initial charset: " . $mysqli->character_set_name() . "\n";

echo "\nPatient Info:\n";

$query = "
    SELECT
        p.pn,
        p.last, 
        p.first,
        i.iname,
        DATE_FORMAT(i.from_date, '%m-%d-%y') AS from_date, 
        DATE_FORMAT(i.to_date, '%m-%d-%y') AS to_date
    FROM patient p JOIN insurance i ON p._id = i.patient_id
    ORDER BY i.from_date ASC, p.last ASC
";

$result = $mysqli->query($query);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $format = "%s, %s, %s, %s, %s, %s\n";
        echo sprintf($format, $row["pn"], $row["first"], $row["last"], $row["iname"], $row["from_date"], $row["to_date"]);
    }

    $result -> free_result();
} else {
    echo "0 results";
}



echo "\nLetter Statistics:\n";

$query_st = "
    SELECT 
        first, 
        last 
    FROM patient";

$result_st = $mysqli->query($query_st);

$letters_st = [];
$total_st = 0;

if ($result_st->num_rows > 0) {
    while($row = $result_st->fetch_assoc()) {
        $fullName = strtoupper($row['first'] . $row['last']);
        $fullName = preg_replace("/[^A-Z]/", '', $fullName);

        foreach (str_split($fullName) as $char) {
            $total_st++;
            if (!isset($letters_st[$char])) {
                $letters_st[$char] = 0;
            } 
            $letters_st[$char]++;
        }
    }

    $result_st -> free_result();
} else {
    echo "0 results";
}

foreach ($letters_st as $letter => $count) {
    $percent = ($count / $total_st) * 100;
    $format = "%s\t%d\t%.2f %%\n";
    printf($format, $letter, $count, $percent);
}

$mysqli->close();
?>




