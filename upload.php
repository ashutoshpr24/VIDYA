<?php
include 'auth.php';
protectPage(['student', 'teacher', 'admin']);
include 'header.php';
?>

<?php
$conn = mysqli_connect("localhost", "root", "", "vidyadb");
if (!$conn) {
    die("DB connection failed: " . mysqli_connect_error());
}

$subjects = mysqli_query($conn, "SELECT * FROM subjects");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIDYA • Upload Notes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/upload.css">
</head>

<body class="bg-gray-50 text-gray-800">
    <!-- FORM -->
    <div class="max-w-4xl mx-auto px-6 py-16">
        <?php
        if (isset($_GET['success'])) {
            echo '<div id="alertBox" class="bg-emerald-100 border border-emerald-500 text-emerald-800 p-4 rounded mb-6">
✅ Notes uploaded successfully and waiting for admin/teacher approval!
</div>';
        } elseif (isset($_GET['error'])) {
            echo '<div id="alertBox" class="bg-red-100 border border-red-500 text-red-800 p-4 rounded mb-6">
❌ Error: ' . htmlspecialchars($_GET['error']) . '
</div>';
        }
        ?>

        <div class="bg-white shadow-lg rounded-xl p-8">
            <h2 class="text-2xl font-bold mb-6">Upload Your Notes</h2>
            <form action="upload_process.php" method="POST" enctype="multipart/form-data" class="space-y-4">
                <div>
                    <label class="block mb-2 font-semibold">Select Branch</label>
                    <select name="subject_id"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-600"
                        required>
                        <option value="">-- Choose Branch --</option>
                        <?php while ($row = mysqli_fetch_assoc($subjects)) { ?>
                            <option value="<?= $row['id'] ?>">
                                <?= htmlspecialchars($row['name']) ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div>
                    <label class="block mb-2 font-semibold">Title</label>
                    <input type="text"
                        name="title"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-600"
                        required>
                </div>
                <div>
                    <label class="block mb-2 font-semibold">Description</label>
                    <textarea name="description"
                        rows="3"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-600"></textarea>
                </div>
                <div>
                    <label class="block mb-2 font-semibold">Upload File</label>
                    <input type="file"
                        name="file"
                        accept=".pdf,.doc,.docx,.ppt,.pptx"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-600"
                        required>
                </div>
                <button type="submit"
                    name="upload"
                    class="w-full bg-emerald-600 text-white font-semibold py-2 rounded hover:bg-emerald-700 transition">
                    Upload Notes
                </button>
            </form>
        </div>
        <?php
        if (isset($_SESSION['role'])) {
            if ($_SESSION['role'] === 'admin') $url = 'admin_dash.php';
            elseif ($_SESSION['role'] === 'teacher') $url = 'teacher_dash.php';
            elseif ($_SESSION['role'] === 'student') $url = null;
            else $url = 'homepage.php';
            if ($url): ?>

                <a href="<?= $url ?>"
                    class="inline-block mt-6 px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-900 transition">
                    Back to Dashboard
                </a>
        <?php endif;
        } ?>
    </div>

    <!-- SCRIPT TO REMOVE SUCCESS PARAMETER -->
    <script>
        if (window.location.search.includes("success") || window.location.search.includes("error")) {
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    </script>
    <?php include 'footer.php'; ?>
</body>

</html>