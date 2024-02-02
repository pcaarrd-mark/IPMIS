CREATE VIEW view_project AS
SELECT
	a.*
FROM
	b_p202__projects AS a;


CREATE OR REPLACE VIEW view_project_pap_attribution AS
SELECT
	a.project_id,
	a.pap_code,
	a.pap_sub
FROM b_p202_pap_attributions AS a
GROUP BY a.project_id,a.pap_code,a.pap_sub;


CREATE OR REPLACE VIEW view_project_target_accomp AS
SELECT
	a.project_id,
	a.accom
FROM b_p202_target_accomps AS a
GROUP BY a.project_id,a.accom;

CREATE OR REPLACE VIEW view_project_pap_infra AS
SELECT
	a.project_id,
	a.pap_code,
	a.infra_sub
FROM b_p202_opt_cost_infras AS a
GROUP BY a.project_id,a.pap_code,a.infra_sub;