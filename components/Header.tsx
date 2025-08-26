'use client'

import { useState, useEffect } from 'react'
import Image from 'next/image'
import { Menu, X, Phone, MessageCircle } from 'lucide-react'
import { motion, AnimatePresence } from 'framer-motion'

const Header = () => {
  const [isMenuOpen, setIsMenuOpen] = useState(false)
  const [isScrolled, setIsScrolled] = useState(false)

  useEffect(() => {
    const handleScroll = () => {
      setIsScrolled(window.scrollY > 50)
    }

    window.addEventListener('scroll', handleScroll)
    return () => window.removeEventListener('scroll', handleScroll)
  }, [])

  const scrollToSection = (sectionId: string) => {
    const element = document.getElementById(sectionId)
    if (element) {
      element.scrollIntoView({ behavior: 'smooth' })
    }
    setIsMenuOpen(false)
  }

  const navItems = [
    { name: 'Inicio', id: 'hero' },
    { name: 'Servicios', id: 'services' },
    { name: 'Galería', id: 'gallery' },
    { name: 'Contacto', id: 'contact' },
  ]

  return (
    <motion.header
      initial={{ y: -100 }}
      animate={{ y: 0 }}
      transition={{ duration: 0.6, ease: 'easeOut' }}
      className={`fixed top-0 left-0 right-0 z-50 transition-all duration-300 ${
        isScrolled
          ? 'bg-white/95 backdrop-blur-md shadow-lg'
          : 'bg-transparent'
      }`}
    >
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex justify-between items-center h-20">
          {/* Logo */}
          <motion.div
            whileHover={{ scale: 1.05 }}
            className="flex items-center space-x-3 cursor-pointer"
            onClick={() => scrollToSection('hero')}
          >
            <div className="relative w-12 h-12">
              <Image
                src="/img/logo_txs.png"
                alt="TinaXShower Logo"
                fill
                className="object-contain"
                priority
              />
            </div>
            <div className="hidden sm:block">
              <h1 className={`text-2xl font-bold transition-colors duration-300 ${
                isScrolled ? 'text-secondary-800' : 'text-white'
              }`}>
                TinaXShower
              </h1>
              <p className={`text-sm transition-colors duration-300 ${
                isScrolled ? 'text-secondary-600' : 'text-white/80'
              }`}>
                Servicios Premium
              </p>
            </div>
          </motion.div>

          {/* Desktop Navigation */}
          <nav className="hidden lg:flex items-center space-x-8">
            {navItems.map((item) => (
              <motion.button
                key={item.id}
                whileHover={{ scale: 1.05 }}
                whileTap={{ scale: 0.95 }}
                onClick={() => scrollToSection(item.id)}
                className={`font-medium transition-colors duration-300 hover:text-primary-500 ${
                  isScrolled ? 'text-secondary-700' : 'text-white'
                }`}
              >
                {item.name}
              </motion.button>
            ))}
          </nav>

          {/* Contact Buttons - Desktop */}
          <div className="hidden lg:flex items-center space-x-4">
            <motion.div
              whileHover={{ scale: 1.05 }}
              whileTap={{ scale: 0.95 }}
            >
              <a
                href="https://wa.me/56947175436"
                target="_blank"
                rel="noopener noreferrer"
                className="btn-outline flex items-center space-x-2 text-sm"
              >
                <MessageCircle size={16} />
                <span>WhatsApp</span>
              </a>
            </motion.div>
            <motion.div
              whileHover={{ scale: 1.05 }}
              whileTap={{ scale: 0.95 }}
            >
              <a
                href="tel:+56947175436"
                className="btn-primary flex items-center space-x-2"
              >
                <Phone size={18} />
                <span>Llamar</span>
              </a>
            </motion.div>
          </div>

          {/* Mobile Menu Button */}
          <motion.button
            whileTap={{ scale: 0.95 }}
            onClick={() => setIsMenuOpen(!isMenuOpen)}
            className={`lg:hidden p-2 rounded-lg transition-colors duration-300 ${
              isScrolled
                ? 'text-secondary-700 hover:bg-secondary-100'
                : 'text-white hover:bg-white/10'
            }`}
          >
            {isMenuOpen ? <X size={24} /> : <Menu size={24} />}
          </motion.button>
        </div>
      </div>

      {/* Mobile Menu */}
      <AnimatePresence>
        {isMenuOpen && (
          <motion.div
            initial={{ opacity: 0, height: 0 }}
            animate={{ opacity: 1, height: 'auto' }}
            exit={{ opacity: 0, height: 0 }}
            transition={{ duration: 0.3 }}
            className="lg:hidden bg-white/95 backdrop-blur-md border-t border-secondary-200"
          >
            <div className="max-w-7xl mx-auto px-4 py-6">
              <nav className="flex flex-col space-y-4">
                {navItems.map((item) => (
                  <motion.button
                    key={item.id}
                    whileHover={{ x: 10 }}
                    onClick={() => scrollToSection(item.id)}
                    className="text-left font-medium text-secondary-700 hover:text-primary-600 transition-colors duration-200"
                  >
                    {item.name}
                  </motion.button>
                ))}
              </nav>
              
              {/* Mobile Contact Buttons */}
              <div className="flex flex-col space-y-3 pt-4 border-t border-secondary-200">
                <a
                  href="https://wa.me/56947175436"
                  target="_blank"
                  rel="noopener noreferrer"
                  className="btn-outline flex items-center justify-center space-x-2 w-full"
                >
                  <MessageCircle size={18} />
                  <span>WhatsApp</span>
                </a>
                <a
                  href="tel:+56947175436"
                  className="btn-primary flex items-center justify-center space-x-2 w-full"
                >
                  <Phone size={18} />
                  <span>Llamar Ahora</span>
                </a>
              </div>
            </div>
          </motion.div>
        )}
      </AnimatePresence>
    </motion.header>
  )
}

export default Header