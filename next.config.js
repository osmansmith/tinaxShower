/** @type {import('next').NextConfig} */
const nextConfig = {
  images: {
    remotePatterns: [
      {
        protocol: 'https',
        hostname: 'prueba.tinaxshower.cl',
        port: '',
        pathname: '/**',
      },
      {
        protocol: 'https',
        hostname: 'tinaxshower.cl',
        port: '',
        pathname: '/**',
      },
    ],
    unoptimized: process.env.NODE_ENV === 'production',
    domains: ['prueba.tinaxshower.cl', 'tinaxshower.cl'],
  },
  poweredByHeader: false,
  compress: true,
  generateEtags: false,
}

// Configuración específica para producción
if (process.env.NODE_ENV === 'production') {
  nextConfig.output = 'standalone'
  nextConfig.trailingSlash = false
  nextConfig.swcMinify = true
  nextConfig.experimental = {
    optimizeCss: true,
  }
  nextConfig.compiler = {
    removeConsole: {
      exclude: ['error', 'warn'],
    },
  }
}

module.exports = nextConfig