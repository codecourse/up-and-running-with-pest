<x-layouts.app>
    @guest
        <x-slot name="header">
            Bookfriends
        </x-slot>

        <div class="mt-8">
            Sign up to get started.
        </div>
    @endguest

    @auth
        <x-slot name="header">
            My books
        </x-slot>

        <div class="space-y-6">
            @foreach ($booksByStatus as $status => $books)
                <div>
                    <h1 class="font-bold text-xl text-slate-600">
                        {{ App\Models\Pivot\BookUser::$statuses[$status] }}
                    </h1>

                    <div class="mt-4 space-y-3">
                        @foreach ($books as $book)
                            <x-book :book="$book">
                                <x-slot name="links">
                                    Links
                                </x-slot>
                            </x-book>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

    @endauth
</x-layouts.app>
