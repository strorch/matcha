### Matcha educational project

    client/     - react client app
    config/     - DI, http routes and settings configuration
    http/       - entry point of http server
    migrations/ - DB migrations
    runtime/    - cache files
    socket/     - entry point of socket server
    src/        - project source code
    test/       - phpunit tests


# Run application

To run PHP apps you need to install required packages and prepare configuration.

  1. To install packages run ``composer update`` in root of repository.
  2. To prepare configs you need to create ``.env`` file. Example of this file is ``.env.local`` file.

If you will have errors like `bad configuration` or other, try to run ``composer du`` command.

`Also` while you are working not in docker, all server logs and errors will displaying in your terminal.
In case docker logs will be in `runtime/app.log`.

After preparing environment you need to run http and websocket servers.

### Websocket

To run websocket server you need to run command:

    php socket/index.php

Now you need just to connect to `ws://0.0.0.0:8000`.

Host and port of socket connection are configured in .env file.

### Http

To run http server you need to run command:

    php -S localhost:8080 -t http http/index.php

Now you can check `localhost:8080`.

This will work for auth and client actions.

### Docker

Also you can run whole application with docker. Use ``dc up -d``.
Websocket, http and database will work on `SITE_HOST` param from `.env` file.

### Database

To configure migration you have to run next command:

   1. In local environment:
   
            ./migrate.php
            
   2. Docker environment (after changing of db host in .env file):
   
            dc exec http ./migrate.php
