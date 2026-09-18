<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "vidyadb";

$conn = mysqli_connect($host, $user, $password, $dbname);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>

<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<header class="bg-white shadow-sm">
<div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

<!-- Logo -->
<a href="homepage.php" class="flex items-center">
<img src="css/images/logo vidya1.1.png" alt="VIDYA Logo" class="h-12 w-auto">
<span class="ml-2 text-xl font-bold text-emerald-600 hidden md:inline"></span>
</a>

<!-- Nav links -->
<nav class="hidden md:flex gap-8 text-sm">

<a href="homepage.php"
class="relative group px-1 py-1 <?php echo ($current_page=='homepage.php') ? 'text-green-800 font-semibold' : 'text-gray-700 font-medium hover:text-green-800'; ?> transition">
Home
<span class="absolute left-0 -bottom-0.5 <?php echo ($current_page=='homepage.php') ? 'w-full' : 'w-0 group-hover:w-full'; ?> h-0.5 bg-green-800 transition-all"></span>
</a>

<a href="browse_notes.php"
class="relative group px-1 py-1 <?php echo ($current_page=='browse_notes.php') ? 'text-green-800 font-semibold' : 'text-gray-700 font-medium hover:text-green-800'; ?> transition">
Browse
<span class="absolute left-0 -bottom-0.5 <?php echo ($current_page=='browse_notes.php') ? 'w-full' : 'w-0 group-hover:w-full'; ?> h-0.5 bg-green-800 transition-all"></span>
</a>

<a href="upload.php"
class="relative group px-1 py-1 <?php echo ($current_page=='upload.php') ? 'text-green-800 font-semibold' : 'text-gray-700 font-medium hover:text-green-800'; ?> transition">
Upload
<span class="absolute left-0 -bottom-0.5 <?php echo ($current_page=='upload.php') ? 'w-full' : 'w-0 group-hover:w-full'; ?> h-0.5 bg-green-800 transition-all"></span>
</a>

<a href="about.php"
class="relative group px-1 py-1 <?php echo ($current_page=='about.php') ? 'text-green-800 font-semibold' : 'text-gray-700 font-medium hover:text-green-800'; ?> transition">
About
<span class="absolute left-0 -bottom-0.5 <?php echo ($current_page=='about.php') ? 'w-full' : 'w-0 group-hover:w-full'; ?> h-0.5 bg-green-800 transition-all"></span>
</a>

<a href="contact.php"
class="relative group px-1 py-1 <?php echo ($current_page=='contact.php') ? 'text-green-800 font-semibold' : 'text-gray-700 font-medium hover:text-green-800'; ?> transition">
Contact
<span class="absolute left-0 -bottom-0.5 <?php echo ($current_page=='contact.php') ? 'w-full' : 'w-0 group-hover:w-full'; ?> h-0.5 bg-green-800 transition-all"></span>
</a>

</nav>

<!-- User Dropdown -->
<div class="relative inline-block group">

<button class="flex items-center focus:outline-none">
<img src="css/images/user-icon.svg"
alt="User"
class="w-10 h-10 hover:scale-105 transition">
</button>

<div class="absolute right-0 top-full w-44 bg-white border rounded-lg shadow-lg hidden group-hover:block z-50">

<a href="student_dash.php"
class="block px-4 py-2 text-sm hover:bg-emerald-600 hover:text-white transition">
Student Dashboard
</a>

<a href="teacher_dash.php"
class="block px-4 py-2 text-sm hover:bg-emerald-600 hover:text-white transition">
Teacher Dashboard
</a>

<a href="admin_dash.php"
class="block px-4 py-2 text-sm hover:bg-emerald-600 hover:text-white transition">
Admin Dashboard
</a>

</div>

</div>

</div>
</header>