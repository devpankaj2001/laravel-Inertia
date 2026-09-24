import React, { useEffect } from 'react';
import AppLayout from '@/Layouts/AppLayout';

export default function IndustryShow({ contentHtml, seo = {} }) {
  useEffect(() => {
    window.scrollTo(0, 0);
    try {
      window.dispatchEvent(new Event('DOMContentLoaded'));
      window.dispatchEvent(new Event('load'));
      window.dispatchEvent(new Event('resize'));
    } catch (e) {}
  }, [contentHtml]);

  return (
    <AppLayout seo={seo}>
      {() => (
        <div
          id="industryDetailBladeContent"
          className="w-full"
          dangerouslySetInnerHTML={{ __html: contentHtml }}
        />
      )}
    </AppLayout>
  );
}
