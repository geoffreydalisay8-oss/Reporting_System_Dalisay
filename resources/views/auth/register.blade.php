<x-guest-layout>
    <div class="mb-10 text-center">
        <h1 class="text-3xl font-extrabold text-[#0f172a]">
            Reporting<span class="text-[#3b82f6]">Portal</span>
        </h1>
        <p class="text-slate-500 text-sm mt-2 font-medium">Create an account to continue.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">Email Address</label>
            <div class="relative">
                <i class="far fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="email" name="email" placeholder="name@company.com" required 
                    class="w-full pl-11 pr-4 py-3.5 rounded-xl border-2 border-slate-100 focus:border-[#3b82f6] focus:ring-0 outline-none transition-all">
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">Password</label>
            <div class="relative">
                <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="password" name="password" placeholder="••••••••" required 
                    class="w-full pl-11 pr-4 py-3.5 rounded-xl border-2 border-slate-100 focus:border-[#3b82f6] focus:ring-0 outline-none">
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">Confirm Password</label>
            <div class="relative">
                <i class="fas fa-shield-alt absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="password" name="password_confirmation" placeholder="••••••••" required 
                    class="w-full pl-11 pr-4 py-3.5 rounded-xl border-2 border-slate-100 focus:border-[#3b82f6] focus:ring-0 outline-none">
            </div>
        </div>

        <button type="submit" class="w-full py-4 bg-[#3b82f6] hover:bg-[#2563eb] text-white font-bold rounded-xl shadow-lg transition-all transform active:scale-[0.98]">
            Register
        </button>

        <div class="text-center mt-6">
            <p class="text-sm text-slate-600 font-medium">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-[#3b82f6] font-bold hover:underline">Sign in here</a>
            </p>
        </div>
    </form>
</x-guest-layout>