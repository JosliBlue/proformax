<table align="center" border="0" style="border:none;">
  <tr>
    <td align="center" valign="middle">
      <img src="./storage/app/public/companies/_01_proformax.webp" width="100" alt="Proformax" />
    </td>
    <td align="center" valign="middle">
      <span style="font-size: 24px; font-weight: bold; color: #549bf5;">PROFORMAX</span>
    </td>
    <td align="center" valign="middle">
      <span style="font-size: 50px; color: #555;">×</span>
    </td>
    <td align="center" valign="middle">
      <span style="font-size: 24px; font-weight: bold; color: #FF2D20;">LARAVEL</span>
    </td>
    <td align="center" valign="middle">
      <img src="./storage/app/public/laravel_icon.png" width="100" alt="Laravel" />
    </td>
  </tr>
</table>

<div align="center" style="margin: 20px 0;">
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2.18-777BB4?logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/TailwindCSS-3.x-06B6D4?logo=tailwindcss&logoColor=white" alt="TailwindCSS">
  <img src="https://img.shields.io/badge/DomPDF-3.x-EC1C24?logo=adobeacrobatreader&logoColor=white" alt="DomPDF">
</div>

<p align="center">
  <b>Gestión moderna y eficiente de proformas, clientes y productos para empresas.</b>
</p>

---

## 📚 Índice

-   [Características](#-características)
-   [Instalación rápida](#-instalación-rápida)
-   [Comandos útiles](#-comandos-útiles)
-   [Configuración recomendada](#-configuración-recomendada)
-   [Estructura del proyecto](#-estructura-del-proyecto)
-   [Notas finales](#-notas-finales)

---

## ✨ Características

-   ✅ Gestión completa de proformas y borradores
-   👥 Base de datos de clientes organizada
-   📄 Generación de PDFs profesionales
-   🔍 Búsqueda avanzada con filtros
-   📱 Interfaz responsive optimizada
-   👨‍💻 Sistema multi-usuario

---

## 🚀 Instalación rápida

1. **Clona el repositorio:**
    ```sh
    git clone <url-del-repo>
    cd proformax
    ```
2. **Instala dependencias PHP:**
    ```sh
    composer install
    ```
3. **Configura tu entorno:**
    ```sh
    cp .env.example .env
    # Edita .env con tus credenciales
    ```
4. **Genera clave, migra y llena la base de datos:**
    ```sh
    php artisan key:generate
    php artisan migrate --seed
    ```
5. **Haz público el almacenamiento para los logos:**
    ```sh
    php artisan storage:link
    ```
6. **(Opcional) Publica la paginación con Tailwind:**
    ```sh
    php artisan vendor:publish --tag=laravel-pagination
    ```
7. **Instala DomPDF para PDFs:**
    ```sh
    composer require barryvdh/laravel-dompdf
    ```

---

## 🧹 Comandos útiles

-   Limpiar cachés de Laravel:
    ```sh
    php artisan config:clear && php artisan route:clear && php artisan view:clear && php artisan config:cache
    ```
-   Limpiar caché de Composer:
    ```sh
    composer dump-autoload
    ```

---

## ⚙️ Configuración recomendada (`php.ini`)

Aumenta los límites para subir archivos y memoria:

```
upload_max_filesize = 20M
post_max_size = 25M
max_file_uploads = 20
memory_limit = 256M
```

---

## 🛠️ Tips y personalización

-   **Autenticación personalizada:**
    -   Para forzar redirección a login, edita:
        `vendor/laravel/framework/src/Illuminate/Auth/Middleware/Authenticate.php`
        ```php
        protected function unauthenticated($request, array $guards)
        {
            throw new AuthenticationException(
                'Unauthenticated.',
                $guards,
                $request->expectsJson() ? null : route('login'),
            );
        }
        // Y comenta el método redirectTo()
        ```
-   **Personaliza los colores y el branding** en `resources/views/appsita.blade.php` y los assets de Tailwind.
-   **Agrega tus propios campos** en los modelos y migraciones según las necesidades de tu empresa.

---

## 📦 Estructura del proyecto

```
proformax/
├── app/
│   ├── Models/           # Modelos Eloquent (Company, Customer, Product, Paper, User)
│   └── Http/Controllers/ # Lógica de negocio y endpoints
├── database/
│   ├── migrations/       # Migraciones de tablas
│   └── seeders/          # Datos de ejemplo
├── resources/views/      # Vistas Blade (UI)
├── public/storage/       # Archivos subidos (logos, etc)
└── ...
```

---

## 💡 Notas finales

-   Sistema optimizado para empresas multiusuario.
-   UI moderna con TailwindCSS y generación de PDFs con DomPDF.
-   Si tienes problemas, limpia cachés y revisa permisos de `storage/` y `.env`.

---

<p align="center">
  <b>¡Listo para usar y personalizar! 🚀</b>
</p>
