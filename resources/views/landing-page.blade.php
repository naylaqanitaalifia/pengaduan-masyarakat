<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Landing Page</title>
    {{-- Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body>
    @if (Session::get('cantAccess'))
        <div class="bg-red text-white">
            {{ Session::get('cantAccess') }}
        </div>
    @endif
    <div class="relative h-screen w-full bg-cover bg-center" style="background-image: url('{{ asset('assets/images/landing.jpg') }}')">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="flex justify-between items-center h-full relative z-10 px-12">
            <div class="text-white w-1/2">
                <h1 class="text-4xl font-bold mb-4">Pengaduan Masyarakat</h1>
                <p class="text-lg mb-6">Platform untuk menyampaikan laporan terkait masalah di lingkungan sekitar. Laporkan isu seperti pelayanan publik, kebersihan, atau infrastruktur, dan pantau perkembangan pengaduan Anda. Bersama, kita bisa menciptakan perubahan untuk lingkungan yang lebih baik.</p>
                <a href="{{ route('login') }}" class="bg-blue-400 text-white px-6 py-3 rounded-full font-semibold hover:bg-transparent hover:border-blue-400 hover:border-2">Bergabung!</a>
            </div>
            {{-- FAB --}}
            <x-fab></x-fab>
        </div>
    </div>
</body>
</html>