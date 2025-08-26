import type { Metadata } from 'next'
import { Inter } from 'next/font/google'
import './globals.css'

const inter = Inter({ subsets: ['latin'] })

export const metadata: Metadata = {
  title: {
    default: 'TinaXShower - Servicios de Ducha Premium en Chile',
    template: '%s | TinaXShower'
  },
  description: 'Servicios profesionales de instalación y reparación de duchas en Chile. Especialistas en duchas modernas, reparaciones rápidas y mantenimiento. Calidad garantizada.',
  keywords: [
    'duchas Chile',
    'instalación duchas',
    'reparación duchas',
    'servicios ducha',
    'TinaXShower',
    'duchas premium',
    'mantenimiento duchas',
    'fontanería Chile',
    'baños modernos',
    'servicios sanitarios'
  ],
  authors: [{ name: 'TinaXShower', url: 'https://tinaxshower.com' }],
  creator: 'TinaXShower',
  publisher: 'TinaXShower',
  robots: {
    index: true,
    follow: true,
    googleBot: {
      index: true,
      follow: true,
      'max-video-preview': -1,
      'max-image-preview': 'large',
      'max-snippet': -1,
    },
  },
  openGraph: {
    type: 'website',
    locale: 'es_CL',
    url: 'https://tinaxshower.com',
    title: 'TinaXShower - Servicios de Ducha Premium en Chile',
    description: 'Servicios profesionales de instalación y reparación de duchas en Chile. Especialistas en duchas modernas, reparaciones rápidas y mantenimiento.',
    siteName: 'TinaXShower',
    images: [
      {
        url: 'https://tinaxshower.com/images/logo_txs.svg',
        width: 1200,
        height: 630,
        alt: 'TinaXShower - Servicios de Ducha Premium',
      },
    ],
  },
  twitter: {
    card: 'summary_large_image',
    title: 'TinaXShower - Servicios de Ducha Premium en Chile',
    description: 'Servicios profesionales de instalación y reparación de duchas en Chile.',
    images: ['https://tinaxshower.com/images/logo_txs.svg'],
  },
  verification: {
    google: 'your-google-site-verification-code',
  },
  manifest: '/manifest.json',
  appleWebApp: {
    capable: true,
    statusBarStyle: 'default',
    title: 'TinaXShower',
  },
}

export const viewport = {
  themeColor: '#0ea5e9',
}

export default function RootLayout({
  children,
}: {
  children: React.ReactNode
}) {
  const structuredData = {
    "@context": "https://schema.org",
    "@type": "LocalBusiness",
    "name": "TinaXShower",
    "description": "Servicios profesionales de instalación y reparación de duchas en Chile",
    "url": "https://tinaxshower.com",
    "logo": "https://tinaxshower.com/images/logo_txs.png",
    "image": "https://tinaxshower.com/images/logo_txs.png",
    "telephone": "+56947175436",
    "address": {
      "@type": "PostalAddress",
      "addressCountry": "CL",
      "addressLocality": "Chile"
    },
    "geo": {
      "@type": "GeoCoordinates",
      "latitude": "-33.4489",
      "longitude": "-70.6693"
    },
    "openingHours": "Mo-Fr 08:00-18:00, Sa 09:00-15:00",
    "serviceArea": {
      "@type": "Country",
      "name": "Chile"
    },
    "hasOfferCatalog": {
      "@type": "OfferCatalog",
      "name": "Servicios de Ducha",
      "itemListElement": [
        {
          "@type": "Offer",
          "itemOffered": {
            "@type": "Service",
            "name": "Instalación de Duchas",
            "description": "Instalación profesional de duchas modernas"
          }
        },
        {
          "@type": "Offer",
          "itemOffered": {
            "@type": "Service",
            "name": "Reparación de Duchas",
            "description": "Reparación rápida y eficiente de duchas"
          }
        }
      ]
    },
    "aggregateRating": {
      "@type": "AggregateRating",
      "ratingValue": "4.8",
      "reviewCount": "127"
    }
  }

  return (
    <html lang="es">
      <head>
        <script
          type="application/ld+json"
          dangerouslySetInnerHTML={{
            __html: JSON.stringify(structuredData),
          }}
        />
      </head>
      <body className={inter.className}>{children}</body>
    </html>
  )
}