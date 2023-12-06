<!-- tasks/search_results.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Search Results') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Search Results</h3>
                    
                    @forelse($results as $result)
                        <div class="mb-4 border rounded p-4">
                            <h4 class="text-xl font-semibold">{{ $result->title }}</h4>
                            <p class="text-gray-600">{{ $result->description }}</p>
                            <p class="text-sm text-gray-500">Category: {{ $result->category }}</p>
                            <p class="text-sm text-gray-500">Scheduled At: {{ $result->scheduled_at }}</p>
                            <!-- Add more details as needed -->
                        </div>
                    @empty
                        <p>No results found.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
