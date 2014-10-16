<?php

/**
 * Debug
 *
 * Use this when in development
 * When enabled, cache is automatically invalided when a template file changes and
 * the dump function will be enabled
 */
$debug = false;

/**
 * Cache path
 *
 * Set this to a path which is writable by the web server user (www_data, _www, etc...)
 * Set to false to disable it
 */
$cachePath = __DIR__ . '/cache';

/**
 * Templates path
 *
 * The path which contains the templates
 * Needs to have a page/ directory and an error/404.html.twig file
 */
$templatesPath = __DIR__ . '/templates';
