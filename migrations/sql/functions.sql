CREATE OR REPLACE FUNCTION gender_id (a_name text) RETURNS integer AS $$
SELECT id FROM gender WHERE name=a_name;
$$ LANGUAGE sql IMMUTABLE STRICT;

CREATE OR REPLACE FUNCTION user_id (a_login text) RETURNS integer AS $$
SELECT id FROM users WHERE login=a_login;
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

-- CREATE OR REPLACE FUNCTION create_user (a_login text, a_password text, a_email text, a_salt text, a_log_stat integer) RETURNS VOID AS $$
-- BEGIN
--     INSERT INTO users (login, password, email, salt, notifications, log_stat) VALUES
--     (a_login, a_password, a_email, a_salt, 1, a_log_stat);
-- END
-- $$ LANGUAGE 'plpgsql';
