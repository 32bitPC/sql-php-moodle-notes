SELECT TOP 1 * FROM dbo.mdl232x0_course ORDER BY id DESC;
SELECT TOP 1 * FROM dbo.mdl232x0_enrol ORDER BY id DESC;
SELECT TOP 1 * FROM dbo.mdl232x0_user ORDER BY id DESC;
SELECT TOP 1 * FROM dbo.mdl232x0_cohort ORDER BY id DESC;
SELECT TOP 2 * FROM dbo.mdl232x0_cohort_members ORDER BY id DESC;
SELECT TOP 3 * FROM dbo.mdl232x0_context ORDER BY id DESC;
SELECT TOP 1 * FROM dbo.mdl232x0_role_assignments ORDER BY id DESC;

SELECT * FROM mdl_course ORDER BY id DESC LIMIT 1;
SELECT * FROM mdl_enrol ORDER BY id DESC LIMIT 1
SELECT * FROM mdl_user ORDER BY id DESC LIMIT 1;
SELECT * FROM mdl_cohort ORDER BY id DESC LIMIT 1;
SELECT * FROM mdl_cohort_members ORDER BY id DESC LIMIT 2;
SELECT * FROM mdl_context ORDER BY id DESC LIMIT 3;
SELECT * FROM mdl_role_assignments ORDER BY id DESC LIMIT 1;
