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
  (fld_first_name, fld_last_name, fld_email_address, fld_username, fld_password, fld_password_salt,fld_fk_id_privilige) 
values 
  ('Agent1','Agent1','Ramin.majidi@gmail.com','1','$2y$12$lDpKTOvxCTjhU9HsEHW03e9fTeh4b/ukUm5lyy20mW1vO0tSOu0A6','lDpKTOvxCTjhU9HsEHW03h', '1');
insert into tbl_agent 
  (fld_first_name, fld_last_name, fld_email_address, fld_username, fld_password, fld_password_salt,fld_fk_id_privilige) 
values 
  ('Agent2','Agent2','Brock2109@gmail.com','2','$2y$12$lDpKTOvxCTjhU9HsEHW03e9fTeh4b/ukUm5lyy20mW1vO0tSOu0A6','lDpKTOvxCTjhU9HsEHW03h', '2');
insert into tbl_agent 
  (fld_first_name, fld_last_name, fld_email_address, fld_username, fld_password, fld_password_salt,fld_fk_id_privilige) 
values 
  ('Agent3','Agent3','Ramin.majidi@gmail.com','1','$2y$12$lDpKTOvxCTjhU9HsEHW03e9fTeh4b/ukUm5lyy20mW1vO0tSOu0A6','lDpKTOvxCTjhU9HsEHW03h', '1');
insert into tbl_agent 
  (fld_first_name, fld_last_name, fld_email_address, fld_username, fld_password, fld_password_salt,fld_fk_id_privilige) 
values 
  ('Agent4','Agent4','Brock2109@gmail.com','2','$2y$12$lDpKTOvxCTjhU9HsEHW03e9fTeh4b/ukUm5lyy20mW1vO0tSOu0A6','lDpKTOvxCTjhU9HsEHW03h', '2');
