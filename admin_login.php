<?php
session_start();

$error = "";

if(isset($_SESSION['error'])){
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>VIDYA Admin Login</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
min-height:100vh;
background:#f6f9f8;
display:flex;
align-items:center;
justify-content:center;
padding:16px;
}

/* MAIN CARD */

.container{
width:100%;
max-width:900px;
height:560px;
background:#fff;
border-radius:28px;
overflow:hidden;
display:flex;
position:relative;
box-shadow:
0 10px 30px rgba(15,23,42,.05),
0 2px 10px rgba(15,23,42,.03);
}

/* LEFT */

.left{
width:50%;
padding:48px 42px;
display:flex;
flex-direction:column;
justify-content:center;
align-items:flex-start;
height:100%;
position:relative;
top:-17px;
z-index:2;
}

.site-logo{
margin-bottom:18px;
display:flex;
align-items:flex-start;
}


.site-logo img{
height:60px;
width:300px;
display:block;
object-fit:contain;
margin-left:-67px;
}
.tag{
display:inline-block;
padding:7px 14px;
background:#ecfdf5;
color:#059669;
font-size:12px;
font-weight:600;
border-radius:999px;
margin-bottom:22px;
width:max-content;
}

.left h1{
font-size:48px;
line-height:1;
color:#111827;
margin-bottom:18px;
font-weight:700;
letter-spacing:-2px;
}

.left h1 span{
color:#10b981;
}

.left p{
font-size:14px;
line-height:1.8;
color:#64748b;
max-width:320px;
}

/* NOTEBOOK SPIRAL */

.spiral{
position:absolute;
left:50%;
top:0;
transform:translateX(-50%);
width:30px;
height:100%;
display:flex;
flex-direction:column;
justify-content:space-evenly;
align-items:center;
z-index:5;
}

.ring{
width:14px;
height:14px;
border:2px solid #94a3b8;
border-radius:50%;
background:white;
position:relative;
}

.ring::before{
content:"";
position:absolute;
width:2px;
height:42px;
background:#94a3b8;
top:100%;
left:50%;
transform:translateX(-50%);
}

.ring:last-child::before{
display:none;
}

/* RIGHT */

.right{
width:50%;
padding:46px 42px;
display:flex;
align-items:center;
justify-content:center;
background:#f8fffc;
}

.form-box{
width:100%;
max-width:300px;
}

.logo{
display:flex;
align-items:center;
justify-content:center;
margin-bottom:18px;
}

.logo img{
width:90px;
height:90px;
object-fit:contain;
filter:
drop-shadow(0 8px 18px rgba(16,185,129,.18));
}
.form-box h2{
font-size:30px;
color:#111827;
margin-bottom:6px;
}

.subtitle{
font-size:13px;
color:#64748b;
margin-bottom:24px;
}

/* ERROR */
.error{
background:#fef2f2;
border:1px solid #fecaca;
padding:12px 14px;
border-radius:14px;
font-size:13px;
color:#dc2626;
margin-bottom:16px;
animation:errorFade .45s ease;
transform-origin:top;
}

/* ERROR ANIMATION */

@keyframes errorFade{

0%{
opacity:0;
transform:translateY(-10px) scale(.96);
}

100%{
opacity:1;
transform:translateY(0) scale(1);
}

}

/* INPUT */
.input-group{
position:relative;
margin-bottom:18px;
}

.input-group input{
width:100%;
height:54px;
border:1px solid #e2e8f0;
background:white;
border-radius:16px;
padding:18px 16px 15px 16px;
font-size:13px;
outline:none;
transition:.25s;
color:#111827;
}

.input-group label{
position:absolute;
left:16px;
top:17px;
font-size:13px;
color:#94a3b8;
pointer-events:none;
transition:.22s ease;
background:white;
padding:0 4px;
}

.input-group input:focus{
border-color:#10b981;
box-shadow:0 0 0 4px rgba(16,185,129,.08);
padding-bottom: 15px;
}

.input-group input:focus + label,
.input-group input:not(:placeholder-shown) + label{
top:-7px;
left:13px;
font-size:11px;
color:#059669;
font-weight:500;
}
/* BUTTON */

button{
width:100%;
height:52px;
border:none;
border-radius:16px;
background:linear-gradient(135deg,#10b981,#059669);
color:white;
font-size:14px;
font-weight:600;
cursor:pointer;
transition:.25s;
margin-top:4px;
}

button:hover{
transform:translateY(-2px);
box-shadow:0 10px 20px rgba(16,185,129,.16);
}

/* FOOTER */

.footer{
margin-top:18px;
text-align:center;
font-size:12px;
color:#94a3b8;
}

/* RESPONSIVE */

@media(max-width:900px){

.container{
flex-direction:column;
height:auto;
max-width:430px;
}

.left,
.right{
width:100%;
}

.left{
padding:34px 26px;
}

.right{
padding:30px 22px;
}

.left h1{
font-size:38px;
}

.spiral{
width:100%;
height:30px;
left:0;
top:50%;
transform:translateY(-50%);
flex-direction:row;
}

.ring::before{
width:38px;
height:2px;
top:50%;
left:100%;
transform:translateY(-50%);
}

}

@media(max-width:900px){

.container{
flex-direction:column;
height:auto;
max-width:430px;
}

.left,
.right{
width:100%;
}

.left{
padding:34px 26px;
}

.right{
padding:30px 22px;
}

.left h1{
font-size:38px;
}


.spiral{
display:none;
}
.site-logo{
margin-bottom:16px;
}

.site-logo img{
height:50px;
width:310px;
margin-left:-88px;
}

}
</style>

</head>

<body>

<div class="container">

<!-- LEFT -->

<div class="left">

<div class="site-logo">
<img src="css/images/logo vidya1.1.png" alt="VIDYA Logo">
</div>

<h1>
Smart<br>
<span>Admin.</span>
</h1>
<p>
Manage students, uploads and academic resources from one centralized workspace.
</p>

</div>

<!-- SPIRAL -->

<div class="spiral">

<div class="ring"></div>
<div class="ring"></div>
<div class="ring"></div>
<div class="ring"></div>
<div class="ring"></div>
<div class="ring"></div>
<div class="ring"></div>
<div class="ring"></div>

</div>

<!-- RIGHT -->

<div class="right">

<div class="form-box">

<div class="logo">
<img src="css/images/admin.png" alt="Admin">
</div>

<h2 style="text-align: center;">Welcome Back</h2>

<div class="subtitle" style="text-align: center;">
Sign in to continue
</div>

<?php if($error): ?>
<div class="error">
<?php echo htmlspecialchars($error); ?>
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
<button type="submit" name="login">
Login to Dashboard
</button>

</form>

<div class="footer">
VIDYA • Admin Control Panel
</div>

</div>

</div>

</div>

</body>
</html>