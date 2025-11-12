<x-guest-layout>
    <div class="auth-container">
        <h1>Вход в систему</h1>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" />
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Пароль</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" />
            </div>

            <!-- Remember Me -->
            <div class="form-options">
                <label for="remember_me">
                    <input id="remember_me" type="checkbox" name="remember">
                    <span>Запомнить меня</span>
                </label>
            </div>

            <div class="auth-links">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">Забыли пароль?</a>
                @endif
            </div>

            <button type="submit" class="btn-primary">Войти</button>

            <div class="auth-links">
                <a href="{{ route('register') }}">Еще нет аккаунта? Зарегистрироваться</a>
            </div>
        </form>
    </div>
</x-guest-layout>