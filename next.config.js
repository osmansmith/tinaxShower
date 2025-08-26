/** @type {import('next').NextConfig} */
const nextConfig = {
  // Configuración para cPanel - exportación estática
  output: 'export',
  trailingSlash: true,
  skipTrailingSlashRedirect: true,
  
  // Configuración de imágenes para hosting estático
  images: {
    unoptimized: true,
    loader: 'custom',
    loaderFile: './image-loader.js'
  },
  
  // Configuraciones de optimización
  compress: true,
  generateEtags: false,
  swcMinify: true,
  poweredByHeader: false,
  reactStrictMode: true,
  
  // Configuración de rutas para cPanel
  basePath: '',
  assetPrefix: '',
  
  env: {
    CUSTOM_KEY: process.env.CUSTOM_KEY,
  },
  
  // Headers de seguridad (se manejarán via .htaccess)
  async headers() {
    return []
  }
}

module.exports = nextConfig