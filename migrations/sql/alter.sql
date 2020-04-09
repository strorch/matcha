ALTER TABLE ONLY users          ADD CONSTRAINT user_id_pkey             PRIMARY KEY (id);
ALTER TABLE ONLY prop           ADD CONSTRAINT prop_id_pkey             PRIMARY KEY (id);
ALTER TABLE ONLY value          ADD CONSTRAINT value_id_pkey            PRIMARY KEY (id);
ALTER TABLE ONLY interests      ADD CONSTRAINT interest_id_pkey         PRIMARY KEY (id);
ALTER TABLE ONLY user2interest  ADD CONSTRAINT user2interest_id_pkey    PRIMARY KEY (id);

ALTER TABLE ONLY value          ADD CONSTRAINT value_user_id_fkey       FOREIGN KEY (user_id)       REFERENCES users (id) ON DELETE CASCADE;
ALTER TABLE ONLY value          ADD CONSTRAINT value_prop_id_fkey       FOREIGN KEY (prop_id)       REFERENCES prop  (id);

ALTER TABLE ONLY user2interest  ADD CONSTRAINT u2i_user_id_fkey         FOREIGN KEY (user_id)       REFERENCES users (id) ON DELETE CASCADE;
ALTER TABLE ONLY user2interest  ADD CONSTRAINT u2i_interest_id_fkey     FOREIGN KEY (interest_id)   REFERENCES interests (id);

ALTER TABLE ONLY users          ADD CONSTRAINT users_username_uniq      UNIQUE (username);

CREATE INDEX     prop_name_idx         ON prop (name);
