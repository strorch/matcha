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


-- SELECT create_user('testuser', 'random', 'test@email.com', '1111', 1);
-- SELECT create_user('usrrrrrr', 'random', 'test@email.com', '1010', 1);
