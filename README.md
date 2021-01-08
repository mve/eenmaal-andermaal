# EenmaalAndermaal Groep 2
## Setup

1. ```composer update && composer install```
2. ```cp .env.example .env```
3. ```php artisan key:generate```
4. ```npm install```

## Setup (PHP/Composer/NodeJS/NPM not yet installed)
1. Download and install XAMPP from https://www.apachefriends.org/download.html
2. Windows Settings -> System -> About -> Advanced System Settings -> Environment Variables -> Path (System Variables) -> Edit
3. Click 'New' and insert the PHP folder path: ```C:\xampp\php```
4. Check if the path is working by opening a new command prompt and typing ```php -v```
5. Download and install Composer from https://getcomposer.org/download/
6. Download and install NodeJS from https://nodejs.org/en/ (this includes NPM)
7. Follow the regular Setup steps above.

## Development

Run local server
```
 php artisan serve 
```

Watch CSS & JS
```
 npm run watch 
```

