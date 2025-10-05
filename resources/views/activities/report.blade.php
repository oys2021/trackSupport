<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Reports - Activity Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-8">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-chart-bar text-white text-lg"></i>
                        </div>
                        <span class="text-xl font-bold text-gray-900">Activity Reports</span>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('activities.index') }}" class="text-gray-600 hover:text-gray-900 text-sm font-medium">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Activity History Report</h1>
            <p class="text-gray-600 mt-2">Query activity updates and status changes within custom date ranges</p>
        </div>

        <!-- Filter Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Filter Report</h2>
            <form method="GET" action="{{ route('activities.report') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                    <input type="date" name="start_date" value="{{ $start_date }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                    <input type="date" name="end_date" value="{{ $end_date }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                </div>
                <div class="md:col-span-3 flex gap-3">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-blue-700 transition flex items-center">
                        <i class="fas fa-filter mr-2"></i> Apply Filter
                    </button>
                    <a href="{{ route('activities.report') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-medium hover:bg-gray-300 transition flex items-center">
                        <i class="fas fa-redo mr-2"></i> Reset
                    </a>
                    <button type="button" onclick="window.print()" class="bg-green-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-green-700 transition flex items-center">
                        <i class="fas fa-print mr-2"></i> Print
                    </button>
                </div>
            </form>
        </div>

        <!-- Summary Cards -->
        @if($start_date && $end_date)
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Total Updates</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $total_updates }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <i class="fas fa-sync-alt text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Completed</p>
                        <p class="text-3xl font-bold text-green-600">{{ $completed_updates }}</p>
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
                        <p class="text-3xl font-bold text-orange-600">{{ $pending_updates }}</p>
                    </div>
                    <div class="p-3 bg-orange-100 rounded-lg">
                        <i class="fas fa-clock text-orange-600 text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Date Range</p>
                        <p class="text-lg font-bold text-gray-900">{{ \Carbon\Carbon::parse($start_date)->format('M j, Y') }} - {{ \Carbon\Carbon::parse($end_date)->format('M j, Y') }}</p>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <i class="fas fa-calendar-alt text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Results -->
        @if($activities->count() > 0)
            <!-- Timeline View -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Update Timeline</h2>
                    <p class="text-sm text-gray-600 mt-1">Chronological view of all status updates</p>
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
                                        <span class="text-sm text-gray-500 whitespace-nowrap">{{ $update->created_at->format('M j, Y h:i A') }}</span>
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

            <!-- Activities Summary -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Activities Summary</h2>
                    <p class="text-sm text-gray-600 mt-1">Detailed view of activities with their update history</p>
                </div>
                <div class="p-6">
                    <div class="space-y-6">
                        @foreach($activities as $activity)
                        <div class="border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <div class="p-4 border-b border-gray-200 bg-gray-50">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-semibold text-gray-900 text-lg">{{ $activity->title }}</h3>
                                        <p class="text-gray-600 mt-1">{{ $activity->description }}</p>
                                        <div class="flex items-center gap-4 mt-2 text-sm text-gray-500">
                                            <span>Created by: {{ $activity->creator->name }}</span>
                                            <span>•</span>
                                            <span>Activity Date: {{ $activity->activity_date }}</span>
                                            <span>•</span>
                                            <span>Total Updates: {{ $activity->updates->count() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="p-4">
                                <h4 class="font-medium text-gray-900 mb-3">Update History:</h4>
                                @if($activity->updates->count() > 0)
                                    <div class="space-y-3">
                                        @foreach($activity->updates as $update)
                                        <div class="border-l-4 border-blue-500 pl-4 py-2 bg-blue-50 rounded-r-lg">
                                            <div class="flex justify-between items-center mb-2">
                                                <div class="flex items-center gap-2">
                                                    <span class="px-2 py-1 text-xs rounded-full {{ $update->status === 'done' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                                                        {{ ucfirst($update->status) }}
                                                    </span>
                                                    <span class="text-sm text-gray-600">{{ $update->created_at->format('M j, Y h:i A') }}</span>
                                                </div>
                                            </div>
                                            @if($update->remark)
                                                <p class="text-sm text-gray-700 mb-2">{{ $update->remark }}</p>
                                            @endif
                                            <div class="text-xs text-gray-600">
                                                Updated by: <strong>{{ $update->user->name }}</strong>
                                                ({{ $update->user->position }}, {{ $update->user->department }})
                                                @if($update->user->employee_id)
                                                    - ID: {{ $update->user->employee_id }}
                                                @endif
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-500 text-sm">No updates in selected date range</p>
                                @endif
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
                    <i class="fas fa-chart-bar text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No activity updates found</h3>
                <p class="text-gray-600 mb-6">No updates were made during the selected date range ({{ \Carbon\Carbon::parse($start_date)->format('M j, Y') }} - {{ \Carbon\Carbon::parse($end_date)->format('M j, Y') }}).</p>
                <div class="flex gap-3 justify-center">
                    <a href="{{ route('activities.report') }}?start_date={{ now()->subDays(30)->format('Y-m-d') }}&end_date={{ now()->format('Y-m-d') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                        <i class="fas fa-calendar-week mr-2"></i> Last 30 Days
                    </a>
                    <a href="{{ route('activities.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg inline-flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Activities
                    </a>
                </div>
            </div>
        @endif
    </main>
</body>
</html>
