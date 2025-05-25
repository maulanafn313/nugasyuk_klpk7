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


<body class=" font-sans min-h-screen flex flex-col bg-blue-100">


    <!-- Sticky Header / Navbar -->
    <header class="bg-blue-300 shadow sticky-header">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="flex items-center space-x-2">
                <img src="{{ asset('storage/cms/' . $cms->logo) }}" alt="Nugas Yuk Logo" class="h-12 w-auto" />
            </a>
            <nav class="space-x-6 text-gray-700 font-semibold">
                <a href="{{ route('login') }}"
                    class="px-4 py-2  transition duration-300">Login</a>
                <a href="{{ route('register') }}" style="background-color: {{ $cms->color }}"
                    class=" hover:bg-blue-700 text-white px-6 py-2 rounded-md transition duration-300">Register</a>
            </nav>
        </div>
    </header>


    <!-- Main Content -->
    <main class="flex-grow pt-20">
        <!-- Added padding-top to account for sticky header -->


        <!-- Hero Section -->
        <section class="max-w-7xl mx-auto px-6 py-28 text-center">
            <h1 class="text-5xl font-extrabold text-gray-900 mb-6">
                {{$cms->hero_text}} <span style="color: {{ $cms->color }}">Nugas Yuk!</span>
            </h1>
            <p class="text-gray-700 mb-12 max-w-2xl mx-auto leading-relaxed text-lg">
                {{$cms->description_text}}
            </p>
        </section>


        <section class=" mt-10">
            <div
                class="max-w-7xl bg-white mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-16 text-center">
                @foreach ($facilities as $facility)
                <div class="p-6 rounded-lg hover:shadow-lg transition duration-300">
                    <img src="{{ asset('storage/' . $facility->img) }}" alt="{{ $facility->title }}"
                        class="mx-auto mb-6 h-16 w-16 object-contain">
                    <h3 class="text-2xl font-semibold mb-4">{{ $facility->title }}</h3>
                    <p class="text-gray-600 max-w-xs mx-auto">{{ $facility->description }}</p>
                </div>
                @endforeach
            </div>
        </section>






        <!-- Visual Planning Section with Image -->
        <section class="mt-10 md-mt-4 ">
            <div
                class="max-w-7xl bg-white shadow rounded-lg mx-auto px-6 grid grid-cols-1 md:grid-cols-2 items-center gap-16">


                <!-- Text Content -->
                <div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-6"> {{$cms->hero_text2}}</h2>
                    <p class="text-gray-700 text-lg mb-8 leading-relaxed">
                        {{$cms->description_text2}}
                    </p>
                    <a href="{{ route('register') }}" style="background-color: {{ $cms->color }}"
                        class="inline-block hover:bg-blue-700 text-white px-8 py-4 rounded-md font-medium transition duration-300">
                        Try It Now
                    </a>
                </div>


                <!-- Illustration / Gambar -->
                <div class="overflow-hidden p-4">
                    <img src="{{ asset('storage/cms/' . $cms->img_text2) }}" alt="Planning Illustration"
                        class="w-full p-4" />
                </div>


            </div>
        </section>


        <!-- NEW: App Features Showcase -->
        <section class=" mt-10">
            <div class="max-w-7xl mx-auto px-6">
                <div class="bg-white p-5 rounded-lg shadow">
                    <h2 class="text-3xl font-bold text-center mb-16">Powerful Features to Boost Your Productivity</h2>


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center mb-24">
                        <div>
                            <img src="{{ asset('storage/cms/' . $cms->img_text3) }}" alt="Calendar Interface"
                                class="w-full p-4" />
                        </div>
                        <div>
                            <h3 class="text-2xl font-semibold mb-4">{{$cms->hero_text3}}</h3>
                            <p class="text-gray-700 mb-6 leading-relaxed">
                                {{$cms->description_text3}}
                            </p>
                            <ul class="space-y-3">
                                <li class="flex items-start">
                                    <svg class="h-6 w-6 text-green-500 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Multiple calendar views: daily, weekly, monthly</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="h-6 w-6 text-green-500 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Color-coding for different task categories</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="h-6 w-6 text-green-500 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Deadline reminders and notifications</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>


                <div
                    class="bg-white p-5 rounded-lg shadow mt-10 grid grid-cols-1 md:grid-cols-2 gap-16 items-center mb-24">
                    <div class="order-2 md:order-1">
                        <h3 class="text-2xl font-semibold mb-4"> {{$cms->hero_text4}}</h3>
                        <p class="text-gray-700 mb-6 leading-relaxed">
                            {{$cms->description_text4}}
                        </p>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Priority levels and due dates</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Task notes and file attachments</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Track completion status and progress</span>
                            </li>
                        </ul>
                    </div>
                    <div class="order-1 md:order-2">
                        <img src="{{ asset('storage/cms/' . $cms->img_text4) }}" alt="Task Management Interface"
                            class="w-full p-4" />
                    </div>
                </div>
        </section>


        <!-- NEW: FAQ Section -->
    <section class="my-10">
        <div class="max-w-4xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-16">Frequently Asked Questions</h2>

            <div class="space-y-6">
                @foreach ($faqs as $faq)
                    <div class="bg-gray-50 rounded-lg p-6 shadow-md">
                        <h3 class="text-xl font-semibold mb-3">{{ $faq->question }}</h3>
                        <p class="text-gray-700 mb-2">{{ $faq->answer }}</p>
                        <p class="text-sm text-gray-500 mt-4">
                            Ditanyakan oleh: <span class="font-medium">{{ $faq->user->name ?? 'Anonim' }}</span>
                            pada {{ $faq->created_at->format('d M Y') }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>





    </main>


    <x-footer></x-footer>


    <!-- JavaScript for sticky header -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const header = document.querySelector('.sticky-header');


            window.addEventListener('scroll', function () {
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


