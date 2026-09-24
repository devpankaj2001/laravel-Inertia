import React, { useState, useEffect } from 'react';
import { useForm, usePage } from '@inertiajs/react';

export default function InquiryDrawer({ isOpen, onClose, onOpen, onToggle }) {
  const { flash = {} } = usePage().props;
  const [submitted, setSubmitted] = useState(false);
  const [errorMessage, setErrorMessage] = useState('');
  const [captchaCode, setCaptchaCode] = useState('');
  const [captchaInput, setCaptchaInput] = useState('');
  const [captchaError, setCaptchaError] = useState('');
  const [isRefreshing, setIsRefreshing] = useState(false);

  const { data, setData, post, processing, errors, reset } = useForm({
    name: '',
    email: '',
    phone: '',
    company: '',
    service_interest: 'Inbound Website Inquiry',
    budget: '',
    message: '',
    website_hp: '', // honeypot
  });

  const generateCaptcha = () => {
    const chars = '23456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz';
    let code = '';
    for (let i = 0; i < 6; i++) {
      code += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    setCaptchaCode(code);
    setCaptchaInput('');
    setCaptchaError('');
  };

  useEffect(() => {
    if (isOpen) {
      document.body.style.overflow = 'hidden';
      generateCaptcha();
      setSubmitted(false);
      setErrorMessage('');
    } else {
      document.body.style.overflow = '';
    }
    return () => {
      document.body.style.overflow = '';
    };
  }, [isOpen]);

  const handleRefreshCaptcha = (e) => {
    if (e) e.preventDefault();
    setIsRefreshing(true);
    generateCaptcha();
    setTimeout(() => setIsRefreshing(false), 350);
  };

  const handleToggleTab = (e) => {
    e.preventDefault();
    e.stopPropagation();
    if (onToggle) {
      onToggle();
    } else if (isOpen) {
      if (onClose) onClose(false);
    } else {
      if (onOpen) onOpen();
      else if (onClose) onClose(true);
    }
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    setErrorMessage('');
    setCaptchaError('');

    if (captchaInput.trim().toLowerCase() !== captchaCode.toLowerCase()) {
      setCaptchaError('Verification code does not match. Please try again.');
      generateCaptcha();
      return;
    }

    post('/inquiry', {
      preserveScroll: true,
      onSuccess: () => {
        setSubmitted(true);
        reset();
      },
      onError: (errs) => {
        const firstErr = Object.values(errs)[0];
        setErrorMessage(firstErr || 'Please check your inputs and try again.');
        generateCaptcha();
      },
    });
  };

  return (
    <>
      {/* Floating Side Tab Trigger (Fixed on right viewport edge) */}
      <div className="ds-git-widget fixed right-0 top-1/2 -translate-y-1/2 z-[10001] pointer-events-auto" id="dsGetInTouchWidget">
        <button
          type="button"
          className="ds-git-tab bg-[#161514] hover:bg-[#ff3b30] text-white py-3.5 px-2 rounded-l-xl text-xs font-bold shadow-2xl flex items-center gap-1.5 transition-colors [writing-mode:vertical-rl] rotate-180 cursor-pointer"
          id="dsGitTabBtn"
          aria-expanded={isOpen}
          onClick={handleToggleTab}
          title="Get in Touch"
        >
          <span className="ds-git-tab-text">Get in Touch</span>
        </button>
      </div>

      {/* Right-Side Popup Modal matching User Design */}
      {isOpen && (
        <div
          className="consult-modal-backdrop"
          id="dsGitBackdrop"
          onClick={(e) => {
            if (e.target.id === 'dsGitBackdrop') onClose(false);
          }}
          role="dialog"
          aria-modal="true"
          aria-labelledby="dsGitDrawerTitle"
        >
          <div
            className="consult-modal-card"
            id="dsGitDrawer"
            onClick={(e) => e.stopPropagation()}
          >
            {/* Close Button */}
            <button
              type="button"
              className="consult-modal-close"
              onClick={() => onClose(false)}
              aria-label="Close form"
            >
              <i className="fas fa-times text-base"></i>
            </button>

            {/* Modal Header */}
            <div className="consult-form-head flex items-center justify-between pb-3 border-b border-[#ece6db] mb-5">
              <div>
                <p className="consult-form-label">INQUIRY</p>
                <h3 id="dsGitDrawerTitle" className="text-2xl font-black text-[#1e2540] tracking-tight">
                  Send Us a Message
                </h3>
              </div>
            </div>

            {submitted ? (
              <div className="py-8 text-center space-y-4">
                <div className="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto text-2xl shadow-inner">
                  <i className="fas fa-check"></i>
                </div>
                <h4 className="text-xl font-extrabold text-[#161514]">Inquiry Received!</h4>
                <p className="text-sm text-[#6e675f] leading-relaxed max-w-sm mx-auto">
                  Thank you! Your inquiry has been submitted. Our senior strategist will review your requirements and reach out within 24 hours.
                </p>
                <button
                  type="button"
                  onClick={() => {
                    setSubmitted(false);
                    onClose(false);
                  }}
                  className="px-6 py-2.5 bg-[#0f152f] hover:bg-[#ff3b30] text-white text-xs font-bold uppercase tracking-wider transition-colors shadow-md"
                >
                  Close
                </button>
              </div>
            ) : (
              <form onSubmit={handleSubmit} className="consult-form space-y-4">
                {/* Honeypot field */}
                <input
                  type="text"
                  name="website_hp"
                  value={data.website_hp}
                  onChange={(e) => setData('website_hp', e.target.value)}
                  style={{ display: 'none' }}
                  tabIndex="-1"
                  autoComplete="off"
                />

                {/* Your Full Name */}
                <label className="consult-field block">
                  <span className="block text-xs font-bold text-[#161514] mb-1">Your Full Name</span>
                  <input
                    type="text"
                    required
                    placeholder="Enter name here"
                    value={data.name}
                    onChange={(e) => setData('name', e.target.value)}
                    className="w-full px-3.5 py-2.5 text-sm border border-[#e6dfd3] bg-[#faf7f2] focus:bg-white focus:border-[#ff3b30] focus:outline-none transition-colors"
                  />
                  {errors.name && <p className="text-xs text-red-600 mt-1">{errors.name}</p>}
                </label>

                {/* Two-Column Row: Phone Number & Email Address */}
                <div className="consult-field-row grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                  <label className="consult-field block">
                    <span className="block text-xs font-bold text-[#161514] mb-1">Phone Number</span>
                    <input
                      type="tel"
                      required
                      placeholder="Phone Number"
                      value={data.phone}
                      onChange={(e) => setData('phone', e.target.value)}
                      className="w-full px-3.5 py-2.5 text-sm border border-[#e6dfd3] bg-[#faf7f2] focus:bg-white focus:border-[#ff3b30] focus:outline-none transition-colors"
                    />
                    {errors.phone && <p className="text-xs text-red-600 mt-1">{errors.phone}</p>}
                  </label>

                  <label className="consult-field block">
                    <span className="block text-xs font-bold text-[#161514] mb-1">Email Address</span>
                    <input
                      type="email"
                      required
                      placeholder="Email Address"
                      value={data.email}
                      onChange={(e) => setData('email', e.target.value)}
                      className="w-full px-3.5 py-2.5 text-sm border border-[#e6dfd3] bg-[#faf7f2] focus:bg-white focus:border-[#ff3b30] focus:outline-none transition-colors"
                    />
                    {errors.email && <p className="text-xs text-red-600 mt-1">{errors.email}</p>}
                  </label>
                </div>

                {/* Project Message */}
                <label className="consult-field block">
                  <span className="block text-xs font-bold text-[#161514] mb-1">Project Message</span>
                  <textarea
                    rows="3"
                    required
                    placeholder="Drop project details here"
                    value={data.message}
                    onChange={(e) => setData('message', e.target.value)}
                    className="w-full px-3.5 py-2.5 text-sm border border-[#e6dfd3] bg-[#faf7f2] focus:bg-white focus:border-[#ff3b30] focus:outline-none transition-colors resize-none"
                  />
                  {errors.message && <p className="text-xs text-red-600 mt-1">{errors.message}</p>}
                </label>

                {/* Security Verification (Captcha) */}
                <div className="consult-captcha space-y-1">
                  <span className="block text-xs font-bold text-[#161514]">Security Verification</span>
                  <div className="consult-captcha-row flex items-stretch gap-2">
                    {/* Stylized Captcha Code Display */}
                    <div
                      className="consult-captcha-code flex items-center justify-center min-w-[110px] px-3.5 py-2 bg-[#ece4d4] text-[#161514] font-serif font-bold italic tracking-widest text-lg select-none border border-[#e6dfd3]"
                      style={{ letterSpacing: '0.22em' }}
                    >
                      {captchaCode}
                    </div>

                    {/* Refresh Captcha Button */}
                    <button
                      type="button"
                      onClick={handleRefreshCaptcha}
                      className="consult-captcha-refresh w-11 flex items-center justify-center border border-[#e6dfd3] bg-[#faf7f2] hover:bg-[#161514] hover:text-white transition-colors cursor-pointer"
                      title="Refresh verification code"
                      aria-label="Refresh captcha"
                    >
                      <i className={`fas fa-rotate-right text-xs ${isRefreshing ? 'fa-spin' : ''}`}></i>
                    </button>

                    {/* Captcha Input */}
                    <input
                      type="text"
                      required
                      placeholder="Enter code"
                      value={captchaInput}
                      onChange={(e) => setCaptchaInput(e.target.value)}
                      className="flex-1 px-3.5 py-2 text-sm border border-[#e6dfd3] bg-[#faf7f2] focus:bg-white focus:border-[#ff3b30] focus:outline-none transition-colors"
                    />
                  </div>
                  {captchaError && <p className="text-xs text-red-600 font-bold mt-1">{captchaError}</p>}
                </div>

                {errorMessage && (
                  <div className="p-3 bg-red-50 border border-red-200 text-red-700 text-xs font-bold rounded-lg">
                    {errorMessage}
                  </div>
                )}

                {/* Submit Inquiry Chamfered Button */}
                <button
                  type="submit"
                  disabled={processing}
                  className="consult-submit w-full mt-2 py-3 px-5 bg-[#0f152f] hover:bg-black text-white text-xs font-black uppercase tracking-widest flex items-center justify-center gap-2.5 transition-all shadow-md cursor-pointer disabled:opacity-50"
                >
                  {processing ? (
                    <>
                      <span>Submitting...</span>
                      <i className="fas fa-spinner fa-spin text-xs"></i>
                    </>
                  ) : (
                    <>
                      <svg className="w-3 h-3 text-[#ff3b30]" viewBox="0 0 14 16" fill="currentColor">
                        <circle cx="4" cy="4" r="1.5" />
                        <circle cx="4" cy="8" r="1.5" />
                        <circle cx="4" cy="12" r="1.5" />
                      </svg>
                      <span>SUBMIT INQUIRY</span>
                    </>
                  )}
                </button>
              </form>
            )}
          </div>
        </div>
      )}
    </>
  );
}
