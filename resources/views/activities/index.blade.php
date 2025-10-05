<x-layout>
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Daily Handover View</h1>
                <p class="text-gray-600 mt-1">Track all activities and updates for seamless handover</p>
            </div>
            <div class="flex items-center gap-3">
                <input type="date" value="{{ date('Y-m-d') }}" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition">Today</button>
                <a href="{{ route('activities.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition flex items-center">
                    <i class="fas fa-plus mr-2"></i> New Activity
                </a>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Total Activities</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $activities->count() }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <i class="fas fa-tasks text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            @php
                $completedCount = 0;
                $pendingCount = 0;
                foreach($activities as $activity) {
                    $latestUpdate = $activity->updates->sortByDesc('created_at')->first();
                    if($latestUpdate && $latestUpdate->status === 'done') {
                        $completedCount++;
                    } else {
                        $pendingCount++;
                    }
                }
            @endphp

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Completed</p>
                        <p class="text-3xl font-bold text-green-600">{{ $completedCount }}</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-lg">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Pending</p>
                        <p class="text-3xl font-bold text-orange-600">{{ $pendingCount }}</p>
                    </div>
                    <div class="p-3 bg-orange-100 rounded-lg">
                        <i class="fas fa-clock text-orange-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Team Members</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $users_count }}</p>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <i class="fas fa-users text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Timeline View -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Activity Timeline</h2>
                <p class="text-sm text-gray-600 mt-1">Chronological view of all activities and updates</p>
            </div>
            <div class="p-6">
                @if($activities->count() > 0)
                    @php
                        $allUpdates = [];
                        foreach($activities as $activity) {
                            foreach($activity->updates as $update) {
                                $allUpdates[] = [
                                    'activity' => $activity,
                                    'update' => $update,
                                    'timestamp' => $update->created_at
                                ];
                            }
                        }
                        // Sort updates by timestamp (newest first)
                        usort($allUpdates, function($a, $b) {
                            return $b['timestamp'] <=> $a['timestamp'];
                        });
                    @endphp

                    @if(count($allUpdates) > 0)
                        @foreach($allUpdates as $item)
                            @php
                                $activity = $item['activity'];
                                $update = $item['update'];
                            @endphp
                            <div class="relative pl-8 pb-8 border-l-2 border-gray-200 last:border-l-0 last:pb-0">
                                <div class="absolute -left-2 top-0 w-4 h-4 {{ $update->status === 'done' ? 'bg-green-500' : 'bg-orange-500' }} rounded-full border-2 border-white shadow-sm"></div>
                                <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition">
                                    <div class="flex items-start justify-between mb-2">
                                        <div>
                                            <h3 class="font-semibold text-gray-900">{{ $activity->title }}</h3>
                                            <p class="text-sm text-gray-600 mt-1">
                                                Status updated to
                                                <span class="font-medium {{ $update->status === 'done' ? 'text-green-600' : 'text-orange-600' }}">
                                                    {{ ucfirst($update->status) }}
                                                </span>
                                            </p>
                                        </div>
                                        <span class="text-xs text-gray-500 whitespace-nowrap">{{ $update->created_at->format('h:i A') }}</span>
                                    </div>
                                    @if($update->remark)
                                        <p class="text-sm text-gray-700 mb-3">{{ $update->remark }}</p>
                                    @endif
                                    <div class="flex items-center gap-2 text-xs">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                                {{ substr($update->user->name, 0, 1) }}
                                            </div>
                                            <span class="font-medium">{{ $update->user->name }}</span>
                                        </div>
                                        <span class="text-gray-400">•</span>
                                        <span class="text-gray-600">{{ $update->user->position ?? 'Staff' }}</span>
                                        <span class="text-gray-400">•</span>
                                        <span class="text-gray-600">{{ $update->user->department ?? 'Support' }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-history text-4xl text-gray-300 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No updates yet</h3>
                            <p class="text-gray-600">Activity updates will appear here once team members start updating status.</p>
                        </div>
                    @endif
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-tasks text-4xl text-gray-300 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No activities found</h3>
                        <p class="text-gray-600 mb-4">Get started by creating your first activity</p>
                        <a href="{{ route('activities.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                            <i class="fas fa-plus mr-2"></i> Create Activity
                        </a>
                    </div>
                @endif
            </div>
        </div>
<!-- Pending Handover Section -->
@php
    $pendingActivities = [];
    foreach($activities as $activity) {
        $latestUpdate = $activity->updates->sortByDesc('created_at')->first();
        if(!$latestUpdate || $latestUpdate->status !== 'done') {
            $pendingActivities[] = $activity;
        }
    }
@endphp

@if(count($pendingActivities) > 0)
<div class="bg-orange-50 border border-orange-200 rounded-xl p-6 mt-6">
    <div class="flex items-start gap-3">
        <div class="flex-shrink-0 p-2 bg-orange-100 rounded-lg">
            <i class="fas fa-exclamation-triangle text-orange-600 text-xl"></i>
        </div>
        <div class="flex-1">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Pending Activities for Handover</h3>
            <ul class="space-y-3">
                @foreach($pendingActivities as $activity)
                <li class="flex items-center justify-between p-3 bg-white rounded-lg border border-orange-100">
                    <div class="flex items-center gap-3">
                        <span class="w-2 h-2 bg-orange-500 rounded-full"></span>
                        <div>
                            <span class="font-medium text-gray-900">{{ $activity->title }}</span>
                            <p class="text-sm text-gray-500 mt-1">
                                Created by {{ $activity->creator->name }} • {{ $activity->created_at->format('M j, Y') }}
                            </p>
                        </div>
                    </div>

                    <!-- Update Form -->
                   <form action="{{ route('activity_updates.store') }}" method="POST" class="flex items-center gap-2">
    @csrf

    {{-- Which activity this update belongs to --}}
    <input type="hidden" name="activity_id" value="{{ $activity->id }}">

    <select name="status" class="px-2 py-1 border rounded">
      <option value="pending" {{ $activity->latestStatus() == 'pending' ? 'selected' : '' }}>Pending</option>
      <option value="done"    {{ $activity->latestStatus() == 'done'    ? 'selected' : '' }}>Done</option>
    </select>

    <input type="text" name="remark" placeholder="Add remark" class="px-2 py-1 border rounded">
    <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded">Update</button>
  </form>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

        <!-- Activities Overview -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mt-6">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">All Activities Overview</h2>
                <p class="text-sm text-gray-600 mt-1">Complete list of activities with current status</p>
            </div>
            <div class="p-6">
                @if($activities->count() > 0)
                    <div class="space-y-4">
                        @foreach($activities as $activity)
                            @php
                                $latestUpdate = $activity->updates->sortByDesc('created_at')->first();
                                $currentStatus = $latestUpdate ? $latestUpdate->status : 'pending';
                            @endphp
                            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                <div class="flex items-center gap-4">
                                    <div class="p-2 rounded-lg {{ $currentStatus === 'done' ? 'bg-green-100 text-green-600' : 'bg-orange-100 text-orange-600' }}">
                                        <i class="fas {{ $currentStatus === 'done' ? 'fa-check-circle' : 'fa-clock' }}"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">{{ $activity->title }}</h4>
                                        <p class="text-sm text-gray-600">{{ $activity->description }}</p>
                                        <div class="flex items-center gap-4 mt-1 text-xs text-gray-500">
                                            <span>Created by: {{ $activity->creator->name }}</span>
                                            <span>•</span>
                                            <span>Date: {{ $activity->activity_date }}</span>
                                            <span>•</span>
                                            <span>Updates: {{ $activity->updates->count() }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="px-3 py-1 text-xs rounded-full {{ $currentStatus === 'done' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                                        {{ ucfirst($currentStatus) }}
                                    </span>
                                    {{-- <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        View Details
                                    </button> --}}
                                    <a href="{{ route('activities.show', $activity->id) }}"
   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
    View Details
</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-tasks text-4xl text-gray-300 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No activities found</h3>
                        <p class="text-gray-600 mb-4">Get started by creating your first activity</p>
                        <a href="{{ route('activities.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                            <i class="fas fa-plus mr-2"></i> Create Activity
                        </a>
                    </div>
                @endif
            </div>
        </div>

</x-layout>
