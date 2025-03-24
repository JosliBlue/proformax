@unless ($breadcrumbs->isEmpty())
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            @foreach ($breadcrumbs as $breadcrumb)
                @if ($loop->first)
                    <li class="inline-flex items-center">
                        <a href="{{ $breadcrumb->url }}"
                            class="group inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            <span class="iconify w-5 h-5 text-gray-700 group-hover:text-blue-600 mr-1"
                                data-icon="ic:round-home"></span>
                            {{ $breadcrumb->title }}
                        </a>
                    </li>
                @elseif (!$loop->last)
                    <li>
                        <div class="flex items-center">
                            <span class="iconify w-6 h-6 text-gray-400" data-icon="weui:arrow-filled"></span>
                            <a href="{{ $breadcrumb->url }}"
                                class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2">{{ $breadcrumb->title }}</a>
                        </div>
                    </li>
                @else
                    <li aria-current="page">
                        <div class="flex items-center">
                            <span class="iconify w-6 h-6 text-gray-400" data-icon="weui:arrow-filled"></span>
                            <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">{{ $breadcrumb->title }}</span>
                        </div>
                    </li>
                @endif
            @endforeach
        </ol>
    </nav>
@endunless
