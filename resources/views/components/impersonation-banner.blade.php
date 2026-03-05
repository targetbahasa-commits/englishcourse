@if(session()->has('view_as_role'))
<div class="bg-indigo-600 w-full text-white text-center py-2 text-sm drop-shadow-md z-50 relative font-medium">
    You are currently viewing the dashboard as a <strong>{{ ucfirst(session('view_as_role')) }}</strong>. 
    <a href="{{ route('admin.impersonate.stop') }}" class="underline font-bold ml-2 hover:text-indigo-200">Return to Admin</a>
</div>
@endif
