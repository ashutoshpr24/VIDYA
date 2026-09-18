<?php
include 'auth.php';
protectPage(['admin','teacher']);
include 'manage_students_process.php';
include 'header.php';

$students = fetchStudents($conn);

$editStudent = null;
if (isset($_GET['edit'])) {
  $id = intval($_GET['edit']);
  $editStudent = fetchStudentById($conn, $id);
}

$current = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Students • VIDYA</title>

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

<h2 class="text-3xl font-bold mb-6">Manage Students</h2>


<?php if ($editStudent): ?>

<div class="bg-white shadow rounded-xl p-6 mb-8">

<h3 class="text-xl font-semibold text-amber-600 mb-4">
Edit Student (ID: <?php echo $editStudent['id']; ?>)
</h3>

<form method="POST" action="manage_students_process.php" class="space-y-4">

<input type="hidden" name="update_id" value="<?php echo $editStudent['id']; ?>">

<div>
<label class="block text-sm font-medium mb-1">Full Name</label>
<input type="text" name="fullname"
class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-emerald-500 outline-none"
value="<?php echo htmlspecialchars($editStudent['fullname']); ?>" required>
</div>

<div>
<label class="block text-sm font-medium mb-1">Email</label>
<input type="email" name="email"
class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-emerald-500 outline-none"
value="<?php echo htmlspecialchars($editStudent['email']); ?>" required>
</div>

<div>
<label class="block text-sm font-medium mb-1">Role</label>
<select name="role"
class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-emerald-500 outline-none">

<option value="student" <?php if ($editStudent['role']=='student') echo 'selected'; ?>>Student</option>
<option value="teacher" <?php if ($editStudent['role']=='teacher') echo 'selected'; ?>>Teacher</option>

</select>
</div>

<div class="flex gap-3 pt-2">

<button type="submit"
class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-lg">
Update
</button>

<a href="manage_students.php"
class="bg-gray-200 hover:bg-gray-300 px-6 py-2 rounded-lg">
Cancel
</a>

</div>

</form>
</div>

<?php endif; ?>


<!-- STUDENT TABLE -->
<div class="bg-white shadow rounded-xl overflow-hidden">

<table class="w-full text-sm">

<thead class="bg-emerald-600 text-white">
<tr>
<th class="text-left px-4 py-3">ID</th>
<th class="text-left px-4 py-3">Full Name</th>
<th class="text-left px-4 py-3">Email</th>
<th class="text-left px-4 py-3">Role</th>
<th class="text-left px-4 py-3">Registered On</th>
<th class="text-left px-4 py-3">Actions</th>
</tr>
</thead>

<tbody class="divide-y">

<?php while ($row = $students->fetch_assoc()): ?>

<tr class="hover:bg-gray-50">

<td class="px-4 py-3"><?php echo $row['id']; ?></td>

<td class="px-4 py-3"><?php echo htmlspecialchars($row['fullname']); ?></td>

<td class="px-4 py-3"><?php echo htmlspecialchars($row['email']); ?></td>

<td class="px-4 py-3">
<span class="px-2 py-1 text-xs rounded
<?php echo $row['role']=='teacher' ? 'bg-blue-100 text-blue-700' : 'bg-emerald-100 text-emerald-700'; ?>">
<?php echo htmlspecialchars($row['role']); ?>
</span>
</td>

<td class="px-4 py-3"><?php echo $row['created_at']; ?></td>

<td class="px-4 py-3 flex gap-2">

<a href="manage_students.php?edit=<?php echo $row['id']; ?>"
class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-1 rounded-md text-xs">
Edit
</a>

<a href="manage_students_process.php?delete=<?php echo $row['id']; ?>"
class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-xs"
onclick="return confirm('Are you sure you want to delete this student?');">
Delete
</a>

</td>

</tr>

<?php endwhile; ?>

</tbody>
</table>

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