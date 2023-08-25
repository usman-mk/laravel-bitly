@extends('short-url.layouts.form')

@section('sub-content')
    <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">

        <h3 class="text-lg text-bold mb-3">#Update Code: {{ $model->code }}</h3>
        <form method="POST" action="{{ route('short-url.short-url.update', $model->code) }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="code" value="{{ $model->code }}">
            <div class="relative z-0 w-full mb-6 group">
                <input type="text" name="original_url" id="original_url" value="{{ $model->original_url }}"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" " required />
                <label for="original_url"
                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                    Original url
                </label>

                @if ($errors->update->has('code'))
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                        {{ $errors->update->first('code') }}
                    </p>
                @enderror
                @if ($errors->update->has('original_url'))
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                        {{ $errors->update->first('original_url') }}
                    </p>
                @endif
        </div>
        <button type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mr-auto">Submit</button>
    </form>

</div>
@endsection
