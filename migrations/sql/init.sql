INSERT INTO prop (name) VALUES ('fame_rate');
INSERT INTO prop (name) VALUES ('gender');
INSERT INTO prop (name) VALUES ('biography');
INSERT INTO prop (name) VALUES ('location');
INSERT INTO prop (name) VALUES ('age');
INSERT INTO prop (name) VALUES ('picture');
INSERT INTO prop (name) VALUES ('interest');

INSERT INTO users (email, username, last_name, first_name, password)
VALUES  ('test.email@email.com', 'test_user', 'last_name', 'first_name', crypt_password('random'));
