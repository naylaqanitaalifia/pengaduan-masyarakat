@extends('layouts.layout')
@section('content')
    @if (Session::get('AlreadyAccess'))
        <div class="bg-red-500 text-white">
            {{ Session::get('AlreadyAccess') }}
        </div>
    @endif

    {{-- Navbar --}}
    <x-navbar></x-navbar>

    {{-- Main --}}
    <div class="flex flex-col lg:flex-row p-8 gap-8">
        {{-- Cards --}}
        <div class="lg:w-3/4 space-y-6">
            {{-- Card --}}
            {{-- @foreach ($reports as $report)     --}}
                <div class="bg-white rounded-lg shadow-lg p-4">
                    <div class="flex">
                        <img src="{{ asset('images/' . $report->image) }}" alt="Road Repair" class="w-1/2 h-64 object-cover rounded-lg">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold mb-2">{{ \Carbon\Carbon::parse($report->created_at)->locale('id')->translatedFormat('l, d F Y') }}</h3>
                            <p class="text-sm text-gray-600">
                                {{ $report->description }}
                            </p>
                            <div class="mt-2">
                                @if ($report->type == 'KEJAHATAN')
                                    <div class="inline-flex items-center px-2 py-1 bg-red-200 text-red-700 text-xs font-medium rounded-full">
                                        <span class="w-2 h-2 me-1 rounded-full bg-red-500"></span>
                                        Kejahatan
                                    </div>
                                @elseif ($report->type == 'PEMBANGUNAN')
                                    <div class="inline-flex items-center px-2 py-1 bg-yellow-200 text-yellow-700 text-xs font-medium rounded-full">
                                        <span class="w-2 h-2 me-1 rounded-full bg-yellow-500"></span>
                                        {{ $report->type }}
                                    </div>
                                @elseif ($report->type == 'SOSIAL')
                                    <div class="inline-flex items-center px-2 py-1 bg-green-200 text-green-700 text-xs font-medium rounded-full">
                                        <span class="w-2 h-2 me-1 rounded-full bg-green-500"></span>
                                        Sosial
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            {{-- @endforeach --}}

            <div class="bg-white rounded-lg shadow-lg p-4">
                <form action="{{ route('comments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="report_id" value="{{ $report->id }}"/>
                    <div class="mb-4 bg-gray-100 rounded-lg shadow-lg">
                        <div class="flex items-center justify-between px-4 py-2 border-b">
                            {{-- <div class="flex flex-wrap items-center divide-gray-200 sm:divide-x sm:rtl:divide-x-reverse dark:divide-gray-600">
                                <div class="flex items-center space-x-1 rtl:space-x-reverse sm:pe-4">
                                    <!-- Attach file button with Font Awesome -->
                                    <button type="button" class="p-2 text-white rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <i class="fas fa-paperclip w-4 h-4"></i>
                                        <span class="sr-only">Attach file</span>
                                    </button>
                                    <!-- Embed map button with Font Awesome -->
                                    <button type="button" class="p-2 text-white rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <i class="fas fa-map-marker-alt w-4 h-4"></i>
                                        <span class="sr-only">Embed map</span>
                                    </button>
                                    <!-- Upload image button with Font Awesome -->
                                    <button type="button" class="p-2 text-white rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <i class="fas fa-image w-4 h-4"></i>
                                        <span class="sr-only">Upload image</span>
                                    </button>
                                    <!-- Format code button with Font Awesome -->
                                    <button type="button" class="p-2 text-white rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <i class="fas fa-code w-4 h-4"></i>
                                        <span class="sr-only">Format code</span>
                                    </button>
                                    <!-- Add emoji button with Font Awesome -->
                                    <button type="button" class="p-2 text-white rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <i class="fas fa-smile w-4 h-4"></i>
                                        <span class="sr-only">Add emoji</span>
                                    </button>
                                </div>
                                <div class="flex flex-wrap items-center space-x-1 rtl:space-x-reverse sm:ps-4">
                                    <!-- Add list button with Font Awesome -->
                                    <button type="button" class="p-2 text-white rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <i class="fas fa-list w-4 h-4"></i>
                                        <span class="sr-only">Add list</span>
                                    </button>
                                    <!-- Settings button with Font Awesome -->
                                    <button type="button" class="p-2 text-white rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <i class="fas fa-cogs w-4 h-4"></i>
                                        <span class="sr-only">Settings</span>
                                    </button>
                                    <!-- Timeline button with Font Awesome -->
                                    <button type="button" class="p-2 text-white rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <i class="fas fa-clock w-4 h-4"></i>
                                        <span class="sr-only">Timeline</span>
                                    </button>
                                    <!-- Download button with Font Awesome -->
                                    <button type="button" class="p-2 text-white rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <i class="fas fa-download w-4 h-4"></i>
                                        <span class="sr-only">Download</span>
                                    </button>
                                </div>
                            </div>
                            <button type="button" data-tooltip-target="tooltip-fullscreen" class="p-2 text-white rounded cursor-pointer sm:ms-auto hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-600">
                                <i class="fas fa-expand-alt w-4 h-4"></i>
                                <span class="sr-only">Full screen</span>
                            </button> --}}
                            <h4 class="font-medium">Komentar</h4>
                        </div>
                        <div class="px-4 py-2 bg-gray-100 rounded-b-lg">
                            <textarea id="comment" name="comment" rows="8" class="block w-full px-0 text-sm text-gray-800 bg-gray-100 border-0 focus:outline-none" placeholder="Tulis komentar..." required></textarea>
                        </div>
                    </div>
                    <button type="submit" class="px-4 py-2 mb-6 inline-flex items-center text-sm font-medium text-center bg-blue-400 text-white rounded-lg focus:outline-none hover:bg-blue-500 transition ease-in-out duration-200">
                        Kirim
                    </button>
                 </form>

                 {{-- Comments --}}
                @foreach ($comments as $comment)
                    <div class="mb-6">
                        <h5 class="font-bold text-blue-500 text-sm">{{ $comment->user->email }}</h5>
                        <p class="text-gray-600 text-xs mb-2">{{ \Carbon\Carbon::parse($comment->created_at)->locale('id')->translatedFormat('d F Y') }}</p>
                        <p class="text-sm">{{ $comment->comment }}</p>
                    </div>
                @endforeach
                 
 
            </div>
        </div>

        {{-- Sidebar --}}
        <x-information></x-information>

        {{-- FAB --}}
        <x-fab></x-fab>
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