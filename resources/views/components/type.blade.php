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