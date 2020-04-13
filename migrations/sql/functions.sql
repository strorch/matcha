CREATE OR REPLACE FUNCTION set_value (a_user_id INT, a_prop_id INT, a_value TEXT) RETURNS INT AS $$
BEGIN
    INSERT INTO value (user_id, prop_id, value) VALUES (a_user_id, a_prop_id, a_value) RETURNING id;
END
$$ LANGUAGE 'plpgsql';

CREATE OR REPLACE FUNCTION prop_id (a_name TEXT) RETURNS INT AS $$
    SELECT id FROM prop WHERE name=a_name;
$$ LANGUAGE SQL IMMUTABLE STRICT;

