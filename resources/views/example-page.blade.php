<x-dashboard-layout>
    <x-slot name="title">Example Page - Target Bahasa</x-slot>
    <x-slot name="pageTitle">Example Page</x-slot>
    <x-slot name="pageDescription">This is an example page using the role-based sidebar layout</x-slot>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card 1 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-blue-50 rounded-xl text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-gray-800 mb-1">24</h3>
            <p class="text-gray-500 text-sm">Total Items</p>
        </div>

        <!-- Card 2 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-green-50 rounded-xl text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-gray-800 mb-1">18</h3>
            <p class="text-gray-500 text-sm">Completed</p>
        </div>

        <!-- Card 3 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-purple-50 rounded-xl text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-gray-800 mb-1">85%</h3>
            <p class="text-gray-500 text-sm">Progress</p>
        </div>

        <!-- Card 4 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-yellow-50 rounded-xl text-yellow-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-gray-800 mb-1">6</h3>
            <p class="text-gray-500 text-sm">Pending</p>
        </div>
    </div>

    <!-- Content Section -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Welcome to the Role-Based Layout System</h2>
        <p class="text-gray-600 mb-4">
            This page demonstrates the automatic sidebar selection based on user role. 
            The sidebar you see depends on whether you're logged in as an admin, teacher, or student.
        </p>
        
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
            <p class="text-blue-700 font-medium">Current Role: <span class="font-bold">{{ ucfirst(Auth::user()->role) }}</span></p>
        </div>

        <div class="mt-6">
            <h3 class="font-bold text-gray-800 mb-2">Features:</h3>
            <ul class="list-disc list-inside space-y-2 text-gray-600">
                <li>Automatic sidebar selection based on user role</li>
                <li>Responsive design with mobile support</li>
                <li>Active menu item highlighting</li>
                <li>Flash message support (success/error)</li>
                <li>Customizable page title and description</li>
                <li>Notification bell with badge support</li>
                <li>User profile display in topbar</li>
            </ul>
        </div>
    </div>
</x-dashboard-layout>
