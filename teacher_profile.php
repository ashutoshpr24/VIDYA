<?php
include 'auth.php';
include 'header.php';
protectPage(['teacher']); 

$conn = mysqli_connect("localhost", "root", "", "vidyadb");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

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
<title>Teacher Profile • VIDYA</title>
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

<a href="teacher_profile.php"
class="px-4 py-2 rounded-lg
<?php echo ($current_page == 'teacher_profile.php') ? 'bg-emerald-600 text-white' : 'hover:bg-gray-100'; ?>">
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

<h2 class="text-3xl font-bold mb-6">My Profile</h2>

<!--SUCCESS MESSAGE -->
<?php if(isset($_GET['updated'])): ?>
<div id="flash-message"
class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow flex justify-between items-center">
    <span>✅ Profile updated successfully!</span>
    <button onclick="this.parentElement.remove()" class="font-bold">✖</button>
</div>
<?php endif; ?>

<!-- ERROR MESSAGE -->
<?php if(isset($_GET['error'])): ?>
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

<!-- PROFILE IMAGE -->
<div class="flex flex-col items-center">

<div class="p-1 rounded-full bg-gradient-to-r from-emerald-500 to-green-600">

<?php if($profile && $profile['profile_image'] && file_exists($profile['profile_image'])): ?>
<img src="<?php echo htmlspecialchars($profile['profile_image']); ?>" 
class="w-32 h-32 rounded-full object-cover bg-white p-1">
<?php else: ?>
<img src="default_avatar.png" 
class="w-32 h-32 rounded-full object-cover bg-white p-1">
<?php endif; ?>

</div>

</div>

<!-- PROFILE INFO -->
<div class="flex-1">

<h3 class="text-3xl font-bold text-emerald-600 mb-2">
<?php echo htmlspecialchars($_SESSION['username']); ?>
</h3>

<p class="text-gray-500 mb-6">
<?php echo htmlspecialchars($_SESSION['email']); ?>
</p>

<div class="grid grid-cols-2 gap-4 text-sm">

<?php if($profile && $profile['qualification']): ?>
<div class="bg-gray-50 p-3 rounded-lg">
<span class="font-semibold text-gray-600">Qualification</span>
<p class="text-gray-800"><?php echo htmlspecialchars($profile['qualification']); ?></p>
</div>
<?php endif; ?>

<?php if($profile && $profile['branch']): ?>
<div class="bg-gray-50 p-3 rounded-lg">
<span class="font-semibold text-gray-600">Department</span>
<p class="text-gray-800"><?php echo htmlspecialchars($profile['branch']); ?></p>
</div>
<?php endif; ?>

<?php if($profile && $profile['experience']): ?>
<div class="bg-gray-50 p-3 rounded-lg">
<span class="font-semibold text-gray-600">Experience</span>
<p class="text-gray-800"><?php echo htmlspecialchars($profile['experience']); ?> years</p>
</div>
<?php endif; ?>

<?php if($profile && $profile['phone']): ?>
<div class="bg-gray-50 p-3 rounded-lg">
<span class="font-semibold text-gray-600">Contact</span>
<p class="text-gray-800"><?php echo htmlspecialchars($profile['phone']); ?></p>
</div>
<?php endif; ?>

</div>

<?php if(!$profile): ?>

<p class="text-gray-500 italic mt-6">
Profile not yet created. Please fill your profile information.
</p>

<a href="teacher_profileform.php"
class="inline-block mt-4 bg-amber-500 hover:bg-amber-600 text-white px-6 py-2 rounded-lg">
Create Profile
</a>

<?php endif; ?>

<div class="mt-6 flex gap-4">

<a href="teacher_profileform.php"
class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-lg shadow transition">
Update Profile
</a>

</div>

</div>

</div>

</div>

<div class="mt-6">
<a href="teacher_dash.php"
class="inline-block bg-gray-800 hover:bg-black text-white px-6 py-2 rounded-lg">
Back to Dashboard
</a>
</div>

</div>

</div>

</div>

<?php include 'footer.php'; ?>

<!-- REMOVE QUERY PARAM AFTER LOAD -->
<script>
if (window.location.search.includes('updated') || window.location.search.includes('error')) {
    window.history.replaceState({}, document.title, window.location.pathname);
}
</script>

</body>
</html>