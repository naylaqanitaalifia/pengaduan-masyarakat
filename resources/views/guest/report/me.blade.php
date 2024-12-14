@extends('layouts.layout')

@section('content')

{{-- Navbar --}}
<x-navbar></x-navbar>

{{-- FAB --}}
<x-fab></x-fab>

{{-- Alert --}}
<x-alert></x-alert>

<div class="container mx-auto p-6">
    @foreach ($reports as $index => $report)
    <div class="max-w-4xl mx-auto my-6 p-6 bg-white rounded-lg shadow-xl border-l-4 border-blue-600">
        <div class="accordion-header cursor-pointer flex justify-between items-center" data-index="{{ $index }}">
            <h2 class="text-xl font-bold text-gray-800">Pengaduan {{ \Carbon\Carbon::parse($report->created_at)->locale('id')->translatedFormat('l, d F Y') }}</h2>
            <span class="text-gray-600">
                <i class="fas fa-chevron-down"></i>
            </span>
        </div>

        <div class="accordion-content mt-5 hidden">
            <div class="flex justify-between border-b border-gray-300">
                <div 
                    class="text-gray-800 py-2 px-4 cursor-pointer tab-button" 
                    data-tab="data-{{ $index }}">Data</div>
                <div 
                    class="text-gray-800 py-2 px-4 cursor-pointer tab-button" 
                    data-tab="gambar-{{ $index }}">Gambar</div>
                <div 
                    class="text-gray-800 py-2 px-4 cursor-pointer tab-button" 
                    data-tab="status-{{ $index }}">Status</div>
            </div>

            <!-- Tab Content: Data -->
            <div id="data-{{ $index }}" class="tab-content mt-5 p-5 bg-gray-100 rounded-lg hidden">
                <div class="space-y-3">
                    <p class="text-gray-700"><b class="text-blue-600">Tipe:</b> {{ $report->type }}</p>
                    <p class="text-gray-700"><b class="text-blue-600">Lokasi:</b> {{ $report->province }}, {{ $report->regency }}, {{ $report->subdistrict }}, {{ $report->village }}</p>
                    <p class="text-gray-700"><b class="text-blue-600">Deskripsi:</b> {{ $report->description }}</p>
                </div>
            </div>

            <!-- Tab Content: Gambar -->
            <div id="gambar-{{ $index }}" class="tab-content mt-5 p-5 bg-gray-100 rounded-lg hidden">
                <img src="{{ asset('images/' . $report->image) }}" alt="Gambar Pengaduan" class="w-full rounded-md">
            </div>

            <!-- Tab Content: Status -->
            <div id="status-{{ $index }}" class="tab-content mt-5 p-5 bg-gray-100 rounded-lg hidden">
                @if ($report->response()->exists())
                    <p class="text-gray-700 mb-2">Pengaduan telah ditanggapi, dengan status: ini blm dibenerin</p>
                    @if ($report->progress->isNotEmpty())
                        <ul>
                            @foreach ($report->progress as $progress)
                                @if (!empty($progress->histories))
                                    @foreach (json_decode($progress->histories) as $history)
                                        {{-- <li data-history="{{ json_encode($history) }}">
                                            {{ $history->timestamp }} - {{ $history->note }}
                                        </li> --}}
                                        <div class="mx-auto">
                                            <!-- Timeline -->
                                            <div class="border-l-4 border-gray-300 pl-4">
                                                <div class="flex items-center">
                                                    <li data-history="{{ json_encode($history) }}">
                                                        {{ $history->timestamp }} - {{ $history->note }}
                                                    </li>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            @endforeach
                        </ul>
                    @endif
                @else
                <div class="flex items-center">
                    <p class="text-gray-700">
                        Pengaduan belum direspon petugas, ingin menghapus data pengaduan?
                    </p>
                    <button type="button" class="openDeleteReportModal text-red-500 px-4 py-2 rounded-lg hover:text-red-600 focus:outline-none" data-id="{{ $report->id }}" 
                        data-date="{{ \Carbon\Carbon::parse($report->created_at)->locale('id')->translatedFormat('d F Y') }}">
                        Hapus
                    </button>                    
                </div>
                @endif

            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Modal Delete -->
<div id="detailReportModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white rounded-lg p-6 w-5/12">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Hapus Pengaduan</h3>
        
        <!-- Form hapus laporan -->
        <form method="POST" action="{{ route('report.destroy', ['id' => $report->id]) }}" class="">
            @csrf
            @method('DELETE')
            <p id="deleteMessage" class="text-gray-700 mb-4">
                Apakah Anda yakin ingin menghapus pengaduan pada tanggal {{ \Carbon\Carbon::parse($report->created_at)->locale('id')->translatedFormat('d F Y') }}?
            </p>
            <div class="mt-4 flex justify-end space-x-4">
                <button type="button" id="closeModal" class="px-4 py-2 bg-gray-300 text-black font-medium rounded-lg hover:bg-gray-400">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-red-500 text-white font-medium rounded-lg hover:bg-red-600">
                    Hapus
                </button>
            </div>
        </form>
    </div>
</div>



{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script>
    $(document).ready(function() {
        // Accordion toggle
        $('.accordion-header').on('click', function() {
            $(this).next('.accordion-content').toggleClass('hidden');
        });

        // Tab switching
        $('.tab-button').on('click', function() {
            const tabId = $(this).data('tab');
            const parentContent = $(this).closest('.accordion-content');

            // Hide all tab contents within the current accordion
            parentContent.find('.tab-content').addClass('hidden');

            // Show the selected tab content
            parentContent.find(`#${tabId}`).removeClass('hidden');

            // Highlight the active tab
            parentContent.find('.tab-button').removeClass('bg-gray-100 text-black rounded-lg').addClass('text-gray-800');
            $(this).addClass('bg-gray-100 text-black rounded-lg').removeClass('text-gray-800');
        });

        $('.openDeleteReportModal').on('click', function() {
    var reportId = $(this).data('id');
    var formAction = "{{ route('report.destroy', ':id') }}".replace(':id', reportId);
    
    // Update form action di dalam modal
    $('#detailReportModal form').attr('action', formAction);
    
    // Update pesan di modal
    $('#deleteMessage').text("Apakah Anda yakin ingin menghapus pengaduan pada tanggal " + $(this).data('date') + "?");
    
    // Tampilkan modal
    $('#detailReportModal').removeClass('hidden');
});


        $('button[data-id]').on('click', function() {
            var reportId = $(this).data('id');
            var formAction = "{{ route('report.destroy', ':id') }}".replace(':id', reportId); // Mengganti :id dengan ID laporan
            $('#deleteReportForm').attr('action', formAction);
            $('#deleteMessage').text("Apakah Anda yakin ingin menghapus laporan ini?");
            $('#detailReportModal').removeClass('hidden');
        });

        // Close modal
        $('#closeModal').on('click', function() {
            $('#detailReportModal').addClass('hidden');
        });
    });
</script>
@endsection
