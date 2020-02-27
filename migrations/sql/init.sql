DROP TABLE IF EXISTS user;
CREATE TABLE user (
  id SERIAL PRIMARY KEY NOT NULL,
  login text NOT NULL,
  password text NOT NULL,
  gender_id int NOT NULL,
  name text NOT NULL,
  last_name text NOT NULL,
  email text NOT NULL,
  salt text NOT NULL,
  date date DEFAULT now()
);

DROP TABLE IF EXISTS address;
CREATE TABLE address (
  id SERIAL PRIMARY KEY NOT NULL,
  user_id INTEGER NOT NULL,
  country_id int NOT NULL,
  street_id int NOT NULL,
  house_num int NOT NULL,
  flat_num int
);

DROP TABLE IF EXISTS gender;
CREATE TABLE gender (
  id SERIAL PRIMARY KEY NOT NULL,
  name text NOT NULL
);

DROP TABLE IF EXISTS country;
CREATE TABLE country (
  id SERIAL PRIMARY KEY NOT NULL,
  name text NOT NULL
);

CREATE OR REPLACE FUNCTION gender_id (a_name text) RETURNS integer AS $$
    SELECT id FROM gender WHERE name=a_name;
$$ LANGUAGE sql IMMUTABLE STRICT;

INSERT INTO gender (name) VALUES ('male');
INSERT INTO gender (name) VALUES ('female');
INSERT INTO gender (name) VALUES ('other');


INSERT INTO users (login, password, gender_id, name, last_name, email, salt, date)
VALUES ('test01', 'passwd', gender_id('male'), 'test_name', 'last_name', 'test@email.com', 'salt1', now());
INSERT INTO users (login, password, gender_id, name, last_name, email, salt, date)
VALUES ('test02', 'passwd', gender_id('female'), 'test_name1', 'last_name1', 'test1@email1.com', 'salt1', now());
INSERT INTO users (login, password, gender_id, name, last_name, email, salt, date)
VALUES ('test03', 'passwd', gender_id('other'), 'test_name3', 'last_name3', 'test3@email.com', 'salt1', now());
-- ALTER TABLE ONLY users             ADD CONSTRAINT test_table_id_pkey           PRIMARY KEY (test_table_id);
-- ALTER TABLE ONLY users             ADD CONSTRAINT users_uniq                   UNIQUE (users_id);

DROP TABLE IF EXISTS likes;
CREATE TABLE likes (
    id SERIAL PRIMARY KEY NOT NULL,
    user_id INTEGER NOT NULL,
    post_id INTEGER NOT NULL
);

CREATE OR REPLACE FUNCTION user_id (a_login text) RETURNS integer AS $$
    SELECT id FROM user WHERE login=a_login;
$$ LANGUAGE sql IMMUTABLE STRICT;

CREATE OR REPLACE FUNCTION set_like (a_post_id integer, a_user_id integer) RETURNS VOID AS $$
BEGIN
    INSERT INTO likes (user_id, post_id) VALUES (a_user_id, a_post_id);
END
$$ LANGUAGE 'plpgsql';

CREATE OR REPLACE FUNCTION remove_like (a_post_id integer, a_user_id integer) RETURNS VOID AS $$
BEGIN
    DELETE
    FROM    likes
    WHERE   post_id=a_post_id
    AND     user_id=a_user_id;
END
$$ LANGUAGE 'plpgsql';

CREATE OR REPLACE FUNCTION create_user (a_login text, a_password text, a_email text, a_salt text, a_log_stat integer) RETURNS VOID AS $$
BEGIN
    INSERT INTO users (login, password, email, salt, notifications, log_stat) VALUES
    (a_login, a_password, a_email, a_salt, 1, a_log_stat);
END
$$ LANGUAGE 'plpgsql';

SELECT create_user('testuser', 'random', 'test@email.com', '1111', 1);
SELECT create_user('usrrrrrr', 'random', 'test@email.com', '1010', 1);
