// Custom image loader para hosting estático en cPanel
export default function imageLoader({ src, width, quality }) {
  // Para hosting estático, simplemente retornamos la URL original
  // sin optimizaciones de Next.js
  return src
}