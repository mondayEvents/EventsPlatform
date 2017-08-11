# Monday Events Project

[![Build Status](https://img.shields.io/travis/cakephp/app/master.svg?style=flat-square)](https://travis-ci.org/cakephp/app)
[![License](https://img.shields.io/packagist/l/cakephp/app.svg?style=flat-square)](https://packagist.org/packages/cakephp/app)

#### Requirements:

- PHP 7+
- Composer


#### Instructions:

To use this repo, clone using:
```
git clone https://github.com/mondayEvents/EventsPlatform.git
```

Go to *EventsPlatform* folder and run the following:
```
composer install
```

Make sure to setup your DB connection details inside the **config/app.php** file. After that, run migrations:
```
bin/cake migrations migrate
```

Happy coding :)

