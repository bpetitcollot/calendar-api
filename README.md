# calendar-api
A symfony 4 API for personal calendars management
## Installation
clone this repo and then
```
composer update
php bin/console doctrine:schema:update --force
```
## Usage
Calendars & Events are exposed through a standard JSON-API at paths '/calendars' & '/events'

Use my ember calendar-app or build your own.
