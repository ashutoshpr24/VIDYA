<?php
$conn = mysqli_connect("localhost", "root", "", "collegenotes");
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

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:Poppins,sans-serif;}

body{
  background:#eef2f7;
  display:flex;
  align-items:center;
  justify-content:center;
  min-height:100vh;
  padding:10px;
}

/* ===== FIXED CONTAINER ===== */
.container{
  display:flex;
  max-width:1050px;
  width:100%;
  height:550px; /* FIXED HEIGHT */
  background:white;
  border-radius:14px;
  overflow:hidden;
  box-shadow:0 25px 50px rgba(0,0,0,0.12);
}

.left{
  flex:0.9;
  padding:30px 40px;
  display:flex;
  flex-direction:column;
  justify-content:center;
  background:white;

  /* 👉 KEY FIX */
  box-shadow: 8px 0 20px -10px rgba(0,0,0,0.12);

  z-index:2;
}



.logo img{width:150px;margin-left:-20px;}

.left h2{text-align:center;margin-bottom:4px;}
.left p{text-align:center;color:#6b7280;margin-bottom:13px;}

input,select{
  width:100%;
  padding:10px;
  border-radius:6px;
  border:1px solid #d1d5db;
  margin-bottom:8px;
  font-size:14px;
}

button{
  width:100%;
  padding:10px;
  background:#059669;
  color:white;
  border:none;
  border-radius:6px;
  margin-top:6px;
}

/* ===== INLINE ROLE FIXED ===== */
.role-row{
  position: relative;
  display: flex;
  gap: 0; /* IMPORTANT: remove gap initially */
}

/* select full width initially */
.role-row select{
  width: 100%;
  transition: width 0.35s ease;
}

/* TAC hidden completely */
#teacher-inline{
  width: 0;
  opacity: 0;
  overflow: hidden;
  transition: all 0.35s ease;
}

/* ACTIVE STATE */
.role-row.active{
  gap: 8px; /* add gap ONLY when active */
}

.role-row.active select{
  width: 45%;
}

.role-row.active #teacher-inline{
  width: 55%;
  opacity: 1;
}

/* ===== RIGHT IMAGE FIX ===== */
.right{
  flex:1.3;
  display:flex;
  align-items:center;   /* ✅ FIX */
  justify-content:center;
  overflow:hidden;
}

.right img{
  width:100%;
  height:100%;
  object-fit:cover;
}

/* ===== ERRORS ===== */
#error-tac{font-size:10px;min-height:14px;text-align: center;}
#error-email{font-size:10px;text-align:center;min-height: 8px; margin-top: -10px;margin-bottom: 5px;}

@media(max-width:768px){
  .container{
    flex-direction:column;
    height:auto;
  }

  .right{
    order:-1;          /* ✅ IMPORTANT */
    height:260px;
    display:flex;
    align-items:center;   /* ✅ center crop like old */
    justify-content:center;
  }
}

/* SAME AS LOGIN PAGE */
.signup{
  margin-top:16px;
  font-size:14px;
  color:#6b7280;
  text-align:center;
}

.signup a{
  color:#059669;
  text-decoration:none;
  font-weight:500;
  display:inline-block;
  transition: transform 0.2s ease, font-weight 0.2s ease;
}

.signup a:hover{
  font-weight:600;
  transform:scale(1.05);
}
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

// toggle inline TAC
roleSelect.addEventListener('change',()=>{
  if(roleSelect.value==='teacher'){
    roleRow.classList.add('active');
  } else {
    roleRow.classList.remove('active');

    // force reset completely
    tacInput.value='';
    errorTac.innerText='';

    // IMPORTANT: force reflow fix (removes leftover width bug)
    teacherInline = document.getElementById('teacher-inline');
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