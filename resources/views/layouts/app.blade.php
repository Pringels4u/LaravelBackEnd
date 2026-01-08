<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        {{-- Lightweight client-side validation for key forms (works without Vite). --}}
        <script>
            (function(){
                const emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                function showInlineError(el, msg) {
                    if (!el) return;
                    // set native validity for accessibility
                    try { el.setCustomValidity(msg); } catch (err) {}
                    // find existing error node
                    let err = el.nextElementSibling;
                    if (!err || !err.classList.contains('validation-error')) {
                        err = document.createElement('div');
                        err.className = 'validation-error';
                        err.style.color = '#dc2626';
                        err.style.fontSize = '0.875rem';
                        err.style.marginTop = '0.25rem';
                        el.parentNode.insertBefore(err, el.nextSibling);
                    }
                    err.textContent = msg;
                }

                function clearInlineError(el){
                    if(!el) return;
                    try { el.setCustomValidity(''); } catch (err) {}
                    const err = el.nextElementSibling;
                    if (err && err.classList.contains('validation-error')) err.textContent = '';
                }

                // Register form validation
                const regForm = document.querySelector('form[action*="/register"]');
                if (regForm) regForm.addEventListener('submit', function(e){
                    const name = regForm.querySelector('[name="name"]');
                    const email = regForm.querySelector('[name="email"]');
                    const password = regForm.querySelector('[name="password"]');
                    const pwc = regForm.querySelector('[name="password_confirmation"]');
                    let ok = true;
                    clearInlineError(name); clearInlineError(email); clearInlineError(password); clearInlineError(pwc);
                    if (!name.value.trim()) { showInlineError(name, 'Vul je naam in'); ok = false; }
                    if (!emailRe.test(email.value.trim())) { showInlineError(email, 'Vul een geldig e-mailadres in'); ok = false; }
                    if (!password.value || password.value.length < 8) { showInlineError(password, 'Wachtwoord moet minimaal 8 tekens zijn'); ok = false; }
                    if (password.value !== pwc.value) { showInlineError(pwc, 'Wachtwoord bevestiging komt niet overeen'); ok = false; }
                    if (!ok) e.preventDefault();
                });

                // Contact form validation
                const contactForm = document.querySelector('form[action*="/contact"]');
                if (contactForm) contactForm.addEventListener('submit', function(e){
                    const name = contactForm.querySelector('[name="name"]');
                    const email = contactForm.querySelector('[name="email"]');
                    const message = contactForm.querySelector('[name="message"]');
                    let ok = true;
                    clearInlineError(name); clearInlineError(email); clearInlineError(message);
                    if (!name.value.trim()) { showInlineError(name, 'Vul je naam in'); ok = false; }
                    if (!emailRe.test(email.value.trim())) { showInlineError(email, 'Vul een geldig e-mailadres in'); ok = false; }
                    if (!message.value.trim() || message.value.trim().length < 10) { showInlineError(message, 'Bericht moet minimaal 10 tekens bevatten'); ok = false; }
                    if (!ok) e.preventDefault();
                });

                // News create validation (admin)
                const newsForm = document.querySelector('form[action*="admin/news"]');
                if (newsForm) newsForm.addEventListener('submit', function(e){
                    const title = newsForm.querySelector('[name="title"]');
                    const content = newsForm.querySelector('[name="content"]');
                    clearInlineError(title); clearInlineError(content);
                    let ok = true;
                    if (!title.value.trim()) { showInlineError(title, 'Titel is vereist'); ok = false; }
                    if (!content.value.trim() || content.value.trim().length < 10) { showInlineError(content, 'Inhoud moet minimaal 10 tekens bevatten'); ok = false; }
                    if (!ok) e.preventDefault();
                });

                // Profile update (basic)
                const profileForm = document.querySelector('form[action*="/profile"]');
                if (profileForm) profileForm.addEventListener('submit', function(e){
                    const name = profileForm.querySelector('[name="name"]');
                    const email = profileForm.querySelector('[name="email"]');
                    clearInlineError(name); clearInlineError(email);
                    let ok = true;
                    if (name && !name.value.trim()) { showInlineError(name, 'Vul je naam in'); ok = false; }
                    if (email && !emailRe.test(email.value.trim())) { showInlineError(email, 'Vul een geldig e-mailadres in'); ok = false; }
                    if (!ok) e.preventDefault();
                });

                // Clear custom validity on input
                document.addEventListener('input', function(e){
                    if (e.target) {
                        try { e.target.setCustomValidity(''); } catch (err) {}
                        const err = e.target.nextElementSibling;
                        if (err && err.classList.contains('validation-error')) err.textContent = '';
                    }
                });
            })();
        </script>
    </body>
</html>
