<x-layout>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Daily Handover View</h1>
            <p class="text-gray-600 mt-1">Track all activities and updates for seamless handover</p>
        </div>
        <div class="flex items-center gap-3">
            <!-- Date Filter -->
            <form method="GET" action="{{ route('activities.daily-view') }}" class="flex gap-3 items-center">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Select Date</label>
                    <input type="date" name="date" value="{{ $date }}"
                           class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition h-[42px] mt-1">
                    View Date
                </button>
            </form>
        </div>
    </div>

    <!-- Summary Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Daily Summary</h3>
                <p class="text-gray-600">{{ \Carbon\Carbon::parse($date)->format('F j, Y') }}</p>
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold text-blue-600">{{ $updates->count() }}</p>
                <p class="text-sm text-gray-600">Total Updates</p>
            </div>
        </div>
    </div>

    @if($updates->count() > 0)
        <!-- Timeline View -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Activity Timeline</h2>
                <p class="text-sm text-gray-600 mt-1">Chronological view of all updates made on {{ \Carbon\Carbon::parse($date)->format('M j, Y') }}</p>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    @foreach($updates as $update)
                    <div class="relative pl-8 pb-6 border-l-2 border-gray-200 last:border-l-0 last:pb-0">
                        <div class="absolute -left-2 top-0 w-4 h-4 {{ $update->status === 'done' ? 'bg-green-500' : 'bg-orange-500' }} rounded-full border-2 border-white shadow-sm"></div>

                        <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900 text-lg">{{ $update->activity->title }}</h3>
                                    <p class="text-gray-600 mt-1 text-sm">{{ $update->activity->description }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-sm text-gray-500 whitespace-nowrap">{{ $update->created_at->format('h:i A') }}</span>
                                    <div class="mt-1">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $update->status === 'done' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                                            {{ ucfirst($update->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            @if($update->remark)
                                <div class="mb-3 p-3 bg-white rounded border">
                                    <p class="text-sm text-gray-700"><strong>Remark:</strong> {{ $update->remark }}</p>
                                </div>
                            @endif

                            <div class="flex items-center gap-3 text-sm text-gray-600">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                        {{ substr($update->user->name ?? 'U', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $update->user->name ?? 'Unknown User' }}</p>
                                        <p class="text-xs text-gray-500">
                                            {{ $update->user->position ?? 'Staff' }} • {{ $update->user->department ?? 'Support' }}
                                            @if($update->user->employee_id ?? false)
                                                • ID: {{ $update->user->employee_id }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No updates found</h3>
            <p class="text-gray-600 mb-6">No activity updates were made on {{ \Carbon\Carbon::parse($date)->format('F j, Y') }}.</p>
            <a href="{{ route('activities.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Activities
            </a>
        </div>
    @endif
</x-layout>
