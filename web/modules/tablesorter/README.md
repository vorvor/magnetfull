# Tablesorter module for Drupal

Tablesorter is a jQuery plugin for turning a standard HTML table
with THEAD and TBODY tags into a sortable table without page refreshes.
tablesorter can successfully parse and sort many types of data including
linked data in a cell.

## Installation

### Using Composer
1. Include the following lines in the `repositories` section
 of your project's `composer.json`:

        {
            "type": "package",
                "package": {
                "name": "mottie/tablesorter",
                "version": "2.31.1",
                "type": "drupal-library",
                "dist": {
                    "url": "https://github.com/Mottie/tablesorter/archive/v2.31.1.zip",
                    "type": "zip"
                }
            }
        }
2. Run `composer require mottie/tablesorter`

### Without Composer
1. Download the Mottie Table sorter library from https://github.com/Mottie/tablesorter/
2. Extract it into your site's `web/libraries` directory
3. rename to folder to `tablesorter`

## How to use

Please download tablesorter plugin from here
https://mottie.github.io/tablesorter/docs/

Add "tablesorter" class to your Table code like in example given.
`<table id="myTable" class="tablesorter">`

Select Skin from the configuration page.

## Configuration page

1. Configuration > User-Interface > Tablesorter
