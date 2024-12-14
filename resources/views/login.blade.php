@extends('layouts.layout')

@section('content')

{{-- Alert --}}
<x-alert></x-alert>

<div class="relative h-screen w-full bg-cover bg-center">
    {{-- <div class="absolute inset-0 bg-black bg-opacity-50"></div> --}}
    <div class="flex items-center justify-center h-full relative z-10">
        <div class="bg-white bg-opacity-90 p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-2xl font-bold text-center mb-6 text-blue-500">Login</h2>
            <form action="{{ route('auth.login') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <input type="email" id="email" name="email" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                {{-- <div class="flex justify-between items-center mb-4">
                    <div>
                        <input type="checkbox" id="remember" name="remember" class="mr-2">
                        <label for="remember" class="text-sm text-gray-700">Remember me</label>
                    </div>
                    <a href="#" class="text-sm text-blue-500 hover:underline">Forgot password?</a>
                </div> --}}
                <div class="flex gap-4">
                    <button type="submit"
                        class="block px-4 py-2 text-center w-full border border-blue-500 text-blue-400 rounded-lg hover:bg-blue-400 hover:text-white transition">
                        Daftar
                    </button>
                    <button type="submit"
                        class="block px-4 py-2 text-center w-full bg-blue-400 text-white rounded-lg hover:bg-transparent  hover:border hover:border-blue-400 hover:text-blue-400 transition">
                        Masuk
                    </button>
                </div>
            </form>
            {{-- <p class="text-center text-sm text-gray-600 mt-4">
                Don't have an account? 
                <a href="/register" class="text-blue-500 hover:underline">Register</a>
            </p> --}}
        </div>
    </div>
</div>
@endsection 