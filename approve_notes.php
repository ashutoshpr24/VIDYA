<?php
include 'auth.php';
protectPage(['admin', 'teacher']);
include 'header.php';

$conn = mysqli_connect("localhost", "root", "", "vidyadb");
if (!$conn) {
    die("DB connection failed: " . mysqli_connect_error());
}

$result = mysqli_query($conn, "
    SELECT notes.id, notes.title, notes.description, notes.file_path, users.fullname, subjects.name AS subject 
    FROM notes
    JOIN users ON notes.user_id = users.id
    JOIN subjects ON notes.subject_id = subjects.id
    WHERE notes.status='pending'");

$current = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Approve Notes • VIDYA</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800">


<!-- MAIN LAYOUT -->
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
<!-- PAGE CONTENT -->
<div class="flex-1">

<div class="max-w-7xl mx-auto px-6 py-10">

<h2 class="text-3xl font-bold mb-6">Pending Notes for Approval</h2>

<?php if (isset($_GET['msg'])): ?>
<div class="bg-emerald-100 text-emerald-700 px-4 py-3 rounded-lg mb-6">
<?= htmlspecialchars($_GET['msg']) ?>
</div>
<?php endif; ?>


<div class="bg-white shadow rounded-xl overflow-hidden">

<table class="w-full text-sm">

<thead class="bg-emerald-600 text-white">
<tr>
<th class="text-left px-4 py-3">ID</th>
<th class="text-left px-4 py-3">Title</th>
<th class="text-left px-4 py-3">Description</th>
<th class="text-left px-4 py-3">Uploaded By</th>
<th class="text-left px-4 py-3">Subject</th>
<th class="text-left px-4 py-3">File</th>
<th class="text-left px-4 py-3">Action</th>
</tr>
</thead>

<tbody class="divide-y">

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<tr class="hover:bg-gray-50">

<td class="px-4 py-3"><?= $row['id'] ?></td>

<td class="px-4 py-3"><?= htmlspecialchars($row['title']) ?></td>

<td class="px-4 py-3"><?= htmlspecialchars($row['description']) ?></td>

<td class="px-4 py-3"><?= htmlspecialchars($row['fullname']) ?></td>

<td class="px-4 py-3">
<span class="bg-emerald-100 text-emerald-700 px-2 py-1 rounded text-xs">
<?= htmlspecialchars($row['subject']) ?>
</span>
</td>

<td class="px-4 py-3">
<a href="<?= $row['file_path'] ?>" target="_blank"
class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md text-xs">
View
</a>
</td>

<td class="px-4 py-3 flex gap-2">

<a href="approve_notes_process.php?action=approve&id=<?= $row['id'] ?>"
class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1 rounded-md text-xs">
Approve
</a>

<a href="approve_notes_process.php?action=reject&id=<?= $row['id'] ?>"
class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-xs">
Reject
</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

<?php if (mysqli_num_rows($result) == 0): ?>

<div class="p-6 text-gray-500">
No pending notes right now 🎉
</div>

<?php endif; ?>

</div>


<?php
if (isset($_SESSION['role'])) {

    if ($_SESSION['role'] === 'admin') {
        $url = 'admin_dash.php';
    } elseif ($_SESSION['role'] === 'teacher') {
        $url = 'teacher_dash.php';
    } elseif ($_SESSION['role'] === 'student') {
        $url = null;
    } else {
        $url = 'homepage.php';
    }

    if ($url): ?>

<div class="mt-6">
<a href="<?php echo $url; ?>"
class="inline-block bg-gray-800 text-white px-6 py-2 rounded-lg hover:bg-black">
Back to Dashboard
</a>
</div>

<?php endif; } ?>

</div>
</div>

</div>


<?php include 'footer.php'; ?>

</body>
</html>
