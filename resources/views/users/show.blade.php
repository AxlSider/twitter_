<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        
        {{-- Profile Header Card --}}
        <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                    <p class="text-gray-500 text-sm">Joined {{ $user->created_at->format('F Y') }}</p>
                </div>
                
                {{-- Stats --}}
                <div class="flex space-x-8">
                    <div class="text-right">
                        <div class="text-xs uppercase tracking-wider text-gray-500">Tweets</div>
                        <div class="text-xl font-bold text-indigo-600">{{ $tweetCount }}</div>
                    </div>
                    <div class="text-right">
                        <div class="text-xs uppercase tracking-wider text-gray-500">Likes Received</div>
                        <div class="text-xl font-bold text-pink-600">{{ $totalLikesReceived }}</div>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="text-lg font-semibold text-gray-700 mb-4">{{ $user->name }}'s Tweets</h2>

        {{-- List of User's Tweets (Reusing the design) --}}
        <div class="bg-white shadow-sm rounded-lg divide-y">
            @forelse ($tweets as $tweet)
                <div class="p-6 flex space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-gray-800 font-bold">{{ $tweet->user->name }}</span>
                                <small class="ml-2 text-sm text-gray-600">{{ $tweet->created_at->format('j M Y, g:i a') }}</small>
                            </div>
                        </div>
                        <p class="mt-4 text-lg text-gray-900">{{ $tweet->message }}</p>
                        
                        {{-- Like Count Display --}}
                        <div class="mt-4 flex items-center text-gray-500">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
                            </svg>
                            <span>{{ $tweet->likes_count }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <p class="p-6 text-gray-500 text-center">This user hasn't tweeted anything yet.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>