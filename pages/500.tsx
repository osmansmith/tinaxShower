import React from 'react'
import Link from 'next/link'
import { RefreshCw, Home, AlertTriangle } from 'lucide-react'

const Custom500: React.FC = () => {
  const handleRefresh = () => {
    window.location.reload()
  }

  return (
    <div className="min-h-screen bg-gradient-to-br from-red-50 to-red-100 flex items-center justify-center px-4">
      <div className="max-w-md w-full text-center">
        <div className="mb-8">
          <div className="flex justify-center mb-4">
            <AlertTriangle className="w-16 h-16 text-red-500" />
          </div>
          <h1 className="text-6xl font-bold text-red-500 mb-4">500</h1>
          <h2 className="text-2xl font-semibold text-gray-800 mb-2">
            Error interno del servidor
          </h2>
          <p className="text-gray-600 mb-8">
            Lo sentimos, algo salió mal en nuestros servidores. Estamos trabajando para solucionarlo.
          </p>
        </div>
        
        <div className="space-y-4">
          <button 
            onClick={handleRefresh}
            className="inline-flex items-center justify-center w-full px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors duration-200"
          >
            <RefreshCw className="w-5 h-5 mr-2" />
            Intentar de nuevo
          </button>
          
          <Link 
            href="/"
            className="inline-flex items-center justify-center w-full px-6 py-3 bg-gray-200 text-gray-800 font-medium rounded-lg hover:bg-gray-300 transition-colors duration-200"
          >
            <Home className="w-5 h-5 mr-2" />
            Ir al inicio
          </Link>
        </div>
        
        <div className="mt-8 text-sm text-gray-500">
          <p>Si el problema persiste, <Link href="/contacto" className="text-red-600 hover:underline">contáctanos</Link></p>
        </div>
      </div>
    </div>
  )
}

export default Custom500