<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'KMS') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional Styles for Modern Look -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .animated-bg {
            background: linear-gradient(-45deg, #667eea, #764ba2, #f093fb, #f5576c, #4facfe, #00f2fe);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .glass-effect {
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: particle-float 20s infinite linear;
        }

        @keyframes particle-float {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                transform: translateY(-100vh) rotate(360deg);
                opacity: 0;
            }
        }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased overflow-hidden">
    <!-- Animated Background -->
    <div class="animated-bg fixed inset-0 z-0"></div>

    <!-- Floating Particles -->
    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="particle w-2 h-2 top-10 left-10" style="animation-delay: 0s;"></div>
        <div class="particle w-1 h-1 top-20 left-1/4" style="animation-delay: 2s;"></div>
        <div class="particle w-3 h-3 top-32 right-1/4" style="animation-delay: 4s;"></div>
        <div class="particle w-2 h-2 top-40 right-10" style="animation-delay: 6s;"></div>
        <div class="particle w-1 h-1 top-60 left-1/3" style="animation-delay: 8s;"></div>
        <div class="particle w-2 h-2 top-80 right-1/3" style="animation-delay: 10s;"></div>
        <div class="particle w-1 h-1 bottom-20 left-1/2" style="animation-delay: 12s;"></div>
        <div class="particle w-3 h-3 bottom-32 right-1/2" style="animation-delay: 14s;"></div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 min-h-screen flex flex-col justify-center items-center p-4">
        <!-- Optional Logo/Brand (only if needed) -->
        <div class="hidden">
            <a href="/" class="block mb-8">
                <x-application-logo class="w-16 h-16 mx-auto text-white floating-animation" />
            </a>
        </div>

        <!-- Content Container -->
        <div class="w-full max-w-6xl">
            {{ $slot }}
        </div>
    </div>

    <!-- Decorative Elements -->
    <div class="fixed top-10 left-10 w-20 h-20 bg-white bg-opacity-10 rounded-full blur-xl"></div>
    <div class="fixed top-32 right-16 w-16 h-16 bg-purple-300 bg-opacity-20 rounded-full blur-lg"></div>
    <div class="fixed bottom-20 left-1/4 w-24 h-24 bg-blue-300 bg-opacity-15 rounded-full blur-xl"></div>
    <div class="fixed bottom-40 right-1/3 w-12 h-12 bg-pink-300 bg-opacity-20 rounded-full blur-lg"></div>

    <!-- Scripts for Enhanced Interactivity -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add smooth scroll behavior
            document.documentElement.style.scrollBehavior = 'smooth';

            // Add subtle mouse movement effect
            document.addEventListener('mousemove', function(e) {
                const particles = document.querySelectorAll('.particle');
                const x = e.clientX / window.innerWidth;
                const y = e.clientY / window.innerHeight;

                particles.forEach((particle, index) => {
                    const speed = (index + 1) * 0.5;
                    const xOffset = (x - 0.5) * speed;
                    const yOffset = (y - 0.5) * speed;

                    particle.style.transform += ` translate(${xOffset}px, ${yOffset}px)`;
                });
            });

            // Add loading animation
            const body = document.body;
            body.style.opacity = '0';
            body.style.transition = 'opacity 0.5s ease-in-out';

            setTimeout(() => {
                body.style.opacity = '1';
            }, 100);
        });
    </script>
</body>

</html>
