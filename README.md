Easy Twig
=========

Easy twig is a very small and simple framework to get started with Twig quickly.

Just start editing the `templates/page/index.html.twig` to start filling in your front page and `templates/base.html.twig` to modify the skeleton. To add a new page, for example a 'contact' page, just create the `templates/page/contact.html.twig` file and you're done! See [Pages](#Pages).

If a page can not be found, the template `templates/error/404.html.twig` will be rendered.

Getting started
---------------

Create a new project based on easy twig:

    composer create-project demontpx/easy-twig <folder_name>

Pages
-----

Assuming your projects runs on the `domain.tld` domain:

- `templates/page/index.html.twig` will be the homepage of the project, accessible through `http://domain.tld/`
- `templates/page/error/404.html.twig` contains the "Not found" error page
- Any template outside `templates/page/` will not be directly accessible for the user and should be used to contain inherited, included and other templates
- Any page inside `templates/page/` will be directly accessible by its name; for example:


| Template | URL |
|----------|-----|
| contact.html.twig | http://domain.tld/contact |
| information/about-us.html.twig | http://domain.tld/information/about-us |
| contact-us/index.html.twig | http://domain.tld/contact-us/ |

Note that removing the last slash will try to access `contact-us.html.twig`

Configuration
-------------

Check out the `config.php` file for configuration settings.

Setting up apache2
------------------

Set the document root to the `web/` folder. You also might want set `AllowOverride All` and enable `mod_rewrite` for some pretty URLs. Your configuration might look a bit like this:

```ApacheConf
<VirtualHost *:80>
    ServerName domain.tld
    ServerAlias www.domain.tld

    DocumentRoot /var/www/website/web
    <Directory /var/www/website/web>
        AllowOverride All
    </Directory>
</VirtualHost>
```

Setting up Nginx
----------------

Configuration might look a bit like this:

```Nginx
server {
    server_name domain.tld www.domain.tld;
    root /var/www/website/web;

    location / {
        try_files $uri /app.php$is_args$args;
    }

    location ~ ^/app\.php(/|$) {
        fastcgi_pass unix:/var/run/php5-fpm.sock;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param HTTPS off;
    }
}
```
