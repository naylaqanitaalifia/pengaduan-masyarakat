<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Keluhan</title>
    @vite('resources/css/app.css')
    <!-- CDN Jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-100">

    {{-- Navbar --}}
    <x-navbar></x-navbar>

    @if ($errors->any())
        <div class="bg-red-100 text-red-500 p-4 mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Content -->
    <div class="container mx-auto px-6 py-16">
        <div class="bg-white shadow-md rounded-xl overflow-hidden p-8 max-w-3xl mx-auto">
            <h1 class="text-2xl font-bold text-blue-600 mb-6">Tambah Keluhan</h1>
            <form action="{{ route('report.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <!-- Provinsi -->
                <div>
                    <label for="province" class="block text-sm font-medium text-gray-700">Provinsi*</label>
                    <select id="province" name="province" class="mt-1 px-2 py-2 block w-full rounded-md border border-gray-300 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-blue-500" required>
                       <option hidden selected disabled>Pilih</option>
                    </select>
                </div>

                <!-- Kota/Kabupaten -->
                <div>
                    <label for="regency" class="block text-sm font-medium text-gray-700">Kota/Kabupaten*</label>
                    <select id="regency" name="regency" class="mt-1 px-2 py-2 block w-full rounded-md border border-gray-300 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-blue-500" required>
                        <option hidden selected disabled>Pilih</option>
                    </select>
                </div>

                <!-- Kecamatan -->
                <div>
                    <label for="subdistrict" class="block text-sm font-medium text-gray-700">Kecamatan*</label>
                    <select id="subdistrict" name="subdistrict" class="mt-1 px-2 py-2 block w-full rounded-md border border-gray-300 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-blue-500" required>
                        <option hidden selected disabled>Pilih</option>
                    </select>
                </div>

                <!-- Kelurahan -->
                <div>
                    <label for="village" class="block text-sm font-medium text-gray-700">Kelurahan*</label>
                    <select id="village" name="village" class="mt-1 px-2 py-2 block w-full rounded-md border border-gray-300 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-blue-500" required>
                        <option hidden selected disabled>Pilih</option>
                    </select>
                </div>

                <!-- Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Type*</label>
                    <select id="type" name="type" class="mt-1 px-2 py-2 block w-full rounded-md border border-gray-300 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-blue-500" required>
                        <option hidden selected disabled>Pilih</option>
                        <option value="KEJAHATAN">Kejahatan</option>
                        <option value="PEMBANGUNAN">Pembangunan</option>
                        <option value="SOSIAL">Sosial</option>
                    </select>
                </div>

                <!-- Detail Keluhan -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Detail Keluhan*</label>
                    <textarea id="description" name="description" rows="4" class="mt-1 px-2 block w-full rounded-md border border-gray-300 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-blue-500" required></textarea>
                </div>

                <!-- Gambar Pendukung -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">Gambar Pendukung*</label>
                    <input type="file" id="image" name="image" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <!-- Checkbox -->
                <input type="hidden" name="statement" value="0">
                <input 
                    id="statement" 
                    name="statement" 
                    type="checkbox" 
                    value="1" 
                    class="h-4 w-4 text-blue-600 border border-gray-300 rounded focus:ring-blue-500"
                    {{ old('statement') ? 'checked' : '' }} 
                >
                <label for="statement" class="ml-2 text-sm text-gray-700">Laporan yang disampaikan sesuai dengan kebenaran.</label>

                <!-- Submit Button -->
                <div>
                    <button type="submit" id="submit-btn" class="w-full bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500" disabled>
                        Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            const setOptions = (id, data, element) => {
                $(id).empty().append('<option hidden selected disabled>Pilih</option>');
                data.forEach(item => {
                    $(id).append(`<option value="${item.id}" data-name="${item.name}">${item.name}</option>`);
                });
            };

            const fetchData = (url, callback) => {
                $.ajax({ method: "GET", url, dataType: "json", success: callback, error: err => alert(err) });
            };

            fetchData("https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json", response => {
                setOptions('#province', response);
            });

            $('#province').change(function () {
                fetchData(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${$(this).val()}.json`, response => {
                    setOptions('#regency', response);
                });
            });

            $('#regency').change(function() {
                fetchData(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${$(this).val()}.json`, response => {
                    setOptions('#subdistrict', response);
                });
            });

            $('#subdistrict').change(function() {
                fetchData(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${$(this).val()}.json`, response => {
                    setOptions('#village', response);
                });
            });

            $('#statement').on('change', function() {
                $('#submit-btn').prop('disabled', !this.checked);
            });

            $('form').submit(function(event) {
                event.preventDefault();
                const provinceName = $('#province option:selected').data('name');
                const regencyName = $('#regency option:selected').data('name');
                const subdistrictName = $('#subdistrict option:selected').data('name');
                const villageName = $('#village option:selected').data('name');

                $(this).append(`<input type="hidden" name="province_name" value="${provinceName}">`);
                $(this).append(`<input type="hidden" name="regency_name" value="${regencyName}">`);
                $(this).append(`<input type="hidden" name="subdistrict_name" value="${subdistrictName}">`);
                $(this).append(`<input type="hidden" name="village_name" value="${villageName}">`);
                this.submit();
            });
        });
    </script>
</body>
</html>
