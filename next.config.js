/** @type {import('next').NextConfig} */
const nextConfig = {
  env: {
    NODE_ENV: process.env.NODE_ENV || 'development',
  },
  images: {
    remotePatterns: [
      {
        protocol: 'https',
        hostname: 'prueba.tinaxshower.cl',
        port: '',
        pathname: '/images/**',
      },
      {
        protocol: 'https',
        hostname: 'prueba.tinaxshower.cl',
        port: '',
        pathname: '/img/**',
      },
      {
        protocol: 'https',
        hostname: 'tinaxshower.cl',
        port: '',
        pathname: '/**',
      },
    ],
    deviceSizes: [640, 750, 828, 1080, 1200, 1920, 2048, 3840],
    imageSizes: [16, 32, 48, 64, 96, 128, 256, 384],
    unoptimized: process.env.NODE_ENV === 'production',
  },
  poweredByHeader: false,
  compress: true,
  trailingSlash: false,
  generateEtags: false,
  async headers() {
    return [
      {
        source: '/favicon.ico',
        headers: [
          {
            key: 'Cache-Control',
            value: 'public, max-age=86400',
          },
        ],
      },
    ]
  },
}

// Configuración adicional para producción
if (process.env.NODE_ENV === 'production') {
  nextConfig.output = 'standalone'
  nextConfig.swcMinify = true
  nextConfig.compiler = {
    removeConsole: {
      exclude: ['error'],
    },
  }
}

module.exports = nextConfig