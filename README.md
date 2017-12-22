# Open Names GeoHash and Long/Lat Generator

## Intro

Quick tool written in PHP 7.2 on top of a number of symfony/silly/portphp and co-ordniate packages. Currently converts the open names british national grid references to long/lat and geohashs.

## Usage

### Installation

 - `git clone git@github.com:Caffe1neAdd1ct/open-names-geohash-uk-generator.git`
 - Install PHP 7.2 and Composer https://getcomposer.org/download/
 - `php composer install`
 - Configure the app inside app/config/config.yaml
 - Create schema and pull in app/config/postcodes.sql

### Open Names Data Download

 - Navigate to https://www.ordnancesurvey.co.uk/opendatadownload/products.html
 - Find the "OS Open Names" product
 - Tick to download this product, scroll to the bottom and continue
 - Enter your life details and await your download URL to arrive via the electroic postal service
 - Pop the downloaded .zip into `data/opname_csv_gb.zip`

### Turning the cogs

Run by either executing the index.php file: 

 - chmod +x index.php
 - ./index.php extract
 - ./index.php process

Or running it through a php executable:

 - php index.php extract
 - php index.php process
