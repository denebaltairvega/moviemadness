<div class="flex flex-col flex-1 justify-center items-center">
    <form class="md:w-1/3 gap-4 flex-col flex" wire:submit="register">
        <label for="name">
            <p>Name</p>
            <input class="text-black w-full" id="name" type="text" wire:model="name" required>
        </label>
        @error('name')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
        <label for="email">
            <p>Email</p>
            <input class="text-black w-full" id="email" type="email" wire:model="email" required>
        </label>
        @error('email')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
        <label for="password">
            <p>Password</p>
            <input class="text-black w-full" id="password" type="password" wire:model="password" required>
        </label>
        @error('password')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
        <label for="password_confirmation">
            <p>Confirm Password</p>
            <input class="text-black w-full" id="password_confirmation" type="password" wire:model="password_confirmation" required>
        </label>
        @error('password_confirmation')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
        <button class="border p-3 mt-2 bg-green-600" type="submit">REGISTER</button>
    </form>
    <a href="{{ route('login') }}" class="underline mt-4 hover:text-gray-300">I already have an account.</a>
</div>
