<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Photo') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Change your photo") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="flex items-center space-x-6">
            <div class="ml-2">
                <img class="h-16 w-16 rounded-full" src="/img/users/{{ Auth::user()->configuration->image }}" alt="Current profile photo" />
            </div>
            <div class="ml-4">
                <input type="file" id="image"  name="image"
                class="ml-2 block w-full text-sm
                border-gray-300 dark:border-gray-700
                bg-gray-200 text-gray-900
                dark:bg-gray-900 dark:text-gray-300
                focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-xl shadow-sm
                file:mr-4 file:py-2 file:px-4
                file:rounded-xl file:border-0
                file:text-sm file:font-semibold
                file:bg-gray-400 file:text-gray-200
                hover:file:bg-gray-300 hover:file:text-gray-600
                dark:file:bg-gray-400 dark:file:text-gray-200
                dark:hover:file:bg-gray-300 dark:hover:file:text-gray-600
                "/>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
