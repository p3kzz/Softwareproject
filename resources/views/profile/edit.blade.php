@extends('layouts.admin')
@section('content')
    <div name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </div>

    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header class="mb-4">
                        <h2 class="h5 text-dark">
                            {{ __('Profile Information') }}
                        </h2>
                        <p class="text-muted small">
                            {{ __("Update your account's profile information and email address.") }}
                        </p>
                    </header>

                    <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
                        @csrf
                    </form>

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input type="text" id="name" name="name" class="form-control"
                                value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                            @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input type="email" id="email" name="email" class="form-control"
                                value="{{ old('email', $user->email) }}" required autocomplete="username">
                            @error('email')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                                <div class="mt-2">
                                    <p class="text-warning small">
                                        {{ __('Your email address is unverified.') }}
                                        <button form="send-verification" class="btn btn-link p-0 align-baseline">
                                            {{ __('Click here to re-send the verification email.') }}
                                        </button>
                                    </p>

                                    @if (session('status') === 'verification-link-sent')
                                        <p class="text-success small mt-1">
                                            {{ __('A new verification link has been sent to your email address.') }}
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

                            @if (session('status') === 'profile-updated')
                                <span class="text-muted small" x-data="{ show: true }" x-show="show" x-transition
                                    x-init="setTimeout(() => show = false, 2000)">{{ __('Saved.') }}</span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header class="mb-4">
                        <h2 class="h5 text-dark">
                            {{ __('Update Password') }}
                        </h2>
                        <p class="text-muted small">
                            {{ __('Ensure your account is using a long, random password to stay secure.') }}
                        </p>
                    </header>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="update_password_current_password"
                                class="form-label">{{ __('Current Password') }}</label>
                            <input type="password" id="update_password_current_password" name="current_password"
                                class="form-control" autocomplete="current-password">
                            @if ($errors->updatePassword->has('current_password'))
                                <div class="text-danger small mt-1">
                                    {{ $errors->updatePassword->first('current_password') }}
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="update_password_password" class="form-label">{{ __('New Password') }}</label>
                            <input type="password" id="update_password_password" name="password" class="form-control"
                                autocomplete="new-password">
                            @if ($errors->updatePassword->has('password'))
                                <div class="text-danger small mt-1">
                                    {{ $errors->updatePassword->first('password') }}
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="update_password_password_confirmation"
                                class="form-label">{{ __('Confirm Password') }}</label>
                            <input type="password" id="update_password_password_confirmation" name="password_confirmation"
                                class="form-control" autocomplete="new-password">
                            @if ($errors->updatePassword->has('password_confirmation'))
                                <div class="text-danger small mt-1">
                                    {{ $errors->updatePassword->first('password_confirmation') }}
                                </div>
                            @endif
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

                            @if (session('status') === 'password-updated')
                                <span class="text-success small" x-data="{ show: true }" x-show="show" x-transition
                                    x-init="setTimeout(() => show = false, 2000)">{{ __('Saved.') }}</span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header class="mb-3">
                        <h2 class="h5 text-dark">
                            {{ __('Delete Account') }}
                        </h2>
                        <p class="text-muted small">
                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                        </p>
                    </header>

                    <!-- Trigger Modal -->
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                        data-bs-target="#confirmDeleteModal">
                        {{ __('Delete Account') }}
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <form method="POST" action="{{ route('profile.destroy') }}">
                                @csrf
                                @method('DELETE')

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-danger" id="confirmDeleteModalLabel">
                                            {{ __('Are you sure you want to delete your account?') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="{{ __('Close') }}"></button>
                                    </div>

                                    <div class="modal-body">
                                        <p class="text-muted">
                                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                                        </p>

                                        <div class="mb-3">
                                            <label for="delete_password" class="form-label">{{ __('Password') }}</label>
                                            <input type="password" id="delete_password" name="password"
                                                class="form-control" placeholder="{{ __('Password') }}">
                                            @if ($errors->userDeletion->has('password'))
                                                <div class="text-danger small mt-1">
                                                    {{ $errors->userDeletion->first('password') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            {{ __('Cancel') }}
                                        </button>
                                        <button type="submit" class="btn btn-danger">
                                            {{ __('Delete Account') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


