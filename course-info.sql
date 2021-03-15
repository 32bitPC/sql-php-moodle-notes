SELECT TOP 1 * FROM dbo.mdl232x0_course ORDER BY id DESC;
SELECT TOP 1 * FROM dbo.mdl232x0_enrol ORDER BY id DESC;
SELECT TOP 1 * FROM dbo.mdl232x0_user ORDER BY id DESC;
SELECT TOP 1 * FROM dbo.mdl232x0_cohort ORDER BY id DESC;
SELECT TOP 2 * FROM dbo.mdl232x0_cohort_members ORDER BY id DESC;
SELECT TOP 3 * FROM dbo.mdl232x0_context ORDER BY id DESC;
SELECT TOP 1 * FROM dbo.mdl232x0_role_assignments ORDER BY id DESC;

SELECT * FROM dbo.mdl_course ORDER BY id DESC LIMIT 1;
SELECT * FROM dbo.mdl_enrol ORDER BY id DESC LIMIT 1
SELECT * FROM dbo.mdl_user ORDER BY id DESC LIMIT 1;
SELECT * FROM dbo.mdl_cohort ORDER BY id DESC LIMIT 1;
SELECT * FROM dbo.mdl_cohort_members ORDER BY id DESC LIMIT 2;
SELECT * FROM dbo.mdl_context ORDER BY id DESC LIMIT 3;
SELECT * FROM dbo.mdl_role_assignments ORDER BY id DESC LIMIT 1;
