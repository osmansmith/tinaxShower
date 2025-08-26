import React from 'react'
import Link from 'next/link'
import { ArrowLeft, Home } from 'lucide-react'

const Custom404: React.FC = () => {
  return (
    <div className="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center px-4">
      <div className="max-w-md w-full text-center">
        <div className="mb-8">
          <h1 className="text-9xl font-bold text-gray-300 mb-4">404</h1>
          <h2 className="text-2xl font-semibold text-gray-800 mb-2">
            Página no encontrada
          </h2>
          <p className="text-gray-600 mb-8">
            Lo sentimos, la página que buscas no existe o ha sido movida.
          </p>
        </div>
        
        <div className="space-y-4">
          <Link 
            href="/"
            className="inline-flex items-center justify-center w-full px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200"
          >
            <Home className="w-5 h-5 mr-2" />
            Ir al inicio
          </Link>
          
          <button 
            onClick={() => window.history.back()}
            className="inline-flex items-center justify-center w-full px-6 py-3 bg-gray-200 text-gray-800 font-medium rounded-lg hover:bg-gray-300 transition-colors duration-200"
          >
            <ArrowLeft className="w-5 h-5 mr-2" />
            Volver atrás
          </button>
        </div>
        
        <div className="mt-8 text-sm text-gray-500">
          <p>¿Necesitas ayuda? <Link href="/contacto" className="text-blue-600 hover:underline">Contáctanos</Link></p>
        </div>
      </div>
    </div>
  )
}

export default Custom404