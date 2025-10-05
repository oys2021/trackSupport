<x-layout>
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Create New Activity</h1>
            <p class="text-gray-600 mt-1">Add a new activity to track for your support team</p>
        </div>

        <!-- Validation errors -->
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg">
                <strong>Whoops!</strong> Please fix the following errors:
                <ul class="mt-2 list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Create Activity Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
            <form action="{{ route('activities.store') }}" method="POST">
                @csrf

                <!-- Activity Title -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Activity Title <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="title"
                        placeholder="e.g., Daily SMS count in comparison to SMS count from logs"
                        value="{{ old('title') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                        required
                    >
                </div>

                <!-- Activity Description -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea
                        name="description"
                        rows="4"
                        placeholder="Provide detailed information about this activity..."
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none resize-none"
                    >{{ old('description') }}</textarea>
                </div>

                <!-- Form Actions -->
                <div class="flex gap-3">
                    <button
                        type="submit"
                        class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition flex items-center justify-center gap-2"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create Activity
                    </button>
                    <a
                        href="{{ route('activities.index') }}"
                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition"
                    >
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Info Box -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex gap-3">
                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="text-sm font-medium text-blue-900">Activity Creation Tips</p>
                    <p class="text-sm text-blue-700 mt-1">Be specific with activity titles and descriptions. This helps team members understand what needs to be done and ensures smooth handovers between shifts.</p>
                </div>
            </div>
        </div>
</x-layout>
