<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>
     <header class="main-header">
        <div class="container">
            <h1 class="logo">Аудиотека</h1>
            <nav class="nav-bar">
                <a href="{{ route('tracks.index') }}" class="nav-item">Мои треки</a>
                <a href="{{ route('collections.index') }}" class="nav-item">Коллекции</a>
                <div class="nav-item active" >Профиль</div>
                <form method="POST" action="{{ route('logout') }}" class="nav-item">
                    @csrf
                    <button class="nav-item-button">
                        Выйти
                    </button>
                </form>
            </nav>
        </div>
    </header>

    <div class="profile-container">
        <div class="container">
            <div class="profile-info">
                <div class="avatar-wrapper">
                    <img class="avatar" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=8a2be2&color=fff" alt="Avatar">
                </div>
                <h2 class="username">{{ Auth::user()->name }}</h2>
                <p class="user-email">{{ Auth::user()->email }}</p>

                <div class="stats-section">
                    <div class="stat-item">
                        <span class="stat-number">{{ Auth::user()->tracks->count() }}</span>
                        <span class="stat-label">Треков</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ Auth::user()->collections->count() }}</span>
                        <span class="stat-label">Коллекций</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">5</span>
                        <span class="stat-label">Часов прослушивания</span>
                    </div>
                </div>
            </div>

            <div class="edit-profile">
                <h3>{{ __('Информация о профиле') }}</h3>
                <p class="">{{ __("Обновление данных") }}</p>

                <form class="profile-form" method="post" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')

                    <div class="form-group">
                        <label for="name">{{ __('Имя') }}</label>
                        <input id="name" name="name" type="text" class="form-group input" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div class="form-group">
                        <label for="email">{{ __('Email') }}</label>
                        <input id="email" name="email" type="email" class="form-group input" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div>
                        <button type="submit" class="save-btn">{{ __('Сохранить') }}</button>

                        @if (session('status') === 'profile-updated')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600">{{ __('Сохранено.') }}</p>
                        @endif
                    </div>
                </form>
            </div>

            <div class="edit-profile" style="margin-top: 30px;">
                <h3>{{ __('Обновить пароль') }}</h3>


                <form class="profile-form" method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    <div class="form-group">
                        <label for="update_password_current_password">{{ __('Текущий пароль') }}</label>
                        <input id="update_password_current_password" name="current_password" type="password" class="form-group input" autocomplete="current-password" />
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" />
                    </div>

                    <div class="form-group">
                        <label for="update_password_password">{{ __('Новый пароль') }}</label>
                        <input id="update_password_password" name="password" type="password" class="form-group input" autocomplete="new-password" />
                        <x-input-error :messages="$errors->updatePassword->get('password')" />
                    </div>

                    <div class="form-group">
                        <label for="update_password_password_confirmation">{{ __('Подтвердите пароль') }}</label>
                        <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-group input" autocomplete="new-password" />
                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" />
                    </div>

                    <div>
                        <button type="submit" class="save-btn">{{ __('Сохранить') }}</button>

                        @if (session('status') === 'password-updated')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600">{{ __('Saved.') }}</p>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>