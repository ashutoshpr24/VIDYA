<?php
include 'auth.php';
protectPage(['admin']);
include 'manage_teachers_process.php';
include 'header.php';

$teachers = fetchTeachers($conn);

$editTeacher = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $editTeacher = fetchTeacherById($conn, $id);
}

$current = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Teachers</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">


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
                <?php if ($_SESSION['role'] === 'admin'): ?>
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
                <?php if ($_SESSION['role'] === 'teacher'): ?>
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

                <h2 class="text-2xl font-bold text-gray-800 mb-6">
                    Manage Teachers
                </h2>


                <?php if ($editTeacher): ?>

                    <div class="bg-white p-6 rounded-xl shadow mb-8">

                        <h3 class="text-lg font-semibold text-emerald-700 mb-4">
                            Edit Teacher (ID: <?php echo $editTeacher['id']; ?>)
                        </h3>

                        <form method="POST" action="manage_teachers_process.php">

                            <input type="hidden" name="update_id" value="<?php echo $editTeacher['id']; ?>">

                            <div class="grid md:grid-cols-3 gap-4">

                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-1">Full Name</label>
                                    <input type="text" name="fullname"
                                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-emerald-500"
                                        value="<?php echo htmlspecialchars($editTeacher['fullname']); ?>" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                                    <input type="email" name="email"
                                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-emerald-500"
                                        value="<?php echo htmlspecialchars($editTeacher['email']); ?>" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-1">Role</label>

                                    <select name="role"
                                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-emerald-500" required>

                                        <option value="student" <?php if ($editTeacher['role'] == 'student') echo 'selected'; ?>>Student</option>
                                        <option value="teacher" <?php if ($editTeacher['role'] == 'teacher') echo 'selected'; ?>>Teacher</option>

                                    </select>
                                </div>

                            </div>

                            <div class="mt-5 flex gap-3">

                                <button type="submit"
                                    class="bg-emerald-600 text-white px-5 py-2 rounded-lg hover:bg-emerald-700">
                                    Update Teacher
                                </button>

                                <a href="manage_teachers.php"
                                    class="bg-gray-300 px-5 py-2 rounded-lg hover:bg-gray-400">
                                    Cancel
                                </a>

                            </div>

                        </form>
                    </div>

                <?php endif; ?>


                <!-- TEACHERS TABLE -->

                <div class="bg-white shadow rounded-xl overflow-hidden">

                    <table class="w-full text-sm text-left">

                        <thead class="bg-emerald-600 text-white">
                            <tr>
                                <th class="px-4 py-3">ID</th>
                                <th class="px-4 py-3">Full Name</th>
                                <th class="px-4 py-3">Email</th>
                                <th class="px-4 py-3">Role</th>
                                <th class="px-4 py-3">Registered On</th>
                                <th class="px-4 py-3 text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php if ($teachers->num_rows > 0): ?>
                                <?php while ($row = $teachers->fetch_assoc()): ?>

                                    <tr class="border-b hover:bg-gray-50">

                                        <td class="px-4 py-3"><?php echo $row['id']; ?></td>

                                        <td class="px-4 py-3 font-medium">
                                            <?php echo htmlspecialchars($row['fullname']); ?>
                                        </td>

                                        <td class="px-4 py-3">
                                            <?php echo htmlspecialchars($row['email']); ?>
                                        </td>

                                        <td class="px-4 py-3">
                                            <span class="px-2 py-1 text-xs bg-emerald-100 text-emerald-700 rounded">
                                                <?php echo htmlspecialchars($row['role']); ?>
                                            </span>
                                        </td>

                                        <td class="px-4 py-3">
                                            <?php echo $row['created_at']; ?>
                                        </td>

                                        <td class="px-4 py-3 text-center flex justify-center gap-2">

                                            <a href="manage_teachers.php?edit=<?php echo $row['id']; ?>"
                                                class="bg-emerald-500 text-white px-3 py-1 rounded hover:bg-emerald-600">
                                                Edit
                                            </a>

                                            <a href="manage_teachers_process.php?delete=<?php echo $row['id']; ?>"
                                                onclick="return confirm('Are you sure you want to delete this teacher?');"
                                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                                Delete
                                            </a>

                                        </td>

                                    </tr>

                                <?php endwhile; ?>

                            <?php else: ?>

                                <tr>
                                    <td colspan="6" class="text-center py-4 text-gray-500">
                                        No teachers found
                                    </td>
                                </tr>

                            <?php endif; ?>

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

                <?php endif;
                } ?>

            </div>
        </div>

    </div>
<?php include 'footer.php'; ?>

</body>

</html>