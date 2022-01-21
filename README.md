# Laravel Envoy Deployment

Envoy is a task runner which uses the `Blade` templating language as a method to script actions.
This Envoy script is designed to be used with `Laravel 7+` projects and can be cloned within the Laravel root or downloaded separately and included in your Laravel project.

## Requirements
- `Laravel7+`

On the remote server:
- `Composer`
- `Node`
- `Npm`

## Installation
1. First, install Envoy into your project using the Composer package manager:

`composer require laravel/envoy --dev`

2. Download or clone the `.dev` folder inside the Laravel root.
3. Edit your `.gitignore` file by adding the line 
   
`/.dev`

## Configurations
Envoy Deploy uses DotEnv to fetch your server and repository details.

The following configuration items are required on the `.dev/deployment/env` file:

- `REPOSITORY_URL`
- `SERVER_HOST`
- `SERVER_PORT`
- `SERVER_USERNAME`
- `SERVER_APP_PATH`
- `SERVER_APP_DIR`
- `DB_HOST`
- `DB_PORT`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`
- `APP_URL`

**By default the compilation of assets through `Laravel Mix` is set so it is mandatory to have Node and Npm installed on your server.

To do this, you need to set the path and the version of Npm in use on the server by editing the `tasks.blade.php` file on `line 71` and `line 78`

## Commands

### Run first deployment

`envoy run deployment_first --branch=branch_name`

### Run the other distributions

`envoy run deployment --branch=branch_name`

## Note
If you should have remote server authorization problems check the permissions on your computer's `/.ssh/config` file.

Before using on live server, it is best to test on a local VM first.