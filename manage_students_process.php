<?php

$servername = "localhost";
$username   = "root";
$password   = "";
$database   = "vidyadb";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function fetchStudents($conn)
{
    $sql = "SELECT * FROM users WHERE role = 'student'";
    return $conn->query($sql);
}

function fetchStudentById($conn, $id)
{
    $stmt = $conn->prepare("SELECT * FROM users WHERE id=? AND role='student'");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

if (isset($_POST['update_id'])) {
    $id = intval($_POST['update_id']);
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("UPDATE users SET fullname=?, email=?, role=? WHERE id=?");
    $stmt->bind_param("sssi", $fullname, $email, $role, $id);
    $stmt->execute();

    header("Location: manage_students.php");
    exit();
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM users WHERE id=? AND role='student'");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: manage_students.php");
    exit();
}
