@php
    $tabs = [
        'reading' => ['label' => 'Reading', 'route' => 'admin.placement-test.reading.index'],
        'listening' => ['label' => 'Listening', 'route' => 'admin.placement-test.listening.index'],
        'writing' => ['label' => 'Writing', 'route' => 'admin.placement-test.writing.index'],
        'speaking' => ['label' => 'Speaking', 'route' => 'admin.placement-test.speaking.index'],
    ];
@endphp
<div class="flex items-center justify-between gap-4 mb-4">
    <div class="flex items-center gap-2">
        <label for="package-switcher" class="text-xs font-semibold text-gray-500 uppercase">Paket:</label>
        <select id="package-switcher" onchange="window.location.href = this.value" class="rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 shadow-sm">
            @foreach ($packages as $p)
                <option value="{{ route($tabs[$active]['route'], ['package_id' => $p->id]) }}" {{ $package->id === $p->id ? 'selected' : '' }}>
                    {{ $p->title }}{{ $p->isActive() ? ' (Active)' : '' }}
                </option>
            @endforeach
        </select>
    </div>
    <a href="{{ route('admin.placement-test.packages.index') }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-800">Kelola Paket &rarr;</a>
</div>

<div class="border-b border-gray-200">
    <nav class="-mb-px flex gap-6">
        @foreach ($tabs as $key => $tab)
            <a href="{{ route($tab['route'], ['package_id' => $package->id]) }}" class="whitespace-nowrap py-3 px-1 border-b-2 text-sm font-medium {{ $active === $key ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                {{ $tab['label'] }}
            </a>
        @endforeach
    </nav>
</div>
