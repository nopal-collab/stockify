@if ($paginator->hasPages())

    <nav role="navigation"
         aria-label="{{ __('Pagination Navigation') }}"
         class="flex items-center justify-between">

        {{-- MOBILE --}}
        <div class="flex justify-between flex-1 sm:hidden">

            {{-- PREVIOUS --}}
            @if ($paginator->onFirstPage())

                <span class="relative inline-flex items-center px-4 py-2
                             text-sm font-medium text-gray-400
                             bg-white dark:bg-gray-800
                             border border-gray-300 dark:border-gray-700
                             cursor-default rounded-md">

                    {!! __('pagination.previous') !!}

                </span>

            @else

                <a href="{{ $paginator->previousPageUrl() }}"
                   class="relative inline-flex items-center px-4 py-2
                          text-sm font-medium text-gray-700 dark:text-gray-200
                          bg-white dark:bg-gray-800
                          border border-gray-300 dark:border-gray-700
                          rounded-md hover:bg-gray-50 dark:hover:bg-gray-700">

                    {!! __('pagination.previous') !!}

                </a>

            @endif

            {{-- NEXT --}}
            @if ($paginator->hasMorePages())

                <a href="{{ $paginator->nextPageUrl() }}"
                   class="relative inline-flex items-center px-4 py-2 ml-3
                          text-sm font-medium text-gray-700 dark:text-gray-200
                          bg-white dark:bg-gray-800
                          border border-gray-300 dark:border-gray-700
                          rounded-md hover:bg-gray-50 dark:hover:bg-gray-700">

                    {!! __('pagination.next') !!}

                </a>

            @else

                <span class="relative inline-flex items-center px-4 py-2 ml-3
                             text-sm font-medium text-gray-400
                             bg-white dark:bg-gray-800
                             border border-gray-300 dark:border-gray-700
                             cursor-default rounded-md">

                    {!! __('pagination.next') !!}

                </span>

            @endif

        </div>

        {{-- DESKTOP --}}
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">

            <div>

                <p class="text-sm text-gray-700 dark:text-gray-300 leading-5">

                    Showing

                    <span class="font-medium">
                        {{ $paginator->firstItem() }}
                    </span>

                    to

                    <span class="font-medium">
                        {{ $paginator->lastItem() }}
                    </span>

                    of

                    <span class="font-medium">
                        {{ $paginator->total() }}
                    </span>

                    results

                </p>

            </div>

            <div>

                <span class="relative z-0 inline-flex rounded-md shadow-sm">

                    {{-- PREVIOUS --}}
                    @if ($paginator->onFirstPage())

                        <span aria-disabled="true"
                              aria-label="{{ __('pagination.previous') }}">

                            <span class="relative inline-flex items-center px-2 py-2
                                         text-sm font-medium text-gray-400
                                         bg-white dark:bg-gray-800
                                         border border-gray-300 dark:border-gray-700
                                         cursor-default rounded-l-md">

                                ‹

                            </span>

                        </span>

                    @else

                        <a href="{{ $paginator->previousPageUrl() }}"
                           rel="prev"
                           class="relative inline-flex items-center px-2 py-2
                                  text-sm font-medium text-gray-500 dark:text-gray-300
                                  bg-white dark:bg-gray-800
                                  border border-gray-300 dark:border-gray-700
                                  rounded-l-md hover:bg-gray-50 dark:hover:bg-gray-700">

                            ‹

                        </a>

                    @endif

                    {{-- PAGE NUMBERS --}}
                    @foreach ($elements as $element)

                        {{-- SEPARATOR --}}
                        @if (is_string($element))

                            <span aria-disabled="true">

                                <span class="relative inline-flex items-center px-4 py-2
                                             text-sm font-medium text-gray-700 dark:text-gray-300
                                             bg-white dark:bg-gray-800
                                             border border-gray-300 dark:border-gray-700">

                                    {{ $element }}

                                </span>

                            </span>

                        @endif

                        {{-- ARRAY --}}
                        @if (is_array($element))

                            @foreach ($element as $page => $url)

                                @if ($page == $paginator->currentPage())

                                    <span aria-current="page">

                                        <span class="relative inline-flex items-center px-4 py-2
                                                     text-sm font-bold text-white
                                                     bg-blue-500 border border-blue-500">

                                            {{ $page }}

                                        </span>

                                    </span>

                                @else

                                    <a href="{{ $url }}"
                                       class="relative inline-flex items-center px-4 py-2
                                              text-sm font-medium
                                              text-gray-700 dark:text-gray-300
                                              bg-white dark:bg-gray-800
                                              border border-gray-300 dark:border-gray-700
                                              hover:bg-gray-50 dark:hover:bg-gray-700">

                                        {{ $page }}

                                    </a>

                                @endif

                            @endforeach

                        @endif

                    @endforeach

                    {{-- NEXT --}}
                    @if ($paginator->hasMorePages())

                        <a href="{{ $paginator->nextPageUrl() }}"
                           rel="next"
                           class="relative inline-flex items-center px-2 py-2
                                  text-sm font-medium text-gray-500 dark:text-gray-300
                                  bg-white dark:bg-gray-800
                                  border border-gray-300 dark:border-gray-700
                                  rounded-r-md hover:bg-gray-50 dark:hover:bg-gray-700">

                            ›

                        </a>

                    @else

                        <span aria-disabled="true"
                              aria-label="{{ __('pagination.next') }}">

                            <span class="relative inline-flex items-center px-2 py-2
                                         text-sm font-medium text-gray-400
                                         bg-white dark:bg-gray-800
                                         border border-gray-300 dark:border-gray-700
                                         cursor-default rounded-r-md">

                                ›

                            </span>

                        </span>

                    @endif

                </span>

            </div>

        </div>

    </nav>

@endif