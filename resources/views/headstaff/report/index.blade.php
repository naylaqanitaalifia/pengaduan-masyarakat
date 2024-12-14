@extends('layouts.layout')

{{-- Navbar --}}
<x-navbar></x-navbar>

{{-- FAB --}}
<x-fab></x-fab>

{{-- Alert --}}
<x-alert></x-alert>

@section('content')
    {{-- Section Title --}}
    <div class="container mx-auto p-6">
        <div class="p-8 bg-white rounded-lg shadow-lg">
            <h2 class="mb-4 text-xl text-center font-medium">
                Jumlah Pengaduan dan Tanggapan Terhadap Pengaduan JAWA BARAT
            </h2>

            {{-- Grafik Area --}}
            <div class="flex justify-center">
                <!-- Tempat untuk grafik bar menggunakan Chart.js -->
                <canvas id="myChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    {{-- Tambahkan CDN Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Data dari Laravel (blade directive)
        const labels = @json($data['labels']); // Provinsi
        const totalReports = @json($data['total_reports']); // Jumlah pengaduan
        const totalResponses = @json($data['total_responses']); // Jumlah tanggapan

        // Inisialisasi grafik
        const ctx = document.getElementById('myChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Jumlah Pengaduan',
                        data: totalReports,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Jumlah Tanggapan',
                        data: totalResponses,
                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    tooltip: { 
                        mode: 'index', 
                        intersect: false 
                    }
                },
                scales: {
                    x: { beginAtZero: true },
                    y: { beginAtZero: true }
                }
            }
        });

        
    </script>
@endsection
