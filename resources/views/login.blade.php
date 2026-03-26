<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-amber-50 py-12 px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-md mx-auto">
            
            <!-- Header -->
            <div class="text-center mb-8">
                <div
                
                class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl shadow-lg mb-4"> 
                <div class=""> <span class=" text-yellow-200">Vintuna</span> <span class=" text-amber-50">Store</span> </div>
                
                </div>
                

                <h1 class="text-4xl font-bold text-gray-900 mb-2">Welcome Back</h1>
                <p class="text-gray-600">Login to your account</p> 
            </div>


            <!-- Login Card -->

            <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-10">

                <form action="{{ route('login') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Email -->

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Email Address
                        </label>

                        <input type="email" name="email" value="{{ old('email') }}" placeholder="your@email.com"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 outline-none">

                        <span class="text-red-500 text-sm">
                            @error('email')
                                {{ $message }}
                            @enderror
                        </span>

                    </div>


                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Password
                        </label>

                        <div class="relative">
                            <input type="password" id="password" name="password" placeholder="••••••••"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 outline-none">
                            <button type="button" onclick="togglePassword('password', this)"
                                class="absolute right-3 top-3.5 text-gray-400 hover:text-emerald-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>

                        <span class="text-red-500 text-sm">
                            @error('password')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>


                    <!-- Remember -->

                    <div class="flex items-center justify-between">

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="remember" class="text-emerald-600">
                            <span class="text-sm text-gray-600">Remember me</span>
                        </label>

                        <a href="#" class="text-sm text-emerald-600 hover:underline">
                            Forgot password?
                        </a>

                    </div>


                    <!-- Button -->

                    <button type="submit"
                        class="w-full bg-gradient-to-r from-emerald-500 to-emerald-600 text-white font-bold py-4 rounded-xl hover:from-emerald-600 hover:to-emerald-700 transition">
                        Login
                    </button>


                    <!-- Register link -->

                    <div class="text-center text-gray-600">

                        Don't have an account?

                        <a href="/register" class="text-emerald-600 font-semibold hover:underline">
                            Create Account
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>


    <script>
        function togglePassword(fieldId, btn) {
            const input = document.getElementById(fieldId);
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            btn.innerHTML = isPassword ?
                `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94"/>
                <path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/>
                <line x1="1" y1="1" x2="23" y2="23"/>
               </svg>` :
                `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>
               </svg>`;
        }
    </script>


</body>

</html>