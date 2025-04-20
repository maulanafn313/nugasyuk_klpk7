<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Welcome to Nugas Yuk!</title>
  @vite('resources/css/app.css')
  <style>
    .sticky-header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 50;
      transition: all 0.3s ease;
    }
    .section-spacing {
      margin-top: 6rem;
      margin-bottom: 6rem;
    }
    .testimonial-card {
      transition: transform 0.3s ease;
    }
    .testimonial-card:hover {
      transform: translateY(-10px);
    }
  </style>
</head>
<body class=" font-sans min-h-screen flex flex-col">

  <!-- Sticky Header / Navbar -->
  <header class="bg-white shadow sticky-header">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
      <a href="/" class="flex items-center space-x-2">
        <img src="/images/logo-nugasyuk.png" alt="Nugas Yuk Logo" class="h-12 w-auto" />
      </a>
      <nav class="space-x-6 text-gray-700 font-semibold">
        <a href="{{ route('login') }}" class="px-4 py-2 hover:text-blue-600 transition duration-300">Login</a>
        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md transition duration-300">Register</a>
      </nav>
    </div>
  </header>

  <!-- Main Content -->
  <main class="flex-grow pt-20"> <!-- Added padding-top to account for sticky header -->

    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-6 py-28 text-center">
      <h1 class="text-5xl font-extrabold text-gray-900 mb-6">
        Manage Your Tasks Easily with <span class="text-blue-600">Nugas Yuk!</span>
      </h1>
      <p class="text-gray-700 mb-12 max-w-2xl mx-auto leading-relaxed text-lg">
        Organize, schedule, and track your tasks to boost your productivity. Start now and never miss a deadline!
      </p>
    </section>

    <!-- Feature Highlights with increased spacing -->
    <section class="bg-white py-24 mt-16">
      <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-16 text-center">
        <div class="p-6 rounded-lg hover:shadow-lg transition duration-300">
          <svg class="mx-auto mb-6 h-16 w-16 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M6 21h12M4 13h16" />
          </svg>
          <h3 class="text-2xl font-semibold mb-4">Create Schedules</h3>
          <p class="text-gray-600 max-w-xs mx-auto">Easily create and customize your own task schedules with intuitive tools.</p>
        </div>
        <div class="p-6 rounded-lg hover:shadow-lg transition duration-300">
          <svg class="mx-auto mb-6 h-16 w-16 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 0h2a2 2 0 002-2v-6a2 2 0 00-2-2h-2a2 2 0 00-2 2v6zM4 6v12a2 2 0 002 2h10a2 2 0 002-2V6H4z" />
          </svg>
          <h3 class="text-2xl font-semibold mb-4">View & Track</h3>
          <p class="text-gray-600 max-w-xs mx-auto">Monitor your progress and keep your tasks organized with visual dashboards.</p>
        </div>
        <div class="p-6 rounded-lg hover:shadow-lg transition duration-300">
          <svg class="mx-auto mb-6 h-16 w-16 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
          </svg>
          <h3 class="text-2xl font-semibold mb-4">Get Things Done</h3>
          <p class="text-gray-600 max-w-xs mx-auto">Achieve your goals with effective task management and productivity insights.</p>
        </div>
      </div>
    </section>

    <!-- Visual Planning Section with Image -->
    <section class="bg-white py-24 mt-16 md-mt-4">
      <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 items-center gap-16">
        
        <!-- Text Content -->
        <div>
          <h2 class="text-4xl font-bold text-gray-900 mb-6">Stay on Track with Visual Planning</h2>
          <p class="text-gray-700 text-lg mb-8 leading-relaxed">
            Visualize your tasks with an intuitive calendar and task view. Whether you're a student or a professional, Nugas Yuk! helps you stay focused and productive.
          </p>
          <a href="{{ route('register') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-md font-medium transition duration-300">
            Try It Now
          </a>
        </div>

        <!-- Illustration / Gambar -->
        <div class="overflow-hidden p-4">
          <img src="/images/planning.svg" alt="Planning Illustration" class="w-full p-4" />
        </div>

      </div>
    </section>

    <!-- NEW: App Features Showcase -->
    <section class="bg-white py-24 mt-16">
      <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-16">Powerful Features to Boost Your Productivity</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center mb-24">
          <div>
            <img src="/images/calendar.svg" alt="Calendar Interface" class="w-full p-4" />
          </div>
          <div>
            <h3 class="text-2xl font-semibold mb-4">Intuitive Calendar View</h3>
            <p class="text-gray-700 mb-6 leading-relaxed">
              Plan your week with our easy-to-use calendar interface. Drag and drop tasks, set recurring events, and get a clear overview of your upcoming schedule at a glance.
            </p>
            <ul class="space-y-3">
              <li class="flex items-start">
                <svg class="h-6 w-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>Multiple calendar views: daily, weekly, monthly</span>
              </li>
              <li class="flex items-start">
                <svg class="h-6 w-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>Color-coding for different task categories</span>
              </li>
              <li class="flex items-start">
                <svg class="h-6 w-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>Deadline reminders and notifications</span>
              </li>
            </ul>
          </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center mb-24">
          <div class="order-2 md:order-1">
            <h3 class="text-2xl font-semibold mb-4">Smart Task Management</h3>
            <p class="text-gray-700 mb-6 leading-relaxed">
              Organize tasks your way with customizable lists, priorities, and categories. Break down complex projects into manageable steps and track your progress effectively.
            </p>
            <ul class="space-y-3">
              <li class="flex items-start">
                <svg class="h-6 w-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>Priority levels and due dates</span>
              </li>
              <li class="flex items-start">
                <svg class="h-6 w-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>Task notes and file attachments</span>
              </li>
              <li class="flex items-start">
                <svg class="h-6 w-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>Track completion status and progress</span>
              </li>
            </ul>
          </div>
          <div class="order-1 md:order-2">
            <img src="/images/task.svg" alt="Task Management Interface" class="w-full p-4" />
          </div>
        </div>
    </section>

    <!-- NEW: FAQ Section -->
    <section class="bg-white py-24 mt-16">
      <div class="max-w-4xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-16">Frequently Asked Questions</h2>
        
        <div class="space-y-6">
          <div class="bg-gray-50 rounded-lg p-6 shadow-md">
            <h3 class="text-xl font-semibold mb-3">Is Nugas Yuk free to use?</h3>
            <p class="text-gray-700">Yes, Nugas Yuk offers a free basic plan with essential features. We also offer premium plans with advanced features for power users.</p>
          </div>
          
          <div class="bg-gray-50 rounded-lg p-6 shadow-md">
            <h3 class="text-xl font-semibold mb-3">Can I access Nugas Yuk on multiple devices?</h3>
            <p class="text-gray-700">Absolutely! Your account can be accessed from any device with a web browser. Our mobile apps for iOS and Android also provide a seamless experience across all your devices.</p>
          </div>
          
          <div class="bg-gray-50 rounded-lg p-6 shadow-md">
            <h3 class="text-xl font-semibold mb-3">Can I collaborate with others on tasks?</h3>
            <p class="text-gray-700">Yes, our premium plans include collaboration features that allow you to share tasks and projects with team members, classmates, or colleagues.</p>
          </div>
          
          <div class="bg-gray-50 rounded-lg p-6 shadow-md">
            <h3 class="text-xl font-semibold mb-3">How secure is my data?</h3>
            <p class="text-gray-700">We take data security seriously. All data is encrypted both in transit and at rest, and we follow industry best practices to ensure your information stays private.</p>
          </div>
          
          <div class="bg-gray-50 rounded-lg p-6 shadow-md">
            <h3 class="text-xl font-semibold mb-3">Can I import tasks from other applications?</h3>
            <p class="text-gray-700">Yes, Nugas Yuk supports importing tasks from popular productivity apps like Todoist, Trello, and Google Tasks to make your transition seamless.</p>
          </div>
        </div>
      </div>
    </section>

  </main>

  <x-footer></x-footer>

  <!-- JavaScript for sticky header -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const header = document.querySelector('.sticky-header');
      
      window.addEventListener('scroll', function() {
        if (window.scrollY > 100) {
          header.classList.add('bg-white', 'shadow-md');
        } else {
          header.classList.remove('shadow-md');
        }
      });
    });
  </script>

</body>
</html>