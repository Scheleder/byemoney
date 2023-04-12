<x-app-layout>
{{--     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <a type="button" title="Testar" href='/generate-pdf' target='_blank'
                    class="w-full py-4 text-center items-center bg-red-600 hover:bg-red-500 text-white text-sm border-1 rounded-lg">
                    TESTAR PDF</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
