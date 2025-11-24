<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        
        {{-- Edit Container: Dark Blue Style --}}
        <div class="p-6" style="border: 1px solid #334155; border-radius: 16px; background-color: #0f172a;">
            <h2 class="text-xl font-bold text-white mb-4">Edit Tweet</h2>

            <form method="POST" action="{{ route('tweets.update', $tweet) }}">
                @csrf
                @method('patch')
                
                <textarea
                    name="message"
                    class="w-full text-xl resize-none p-4"
                    style="background-color: transparent; border: 1px solid #334155; color: white; border-radius: 8px;"
                    rows="4"
                >{{ old('message', $tweet->message) }}</textarea>
                
                <x-input-error :messages="$errors->get('message')" class="mt-2" />
                
                <div class="mt-4 flex items-center space-x-4">
                    <button class="font-bold py-2 px-6 rounded-full text-sm transition text-white" style="background-color: #2563eb;">
                        {{ __('Save') }}
                    </button>
                    <a href="{{ route('tweets.index') }}" style="color: #94a3b8;" class="hover:text-white transition">
                        {{ __('Cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>