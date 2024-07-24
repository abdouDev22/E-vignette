<x-app-layout>

    <main class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- Profile Information Card -->
                    <div class="card animate__animated animate__fadeInUp">
                        <div class="card-header">
                            <h2 class="card-title mb-0 fs-5">Profile Information</h2>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Update your account's profile information and email address.") }}
                            </p>
                        </div>
                        <div class="card-body">
                            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                                @csrf
                            </form>

                            <!-- Profile Update Form -->
                            <form method="post" action="{{ route('profile.update') }}" class="mt-3">
                                @csrf
                                @method('patch')

                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus>
                                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                    @error('name')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                    @error('email')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror

                                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Save Changes
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Change Password Card -->
                    <div class="card animate__animated animate__fadeInUp mt-4">
                        <div class="card-header">
                            <h2 class="card-title mb-0 fs-5">Update Password</h2>
                        </div>
                        <div class="card-body">
                            <!-- Change Password Form -->
                            <form method="post" action="{{ route('password.update') }}" class="mt-3">
                                @csrf
                                @method('put')

                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <input id="current_password" name="current_password" type="password" class="form-control" autocomplete="current-password">
                                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                                    @error('current_password')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">New Password</label>
                                    <input id="password" name="password" type="password" class="form-control" autocomplete="new-password">
                                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                                    @error('password')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                    <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password">
                                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                                    @error('password_confirmation')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-lock me-2"></i>Save
                                    </button>

                                    @if (session('status') === 'password-updated')
                                        <p
                                            x-data="{ show: true }"
                                            x-show="show"
                                            x-transition
                                            x-init="setTimeout(() => show = false, 2000)"
                                            class="text-success mb-0"
                                        >{{ __('Saved.') }}</p>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sidebarButton = document.querySelector('.sidebarbuuton');
        const f1Button = document.querySelector('.f1');
        const sidebar = document.querySelector('.sideBarre');

        if (sidebarButton && f1Button && sidebar) {
            sidebarButton.addEventListener('click', () => {
                sidebar.classList.remove('a1');
                console.log('au revoir');
            });

            f1Button.addEventListener('click', () => {
                sidebar.classList.add('a1');
                console.log('salut');
            });
        }
    });
</script>
