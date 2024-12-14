@if(Session::get('success'))    
    <div id="alertMessage" class="rounded-lg w-64 h-16 bg-blue-400 text-white fixed top-12 left-1/2 transform -translate-x-1/2 z-50 opacity-0 translate-y-[-30px] transition-all duration-500 ease-out">
        <div class="flex flex-row px-5  w-full gap-5 justify-center items-center h-full">
            <div class="my-auto text-md">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-circle" width="50" height="50">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <path d="m9 11 3 3L22 4"></path>
                </svg>
            </div>
            <div>
                <div class="font-bold text-md">{{ Session::get('success') }}</div>
            </div>
        </div>
    </div>
@endif
    
@if(Session::get('failed'))    
    <div id="alertMessage" class="rounded-lg w-52 h-16 bg-blue-400 text-white fixed top-12 left-1/2 transform -translate-x-1/2 z-50 opacity-0 translate-y-[-30px] transition-all duration-500 ease-out">
        <div class="flex flex-row w-full gap-5 justify-center items-center h-full">
            <div class="my-auto text-md">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-circle" width="50" height="50">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="m15 9-6 6"></path>
                    <path d="m9 9 6 6"></path>
                </svg>
            </div>
            <div>
                <div class="font-bold text-md">{{ Session::get('failed') }}</div>
            </div>
        </div>
    </div>
@endif

<script>
    $(document).ready(function() {
        $('#alertMessage').removeClass('opacity-0 translate-y-[-30px]').addClass('opacity-100 translate-y-0'); // Muncul dari atas

        // alert hilang  setelah 5 detik dengan animasi
        setTimeout(() => {
            $('#alertMessage').removeClass('opacity-100 translate-y-0').addClass('opacity-0 translate-y-[-30px]'); // Hilang ke atas
            setTimeout(() => {
                $('#alertMessage').remove(); // Menghapus elemen setelah transisi selesai
            }, 500); // Menunggu 500ms setelah transisi hilang
        }, 5000);
    });
</script>