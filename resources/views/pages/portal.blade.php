<x-layouts.app title="Student Portal">
    <x-page-header eyebrow="Student Portal" title="Your Learning, Organised in One Place">
        One place for registered learners to find course information and student services.
    </x-page-header>

    <section class="container-site grid items-center gap-14 py-20 sm:py-24 lg:grid-cols-2">
        <div class="reveal">
            <p class="eyebrow">Coming Soon</p>
            <h2 class="section-title">Your course, all in one place.</h2>
            <p class="lead mt-5">We are building the Student Portal for registered learners. Once it opens, you will be able to log in and find everything you need for your course.</p>
            <p class="mt-4 leading-relaxed text-muted">That will include course information, learning materials, announcements and other student services.</p>

            <ul class="mt-8 grid gap-3 sm:grid-cols-2">
                @foreach ([['book', 'Course information'], ['clipboard', 'Learning resources'], ['bell', 'Announcements'], ['users', 'Student services']] as [$icon, $label])
                    <li class="flex items-center gap-3 rounded-xl bg-brand-50 p-4 font-bold text-brand-800">
                        <x-icon :name="$icon" class="size-5 text-brand-600" /> {{ $label }}
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="reveal rounded-3xl border border-brand-100 bg-white p-8 shadow-xl shadow-brand-900/5 sm:p-10">
            <div class="text-center">
                <img src="{{ asset('images/badge.png') }}" alt="" class="mx-auto size-20 rounded-full">
                <h3 class="mt-4 text-2xl font-extrabold">Student Login</h3>
                <p class="mt-1 text-sm text-muted">The portal is not open yet. You will be able to log in here soon.</p>
            </div>
            <form class="mt-8 grid gap-5" aria-disabled="true" onsubmit="return false">
                <div>
                    <label for="portal-id" class="form-label">Student ID or email</label>
                    <input id="portal-id" type="text" class="form-input" disabled>
                </div>
                <div>
                    <label for="portal-password" class="form-label">Password</label>
                    <input id="portal-password" type="password" class="form-input" disabled>
                </div>
                <button type="submit" class="btn-primary cursor-not-allowed opacity-60" disabled><x-icon name="lock" class="size-4" /> Student Login</button>
            </form>
            <p class="mt-6 text-center text-sm text-muted">Need help? <a href="{{ route('contact') }}" class="font-bold text-brand-600 hover:underline">Contact us</a></p>
        </div>
    </section>
</x-layouts.app>
