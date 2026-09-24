import React, { useState } from 'react';
import { useForm, usePage } from '@inertiajs/react';

export default function LinkRequestModal({ isOpen, onClose, targetPageUrl = '', targetPageTitle = '' }) {
  const [submitted, setSubmitted] = useState(false);
  const [errorMessage, setErrorMessage] = useState('');

  const { data, setData, post, processing, errors, reset } = useForm({
    client_name: '',
    client_email: '',
    client_company: '',
    client_website: '',
    target_page_url: targetPageUrl || (typeof window !== 'undefined' ? window.location.href : ''),
    target_page_title: targetPageTitle || 'WebRanker Page',
    requested_anchor_text: '',
    target_link_url: '',
    link_type: 'link_insertion',
    budget_offer: '$250 - $500',
    proposed_context: '',
    message: '',
  });

  React.useEffect(() => {
    if (targetPageUrl) setData('target_page_url', targetPageUrl);
    if (targetPageTitle) setData('target_page_title', targetPageTitle);
  }, [targetPageUrl, targetPageTitle]);

  if (!isOpen) return null;

  const handleSubmit = (e) => {
    e.preventDefault();
    setErrorMessage('');

    post('/link-request', {
      preserveScroll: true,
      onSuccess: () => {
        setSubmitted(true);
        reset();
      },
      onError: (errs) => {
        const firstErr = Object.values(errs)[0];
        setErrorMessage(firstErr || 'Please check your inputs and try again.');
      },
    });
  };

  return (
    <div className="fixed inset-0 z-[10010] flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-sm">
      <div className="relative w-full max-w-xl bg-white rounded-3xl p-6 sm:p-8 shadow-2xl border border-slate-200 max-h-[90vh] overflow-y-auto">
        <button
          type="button"
          onClick={onClose}
          className="absolute top-5 right-5 text-slate-400 hover:text-slate-700 text-xl w-8 h-8 rounded-full flex items-center justify-center hover:bg-slate-100 transition-colors"
        >
          <i className="fas fa-times"></i>
        </button>

        {submitted ? (
          <div className="py-8 text-center">
            <div className="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
              <i className="fas fa-check"></i>
            </div>
            <h3 className="text-xl font-bold text-slate-900 mb-2">Request Submitted!</h3>
            <p className="text-sm text-slate-600 mb-6 max-w-md mx-auto">
              Thank you! Your link placement &amp; editorial collaboration request has been submitted. Our editorial team will review your target URL and respond within 24 hours.
            </p>
            <button
              type="button"
              onClick={() => {
                setSubmitted(false);
                onClose();
              }}
              className="px-6 py-2.5 bg-[#161514] hover:bg-[#ff3b30] text-white text-xs font-bold rounded-xl transition-colors"
            >
              Done
            </button>
          </div>
        ) : (
          <form onSubmit={handleSubmit} className="space-y-4">
            <div>
              <span className="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-[#ff3b30]/10 text-[#ff3b30] text-xs font-bold uppercase tracking-wider mb-2">
                <i className="fas fa-link text-[10px]"></i> Sponsored Collaboration
              </span>
              <h3 className="text-2xl font-black text-slate-900">Request Link Insertion / Guest Feature</h3>
              <p className="text-xs text-slate-500 mt-1">
                Collaborate with WebRanker's high-authority domain. All placements are manually reviewed for editorial relevance.
              </p>
            </div>

            <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
              <div>
                <label className="block text-xs font-bold text-slate-700 mb-1">Your Name *</label>
                <input
                  type="text"
                  required
                  placeholder="Sarah Jenkins"
                  value={data.client_name}
                  onChange={(e) => setData('client_name', e.target.value)}
                  className="w-full px-3 py-2 text-sm border border-slate-300 rounded-xl focus:outline-none focus:border-[#ff3b30]"
                />
                {errors.client_name && <p className="text-xs text-red-600 mt-0.5">{errors.client_name}</p>}
              </div>
              <div>
                <label className="block text-xs font-bold text-slate-700 mb-1">Your Email *</label>
                <input
                  type="email"
                  required
                  placeholder="sarah@agency.com"
                  value={data.client_email}
                  onChange={(e) => setData('client_email', e.target.value)}
                  className="w-full px-3 py-2 text-sm border border-slate-300 rounded-xl focus:outline-none focus:border-[#ff3b30]"
                />
                {errors.client_email && <p className="text-xs text-red-600 mt-0.5">{errors.client_email}</p>}
              </div>
            </div>

            <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
              <div>
                <label className="block text-xs font-bold text-slate-700 mb-1">Your Website / Client Domain</label>
                <input
                  type="url"
                  placeholder="https://yourbrand.com"
                  value={data.client_website}
                  onChange={(e) => setData('client_website', e.target.value)}
                  className="w-full px-3 py-2 text-sm border border-slate-300 rounded-xl focus:outline-none focus:border-[#ff3b30]"
                />
              </div>
              <div>
                <label className="block text-xs font-bold text-slate-700 mb-1">Collaboration Type</label>
                <select
                  value={data.link_type}
                  onChange={(e) => setData('link_type', e.target.value)}
                  className="w-full px-3 py-2 text-sm border border-slate-300 rounded-xl bg-white focus:outline-none focus:border-[#ff3b30]"
                >
                  <option value="link_insertion">Existing Article Link Insertion</option>
                  <option value="guest_post">New Sponsored Guest Post</option>
                  <option value="sponsored_feature">Service / Product Review</option>
                  <option value="service_partnership">Agency White-label Partnership</option>
                </select>
              </div>
            </div>

            <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
              <div>
                <label className="block text-xs font-bold text-slate-700 mb-1">Target Anchor Text</label>
                <input
                  type="text"
                  placeholder="e.g. enterprise ecommerce solutions"
                  value={data.requested_anchor_text}
                  onChange={(e) => setData('requested_anchor_text', e.target.value)}
                  className="w-full px-3 py-2 text-sm border border-slate-300 rounded-xl focus:outline-none focus:border-[#ff3b30]"
                />
              </div>
              <div>
                <label className="block text-xs font-bold text-slate-700 mb-1">Target Landing Page URL</label>
                <input
                  type="url"
                  placeholder="https://yourbrand.com/landing"
                  value={data.target_link_url}
                  onChange={(e) => setData('target_link_url', e.target.value)}
                  className="w-full px-3 py-2 text-sm border border-slate-300 rounded-xl focus:outline-none focus:border-[#ff3b30]"
                />
              </div>
            </div>

            <div>
              <label className="block text-xs font-bold text-slate-700 mb-1">Proposed Budget / Compensation</label>
              <select
                value={data.budget_offer}
                onChange={(e) => setData('budget_offer', e.target.value)}
                className="w-full px-3 py-2 text-sm border border-slate-300 rounded-xl bg-white focus:outline-none focus:border-[#ff3b30]"
              >
                <option value="<$250">&lt; $250</option>
                <option value="$250 - $500">$250 - $500 (Standard)</option>
                <option value="$500 - $1,000">$500 - $1,000 (Priority Placement)</option>
                <option value="$1,000+">$1,000+ (Featured Partner)</option>
              </select>
            </div>

            <div>
              <label className="block text-xs font-bold text-slate-700 mb-1">Proposed Sentence / Context</label>
              <textarea
                rows="2"
                placeholder="Include snippet or paragraph showing where the link naturally fits..."
                value={data.proposed_context}
                onChange={(e) => setData('proposed_context', e.target.value)}
                className="w-full px-3 py-2 text-sm border border-slate-300 rounded-xl focus:outline-none focus:border-[#ff3b30]"
              />
            </div>

            {errorMessage && (
              <div className="p-3 bg-red-50 border border-red-200 text-red-700 text-xs rounded-xl">
                {errorMessage}
              </div>
            )}

            <button
              type="submit"
              disabled={processing}
              className="w-full py-3 bg-[#161514] hover:bg-[#ff3b30] text-white font-bold rounded-xl transition-all text-sm flex items-center justify-center gap-2 disabled:opacity-50"
            >
              {processing ? (
                <>
                  <span>Processing...</span>
                  <i className="fas fa-spinner fa-spin text-xs"></i>
                </>
              ) : (
                <>
                  <span>Submit Collaboration Request</span>
                  <i className="fas fa-arrow-right text-xs"></i>
                </>
              )}
            </button>
          </form>
        )}
      </div>
    </div>
  );
}
