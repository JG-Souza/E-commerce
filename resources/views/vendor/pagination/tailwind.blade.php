@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex justify-center">
        <ul class="inline-flex items-center -space-x-px">
            {{-- Link Anterior --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="px-3 py-2 ml-0 text-sm font-medium text-gray-400 cursor-not-allowed bg-gray-100 border border-gray-300 rounded-l-lg">
                        {{ __('Previous') }}
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-2 ml-0 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100">
                        {{ __('Previous') }}
                    </a>
                </li>
            @endif

            {{-- Paginação de páginas --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li>
                        <span class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300">{{ $element }}</span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <li>
                            <a href="{{ $url }}" class="px-3 py-2 text-sm font-medium {{ $page == $paginator->currentPage() ? 'bg-blue-600 text-white' : 'text-gray-500 hover:bg-gray-100' }} border border-gray-300 rounded">
                                {{ $page }}
                            </a>
                        </li>
                    @endforeach
                @endif
            @endforeach

            {{-- Link Próximo --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100">
                        {{ __('Next') }}
                    </a>
                </li>
            @else
                <li>
                    <span class="px-3 py-2 text-sm font-medium text-gray-400 cursor-not-allowed bg-gray-100 border border-gray-300 rounded-r-lg">
                        {{ __('Next') }}
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif

