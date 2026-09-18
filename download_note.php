<?php
include 'auth.php';
protectPage(['student', 'teacher', 'admin']);

$conn = mysqli_connect("localhost", "root", "", "vidyadb");
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$note_id = intval($_GET['id']);

$res = mysqli_query($conn, "SELECT file_path FROM notes WHERE id=$note_id AND status='approved'");
if (!$res || mysqli_num_rows($res) === 0) {
    die("Invalid note or note not approved.");
}

$row = mysqli_fetch_assoc($res);
$file = $row['file_path'];

if (!file_exists($file)) {
    die("File not found on server.");
}

mysqli_query($conn, "UPDATE notes SET download_count = download_count + 1 WHERE id=$note_id");

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($file) . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($file));
readfile($file);
exit();
