<?php
// Include database connection
include "../DBConnection/connect.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data)) {
    foreach ($data as $entry) {
        $date = $entry['date'];
        $department = $entry['department'];
        $subject = $entry['subject'];
        $batch = $entry['batch'];
        $year = $entry['year'];
        $semester = $entry['semester'];
        $start_time = $entry['startTime'];
        $end_time = $entry['endTime'];

        $query = "INSERT INTO timetable (date, department, subject, batch, year, semester, start_time, end_time) VALUES ('$date', '$department', '$subject', '$batch', '$year', '$semester', '$start_time', '$end_time')";
        mysqli_query($conn, $query);
    }
    echo "Timetable saved successfully!";
} else {
    echo "No data received!";
}
?>
