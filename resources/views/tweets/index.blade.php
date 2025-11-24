<x-app-layout>
    {{-- Main Feed Container --}}
    <div class="max-w-2xl mx-auto min-h-screen" style="border-left: 1px solid #334155; border-right: 1px solid #334155;">
        
        {{-- 1. Create Tweet Area --}}
        <div class="p-4" style="border-bottom: 1px solid #334155;">
            <form method="POST" action="{{ route('tweets.store') }}">
                @csrf
                <div class="flex flex-col">
                    {{-- Input --}}
                    <textarea
                        name="message"
                        placeholder="What's happening?"
                        class="w-full border-none text-xl focus:ring-0 resize-none p-2"
                        style="background-color: transparent; color: white;"
                        rows="2"
                        maxlength="280"
                        oninput="updateCounter(this)"
                    >{{ old('message') }}</textarea>
                    
                    <x-input-error :messages="$errors->get('message')" class="mt-2" />

                    {{-- Bottom Toolbar --}}
                    <div class="flex justify-end items-center mt-3 pt-3" style="border-top: 1px solid #334155;">
                        
                        {{-- Character Counter (New) --}}
                        <span id="charCount" class="text-sm text-slate-500 mr-4">0 / 280</span>

                        {{-- Tweet Button --}}
                        <button class="font-bold py-1.5 px-6 rounded-full text-sm transition text-white" style="background-color: #2563eb;">
                            Tweet
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- 2. The Feed --}}
        <div>
            @foreach ($tweets as $tweet)
                <div class="p-4 cursor-pointer hover:bg-white/5 transition" style="border-bottom: 1px solid #334155;">
                    <div class="flex-1">
                        {{-- Header --}}
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                {{-- Name --}}
                                <a href="{{ route('users.show', $tweet->user) }}" class="font-bold text-white hover:underline text-base">
                                    {{ $tweet->user->name }}
                                </a>
                                {{-- Handle & Time --}}
                                <span class="text-sm" style="color: #94a3b8;">@ {{ strtolower(str_replace(' ', '', $tweet->user->name)) }}</span>
                                <span class="text-sm" style="color: #94a3b8;">&middot; {{ $tweet->created_at->diffForHumans(null, true, true) }}</span>
                                
                                @unless ($tweet->created_at->eq($tweet->updated_at))
                                    <span class="text-xs ml-2 px-1 rounded" style="color: #94a3b8; border: 1px solid #334155;">edited</span>
                                @endunless
                            </div>
                            
                            {{-- Dropdown --}}
                            @if ($tweet->user->is(auth()->user()))
                                <x-dropdown>
                                    <x-slot name="trigger">
                                        <button style="color: #94a3b8;">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('tweets.edit', $tweet)">{{ __('Edit') }}</x-dropdown-link>
                                        <form method="POST" action="{{ route('tweets.destroy', $tweet) }}">
                                            @csrf @method('delete')
                                            <x-dropdown-link :href="route('tweets.destroy', $tweet)" onclick="event.preventDefault(); if(confirm('Are you sure?')) this.closest('form').submit();">
                                                {{ __('Delete') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            @endif
                        </div>

                        {{-- Message --}}
                        <p class="mt-2 text-white text-[15px] leading-normal font-normal">{{ $tweet->message }}</p>

                        {{-- Action Icons (Like) --}}
                        <div class="flex items-center mt-3" style="color: #94a3b8;">
                            <button 
                                onclick="toggleLike({{ $tweet->id }})" 
                                id="like-btn-{{ $tweet->id }}"
                                class="flex items-center space-x-2 group transition"
                                style="color: {{ $tweet->isLikedBy(auth()->user()) ? '#ef4444' : '#64748b' }}"
                            >
                                <div class="p-2 rounded-full transition group-hover:bg-red-900/20" style="margin-left: -8px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" 
                                            fill="{{ $tweet->isLikedBy(auth()->user()) ? 'currentColor' : 'none' }}" 
                                            stroke="{{ $tweet->isLikedBy(auth()->user()) ? 'none' : 'currentColor' }}"
                                            viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </div>
                                <span id="like-count-{{ $tweet->id }}" class="text-sm group-hover:text-red-500">{{ $tweet->likes_count }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Script for AJAX Likes & Char Count --}}
    <script>
        // Character Counter
        function updateCounter(input) {
            const maxLength = 280;
            const currentLength = input.value.length;
            const counter = document.getElementById('charCount');
            
            counter.innerText = `${currentLength} / ${maxLength}`;
            
            if (currentLength >= 260) {
                counter.style.color = "#ef4444"; // Warning Red
            } else {
                counter.style.color = "#64748b"; // Normal Slate
            }
        }

        // AJAX Like Function
        async function toggleLike(tweetId) {
            const btn = document.getElementById(`like-btn-${tweetId}`);
            const countSpan = document.getElementById(`like-count-${tweetId}`);
            const svg = btn.querySelector('svg');

            try {
                const response = await fetch(`/tweets/${tweetId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                });

                if (response.ok) {
                    const data = await response.json();
                    countSpan.innerText = data.likes_count;

                    if (data.liked) {
                        btn.style.color = "#ef4444"; 
                        svg.setAttribute('fill', 'currentColor');
                        svg.setAttribute('stroke', 'none'); 
                    } else {
                        btn.style.color = "#64748b"; 
                        svg.setAttribute('fill', 'none');
                        svg.setAttribute('stroke', 'currentColor');
                    }
                }
            } catch (error) {
                console.error('Error toggling like:', error);
            }
        }
    </script>
</x-app-layout>