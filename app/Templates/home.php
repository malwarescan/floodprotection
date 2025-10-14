<!-- AI Chat Hero Section -->
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-10">
    <!-- Chat Container -->
    <div id="chatContainer" class="relative">
        <!-- Initial State -->
        <div id="initialState" class="text-center">
            <div class="flex justify-center mb-6">
                <span class="inline-flex items-center gap-x-2 bg-white border border-gray-200 text-xs text-gray-600 p-2 px-3 rounded-full">
                    Florida Licensed • Same-Week Installs • 67 Counties
                </span>
            </div>
            
            <h1 class="block font-bold text-gray-800 text-4xl md:text-5xl lg:text-6xl mb-4">
                Flood Protection
                <span class="bg-clip-text bg-gradient-to-tl from-accent to-primary text-transparent">Expert Assistant</span>
            </h1>
            
            <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
                Ask me anything about flood barriers, installation, pricing, or protection solutions for your Florida home.
            </p>
        </div>

        <!-- Chat Messages (Hidden Initially) -->
        <div id="chatMessages" class="hidden mb-4 max-h-[500px] overflow-y-auto space-y-4 bg-white rounded-xl border border-gray-200 p-6">
            <!-- Messages will be appended here -->
        </div>

        <!-- Input Area -->
        <div class="max-w-3xl mx-auto">
            <div class="relative">
                <textarea 
                    id="chatInput" 
                    rows="1"
                    class="p-4 pb-12 block w-full border-gray-200 rounded-xl text-sm focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none resize-none"
                    placeholder="Ask about flood barriers, installation, pricing..."
                    style="min-height: 60px; max-height: 200px;"
                ></textarea>

                <div class="absolute bottom-px inset-x-px p-2 rounded-b-xl bg-white">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-x-1">
                            <!-- Suggested prompts -->
                            <button type="button" class="hidden sm:inline-flex items-center gap-x-1 text-xs text-gray-500 hover:text-primary" onclick="setSuggestion('What flood barriers do you recommend for a garage?')">
                                <svg class="size-3" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/></svg>
                                Example
                            </button>
                        </div>
                        <div class="flex items-center gap-x-1">
                            <button 
                                type="button" 
                                id="sendButton"
                                class="inline-flex shrink-0 justify-center items-center size-8 rounded-lg text-white bg-accent hover:bg-accent-600 focus:z-10 focus:outline-none focus:bg-accent-600"
                                onclick="sendMessage()"
                            >
                                <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="mt-4 flex flex-wrap gap-2 justify-center">
                <button onclick="setSuggestion('What types of flood barriers do you offer?')" class="py-2 px-3 inline-flex items-center gap-x-2 text-xs font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50">
                    Types of Barriers
                </button>
                <button onclick="setSuggestion('How much does installation cost?')" class="py-2 px-3 inline-flex items-center gap-x-2 text-xs font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50">
                    Pricing
                </button>
                <button onclick="setSuggestion('How long does installation take?')" class="py-2 px-3 inline-flex items-center gap-x-2 text-xs font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50">
                    Installation Time
                </button>
                <button onclick="setSuggestion('Do you serve my area in Florida?')" class="py-2 px-3 inline-flex items-center gap-x-2 text-xs font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50">
                    Service Areas
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let chatActive = false;

function setSuggestion(text) {
    document.getElementById('chatInput').value = text;
    document.getElementById('chatInput').focus();
}

function autoResize() {
    const textarea = document.getElementById('chatInput');
    textarea.style.height = 'auto';
    textarea.style.height = Math.min(textarea.scrollHeight, 200) + 'px';
}

document.getElementById('chatInput').addEventListener('input', autoResize);
document.getElementById('chatInput').addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        sendMessage();
    }
});

function sendMessage() {
    const input = document.getElementById('chatInput');
    const message = input.value.trim();
    
    if (!message) return;
    
    // Show chat interface if first message
    if (!chatActive) {
        chatActive = true;
        document.getElementById('initialState').classList.add('hidden');
        document.getElementById('chatMessages').classList.remove('hidden');
    }
    
    // Add user message
    addMessage(message, 'user');
    
    // Clear input
    input.value = '';
    autoResize();
    
    // Show typing indicator
    showTyping();
    
    // Simulate AI response (replace with actual API call)
    setTimeout(() => {
        hideTyping();
        const response = getAIResponse(message);
        addMessage(response, 'assistant');
    }, 1500);
}

function addMessage(text, sender) {
    const messagesDiv = document.getElementById('chatMessages');
    const messageDiv = document.createElement('div');
    
    if (sender === 'user') {
        messageDiv.className = 'flex justify-end';
        messageDiv.innerHTML = `
            <div class="max-w-[80%] bg-primary text-white rounded-2xl px-4 py-3">
                <p class="text-sm">${escapeHtml(text)}</p>
            </div>
        `;
    } else {
        messageDiv.className = 'flex justify-start';
        messageDiv.innerHTML = `
            <div class="max-w-[80%] bg-gray-100 text-gray-800 rounded-2xl px-4 py-3">
                <div class="flex items-start gap-3">
                    <svg class="shrink-0 size-5 text-accent mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8V4H8"/><rect width="16" height="12" x="4" y="8" rx="2"/><path d="M2 14h2"/><path d="M20 14h2"/><path d="M15 13v2"/><path d="M9 13v2"/></svg>
                    <div class="text-sm">${escapeHtml(text)}</div>
                </div>
            </div>
        `;
    }
    
    messagesDiv.appendChild(messageDiv);
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
}

function showTyping() {
    const messagesDiv = document.getElementById('chatMessages');
    const typingDiv = document.createElement('div');
    typingDiv.id = 'typingIndicator';
    typingDiv.className = 'flex justify-start';
    typingDiv.innerHTML = `
        <div class="bg-gray-100 rounded-2xl px-4 py-3">
            <div class="flex gap-1">
                <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0ms"></span>
                <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 150ms"></span>
                <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 300ms"></span>
            </div>
        </div>
    `;
    messagesDiv.appendChild(typingDiv);
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
}

function hideTyping() {
    const typingIndicator = document.getElementById('typingIndicator');
    if (typingIndicator) typingIndicator.remove();
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Placeholder AI response (replace with actual API integration)
function getAIResponse(message) {
    const responses = {
        'types': "We offer three main types of flood barriers:\n\n1. **Modular Aluminum Panels** - Custom-fit for doorways and large openings\n2. **Door Dams** - Quick-deploy compression seal systems for standard doors\n3. **Garage Dam Kits** - Heavy-duty barriers for garage doors\n\nAll products are made with 6063 T-6 aluminum and EPDM rubber sealing. Would you like details about a specific type?",
        'price': "Our pricing varies based on the type and size:\n\n• Door Dams: Starting at $1,499\n• Modular Panels: $2,499 - $4,299\n• Garage Kits: Starting at $3,299\n\nWe offer free on-site measurements and quotes. Would you like to schedule a consultation? Call us at +1-239-810-8761",
        'installation': "Most installations are completed within 24-48 hours! Our process:\n\n1. Free measurement & consultation\n2. Custom fabrication (3-5 days)\n3. Professional installation (2-4 hours)\n\nWe serve all 67 Florida counties with same-week service in most areas. Emergency pre-storm installations available.",
        'area': "Yes! We serve all 67 counties in Florida, including:\n\n• Miami-Dade, Broward, Palm Beach\n• Tampa, St. Petersburg, Clearwater\n• Jacksonville, Orlando, Fort Myers\n• And everywhere in between!\n\nWe're Florida licensed and insured. Which county are you located in?"
    };
    
    const lowerMessage = message.toLowerCase();
    if (lowerMessage.includes('type') || lowerMessage.includes('barrier') || lowerMessage.includes('offer')) {
        return responses.types;
    } else if (lowerMessage.includes('cost') || lowerMessage.includes('price') || lowerMessage.includes('pricing')) {
        return responses.price;
    } else if (lowerMessage.includes('install') || lowerMessage.includes('time') || lowerMessage.includes('long')) {
        return responses.installation;
    } else if (lowerMessage.includes('area') || lowerMessage.includes('serve') || lowerMessage.includes('location')) {
        return responses.area;
    } else {
        return "I'm here to help with flood protection questions! I can tell you about:\n\n• Types of flood barriers we offer\n• Pricing and installation costs\n• Installation timeline and process\n• Service areas across Florida\n• Product specifications and warranties\n\nWhat would you like to know?";
    }
}
</script>

<!-- Features Section -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <!-- Grid -->
    <div class="md:grid md:grid-cols-2 md:items-center md:gap-12 xl:gap-32">
        <div>
            <h2 class="text-3xl text-gray-800 font-bold lg:text-4xl">
                Professional Flood Protection Services
            </h2>
            <p class="mt-3 text-gray-600">
                Custom-designed flood barriers, rapid-deploy panels, and compression-seal door dams. We protect Florida homes from rising water with proven, reliable solutions.
            </p>
            
            <!-- Checklist -->
            <div class="mt-6 lg:mt-10">
                <div class="flex gap-x-5 ms-1">
                    <svg class="shrink-0 mt-1 size-5 text-accent" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    <div class="grow">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-800">
                            Florida Licensed & Insured
                        </h3>
                        <p class="mt-1 text-gray-600">
                            Fully licensed to provide flood protection services throughout all 67 Florida counties.
                        </p>
                    </div>
                </div>
                
                <div class="flex gap-x-5 ms-1 mt-6">
                    <svg class="shrink-0 mt-1 size-5 text-accent" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    <div class="grow">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-800">
                            Same-Week Installation
                        </h3>
                        <p class="mt-1 text-gray-600">
                            Most installations completed within 24-48 hours. We move fast so you're protected before the storm.
                        </p>
                    </div>
                </div>
                
                <div class="flex gap-x-5 ms-1 mt-6">
                    <svg class="shrink-0 mt-1 size-5 text-accent" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    <div class="grow">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-800">
                            20+ Year Warranty
                        </h3>
                        <p class="mt-1 text-gray-600">
                            Quality products backed by comprehensive warranties. Built to last decades.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <div>
            <img class="rounded-xl" src="https://images.unsplash.com/photo-1563298723-dcfebaa392e3?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=900&h=600&q=80" alt="Professional Flood Barrier Installation">
        </div>
    </div>
</div>

<!-- Services Cards -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <div class="max-w-2xl mx-auto text-center mb-10 lg:mb-14">
        <h2 class="text-2xl font-bold md:text-4xl md:leading-tight text-gray-800">Our Flood Protection Services</h2>
        <p class="mt-1 text-gray-600">Complete flood protection solutions for residential and commercial properties.</p>
    </div>
    
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Card 1 -->
        <a class="group flex flex-col h-full bg-white border border-gray-200 hover:border-transparent hover:shadow-lg focus:outline-none focus:border-transparent focus:shadow-lg transition duration-300 rounded-xl p-5" href="/products/modular-flood-barrier">
            <div class="aspect-w-16 aspect-h-11">
                <img class="w-full object-cover rounded-xl" src="https://images.unsplash.com/photo-1621905251189-08b45d6a269e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=560&q=80" alt="Modular Aluminum Construction Materials">
            </div>
            <div class="my-6">
                <h3 class="text-xl font-semibold text-gray-800 group-hover:text-primary">
                    Modular Flood Barriers
                </h3>
                <p class="mt-5 text-gray-600">
                    Custom-designed modular barriers that protect your home's entry points from rising water levels. 6063 T-6 aluminum with EPDM sealing.
                </p>
            </div>
            <div class="mt-auto flex items-center gap-x-3">
                <span class="text-sm text-gray-800 hover:text-primary">Learn More</span>
                <svg class="shrink-0 size-4 text-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            </div>
        </a>
        
        <!-- Card 2 -->
        <a class="group flex flex-col h-full bg-white border border-gray-200 hover:border-transparent hover:shadow-lg focus:outline-none focus:border-transparent focus:shadow-lg transition duration-300 rounded-xl p-5" href="/products/doorway-flood-panel">
            <div class="aspect-w-16 aspect-h-11">
                <img class="w-full object-cover rounded-xl" src="https://images.unsplash.com/photo-1513694203232-719a280e022f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=560&q=80" alt="Modern Home Entrance Door">
            </div>
            <div class="my-6">
                <h3 class="text-xl font-semibold text-gray-800 group-hover:text-primary">
                    Doorway Flood Panels
                </h3>
                <p class="mt-5 text-gray-600">
                    Quick-deploy flood panels for doors, windows, and openings. Pre-cut, measured to fit, and ready to install when you need them.
                </p>
            </div>
            <div class="mt-auto flex items-center gap-x-3">
                <span class="text-sm text-gray-800 hover:text-primary">Learn More</span>
                <svg class="shrink-0 size-4 text-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            </div>
        </a>
        
        <!-- Card 3 -->
        <a class="group flex flex-col h-full bg-white border border-gray-200 hover:border-transparent hover:shadow-lg focus:outline-none focus:border-transparent focus:shadow-lg transition duration-300 rounded-xl p-5" href="/products/garage-dam-kit">
            <div class="aspect-w-16 aspect-h-11">
                <img class="w-full object-cover rounded-xl" src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=560&q=80" alt="Residential Garage Door">
            </div>
            <div class="my-6">
                <h3 class="text-xl font-semibold text-gray-800 group-hover:text-primary">
                    Garage Dam Kits
                </h3>
                <p class="mt-5 text-gray-600">
                    Compression-seal garage door dams that create watertight seals without damaging frames. Perfect for vulnerable garage entries.
                </p>
            </div>
            <div class="mt-auto flex items-center gap-x-3">
                <span class="text-sm text-gray-800 hover:text-primary">Learn More</span>
                <svg class="shrink-0 size-4 text-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            </div>
        </a>
    </div>
</div>

<!-- Coverage Section -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <div class="max-w-2xl mx-auto text-center mb-10 lg:mb-14">
        <h2 class="text-2xl font-bold md:text-4xl md:leading-tight text-gray-800">We Serve All of Florida</h2>
        <p class="mt-1 text-gray-600">From Miami to Jacksonville, Tampa to Orlando — flood protection throughout the Sunshine State.</p>
    </div>
    
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3">
        <a class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50" href="/home-flood-barriers/miami">Miami</a>
        <a class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50" href="/home-flood-barriers/jacksonville">Jacksonville</a>
        <a class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50" href="/home-flood-barriers/tampa">Tampa</a>
        <a class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50" href="/home-flood-barriers/orlando">Orlando</a>
        <a class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50" href="/home-flood-barriers/fort-lauderdale">Fort Lauderdale</a>
        <a class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50" href="/home-flood-barriers/tallahassee">Tallahassee</a>
    </div>
</div>

<!-- CTA Section -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <div class="max-w-2xl mx-auto text-center">
        <div class="mt-5 max-w-2xl">
            <h2 class="block font-bold text-gray-800 text-4xl md:text-5xl">
                Ready to Protect Your Home?
            </h2>
        </div>
        
        <div class="mt-5 max-w-3xl">
            <p class="text-xl text-gray-600">Don't wait for the next storm. Get your free flood protection quote today.</p>
        </div>
        
        <div class="mt-8 gap-3 flex flex-col sm:flex-row justify-center">
            <a class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-accent text-white hover:bg-accent-600 focus:outline-none focus:bg-accent-600" href="<?= \App\Config::getPhoneLink() ?>">
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                Call Now: <?= htmlspecialchars(\App\Config::get('phone')) ?>
            </a>
            <a class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-primary text-white hover:bg-primary-600 focus:outline-none focus:bg-primary-600" href="<?= \App\Config::getSmsLink('I need a free quote for flood barriers.') ?>">
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                Text for Free Quote
            </a>
        </div>
    </div>
</div>
