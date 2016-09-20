SELECT 
    A.fld_first_name,
    A.fld_last_name,
    N.fld_content,
	ATT.fld_fk_id_attachment
FROM
    tbl_agent A,
    tbl_note N
    LEft join 
		tbl_note_attachment_bridge ATT
	ON N.fld_id_note = ATT.fld_fk_id_note
WHERE
	A.fld_id_agent = N.fld_fk_id_agent_note
		AND N.fld_fk_id_job_note = 37