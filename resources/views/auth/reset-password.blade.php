<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ request()->route('token') }}">

        <div>
            <label>Email</label>
            <input type="email" name="email" required autofocus value="{{ old('email', request()->email) }}">
        </div>

        <div>
            <label>Password Baru</label>
            <input type="password" name="password" required>
        </div>

        <div>
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <button type="submit">Reset Password</button>
    </form>
</x-guest-layout>
