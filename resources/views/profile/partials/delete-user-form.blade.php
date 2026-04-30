<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            Delete Account
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
        </p>
    </header>

    <div x-data="{ open: false }">
        <button @click="open = true" type="button" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
            Delete Account
        </button>

        <div x-show="open" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="display: none;">
            <div @click.away="open = false" class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 w-full max-w-md mx-4">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Are you sure you want to delete your account?
                    </h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.
                    </p>

                    <div class="mt-6">
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" name="password" type="password" placeholder="Password"
                            class="mt-1 block w-3/4 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300" />
                        @error('password', 'userDeletion')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <button @click="open = false" type="button" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                            Cancel
                        </button>

                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Delete Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

