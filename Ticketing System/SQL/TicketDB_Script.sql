insert into tbl_privilige (fld_privilige) values ('Admin-Agent');
insert into tbl_privilige (fld_privilige) values ('Agent');

insert into tbl_job_type (fld_type) value ('Hardware');
insert into tbl_job_type (fld_type) value ('Software');
insert into tbl_job_type (fld_type) value ('Network');
insert into tbl_job_type (fld_type) value ('Content-Creation');
insert into tbl_job_type (fld_type) value ('Advice/Tutorial');
insert into tbl_job_type (fld_type) value ('Other');

insert into tbl_status (fld_status) value ('Open');
insert into tbl_status (fld_status) value ('Closed-resolved');
insert into tbl_status (fld_status) value ('Closed-unresolved');
insert into tbl_status (fld_status) value ('In-progress');
insert into tbl_status (fld_status) value ('Delayed');
insert into tbl_status (fld_status) value ('Open');

insert into tbl_priority (fld_priority) value ('Low');
insert into tbl_priority (fld_priority) value ('Medium');
insert into tbl_priority (fld_priority) value ('High');
insert into tbl_priority (fld_priority) value ('Extreme');
insert into tbl_priority (fld_priority) value ('Time-Sensitive');

insert into tbl_agent_bridge (fld_fk_id_agent, fld_fk_id_job) values ('1','37');
insert into tbl_agent_bridge (fld_fk_id_agent, fld_fk_id_job) values ('2','37');


insert into tbl_agent 
  (fld_first_name, fld_last_name, fld_email_address, fld_username, fld_password, fld_password_salt, fld_fk_id_privilige) 
values 
  ('Admin','Admin','Ded@ded.Ded','Admin','$2y$12$UVoj0opWrxwx91xlfplhYet3NyhfuCJY/h3NR6/ey/VwmNyTNxyRe','UVoj0opWrxwx91xlfplhYq', '1');
insert into tbl_agent 
  (fld_first_name, fld_last_name, fld_email_address, fld_username, fld_password, fld_password_salt,fld_fk_id_privilige) 
values 
  ('Agent','Agent','Ded@ded.Ded','Agent1','$2y$12$UVoj0opWrxwx91xlfplhYet3NyhfuCJY/h3NR6/ey/VwmNyTNxyRe','UVoj0opWrxwx91xlfplhYq', '2');
insert into tbl_agent 
  (fld_first_name, fld_last_name, fld_email_address, fld_username, fld_password, fld_password_salt,fld_fk_id_privilige) 
values 
  ('Agent','Agent','Ded@ded.Ded','Agent2','$2y$12$UVoj0opWrxwx91xlfplhYet3NyhfuCJY/h3NR6/ey/VwmNyTNxyRe','UVoj0opWrxwx91xlfplhYq', '2');
insert into tbl_agent 
  (fld_first_name, fld_last_name, fld_email_address, fld_username, fld_password, fld_password_salt,fld_fk_id_privilige) 
values 
  ('Agent','Agent','Ded@ded.Ded','Agent3','$2y$12$UVoj0opWrxwx91xlfplhYet3NyhfuCJY/h3NR6/ey/VwmNyTNxyRe','UVoj0opWrxwx91xlfplhYq', '2');
