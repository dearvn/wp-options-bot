# Options Bot
A simple bot to trade OPTIONS in WordPress plugin development using WordPress Rest API, WP-script, React, React Router, Tailwind CSS, PostCSS, Eslint, WP-Data, WP-Data Store, React Components, React CRUD, i18n, PHPUnit Test, JestUnit Test, WordPress Playwright e2e Test, Gutenberg blocks and PHP OOP plugin architecture easily in a minute.

----

## What's included?

1. WordPress Rest API
2. WP-script Setup
3. React
4. React Router
5. TypeScript
6. Tailwind CSS [Nested + ]
7. Scss
8. PostCSS
9. Eslint
10. WP-Data
11. WP-Data Redux Store [Redux Saga, Generator function, Thunk, Saga Middleware]
12. React Components
13. React CRUD Operations - Create, Reade, Update, Delete, Status changes and so many...
14. Internationalization - WP i18n
15. PHPUnit Test [Test + Fix]
16. JestUnit Test
17. WordPress Playwright e2e Test
18. PHP OOP plugin architecture [Traits + Interfaces + Abstract Classes]
19. Gutenberg blocks, Dynamic blocks

### Quick Start
```sh
# Clone the Git repository
git clone https://github.com/dearvn/wp-options-bot.git

# Install PHP-composer dependencies [It's empty]
composer install

# Install node module packages
npm i

# Start development mode
npm start

# Start development with hot reload (Frontend components will be updated automatically if any changes are made)
npm run start:hot

# To run in production
npm run build
```

After running `start`, or `build` command, there will be a folder called `/build` will be generated at the root directory.

### Activate the plugin
You need activate the plugin from plugin list page.
http://localhost/wpex/wp-admin/plugins.php

### Zip making process [Build, Localization, Version replace & Zip]
```sh
# One by one.
npm run build
npm run makepot
npm run version
npm run zip

# Single release command - which actually will run the above all in single command.
npm run release
```

After running `release` command, there will be a folder called `/dist` will be generated at the root directory with `options_bot.zip` project files.


### Run PHP Unit Test

```sh
composer run test
```

### Run all tests by single command - PHPCS, PHPUnit

```sh
composer run test:all
```

### Run Jest Unit Test

```sh
npm run test:unit
```

### Run Playwright e2e Test

Playwright doc link: https://playwright.dev/docs/running-tests

**Requirements:**
- Must have docker installed and running by ensuring these commands -
```
npm run env:stop
npm run env:start
```

**Normal e2e test**
```sh
npm run test:e2e
```

**Interactive e2e test**
```sh
npm run test:e2e:watch
```

For more about e2e Tests running please check - https://playwright.dev/docs/running-tests

### PHP Coding Standards - PHPCS

**Get all errors of the project:**
```sh
composer run phpcs
```

**Fix all errors of the project:**
```sh
composer run phpcbf
```

**Full Composer test run:**
```sh
composer run test:all
```

### Browse Plugin

http://localhost/wpex/wp-admin/admin.php?page=optionsbot#/

Where, `/wpex` is the project root folder inside `/htdocs`.

Or, it could be your custom processed URL.

### REST API's

#### REST API Documentation

1. **Options Lists**
    - Method: `GET`
    - URL: http://localhost/wpex/wp-json/options-bot/v1/options
1. **Orders Lists**
    - Method: `GET`
    - URL: http://localhost/wpex/wp-json/options-bot/v1/orders
1. **Place order manually**
    - Method: `POST`
    - URL: http://localhost/wpex/wp-json/options-bot/v1/order
    - Body:
    ```json
    {
        
    }
    ```
1. **Update Order**
    - Method: `PUT`
    - URL: http://localhost/wpex/wp-json/options-bot/v1/order/1
    - Body:
    ```json
    {
       
    }
    ```
1. **Delete Order**
    - Method: `DELETE`
    - URL: http://localhost/wpex/wp-json/options-bot/v1/order
    - Body:
    ```json
    {
        "ids": [1, 2]
    }
    ```

**Detailed Documentation** -
[View Detailed documentations with parameters and responses of the REST API](https://github.com/dearvn/wp-options-bot/blob/main/Rest-API-Docs.MD)

<details>
    <summary>Options for specific files:</summary>

**Get specific file errors of the project:**
```sh
vendor/bin/phpcs options-bot.php
```


**Fix specific file errors of the project:**
```sh
vendor/bin/phpcbf options-bot.php
```
</details>

### Versions

## Contribution

Contribution is open and kindly accepted. Before contributing, please check the issues tab if anything in enhancement or bug. If you want to contribute new, please create an issue first with your enhancement or feature idea.
Then, fork this repository and make your Pull-Request. I'll approve, if everything goes well.

## Contact
It's me, Donaldit. Find me at donald.nguyen.it@gmail.com
