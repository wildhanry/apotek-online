<!-- Floating Chatbot Widget -->
<div x-data="chatbotWidget()" x-cloak class="fixed bottom-6 right-6 z-50">
    <!-- Chat Container -->
    <div x-show="isOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-4"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform translate-y-4"
         class="absolute bottom-20 right-0 w-80 sm:w-96 bg-white rounded-lg shadow-2xl overflow-hidden max-h-[calc(100vh-120px)]">
        
        <!-- Chat Header -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 p-3 text-white flex-shrink-0">
            <div class="flex justify-between items-center gap-2">
                <div class="flex items-center min-w-0 flex-1">
                    <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center flex-shrink-0 mr-2">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="font-semibold text-sm sm:text-base truncate">Asisten Apoteker</h3>
                        <p class="text-xs text-green-100 truncate">Online • Siap Membantu</p>
                    </div>
                </div>
                <button @click="toggleChat()" class="text-white hover:text-green-100 transition flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Chat Messages -->
        <div class="h-80 overflow-y-auto p-4 bg-gray-50 space-y-3" id="chatMessages">
            <!-- Welcome Message -->
            <div class="flex items-start">
                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div class="ml-3 bg-white p-3 rounded-lg shadow-sm max-w-xs">
                    <p class="text-sm text-gray-800">Halo! 👋 Saya Asisten Apoteker Pintar. Ada yang bisa saya bantu hari ini?</p>
                    <p class="text-xs text-gray-500 mt-1">Jam buka: 08:00 - 22:00 WIB</p>
                </div>
            </div>

            <!-- Dynamic Messages -->
            <template x-for="(msg, index) in messages" :key="index">
                <div :class="msg.sender === 'user' ? 'flex justify-end' : 'flex items-start'">
                    <!-- AI Avatar (for bot messages) -->
                    <div x-show="msg.sender === 'bot'" class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    
                    <!-- Message Bubble -->
                    <div :class="msg.sender === 'user' 
                        ? 'bg-green-500 text-white p-3 rounded-lg shadow-sm max-w-xs' 
                        : 'ml-3 bg-white p-3 rounded-lg shadow-sm max-w-xs'">
                        <p class="text-sm whitespace-pre-wrap" x-text="msg.text"></p>
                        <p class="text-xs mt-1 opacity-70" x-text="msg.time"></p>
                    </div>
                </div>
            </template>

            <!-- Typing Indicator -->
            <div x-show="isTyping" class="flex items-start">
                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div class="ml-3 bg-white p-3 rounded-lg shadow-sm">
                    <div class="flex space-x-1">
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat Input -->
        <div class="p-4 bg-white border-t border-gray-200">
            <form @submit.prevent="sendMessage()" class="flex space-x-2">
                <input 
                    type="text" 
                    x-model="userInput"
                    :disabled="isTyping"
                    placeholder="Ketik pertanyaan Anda..."
                    maxlength="500"
                    class="flex-1 rounded-full border-gray-300 focus:border-green-500 focus:ring-green-500 px-4 py-2 text-sm"
                    autocomplete="off">
                <button 
                    type="submit"
                    :disabled="!userInput.trim() || isTyping"
                    :class="userInput.trim() && !isTyping 
                        ? 'bg-green-500 hover:bg-green-600' 
                        : 'bg-gray-300 cursor-not-allowed'"
                    class="text-white rounded-full p-2 transition duration-150">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </button>
            </form>
            <p class="text-xs text-gray-500 mt-2 text-center">Powered by Google Gemini AI ✨</p>
        </div>
    </div>

    <!-- Floating Action Button -->
    <button 
        @click="toggleChat()"
        class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-full p-4 shadow-2xl hover:shadow-3xl hover:scale-110 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-green-300">
        <svg x-show="!isOpen" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
        </svg>
        <svg x-show="isOpen" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</div>

<script>
function chatbotWidget() {
    return {
        isOpen: false,
        isTyping: false,
        userInput: '',
        messages: [],

        toggleChat() {
            this.isOpen = !this.isOpen;
            if (this.isOpen) {
                this.$nextTick(() => {
                    this.scrollToBottom();
                });
            }
        },

        cleanMarkdown(text) {
            return text
                .replace(/\*\*(.*?)\*\*/g, '$1')
                .replace(/\*(.*?)\*/g, '$1')
                .replace(/_(.*?)_/g, '$1')
                .replace(/^\s*\*\s+/gm, '• ')
                .replace(/\n{3,}/g, '\n\n');
        },

        async sendMessage() {
            if (!this.userInput.trim()) return;

            const message = this.userInput.trim();
            const currentTime = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });

            // Add user message
            this.messages.push({
                sender: 'user',
                text: message,
                time: currentTime
            });

            this.userInput = '';
            this.isTyping = true;
            this.scrollToBottom();

            try {
                // Send to backend API
                const response = await fetch('{{ route("chatbot.chat") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ message: message })
                });

                const data = await response.json();

                // Clean markdown and add AI response
                this.messages.push({
                    sender: 'bot',
                    text: this.cleanMarkdown(data.message || 'Maaf, terjadi kesalahan. Silakan coba lagi.'),
                    time: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })
                });

            } catch (error) {
                console.error('Chatbot error:', error);
                this.messages.push({
                    sender: 'bot',
                    text: 'Maaf, terjadi kesalahan koneksi. Silakan coba lagi. 🙏',
                    time: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })
                });
            } finally {
                this.isTyping = false;
                this.scrollToBottom();
            }
        },

        scrollToBottom() {
            this.$nextTick(() => {
                const chatMessages = document.getElementById('chatMessages');
                if (chatMessages) {
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
            });
        }
    };
}
</script>
