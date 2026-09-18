<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}

include 'header.php';
$conn = mysqli_connect("localhost", "root", "", "vidyadb");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

/* TOTAL STUDENTS */
$students_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role='student'");
$students_data = mysqli_fetch_assoc($students_query);
$total_students = $students_data['total'];

/* TOTAL TEACHERS */
$teachers_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role='teacher'");
$teachers_data = mysqli_fetch_assoc($teachers_query);
$total_teachers = $teachers_data['total'];

/* TOTAL NOTES */
$notes_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM notes");
$notes_data = mysqli_fetch_assoc($notes_query);
$total_notes = $notes_data['total'];

/* TOTAL DOWNLOADS */
$downloads_query = mysqli_query($conn, "SELECT SUM(download_count) as total FROM notes");
$downloads_data = mysqli_fetch_assoc($downloads_query);
$total_downloads = $downloads_data['total'] ?? 0;

/* NOTES PER MONTH */
$chart_query = mysqli_query($conn,"
SELECT MONTH(uploaded_at) as month, COUNT(*) as total
FROM notes
GROUP BY MONTH(uploaded_at)
");

$months = [];
$notes_count = [];

while($row = mysqli_fetch_assoc($chart_query)){
    $months[] = $row['month'];
    $notes_count[] = $row['total'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard - VIDYA</title>

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body class="bg-gray-50">

<div class="flex">

<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!-- SIDEBAR -->
<div class="w-64 bg-white shadow-md min-h-screen">

<div class="p-6 font-bold text-lg border-b">
Admin Panel
</div>

<nav class="flex flex-col p-4 space-y-2 text-sm">

<a href="admin_dash.php"
class="px-4 py-2 rounded-lg
<?php echo ($current_page == 'admin_dash.php') ? 'bg-emerald-600 text-white' : 'hover:bg-gray-100'; ?>">
Dashboard
</a>

<a href="manage_students.php"
class="px-4 py-2 rounded-lg
<?php echo ($current_page == 'manage_students.php') ? 'bg-emerald-600 text-white' : 'hover:bg-gray-100'; ?>">
Manage Students
</a>

<a href="manage_teachers.php"
class="px-4 py-2 rounded-lg
<?php echo ($current_page == 'manage_teachers.php') ? 'bg-emerald-600 text-white' : 'hover:bg-gray-100'; ?>">
Manage Teachers
</a>

<a href="approve_notes.php"
class="px-4 py-2 rounded-lg
<?php echo ($current_page == 'approve_notes.php') ? 'bg-emerald-600 text-white' : 'hover:bg-gray-100'; ?>">
Approve Notes
</a>

<a href="manage_notes.php"
class="px-4 py-2 rounded-lg
<?php echo ($current_page == 'manage_notes.php') ? 'bg-emerald-600 text-white' : 'hover:bg-gray-100'; ?>">
Manage Notes
</a>

<a href="admin_logout.php"
class="px-4 py-2 rounded-lg hover:bg-red-500 hover:text-white">
Logout
</a>

</nav>
</div>


<!-- MAIN CONTENT -->
<div class="flex-1 p-8">

<h2 class="text-2xl font-bold mb-6">
Hello, <?php echo $_SESSION['admin_name']; ?>
</h2>


<!-- STAT CARDS -->
<div class="grid md:grid-cols-4 gap-6 mb-8">

<div class="bg-white p-6 rounded-xl shadow text-center">
<h3 class="text-3xl font-bold text-emerald-600"><?= $total_students ?></h3>
<p class="text-gray-500 mt-1">Students</p>
</div>

<div class="bg-white p-6 rounded-xl shadow text-center">
<h3 class="text-3xl font-bold text-emerald-600"><?= $total_teachers ?></h3>
<p class="text-gray-500 mt-1">Teachers</p>
</div>

<div class="bg-white p-6 rounded-xl shadow text-center">
<h3 class="text-3xl font-bold text-emerald-600"><?= $total_notes ?></h3>
<p class="text-gray-500 mt-1">Notes Uploaded</p>
</div>

<div class="bg-white p-6 rounded-xl shadow text-center">
<h3 class="text-3xl font-bold text-emerald-600"><?= $total_downloads ?></h3>
<p class="text-gray-500 mt-1">Downloads</p>
</div>

</div>


<!-- CHARTS -->
<div class="grid md:grid-cols-3 gap-6">

<div class="md:col-span-2 bg-white p-6 rounded-xl shadow">
<h4 class="font-semibold mb-4">Notes Uploaded per Month</h4>
<canvas id="notesChart"></canvas>
</div>

<div class="bg-white p-6 rounded-xl shadow">
<h4 class="font-semibold mb-4">Users Breakdown</h4>
<canvas id="usersChart"></canvas>
</div>

</div>

</div>
</div>


<script>

/* NOTES PER MONTH CHART */
const ctx1 = document.getElementById('notesChart');

new Chart(ctx1, {
type: 'line',
data: {
labels: <?= json_encode($months) ?>,
datasets: [{
label: 'Notes Uploaded',
data: <?= json_encode($notes_count) ?>,
borderColor: '#059669',
backgroundColor: 'rgba(5,150,105,0.2)',
fill: true,
tension: 0.3
}]
}
});


/* USERS CHART */
const ctx2 = document.getElementById('usersChart');

new Chart(ctx2, {
type: 'doughnut',
data: {
labels: ['Students','Teachers'],
datasets: [{
data: [<?= $total_students ?>, <?= $total_teachers ?>],
backgroundColor: ['#10b981','#ef4444']
}]
}
});

</script>
<?php include 'footer.php'; ?>

</body>
</html>