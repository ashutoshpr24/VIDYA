<?php
session_start();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = mysqli_connect("localhost", "root", "", "vidyadb");
    if (!$conn) die("Connection failed: " . mysqli_connect_error());

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['fullname'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['role'] = $row['role'];

                if ($row['role'] === 'teacher') {
                    header("Location: teacher_dash.php");
                } else {
                    header("Location: homepage.php");
                }
                exit();
            } else {
                header("Location: userlogin.php?error=invalid_password");
                exit();
            }
        } else {
            header("Location: userlogin.php?error=email_not_registered");
            exit();
        }

        mysqli_stmt_close($stmt);
    } else {
        header("Location: userlogin.php?error=stmt_failed");
        exit();
    }
    mysqli_close($conn);
} else {
    header("Location: userlogin.php");
    exit();
}
