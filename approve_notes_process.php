<?php
include 'auth.php';
protectPage(['admin', 'teacher']);

$conn = mysqli_connect("localhost", "root", "", "vidyadb");
if (!$conn) {
    die("DB connection failed: " . mysqli_connect_error());
}

if (isset($_GET['action'], $_GET['id'])) {

    $note_id = (int) $_GET['id'];
    $action  = $_GET['action'];

    if ($action === 'approve') {

        mysqli_query($conn,
            "UPDATE notes SET status='approved' WHERE id=$note_id"
        );
        $msg = "Note approved successfully";

    } elseif ($action === 'reject') {

        mysqli_query($conn,
            "UPDATE notes SET status='rejected' WHERE id=$note_id"
        );
        $msg = "Note rejected successfully";

    } else {
        $msg = "Invalid action";
    }

    header("Location: approve_notes.php?msg=" . urlencode($msg));
    exit;

} else {
    header("Location: approve_notes.php?msg=" . urlencode("Invalid request"));
    exit;
}
