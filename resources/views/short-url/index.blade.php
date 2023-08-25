@extends('short-url.layouts.form')

@section('sub-content')
    <div
        class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Shorten url
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Original url
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($models as $item)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ route('short-url.short-url.redirect', $item->code) }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $item->original_url }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('short-url.short-url.edit', $item->code) }}"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                            <form method="POST" action="{{ route('short-url.short-url.destroy', $item->code) }}"
                                class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                        colspan="3">
                        Data not found.
                    </th>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
