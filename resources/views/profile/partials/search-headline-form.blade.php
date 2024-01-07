<section class="pb-4 border-b-2 border-indigo-500">
    <form action="{{ route('headline.index') }}" class="mt-6 space-y-6">
        
        
        <div class="grid grid-cols-4 gap-2">
            <div>
                <x-input-label for="q" :value="__('Search Term')" />
                <x-text-input id="q" name="q" type="text" class="mt-1 block w-full" value="{{ request('q') }}" autofocus />
                <x-input-error class="mt-2" :messages="$errors->get('q')" />
            </div>

            <div>
                <x-input-label for="category" :value="__('Category')" />
                <x-select name="category" class="mt-1 block w-full">
                    <option value="" selected disabled hidden>{{ __('Choose category') }}</option>
                    @foreach ($categories as $category)
                        <option
                            {{ request('category') == $category ? 'selected' : '' }} 
                            value="{{ $category }}"
                        >
                            {{ $category }}
                        </option>
                    @endforeach
                </x-select>
                <x-input-error class="mt-2" :messages="$errors->get('category')" />
            </div>

            <div>
                <x-input-label for="start_date" :value="__('Start Date')" />
                <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full" value="{{ request('start_date') }}" />
                <x-input-error class="mt-2" :messages="$errors->get('start_date')" />
            </div>

            <div>
                <x-input-label for="end_date" :value="__('End Date')" />
                <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full" value="{{ request('end_date') }}" />
                <x-input-error class="mt-2" :messages="$errors->get('end_date')" />
            </div>
        </div>
        

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Search') }}</x-primary-button>
        </div>

        @if (request()->has('q'))
            <p class="text-sm text-white">Using search: <strong>"{{ request('q') }}"</strong>. <a
                    class="border-b border-green-400 text-green-400" href="{{ route('headline.index') }}">Clear
                    filters</a>
            </p>
        @endif
    </form>
</section>
