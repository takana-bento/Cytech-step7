@if ($paginator->hasPages())
    <nav class="mt-6 flex justify-center space-x-1">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1 bg-gray-200 rounded">&laquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400">&laquo;</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-3 py-1">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-1 bg-orange-400 rounded text-white">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400">&raquo;</a>
        @else
            <span class="px-3 py-1 bg-gray-200 rounded">&raquo;</span>
        @endif
    </nav>
@endif
