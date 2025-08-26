const { createServer } = require('http')
const { parse } = require('url')
const next = require('next')
 
const port = parseInt(process.env.PORT || '3000', 10)
const dev = process.env.NODE_ENV !== 'production'
const hostname = process.env.HOSTNAME || 'localhost'

const app = next({ dev, hostname, port })
const handle = app.getRequestHandler()
 
app.prepare().then(() => {
  const server = createServer(async (req, res) => {
    try {
      // Manejo especial para favicon.ico
      if (req.url === '/favicon.ico') {
        res.statusCode = 200
        res.setHeader('Content-Type', 'image/x-icon')
        res.setHeader('Cache-Control', 'public, max-age=86400')
        const fs = require('fs')
        const path = require('path')
        const faviconPath = path.join(__dirname, 'public', 'favicon.ico')
        
        if (fs.existsSync(faviconPath)) {
          const favicon = fs.readFileSync(faviconPath)
          res.end(favicon)
        } else {
          res.statusCode = 404
          res.end()
        }
        return
      }

      const parsedUrl = parse(req.url, true)
      await handle(req, res, parsedUrl)
    } catch (err) {
      console.error('Error occurred handling', req.url, err)
      res.statusCode = 500
      res.end('Internal Server Error')
    }
  })

  server.listen(port, (err) => {
    if (err) throw err
    console.log(
      `> Server listening at http://${hostname}:${port} as ${
        dev ? 'development' : 'production'
      }`
    )
  })
}).catch((ex) => {
  console.error('Error starting server:', ex)
  process.exit(1)
})