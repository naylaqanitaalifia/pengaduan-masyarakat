@extends('layouts.layout')
@section('content')

    {{-- Navbar --}}
    <x-navbar></x-navbar>

    {{-- FAB --}}
    <x-fab></x-fab>
    
    {{-- Alert --}}
    <x-alert></x-alert>

    {{-- Main --}}
    <div class="flex flex-col lg:flex-row p-8 gap-8">
        {{-- Cards --}}
        <div class="lg:w-3/4 space-y-6">
            {{-- Search --}}
            <form action="{{ route('report.articles') }}" method="GET">
                <div class="flex items-center justify-between">
                    <div class="w-full flex">
                        <select name="search" id="province" class="w-full px-2 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-blue-500" value="{{ request()->query('search_data') }}">
                            <option hidden selected disabled>Pilih</option>
                            @foreach ($reports as $report)
                                <option value="{{ $report['name'] }}">{{ $report['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="ml-4">
                        <button type="submit" class="bg-blue-400 text-white px-4 py-2 rounded-lg hover:bg-blue-500 focus:outline-none transition ease-in-out duration-200">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </div>
            </form>
            {{-- Card --}}
            @if ($dataReport->isEmpty())
                <div class="bg-white rounded-lg shadow-lg p-4">
                    <p class="text-center text-red-500">Data tidak ditemukan</p>
                </div>
            @endif
            @foreach ($dataReport as $report)    
            <div class="bg-white rounded-lg shadow-lg p-4">
                <div class="flex">
                    <img src="{{ asset('images/' . $report->image) }}" alt="Report Image" class="w-1/3 h-48 object-cover rounded-lg mr-4">
                    <div class="flex flex-col flex-grow">
                        <!-- Deskripsi yang terpotong jika terlalu panjang -->
                        <a href="{{ route('report.articles.show', $report->id) }}" class="text-xl font-semibold mb-2 hover:text-blue-500 hover:underline">
                            {{ Str::limit($report->description, 100) }}  <!-- Menambahkan limitasi untuk teks -->
                        </a>                            
                        <p class="text-sm text-gray-600">{{ $report->viewers }} views • 
                            {{ is_array(json_decode($report->voting, true)) ? count(json_decode($report->voting, true)) : 0 }} votes • 
                            <span class="text-blue-500">{{ $report->user->email }}</span></p>
                        
                        <div class="flex flex-col justify-between mt-4 h-full">
                            <div class="flex items-center gap-2">
                                <form action="{{ route('report.articles.voting', $report->id) }}" method="POST">
                                    @csrf
                                    <button class="focus:outline-none">
                                        @php
                                            $voting = json_decode($report->voting, true) ?? [];
                                            $userHasVoted = array_key_exists(auth()->id(), $voting);
                                        @endphp
                                        <i class="fa-solid fa-heart {{ $userHasVoted ? 'text-red-500' : 'text-gray-300' }}"></i>
                                    </button>
                                </form>
                                
                            </div>
                            <!-- Tanggal sekarang berada di paling bawah -->
                            <div class="text-sm text-gray-500 mt-2">
                                <p>{{ $report->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            @endforeach
        </div>

        {{-- Sidebar --}}
        <x-information></x-information>
    </div>

    <script>
        $(document).ready(function() {
            $.ajax({
                method: "GET",
                url: "https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json",
                dataType: "json",
                success: function(response) {
                    response.forEach(function(province) {
                        $('#search').append(`<option value="${province.id}">${province.name}</option>`);
                    });
                },
                error: function(error) {
                    alert(error);
                }
            });
            });
    </script>
@endsection