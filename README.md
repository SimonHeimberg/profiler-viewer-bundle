View profiler data outside the instance you recorded it.

Normally  use the app [ProfilerViewer](https://github.com/SimonHeimberg/profiler-viewer)
instead, which uses this bundle. Use the bundle directly in complex cases.


Installation
============

Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Applications that use Symfony Flex
----------------------------------

Open a command console, enter your project directory and execute:

```console
$ composer require simon-heimberg/profiler-viewer-bundle
```

Applications that don't use Symfony Flex
----------------------------------------

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require simon-heimberg/profiler-viewer-bundle
```

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    SimonHeimberg\ProfilerViewerBundle\ProfilerViewerBundle::class => ['dev' => true],
];
```

Configure the bundle
--------------------

### Step 1: Import the routes

To give access to routing information, import routing into
`app/config/routing.yml`:
config/routing/dev/profiler-viewer.yaml
```yaml
# config/routing/dev/profiler-viewer.yaml

_profiler_viewer:
    resource: "@ProfilerViewerBundle/Resources/config/routing/all.yaml"
    prefix: /pview # can be adapted when required
```

### Step 2 (optional): Enable overwrite files for templates (to indicate when you are in the profiler-viewer)

```console
$ mkdir -p templates/bundles/
$ ln -sr vendor/simon_heimberg/profiler_viewer_bundle/Resources/views/overwrite/WebProfilerBundle templates/bundles/
```

### Step 3 (recommended): configure the firewall for the routes

Profiler information may contain sensitive information. So protect the data by
protecting the access to the app or by configureing the firewall for all routes
starting with `/pview`.

use the bundle
--------------

Set PROFILER_VIEWER_PROFILER_PATH in .env.local (or as real environment
variable) to the profiler path you want to see data from.  
Example: `PROFILER_VIEWER_PROFILER_PATH=/mendia/from_your_system/project/var/cache/prod/profiler/`
Enable dev mode (`APP_ENV=dev`) because the symfony profiler warns when used in prod mode.

Navigate to the page http://your-app-base-url/pview/. Use the profiler as usual

Known issues
============

* router panel is not shown because it would show current router data
