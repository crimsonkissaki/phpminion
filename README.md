## phpminion

A PHP developer helper framework providing better debugging utilities.


This project is a developmental placeholder for a few libraries I'm developing as time and needs permit.

Eventually each sub-system should be split off into its own project repo as an independent module.


## Installation:

Through Composer:

```bin
    composer require --dev crimsonkissaki/phpminion:dev-master
```

*NOTE* You will have to update your composer.json file with a repository entry for this github repo as I have not yet uploaded the repo to packagist. I will do so when I'm happy that it will work on most use-cases.

```json
        {
            "type": "vcs",
            "url": "https://github.com/crimsonkissaki/phpminion.git"
        }
        ...
        "require-dev": {
            "crimsonkissaki/phpminion": "dev-master"
        }
```
