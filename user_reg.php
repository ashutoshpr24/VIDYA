<?php
$conn = mysqli_connect("localhost", "root", "", "vidyadb");
if (!$conn) die("Connection failed: " . mysqli_connect_error());

// AJAX TAC
if (isset($_POST['ajax_check_tac'])) {
    $code = $_POST['teacher_code'] ?? '';
    $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT code FROM teacher_codes LIMIT 1"));
    $correct = $row['code'] ?? '';

    if ($code === '') {
        echo json_encode(['status'=>'empty','message'=>'❌ Teacher Access Code cannot be empty']);
    } elseif ($code !== $correct) {
        echo json_encode(['status'=>'wrong','message'=>'❌ Invalid Teacher Access Code']);
    } else {
        echo json_encode(['status'=>'ok','message'=>'✅ TAC is correct']);
    }
    exit();
}

// AJAX Email
if (isset($_POST['ajax_check_email'])) {
    $email = $_POST['email'] ?? '';
    if ($email === '') {
        echo json_encode(['status'=>'empty','message'=>'❌ Email cannot be empty']);
    } else {
        $stmt = mysqli_prepare($conn,"SELECT * FROM users WHERE email=?");
        mysqli_stmt_bind_param($stmt,'s',$email);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if(mysqli_num_rows($res)>0){
            echo json_encode(['status'=>'wrong','message'=>'❌ Email already registered.']);
        } else {
            echo json_encode(['status'=>'ok','message'=>'']);
        }
    }
    exit();
}

// Register
if (isset($_POST['register'])) {
    $fullname=$_POST['fullname'];
    $email=$_POST['email'];
    $password=password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role=$_POST['role'];

    if ($role==='teacher') {
        $tac=$_POST['teacher_code'] ?? '';
        $row=mysqli_fetch_assoc(mysqli_query($conn,"SELECT code FROM teacher_codes LIMIT 1"));
        if($tac !== ($row['code'] ?? '')){
            $error_msg="❌ Invalid Teacher Access Code";
        }
    }

    if (!isset($error_msg)) {
        $stmt=mysqli_prepare($conn,"INSERT INTO users(fullname,email,password,role) VALUES (?,?,?,?)");
        mysqli_stmt_bind_param($stmt,"ssss",$fullname,$email,$password,$role);
        if(mysqli_stmt_execute($stmt)){
            header("Location: success.php"); exit();
        } else {
            $error_msg = mysqli_errno($conn)==1062 
                ? "❌ Email already registered." 
                : "❌ Error: ".mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>VIDYA Register</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/user_reg.css">
<style>
</style>
</head>

<body>

<div class="container">
<div class="left">

<div class="logo">
<img src="css/images/logo vidya1.1.png">
</div>

<h2>Create your account</h2>
<p>Please fill your personal details</p>

<div id="error-email"><?php if(isset($error_msg)) echo $error_msg; ?></div>

<form id="regForm" method="POST">

<input type="text" name="fullname" placeholder="Full Name" required>
<input type="email" name="email" placeholder="Email Address" required>
<input type="password" name="password" placeholder="Create Password" required>

<div class="role-row">
    <select name="role" id="roleSelect" required>
        <option value="">Register As</option>
        <option value="student">Student</option>
        <option value="teacher">Teacher</option>
    </select>

    <div id="teacher-inline">
        <input type="password" name="teacher_code" placeholder="TAC">
    </div>
</div>

<div id="error-tac"></div>

<button type="submit" name="register">Register</button>
<div class="signup">
    Already have an account? <a href="userlogin.php">Log In</a>
</div>


</form>
</div>

<div class="right">
<img src="css/images/4444.png">
</div>
</div>

<script>
const roleSelect=document.getElementById('roleSelect');
const roleRow=document.querySelector('.role-row');
const tacInput=document.querySelector('input[name="teacher_code"]');
const errorTac=document.getElementById('error-tac');
const emailInput=document.querySelector('input[name="email"]');
const errorEmail=document.getElementById('error-email');
const regForm=document.getElementById('regForm');

// toggle TAC
roleSelect.addEventListener('change', () => {
  const teacherInline = document.getElementById('teacher-inline');

  if (roleSelect.value === 'teacher') {
    roleRow.classList.add('active');
    teacherInline.style.width = "";
  } else {
    roleRow.classList.remove('active');
    tacInput.value = '';
    errorTac.innerText = '';
    teacherInline.style.width = "0px";
  }
});

// TAC validation
let d1;
tacInput.addEventListener('input',()=>{
 clearTimeout(d1);
 d1=setTimeout(()=>{
  const fd=new FormData();
  fd.append('ajax_check_tac',true);
  fd.append('teacher_code',tacInput.value);
  fetch('',{method:'POST',body:fd})
  .then(r=>r.json())
  .then(d=>{ errorTac.innerText=d.message; });
 },300);
});

// Email validation
let d2;
emailInput.addEventListener('input',()=>{
 clearTimeout(d2);
 d2=setTimeout(()=>{
  const fd=new FormData();
  fd.append('ajax_check_email',true);
  fd.append('email',emailInput.value);
  fetch('',{method:'POST',body:fd})
  .then(r=>r.json())
  .then(d=>{ errorEmail.innerText=d.message; });
 },300);
});

// Prevent form submission if TAC invalid
regForm.addEventListener('submit',(e)=>{
    if(roleSelect.value==='teacher' && (tacInput.value.trim()==='' || errorTac.innerText.includes('Invalid'))){
        e.preventDefault();
        tacInput.focus();
    }
    if(emailInput.value.trim()==='' || errorEmail.innerText.includes('already')){
        e.preventDefault();
        emailInput.focus();
    }
});
</script>

</body>
</html>