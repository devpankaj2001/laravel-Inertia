<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Sign In | WebRanker Control Center</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <style>body { font-family: 'Urbanist', sans-serif; }</style>
</head>
<body class="h-full flex items-center justify-center p-4 bg-slate-950 text-slate-100">

  <div class="w-full max-w-md space-y-8">
    <!-- Brand Header -->
    <div class="text-center space-y-3">
      <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-[#ff3b30] text-white text-2xl shadow-xl shadow-red-500/20">
        <i class="fas fa-chart-line"></i>
      </div>
      <h2 class="text-3xl font-extrabold tracking-tight text-white">
        Web<span class="text-[#ff3b30]">Ranker</span>
      </h2>
      <p class="text-sm text-slate-400">Sign in to manage SEO, Custom Schema &amp; Inbound Leads</p>
    </div>

    <!-- Login Card -->
    <div class="bg-slate-900 border border-slate-800 rounded-3xl p-8 shadow-2xl shadow-black/40 space-y-6">

      @if(session('success'))
        <div class="p-3.5 rounded-xl bg-emerald-950/60 border border-emerald-500/30 text-emerald-300 text-xs flex items-center gap-2">
          <i class="fas fa-circle-check"></i>
          <span>{{ session('success') }}</span>
        </div>
      @endif

      @if($errors->any())
        <div class="p-3.5 rounded-xl bg-red-950/60 border border-red-500/30 text-red-300 text-xs flex items-center gap-2">
          <i class="fas fa-triangle-exclamation"></i>
          <span>{{ $errors->first() }}</span>
        </div>
      @endif

      <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-4">
        @csrf

        <div class="space-y-1.5">
          <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-300">Email Address</label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-500 text-sm">
              <i class="fas fa-envelope"></i>
            </span>
            <input type="email" id="email" name="email" value="{{ old('email', 'admin@webranker.com') }}" required autofocus
                   class="w-full pl-10 pr-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm focus:outline-none focus:border-[#ff3b30] focus:ring-1 focus:ring-[#ff3b30] placeholder-slate-600 transition-colors">
          </div>
        </div>

        <div class="space-y-1.5">
          <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-300">Password</label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-500 text-sm">
              <i class="fas fa-lock"></i>
            </span>
            <input type="password" id="password" name="password" required placeholder="••••••••"
                   class="w-full pl-10 pr-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm focus:outline-none focus:border-[#ff3b30] focus:ring-1 focus:ring-[#ff3b30] placeholder-slate-600 transition-colors">
          </div>
        </div>

        <div class="flex items-center justify-between text-xs pt-1">
          <label class="flex items-center gap-2 cursor-pointer text-slate-400 hover:text-slate-200">
            <input type="checkbox" name="remember" class="w-4 h-4 rounded bg-slate-950 border-slate-800 text-[#ff3b30] focus:ring-0 focus:ring-offset-0">
            <span>Remember me</span>
          </label>
          <span class="text-slate-500 text-[11px]">Default: password123</span>
        </div>

        <button type="submit"
                class="w-full py-3 px-4 rounded-xl bg-[#ff3b30] hover:bg-red-600 text-white font-bold text-sm shadow-lg shadow-red-500/20 transition-all transform active:scale-[0.99] flex items-center justify-center gap-2 mt-2">
          <span>Sign In to Admin Console</span>
          <i class="fas fa-arrow-right text-xs"></i>
        </button>
      </form>
    </div>

    <div class="text-center">
      <a href="{{ route('home') }}" class="text-xs text-slate-500 hover:text-slate-300 transition-colors inline-flex items-center gap-1.5">
        <i class="fas fa-arrow-left text-[10px]"></i> Return to WebRanker Home
      </a>
    </div>
  </div>

</body>
</html>
