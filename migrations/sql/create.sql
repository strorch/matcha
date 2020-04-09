DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id           SERIAL NOT NULL,
    email        TEXT   NOT NULL,
    is_confirmed BOOL   NOT NULL DEFAULT FALSE,
    username     TEXT   NOT NULL,
    last_name    TEXT   NOT NULL,
    first_name   TEXT   NOT NULL,
    password     TEXT   NOT NULL
);

DROP TABLE IF EXISTS prop;
CREATE TABLE prop (
    id           SERIAL  NOT NULL,
    name         TEXT    NOT NULL
);

DROP TABLE IF EXISTS value;
CREATE TABLE value (
    id           SERIAL NOT NULL,
    user_id      INT    NOT NULL,
    prop_id      INT    NOT NULL,
    value        TEXT   NOT NULL
);

DROP TABLE IF EXISTS interests;
CREATE TABLE interests (
    id           SERIAL NOT NULL,
    name         TEXT   NOT NULL
);

DROP TABLE IF EXISTS user2interest;
CREATE TABLE user2interest (
    id           SERIAL NOT NULL,
    user_id      INT    NOT NULL,
    interest_id  INT    NOT NULL
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
