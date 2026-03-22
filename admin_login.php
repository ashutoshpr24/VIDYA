<?php
session_start();
$error = "";
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Login • VIDYA</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Poppins, sans-serif;
}

body{
min-height:100vh;
display:flex;
align-items:center;
justify-content:center;
background:linear-gradient(135deg,#10b981,#059669,#047857);
padding:20px;
}

/* GLASS CARD */

.card{
width:100%;
max-width:420px;
padding:42px 36px;
border-radius:20px;
background:rgba(255,255,255,0.92);
backdrop-filter:blur(12px);
box-shadow:0 30px 60px rgba(0,0,0,0.25);
text-align:center;
animation:fadeIn .6s ease;
}

@keyframes fadeIn{
from{opacity:0; transform:translateY(20px);}
to{opacity:1; transform:translateY(0);}
}

/* AVATAR */

.avatar{
width:110px;
height:110px;
margin:0 auto 18px;
border-radius:50%;
padding:4px;
background:linear-gradient(135deg,#10b981,#047857);
}

.avatar img{
width:100%;
height:100%;
border-radius:50%;
object-fit:cover;
background:white;
padding:3px;
}

/* TITLE */

.card h2{
font-size:26px;
color:#111827;
margin-bottom:25px;
}

/* ERROR */

.error{
background:#fee2e2;
border-left:4px solid #ef4444;
color:#b91c1c;
padding:12px;
border-radius:8px;
margin-bottom:18px;
font-size:14px;
text-align:left;
}

/* FLOATING INPUT GROUP */

.input-group{
position:relative;
margin-bottom:22px;
}

.input-group input{
width:100%;
padding:14px 12px;
border-radius:10px;
border:1px solid #d1d5db;
background:#f9fafb;
font-size:14px;
transition:.25s;
}

.input-group label{
position:absolute;
left:12px;
top:14px;
color:#6b7280;
font-size:14px;
background:#f9fafb;
padding:0 4px;
transition:.25s;
pointer-events:none;
}

/* FLOAT EFFECT */

.input-group input:focus,
.input-group input:not(:placeholder-shown){
border-color:#059669;
background:white;
box-shadow:0 0 0 3px rgba(16,185,129,0.15);
}

.input-group input:focus + label,
.input-group input:not(:placeholder-shown) + label{
top:-9px;
font-size:12px;
color:#059669;
background:white;
}

/* BUTTON */

button{
width:100%;
padding:14px;
background:#059669;
color:white;
border:none;
border-radius:10px;
font-size:16px;
font-weight:500;
cursor:pointer;
transition:.25s;
}

button:hover{
background:#047857;
transform:translateY(-2px);
box-shadow:0 12px 25px rgba(0,0,0,0.2);
}

/* FOOTER */

.footer{
margin-top:20px;
font-size:13px;
color:#6b7280;
}

/* MOBILE */

@media(max-width:480px){
.card{padding:30px 22px;}
.avatar{width:90px;height:90px;}
.card h2{font-size:22px;}
}

</style>
</head>

<body>

<div class="card">

<div class="avatar">
<img src="css/images/admin1.png" alt="Admin">
</div>

<h2>Admin Login</h2>

<?php if($error): ?>
<div class="error">
❌ <?php echo htmlspecialchars($error); ?>
</div>
<?php endif; ?>

<form action="admin_login_process.php" method="POST">

<div class="input-group">
<input type="email" name="email" required placeholder=" ">
<label>Email Address</label>
</div>

<div class="input-group">
<input type="password" name="password" required placeholder=" ">
<label>Password</label>
</div>

<button type="submit" name="login">Log In to Dashboard</button>

</form>

<div class="footer">
VIDYA • Admin Control Panel
</div>

</div>

</body>
</html>