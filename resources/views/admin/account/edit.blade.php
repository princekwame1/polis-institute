<x-layouts.admin title="My account">
    <x-admin.header title="My account" description="Update your name, sign in email and password." />

    <form method="POST" action="{{ route('admin.account.update') }}">
        @csrf
        @method('PUT')

        <x-admin.panel class="grid gap-6">
            <div class="grid gap-6 sm:grid-cols-2">
                <x-admin.input name="name" label="Name" :value="$user->name" required autocomplete="name" />
                <x-admin.input name="email" label="Email address" type="email" :value="$user->email" required autocomplete="username" />
            </div>

            <div class="border-t border-gray-100 pt-6">
                <h2 class="text-lg font-extrabold">Change password</h2>
                <p class="text-sm text-muted">Leave these empty to keep your current password.</p>
            </div>
            <div class="grid gap-6 sm:grid-cols-3">
                <x-admin.input name="current_password" label="Current password" type="password" autocomplete="current-password" />
                <x-admin.input name="password" label="New password" type="password" autocomplete="new-password" help="At least 8 characters." />
                <x-admin.input name="password_confirmation" label="Confirm new password" type="password" autocomplete="new-password" />
            </div>
        </x-admin.panel>

        <div class="mt-6">
            <button type="submit" class="btn-primary">Save changes</button>
        </div>
    </form>
</x-layouts.admin>
