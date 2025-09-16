# TinasXShower WordPress Theme

Tema WordPress personalizado para TinasXShower, especialistas en servicios de ducha.

## Características

- Diseño moderno y responsive
- Integración con Tailwind CSS
- Secciones personalizadas para mostrar servicios, galería y formulario de contacto
- Optimizado para SEO
- Compatible con Gutenberg

## Requisitos

- WordPress 5.8 o superior
- PHP 7.4 o superior
- Node.js y npm (para desarrollo)

## Instalación

1. Descarga el tema y colócalo en la carpeta `wp-content/themes/` de tu instalación de WordPress.
2. Activa el tema desde el panel de administración de WordPress.
3. Configura las opciones del tema desde Apariencia > Personalizar.

## Desarrollo

Para trabajar en el desarrollo del tema:

```bash
# Instalar dependencias
npm install

# Compilar assets para desarrollo (con watch y BrowserSync)
npm run dev

# Compilar assets para producción
npm run build

# Ejecutar linting de CSS y JavaScript
npm run lint

# Ejecutar linting solo de JavaScript
npm run lint:js

# Ejecutar linting solo de CSS
npm run lint:css
```

### Herramientas de desarrollo

El tema utiliza las siguientes herramientas para el desarrollo:

- **Gulp**: Automatización de tareas
- **Tailwind CSS**: Framework de utilidades CSS
- **PostCSS**: Procesamiento de CSS
- **Babel**: Transpilación de JavaScript
- **ESLint**: Linting de JavaScript
- **BrowserSync**: Recarga automática del navegador

## Estructura del Tema

```
wp-theme/
├── assets/
│   ├── css/
│   │   ├── main.css
│   │   └── tailwind.css
│   └── js/
│       ├── main.js
│       └── navigation.js
├── inc/
│   ├── ajax-handlers.php
│   ├── customizer.php
│   ├── post-types.php
│   ├── shortcodes.php
│   └── template-tags.php
├── template-parts/
│   ├── content.php
│   └── sections/
│       ├── hero.php
│       ├── services.php
│       ├── gallery.php
│       └── contact.php
├── footer.php
├── front-page.php
├── functions.php
├── header.php
├── index.php
├── style.css
└── tailwind.config.js
```

## Personalización

El tema incluye varias opciones de personalización accesibles desde el Personalizador de WordPress:

- Logo del sitio
- Colores del tema
- Opciones de la página de inicio
- Configuración de servicios
- Configuración de la galería
- Información de contacto

## Licencia

Este tema está licenciado bajo GPL v2 o posterior.