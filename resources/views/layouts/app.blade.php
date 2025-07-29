<!DOCTYPE html>
<html>
    <head>
        <title>Laravel 10 Task List App</title>
         {{-- Відображення вмісту певного розділу у батьківському макеті стилів styles за допомогою директиви @yield() --}}
         {{--Виконуємо стилізацію Tailwind CSS --}}
        <script src="//unpkg.com/alpinejs" defer></script>
        <script src="https://cdn.tailwindcss.com"></script>

        {{--blade-formatter-disable--}}
        {{--Підключаємо стилі--}}
        <style type="text/tailwindcss">
            .btn {
                @apply rounded-md px-2 py-1 text-center font-medium text-slate-700 shadow-sm ring-1 ring-slate-700/10 hover:bg-slate-50
            }

            .link {
                @apply font-medium text-gray-700 underline decoration-pink-500
              }

            label {
                @apply block uppercase text-slate-700 mb-2
            }

            input, textarea {
                @apply shadow-sm appearance-none border w-full py-2 px-3 text-slate-700 leading-tight focus:outline-none
            }

            .error {
                @apply text-red-500 text-sm
            }
        </style>
        {{--blade-formatter-enable--}}
        @yield('styles')
    </head>

    {{--Додаємо стилі--}}
    <body class="container mx-auto mt-10 mb-10 max-w-lg">
        {{-- Відображення вмісту певного розділу у батьківському макеті show за допомогою директиви --}}
        <h1 class="mb-4 text-2xl">@yield('title')</h1>
        <div>
        <div x-data="{ flash: true }">
        {{-- Використовуємо директиву if, щоб отримати доступ до сеансу через функцію session та також метод, який дозволяє нам перевірити яка змінна існує в сеансі --}}
          @if (session()->has('success'))
            <div x-show="flash"
              class="relative mb-10 rounded border border-green-400 bg-green-100 px-4 py-3 text-lg text-green-700"
              role="alert">
              <strong class="font-bold">Success!</strong>
              <div>{{ session('success') }}</div>
            {{-- Отримуємо значення змінної успіху success, використовуємо функцію session --}}
              <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                  stroke-width="1.5" @click="flash = false"
                  stroke="currentColor" class="h-6 w-6 cursor-pointer">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </span>
            </div>
            @endif
          @yield('content')
        </div>
      </body>
</html>
