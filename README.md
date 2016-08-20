# IT IS NOT ONLY SLIM BUT ALSO FIT 
## Introduction

Good enough RESTful API framework built on top Slim 3

> All general purpose PHP frameworks suck!
> – Rasmus Lerdorf

## Installation

```
$ composer create-project khanhicetea/slimfit your-folder-project
```

- Run on Apache2 webserver : point document root to `public` folder (enable `mod_rewrite` if you have)
- Run on builtin PHP webserver : `php -S localhost:8000 -t public public/index.php`
- Run on nginx webserver + php-fpm, use this site config example :

```
server {
    listen 80;
    server_name slimfit.dev; 

    root /www/slimfit/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php$is_args$args;
    }

    location ~ \.php$ {
        fastcgi_pass localhost:9000;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```

## LICENSE

This project is licensed under the MIT license.
