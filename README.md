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

<div align="center" style="margin: 18px 0;">
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

- [Características](#-características)
- [Creación de la base de datos](#-creación-de-la-base-de-datos)
- [Instalación rápida](#-instalación-rápida)
- [Comandos útiles](#-comandos-útiles)
- [Configuración recomendada](#-configuración-recomendada-phpini)
- [Tips y personalización](#-tips-y-personalización)
- [Estructura del proyecto](#-estructura-del-proyecto)
- [Notas finales](#-notas-finales)

---

## ✨ Características

-   ✅ Gestión completa de proformas y borradores
-   📄 Generación de PDFs profesionales (con barryvdh/laravel-dompdf)
-   📱 Interfaz responsive optimizada
-   👨‍💻 Sistema multi-usuario
-   📝 Gestion rápida de proformas
-   🎨 Personalización visual y branding

---

## 🗄️ Creación de la base de datos

> 🏗️ **¡Un paso y listo!**
>
> Crea una base de datos llamada **proformax** con cotejamiento **utf8mb4_unicode_ci** antes de migrar 🚦. Así tendrás soporte para todos los caractéres y emojis que necesites.

---

## 🚀 Instalación rápida

```bash
# 1. Clona el repositorio
$ git clone <url-del-repo>
$ cd proformax

# 2. Instala dependencias PHP
$ composer install

# 3. Configura tu entorno
$ cp .env.example .env
# Edita .env con tus credenciales de la bd creada

# 4. Genera clave, migra y llena la base de datos
$ php artisan key:generate
$ php artisan migrate --seed

# 5. Haz público el almacenamiento para los logos
$ php artisan storage:link

# 6. (Opcional) Publica la paginación con Tailwind
$ php artisan vendor:publish --tag=laravel-pagination
```

<div align="center">
  <strong>¡ARRANCA EL PROYECTO EN TU NAVEGADOR!</strong>
</div>

```sh
php artisan serve
```

<span style="font-size:1.1em; color:#549bf5;">Accede a <b>http://127.0.0.1:8000</b> para ver la app en acción 🚀</span>

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

```ini
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

```text
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
