<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-400 leading-tight">
            {{ __('Headlines') }} <span class="text-gray-400">({{ $headlines->total() ?? $headlines->count() }})</span>
        </h2>
    </x-slot>
    <div class="py-12 bg-gray-800">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    
                    {{-- Search form --}}
                    @include('profile.partials.search-headline-form')
                    
                    <div class="mt-8">
                        @forelse ($headlines as $headline)
                            <div class="text-green-500 mb-4 border rounded p-4">
                                <h2 class="font-semibold text-2xl">
                                    <a href="{{ $headline->link }}" target="_blank">
                                        {{ $headline->headline }}
                                    </a>
                                </h2>
                                <p class="m-0">{{ $headline->short_description }}</body>
                                <div class="flex space-x-2">
                                    <span class="text-sm font-bold px-2 py-1 rounded bg-blue-500 text-white">
                                        {{ $headline->category }}
                                    </span>
                                    <span class="text-sm font-bold px-2 py-1 rounded bg-blue-500 text-white">
                                        {{ $headline->date }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <p>No headlines found</p>
                        @endforelse
                    </div>
                </div>
                <div class="text-right">
                    {{ $headlines->onEachSide(2)->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
