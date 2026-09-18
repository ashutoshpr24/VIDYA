<?php
if (isset($_POST['register'])) {

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role']; 

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $conn = mysqli_connect("localhost", "root", "", "vidyadb");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if ($role === 'teacher') {
        $teacher_code = $_POST['teacher_code'] ?? '';

        $code_sql = "SELECT code FROM teacher_codes LIMIT 1";
        $code_result = mysqli_query($conn, $code_sql);

        if ($code_result && mysqli_num_rows($code_result) > 0) {
            $row = mysqli_fetch_assoc($code_result);
            $correct_code = $row['code'];
        } else {
            echo "<div style='color:red; text-align:center;'>❌ No Teacher Code set in database.</div>";
            exit();
        }

        if ($teacher_code !== $correct_code) {
            echo "<div style='color:red; text-align:center;'>❌ Invalid Teacher Access Code</div>";
            exit();
        }
    }

    $sql = "INSERT INTO users(fullname,email,password,role) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssss", $fullname, $email, $hashedPassword, $role);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: success.php");
            exit();
        } else {
            if (mysqli_errno($conn) == 1062) {
                echo "<div style='color:red; text-align:center; margin-top:20px;'>❌ Email already registered. Please use another.</div>";
            } else {
                echo "<div style='color:red; text-align:center; margin-top:20px;'>❌ Error: " . mysqli_error($conn) . "</div>";
            }
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<div style='color:red; text-align:center; margin-top:20px;'>❌ Failed to prepare statement: " . mysqli_error($conn) . "</div>";
    }

    mysqli_close($conn);
} else {
    header("Location: register.php");
    exit();
}
?>
