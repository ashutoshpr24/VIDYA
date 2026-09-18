<?php
include 'auth.php';
protectPage(['student', 'teacher', 'admin']);

$conn = mysqli_connect("localhost", "root", "", "vidyadb");
if (!$conn) {
    echo json_encode([]);
    exit();
}

$subject_id = isset($_GET['subject_id']) ? intval($_GET['subject_id']) : 0;
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

$sql = "
    SELECT 
        notes.id AS note_id,
        notes.title,
        notes.description,
        notes.file_path,
        notes.download_count,
        users.fullname,
        subjects.name AS subject
    FROM notes
    LEFT JOIN users ON notes.user_id = users.id
    LEFT JOIN subjects ON notes.subject_id = subjects.id
    WHERE notes.status = 'approved'
";

if ($subject_id > 0) {
    $sql .= " AND notes.subject_id = $subject_id";
}

if ($search !== '') {
    $sql .= " AND (notes.title LIKE '%$search%' OR notes.description LIKE '%$search%')";
}

$sql .= " ORDER BY notes.uploaded_at DESC";

$res = mysqli_query($conn, $sql);
$notes = [];

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $row['fullname'] = $row['fullname'] ?? 'Deleted User';
        $row['subject']  = $row['subject']  ?? 'Unknown';
        $notes[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($notes);
