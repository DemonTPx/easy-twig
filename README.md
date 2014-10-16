# Easy Twig

Get started with twig real quick and easy. Just start editing the `templates/page/index.html.twig` to start filling in your front page and `templates/base.html.twig` to modify the skeleton. To add a new page, for example a 'contact' page, just create the `templates/page/contact.html.twig` file and you're done!

If a page can not be found, the template `templates/error/404.html.twig` will be rendered.

## Getting started

Create a new project based on easy twig: `composer create-project demontpx/easy-twig <foldername>`

## Twig cache (optional)
If you want to enable cache, set `$cache = true` in `config.php`. Also be sure to set `$cacheFolder` to a path which is writable by the web server.
