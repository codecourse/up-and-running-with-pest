<x-layouts.app>
    <x-slot name="header">
        Log in
    </x-slot>

    <form action="/login" method="post" class="mt-4 space-y-4">
        @csrf

        <div class="space-y-1">
            <label for="email" class="block">Email address</label>
            <input type="email" name="email" id="email" placeholder="e.g. you@somewhere.com" class="rounded block w-full">
        </div>

        <div class="space-y-1">
            <label for="password" class="block">Password</label>
            <input type="password" name="password" id="password" class="rounded block w-full">
        </div>

        <button type="submit" class="bg-slate-200 px-3 py-2 rounded">
            Log in
        </button>
    </form>
</x-layouts-app>
