
<div class="fixed bottom-8 right-8 p-4 text-white flex flex-col space-y-8">
    @auth
        @if (auth()->user()->role == 'GUEST')
            <a href="{{ route('report.articles') }}" class="bg-blue-400 w-16 h-16 rounded-full flex items-center justify-center hover:bg-transparent hover:text-blue-400 hover:border-blue-400 hover:border-2 transition-all duration-300">
                <i class="fa-solid fa-house"></i>
            </a>
            <a href="{{ route('report.me') }}" class="bg-blue-400 w-16 h-16 rounded-full flex items-center justify-center hover:bg-transparent hover:text-blue-400 hover:border-blue-400 hover:border-2 transition-all duration-300">
                <i class="fa-solid fa-exclamation"></i>
            </a>
            <a href="{{ route('report.create') }}" class="bg-blue-400 w-16 h-16 rounded-full flex items-center justify-center hover:bg-transparent hover:text-blue-400 hover:border-blue-400 hover:border-2 transition-all duration-300">
                <i class="fa-solid fa-pen"></i>
            </a>
        @elseif (auth()->user()->role == 'STAFF')
            <a href="{{ route('report.index') }}" class="bg-blue-400 w-16 h-16 rounded-full flex items-center justify-center hover:bg-transparent hover:text-blue-400 hover:border-blue-400 hover:border-2 transition-all duration-300">
                <i class="fa-solid fa-house"></i>
            </a>
            <a href="{{ route('response.report') }}" class="bg-blue-400 w-16 h-16 rounded-full flex items-center justify-center hover:bg-transparent hover:text-blue-400 hover:border-blue-400 hover:border-2 transition-all duration-300">
                <i class="fa-solid fa-exclamation"></i>
            </a>
        @elseif (auth()->user()->role == 'HEAD_STAFF')
            <a href="{{ route('report.dashboard') }}" class="bg-blue-400 w-16 h-16 rounded-full flex items-center justify-center hover:bg-transparent hover:text-blue-400 hover:border-blue-400 hover:border-2 transition-all duration-300">
                <i class="fa-solid fa-exclamation"></i>
            </a>
            <a href="{{ route('user.user') }}" class="bg-blue-400 w-16 h-16 rounded-full flex items-center justify-center hover:bg-transparent hover:text-blue-400 hover:border-blue-400 hover:border-2 transition-all duration-300">
                <i class="fa-solid fa-pen"></i>
            </a>
        @endif
    @else
        <a href="{{ route('login') }}" class="bg-blue-400 w-16 h-16 rounded-full flex items-center justify-center hover:bg-transparent hover:border-blue-400 hover:border-2 hover:transition-all duration-300">
            <i class="fa-solid fa-user"></i>
        </a>
        <a href="{{ route('report.me') }}" class="bg-blue-400 w-16 h-16 rounded-full flex items-center justify-center hover:bg-transparent hover:border-blue-400 hover:border-2 transition-all duration-300">
            <i class="fa-solid fa-exclamation"></i>
        </a>
        <a href="{{ route('report.create') }}" class="bg-blue-400 w-16 h-16 rounded-full flex items-center justify-center hover:bg-transparent hover:border-blue-400 hover:border-2 transition-all duration-300">
            <i class="fa-solid fa-pen"></i>
        </a>
    @endauth
</div>
