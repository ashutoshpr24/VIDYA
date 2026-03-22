<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>VIDYA Login</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Poppins, sans-serif;
}

body{
background:#eef2f7;
display:flex;
align-items:center;   /* SAME AS ORIGINAL */
justify-content:center;
min-height:100vh;
padding:10px;         /* TOP MARGIN KEPT SAME */
}

/* CONTAINER */

.container{
display:flex;
max-width:1050px;
width:100%;
min-height:580px;
background:white;
border-radius:14px;
overflow:hidden;
box-shadow:0 25px 50px rgba(0,0,0,0.12);
}

/* LEFT SIDE */

.left{
flex:0.9;
padding:20px 45px 50px 45px;
display:flex;
flex-direction:column;
justify-content:center;
background:white;
box-shadow:6px 0 18px rgba(0,0,0,0.06);
z-index:2;
}

/* LOGO */

.logo{ margin-bottom:20px; }

.logo img{
width:150px;
margin-left:-20px;
}

/* HEADING */

.left h2{
font-size:26px;
margin-bottom:20px;
color:#111827;
text-align:center;
}

/* ===== FLOATING FIELD ===== */

.field{
position:relative;
margin-bottom:14px;
}

.field input{
width:100%;
padding:12px 10px;
border-radius:7px;
border:1px solid #d1d5db;
font-size:14px;
background:white;
transition:.25s;
}

/* LABEL */

.field label{
position:absolute;
left:10px;
top:12px;
font-size:14px;
color:#6b7280;
background:white;
padding:0 4px;
pointer-events:none;
transition:.25s;
}

/* FOCUS */

.field input:focus{
outline:none;
border-color:#059669;
box-shadow:0 0 0 3px rgba(16,185,129,0.15);
}

/* FLOAT EFFECT */

.field input:focus + label,
.field input:not(:placeholder-shown) + label{
top:-8px;
font-size:11px;
color:#059669;
}

/* PASSWORD WRAPPER */

.password-wrapper{
position:relative;
}

.password-wrapper input{
padding-right:38px;
}

.eye{
position:absolute;
right:10px;
top:50%;
transform:translateY(-50%);
cursor:pointer;
font-size:16px;
color:#6b7280;
user-select:none;
}

/* BUTTON */

button{
width:100%;
padding:12px;
background:#059669;
color:white;
border:none;
border-radius:7px;
font-size:15px;
cursor:pointer;
transition:.25s;
}

button:hover{
background:#047857;
transform:translateY(-2px);
box-shadow:0 8px 18px rgba(0,0,0,0.12);
}

/* SIGNUP */

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
}

.signup a:hover{
font-weight:600;
transform:scale(1.05);
}

/* RIGHT SIDE */

.right{
flex:1.3;
display:flex;
align-items:center;
justify-content:center;
overflow:hidden;
}

.right img{
width:100%;
height:100%;
object-fit:cover;
}

/* MOBILE */

@media(max-width:768px){

  body{
    padding:10px;              /* ✅ remove outer gap */
    align-items:center; /* ✅ stop vertical centering */
  }

  .container{
    flex-direction:column;
    min-height:auto;
    border-radius:0;        /* optional: edge-to-edge clean look */
  }

  .right{
    order:-1;
    height:260px;
  }

  .left{
    padding:25px 18px;      /* slightly tighter */
    box-shadow:none;
  }

}
</style>
</head>

<body>

<div class="container">

<div class="left">

<div class="logo">
<img src="css/images/logo vidya1.1.png" alt="VIDYA Logo">
</div>

<h2>Sign into your account</h2>

<form action="user_logincode.php" method="POST">

<!-- EMAIL -->

<div class="field">
<input type="email" name="email" required placeholder=" ">
<label>Email Address</label>
</div>

<!-- PASSWORD -->

<div class="field password-wrapper">
<input type="password" name="password" id="password" required placeholder=" ">
<label>Password</label>
<span class="eye" onclick="togglePassword()">👁</span>
</div>

<button type="submit" name="login">Log In</button>

<div class="signup">
Don't have an account? <a href="user_reg.php">Sign Up</a>
</div>

</form>

</div>

<div class="right">
<img src="css/images/4444.png" alt="Students studying">
</div>

</div>

<script>

function togglePassword(){
  const p = document.getElementById("password");
  p.type = (p.type === "password") ? "text" : "password";
}

</script>

</body>
</html>