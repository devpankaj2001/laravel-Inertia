import React from 'react';
import { Head } from '@inertiajs/react';

export default function SeoHead({
  title,
  description,
  keywords,
  canonical,
  ogImage,
  schemas = [],
  customJsonLd = null,
  googleVerification,
  bingVerification,
}) {
  const fullTitle = title || 'WebRanker | Web & App Development, SEO, Content & Performance Optimization';
  const metaDesc = description || 'WebRanker is an elite engineering and organic search agency specializing in Web Development, Mobile Apps, Technical SEO, Topical Content, and Site Speed Optimization.';
  const metaKw = keywords || 'web development, mobile app development, technical SEO, core web vitals, ecommerce development, AI automation';
  const defaultImage = ogImage || '/asset/logo.svg';

  return (
    <Head>
      <title>{fullTitle}</title>
      <meta name="title" content={fullTitle} />
      <meta name="description" content={metaDesc} />
      <meta name="keywords" content={metaKw} />
      <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1" />
      {canonical && <link rel="canonical" href={canonical} />}
      {googleVerification && <meta name="google-site-verification" content={googleVerification} />}
      {bingVerification && <meta name="msvalidate.01" content={bingVerification} />}

      {/* Open Graph / Facebook */}
      <meta property="og:type" content="website" />
      {canonical && <meta property="og:url" content={canonical} />}
      <meta property="og:title" content={fullTitle} />
      <meta property="og:description" content={metaDesc} />
      <meta property="og:image" content={defaultImage} />
      <meta property="og:site_name" content="WebRanker" />
      <meta property="og:locale" content="en_US" />

      {/* Twitter */}
      <meta name="twitter:card" content="summary_large_image" />
      {canonical && <meta name="twitter:url" content={canonical} />}
      <meta name="twitter:title" content={fullTitle} />
      <meta name="twitter:description" content={metaDesc} />
      <meta name="twitter:image" content={defaultImage} />
      <meta name="twitter:site" content="@webranker" />
      <meta name="twitter:creator" content="@webranker" />

      {/* Structured Data (Schema.org JSON-LD) */}
      {Array.isArray(schemas) && schemas.map((schema, idx) => (
        <script
          key={`schema-${idx}`}
          type="application/ld+json"
          dangerouslySetInnerHTML={{ __html: JSON.stringify(schema) }}
        />
      ))}

      {customJsonLd && (
        <script
          type="application/ld+json"
          dangerouslySetInnerHTML={{ __html: JSON.stringify(customJsonLd) }}
        />
      )}
    </Head>
  );
}
