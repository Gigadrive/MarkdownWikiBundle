# MarkdownWikiBundle

This bundle allows you to create rich subpages in a Symfony project using Markdown. Pages are stored in a file cache and sourced from an external directory, for example a Git submodule.

You can use this bundle to create help sections, information wikis or any other type of sub page, that is not supposed to be hardcoded into your Symfony codebase.

## Features

* Pages sourced from Markdown files
* Page meta stored in separate YAML files
* Multi-language support without constraints for locale codes
* Custom implementations for parsing, storing and fetching pages

## Requirements

* Symfony 5.3+
* PHP 8

## Installation

```bash
composer require gigadrive/markdown-wiki-bundle
```

## Configuration

This bundle is configured using standard Symfony bundle configuration.

```yaml
# config/packages/markdown_wiki_bundle.yaml
markdown_wiki_bundle:
    source_directory: "%kernel.project_dir%/example-wiki/pages/"
```

* `source_directory` defines a path to the directory holding your source files. These are the files that make up the content and data of your wiki. For best practice, use a Git submodule.

## Usage

Once you have installed and configured the bundle, you need to create a file structure for your Markdown files. You can find an example wiki for help [here](https://github.com/Gigadrive/mcskinhistory-wiki).

The file structure within your wiki directory is held simple.

* Every folder represents a level of your page's path.
* Every folder for a page needs to contain two files, one called `meta.yaml` and one called `content.md`. If you wish to support multiple languages, name these files depending on your language code. For example for an English page, call them `en.md` and `en.yaml`
* `meta.yaml` files need to contain the following keys:
    `title` The page's title
    `description` The page's description

**Example:** If you want to create a page with the path `/account/creation`, you would need a folder with the path `/account/creation`. In that folder, you would create a file named `meta.yaml` and a file named `content.md`. The first contains meta data about your page, the second contains your actual page content.

### Serving pages

You can find an example Controller to serve pages [here](https://github.com/Gigadrive/MarkdownWikiBundle/blob/master/src/Controller/MarkdownWikiController.php).

### Customizing the parser

MarkdownWikiBundle is built using [Parsedown](https://github.com/erusev/parsedown), a free and open-source library to parse Markdown with PHP. This bundle registers Parsedown as a service ([`MarkdownWikiParser`](https://github.com/Gigadrive/MarkdownWikiBundle/blob/master/src/Service/MarkdownWikiParser.php)) and uses it for parsing. To overwrite parsing behavior, do the following:

First, create your own implementation of the parser:

```php
namespace App\Service;

use Gigadrive\Bundle\MarkdownWikiBundle\Service\MarkdownWikiParser;

class ExampleParser extends MarkdownWikiParser {
    // TODO: Extend Parsedown
}
```

Now you have a class that extends Parsedown. Refer to [Parsedown's documentation to extend parsing behavior](https://github.com/erusev/parsedown/wiki/Tutorial:-Create-Extensions) in this new service. Once you are done, register your new parser by overwriting it in the Symfony container:

```yaml
# config/services.yaml
services:
    app.parser:
        class: App\Service\ExampleParser

    markdownwiki.parser:
        alias: app.parser
```

### Customizing the storage

By default, pages are cached in the Symfony file cache. This behavior can be overwritten using the [`MarkdownWikiStorageInterface`](https://github.com/Gigadrive/MarkdownWikiBundle/blob/master/src/Service/Storage/MarkdownWikiStorageInterface.php). With this interface, you can create your own storage behavior and save cached pages in Redis, Doctrine or wherever you need.

To ensure that the bundle uses your storage and not the default one, the `markdownwiki.storage` container key needs to be overwritten:

```yaml
# config/services.yaml
services:
    markdownwiki.storage.example:
        class: App\Service\YourStorageImplementation

    markdownwiki.storage:
        alias: markdownwiki.storage.example
```

### Example Wiki

This bundle was created for the MCSkinHistory help section. You can find the source of it [here](https://github.com/Gigadrive/mcskinhistory-wiki) to help you understand the intended structure for a wiki like this.

### Rebuilding the caches

Whenever there is an update to the wiki pages, the internal caches of the bundle need to be rebuilt. This can be done by running the following console command, which comes with this bundle:

```bash
php bin/console wiki:rebuild-storage-cache
```

Caches can also be rebuilt programatically through the `MarkdownWikiStorageService`:

```php
use Gigadrive\Bundle\MarkdownWikiBundle\Service\MarkdownWikiStorageService;

class ExampleService {
    public function __construct(
        protected MarkdownWikiStorageService $storageService
    ) {
    }

    public function rebuildCaches() {
        $this->storageService->rebuildStorageCache();
    }
}
```

## Testing

This bundle uses PHPUnit as a testing framework.

When developing for this bundle, use the following commands to test its functionality:

```
git submodule update --init --recursive
composer install
php ./vendor/bin/phpunit
```

## Copyright and License

This program was developed by [Mehdi Baaboura](https://github.com/Zeryther) and published by [Gigadrive UG](https://gigadrivegroup.com) under the MIT License. For more information click [here](https://github.com/Gigadrive/MarkdownWikiBundle/blob/master/LICENSE).
