# PHP-UML
[![CircleCI](https://circleci.com/gh/makeey/php-puml/tree/master.svg?style=svg&circle-token=8b4d8ce8e2d6819ef721f73b62645447207efab8)](https://circleci.com/gh/makeey/php-puml/tree/master)
[![Coverage Status](https://coveralls.io/repos/github/makeey/php-puml/badge.svg?branch=master)](https://coveralls.io/github/makeey/php-puml?branch=master)
<a href="https://github.com/phpstan/phpstan"><img src="https://img.shields.io/badge/PHPStan-enabled-brightgreen.svg?style=flat" alt="PHPStan Enabled"></a>
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

### Generate class diagrams for your code
Generate class diagrams for your code in plant UML format. 

### Features
* Generation class diagrams for folders
* Uses namespaces for separate classes in diagrams
* Don't require an autoload file
* Use PlantUML format for diagrams

### Installation 
`composer global require makeey/php-puml`

### Usage 
`php bin/app generate path_to_folder output_path/file.puml `

