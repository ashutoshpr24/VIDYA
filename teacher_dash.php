<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header("Location: userlogin.php");
    exit();
}
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Teacher Dashboard | VIDYA</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-50">


<div class="flex">

<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!-- SIDEBAR -->
<div class="w-64 bg-white shadow-md min-h-screen">

<div class="p-6 font-bold text-lg border-b">
<?php echo ($_SESSION['role'] === 'admin') ? 'Admin Panel' : 'Teacher Panel'; ?>
</div>

<nav class="flex flex-col p-4 space-y-2 text-sm">

<!-- Dashboard -->
<a href="<?php echo ($_SESSION['role'] === 'admin') ? 'admin_dash.php' : 'teacher_dash.php'; ?>"
class="px-4 py-2 rounded-lg
<?php echo ($current_page == 'admin_dash.php' || $current_page == 'teacher_dash.php') ? 'bg-emerald-600 text-white' : 'hover:bg-gray-100'; ?>">
Dashboard
</a>

<!-- Manage Students -->
<a href="manage_students.php"
class="px-4 py-2 rounded-lg
<?php echo ($current_page == 'manage_students.php') ? 'bg-emerald-600 text-white' : 'hover:bg-gray-100'; ?>">
Manage Students
</a>

<!-- Manage Teachers (ADMIN ONLY) -->
<?php if($_SESSION['role'] === 'admin'): ?>
<a href="manage_teachers.php"
class="px-4 py-2 rounded-lg
<?php echo ($current_page == 'manage_teachers.php') ? 'bg-emerald-600 text-white' : 'hover:bg-gray-100'; ?>">
Manage Teachers
</a>
<?php endif; ?>

<!-- Approve Notes -->
<a href="approve_notes.php"
class="px-4 py-2 rounded-lg
<?php echo ($current_page == 'approve_notes.php') ? 'bg-emerald-600 text-white' : 'hover:bg-gray-100'; ?>">
Approve Notes
</a>

<!-- Manage Notes -->
<a href="manage_notes.php"
class="px-4 py-2 rounded-lg
<?php echo ($current_page == 'manage_notes.php') ? 'bg-emerald-600 text-white' : 'hover:bg-gray-100'; ?>">
Manage Notes
</a>

<!-- Teacher Profile -->
<?php if($_SESSION['role'] === 'teacher'): ?>
<a href="teacher_profile.php"
class="px-4 py-2 rounded-lg
<?php echo ($current_page == 'teacher_profile.php') ? 'bg-emerald-600 text-white' : 'hover:bg-gray-100'; ?>">
Profile
</a>
<?php endif; ?>

<!-- Logout -->
<a href="<?php echo ($_SESSION['role'] === 'admin') ? 'admin_logout.php' : 'logout.php'; ?>"
class="px-4 py-2 rounded-lg hover:bg-red-500 hover:text-white">
Logout
</a>

</nav>
</div>

<!-- MAIN CONTENT -->
<div class="flex-1 p-8">

<h2 class="text-2xl font-bold mb-6">
Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> 👋
</h2>


<!-- DASHBOARD STATS -->
<div class="grid md:grid-cols-4 gap-6">

<div class="bg-white p-6 rounded-xl shadow text-center">
<h3 class="text-3xl font-bold text-emerald-600">12</h3>
<p class="text-gray-500 mt-1">Total Notes Uploaded</p>
</div>

<div class="bg-white p-6 rounded-xl shadow text-center">
<h3 class="text-3xl font-bold text-emerald-600">145</h3>
<p class="text-gray-500 mt-1">Total Downloads</p>
</div>

<div class="bg-white p-6 rounded-xl shadow text-center">
<h3 class="text-3xl font-bold text-emerald-600">3</h3>
<p class="text-gray-500 mt-1">Pending Approvals</p>
</div>

<div class="bg-white p-6 rounded-xl shadow text-center">
<h3 class="text-3xl font-bold text-emerald-600">4.8 ⭐</h3>
<p class="text-gray-500 mt-1">Average Rating</p>
</div>

</div>

</div>
</div>
<?php include 'footer.php'; ?>

</body>
</html>