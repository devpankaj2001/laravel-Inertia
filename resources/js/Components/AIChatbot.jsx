import React, { useState, useRef, useEffect } from 'react';

const WELCOME_MESSAGE = {
  role: 'bot',
  text: "Hello! I am the **WebRanker AI Web Development & SEO Consultant**.\n\nWe engineer modern, scalable web systems and organic search growth:\n• **Modern Full-Stack Engineering** (Laravel, Python/FastAPI, Node.js, Next.js, React)\n• **Third-Party APIs & Payment Gateways** (Stripe, Razorpay, CRMs, Webhooks)\n• **Technical & On-Page SEO** (Core Web Vitals, Schema, Structured Crawling)\n• **Custom E-Commerce & Website Redesigns**\n• **Mobile App Development** (Flutter, iOS, Android)\n\n*Tell me about your project goals or explore our consulting options below:*",
  quick_replies: [
    { label: 'Tech Stack Advice', action: 'message', prompt: 'Which technology should I choose for my project (Laravel, FastAPI, Node.js, React, Next.js, WordPress)? Explain how you evaluate requirements.' },
    { label: 'APIs & Payment Gateways', action: 'message', prompt: 'Can you integrate payment gateways and third-party APIs (Stripe, Razorpay, CRMs, Shipping, Maps)? Give a concise breakdown in bullet points.' },
    { label: 'Fast SEO-Friendly Website', action: 'message', prompt: 'How do you build a fast, mobile-friendly, and SEO-ready website optimized for Core Web Vitals? Give details in clean bullet points.' },
    { label: 'E-Commerce Solutions', action: 'message', prompt: 'Can you build a custom e-commerce website? What features and integrations are included? Use clean bullet points.' },
    { label: 'Website Redesign', action: 'message', prompt: 'Can you redesign my existing website to improve page speed, UI/UX, and SEO? What does the redesign process include?' },
    { label: 'Claim Free Audit', action: 'audit' },
    { label: 'Chat on WhatsApp', action: 'whatsapp' },
    { label: 'Schedule Consultation', action: 'consult' },
  ],
};

/**
 * Format markdown-like text (bold, bullets, links, table cleanup, HTML sanitization, line breaks)
 */
function FormattedMessageText({ text, isStreaming = false }) {
  if (!text && !isStreaming) return null;

  // 1. Normalize all HTML line breaks (<br>, <br/>, <br >) to standard newlines \n
  // and strip any stray HTML tags (<b>, <span>, <div>, etc.)
  const normalized = (text || '')
    .replace(/<br\s*\/?>/gi, '\n')
    .replace(/<[^>]+>/g, '')
    .replace(/\*{3,}/g, '**');

  // 2. Process line by line
  const rawLines = normalized.split('\n');
  const lines = [];

  for (const rawLine of rawLines) {
    const trimmed = rawLine.trim();
    if (!trimmed) {
      lines.push('');
      continue;
    }

    // Skip table divider lines (|---|---|)
    if (/^\|[-:\s|]+\|$/.test(trimmed)) {
      continue;
    }

    // Convert table rows (| Col1 | Col2 |) to clean bullet points
    if (trimmed.startsWith('|') && trimmed.endsWith('|')) {
      const cells = trimmed
        .split('|')
        .map((c) => c.trim())
        .filter(Boolean);

      if (cells.length >= 2) {
        if (
          cells[0].toLowerCase().includes('sub-service') ||
          cells[0].toLowerCase().includes('phase') ||
          cells[0].toLowerCase().includes('layer') ||
          cells[0].toLowerCase().includes('channel') ||
          cells[0].toLowerCase().includes('area')
        ) {
          continue; // Skip header
        }
        lines.push(`• **${cells[0]}**: ${cells.slice(1).join(' — ')}`);
        continue;
      } else if (cells.length === 1) {
        lines.push(`• ${cells[0]}`);
        continue;
      }
    }

    // If multiple bullet points got concatenated on a single line, split them
    if (trimmed.includes(' • ') || (trimmed.startsWith('• ') && trimmed.indexOf('• ', 2) !== -1)) {
      const subItems = trimmed.split(/\s*•\s+/).filter(Boolean);
      for (const item of subItems) {
        lines.push(`• ${item.trim()}`);
      }
      continue;
    }

    lines.push(trimmed);
  }

  return (
    <div className="space-y-1.5 leading-relaxed text-[12.5px]">
      {lines.map((line, lineIdx) => {
        if (!line) {
          return <div key={lineIdx} className="h-1" />;
        }

        const isBullet = line.startsWith('•') || line.startsWith('- ') || line.startsWith('* ');
        const cleanLine = isBullet ? line.replace(/^([•\-\*]\s*)/, '') : line;
        const isLastLine = lineIdx === lines.length - 1;

        // Parse bold segments **word** and links [text](url)
        const parts = cleanLine.split(/(\*\*[^*]+\*\*|\[[^\]]+\]\([^)]+\))/g);
        const renderedParts = parts.map((part, pIdx) => {
          if (part.startsWith('**') && part.endsWith('**')) {
            return (
              <strong key={pIdx} className="font-semibold text-white">
                {part.slice(2, -2)}
              </strong>
            );
          }

          // Markdown links: [Title](URL)
          const linkMatch = part.match(/^\[([^\]]+)\]\(([^)]+)\)$/);
          if (linkMatch) {
            return (
              <a
                key={pIdx}
                href={linkMatch[2]}
                target="_blank"
                rel="noopener noreferrer"
                className="text-[#ff3b30] hover:text-white underline font-medium transition-colors"
              >
                {linkMatch[1]}
              </a>
            );
          }

          return part;
        });

        if (isBullet) {
          return (
            <div key={lineIdx} className="flex items-start gap-1.5 pl-1 text-slate-200">
              <span className="text-[#ff3b30] font-bold text-xs mt-0.5">•</span>
              <span className="flex-1">
                {renderedParts}
                {isStreaming && isLastLine && (
                  <span className="inline-block w-1.5 h-3.5 bg-[#ff3b30] ml-1 animate-pulse rounded-sm align-middle" />
                )}
              </span>
            </div>
          );
        }

        return (
          <p key={lineIdx} className="m-0 text-slate-200">
            {renderedParts}
            {isStreaming && isLastLine && (
              <span className="inline-block w-1.5 h-3.5 bg-[#ff3b30] ml-1 animate-pulse rounded-sm align-middle" />
            )}
          </p>
        );
      })}
      {isStreaming && lines.length === 0 && (
        <span className="inline-block w-1.5 h-3.5 bg-[#ff3b30] animate-pulse rounded-sm align-middle" />
      )}
    </div>
  );
}

export default function AIChatbot({ onOpenInquiry, onOpenAudit }) {
  const [isOpen, setIsOpen] = useState(false);
  const [input, setInput] = useState('');
  const [isLoading, setIsLoading] = useState(false);
  const [providerBadge, setProviderBadge] = useState('Online');

  const [sessionId, setSessionId] = useState('');
  // On every initial load, ONLY show the fresh welcome message
  const [messages, setMessages] = useState([WELCOME_MESSAGE]);

  const messagesEndRef = useRef(null);
  const inputRef = useRef(null);
  const streamingTimerRef = useRef(null);

  // Initialize fresh session ID on page load (starts cleanly with only welcome message)
  useEffect(() => {
    const freshSid = 'wr_' + Date.now() + '_' + Math.random().toString(36).substring(2, 9);
    setSessionId(freshSid);

    return () => {
      if (streamingTimerRef.current) {
        clearInterval(streamingTimerRef.current);
      }
    };
  }, []);

  const scrollToBottom = () => {
    messagesEndRef.current?.scrollIntoView({ behavior: 'smooth' });
  };

  useEffect(() => {
    if (isOpen) {
      scrollToBottom();
      setTimeout(() => inputRef.current?.focus(), 150);
    }
  }, [isOpen, messages, isLoading]);

  // Subtle audio ping on incoming message
  const playChime = () => {
    try {
      const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
      const osc = audioCtx.createOscillator();
      const gain = audioCtx.createGain();
      osc.type = 'sine';
      osc.frequency.setValueAtTime(587.33, audioCtx.currentTime);
      osc.frequency.exponentialRampToValueAtTime(880, audioCtx.currentTime + 0.12);
      gain.gain.setValueAtTime(0.04, audioCtx.currentTime);
      gain.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + 0.18);
      osc.connect(gain);
      gain.connect(audioCtx.destination);
      osc.start();
      osc.stop(audioCtx.currentTime + 0.2);
    } catch (e) {}
  };

  // Real-time progressive token streamer (creates genuine generative AI streaming feel)
  const streamBotResponse = (fullText, quickReplies, provider) => {
    if (provider) {
      if (provider.includes('groq')) {
        setProviderBadge('Groq RAG AI');
      } else if (provider.includes('gemini')) {
        setProviderBadge('Gemini RAG');
      } else if (provider.includes('guardrail')) {
        setProviderBadge('Grounded Guardrail');
      } else {
        setProviderBadge('WebRanker AI');
      }
    }

    if (streamingTimerRef.current) {
      clearInterval(streamingTimerRef.current);
    }

    // Split text into tokens / words preserving spaces
    const tokens = fullText.split(/(\s+)/);
    let currentText = '';
    let tokenIndex = 0;

    // Append streaming message placeholder
    setMessages((prev) => [
      ...prev,
      {
        role: 'bot',
        text: '',
        isStreaming: true,
        quick_replies: [],
      },
    ]);
    setIsLoading(false);

    streamingTimerRef.current = setInterval(() => {
      if (tokenIndex < tokens.length) {
        currentText += tokens[tokenIndex];
        tokenIndex++;

        setMessages((prev) => {
          const updated = [...prev];
          const lastIdx = updated.length - 1;
          if (updated[lastIdx] && updated[lastIdx].role === 'bot') {
            updated[lastIdx] = {
              ...updated[lastIdx],
              text: currentText,
              isStreaming: true,
            };
          }
          return updated;
        });

        scrollToBottom();
      } else {
        clearInterval(streamingTimerRef.current);
        streamingTimerRef.current = null;

        setMessages((prev) => {
          const updated = [...prev];
          const lastIdx = updated.length - 1;
          if (updated[lastIdx] && updated[lastIdx].role === 'bot') {
            updated[lastIdx] = {
              ...updated[lastIdx],
              text: fullText,
              isStreaming: false,
              quick_replies: quickReplies || [],
            };
          }
          return updated;
        });

        playChime();
        scrollToBottom();
      }
    }, 16); // 16ms high-speed, fluid real-time streaming cadence
  };

  // Send message to free backend
  const handleSendMessage = async (textToSend, displayText) => {
    const userText = (textToSend || input).trim();
    if (!userText || isLoading) return;

    if (streamingTimerRef.current) {
      clearInterval(streamingTimerRef.current);
      streamingTimerRef.current = null;
    }

    const bubbleLabel = displayText || userText;
    const newHistory = [...messages, { role: 'user', text: bubbleLabel }];
    setMessages(newHistory);
    setInput('');
    setIsLoading(true);

    try {
      const response = await fetch('/api/ai/chat', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({
          message: userText,
          session_id: sessionId,
          history: newHistory.slice(-8).map((m) => ({
            role: m.role === 'bot' ? 'assistant' : 'user',
            text: m.text,
          })),
        }),
      });

      const data = await response.json();
      const replyText = data.reply || "I'm here to help you scale. Would you like to connect directly on WhatsApp (+91 97185 70218) or schedule a consultation with our Principal Engineer?";

      streamBotResponse(replyText, data.quick_replies || [], data.provider);
    } catch (error) {
      console.error('AI chat failed:', error);
      const fallbackText = "Our senior technology team is available to review your project! You can connect with us directly on WhatsApp (+91 97185 70218), via email at info@webranker.in, or click 'Schedule Consultation' below.";
      streamBotResponse(fallbackText, [
        { label: 'Chat on WhatsApp', action: 'whatsapp' },
        { label: 'Schedule Consultation', action: 'consult' },
        { label: 'Our Core Services', action: 'message' },
      ], 'fallback');
    }
  };

  // Quick Action Handler - Routes clicks to exact service details
  const handleQuickAction = (chip) => {
    if (chip.action === 'whatsapp') {
      window.open(
        'https://wa.me/919718570218?text=Hi%20WebRanker%20Team%2C%20I%20would%20like%20to%20discuss%20a%20project%20and%20get%20service%20details.',
        '_blank'
      );
      return;
    }

    if (chip.action === 'consult') {
      if (typeof onOpenInquiry === 'function') {
        onOpenInquiry();
      }
      return;
    }

    if (chip.action === 'audit') {
      if (typeof onOpenAudit === 'function') {
        onOpenAudit();
        return;
      }
      handleSendMessage(
        'How can I claim the complimentary 48-Hour Technical SEO & Core Web Vitals Audit for my website domain? Give me a concise answer in bullet points, no markdown tables.',
        'Claim Free Audit'
      );
      return;
    }

    // Determine targeted prompt for the clicked service
    let prompt = chip.prompt || chip.label;
    if (!chip.prompt) {
      const lower = chip.label.toLowerCase();
      if (lower.includes('tech stack') || lower.includes('stack') || lower.includes('technology')) {
        prompt = 'Which technology should I choose for my project (Laravel, FastAPI, Node.js, React, Next.js, WordPress)? Explain how you evaluate requirements.';
      } else if (lower.includes('api') || lower.includes('payment') || lower.includes('gateway') || lower.includes('integration')) {
        prompt = 'Can you integrate payment gateways and third-party APIs (Stripe, Razorpay, CRMs, Shipping, Maps)? Give a concise breakdown in bullet points.';
      } else if (lower.includes('ecommerce') || lower.includes('shop') || lower.includes('store')) {
        prompt = 'Can you build a custom e-commerce website? What features and integrations are included? Use clean bullet points.';
      } else if (lower.includes('redesign') || lower.includes('revamp')) {
        prompt = 'Can you redesign my existing website to improve page speed, UI/UX, and SEO? What does the redesign process include?';
      } else if (lower.includes('fast') || lower.includes('vitals') || lower.includes('speed')) {
        prompt = 'How do you build a fast, mobile-friendly, and SEO-ready website optimized for Core Web Vitals? Give details in clean bullet points.';
      } else if (lower.includes('seo') || lower.includes('rank') || lower.includes('organic')) {
        prompt = 'Tell me in detail about WebRanker Technical SEO and Organic Keyword Ranking services. Use concise bullet points, no markdown tables.';
      } else if (lower.includes('web') || lower.includes('development') || lower.includes('laravel') || lower.includes('next')) {
        prompt = 'Tell me in detail about WebRanker Custom Web Development services (Laravel, Next.js, React, Python/FastAPI, Node.js). Use concise bullet points.';
      } else if (lower.includes('ppc') || lower.includes('ad') || lower.includes('google ads')) {
        prompt = 'Tell me in detail about WebRanker PPC and Paid Performance Advertising services (Google Ads, Meta Ads). Use concise bullet points, no markdown tables.';
      } else if (lower.includes('service')) {
        prompt = 'Give me a comprehensive breakdown of all core services offered by WebRanker. Use concise bullet points, no markdown tables.';
      } else if (lower.includes('mobile') || lower.includes('app')) {
        prompt = 'Tell me in detail about WebRanker Mobile App Engineering services (Flutter, iOS, Android). Use concise bullet points, no markdown tables.';
      }
    }

    handleSendMessage(prompt, chip.label);
  };

  // Reset / Clear Conversation
  const handleClearHistory = () => {
    if (streamingTimerRef.current) {
      clearInterval(streamingTimerRef.current);
      streamingTimerRef.current = null;
    }
    const newSid = 'wr_' + Date.now() + '_' + Math.random().toString(36).substring(2, 9);
    setSessionId(newSid);
    setMessages([WELCOME_MESSAGE]);
  };

  const handleKeyDown = (e) => {
    if (e.key === 'Enter' && !e.shiftKey) {
      e.preventDefault();
      handleSendMessage();
    }
  };

  return (
    <div
      id="aiChatbotWidget"
      className={`ds-chat-widget fixed bottom-6 right-6 z-[9990] ${isOpen ? 'is-open pointer-events-auto' : 'pointer-events-none'}`}
    >
      {/* Clean, Premium AI Chat Window */}
      <div
        id="chatWindow"
        className="ds-chat-window !clip-path-none !rounded-2xl !w-[380px] sm:!w-[410px] !max-w-[calc(100vw-1.5rem)] !h-[550px] !max-h-[calc(100dvh-6.5rem)] overflow-hidden shadow-2xl transition-all duration-300"
        style={{
          boxShadow: '0 25px 60px -12px rgba(0, 0, 0, 0.7), 0 0 0 1px rgba(255, 255, 255, 0.12)',
          background: '#161514',
        }}
      >
        <div className="ds-chat-window-inner !clip-path-none !rounded-2xl flex flex-col h-full !bg-[#161514] text-white select-text">
          {/* Header: Clean, Uncluttered, No Overlapping */}
          <div className="flex items-center justify-between px-3.5 py-3 bg-[#1e1c1a] border-b border-white/10 flex-shrink-0">
            {/* Identity & Status */}
            <div className="flex items-center gap-2.5 min-w-0 pr-2">
              <div className="relative w-9 h-9 rounded-xl bg-gradient-to-tr from-[#ff3b30] to-orange-500 p-0.5 flex items-center justify-center flex-shrink-0 shadow-lg shadow-red-500/20">
                <img
                  src="/asset/chatbot_icon.png"
                  alt="WebRanker Assistant"
                  className="w-full h-full object-contain rounded-lg p-0.5"
                />
                <span className="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-500 border-2 border-[#161514] rounded-full"></span>
              </div>
              <div className="min-w-0">
                <h4 className="font-bold text-xs tracking-tight text-white truncate m-0 leading-tight">
                  WebRanker AI
                </h4>
                <p className="text-[10px] text-slate-400 flex items-center gap-1.5 m-0 mt-0.5 leading-tight">
                  <span className="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                  <span className="text-emerald-400 font-medium">{providerBadge}</span>
                  <span className="text-slate-500">·</span>
                  <span className="text-slate-400">Tech & Growth</span>
                </p>
              </div>
            </div>

            {/* Header Actions: WhatsApp, Book, Reset, Close */}
            <div className="flex items-center gap-1 flex-shrink-0">
              <a
                href="https://wa.me/919718570218?text=Hi%20WebRanker%20Team%2C%20I%20would%20like%20to%20discuss%20a%20project."
                target="_blank"
                rel="noopener noreferrer"
                className="w-7 h-7 rounded-lg bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400 flex items-center justify-center transition-colors"
                title="Chat on WhatsApp"
              >
                <i className="fab fa-whatsapp text-xs"></i>
              </a>

              <button
                type="button"
                onClick={onOpenInquiry}
                className="w-7 h-7 rounded-lg bg-white/5 hover:bg-white/10 text-slate-300 hover:text-white flex items-center justify-center transition-colors"
                title="Schedule Consultation"
              >
                <i className="fas fa-calendar-check text-xs"></i>
              </button>

              <button
                type="button"
                onClick={handleClearHistory}
                className="w-7 h-7 rounded-lg bg-white/5 hover:bg-white/10 text-slate-400 hover:text-white flex items-center justify-center transition-colors"
                title="Reset Chat"
              >
                <i className="fas fa-rotate-right text-xs"></i>
              </button>

              <button
                id="closeChatBtn"
                className="w-7 h-7 rounded-lg bg-white/5 hover:bg-red-500/20 text-slate-400 hover:text-[#ff3b30] flex items-center justify-center transition-colors ml-0.5"
                type="button"
                aria-label="Close chat"
                onClick={() => setIsOpen(false)}
              >
                <i className="fas fa-times text-xs"></i>
              </button>
            </div>
          </div>

          {/* Messages Area */}
          <div
            id="chatMessages"
            className="flex-1 overflow-y-auto p-3.5 space-y-3 bg-[#161514] text-slate-200"
          >
            {messages.map((m, idx) => {
              const isBot = m.role === 'bot' || m.role === 'assistant';
              return (
                <div key={idx} className={`flex flex-col ${isBot ? 'items-start' : 'items-end'}`}>
                  <div className={`flex items-end gap-2 max-w-[88%] ${isBot ? 'flex-row' : 'flex-row-reverse'}`}>
                    {isBot && (
                      <div className="w-6 h-6 rounded-lg bg-gradient-to-tr from-[#ff3b30] to-orange-500 flex items-center justify-center flex-shrink-0 mb-0.5 shadow-sm shadow-red-500/20">
                        <img src="/asset/chatbot_icon.png" alt="Bot" className="w-5 h-5 object-contain" />
                      </div>
                    )}
                    <div
                      className={`px-3.5 py-2.5 rounded-2xl text-[12.5px] leading-relaxed shadow-sm ${
                        isBot
                          ? 'bg-[#22201e] text-slate-100 rounded-bl-none border border-white/10'
                          : 'bg-[#ff3b30] text-white rounded-br-none font-normal'
                      }`}
                    >
                      {isBot ? (
                        <FormattedMessageText text={m.text} isStreaming={m.isStreaming} />
                      ) : (
                        <p className="m-0 whitespace-pre-wrap">{m.text}</p>
                      )}
                    </div>
                  </div>

                  {/* Contextual Quick Reply Chips (fades in once streaming is done) */}
                  {isBot && !m.isStreaming && Array.isArray(m.quick_replies) && m.quick_replies.length > 0 && idx === messages.length - 1 && (
                    <div className="flex flex-wrap gap-1.5 mt-2.5 pl-8 max-w-full">
                      {m.quick_replies.map((chip, cIdx) => {
                        const label = typeof chip === 'string' ? chip : chip.label;
                        const action = typeof chip === 'string' ? 'message' : chip.action;
                        const isConsult = action === 'consult';
                        const isWhatsapp = action === 'whatsapp';
                        const isAudit = action === 'audit';

                        return (
                          <button
                            key={cIdx}
                            type="button"
                            onClick={() => handleQuickAction(typeof chip === 'string' ? { label, action } : chip)}
                            className={`text-[11px] px-2.5 py-1 rounded-full border transition-all text-left flex items-center gap-1.5 shadow-sm active:scale-95 ${
                              isWhatsapp
                                ? 'bg-emerald-500/15 hover:bg-emerald-500 text-emerald-400 hover:text-white border-emerald-500/35 font-medium'
                                : isConsult
                                ? 'bg-[#ff3b30]/15 hover:bg-[#ff3b30] text-[#ff3b30] hover:text-white border-[#ff3b30]/35 font-medium'
                                : isAudit
                                ? 'bg-orange-500/15 hover:bg-orange-500 text-orange-400 hover:text-white border-orange-500/35 font-medium'
                                : 'bg-[#22201e] hover:bg-[#2e2a27] text-slate-200 border-white/10 hover:border-white/20'
                            }`}
                          >
                            {isWhatsapp && <i className="fab fa-whatsapp text-xs"></i>}
                            {isConsult && <i className="fas fa-calendar-check text-[10px]"></i>}
                            {isAudit && <i className="fas fa-bolt text-[10px]"></i>}
                            {label}
                          </button>
                        );
                      })}
                    </div>
                  )}
                </div>
              );
            })}

            {/* Typing Indicator */}
            {isLoading && (
              <div className="flex items-end gap-2 max-w-[85%]">
                <div className="w-6 h-6 rounded-lg bg-gradient-to-tr from-[#ff3b30] to-orange-500 flex items-center justify-center flex-shrink-0 mb-0.5">
                  <img src="/asset/chatbot_icon.png" alt="Bot" className="w-5 h-5 object-contain" />
                </div>
                <div className="px-3.5 py-2.5 rounded-2xl rounded-bl-none bg-[#22201e] border border-white/10 flex items-center gap-1.5">
                  <span className="w-1.5 h-1.5 rounded-full bg-[#ff3b30] animate-bounce"></span>
                  <span className="w-1.5 h-1.5 rounded-full bg-[#ff3b30] animate-bounce [animation-delay:0.15s]"></span>
                  <span className="w-1.5 h-1.5 rounded-full bg-[#ff3b30] animate-bounce [animation-delay:0.3s]"></span>
                  <span className="text-[11px] text-slate-400 font-medium ml-1">Analyzing...</span>
                </div>
              </div>
            )}

            <div ref={messagesEndRef} />
          </div>

          {/* Clean Sub-Bar: Direct Trust Links */}
          <div className="px-3.5 py-1.5 bg-[#1a1817] border-t border-white/5 flex items-center justify-between text-[11px] text-slate-400 flex-shrink-0">
            <a
              href="https://wa.me/919718570218?text=Hi%20WebRanker%20Team%2C%20I%20would%20like%20to%20discuss%20a%20project."
              target="_blank"
              rel="noopener noreferrer"
              className="text-emerald-400 hover:underline flex items-center gap-1 font-medium truncate"
            >
              <i className="fab fa-whatsapp"></i> WhatsApp: +91 97185 70218
            </a>
            <button
              type="button"
              onClick={onOpenInquiry}
              className="text-[#ff3b30] hover:underline font-medium whitespace-nowrap ml-2 flex items-center gap-0.5 flex-shrink-0"
            >
              Consult Architect <i className="fas fa-chevron-right text-[8px]"></i>
            </button>
          </div>

          {/* Composer */}
          <div className="p-2.5 bg-[#1e1c1a] border-t border-white/10 flex items-center gap-2 flex-shrink-0">
            <input
              ref={inputRef}
              type="text"
              id="chatInput"
              placeholder="Ask about Web Dev, SEO, PPC Ads..."
              autoComplete="off"
              value={input}
              disabled={isLoading}
              onChange={(e) => setInput(e.target.value)}
              onKeyDown={handleKeyDown}
              className="flex-1 bg-[#141312] border border-white/10 focus:border-[#ff3b30] text-white text-xs px-3.5 py-2.5 rounded-xl outline-none transition-colors placeholder-slate-500 disabled:opacity-50"
            />
            <button
              type="button"
              id="sendBtn"
              aria-label="Send message"
              disabled={isLoading || !input.trim()}
              onClick={() => handleSendMessage()}
              className="w-9 h-9 flex items-center justify-center bg-[#ff3b30] hover:bg-[#e03126] text-white rounded-xl transition-all active:scale-95 disabled:opacity-40 disabled:hover:bg-[#ff3b30] disabled:cursor-not-allowed flex-shrink-0 shadow-lg shadow-red-500/20"
            >
              {isLoading ? (
                <i className="fas fa-spinner fa-spin text-xs"></i>
              ) : (
                <i className="fas fa-paper-plane text-xs"></i>
              )}
            </button>
          </div>
        </div>
      </div>

      {/* Floating Animated 3D Launcher Button */}
      <button
        id="chatToggleBtn"
        className="ds-chat-launcher relative cursor-pointer pointer-events-auto group outline-none"
        type="button"
        aria-label={isOpen ? 'Close WebRanker Assistant' : 'Open WebRanker Assistant'}
        onClick={() => setIsOpen(!isOpen)}
      >
        <span className="ds-chat-launcher-glow" aria-hidden="true"></span>
        <span className="ds-chat-launcher-ring" aria-hidden="true"></span>
        <span className="ds-chat-launcher-float flex items-center justify-center transition-transform group-hover:scale-105">
          <img
            src="/asset/chatbot_icon.png"
            alt="WebRanker Assistant"
            className="w-full h-full object-contain drop-shadow-2xl"
          />
        </span>

        {/* Free AI Chip Badge */}
        {!isOpen && (
          <span className="absolute -top-1 -left-2 bg-[#ff3b30] text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full shadow-lg border border-black/30 animate-pulse pointer-events-none tracking-wider">
            FREE AI
          </span>
        )}
      </button>
    </div>
  );
}
