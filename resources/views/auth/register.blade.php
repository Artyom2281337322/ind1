<x-guest-layout>
    <div class="auth-container">
        <h1>Регистрация</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label for="name">Имя</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" />
            </div>

            <!-- Email Address -->
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" />
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Пароль</label>
                <input id="password" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" />
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation">Подтвердите пароль</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" />
            </div>

            <div class="auth-links">
                <a href="{{ route('login') }}">Уже зарегистрированы?</a>
            </div>

            <button type="submit" class="btn-primary">Зарегистрироваться</button>
        </form>
    </div>
</x-guest-layout>