@extends('layouts.layout')

@section('content')
    {{-- Navbar --}}
    <x-navbar></x-navbar>

    {{-- FAB --}}
    <x-fab></x-fab>

    <div class="p-8">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between">
                <h2 class="text-lg font-bold text-gray-700 mb-4">{{ $report->user->email }}</h2>
                <a href="{{ route('report.index') }}">
                    <i class="fa-solid fa-arrow-left-long"></i>
                </a>
            </div>
            <p class="text-sm text-gray-500">
                {{ \Carbon\Carbon::parse($report->created_at)->locale('id')->translatedFormat('d F Y') }}
                @if ($report->response->isNotEmpty())
                    @if ($report->response->first()->response_status == 'ON_PROCESS')
                        | <span class="font-semibold text-yellow-500">{{ $report->response->first()->response_status }}</span>
                    @elseif ($report->response->first()->response_status == 'REJECT')
                        | <span class="font-semibold text-red-500">{{ $report->response->first()->response_status }}</span>
                    @elseif ($report->response->first()->response_status == 'DONE')
                    | <span class="font-semibold text-green-500">{{ $report->response->first()->response_status }}</span>
                    @endif
                @else
                    | <span class="font-semibold text-blue-500">Tidak ada status respon</span>
                @endif
            </p>
            
            <div class="bg-white border rounded-lg shadow-lg p-6 mt-4">
                {{-- Lokasi --}}
                <h3 class="text-base font-semibold text-gray-700 uppercase">
                    {{ $report->village }}, 
                    {{ $report->subdistrict }},
                    {{ $report->regency }}, 
                    {{ $report->province }}
                </h3>
                
                {{-- Deskripsi --}}
                <p class="mt-2 text-sm text-gray-600">
                    {{ $report->description }}
                </p>
                
                {{-- Gambar --}}
                <div class="mt-4">
                    <img src="{{ asset('images/' . $report->image) }}" alt="Gambar Laporan" class="rounded-lg shadow-md w-64">
                </div>
            </div>

            {{-- Riwayat Progress --}}
            <div class="mt-6">
                <h4 class="text-sm font-semibold text-gray-700">Riwayat Progress</h4>
                @if ($report->progress->isEmpty())
                    <p class="mt-2 text-sm text-gray-500">Belum ada riwayat progress perbaikan/penyelesaian apapun.</p>
                @else
                    <ul class="mt-2 space-y-2">
                        @foreach ($report->progress as $progress)
                            @foreach (json_decode($progress->histories) as $history)
                                <div class="py-1">
                                    <div class="mx-auto">
                                        <!-- Timeline -->
                                        <div class="border-l-4 border-gray-300 pl-4">
                                            <div class="flex items-center">
                                                <div class="w-4 h-4 bg-yellow-500 rounded-full flex-shrink-0"></div>
                                                <div class="ml-4">
                                                    <li class="text-sm text-gray-600 cursor-pointer" data-history="{{ json_encode($history) }}">
                                                        {{ $history->timestamp }} - {{ $history->note }}
                                                    </li>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- Aksi --}}
            @if ($report->response_status != 'DONE')
                <div class="flex justify-end mt-6 space-x-4">
                    <form action="{{ route('response.report.completed', ['id' => $report->id]) }}" method="POST">
                        @csrf
                        <button class="px-4 py-2 bg-green-500 text-white font-medium rounded-lg hover:bg-green-600">
                            Nyatakan Selesai
                        </button>
                    </form>
                    <button id="openProgressModal" class="px-4 py-2 bg-blue-500 text-white font-medium rounded-lg hover:bg-blue-600">
                        Tambah Progress
                    </button>
                </div>
            @endif
        </div>
    </div>

    {{-- Progress Modal --}}
    <div id="progressModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white rounded-lg p-6 w-5/12">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Progres Tindak Lanjut</h3>
            <form action="{{ route('response.progress.store', ['id' => $report->id]) }}" method="POST">
                @csrf
                <input type="hidden" name="response_id" value="{{ $response->id }}">
                <textarea name="histories" class="w-full p-4 border border-gray-300 rounded-lg" rows="4" placeholder="Deskripsi progres"></textarea>
                <div class="mt-4 flex justify-end space-x-4">
                    <button type="button" id="closeProgressModal" class="px-4 py-2 bg-gray-300 text-black font-medium rounded-lg hover:bg-gray-400">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white font-medium rounded-lg hover:bg-blue-600">
                        Buat
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="detailProgressModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white rounded-lg p-6 w-5/12">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Hapus Pengaduan</h3>
            {{-- <form action="{{ route('response.report.destroy', ['id' => $progress->id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <div id="detailProgressContent">
                    <!-- Konten detail progress akan dimuat di sini -->
                </div>
                <div class="mt-4 flex justify-end space-x-4">
                    <button id="closeDetailProgressModal" class="px-4 py-2 bg-gray-300 text-black font-medium rounded-lg hover:bg-gray-400">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white font-medium rounded-lg hover:bg-red-600">
                        Hapus
                    </button>
                </div>
            </form> --}}
        </div>
    </div>
    
    <script>
        $('#openProgressModal').click(function() {
            $('#progressModal').removeClass('hidden');
        });

        // Close modal when "Batal" button is clicked
        $('#closeProgressModal').click(function() {
            $('#progressModal').addClass('hidden');
        });

        $('ul li').on('click', function () {
            // Ambil data dari atribut `data-history`
            const history = $(this).data('history');

            // Muat detail ke dalam modal
            const detailContent = `
                <p class="text-sm text-gray-600 mt-2">
                    Apakah Anda yakin ingin menghapus pengaduan pada tanggal <b>${history.timestamp}</b>?
                </p>
            `;
            $('#detailProgressContent').html(detailContent);

            // Tampilkan modal
            $('#detailProgressModal').removeClass('hidden');
        });

        // Klik tombol "Tutup" untuk menutup modal
        $('#closeDetailProgressModal').on('click', function () {
            $('#detailProgressModal').addClass('hidden');
        });
    </script>
@endsection