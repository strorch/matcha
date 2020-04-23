### Matcha educational project

    client/     - react client app
    config/     - DI, http routes and settings configuration
    http/       - entry point of http server
    migrations/ - DB migrations
    runtime/    - cache files
    socket/     - entry point of socket server
    src/        - project source code
    test/       - phpunit tests

### Authors
* [mstorcha](https://github.com/strorch)
* [vlvereta](https://github.com/vlvereta/)

# Run application

To run PHP apps you need to install required packages and prepare configuration.

  1. To install packages run ``composer update`` in root of repository.
  2. To prepare configs you need to create ``.env`` file. Example of this file is ``.env.local`` file.

If you will have errors like `bad configuration` or other, try to run ``composer du`` command.

After preparing environment you need to run http and websocket servers.

Use ``dc up -d``. Websocket, http and database will work on `SITE_HOST` param from `.env` file.

Now you can check http on `http://127.0.0.2:8080` and websocket on `ws://127.0.0.2:8000`.

### Database

To configure migration you have to run next command:
   
    dc exec http ./migrate.php

HTTP manual:

    GET /
    GET /testCacheSet - check session work with test data
    GET /testSendMail - check send email
    POST /auth/login - allowed while guest
    POST /auth/signUp - allowed while guest
    POST /auth/logout - allowed while authenticated
    PATCH /auth/confirm-email
    GET /api/users - users search with parameters, allowed while authenticated
    PUT /api/user - user update, allowed while authenticated
