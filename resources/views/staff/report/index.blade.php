@extends('layouts.layout')

@section('content')
    {{-- Navbar --}}
    <x-navbar></x-navbar>

    {{-- FAB --}}
    <x-fab></x-fab>

    {{-- Alert --}}
    <x-alert></x-alert>

    {{-- Table --}}
    <div class="p-8">
        <div class="flex justify-end mb-4">
            <div class="relative inline-block text-left">
                <button type="button" class="px-4 py-2 bg-blue-400 text-white font-medium rounded-lg hover:bg-blue-500 focus:outline-none" id="exportDropdownButton">
                    Export
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="exportDropdown" class="absolute right-0 mt-2 w-56 hidden bg-white border rounded-lg shadow-lg z-50">
                    <div class="py-1">
                        <form action="{{ route('report.export-all') }}" method="GET" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                            <button type="submit" class="w-full text-left">Semua Data</button>
                        </form>
                        <button id="filterByDate" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 w-full text-left">Berdasarkan Tanggal</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto shadow-md rounded-lg">
            <table class="w-full text-left border-collapse text-sm">
                <thead class="bg-white uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">Gambar & Pengirim</th>
                        <th class="px-6 py-3">Lokasi & Tanggal</th>
                        <th class="px-6 py-3">Deskripsi</th>
                        <th class="px-6 py-3">
                            Jumlah Vote
                            <button id="sortAsc" class="ml-2">
                                <a href="{{ route('report.index', ['sort' => 'voting', 'order' => 'asc']) }}">
                                    <i class="fa-solid fa-sort-up"></i>
                                </a>
                            </button>
                            <button id="sortDesc" class="ml-2">
                                <a href="{{ route('report.index', ['sort' => 'voting', 'order' => 'desc']) }}">
                                    <i class="fa-solid fa-sort-down"></i>
                                </a>
                            </button>
                        </th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reports as $report)
                        <tr class="bg-white border-b hover:bg-gray-50 transition ease-in-out duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <a href="#" class="openImageModal" data-id="{{ $report->id }}" data-image="{{ asset('images/' . $report->image) }}">
                                        <img src="{{ asset('images/' . $report->image) }}" alt="Image" class="w-12 h-12 object-cover rounded-full cursor-pointer">
                                    </a>
                                    <div class="ml-4">
                                        <p class="text-blue-400">{{ $report->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-500">
                                    {{ $report->village }},
                                    {{ $report->subdistrict }},
                                    {{ $report->regency }},
                                    {{ $report->province }} |
                                    {{ \Carbon\Carbon::parse($report->created_at)->locale('id')->translatedFormat('d F Y') }}
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="truncate" style="max-width: 200px">
                                    {{ $report->description }}
                                </p>
                            </td>
                            <td class="px-6 py-4 text-center">{{ $report->voting }} votes</td>
                            <td class="px-6 py-4">
                                <div class="relative inline-block text-left">
                                    <button type="button" class="dropdownMenuButton bg-blue-400 text-white px-4 py-2 rounded-lg hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-400 transition ease-in-out duration-200" aria-expanded="false">
                                        Aksi
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                                        <div class="py-1">
                                            <button type="button" class="buttonModal block px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 w-full" data-id="{{ $report->id }}">
                                                Tindak lanjut
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Date Modal --}}
    <div id="dateFilterModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-96">
            <h2 class="text-lg font-bold mb-4">Export Berdasarkan Tanggal</h2>
            <form action="{{ route('report.export-date') }}" method="GET">
                <div class="mb-4">
                    <label for="selected_date" class="block text-sm font-medium text-gray-700">Pilih Tanggal</label>
                    <input type="date" id="selected_date" name="selected_date" class="w-full mt-2 p-2 border rounded-lg" required>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" id="closeDateModal" class="px-4 py-2 text-black rounded-lg hover:bg-gray-400 hover:text-white">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-400 text-white rounded-lg hover:bg-blue-500">Export</button>
                </div>
            </form>
        </div>
    </div>
    
    {{-- Image Modal --}}
    <div id="imageModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-96">
            <div class="flex justify-between">
                <h2 class="text-lg font-medium mb-4">Detail Gambar</h2>
                <i id="closeImageModal" class="fa-solid fa-xmark text-gray-600 text-xl hover:text-gray-700"></i>
            </div>
            <img id="modalImage" src="" alt="Detail Image" class="w-full h-auto mb-4">
            {{-- <span id="closeImageModal" class="absolute top-2 right-2 text-black cursor-pointer text-xl">&times;</span> --}}
        </div>
    </div>

    {{-- Modal --}}
    <div id="responseModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-96">
            <h2 class="text-lg font-bold mb-4">Tindak Lanjut</h2>
            <form id="responseForm" action="{{ route('response.report.store', ['id' => $report->id]) }}" method="POST">
                @csrf
                <input type="hidden" name="report_id" id="reportId" value="{{ $report->id }}">
                <p id="reportDescription" class="mb-4 text-gray-700"></p>
                <div class="mb-4">
                    <label for="response_status" class="block text-sm font-medium text-gray-700">Tanggapan</label>
                    <select id="response_status" name="response_status" class="w-full mt-2 p-2 border rounded-lg">
                        <option value="REJECT">Tolak</option>
                        <option value="ON_PROCESS">Proses Penyelesaian/Perbaikan</option>
                    </select>
                </div>
                {{-- <div class="mb-4 hidden" id="responseField">
                    <label for="response" class="block text-sm font-medium text-gray-700">Tanggapan</label>
                    <textarea id="response" name="response" class="w-full mt-2 p-2 border rounded-lg" placeholder="Masukkan tanggapan..."></textarea>
                </div> --}}
                <div class="flex justify-end space-x-2">
                    <button type="button" id="closeModal" class="px-4 py-2 text-black rounded-lg hover:bg-gray-400 hover:text-white">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-400 text-white rounded-lg hover:bg-blue-500">Kirim</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            var today = new Date().toISOString().split('T')[0];
            document.getElementById('selected_date').setAttribute('max', today);
            // export
            $('#exportDropdownButton').click(function (e) {
                e.stopPropagation();
                $('#exportDropdown').toggleClass('hidden');
            });

            $(document).click(function () {
                $('#exportDropdown').addClass('hidden');
            });

            // dropdown
            $('.absolute').addClass('hidden');
            $('.dropdownMenuButton').click(function (e) {
                e.stopPropagation();
                $(this).next('.absolute').toggleClass('hidden');
            })

            $('.openImageModal').on('click', function(e) {
                e.preventDefault();
                var imageUrl = $(this).data('image');
                var reportId = $(this).data('id');

                // Set the image source and show the modal
                $('#modalImage').attr('src', imageUrl);
                $('#imageModal').removeClass('hidden');
            });

            // Close the image modal
            $('#closeImageModal').on('click', function() {
                $('#imageModal').addClass('hidden');
            });

            $(document).click(function () {
                $('.absolute').addClass('hidden');
            })

            $('.buttonModal').click(function() {
    const reportId = $(this).data('id');
    $('#responseForm').attr('action', `/response/report/${reportId}/response`);
    $('#responseModal').removeClass('hidden');
});


            $('#closeModal').click(function() {
                $('#responseModal').addClass('hidden');
            })

            // Show modal for filter by date
            $('#filterByDate').click(function () {
                $('#dateFilterModal').removeClass('hidden');
            });

            // Close modal
            $('#closeDateModal').click(function () {
                $('#dateFilterModal').addClass('hidden');
            });
        })
    </script>
@endsection
