@php
    $direction = config('ui.direction', 'ltr');
    $isRtl = $direction === 'rtl';
@endphp

<nav class="flex items-center space-x-2 {{ $isRtl ? 'space-x-reverse' : '' }}" aria-label="Breadcrumb">
    @foreach($items as $index => $item)
        @if($index > 0)
            <!-- Arrow -->
            <svg class="w-4 h-4 text-gray-900 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="{{ $isRtl ? 'M15 19l-7-7 7-7' : 'M9 5l7 7-7 7' }}"></path>
            </svg>
        @endif

        @if(isset($item['url']) && !isset($item['active']))
            <!-- Link Item -->
            <a href="{{ $item['url'] }}" class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 transition-all duration-200 group">
                @if(isset($item['icon']))
                <svg class="w-4 h-4 {{ $isRtl ? 'ml-1.5' : 'mr-1.5' }} text-gray-500 group-hover:text-gray-700 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    {!! $item['icon'] !!}
                </svg>
                @endif
                <span>{{ $item['label'] }}</span>
            </a>
        @else
            <!-- Current Page (Active) -->
            <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium text-gray-900 bg-gray-200">
                @if(isset($item['icon']))
                <svg class="w-4 h-4 {{ $isRtl ? 'ml-1.5' : 'mr-1.5' }} text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    {!! $item['icon'] !!}
                </svg>
                @endif
                <span>{{ $item['label'] }}</span>
            </span>
        @endif
    @endforeach
</nav>

