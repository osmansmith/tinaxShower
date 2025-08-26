'use client'

import { useState } from 'react'
import { motion } from 'framer-motion'
import { 
  Droplets, 
  Wrench, 
  Shield, 
  Clock, 
  Star, 
  CheckCircle, 
  MessageCircle,
  Phone
} from 'lucide-react'

const Services = () => {
  const [activeService, setActiveService] = useState(0)

  const services = [
    {
      id: 1,
      icon: Droplets,
      title: 'Instalación de Duchas',
      description: 'Instalación profesional de duchas modernas con acabados de primera calidad.',
      features: [
        'Duchas de lluvia premium',
        'Sistemas termostáticos',
        'Paneles de hidromasaje',
        'Duchas escocesas',
        'Garantía de 2 años'
      ],
      price: 'Desde $150.000',
      duration: '2-4 horas',
      image: '/images/service01.jpg'
    },
    {
      id: 2,
      icon: Wrench,
      title: 'Reparación y Mantención',
      description: 'Servicio técnico especializado para todo tipo de problemas en duchas.',
      features: [
        'Reparación de fugas',
        'Cambio de grifería',
        'Limpieza de cañerías',
        'Mantención preventiva',
        'Servicio de emergencia'
      ],
      price: 'Desde $35.000',
      duration: '1-2 horas',
      image: '/images/service02.jpg'
    },
    {
      id: 3,
      icon: Shield,
      title: 'Impermeabilización',
      description: 'Protección total contra filtraciones con materiales de última generación.',
      features: [
        'Membranas impermeables',
        'Sellado de juntas',
        'Tratamiento anti-hongos',
        'Revestimientos cerámicos',
        'Garantía extendida'
      ],
      price: 'Desde $80.000',
      duration: '4-6 horas',
      image: '/images/service03.jpg'
    },
    {
      id: 4,
      icon: Clock,
      title: 'Servicio Express',
      description: 'Atención inmediata para emergencias y reparaciones urgentes.',
      features: [
        'Disponible 24/7',
        'Respuesta en 30 min',
        'Diagnóstico gratuito',
        'Repuestos en stock',
        'Sin costo adicional'
      ],
      price: 'Desde $45.000',
      duration: '30 min - 1 hora',
      image: '/images/service04.jpg'
    }
  ]

  const containerVariants = {
    hidden: { opacity: 0 },
    visible: {
      opacity: 1,
      transition: {
        staggerChildren: 0.2
      }
    }
  }

  const itemVariants = {
    hidden: { opacity: 0, y: 50 },
    visible: {
      opacity: 1,
      y: 0,
      transition: {
        duration: 0.6,
        ease: 'easeOut'
      }
    }
  }

  return (
    <section id="services" className="py-20 bg-gradient-to-br from-gray-50 to-blue-50">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Header */}
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          transition={{ duration: 0.8 }}
          className="text-center mb-16"
        >
          <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
            Nuestros Servicios
          </h2>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
            Ofrecemos soluciones completas para tu baño con la más alta calidad y 
            profesionalismo. Cada servicio incluye garantía y atención personalizada.
          </p>
        </motion.div>

        {/* Services Grid */}
        <motion.div
          variants={containerVariants}
          initial="hidden"
          whileInView="visible"
          viewport={{ once: true }}
          className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16"
        >
          {services.map((service, index) => {
            const IconComponent = service.icon
            return (
              <motion.div
                key={service.id}
                variants={itemVariants}
                whileHover={{ 
                  y: -10,
                  transition: { duration: 0.3 }
                }}
                onHoverStart={() => setActiveService(index)}
                className={`relative group cursor-pointer transition-all duration-300 ${
                  activeService === index ? 'z-10' : ''
                }`}
              >
                <div className="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 h-full border border-gray-100">
                  {/* Icon */}
                  <div className="mb-6">
                    <div className="w-16 h-16 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                      <IconComponent className="w-8 h-8 text-white" />
                    </div>
                  </div>

                  {/* Content */}
                  <h3 className="text-xl font-bold text-gray-900 mb-3 group-hover:text-primary-600 transition-colors">
                    {service.title}
                  </h3>
                  
                  <p className="text-gray-600 mb-6 leading-relaxed">
                    {service.description}
                  </p>

                  {/* Features */}
                  <ul className="space-y-2 mb-6">
                    {service.features.slice(0, 3).map((feature, idx) => (
                      <li key={idx} className="flex items-center text-sm text-gray-600">
                        <CheckCircle className="w-4 h-4 text-green-500 mr-2 flex-shrink-0" />
                        {feature}
                      </li>
                    ))}
                  </ul>

                  {/* Price & Duration */}
                  <div className="border-t border-gray-100 pt-4 mt-auto">
                    <div className="flex justify-between items-center mb-4">
                      <span className="text-2xl font-bold text-primary-600">
                        {service.price}
                      </span>
                      <span className="text-sm text-gray-500 flex items-center">
                        <Clock className="w-4 h-4 mr-1" />
                        {service.duration}
                      </span>
                    </div>
                    
                    <motion.button
                      whileHover={{ scale: 1.05 }}
                      whileTap={{ scale: 0.95 }}
                      className="w-full btn-primary text-sm py-3"
                      onClick={() => {
                        window.open('https://wa.me/56947175436', '_blank')
                      }}
                    >
                      Solicitar Servicio
                    </motion.button>
                  </div>
                </div>

                {/* Hover Effect Overlay */}
                <div className="absolute inset-0 bg-gradient-to-br from-primary-500/5 to-secondary-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none" />
              </motion.div>
            )
          })}
        </motion.div>

        {/* Featured Service Detail */}
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          transition={{ duration: 0.8 }}
          className="bg-white rounded-3xl shadow-xl overflow-hidden"
        >
          <div className="grid grid-cols-1 lg:grid-cols-2">
            {/* Image */}
            <div className="relative h-64 lg:h-auto">
              <div className="absolute inset-0 bg-gradient-to-br from-primary-600 to-secondary-600" />
              <div className="absolute inset-0 flex items-center justify-center">
                <div className="text-center text-white">
                  <Star className="w-16 h-16 mx-auto mb-4" />
                  <h3 className="text-2xl font-bold mb-2">Servicio Premium</h3>
                  <p className="text-primary-100">Calidad garantizada</p>
                </div>
              </div>
            </div>

            {/* Content */}
            <div className="p-8 lg:p-12">
              <h3 className="text-3xl font-bold text-gray-900 mb-6">
                ¿Por qué elegir TinaXShower?
              </h3>
              
              <div className="space-y-4 mb-8">
                <div className="flex items-start space-x-3">
                  <CheckCircle className="w-6 h-6 text-green-500 mt-1 flex-shrink-0" />
                  <div>
                    <h4 className="font-semibold text-gray-900">Experiencia Comprobada</h4>
                    <p className="text-gray-600">Más de 10 años especializados en servicios de ducha</p>
                  </div>
                </div>
                
                <div className="flex items-start space-x-3">
                  <CheckCircle className="w-6 h-6 text-green-500 mt-1 flex-shrink-0" />
                  <div>
                    <h4 className="font-semibold text-gray-900">Garantía Total</h4>
                    <p className="text-gray-600">Todos nuestros trabajos incluyen garantía extendida</p>
                  </div>
                </div>
                
                <div className="flex items-start space-x-3">
                  <CheckCircle className="w-6 h-6 text-green-500 mt-1 flex-shrink-0" />
                  <div>
                    <h4 className="font-semibold text-gray-900">Atención 24/7</h4>
                    <p className="text-gray-600">Servicio de emergencia disponible todos los días</p>
                  </div>
                </div>
              </div>

              <div className="flex flex-col sm:flex-row gap-4">
                <motion.div
                  whileHover={{ scale: 1.05 }}
                  whileTap={{ scale: 0.95 }}
                >
                  <a 
                    href="https://wa.me/56947175436" 
                    target="_blank" 
                    rel="noopener noreferrer"
                    className="btn-primary flex items-center space-x-3 px-6 py-3"
                  >
                    <MessageCircle size={20} />
                    <span>WhatsApp</span>
                  </a>
                </motion.div>
                
                <motion.div
                  whileHover={{ scale: 1.05 }}
                  whileTap={{ scale: 0.95 }}
                >
                  <a 
                    href="tel:+56947175436" 
                    className="btn-outline flex items-center space-x-3 px-6 py-3"
                  >
                    <Phone size={20} />
                    <span>Llamar</span>
                  </a>
                </motion.div>
              </div>
            </div>
          </div>
        </motion.div>
      </div>
    </section>
  )
}

export default Services