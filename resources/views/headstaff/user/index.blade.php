@extends('layouts.layout')

{{-- Navbar --}}
<x-navbar></x-navbar>

{{-- FAB --}}
<x-fab></x-fab>

@section('content')
<div class="container mx-auto p-6">
    <x-alert></x-alert>
    <div class="flex justify-center gap-6">
        <div class="bg-white rounded-lg shadow-lg p-4">
            <table class="min-w-full table-auto">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border-b text-left">#</th>
                        <th class="px-4 py-2 border-b text-left">Email</th>
                        <th class="px-4 py-2 border-b text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td class="px-4 py-2 border-b">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border-b">
                            {{ $user->email }}
                        </td>
                        <td class="px-8 py-2 border-b flex">
                            <form action="{{ route('user.reset', $user->id) }}" method="POST">
                                @csrf
                                <button class="bg-blue-400 text-white px-4 py-2 rounded-lg hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-400 transition ease-in-out duration-200">
                                    Reset
                                </button>
                            </form>
                            <form action="{{ route('user.destroy', $user['id']) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-400 text-white px-4 py-2 rounded-lg hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-400 transition ease-in-out duration-200 ml-2">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-4">
            <h3 class="font-medium mb-4">Buat Akun Staff</h3>
            <form action="" method="POST">
                @csrf
                <div class="mb-2">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" class="mt-1 px-2 py-2 block w-full rounded-md border border-gray-300 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-blue-500" name="email">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" class="mt-1 px-2 py-2 block w-full rounded-md border border-gray-300 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-blue-500" name="password">
                </div>
                <div class="">
                    <button type="submit" id="submit-btn" class="w-full bg-blue-500 text-white font-semibold py-1 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
