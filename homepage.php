<?php
include 'auth.php';
protectPage(['student', 'teacher', 'admin']);
include 'header.php';


$conn = mysqli_connect("localhost", "root", "", "vidyadb");

$feedbacks = mysqli_query($conn, "
  SELECT u.fullname, f.message, f.rating
  FROM feedback f
  JOIN users u ON f.user_id = u.id
  WHERE f.is_featured = 1
  ORDER BY RAND()
  LIMIT 5
");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>VIDYA • Online Learning</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .hero-animate {
      opacity: 0;
      transform: scale(0.6);
      transition: all 1s ease;
    }

    .hero-animate.show {
      opacity: 1;
      transform: scale(1);
    }
  </style>
</head>

<body class="bg-gray-50 text-gray-800">

  <!-- HERO -->
  <!-- DESKTOP HERO -->
  <section id="hero-desktop" class="hidden relative w-full bg-gray-50 min-h-[70vh]">
    <div class="absolute inset-0">
      <img src="css/images/herosection1.1.jpg" class="w-full h-full object-cover" alt="Hero Background">
      <!-- <div class="absolute inset-0 bg-gradient-to-r from-gray-50/50 via-gray-50/20 to-transparent"></div>  -->
    </div>

    <div class="relative max-w-7xl mx-auto px-6 py-32 md:py-40 grid md:grid-cols-2 gap-10 items-center z-10">
      <div class="hero-animate">
        <h2 class="text-4xl font-bold leading-tight text-gray-900">
          Online Education <br>
          <span class="text-green-800">Feels Like Real Classroom</span>
        </h2>

        <p class="text-gray-700 mt-4 max-w-md">
          Learn from trusted teachers, download notes, and grow smarter with VIDYA.
        </p>

        <button class="mt-6 px-6 py-3 bg-green-800 text-white rounded-xl">
          Get Started
        </button>
      </div>
    </div>
  </section>

  <!-- MOBILE HERO (shows even in desktop mode) -->
  <section id="hero-mobile" class="hidden relative w-full bg-gray-50">
    <div class="w-full">
      <img src="css/images/herosection.jpg" class="w-full h-auto object-contain" alt="Hero Background">
    </div>

    <div class="absolute inset-0 flex items-center">
      <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-10 items-center w-full">
        <div class="hero-animate">
          <h2 class="text-4xl font-bold leading-tight text-gray-900">
            Online Education <br>
            <span class="text-green-800">Feels Like Real Classroom</span>
          </h2>

          <p class="text-gray-700 mt-4 max-w-md">
            Learn from trusted teachers, download notes, and grow smarter with VIDYA.
          </p>

          <button class="mt-6 px-6 py-3 bg-green-800 text-white rounded-xl">
            Get Started
          </button>
        </div>
      </div>
    </div>
  </section>

  <!-- JS to detect device and viewport -->
  <script>
    function showHeroByDevice() {
      const desktopHero = document.getElementById('hero-desktop');
      const mobileHero = document.getElementById('hero-mobile');

      // Detect real mobile devices
      const isMobileDevice = /Mobi|Android|iPhone|iPad|iPod/i.test(navigator.userAgent);

      // Treat narrow screens as mobile (covers mobile in desktop mode)
      const isSmallScreen = window.innerWidth < 1024;

      if (isMobileDevice || isSmallScreen) {
        // Show mobile hero
        mobileHero.classList.remove('hidden');
        desktopHero.classList.add('hidden');
      } else {
        // Show desktop hero
        desktopHero.classList.remove('hidden');
        mobileHero.classList.add('hidden');
      }
    }

    // Run on page load
    window.addEventListener('DOMContentLoaded', showHeroByDevice);

    // Update on resize
    window.addEventListener('resize', showHeroByDevice);
  </script>


  <!-- FEATURES -->
  <section class="bg-white py-16">
    <div class="max-w-6xl mx-auto px-6 text-center mb-6">
      <h2 class="text-3xl font-bold text-gray-900">Our Highlights</h2>
      <p class="text-gray-500 mt-2">Discover the benefits of learning with VIDYA</p>
    </div>

    <div class="max-w-6xl mx-auto px-6 grid sm:grid-cols-2 lg:grid-cols-4 gap-16">
      <div class="bg-emerald-600 text-white rounded-2xl p-6 text-center shadow transition transform hover:-translate-y-2 hover:shadow-xl hover:bg-gray-100 hover:text-black">
        <h3 class="font-semibold">Best Curriculum</h3>
        <p class="text-sm mt-2">Structured notes by subject & semester.</p>
      </div>

      <div class="bg-emerald-600 text-white rounded-2xl p-6 text-center shadow transition transform hover:-translate-y-2 hover:shadow-xl hover:bg-gray-100 hover:text-black">
        <h3 class="font-semibold">Best Teachers</h3>
        <p class="text-sm mt-2">Content uploaded by verified teachers & toppers.</p>
      </div>

      <div class="bg-emerald-600 text-white rounded-2xl p-6 text-center shadow transition transform hover:-translate-y-2 hover:shadow-xl hover:bg-gray-100 hover:text-black">
        <h3 class="font-semibold">Happy Students</h3>
        <p class="text-sm mt-2">Thousands of downloads every semester.</p>
      </div>

      <div class="bg-emerald-600 text-white rounded-2xl p-6 text-center shadow transition transform hover:-translate-y-2 hover:shadow-xl hover:bg-gray-100 hover:text-black">
        <h3 class="font-semibold">Anytime Access</h3>
        <p class="text-sm mt-2">Learn anytime, anywhere, on any device.</p>
      </div>
    </div>
  </section>


  <!-- HOW IT WORKS -->
  <section class="py-16 max-w-6xl mx-auto px-6">
    <h2 class="text-2xl font-bold text-center mb-10">How VIDYA Works</h2>

    <div class="grid sm:grid-cols-3 gap-8 text-center">
      <div>
        <div class="w-12 h-12 mx-auto bg-emerald-100 rounded-full flex items-center justify-center">1</div>
        <p class="mt-3 font-semibold">Sign Up</p>
        <p class="text-sm text-gray-500">Create your free account</p>
      </div>

      <div>
        <div class="w-12 h-12 mx-auto bg-emerald-100 rounded-full flex items-center justify-center">2</div>
        <p class="mt-3 font-semibold">Browse Notes</p>
        <p class="text-sm text-gray-500">Search subject-wise notes</p>
      </div>

      <div>
        <div class="w-12 h-12 mx-auto bg-emerald-100 rounded-full flex items-center justify-center">3</div>
        <p class="mt-3 font-semibold">Download</p>
        <p class="text-sm text-gray-500">One click PDF access</p>
      </div>
    </div>
  </section>


  <!-- TESTIMONIAL -->
  <section class="bg-white py-10">
    <div class="max-w-6xl mx-auto px-6">

      <div class="grid md:grid-cols-2 gap-10 items-center">

        <!-- LEFT -->
        <div class="md:pr-6">

          <h2 class="text-2xl md:text-3xl font-bold mb-6">
            What Students Say
          </h2>

          <div class="relative min-h-[140px]">

            <?php
            $index = 0;
            while ($row = mysqli_fetch_assoc($feedbacks)) {
            ?>

              <div class="slide absolute inset-0 w-full flex items-start transition-all duration-700 ease-in-out 
                <?php echo $index == 0 ? 'opacity-100' : 'opacity-0'; ?>">

                <div class="bg-emerald-50 border-l-4 border-emerald-500 rounded-xl p-6 shadow-md max-w-xl">

                  <!-- MESSAGE -->
                  <p class="text-gray-700 italic leading-relaxed">
                    “<?php echo $row['message']; ?>”
                  </p>

                  <!-- FOOTER -->
                  <div class="mt-4 flex items-center justify-between">

                    <!-- NAME -->
                    <p class="font-semibold text-gray-900">
                      — <?php echo $row['fullname']; ?>
                    </p>

                    <!-- STARS -->
                    <div class="text-yellow-400 text-sm">
                      <?php for ($i = 0; $i < $row['rating']; $i++) echo "★"; ?>
                    </div>

                  </div>

                </div>

              </div>

            <?php $index++;
            } ?>

          </div>

        </div>

        <!-- RIGHT -->
        <div class="flex justify-center md:justify-end md:pl-6">
          <img src="css/images/students1.1.png"
            class="w-full max-w-md md:max-w-lg lg:max-w-xl h-auto object-contain drop-shadow-xl">
        </div>

      </div>

    </div>
  </section>

  <!-- FAQ -->
  <section class="py-16 max-w-6xl mx-auto px-6">
    <h2 class="text-2xl font-bold mb-6">Frequently Asked Questions</h2>

    <div class="space-y-4">
      <div class="bg-emerald-100 p-4 rounded-xl">Are the notes free?</div>
      <div class="bg-emerald-100 p-4 rounded-xl">Can students upload notes?</div>
      <div class="bg-emerald-100 p-4 rounded-xl">Is registration required?</div>
    </div>
  </section>

  <?php include 'footer.php'; ?>


  <script>
    document.addEventListener("DOMContentLoaded", function() {

      const slides = document.querySelectorAll(".slide");
      let current = 0;
      let interval;

      if (slides.length <= 1) return;

      // RESET all animation classes (important fix)
      function resetClasses(slide) {
        slide.classList.remove(
          "opacity-100", "opacity-0",
          "translate-x-0", "translate-x-3", "-translate-x-3"
        );
      }

      function showSlide(next) {

        // current exit (smooth fade + slight left)
        slides[current].classList.remove("opacity-100", "translate-x-0");
        slides[current].classList.add("opacity-0", "-translate-x-3");

        // next enter (smooth from right)
        slides[next].classList.remove("opacity-0", "translate-x-3");
        slides[next].classList.add("opacity-100", "translate-x-0");

        current = next;
      }

      function startSlider() {
        interval = setInterval(() => {
          let next = (current + 1) % slides.length;
          showSlide(next);
        }, 4000);
      }

      function stopSlider() {
        clearInterval(interval);
      }

      // start auto sliding
      startSlider();

      // pause on hover (better UX)
      const container = document.querySelector(".relative.min-h-[140px]");
      if (container) {
        container.addEventListener("mouseenter", stopSlider);
        container.addEventListener("mouseleave", startSlider);
      }

    });
  </script>
  <script>
    function runHeroAnimation() {
      document.querySelectorAll('.hero-animate').forEach(el => {
        el.classList.remove('show'); // reset
        setTimeout(() => {
          el.classList.add('show');
        }, 200);
      });
    }

    window.addEventListener('load', () => {
      runHeroAnimation();
    });
  </script>
</body>

</html>