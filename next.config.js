/** @type {import('next').NextConfig} */
const nextConfig = {
  env: {
    NODE_ENV: process.env.NODE_ENV || 'development',
  },
  images: {
    remotePatterns: [
      {
        protocol: 'https',
        hostname: 'tinaxshower.com',
        port: '',
        pathname: '/images/**',
      },
      {
        protocol: 'https',
        hostname: 'tinaxshower.com',
        port: '',
        pathname: '/img/**',
      },
    ],
    deviceSizes: [640, 750, 828, 1080, 1200, 1920, 2048, 3840],
    imageSizes: [16, 32, 48, 64, 96, 128, 256, 384],
  },
  poweredByHeader: false,
  compress: true,
}

// Configuración adicional para producción
if (process.env.NODE_ENV === 'production') {
  nextConfig.swcMinify = true
  nextConfig.compiler = {
    removeConsole: {
      exclude: ['error'],
    },
  }
}

module.exports = nextConfig