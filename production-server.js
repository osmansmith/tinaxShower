const { createServer } = require("http")
const next = require("next")
const { parse } = require("url")
const path = require("path")
const fs = require("fs")

// Configuración del servidor
const port = parseInt(process.env.PORT || '3000', 10)
const hostname = process.env.HOSTNAME || '0.0.0.0'
const dev = false // Siempre en modo producción

// Configurar Next.js para producción
const app = next({ 
  dev, 
  hostname, 
  port,
  conf: {
    distDir: '.next',
    generateEtags: false,
    poweredByHeader: false,
    compress: true
  }
})

const handle = app.getRequestHandler()

// Función para servir archivos estáticos
const serveStatic = (req, res, filePath, contentType) => {
  try {
    if (fs.existsSync(filePath)) {
      const stat = fs.statSync(filePath)
      const fileStream = fs.createReadStream(filePath)
      
      res.writeHead(200, {
        'Content-Type': contentType,
        'Content-Length': stat.size,
        'Cache-Control': 'public, max-age=31536000',
        'ETag': `"${stat.mtime.getTime()}-${stat.size}"`
      })
      
      fileStream.pipe(res)
      return true
    }
  } catch (error) {
    console.error('Error serving static file:', error)
  }
  return false
}

// Inicializar servidor
app.prepare().then(() => {
  const server = createServer(async (req, res) => {
    try {
      const parsedUrl = parse(req.url, true)
      const { pathname } = parsedUrl

      // Manejo especial para favicon
      if (pathname === '/favicon.ico') {
        const faviconPath = path.join(__dirname, 'public', 'favicon.ico')
        if (serveStatic(req, res, faviconPath, 'image/x-icon')) {
          return
        }
      }

      // Manejo de archivos estáticos de imágenes
      if (pathname.startsWith('/img/')) {
        const imagePath = path.join(__dirname, 'public', pathname)
        const ext = path.extname(pathname).toLowerCase()
        const contentTypes = {
          '.png': 'image/png',
          '.jpg': 'image/jpeg',
          '.jpeg': 'image/jpeg',
          '.gif': 'image/gif',
          '.svg': 'image/svg+xml',
          '.ico': 'image/x-icon'
        }
        
        if (contentTypes[ext] && serveStatic(req, res, imagePath, contentTypes[ext])) {
          return
        }
      }

      // Headers de seguridad
      res.setHeader('X-Frame-Options', 'DENY')
      res.setHeader('X-Content-Type-Options', 'nosniff')
      res.setHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
      res.setHeader('X-XSS-Protection', '1; mode=block')

      // Manejar con Next.js
      await handle(req, res, parsedUrl)
    } catch (err) {
      console.error('Error handling request:', req.url, err)
      res.statusCode = 500
      res.setHeader('Content-Type', 'text/html')
      res.end(`
        <!DOCTYPE html>
        <html>
        <head>
          <title>Error 500</title>
          <meta charset="utf-8">
        </head>
        <body>
          <h1>Error interno del servidor</h1>
          <p>Lo sentimos, algo salió mal. Por favor, inténtalo de nuevo más tarde.</p>
        </body>
        </html>
      `)
    }
  })

  // Configurar timeouts
  server.timeout = 30000
  server.keepAliveTimeout = 5000
  server.headersTimeout = 6000

  // Iniciar servidor
  server.listen(port, hostname, (err) => {
    if (err) {
      console.error('Error starting server:', err)
      process.exit(1)
    }
    console.log(`\n🚀 Production server ready!`)
    console.log(`   - URL: http://${hostname}:${port}`)
    console.log(`   - Environment: production`)
    console.log(`   - Process ID: ${process.pid}`)
    console.log(`   - Memory usage: ${Math.round(process.memoryUsage().heapUsed / 1024 / 1024)}MB\n`)
  })

  // Manejo de señales para cierre graceful
  process.on('SIGTERM', () => {
    console.log('SIGTERM received, shutting down gracefully')
    server.close(() => {
      console.log('Process terminated')
      process.exit(0)
    })
  })

  process.on('SIGINT', () => {
    console.log('SIGINT received, shutting down gracefully')
    server.close(() => {
      console.log('Process terminated')
      process.exit(0)
    })
  })

}).catch((ex) => {
  console.error('Error initializing Next.js app:', ex)
  process.exit(1)
})