<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: userlogin.php");
    exit();
}


if (isset($_POST['upload'])) {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $subject_id = intval($_POST['subject_id']);

    $conn = mysqli_connect("localhost", "root", "", "vidyadb");
    if (!$conn) {
        die("DB connection failed: " . mysqli_connect_error());
    }

    $res = mysqli_query($conn, "SELECT name FROM subjects WHERE id = $subject_id");
    if (!$res || mysqli_num_rows($res) == 0) {
        die("Invalid subject selected.");
    }
    $subject = mysqli_fetch_assoc($res)['name'];

    $baseDir = "vidya_notes/$subject/";
    if (!is_dir($baseDir)) {
        mkdir($baseDir, 0777, true);
    }

    $file = $_FILES['file'];
    $fileName = time() . "_" . basename($file['name']);
    $targetFile = $baseDir . $fileName;

    if (!is_uploaded_file($file['tmp_name'])) {
        die("Upload failed: temporary file not found.");
    }

    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
    
        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO notes (user_id, subject_id, title, description, file_path, status) VALUES (?, ?, ?, ?, ?, 'pending')"
        );
        mysqli_stmt_bind_param($stmt, "iisss", $user_id, $subject_id, $title, $description, $targetFile);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header("Location: upload.php?success=1");
            exit();
        } else {
            unlink($targetFile); 
            die("Database insertion failed: " . mysqli_error($conn));
        }
    } else {
        die("File upload failed. Check folder permissions.");
    }
} else {
    header("Location: upload.php");
    exit();
}
?>
