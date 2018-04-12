# PHP Summary

[![StyleCI](https://styleci.io/repos/47579407/shield?branch=master)](https://styleci.io/repos/47579407)
![Packagist](https://img.shields.io/packagist/dt/DivineOmega/php-summary.svg)

A PHP library to automatically summarise text using a naive summerisation algorithm.

This summerisation algorithm in use takes the key sentence from each paragraph. It then strings these resulting sentences together to form the summary.

For more details on this algorithm, see this [blog post by Shlomi Babluki](http://thetokenizer.com/2013/04/28/build-your-own-summary-tool/).

## Installation

Require this package, with [Composer](https://getcomposer.org/), in the root directory of your project.

```bash
composer require divineomega/php-summary
```

## Usage

To use PHP Summary, you should create a new `SummaryTool` object, passing it the text content of your article. You can then call its `getSummary` method to retrieve the shortened summary of the article.

Note: The article content must have its paragraphs seperated by two new line characters.

```php
$summary = (new SummaryTool($content))->getSummary();
```
