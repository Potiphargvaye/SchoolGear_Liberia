<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>

    @vite(['resources/css/app.css'])
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen px-4">

<div class="w-full max-w-md bg-white p-6 sm:p-8 rounded shadow">

    <h2 class="text-xl font-bold mb-4 text-center sm:text-left">
        Forgot Password
    </h2>

    <p class="text-sm text-gray-600 mb-6 text-center sm:text-left">
        Enter your email and we will send you a reset link.
    </p>

    @if (session('status'))
        <div class="mb-4 text-green-600 text-sm">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" id="forgotForm">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Email</label>

            <input type="email"
                   name="email"
                   value="{{ old('email') }}"
                   required
                   class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">

            @error('email')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- BUTTON -->
        <button type="submit"
                id="forgotBtn"
                class="bg-blue-600 text-white px-4 py-2 rounded w-full relative overflow-hidden">

            <span class="btn-text">Send Reset Link</span>

            <!-- spinner -->
            <span class="btn-spinner hidden absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>

        </button>
    </form>

</div>

<script>
const forgotForm = document.getElementById('forgotForm');
const forgotBtn = document.getElementById('forgotBtn');
const spinner = forgotBtn.querySelector('.btn-spinner');
const text = forgotBtn.querySelector('.btn-text');

forgotForm.addEventListener('submit', function () {

    forgotBtn.disabled = true;

    text.textContent = "Sending...";
    spinner.classList.remove('hidden');
});
</script>

</body>
</html>