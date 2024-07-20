<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Merci de vous être inscrit ! Avant de commencer, veuillez verifier votre adresse e-mail en cliquant sur le lien que nous venons de vous envoyer. Si vous n avez pas reçu l e-mail, nous serons heureux de vous en envoyer un autre.') }}
    </div>

    <!-- Display Success Message for Resending Verification Email -->
    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('Un nouveau code de verification a ete envoye a l adresse e-mail que vous avez fournie lors de votre inscription.') }}
        </div>
    @endif

    <!-- Display Errors for Verification Code -->
    @if ($errors->has('verification_code'))
        <div class="mb-4 font-medium text-sm text-red-600">
            {{ $errors->first('verification_code') }}
        </div>
    @endif

    <!-- Display Errors for Resending Email -->
    @if ($errors->has('email'))
        <div class="mb-4 font-medium text-sm text-red-600">
            {{ $errors->first('email') }}
        </div>
    @endif

    <div class="mt-4">
        <!-- Form to enter the verification code -->
        <form method="POST" action="{{ route('verify-code') }}">
            @csrf

            <div class="flex space-x-2">
                <!-- Loop to create multiple input fields -->
                @for ($i = 0; $i < 6; $i++)
                    <input id="verification_code_{{ $i }}" name="verification_code[]" type="text" maxlength="1" required class="verification-input w-12 h-12 text-center border rounded-md">
                @endfor
            </div>

            <div class="mt-4">
                <x-primary-button>
                    {{ __('Verify Code') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.verification-input');

            inputs.forEach((input, index) => {
                input.addEventListener('input', function() {
                    if (input.value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                });

                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && index > 0 && input.value.length === 0) {
                        inputs[index - 1].focus();
                    }
                });
            });
        });
    </script>
</x-guest-layout>

<style>
    .flex input {
        border: 1px solid #d1d5db; /* Couleur de bordure */
        border-radius: 0.375rem; /* Coins arrondis */
        font-size: 1.25rem; /* Taille de la police */
        text-align: center; /* Aligner le texte au centre */
        transition: border-color 0.3s ease; /* Animation de bordure */
    }

    .flex input:focus {
        border-color: #3b82f6; /* Couleur de bordure au focus */
        outline: none; /* Supprimer le contour par défaut */
        box-shadow: 0 0 0 1px #3b82f6; /* Ajouter une ombre de bordure */
    }
</style>
