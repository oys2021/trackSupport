<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Activity Tracker</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; }
  </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen px-4">
  <div class="w-full max-w-md">

    <!-- Logo & Header -->
    <div class="text-center mb-10">
      <div class="mx-auto w-16 h-16 flex items-center justify-center bg-blue-600 rounded-xl shadow-md">
        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2
            2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2
            2 0 002 2h2a2 2 0 002-2M9 5a2
            2 0 012-2h2a2 2 0 012 2" />
        </svg>
      </div>
      <h1 class="mt-6 text-3xl font-bold text-gray-900">Welcome Back</h1>
      <p class="mt-2 text-gray-600">Sign in to continue to Activity Tracker</p>
    </div>

    <!-- Login Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
      <form action="{{ url('/login') }}" method="POST">
        @csrf

        <!-- Email -->
        <div class="mb-5">
          <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
            Email Address
          </label>
          <input
            type="email" id="email" name="email" autocomplete="email"
            placeholder="you@example.com"
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2
                   focus:ring-blue-500 focus:border-transparent outline-none transition"
            required
            value="{{old('email')}}"
            >
        </div>

        <!-- Password -->
        <div class="mb-3">
          <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
            Password
          </label>
          <input
            type="password" id="password" name="password" autocomplete="current-password"
            placeholder="Enter your password"
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2
                   focus:ring-blue-500 focus:border-transparent outline-none transition"
            required
            value="{{old('password')}}"
            >
        </div>

        <button
          type="submit"
          class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold
                 hover:bg-blue-700 transition focus:ring-4 focus:ring-blue-200">
          Sign In
        </button>

         @if ($errors->any())
        <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
          <ul class="text-red-600 text-sm">
            @foreach ($errors->all() as $error)
              <li class="flex items-center mt-1">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ $error }}
              </li>
            @endforeach
          </ul>
        </div>
        @endif
      </form>


      <!-- Social Login -->
      <div class="grid gap-3">

      </div>
    </div>

    <!-- Sign Up -->
    <p class="text-center text-sm text-gray-600 mt-6">
      Don’t have an account?
      <a href="/register" class="font-medium text-blue-600 hover:text-blue-700">Sign up</a>
    </p>
  </div>
</body>
</html>
