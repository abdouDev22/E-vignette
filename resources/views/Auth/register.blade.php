<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            @error('name')
                <p class="text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            @error('email')
                <p class="text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="new-password" />
            @error('password')
                <p class="text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password" />
            @error('password_confirmation')
                <p class="text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- File Inputs -->
        <div class="mt-4">
            <x-input-label for="image1" :value="__('Image 1')" />
            <input id="image1" class="block mt-1 w-full" type="file" name="image1" required />
            @error('image1')
                <p class="text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-4">
            <x-input-label for="image2" :value="__('Image 2')" />
            <input id="image2" class="block mt-1 w-full" type="file" name="image2" required />
            @error('image2')
                <p class="text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Display OCR Results -->
        @if(session('ocrData'))
            <div class="mt-4">
                <h2>Résultats OCR :</h2>
                <p><strong>Nom Extrait :</strong> {{ session('ocrData')['identityName'] }}</p>
                <p><strong>Adresse Extrait :</strong> {{ session('ocrData')['identityAddress'] }}</p>
                <p><strong>NNI :</strong> {{ session('ocrData')['identityNNI'] }}</p>
            </div>
        @endif

        <!-- Display Success or Error Messages -->
        @if(session('success'))
            <div class="mt-4">
                <p class="text-green-600">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="mt-4">
                <p class="text-red-600">{{ session('error') }}</p>
            </div>
        @endif

        <!-- Display Error Messages -->
@if($errors->any())
    <div class="mt-4">
        @foreach ($errors->all() as $error)
            <p class="text-red-600 mt-2">{{ $error }}</p>
        @endforeach
    </div>
@endif


        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
