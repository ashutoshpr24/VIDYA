<?php
include 'auth.php';
protectPage(['teacher']);
include 'header.php';

$conn = mysqli_connect("localhost", "root", "", "vidyadb");
if (!$conn) die("Connection failed: " . mysqli_connect_error());

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM user_profiles WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$profile = $result->fetch_assoc();
$stmt->close();
$conn->close();

$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Teacher Profile Form • VIDYA</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800">

  <div class="flex">

    <!-- SIDEBAR -->
    <div class="w-64 bg-white shadow-md min-h-screen">

      <div class="p-6 font-bold text-lg border-b">
        Teacher Panel
      </div>

      <nav class="flex flex-col p-4 space-y-2 text-sm">

        <a href="teacher_dash.php"
          class="px-4 py-2 rounded-lg
<?php echo ($current_page == 'teacher_dash.php') ? 'bg-emerald-600 text-white' : 'hover:bg-gray-100'; ?>">
          Dashboard
        </a>

        <a href="manage_students.php"
          class="px-4 py-2 rounded-lg
<?php echo ($current_page == 'manage_students.php') ? 'bg-emerald-600 text-white' : 'hover:bg-gray-100'; ?>">
          Manage Students
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

        <!-- PROFILE (active for both pages) -->
        <a href="teacher_profile.php"
          class="px-4 py-2 rounded-lg
<?php
$profile_pages = ['teacher_profile.php', 'teacher_profileform.php'];
echo in_array($current_page, $profile_pages)
  ? 'bg-emerald-600 text-white'
  : 'hover:bg-gray-100';
?>">
          Profile
        </a>

        <a href="logout.php"
          class="px-4 py-2 rounded-lg hover:bg-red-500 hover:text-white">
          Logout
        </a>

      </nav>
    </div>

    <!-- PAGE CONTENT -->
    <div class="flex-1">

      <div class="max-w-5xl mx-auto px-6 py-10">

        <h2 class="text-3xl font-bold mb-6">Update Profile</h2>

        <!-- ❌ ERROR MESSAGE -->
        <?php if (isset($_GET['error'])): ?>
          <div id="flash-message"
            class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow flex justify-between items-center">
            <span>❌ Failed to update profile. Please try again.</span>
            <button onclick="this.parentElement.remove()" class="font-bold">✖</button>
          </div>
        <?php endif; ?>

        <!-- PROFILE CARD -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">

          <div class="h-3 bg-gradient-to-r from-emerald-500 via-green-500 to-emerald-700"></div>

          <div class="p-10 flex gap-10 items-start">

            <!-- LEFT: PROFILE IMAGE -->
            <div class="flex flex-col items-center">

              <div class="p-1 rounded-full bg-gradient-to-r from-emerald-500 to-green-600">

                <?php if (!empty($profile['profile_image']) && file_exists($profile['profile_image'])): ?>
                  <img src="<?php echo htmlspecialchars($profile['profile_image']); ?>"
                    class="w-32 h-32 rounded-full object-cover bg-white p-1">
                <?php else: ?>
                  <img src="default_avatar.png"
                    class="w-32 h-32 rounded-full object-cover bg-white p-1">
                <?php endif; ?>

              </div>

              <input type="file" name="profile_image" form="profileForm"
                accept="image/*"
                class="mt-4 text-sm">

              <div id="preview" class="mt-3"></div>

            </div>

            <!-- RIGHT: FORM -->
            <div class="flex-1">

              <form id="profileForm"
                method="POST"
                action="teacher_profileform_process.php"
                enctype="multipart/form-data"
                class="space-y-6">

                <div class="grid grid-cols-2 gap-4 text-sm">

                  <div>
                    <label class="font-semibold text-gray-600">Full Name</label>
                    <input type="text" name="fullname"
                      value="<?php echo htmlspecialchars($_SESSION['username']); ?>"
                      readonly
                      class="w-full bg-gray-100 p-3 rounded-lg mt-1">
                  </div>

                  <div>
                    <label class="font-semibold text-gray-600">Email</label>
                    <input type="email" name="email"
                      value="<?php echo htmlspecialchars($_SESSION['email']); ?>"
                      readonly
                      class="w-full bg-gray-100 p-3 rounded-lg mt-1">
                  </div>

                  <div>
                    <label class="font-semibold text-gray-600">Qualification</label>
                    <input type="text" name="qualification" required
                      value="<?php echo $profile['qualification'] ?? ''; ?>"
                      class="w-full bg-gray-50 p-3 rounded-lg mt-1 focus:ring-2 focus:ring-emerald-600">
                  </div>

                  <div>
                    <label class="font-semibold text-gray-600">Department</label>
                    <input type="text" name="branch" required
                      value="<?php echo $profile['branch'] ?? ''; ?>"
                      class="w-full bg-gray-50 p-3 rounded-lg mt-1 focus:ring-2 focus:ring-emerald-600">
                  </div>

                  <div>
                    <label class="font-semibold text-gray-600">Experience (years)</label>
                    <input type="number" name="experience" min="0" required
                      value="<?php echo $profile['experience'] ?? ''; ?>"
                      class="w-full bg-gray-50 p-3 rounded-lg mt-1 focus:ring-2 focus:ring-emerald-600">
                  </div>

                  <div>
                    <label class="font-semibold text-gray-600">Contact</label>
                    <input type="text" name="phone" required
                      value="<?php echo $profile['phone'] ?? ''; ?>"
                      class="w-full bg-gray-50 p-3 rounded-lg mt-1 focus:ring-2 focus:ring-emerald-600">
                  </div>

                </div>

                <div class="mt-6 flex gap-4">

                  <button type="submit"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-lg shadow transition">
                    Save Profile
                  </button>

                  <a href="teacher_profile.php"
                    class="bg-gray-800 hover:bg-black text-white px-6 py-2 rounded-lg">
                    Cancel
                  </a>

                </div>

              </form>

            </div>

          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- FOOTER -->
  <footer class="bg-gray-900 text-gray-400 py-10 text-center mt-10">
    © 2026 VIDYA. All rights reserved by Ashutosh Prajapati.
  </footer>

  <!-- IMAGE PREVIEW -->
  <script>
    const input = document.querySelector('input[name="profile_image"]');
    const previewContainer = document.getElementById('preview');

    input.addEventListener('change', function() {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          previewContainer.innerHTML =
            `<img src="${e.target.result}" class="w-32 h-32 rounded-full object-cover border-2 border-emerald-600">`;
        }
        reader.readAsDataURL(file);
      }
    });
  </script>

  <!-- 🔥 REMOVE ERROR PARAM AFTER LOAD -->
  <script>
    if (window.location.search.includes('error')) {
      window.history.replaceState({}, document.title, window.location.pathname);
    }
  </script>

</body>

</html>