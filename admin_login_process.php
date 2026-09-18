<?php
session_start();

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);


    $conn = mysqli_connect("localhost", "root", "", "vidyadb");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM admins WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {

            if (password_verify($password, $row['password'])) {
                $_SESSION['admin_id'] = $row['id'];
                $_SESSION['admin_name'] = $row['fullname'];
                $_SESSION['role']='admin';
                header("Location: admin_dash.php"); 
                exit();
            } else {
                $_SESSION['error'] = "❌ Invalid Password";
            }
        } else {
            $_SESSION['error'] = "❌ No Admin found with this email";
        }

        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);


    header("Location: admin_login.php");
    exit();
} else {
    header("Location: admin_login.php");
    exit();
}
?>
