<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-medium text-xl text-[#2c1810] flex items-center gap-3">
                <div class="relative">
                    <img src="{{ asset('storage/' . $otherUser->profile_picture) }}" alt="{{ $otherUser->name }}" class="w-8 h-8 rounded-full border border-[#d6ccc2]">
                    <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 rounded-full border-2 border-[#f5ebe0]" id="online-status"></span>
                </div>
                <span>{{ $otherUser->name }}</span>
            </h2>
            <a href="{{ route('messages.index') }}" class="px-4 py-2 bg-[#f5ebe0] text-[#967259] hover:bg-[#e3d5ca] transition-colors rounded-md">
                Back to Messages
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#f5ebe0] shadow-sm rounded-lg h-[700px] flex flex-col">
                <div class="p-6 text-[#2c1810] flex-1 flex flex-col">
                    <!-- Loading Indicator -->
                    <div id="loading-indicator" class="hidden w-full py-4 text-center">
                        <div class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm text-[#2c1810] transition ease-in-out duration-150 cursor-not-allowed">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-[#2c1810]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Loading messages...
                        </div>
                    </div>

                    <!-- Date Separator -->
                    <div id="date-separator" class="hidden text-center my-4">
                        <span class="px-4 py-1 bg-[#e3d5ca] text-[#967259] text-xs rounded-full"></span>
                    </div>

                    <!-- Messages Container -->
                    <div id="messages-container" class="space-y-4 mb-4 flex-1 overflow-y-auto px-4 scroll-smooth">
                        @foreach($messages as $message)
                            <div class="flex {{ $message->sender_id === Auth::id() ? 'justify-end' : 'justify-start' }} message-item">
                                <div class="flex flex-col {{ $message->sender_id === Auth::id() ? 'items-end' : 'items-start' }} max-w-[70%] group">
                                    <div class="{{ $message->sender_id === Auth::id() ? 'bg-[#c7b7a3] text-white' : 'bg-[#e3d5ca] text-[#2c1810]' }} rounded-lg p-3 shadow-sm hover:shadow-md transition-shadow">
                                        <p class="text-sm whitespace-pre-wrap break-words">{{ $message->content }}</p>
                                    </div>
                                    <div class="flex items-center gap-2 px-2 mt-1 text-xs {{ $message->sender_id === Auth::id() ? 'text-[#e3d5ca]' : 'text-[#967259]' }}">
                                        <span>{{ $message->sent_at->format('g:i a') }}</span>
                                        @if($message->sender_id === Auth::id())
                                            <span class="opacity-0 group-hover:opacity-100 transition-opacity">
                                                @if($message->read)
                                                    <svg class="w-4 h-4 text-[#c7b7a3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                @endif
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Typing Indicator -->
                    <div id="typing-indicator" class="hidden">
                        <div class="flex items-center space-x-2 text-[#967259] text-sm">
                            <span>{{ $otherUser->name }} is typing</span>
                            <div class="flex space-x-1">
                                <div class="w-2 h-2 bg-[#967259] rounded-full animate-bounce"></div>
                                <div class="w-2 h-2 bg-[#967259] rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                                <div class="w-2 h-2 bg-[#967259] rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Message Input -->
                    <div class="mt-4 border-t border-[#d6ccc2] pt-4">
                        <form id="message-form" class="flex gap-2">
                            @csrf
                            <input type="hidden" name="receiver_id" value="{{ $otherUser->id }}">
                            <div class="flex-1 relative">
                                <textarea 
                                    name="content" 
                                    id="message-input" 
                                    rows="1"
                                    class="form-input w-full pr-12 resize-none overflow-hidden border-[#d6ccc2] focus:border-[#c7b7a3] focus:ring-[#c7b7a3]"
                                    placeholder="Type your message..."
                                    maxlength="1000"
                                ></textarea>
                                <button type="submit" class="absolute right-2 bottom-2 px-3 py-1 text-sm bg-[#c7b7a3] text-white rounded-md hover:bg-[#967259] transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                    Send
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="module">
        // Import Firebase
        import { initializeApp } from 'https://www.gstatic.com/firebasejs/10.8.0/firebase-app.js';
        import { getDatabase, ref, push, onValue, set } from 'https://www.gstatic.com/firebasejs/10.8.0/firebase-database.js';

        // Your Firebase configuration
        const firebaseConfig = {
            apiKey: "{{ config('services.firebase.api_key') }}",
            authDomain: "{{ config('services.firebase.auth_domain') }}",
            projectId: "{{ config('services.firebase.project_id') }}",
            storageBucket: "{{ config('services.firebase.storage_bucket') }}",
            messagingSenderId: "{{ config('services.firebase.messaging_sender_id') }}",
            appId: "{{ config('services.firebase.app_id') }}",
            databaseURL: "{{ config('services.firebase.database_url') }}"
        };

        // Initialize Firebase
        const app = initializeApp(firebaseConfig);
        const database = getDatabase(app);

        // References
        const messageForm = document.getElementById('message-form');
        const messageInput = document.getElementById('message-input');
        const messagesContainer = document.getElementById('messages-container');
        const loadingIndicator = document.getElementById('loading-indicator');
        const typingIndicator = document.getElementById('typing-indicator');
        const currentUserId = {{ Auth::id() }};
        const otherUserId = {{ $otherUser->id }};

        // Chat room ID (combination of both user IDs, sorted and joined)
        const chatRoomId = [currentUserId, otherUserId].sort().join('_');
        const messagesRef = ref(database, 'messages/' + chatRoomId);
        const typingRef = ref(database, `typing/${chatRoomId}/${currentUserId}`);
        const presenceRef = ref(database, `presence/${otherUserId}`);

        // Auto-resize textarea
        messageInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });

        // Handle typing status
        let typingTimeout;
        messageInput.addEventListener('input', () => {
            set(typingRef, true);
            clearTimeout(typingTimeout);
            typingTimeout = setTimeout(() => set(typingRef, false), 1500);
        });

        // Listen for typing status
        onValue(ref(database, `typing/${chatRoomId}/${otherUserId}`), (snapshot) => {
            typingIndicator.classList.toggle('hidden', !snapshot.val());
        });

        // Listen for presence status
        onValue(presenceRef, (snapshot) => {
            const isOnline = snapshot.val() === true;
            document.getElementById('online-status').classList.toggle('bg-green-500', isOnline);
            document.getElementById('online-status').classList.toggle('bg-gray-400', !isOnline);
        });

        // Listen for new messages
        loadingIndicator.classList.remove('hidden');
        onValue(messagesRef, (snapshot) => {
            loadingIndicator.classList.add('hidden');
            const data = snapshot.val();
            if (data) {
                updateMessagesUI(Object.values(data));
            }
        });

        // Mark user as online
        const myPresenceRef = ref(database, `presence/${currentUserId}`);
        set(myPresenceRef, true);
        window.addEventListener('beforeunload', () => set(myPresenceRef, false));

        // Send message
        messageForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const content = messageInput.value.trim();
            if (!content) return;

            const submitButton = messageForm.querySelector('button[type="submit"]');
            submitButton.disabled = true;

            try {
                // Send to Laravel backend
                const response = await fetch('{{ route("messages.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        receiver_id: otherUserId,
                        content: content
                    })
                });

                if (response.ok) {
                    const message = await response.json();
                    // Send to Firebase
                    await push(messagesRef, {
                        sender_id: currentUserId,
                        content: content,
                        timestamp: Date.now(),
                        read: false
                    });

                    messageInput.value = '';
                    messageInput.style.height = 'auto';
                    set(typingRef, false);
                }
            } catch (error) {
                console.error('Error sending message:', error);
            } finally {
                submitButton.disabled = false;
            }
        });

        // Update UI with messages
        function updateMessagesUI(messages) {
            messages.sort((a, b) => a.timestamp - b.timestamp);
            
            let currentDate = '';
            let html = '';

            messages.forEach(message => {
                const messageDate = new Date(message.timestamp);
                const formattedDate = messageDate.toLocaleDateString();
                
                if (formattedDate !== currentDate) {
                    currentDate = formattedDate;
                    html += `
                        <div class="text-center my-4">
                            <span class="px-4 py-1 bg-[#e3d5ca] text-[#967259] text-xs rounded-full">
                                ${isToday(messageDate) ? 'Today' : formattedDate}
                            </span>
                        </div>
                    `;
                }

                html += `
                    <div class="flex ${message.sender_id === currentUserId ? 'justify-end' : 'justify-start'} message-item">
                        <div class="flex flex-col ${message.sender_id === currentUserId ? 'items-end' : 'items-start'} max-w-[70%] group">
                            <div class="${message.sender_id === currentUserId ? 'bg-[#c7b7a3] text-white' : 'bg-[#e3d5ca] text-[#2c1810]'} rounded-lg p-3 shadow-sm hover:shadow-md transition-shadow">
                                <p class="text-sm whitespace-pre-wrap break-words">${escapeHtml(message.content)}</p>
                            </div>
                            <div class="flex items-center gap-2 px-2 mt-1 text-xs ${message.sender_id === currentUserId ? 'text-[#e3d5ca]' : 'text-[#967259]'}">
                                <span>${messageDate.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' })}</span>
                                ${message.sender_id === currentUserId ? `
                                    <span class="opacity-0 group-hover:opacity-100 transition-opacity">
                                        ${message.read ? `
                                            <svg class="w-4 h-4 text-[#c7b7a3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        ` : `
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        `}
                                    </span>
                                ` : ''}
                            </div>
                        </div>
                    </div>
                `;
            });

            messagesContainer.innerHTML = html;
            scrollToBottom();

            // Mark messages as read
            if (document.hasFocus()) {
                markMessagesAsRead(messages);
            }
        }

        function isToday(date) {
            const today = new Date();
            return date.getDate() === today.getDate() &&
                date.getMonth() === today.getMonth() &&
                date.getFullYear() === today.getFullYear();
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function scrollToBottom() {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        async function markMessagesAsRead(messages) {
            const unreadMessages = messages.filter(m => 
                m.sender_id === otherUserId && !m.read
            );

            for (const message of unreadMessages) {
                try {
                    await fetch(`/messages/${message.id}/read`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    
                    // Update Firebase
                    const messageRef = ref(database, `messages/${chatRoomId}/${message.key}`);
                    await set(messageRef, { ...message, read: true });
                } catch (error) {
                    console.error('Error marking message as read:', error);
                }
            }
        }

        // Handle window focus for marking messages as read
        window.addEventListener('focus', () => {
            const messages = Array.from(document.querySelectorAll('.message-item'))
                .map(el => ({
                    id: el.dataset.messageId,
                    sender_id: parseInt(el.dataset.senderId),
                    read: el.dataset.read === 'true'
                }));
            markMessagesAsRead(messages);
        });
    </script>
</x-app-layout>