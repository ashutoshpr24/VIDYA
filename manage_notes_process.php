<?php

include_once 'auth.php';
protectPage(['admin','teacher']);

$conn = mysqli_connect("localhost", "root", "", "vidyadb");
if (!$conn) {
    die("DB connection failed: " . mysqli_connect_error());
}

/* ===== ACTION HANDLER ======== */
if (isset($_GET['action'], $_GET['id'])) {

    $note_id = intval($_GET['id']);
    $action  = $_GET['action'];

    // fetch note first
    $res = mysqli_query($conn, "SELECT file_path, status FROM notes WHERE id = $note_id");

    if (!$res || mysqli_num_rows($res) === 0) {
        header("Location: manage_notes.php?msg=Note not found");
        exit();
    }

    $note = mysqli_fetch_assoc($res);

    /* ===== RESTORE ===== */
    if ($action === 'restore') {

        if ($note['status'] !== 'rejected') {
            header("Location: manage_notes.php?msg=Only rejected notes can be restored");
            exit();
        }

        mysqli_query($conn, "UPDATE notes SET status='approved' WHERE id=$note_id");

        header("Location: manage_notes.php?msg=Note restored successfully");
        exit();
    }

    /* ===== DELETE PERMANENTLY ===== */
    if ($action === 'delete') {

        // delete file
        if (!empty($note['file_path']) && file_exists($note['file_path'])) {
            unlink($note['file_path']);
        }

        mysqli_query($conn, "DELETE FROM notes WHERE id=$note_id");

        header("Location: manage_notes.php?msg=Note deleted permanently");
        exit();
    }
}

$query = "
    SELECT 
        notes.id AS note_id,
        notes.title,
        notes.file_path,
        notes.status,
        notes.uploaded_at,
        users.fullname,
        subjects.name AS subject
    FROM notes
    LEFT JOIN users ON notes.user_id = users.id
    LEFT JOIN subjects ON notes.subject_id = subjects.id
    ORDER BY notes.uploaded_at DESC
";

$result = mysqli_query($conn, $query);
