import React, { useEffect } from 'react';
import AppLayout from '@/Layouts/AppLayout';

export default function Contact({
  contentHtml,
  services = [],
  contactInfo = {},
  faqs = [],
  seo = {},
}) {
  useEffect(() => {
    // Re-bind interactive form handling for the contact form
    const form = document.getElementById('mainContactPageForm');
    if (!form) return;

    const budgetSelect = document.getElementById('contact_budget_select');
    const budgetFinal = document.getElementById('contact_budget_final');
    const manualContainer = document.getElementById('manualBudgetContainer');
    const manualInput = document.getElementById('manualBudgetInput');

    const handleBudgetChange = () => {
      if (!budgetSelect || !budgetFinal) return;
      if (budgetSelect.value === '__manual__') {
        if (manualContainer) manualContainer.classList.remove('hidden');
        if (manualInput) {
          manualInput.focus();
          budgetFinal.value = manualInput.value ? ('$' + manualInput.value.replace(/^\$/, '')) : 'Custom Budget';
        }
      } else {
        if (manualContainer) manualContainer.classList.add('hidden');
        budgetFinal.value = budgetSelect.value;
      }
    };

    const handleManualInput = () => {
      if (!budgetFinal || !manualInput) return;
      budgetFinal.value = manualInput.value ? ('$' + manualInput.value.replace(/^\$/, '')) : 'Custom Budget';
    };

    if (budgetSelect) budgetSelect.addEventListener('change', handleBudgetChange);
    if (manualInput) manualInput.addEventListener('input', handleManualInput);

    const handleSubmit = (e) => {
      e.preventDefault();
      const btn = document.getElementById('contactSubmitBtn');
      const successBox = document.getElementById('contactFormSuccess');
      const errorBox = document.getElementById('contactFormError');
      const errorText = document.getElementById('contactFormErrorText');

      if (successBox) successBox.classList.add('hidden');
      if (errorBox) errorBox.classList.add('hidden');

      const origText = btn ? btn.innerHTML : '';
      if (btn) {
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
        btn.disabled = true;
      }

      const formData = new FormData(form);

      fetch(form.action || '/inquiry', {
        method: 'POST',
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json',
        },
        body: formData,
      })
        .then((res) => res.json())
        .then((data) => {
          if (btn) {
            btn.innerHTML = origText;
            btn.disabled = false;
          }
          if (data.success) {
            if (successBox) successBox.classList.remove('hidden');
            form.reset();
            if (budgetSelect) budgetSelect.value = 'Not Decided / Flexible';
            if (budgetFinal) budgetFinal.value = 'Not Decided / Flexible';
            if (manualContainer) manualContainer.classList.add('hidden');
            if (manualInput) manualInput.value = '';
          } else {
            if (errorText) errorText.innerText = data.message || 'Please verify your details and try again.';
            if (errorBox) errorBox.classList.remove('hidden');
          }
        })
        .catch((err) => {
          if (btn) {
            btn.innerHTML = origText;
            btn.disabled = false;
          }
          if (errorText) errorText.innerText = 'Network error. Please call or email us directly.';
          if (errorBox) errorBox.classList.remove('hidden');
        });
    };

    form.addEventListener('submit', handleSubmit);

    return () => {
      form.removeEventListener('submit', handleSubmit);
      if (budgetSelect) budgetSelect.removeEventListener('change', handleBudgetChange);
      if (manualInput) manualInput.removeEventListener('input', handleManualInput);
    };
  }, [contentHtml]);

  return (
    <AppLayout seo={seo}>
      {({ openInquiry, openLinkModal }) => (
        <div
          id="contactBladeContent"
          className="w-full"
          dangerouslySetInnerHTML={{ __html: contentHtml }}
        />
      )}
    </AppLayout>
  );
}
