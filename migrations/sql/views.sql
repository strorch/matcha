DROP VIEW IF EXISTS contact;
CREATE VIEW contact AS
SELECT      us.id       AS user_id,
            fr.value    AS fame_rate,
            ge.value    AS gender,
            bi.value    AS biography,
            lo.value    AS location,
            ag.value    AS age
FROM        users   us
LEFT JOIN   value   fr  ON fr.user_id = us.id AND fr.prop_id = prop_id('fame_rate')
LEFT JOIN   value   ge  ON ge.user_id = us.id AND ge.prop_id = prop_id('gender')
LEFT JOIN   value   bi  ON bi.user_id = us.id AND bi.prop_id = prop_id('biography')
LEFT JOIN   value   lo  ON lo.user_id = us.id AND lo.prop_id = prop_id('location')
LEFT JOIN   value   ag  ON ag.user_id = us.id AND ag.prop_id = prop_id('age')
;
