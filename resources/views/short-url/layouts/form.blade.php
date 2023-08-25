@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="container bg-white rounded-lg shadow-md px-4 py-3">
            <form method="POST" class="w-full mb-3" action="{{ route('short-url.short-url.store') }}">
                @csrf

                <div class="flex items-center border-b border-teal-500 py-2">
                    <input
                        class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                        type="text" name="original_url" id="original_url" placeholder="Paste a link to shorten" required>
                    <button
                        class="flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded"
                        type="submit">
                        Shorten
                    </button>
                </div>
                @if ($errors->store->has('code'))
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                        {{ $errors->store->first('code') }}
                    </p>
                @enderror
                @if ($errors->store->has('original_url'))
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                        {{ $errors->store->first('original_url') }}
                    </p>
                @endif
        </form>

        @yield('sub-content')
    </div>
</div>
@endsection
