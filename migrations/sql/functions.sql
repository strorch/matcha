CREATE OR REPLACE FUNCTION set_value (a_user_id UUID, a_prop_id UUID, a_value TEXT) RETURNS UUID AS $$
BEGIN
    INSERT INTO value (user_id, prop_id, value) VALUES (a_user_id, a_prop_id, a_value) RETURNING id;
END
$$ LANGUAGE 'plpgsql';

CREATE OR REPLACE FUNCTION prop_id (a_name TEXT) RETURNS UUID AS $$
DECLARE
    res UUID;
BEGIN
    SELECT id FROM prop WHERE name=a_name INTO res;
    RETURN res;
END
$$ LANGUAGE 'plpgsql';


CREATE OR REPLACE FUNCTION crypt_password (password TEXT) RETURNS TEXT AS $$
DECLARE
    res TEXT;
BEGIN
    SELECT crypt(password, gen_salt('md5')) INTO res;
    RETURN res;
END
$$ LANGUAGE 'plpgsql';

CREATE OR REPLACE FUNCTION check_password (to_check TEXT, db_record TEXT) RETURNS TEXT AS $$
DECLARE
    res BOOL;
BEGIN
    SELECT db_record = crypt(to_check, db_record) INTO res;
    RETURN res;
END
$$ LANGUAGE 'plpgsql';
