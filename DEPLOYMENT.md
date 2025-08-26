# Guía de Deployment - TinaXShower

## Problemas Identificados y Soluciones

### 1. Error 503/500 en Producción

**Causas principales:**
- Inconsistencia entre dominios en configuración
- Falta de favicon.ico causando error 500
- Configuración inadecuada de Next.js para producción
- Manejo deficiente de errores en server.js

**Soluciones implementadas:**

#### A. Configuración de Dominios
- ✅ Actualizado `next.config.js` para usar `prueba.tinaxshower.cl`
- ✅ Agregado soporte para múltiples dominios
- ✅ Configurado `unoptimized: true` para imágenes en producción

#### B. Favicon y Archivos Estáticos
- ✅ Copiado favicon.ico a `/public/favicon.ico`
- ✅ Agregado manejo especial de favicon en server.js
- ✅ Configurado headers de cache para archivos estáticos

#### C. Configuración de Producción
- ✅ Agregado `output: 'standalone'` para deployment
- ✅ Mejorado manejo de errores en server.js
- ✅ Creado páginas de error personalizadas (404.tsx, 500.tsx)

### 2. Pasos para Deployment

#### Opción 1: Deployment Manual
```bash
# 1. Build para producción
npm run build:prod

# 2. Iniciar servidor
npm run start:prod
```

#### Opción 2: Con PM2 (Recomendado)
```bash
# 1. Instalar PM2 globalmente
npm install -g pm2

# 2. Build para producción
npm run build:prod

# 3. Iniciar con PM2
pm2 start ecosystem.config.js --env production

# 4. Guardar configuración PM2
pm2 save
pm2 startup
```

### 3. Variables de Entorno Requeridas

Asegúrate de que estas variables estén configuradas en tu servidor:

```bash
NODE_ENV=production
PORT=3000
HOSTNAME=0.0.0.0
NEXT_PUBLIC_SITE_URL=https://prueba.tinaxshower.cl
NEXT_PUBLIC_METADATA_BASE=https://prueba.tinaxshower.cl
```

### 4. Configuración del Servidor Web

#### Apache (.htaccess ya incluido)
- ✅ Redirección HTTPS
- ✅ Compresión GZIP
- ✅ Headers de seguridad
- ✅ Manejo de errores

#### Nginx (configuración recomendada)
```nginx
server {
    listen 80;
    server_name prueba.tinaxshower.cl;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name prueba.tinaxshower.cl;
    
    # SSL configuration
    ssl_certificate /path/to/certificate.crt;
    ssl_certificate_key /path/to/private.key;
    
    location / {
        proxy_pass http://localhost:3000;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection 'upgrade';
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
        proxy_cache_bypass $http_upgrade;
    }
    
    # Manejo de archivos estáticos
    location /_next/static/ {
        proxy_pass http://localhost:3000;
        add_header Cache-Control "public, max-age=31536000, immutable";
    }
    
    location /img/ {
        proxy_pass http://localhost:3000;
        add_header Cache-Control "public, max-age=86400";
    }
}
```

### 5. Verificación Post-Deployment

1. **Verificar que el servidor esté corriendo:**
   ```bash
   curl -I https://prueba.tinaxshower.cl
   ```

2. **Verificar favicon:**
   ```bash
   curl -I https://prueba.tinaxshower.cl/favicon.ico
   ```

3. **Verificar imágenes:**
   ```bash
   curl -I https://prueba.tinaxshower.cl/img/logo_txs.png
   ```

4. **Verificar páginas de error:**
   - https://prueba.tinaxshower.cl/pagina-inexistente (debe mostrar 404)

### 6. Monitoreo y Logs

```bash
# Ver logs de PM2
pm2 logs tinaxshower

# Ver estado de la aplicación
pm2 status

# Reiniciar si es necesario
pm2 restart tinaxshower
```

### 7. Troubleshooting

**Si persisten los errores 500:**
1. Verificar que todas las dependencias estén instaladas
2. Verificar permisos de archivos
3. Revisar logs del servidor web (Apache/Nginx)
4. Verificar configuración de SSL

**Si las imágenes no cargan:**
1. Verificar que los archivos existan en `/public/img/`
2. Verificar configuración de `remotePatterns` en `next.config.js`
3. Verificar headers CORS

Esta configuración debería resolver los problemas de deployment en producción.