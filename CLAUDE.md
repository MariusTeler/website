# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Quick Start - Local Development

### MAMP Setup (Recommended)
1. Install MAMP and set Document Root to this folder
2. Enable `mod_rewrite` in Apache config
3. Enable `short_open_tag = On` in php.ini
4. Start MySQL and Apache servers
5. Access at `http://localhost:8888`

### Database Setup
```bash
# Create database in MAMP MySQL
/Applications/MAMP/Library/bin/mysql80/bin/mysql -u root -proot -e "CREATE DATABASE dragonstarcurier_local;"

# Import data
/Applications/MAMP/Library/bin/mysql80/bin/mysql -u root -proot dragonstarcurier_local < dragonstarcurier_website.sql
```

### Configuration
1. Create `env` file in root (enables development mode)
2. Edit `platform/config/config.php` development section:
```php
'db' => ['main' => [
    'host' => 'localhost',
    'user' => 'root',
    'pass' => 'root',
    'db' => 'dragonstarcurier_local'
]]
```

### Alternative: PHP Built-in Server
```bash
php -d short_open_tag=On -S localhost:8000
```
Note: URL rewriting works differently - `$websiteURL` may include path segments.

## Architecture Overview

### Project Structure
```
├── index.php              # Front-end entry point
├── admin/                 # Admin module (pages/, views/, templates/)
├── site/                  # Front-end module (pages/, views/, templates/)
├── platform/
│   ├── config/            # Configuration files
│   │   ├── common.php     # Global constants & settings
│   │   ├── config.php     # Database credentials (NOT versioned)
│   │   ├── rewrite.php    # URL routing logic
│   │   └── db.tables.php  # Database schema mapping
│   └── functions/         # Core functions (db.php, common.php, front.php, admin.php)
├── public/                # Static assets (CSS, JS, uploads)
└── vendor/                # Composer dependencies
```

### Request Flow
1. `.htaccess` rewrites URLs to `index.php?req=<path>`
2. `platform/config/rewrite.php` parses URL segments
3. Matches against `cms_pages.url_key` in database
4. Sets `$_GET['page']` and `$_GET['id_*']` variables
5. `parseAll()` loads page file, then renders view within template

### Module Separation
- **PLATFORM_MODULE_FRONT** (`front`): Public website
- **PLATFORM_MODULE_ADMIN** (`admin`): Admin interface
- Environment detected by `env` file presence (`PLATFORM_ENV`)

## Key Conventions

### Short Open Tags
This codebase uses `<?` instead of `<?php`. Ensure `short_open_tag = On` in php.ini.

### Database Functions
```php
dbSelect($fields, $table, $where, $order)  // SELECT query
dbInsert($table, $data)                    // INSERT
dbUpdate($table, $data, $where)            // UPDATE
dbDelete($table, $where)                   // DELETE
dbEscape($value)                           // SQL escape (always use!)
dbShift($result)                           // Get first row
```

### Page/View Rendering
```php
parseVar('varName', $value, 'page_name')   // Set variable for page scope
getVar('varName', 'page_name')             // Get variable
parseBlock('block-name')                   // Execute page + render view
parseView('view-name')                     // Render view only
setPage('page-name')                       // Set current page
setTemplate('template-name')               // Set layout template
```

### URL Generation
```php
makeLink(LINK_RELATIVE, $page, $subpage)   // Returns '/page/subpage'
makeLink(LINK_ABSOLUTE, $page)             // Returns 'http://site.com/page'
imageLink($folder, $thumbType, $filename)  // Image URLs
blogLink($linkType, $post)                 // Blog post URLs
```

## Important Constants (platform/config/common.php)

- `LINK_RELATIVE`, `LINK_ABSOLUTE`, `LINK_FRONT` - URL types
- `MENU_HEADER`, `MENU_FOOTER` - Menu positions
- `LIST_*` - Content list types (FAQ, testimonial, gallery, etc.)
- `VARIOUS_*` - Content block types (text, image, hero, contact, etc.)
- `UPLOAD_URL` - `/public/uploads/`
- `THUMB_SMALL`, `THUMB_MEDIUM`, `THUMB_LARGE` - Image sizes

## Database Tables

### Core Content
- `cms_pages` - Main pages (url_key, title, text, parent_id, status)
- `blog` - Blog posts (page_id links to parent page)
- `blog_author` - Blog authors
- `cms_menu` - Navigation menus (identifier: header/footer)
- `cms_various` - Dynamic content blocks
- `cms_list` / `cms_list_row` - List components

### Admin
- `back_users` - Admin users (supports OAuth: Google, Facebook, Microsoft)
- `back_users_log` - Action logging
- `back_settings` - Key-value settings

## Common Issues

### "short_open_tag" errors
PHP displays raw code starting with `<? $var = ...`
**Fix**: Enable `short_open_tag = On` in php.ini and restart server

### "NO_AUTO_CREATE_USER" MySQL error
MySQL 8+ doesn't support this sql_mode option
**Fix**: Remove from `platform/functions/db.php` line 28

### URLs return 404
**Fix**: Ensure `.htaccess` exists with:
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?req=$1 [QSA,L]
```
And `mod_rewrite` is enabled, `AllowOverride All` is set.

### Pages don't change (always homepage)
**Fix**: `.htaccess` must pass URL as `req` parameter: `index.php?req=$1`
