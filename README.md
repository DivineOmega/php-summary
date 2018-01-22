# PHP Summary

A PHP library to automatically summarise text using a naive summerisation algorithm.

This summerisation algorithm in use takes the key sentence from each paragraph. It then strings these resulting sentences together to form to summary.

For more details on this algorithm, see this [blog post by Shlomi Babluki](http://thetokenizer.com/2013/04/28/build-your-own-summary-tool/).

## Installation

Require this package, with [Composer](https://getcomposer.org/), in the root directory of your project.

```bash
composer require divineomega/php-summary
```

## Usage

To use PHP Summary, you should create a new `SummaryTool` object, passing it the title and plain text content of your article. You can then call its `getSummary` method to retrieve the shortened summary of the article.

```php
$summaryTool = new SummaryTool($title, $content);
$summary = $summaryTool->getSummary();
```
