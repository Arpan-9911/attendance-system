<?php
// Include database and start sessions
include "database.php";
session_start();

// Checking user is logged as admin or not
if (!isset($_SESSION['stafflogged'])) {
    header('Location: login.php');
    exit(); // Always exit after header redirects
}

// Checking data passed or not
$staffName = $_SESSION['staffName'];
$subject = $_GET['subject'];
if ($subject == null) {
    header('Location: staffDashboard.php');
    exit(); // Always exit after header redirects
}

// Load PhpSpreadsheet library
require 'vendor/autoload.php';

// Create new PhpSpreadsheet instance
$spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set headers
$sheet->setCellValue('A1', 'Student Name');
$sheet->setCellValue('B1', 'Roll No.');

// Query to fetch distinct dates for the subject
$dateQuery = "SELECT DISTINCT DATE(date) AS attendanceDate FROM `attendance` WHERE teacherName = '$staffName' AND subject = '$subject' ORDER BY attendanceDate ASC";

$dateResult = mysqli_query($connection, $dateQuery);

if ($dateResult) {
    $colIndex = 'C'; // Start from column C (after 'Student Name' and 'Roll No.')
    $rowIndex = 2; // Start from row 2

    // Query to fetch student names and roll numbers
    $studentQuery = "SELECT DISTINCT studentName, studentRoll FROM `attendance` WHERE teacherName = '$staffName' AND subject = '$subject' ORDER BY studentRoll ASC";
    $studentResult = mysqli_query($connection, $studentQuery);

    if ($studentResult) {
        // Loop through each student
        while ($studentRow = mysqli_fetch_assoc($studentResult)) {
            $sheet->setCellValue('A' . $rowIndex, $studentRow['studentName']);
            $sheet->setCellValue('B' . $rowIndex, $studentRow['studentRoll']);

            // Loop through each date to fetch attendance
            mysqli_data_seek($dateResult, 0); // Reset dateResult pointer
            while ($dateRow = mysqli_fetch_assoc($dateResult)) {
                $attendanceDate = $dateRow['attendanceDate'];
                $sheet->setCellValue($colIndex . 1, $attendanceDate);

                $name = $studentRow['studentName'];
                $roll = $studentRow['studentRoll'];
                // Query to fetch attendance for each student and date
                $attendanceQuery = "SELECT attendance FROM `attendance` WHERE teacherName = '$staffName' AND subject = '$subject' AND date = '$attendanceDate' AND studentName = '$name' AND studentRoll = '$roll'";
                $attendanceResult = mysqli_query($connection, $attendanceQuery);
                if ($attendanceResult) {
                    $attendanceData = mysqli_fetch_assoc($attendanceResult);
                    $attend = ($attendanceData !== null && isset($attendanceData['attendance'])) ? $attendanceData['attendance'] : 'A';
                    $sheet->setCellValue($colIndex . $rowIndex, $attend);
                }
                $colIndex++;
            }

            $rowIndex++;
            $colIndex = 'C'; // Reset column index for the next student
        }
    } else {
        echo "<script>alert('Error occurred while fetching student data');</script>";
        echo "<script>window.location.href ='staffDashboard.php';</script>";
        exit(); // Always exit after header redirects
    }
} else {
    echo "<script>alert('Error occurred while fetching date data');</script>";
    echo "<script>window.location.href ='staffDashboard.php';</script>";
    exit(); // Always exit after header redirects
}

// Save Excel file
$writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
$filename = $subject . '.xlsx';

// Download the Excel file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$writer->save('php://output');