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

    <!-- Simple and Clean Styles -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
        }

        .gradient-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.05) 50%, transparent 70%);
            animation: shimmer 3s ease-in-out infinite;
        }

        @keyframes shimmer {

            0%,
            100% {
                transform: translateX(-100%);
            }

            50% {
                transform: translateX(100%);
            }
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Subtle floating animation for decorative elements */
        .float-decoration {
            animation: float 8s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-15px) rotate(180deg);
            }
        }

        /* Smooth transitions */
        * {
            transition: all 0.3s ease;
        }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased">
    <!-- Simple Gradient Background -->
    <div class="gradient-bg min-h-screen relative">
        <!-- Subtle Decorative Elements -->
        <div class="absolute top-10 left-10 w-32 h-32 bg-white bg-opacity-5 rounded-full blur-xl float-decoration">
        </div>
        <div class="absolute top-20 right-20 w-24 h-24 bg-white bg-opacity-5 rounded-full blur-lg float-decoration"
            style="animation-delay: -2s;"></div>
        <div class="absolute bottom-20 left-1/4 w-40 h-40 bg-white bg-opacity-5 rounded-full blur-2xl float-decoration"
            style="animation-delay: -4s;"></div>
        <div class="absolute bottom-32 right-1/3 w-20 h-20 bg-white bg-opacity-5 rounded-full blur-lg float-decoration"
            style="animation-delay: -6s;"></div>

        <!-- Main Content -->
        <div class="relative z-10 min-h-screen flex flex-col justify-center items-center p-4">
            <!-- Content Container -->
            <div class="w-full max-w-md fade-in">
                {{ $slot }}
            </div>
        </div>
    </div>

    <!-- Simple JavaScript for Enhanced UX -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth page loading
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity 0.5s ease-in-out';

            setTimeout(() => {
                document.body.style.opacity = '1';
            }, 100);

            // Add subtle focus effects to form inputs
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.style.transform = 'translateY(-2px)';
                    this.style.boxShadow = '0 8px 25px rgba(0,0,0,0.1)';
                });

                input.addEventListener('blur', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = 'none';
                });
            });

            // Add hover effects to buttons
            const buttons = document.querySelectorAll('button');
            buttons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                    this.style.boxShadow = '0 8px 25px rgba(0,0,0,0.15)';
                });

                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = 'none';
                });
            });

            // Smooth form submission feedback
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    const button = this.querySelector('button[type="submit"]');
                    if (button) {
                        button.style.transform = 'scale(0.95)';
                        button.textContent = 'Memproses...';
                        button.disabled = true;
                    }
                });
            });
        });
    </script>
</body>

</html>
