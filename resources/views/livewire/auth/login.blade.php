<div class="flex flex-col flex-1 justify-center items-center">
    <form class="md:w-1/3 gap-4 flex-col flex" wire:submit="login">
        <label for="email">
            <p>Email</p>
            <input class="text-black w-full" id="email" type="text" wire:model="email" required>
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
        <button class="border p-3 mt-2 bg-green-600" type="submit">LOGIN</button>
    </form>
</div>
