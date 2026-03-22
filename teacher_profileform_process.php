<?php
include 'auth.php';
protectPage(['teacher']); 

$conn = mysqli_connect("localhost", "root", "", "collegenotes");
if (!$conn) die("Connection failed: " . mysqli_connect_error());

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = $_SESSION['user_id'];
    $qualification = trim($_POST['qualification']);
    $branch = trim($_POST['branch']);
    $phone = trim($_POST['phone']);
    $experience = !empty($_POST['experience']) ? intval($_POST['experience']) : 0;
    $profile_image = null;

    /* ---------- PROFILE IMAGE UPLOAD ---------- */

    if (!empty($_FILES['profile_image']['name'])) {

        $uploadDir = "uploads/profile_pics/";
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

        $filename = $user_id . "_" . time() . "_" . basename($_FILES['profile_image']['name']);
        $targetFile = $uploadDir . $filename;

        $allowed_types = ['jpg','jpeg','png','gif'];
        $file_ext = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if (in_array($file_ext, $allowed_types)) {
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFile)) {
                $profile_image = $targetFile;
            }
        }
    }

    /* ---------- CHECK IF PROFILE EXISTS ---------- */

    $check = $conn->prepare("SELECT profile_id FROM user_profiles WHERE user_id=?");
    $check->bind_param("i", $user_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {

        // UPDATE

        if ($profile_image) {
            $stmt = $conn->prepare("UPDATE user_profiles 
                SET qualification=?, branch=?, phone=?, experience=?, profile_image=?, updated_at=NOW()
                WHERE user_id=?");
            $stmt->bind_param("ssissi", $qualification, $branch, $phone, $experience, $profile_image, $user_id);
        } else {
            $stmt = $conn->prepare("UPDATE user_profiles 
                SET qualification=?, branch=?, phone=?, experience=?, updated_at=NOW()
                WHERE user_id=?");
            $stmt->bind_param("ssisi", $qualification, $branch, $phone, $experience, $user_id);
        }

    } else {

        // INSERT

        $stmt = $conn->prepare("INSERT INTO user_profiles 
            (user_id, qualification, branch, phone, experience, profile_image) 
            VALUES (?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("isssis", $user_id, $qualification, $branch, $phone, $experience, $profile_image);
    }

    /* ---------- EXECUTE ---------- */

    if ($stmt->execute()) {

        // ✅ SUCCESS → Redirect to profile page with flag
        header("Location: teacher_profile.php?updated=1");
        exit();

    } else {

        // ❌ ERROR → Redirect back to form with flag
        header("Location: teacher_profileform.php?error=1");
        exit();
    }

    $stmt->close();
    $conn->close();

} else {

    // ❌ Direct access without POST
    header("Location: teacher_profileform.php?error=invalid");
    exit();
}
?>