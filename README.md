OnlineCourses
=============

An online courses website based on Yii2 Advanced Application

DIRECTORY STRUCTURE
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
app/                     contains frontend page
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
tests                    contains various tests for the advanced application
    codeception/         contains tests developed with Codeception PHP Testing Framework
```


REQUIREMENTS
------------

The minimum requirement by this application template that your Web server supports PHP 5.4.0.


INSTALLATION
------------

Download the project and unzip in /var/www folder.
I uploaded vender folder, you can use it without composer.

### Config nginx

```sh
server {
    charset      utf-8;
    client_max_body_size  200M;

    listen       80; ## listen for ipv4
    #listen       [::]:80 default_server ipv6only=on; ## listen for ipv6

    server_name  course.com;
    root         /var/www/OnlineCourses;

    access_log /var/log/nginx/course.com-access.log;
    error_log  /var/log/nginx/course.com-error.log;

    location / {
        root  /var/www/OnlineCourses/app;

        rewrite ^/?(.*) /app/index.php last;

        # avoiding processing of calls to non-existing static files by Yii
        location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
            access_log  off;
            expires  360d;

            try_files  $uri =404;
        }
    }

    location /api {
        alias  /var/www/OnlineCourses/frontend/web;

        rewrite  ^(/api)/$ $1 permanent;
        try_files  $uri /frontend/web/index.php?$args;
    }

    # avoiding processing of calls to non-existing static files by Yii
    location ~ ^/api/(.+\.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar))$ {
        access_log  off;
        expires  360d;

        rewrite  ^/api/(.+)$ /frontend/web/$1 break;
        rewrite  ^/api/(.+)/(.+)$ /frontend/web/$1/$2 break;
        try_files  $uri =404;
    }

    location /admin {
        alias  /var/www/OnlineCourses/backend/web;

        rewrite  ^(/admin)/$ $1 permanent;
        try_files  $uri /backend/web/index.php?$args;
    }

    # avoiding processing of calls to non-existing static files by Yii
    location ~ ^/admin/(.+\.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar))$ {
        access_log  off;
        expires  360d;

        rewrite  ^/admin/(.+)$ /backend/web/$1 break;
        rewrite  ^/admin/(.+)/(.+)$ /backend/web/$1/$2 break;
        try_files  $uri =404;
    }

    location ~ \.php$ {
        include  fastcgi_params;
        # check your /etc/php5/fpm/pool.d/www.conf to see if PHP-FPM is listening on a socket or port
        fastcgi_pass  unix:/var/run/php5-fpm.sock; ## listen for socket
        #fastcgi_pass  127.0.0.1:9000; ## listen for port
        fastcgi_param  SCRIPT_FILENAME $document_root$fastcgi_script_name;
        try_files  $uri =404;
    }
    #error_page  404 /404.html;

    location = /requirements.php {
        deny all;
    }

    location ~ \.(ht|svn|git) {
        deny all;
    }
}
```


