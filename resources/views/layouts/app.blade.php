<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Chat Widget Styles */
        #chatWidget {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 1000;
        }

        #chatToggle {
            background: #2563eb;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
            font-size: 24px;
        }

        #chatToggle:hover {
            background: #1d4ed8;
            transform: scale(1.1);
        }

        #chatBox {
            position: absolute;
            bottom: 70px;
            right: 0;
            width: 320px;
            height: 400px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            border: 1px solid #e5e7eb;
            display: none;
            flex-direction: column;
        }

        #chatBox.show {
            display: flex !important;
        }

        .chat-header {
            background: #2563eb;
            color: white;
            padding: 12px 16px;
            border-radius: 12px 12px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chat-header h3 {
            font-weight: 600;
            margin: 0;
            font-size: 16px;
        }

        .chat-header p {
            margin: 0;
            font-size: 12px;
            opacity: 0.8;
        }

        #closeChat {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
        }

        #closeChat:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        #chatMessages {
            flex: 1;
            overflow-y: auto;
            padding: 16px;
            background: #f9fafb;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 #f7fafc;
        }

        #chatMessages::-webkit-scrollbar {
            width: 6px;
        }

        #chatMessages::-webkit-scrollbar-track {
            background: #f7fafc;
        }

        #chatMessages::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 3px;
        }

        .message {
            margin-bottom: 12px;
        }

        .message.user {
            display: flex;
            justify-content: flex-end;
        }
        
        .message.bot {
            display: flex;
            justify-content: flex-start;
        }
        
        .message-content {
            padding: 8px 12px;
            border-radius: 12px;
            max-width: 80%;
            font-size: 14px;
        }
        
        .message.user .message-content {
            background: #3b82f6;
            color: white;
            border-radius: 12px 12px 4px 12px;
        }
        
        .message.bot .message-content {
            background: #f3f4f6;
            color: #374151;
            border-radius: 12px 12px 12px 4px;
        }

        .chat-input {
            padding: 16px;
            border-top: 1px solid #e5e7eb;
        }

        .input-group {
            display: flex;
            gap: 8px;
        }

        #userInput {
            flex: 1;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 14px;
            outline: none;
        }

        #userInput:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
        }

        .send-btn {
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            transition: background 0.2s;
        }

        .send-btn:hover {
            background: #1d4ed8;
        }

        .typing-indicator {
            display: flex;
            align-items: center;
            padding: 8px 12px;
        }

        .typing-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #9ca3af;
            margin: 0 2px;
            animation: typing 1.4s infinite ease-in-out;
        }

        .typing-dot:nth-child(1) { animation-delay: -0.32s; }
        .typing-dot:nth-child(2) { animation-delay: -0.16s; }

        @keyframes typing {
            0%, 80%, 100% { transform: scale(0.8); opacity: 0.5; }
            40% { transform: scale(1); opacity: 1; }
        }
    </style>
</head>

<body class="min-h-screen flex flex-col bg-gray-50">
    <div id="app" class="flex flex-col min-h-screen">
        @include('partials.navbar')

        <main class="py-6 mt-16 flex-grow">
            <div class="container mx-auto px-4">
                @if (session('message'))
                    <div id="session-message"
                        class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                        role="alert">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ session('message') }}
                        </div>
                        <button type="button" class="absolute top-0 right-0 p-2" onclick="this.parentElement.remove()">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>

        @include('partials.footer')
    </div>

    <!-- Floating Customer Service Chat Widget - HANYA UNTUK USER BIASA -->
    @auth
        @if(!Auth::user()->is_admin)
            <div id="chatWidget">
                <!-- Chat Button -->
                <button id="chatToggle">
                    <i class="fas fa-comments"></i>
                </button>
                
                <!-- Chat Box -->
                <div id="chatBox">
                    <!-- Chat Header -->
                    <div class="chat-header">
                        <div>
                            <h3>Job Support</h3>
                            <p>Bantuan Karir & Lowongan</p>
                        </div>
                        <button id="closeChat">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <!-- Chat Messages -->
                    <div id="chatMessages">
                        <div class="message bot">
                            <div class="message-content">
                                <p>Halo! Saya Job Support Bot. Ada yang bisa saya bantu mengenai lowongan pekerjaan atau aplikasi Anda?</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Chat Input -->
                    <div class="chat-input">
                        <div class="input-group">
                            <input type="text" id="userInput" placeholder="Tulis pesan Anda..." autocomplete="off">
                            <button class="send-btn" onclick="sendMessage()">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endauth

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded - initializing chat widget...');
            
            const message = document.getElementById('session-message');
            if (message) {
                setTimeout(() => {
                    message.style.transition = 'opacity 0.5s ease';
                    message.style.opacity = '0';
                    setTimeout(() => {
                        message.remove();
                    }, 500);
                }, 5000);
            }

            // Chat Widget Functionality - HANYA JALANKAN JIKA CHAT WIDGET ADA
            const chatWidget = document.getElementById('chatWidget');
            if (chatWidget) {
                const chatToggle = document.getElementById('chatToggle');
                const chatBox = document.getElementById('chatBox');
                const closeChat = document.getElementById('closeChat');
                const userInput = document.getElementById('userInput');

                // Pastikan chat box awalnya hidden
                if (chatBox) {
                    chatBox.style.display = 'none';
                }

                // Toggle Chat Box
                if (chatToggle) {
                    chatToggle.addEventListener('click', function(e) {
                        e.stopPropagation();
                        console.log('Opening chat box');
                        if (chatBox.style.display === 'none') {
                            chatBox.style.display = 'flex';
                            if (userInput) userInput.focus();
                        } else {
                            chatBox.style.display = 'none';
                        }
                    });
                }
                
                // Close Chat Box
                if (closeChat) {
                    closeChat.addEventListener('click', function(e) {
                        e.stopPropagation();
                        console.log('Closing chat box');
                        chatBox.style.display = 'none';
                    });
                }
                
                // Handle Enter Key
                if (userInput) {
                    userInput.addEventListener('keypress', function(e) {
                        if (e.key === 'Enter') {
                            sendMessage();
                        }
                    });
                }

                // Close chat when clicking outside
                document.addEventListener('click', function(event) {
                    if (chatWidget && !chatWidget.contains(event.target) && chatBox) {
                        chatBox.style.display = 'none';
                    }
                });

                console.log('Chat widget initialized successfully');
            } else {
                console.log('Chat widget not available (admin user or guest)');
            }
        });

        function sendMessage() {
            const input = document.getElementById('userInput');
            if (!input) return;
            
            const message = input.value.trim();
            
            if (message === '') return;
            
            // Add user message
            appendMessage('user', message);
            input.value = '';
            
            // Show typing indicator
            showTypingIndicator();
            
            // Get bot response after delay
            setTimeout(() => {
                removeTypingIndicator();
                const response = getBotResponse(message);
                appendMessage('bot', response);
            }, 1000);
        }
        
        function appendMessage(sender, text) {
            const chatMessages = document.getElementById('chatMessages');
            if (!chatMessages) return;
            
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${sender}`;
            
            messageDiv.innerHTML = `
                <div class="message-content">
                    <p>${text}</p>
                </div>
            `;
            
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function showTypingIndicator() {
            const chatMessages = document.getElementById('chatMessages');
            if (!chatMessages) return;
            
            const typingDiv = document.createElement('div');
            typingDiv.className = 'message bot';
            typingDiv.id = 'typingIndicator';
            
            typingDiv.innerHTML = `
                <div class="message-content">
                    <div class="typing-indicator">
                        <div class="typing-dot"></div>
                        <div class="typing-dot"></div>
                        <div class="typing-dot"></div>
                    </div>
                </div>
            `;
            
            chatMessages.appendChild(typingDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function removeTypingIndicator() {
            const typingIndicator = document.getElementById('typingIndicator');
            if (typingIndicator) {
                typingIndicator.remove();
            }
        }
        
        function getBotResponse(message) {
            const msg = message.toLowerCase();
            
            // Greetings
            if (msg.includes('halo') || msg.includes('hai') || msg.includes('hi') || msg.includes('hello')) {
                return "Halo! Saya Job Support Bot. Ada yang bisa saya bantu mengenai lowongan pekerjaan atau aplikasi Anda?";
            }
            
            // Job Applications
            if (msg.includes('lamar') || msg.includes('apply') || msg.includes('melamar') || msg.includes('aplikasi')) {
                return "Untuk melamar pekerjaan, klik tombol 'Apply Now' pada lowongan yang Anda minati. Pastikan CV dan surat lamaran Anda sudah siap!";
            }
            
            // CV/Resume
            if (msg.includes('cv') || msg.includes('resume') || msg.includes('curriculum vitae')) {
                return "Format CV yang diterima: PDF, DOC, DOCX (maksimal 2MB). Pastikan CV Anda update dan relevan dengan posisi yang dilamar.";
            }
            
            // Job Search
            if (msg.includes('cari kerja') || msg.includes('lowongan') || msg.includes('pekerjaan') || msg.includes('job')) {
                return "Gunakan fitur pencarian di halaman utama untuk menemukan lowongan. Anda bisa filter berdasarkan kategori, lokasi, atau jenis pekerjaan.";
            }
            
            // Application Status
            if (msg.includes('status') || msg.includes('lamaran') || msg.includes('proses') || msg.includes('diterima')) {
                return "Cek status lamaran di menu 'My Applications'. Perusahaan biasanya membutuhkan waktu 1-2 minggu untuk proses review.";
            }
            
            // Withdraw Application
            if (msg.includes('tarik') || msg.includes('batalkan') || msg.includes('withdraw')) {
                return "Untuk membatalkan lamaran, buka menu 'My Applications', pilih lamaran yang ingin dibatalkan, lalu klik 'Withdraw Application'.";
            }
            
            // Contact Information
            if (msg.includes('kontak') || msg.includes('hubungi') || msg.includes('customer service') || msg.includes('cs')) {
                return "Hubungi kami di:\n📧 Email: support@joblisting.com\n📱 WhatsApp: +62 812-3456-7890\n🕒 Senin-Jumat, 09:00-17:00 WIB";
            }
            
            // Thank you
            if (msg.includes('terima kasih') || msg.includes('thanks') || msg.includes('makasih')) {
                return "Sama-sama! Semoga sukses dengan pencarian kerja Anda. 😊";
            }
            
            // Default response
            return "Maaf, saya belum memahami pertanyaan Anda. Coba tanyakan tentang: cara melamar kerja, upload CV, status lamaran, atau kontak customer service.";
        }
    </script>
</body>
</html>