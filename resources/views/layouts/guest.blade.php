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

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .bg-pattern {
            background-color: #f8fafc;
            background-image:
                radial-gradient(circle at 1px 1px, #e2e8f0 1px, transparent 0);
            background-size: 20px 20px;
        }

        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
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

        .input-focus {
            transition: all 0.3s ease;
        }

        .input-focus:focus {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
        }

        .btn-hover {
            transition: all 0.3s ease;
        }

        .btn-hover:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);
        }

        .btn-hover:active {
            transform: translateY(0);
        }

        /* Decorative circles */
        .decoration-circle {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        .decoration-circle:nth-child(1) {
            width: 60px;
            height: 60px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .decoration-circle:nth-child(2) {
            width: 80px;
            height: 80px;
            top: 20%;
            right: 15%;
            animation-delay: 2s;
        }

        .decoration-circle:nth-child(3) {
            width: 40px;
            height: 40px;
            bottom: 30%;
            left: 20%;
            animation-delay: 4s;
        }

        .decoration-circle:nth-child(4) {
            width: 100px;
            height: 100px;
            bottom: 10%;
            right: 10%;
            animation-delay: 1s;
        }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="bg-pattern min-h-screen relative overflow-hidden">
        <!-- Decorative Elements -->
        <div class="decoration-circle"></div>
        <div class="decoration-circle"></div>
        <div class="decoration-circle"></div>
        <div class="decoration-circle"></div>

        <!-- Main Content -->
        <div class="relative z-10 min-h-screen flex flex-col justify-center items-center p-4">
            <div class="w-full max-w-md fade-in">
                {{ $slot }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth page loading
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity 0.5s ease-in-out';

            setTimeout(() => {
                document.body.style.opacity = '1';
            }, 100);

            // Enhanced form interactions
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.classList.add('input-focus');

                // Add floating label effect
                input.addEventListener('focus', function() {
                    const label = this.previousElementSibling;
                    if (label && label.tagName === 'LABEL') {
                        label.style.color = '#3b82f6';
                        label.style.transform = 'scale(0.95)';
                    }
                });

                input.addEventListener('blur', function() {
                    const label = this.previousElementSibling;
                    if (label && label.tagName === 'LABEL') {
                        label.style.color = '#374151';
                        label.style.transform = 'scale(1)';
                    }
                });
            });

            // Enhanced button interactions
            const buttons = document.querySelectorAll('button');
            buttons.forEach(button => {
                button.classList.add('btn-hover');
            });

            // Form submission handling
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    const button = this.querySelector('button[type="submit"]');
                    if (button) {
                        button.style.transform = 'scale(0.98)';
                        button.innerHTML =
                            '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Memproses...';
                        button.disabled = true;
                    }
                });
            });
        });
    </script>
</body>

</html>
