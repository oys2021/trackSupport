<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $activity->title }} - Activity Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">

    <main class="max-w-5xl mx-auto py-10 px-6">
        <div class="mb-6">
            <a href="{{ route('activities.index') }}" class="text-blue-600 hover:underline text-sm">&larr; Back to All Activities</a>
        </div>

        <!-- Activity Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $activity->title }}</h1>
            @if($activity->description)
                <p class="text-gray-700 mb-4">{{ $activity->description }}</p>
            @endif

            <div class="text-sm text-gray-500 flex items-center gap-2">
                <span>Created by <strong>{{ $activity->creator->name }}</strong></span>
                <span>•</span>
                <span>{{ $activity->created_at->format('M d, Y h:i A') }}</span>
            </div>
        </div>

        <!-- Updates Timeline -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Status Updates</h2>
                <p class="text-sm text-gray-600 mt-1">Track every status change and remark on this activity.</p>
            </div>

            <div class="p-6 space-y-6">
                @forelse($activity->updates as $update)
                    <div class="relative pl-8 border-l-2 border-gray-200">
                        <div class="absolute -left-2 top-0 w-4 h-4 {{ $update->status === 'done' ? 'bg-green-500' : 'bg-orange-500' }} rounded-full border-2 border-white"></div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <p class="text-sm text-gray-600">
                                        Status changed to
                                        <span class="font-medium {{ $update->status === 'done' ? 'text-green-600' : 'text-orange-600' }}">
                                            {{ ucfirst($update->status) }}
                                        </span>
                                    </p>
                                </div>
                                <span class="text-xs text-gray-500">{{ $update->updated_at->format('M d, Y h:i A') }}</span>
                            </div>
                            @if($update->remark)
                                <p class="text-sm text-gray-800 mb-2 italic">"{{ $update->remark }}"</p>
                            @endif
                            <div class="text-xs text-gray-600">
                                — Updated by <strong>{{ $update->user->name }}</strong> ({{ $update->user->role ?? 'Staff' }})
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No updates yet for this activity.</p>
                @endforelse
            </div>
        </div>

        <!-- Add New Update -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mt-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Add New Update</h2>

            <form action="{{ route('activity_updates.store') }}" method="POST" class="flex flex-col md:flex-row gap-3">
                @csrf
                <input type="hidden" name="activity_id" value="{{ $activity->id }}">

                <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg">
                    <option value="pending">Pending</option>
                    <option value="done">Done</option>
                </select>

                <input type="text" name="remark" placeholder="Enter remark" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg">

                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Submit Update
                </button>
            </form>
        </div>
    </main>

</body>
</html>
