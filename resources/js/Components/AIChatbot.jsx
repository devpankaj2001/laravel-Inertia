import React, { useState, useRef, useEffect } from 'react';

export default function AIChatbot({ onOpenInquiry }) {
  const [isOpen, setIsOpen] = useState(false);
  const [input, setInput] = useState('');
  const [messages, setMessages] = useState([
    {
      role: 'bot',
      text: 'Hello! I am WebRanker AI Assistant. How can I help you today? You can ask about our technical SEO audits, Next.js / Laravel architectures, Core Web Vitals, or claiming your free 48-hour growth roadmap.',
    },
  ]);
  const messagesEndRef = useRef(null);

  const scrollToBottom = () => {
    messagesEndRef.current?.scrollIntoView({ behavior: 'smooth' });
  };

  useEffect(() => {
    if (isOpen) {
      scrollToBottom();
    }
  }, [messages, isOpen]);

  const handleSend = () => {
    if (!input.trim()) return;

    const userText = input.trim();
    const newMessages = [...messages, { role: 'user', text: userText }];
    setMessages(newMessages);
    setInput('');

    // Generate responsive bot reply
    setTimeout(() => {
      let botReply = '';
      const lower = userText.toLowerCase();

      if (lower.includes('audit') || lower.includes('free') || lower.includes('claim')) {
        botReply = 'You can claim our complimentary 48-Hour Growth & SEO Roadmap right now! Click the "FREE AUDIT" button above or use our inquiry drawer to get started.';
      } else if (lower.includes('next') || lower.includes('react') || lower.includes('laravel')) {
        botReply = 'We specialize in modern hybrid stacks: Laravel for robust APIs, ORM & security paired with Next.js or Inertia.js React for sub-second page transitions and 100/100 Core Web Vitals.';
      } else if (lower.includes('price') || lower.includes('cost') || lower.includes('budget')) {
        botReply = 'Our project engagements typically start from $5,000 for sprint audits to enterprise retainers. Share your target domain and we will tailor a proposal with exact deliverables.';
      } else if (lower.includes('seo') || lower.includes('rank')) {
        botReply = 'Our SEO framework includes technical crawl budget optimization, Schema.org graph expansion, topical authority clusters, and sub-second Core Web Vitals engineered for #1 positions.';
      } else {
        botReply = 'Thank you for reaching out! Would you like our senior technical architect to review your domain and schedule a 30-minute growth strategy session?';
      }

      setMessages((prev) => [...prev, { role: 'bot', text: botReply }]);
    }, 600);
  };

  const handleKeyDown = (e) => {
    if (e.key === 'Enter') {
      e.preventDefault();
      handleSend();
    }
  };

  return (
    <div id="aiChatbotWidget" className="ds-chat-widget fixed bottom-6 right-6 z-[9990] pointer-events-none">
      {isOpen && (
        <div id="chatWindow" className="ds-chat-window block">
          <div className="ds-chat-window-inner">
            <div className="ds-chat-header">
              <div className="ds-chat-header-id">
                <div className="ds-chat-header-avatar">
                  <img src="/asset/chatbot_icon.png" alt="WebRanker Assistant" className="ds-chat-header-avatar-img" />
                </div>
                <div>
                  <h4 className="ds-chat-title">WebRanker Assistant</h4>
                  <p className="ds-chat-status">
                    <span className="ds-chat-status-dot"></span> Online · Instant reply
                  </p>
                </div>
              </div>
              <button
                id="closeChatBtn"
                className="ds-chat-close"
                type="button"
                aria-label="Close chat"
                onClick={() => setIsOpen(false)}
              >
                <i className="fas fa-times"></i>
              </button>
            </div>

            <div id="chatMessages" className="ds-chat-messages">
              {messages.map((m, idx) => (
                <div
                  key={idx}
                  className={`ds-chat-row ${m.role === 'bot' ? 'ds-chat-row--bot' : 'ds-chat-row--user justify-end flex'}`}
                >
                  {m.role === 'bot' && (
                    <div className="ds-chat-avatar">
                      <img src="/asset/chatbot_icon.png" alt="Bot" />
                    </div>
                  )}
                  <div
                    className={`ds-chat-bubble ${
                      m.role === 'bot'
                        ? 'ds-chat-bubble--bot'
                        : 'bg-[#ff3b30] text-white rounded-2xl rounded-tr-none px-4 py-2.5 text-xs max-w-[80%]'
                    }`}
                  >
                    {m.text}
                  </div>
                </div>
              ))}
              <div ref={messagesEndRef} />
            </div>

            <div className="ds-chat-composer">
              <input
                type="text"
                id="chatInput"
                placeholder="Ask about SEO, speed, or a project..."
                autoComplete="off"
                value={input}
                onChange={(e) => setInput(e.target.value)}
                onKeyDown={handleKeyDown}
              />
              <button
                type="button"
                id="sendBtn"
                className="ds-chat-send"
                aria-label="Send message"
                onClick={handleSend}
              >
                <i className="fas fa-paper-plane"></i>
              </button>
            </div>
          </div>
        </div>
      )}

      {/* Floating Launcher Button */}
      <button
        id="chatToggleBtn"
        className="ds-chat-launcher fixed bottom-6 right-6 z-[10000] w-14 h-14 rounded-full bg-[#161514] text-white flex items-center justify-center shadow-2xl hover:scale-105 transition-transform border border-slate-700 hover:bg-[#ff3b30]"
        type="button"
        aria-label="Open WebRanker Assistant"
        onClick={() => setIsOpen(!isOpen)}
      >
        <span className="ds-chat-launcher-float flex items-center justify-center">
          {isOpen ? (
            <i className="fas fa-times text-lg"></i>
          ) : (
            <img src="/asset/chatbot_icon.png" alt="Chat" className="w-8 h-8 rounded-full" />
          )}
        </span>
      </button>
    </div>
  );
}
