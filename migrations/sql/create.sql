DROP TABLE IF EXISTS users;
CREATE TABLE users (
   id          int  NOT NULL,
   email       text NOT NULL,
   username    text NOT NULL,
   last_name   text NOT NULL,
   first_name  text NOT NULL,
   password    text NOT NULL
);

DROP TABLE IF EXISTS contact;
CREATE TABLE contact (
    id          int NOT NULL,
    user_id     INT NOT NULL,
    login       text NOT NULL,
    password    text NOT NULL,
    gender_id   int NOT NULL,
    name        text NOT NULL,
    last_name   text NOT NULL,
    email       text NOT NULL
);

DROP TABLE IF EXISTS interests;
CREATE TABLE interests (
   id      int  not null,
   name    text NOT NULL
);

DROP TABLE IF EXISTS user2interest;
CREATE TABLE user2interest (
   id          int not null,
   user_id     int NOT NULL,
   interest_id text NOT NULL
);

DROP TABLE IF EXISTS prop;
CREATE TABLE prop (
    obj_id   |
    class_id |
    name     |
    type_id  |
    no       |
    is_t     |
    is_n     |
    is_s     |
    is_r     |
    def      |
    keep_def |
);
DROP TABLE IF EXISTS value;
CREATE TABLE value (
    id
    obj_id
    prop_id
    no
    value

);


DROP TABLE IF EXISTS gender;
CREATE TABLE gender (
                        id      SERIAL PRIMARY KEY NOT NULL,
                        name    text NOT NULL
);

/**
  like
  fame
  blacklist
  visit
  fake acc
 */
DROP TABLE IF EXISTS actions;
CREATE TABLE actions (
                         id      SERIAL PRIMARY KEY NOT NULL,
                         name    text NOT NULL
);


DROP TABLE IF EXISTS likes;
CREATE TABLE likes (
                       id SERIAL PRIMARY KEY NOT NULL,
                       user_id INTEGER NOT NULL,
                       post_id INTEGER NOT NULL
);
