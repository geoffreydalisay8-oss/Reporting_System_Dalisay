<x-guest-layout>
    <div class="text-center mb-10">
        <h2 class="text-2xl font-bold text-slate-800">Welcome Back</h2>
        <p class="text-slate-500 text-sm mt-1">Please enter your details to sign in.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-6">
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-4 rounded-xl border-2 border-slate-100 focus:border-blue-500 focus:ring-0 transition-all outline-none text-slate-700 bg-slate-50/50" placeholder="name@company.com" required autofocus>
            
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

    <div style="margin-bottom: 15px;">
    <label style="font-weight: 700; color: #475569; font-size: 0.85rem; text-transform: uppercase; display: block; margin-bottom: 8px;">
        Password
    </label>
    <input type="password" name="password" 
           style="width: 100%; padding: 14px; border: 1px solid #e2e8f0; border-radius: 12px; background: #f8fafc;" 
           placeholder="••••••••">
</div>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
    
    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.85rem; color: #64748b; margin: 0;">
        <input type="checkbox" name="remember" style="width: 16px; height: 16px; accent-color: #3b82f6; cursor: pointer;">
        Keep me logged in
    </label>

    <a href="{{ route('password.request') }}" 
       style="color: #3b82f6; font-weight: 700; font-size: 0.85rem; text-decoration: none;">
        Forgot?
    </a>
</div>

<button type="submit" style="width: 100%; padding: 16px; background: #3b82f6; color: white; border: none; border-radius: 12px; font-weight: 700; text-transform: uppercase; cursor: pointer; box-shadow: 0 4px 14px 0 rgba(59, 130, 246, 0.39);">
    Sign In
</button>
        <div class="mt-10 pt-6 border-t border-slate-100 text-center">
            <p class="text-sm text-slate-500">
                Don't have an account? 
                <a href="{{ route('register') }}" class="text-blue-500 font-bold hover:underline">Register here</a>
            </p>
        </div>
    </form>
</x-guest-layout>