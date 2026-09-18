<?php
session_start();
include 'auth.php';
protectPage(['student']);

$conn = mysqli_connect("localhost", "root", "", "vidyadb");

$user_id = $_SESSION['user_id'];

// CHECK EXISTING FEEDBACK
$existing = mysqli_query($conn, "SELECT * FROM feedback WHERE user_id='$user_id'");
$hasFeedback = mysqli_num_rows($existing) > 0;

// HANDLE SUBMIT
if(isset($_POST['submit_feedback'])){
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $rating = (int)$_POST['rating'];

    if($rating < 1 || $rating > 5){
        $error = "Invalid rating!";
    } else {
        if($hasFeedback){
            $error = "You already submitted feedback!";
        } else {
            mysqli_query($conn, "
                INSERT INTO feedback (user_id, message, rating) 
                VALUES ('$user_id', '$message', '$rating')
            ");
            header("Location: feedback.php");
        }
    }
}

// FETCH USER FEEDBACK
$myFeedback = mysqli_query($conn, "SELECT * FROM feedback WHERE user_id='$user_id'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Feedback</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

<div class="w-full max-w-xl">

  <!-- ERROR -->
  <?php if(isset($error)) { ?>
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
      <?php echo $error; ?>
    </div>
  <?php } ?>

  <!-- FEEDBACK FORM -->
  <?php if(!$hasFeedback) { ?>

  <div class="bg-white p-6 rounded-xl shadow">
    <h2 class="text-xl font-bold mb-4">Give Feedback</h2>

    <form method="POST">

      <!-- STARS -->
      <div class="mb-4">
        <label class="block mb-2 font-semibold">Rating</label>

        <div id="starContainer" class="text-3xl text-gray-300 cursor-pointer">
          <span data-value="1">★</span>
          <span data-value="2">★</span>
          <span data-value="3">★</span>
          <span data-value="4">★</span>
          <span data-value="5">★</span>
        </div>

        <input type="hidden" name="rating" id="ratingInput" required>
      </div>

      <!-- MESSAGE -->
      <div class="mb-4">
        <textarea name="message" required 
          class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-emerald-400"
          placeholder="Write your experience..."></textarea>
      </div>

      <!-- BUTTON -->
      <button name="submit_feedback" 
        class="bg-emerald-600 text-white px-6 py-2 rounded-lg hover:bg-emerald-700">
        Submit Feedback
      </button>

    </form>
  </div>

  <?php } ?>

  <!-- SHOW USER FEEDBACK -->
  <div class="mt-6 bg-white p-6 rounded-xl shadow">
    <h3 class="font-semibold mb-3">Your Feedback</h3>

    <?php
    if(mysqli_num_rows($myFeedback) > 0){
        while($row = mysqli_fetch_assoc($myFeedback)){
    ?>
        <div class="border-b py-3">
          
          <!-- STARS -->
          <div class="text-yellow-400 text-lg">
            <?php for($i=0; $i<$row['rating']; $i++) echo "★"; ?>
          </div>

          <!-- MESSAGE -->
          <p class="text-gray-700 mt-1">
            “<?php echo $row['message']; ?>”
          </p>

          <p class="text-sm text-gray-400 mt-1">
            <?php echo $row['created_at']; ?>
          </p>

        </div>
    <?php 
        }
    } else {
        echo "<p class='text-gray-500'>No feedback submitted yet.</p>";
    }
    ?>

  </div>

</div>

<!-- STAR SCRIPT -->
<script>
const stars = document.querySelectorAll('#starContainer span');
const ratingInput = document.getElementById('ratingInput');

stars.forEach(star => {
  star.addEventListener('click', () => {
    const value = star.getAttribute('data-value');
    ratingInput.value = value;

    stars.forEach(s => s.classList.remove('text-yellow-400'));
    for(let i = 0; i < value; i++){
      stars[i].classList.add('text-yellow-400');
    }
  });
});
</script>

</body>
</html>