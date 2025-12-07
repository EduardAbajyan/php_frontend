# PHP Starter Framework

A lightweight, pure PHP framework for rapid web application development. This starter kit provides a clean MVC architecture with essential features for building web applications without external dependencies.

## ✨ Features

- **Pure PHP** - No external dependencies required
- **MVC Architecture** - Clean separation of concerns
- **Custom Routing** - Simple URL routing system
- **Database Connection** - Built-in database abstraction
- **Environment Configuration** - Easy environment management
- **Modular Structure** - Organized codebase for scalability

## 📋 Requirements

- PHP 7.4 or higher
- Web server (Apache/Nginx)
- MySQL/MariaDB or other supported database

## 🚀 Quick Start

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/EduardAbajyan/PHP_starter.git
   cd PHP_starter
   ```

2. **Set up environment**
   ```bash
   cp .env.example .env
   ```

3. **Configure your database connection**
   Edit the `.env` file with your database credentials:
   ```bash
   nano .env
   ```

4. **Set up web server** (See detailed Apache configuration below)

### Basic Usage

1. **Create a new controller**
   ```php
   // app/Controllers/HomeController.php
   <?php

   class HomeController
   {
       public function index()
       {
           return "Welcome to PHP Starter!";
       }
   }
   ```

2. **Define routes**
   ```php
   // routes/web.php
   $router->get('/', 'HomeController@index');
   ```

3. **Access your application**
   Visit `http://your-domain.com` to see your application in action.

## 📁 Project Structure

```
PHP_starter/
├── app/                    # Application logic
│   ├── Controllers/        # Controller classes
│   ├── Models/            # Data models
│   └── Views/             # View templates
├── config/                # Configuration files
│   └── database.php       # Database configuration
├── core/                  # Framework core files
│   ├── Router.php         # Routing system
│   ├── Database.php       # Database connection
│   └── App.php           # Application bootstrap
├── public/               # Public web directory
│   ├── index.php         # Application entry point
│   ├── css/              # Stylesheets
│   └── js/               # JavaScript files
├── routes/               # Route definitions
│   └── web.php          # Web routes
├── log/                 # Application logs (optional)
├── .env.example         # Environment variables template
├── .gitignore          # Git ignore rules
└── README.md           # This file
```

## ⚙️ Configuration

### Environment Variables

Copy `.env.example` to `.env` and configure your database settings:

```env
# Database
DB_HOST=localhost
DB_NAME=your_database
DB_USER=your_username
DB_PASS=your_password
DB_PORT=3306
```

### Web Server Configuration

#### Apache VirtualHost Configuration

You can add these lines to your `httpd.conf` file or create a separate virtual host file:

```apache
<VirtualHost *:80>
    ServerName example.example
    DocumentRoot "/path/to/your/project/PHP_starter/public"

    <Directory "/path/to/your/project/PHP_starter/public">
        Require all granted
        AllowOverride None
        DirectoryIndex index.php index.html
        Options -Multiviews +Indexes +FollowSymLinks
        
        # Rewrite rules from .htaccess
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]
    </Directory>

    # Set timeout for proxy
    ProxyTimeout 60
    
    # Map *.php to php-fpm with an explicit filesystem prefix
    <FilesMatch \.php$>
        SetHandler "proxy:fcgi://127.0.0.1:9000"
    </FilesMatch>

    ErrorLog "/opt/homebrew/var/log/httpd/example.example.error.log"
    CustomLog "/opt/homebrew/var/log/httpd/example.example.access.log" common
</VirtualHost>
```

**Important Notes:**
- Replace `example.example` with your desired domain name
- Replace `/path/to/your/project/PHP_starter/public` with the actual path to your project's public folder
- Make sure Apache has read/write permissions to the project directory
- Ensure mod_rewrite is enabled: `a2enmod rewrite` (on Ubuntu/Debian)
- Restart Apache after making changes: `sudo systemctl restart apache2`

#### Alternative: Simple .htaccess (if using shared hosting)

If you can't modify httpd.conf, ensure your `public/.htaccess` file contains:

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]
```

#### Nginx Configuration

```nginx
server {
    listen 80;
    server_name example.example;
    root /path/to/your/project/PHP_starter/public;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?url=$uri&$args;
    }

    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```

## 🛠️ Development

### Creating Controllers

```php
<?php

class UserController
{
    public function index()
    {
        // Get all users
        $users = User::all();
        include 'app/Views/users/index.php';
    }
    
    public function show($id)
    {
        // Get specific user
        $user = User::find($id);
        include 'app/Views/users/show.php';
    }
}
```

### Defining Routes

```php
// routes/web.php
$router->get('/', 'HomeController@index');
$router->get('/users', 'UserController@index');
$router->get('/users/{id}', 'UserController@show');
$router->post('/users', 'UserController@store');
```

### Working with Database

```php
<?php

class User
{
    public static function all()
    {
        $db = Database::connect();
        $stmt = $db->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function find($id)
    {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
```

### Creating Views

```php
<!-- app/Views/users/index.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Users</title>
</head>
<body>
    <h1>Users List</h1>
    <?php foreach($users as $user): ?>
        <p><?php echo htmlspecialchars($user['name']); ?></p>
    <?php endforeach; ?>
</body>
</html>
```

## 🔧 Database Setup

1. Create your database
2. Update `.env` with your database credentials
3. Create your tables as needed
4. Start building your models and controllers

Example table structure:
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## 🔧 File Permissions

Make sure your web server has proper permissions:

```bash
# Set ownership (replace www-data with your web server user)
sudo chown -R www-data:www-data /path/to/PHP_starter

# Set permissions
sudo chmod -R 755 /path/to/PHP_starter
sudo chmod -R 775 /path/to/PHP_starter/log  # If using log directory
```

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## 👨‍💻 Author

**Eduard Abajyan**
- GitHub: [@EduardAbajyan](https://github.com/EduardAbajyan)

---

⭐ Star this repository if you find it helpful for your PHP projects!
