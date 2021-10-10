CREATE EXTENSION IF NOT EXISTS "pgcrypto";
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

DROP TABLE IF EXISTS users CASCADE;
CREATE TABLE users (
    id           UUID   NOT NULL DEFAULT uuid_generate_v4(),
    email        TEXT   NOT NULL,
    is_confirmed BOOL   NOT NULL DEFAULT FALSE,
    username     TEXT   NOT NULL,
    last_name    TEXT   NOT NULL,
    first_name   TEXT   NOT NULL,
    password     TEXT   NOT NULL
);

DROP TABLE IF EXISTS interests CASCADE;
CREATE TABLE interests (
    id           UUID   NOT NULL  DEFAULT uuid_generate_v4(),
    name         TEXT   NOT NULL
);

DROP TABLE IF EXISTS prop CASCADE;
CREATE TABLE prop (
    id           UUID    NOT NULL  DEFAULT uuid_generate_v4(),
    name         TEXT    NOT NULL
);

DROP TABLE IF EXISTS value CASCADE;
CREATE TABLE value (
    id           UUID   NOT NULL  DEFAULT uuid_generate_v4(),
    user_id      UUID   NOT NULL,
    prop_id      UUID   NOT NULL,
    value        TEXT   NOT NULL
);

DROP TABLE IF EXISTS user2interest CASCADE;
CREATE TABLE user2interest (
    user_id      UUID    NOT NULL,
    interest_id  UUID    NOT NULL
);

/**
  like
  fame
  blacklist
  visit
  fake acc
 */
-- DROP TABLE IF EXISTS actions;
-- CREATE TABLE actions (
--
-- );
