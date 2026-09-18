<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VIDYA Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/user_login.css">
</head>

<body>
  <div class="container">
    <div class="left">
      <div class="logo">
        <img src="css/images/logo vidya1.1.png" alt="VIDYA Logo">
      </div>
      <h2>Sign into your account</h2>
      <form action="user_logincode.php" method="POST">
        <div class="field">
          <input type="email" name="email" required placeholder=" ">
          <label>Email Address</label>
        </div>
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
    function togglePassword() {
      const p = document.getElementById("password");
      p.type = (p.type === "password") ? "text" : "password";
    }
  </script>
</body>

</html>