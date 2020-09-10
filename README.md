# Matcha educational project

### Authors
* [mstorcha](https://github.com/strorch)
* [grevenko](https://github.com/charmingelle/)
* [vlvereta](https://github.com/vlvereta/)

# Run application

To prepare configs you need to create ``.env`` file. Example of this file is ``.env.local`` file.

To prepare docker environment you need to create ``docker-compose.yml`` file from examples.
For backend development use ``docker-compose.back.yml``, for frontend - ``docker-compose.front.yml``.

To build and run application use ``docker-compose up -d --build``. All services will work on `SITE_HOST` param from `.env` file.

Now you can check web interface on `http://{SITE_HOST}`, http api on `http://{SITE_HOST}:8080`, websocket api on `ws://{SITE_HOST}:8000` and etc.

### Database

To configure a database you have to run next command:
   
    docker-compose exec http ./migrate.php
    
### Dir manual

    client/     - react client app
    config/     - DI, http routes and settings configuration
    http/       - entry point of http server
    migrations/ - DB migrations
    runtime/    - cache files
    socket/     - entry point of socket server
    src/        - project source code
    test/       - phpunit tests

### HTTP manual:

    GET /
    GET /testCacheSet - check session work with test data
    GET /testSendMail - check send email
    POST /auth/login - allowed while guest
    POST /auth/signUp - allowed while guest
    POST /auth/logout - allowed while authenticated
    PATCH /auth/confirm-email
    GET /api/users - users search with parameters, allowed while authenticated
    PUT /api/user - user update, allowed while authenticated
