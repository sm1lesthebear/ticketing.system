SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema ticketdb
-- -----------------------------------------------------

Drop database if exists ticketdb;
CREATE SCHEMA IF NOT EXISTS ticketdb DEFAULT CHARACTER SET utf8 ;
USE ticketdb;

-- -----------------------------------------------------
-- Schema intranetdb
- -----------------------------------------------------

CREATE SCHEMA IF NOT EXISTS ticketdb DEFAULT CHARACTER SET utf8 ;
USE ticketdb;
 

create table if not exists ticketdb.tbl_status(
	fld_id_status int(11) auto_increment not null,
	fld_status varchar(30) not null,
    primary key (fld_id_status));    

     
    
create table if not exists ticketdb.tbl_attachment(
	fld_id_attachment int(11) auto_increment not null,
	fld_type varchar(30) not null,
	fld_data blob not null,
    primary key (fld_id_attachment));
    
    
create table if not exists ticketdb.tbl_job_type(
	fld_id_job_type int(11) auto_increment not null,
	fld_type varchar(45) not null,
    primary key (fld_id_job_type));

    
    
create table if not exists ticketdb.tbl_client(
	fld_id_client int(11) auto_increment not null,
	fld_first_name varchar(45),
    fld_last_name varchar(45),
	fld_phone_number varchar(45),
    fld_email_address varchar(45),
	primary key (fld_id_client));
    

create table if not exists ticketdb.tbl_privilige(
	fld_id_privilige int(11) auto_increment not null,
	fld_privilige varchar(45) not null,
    primary key (fld_id_privilige));
    

create table if not exists ticketdb.tbl_priority(
	fld_id_priority int(11) auto_increment not null,
	fld_priority varchar(45),
    primary key (fld_id_priority));
    

create table if not exists ticketdb.tbl_agent(
	fld_id_agent int(11) auto_increment not null,
	fld_first_name varchar(45) not null,
    fld_last_name varchar(45) not null,
    fld_email_address varchar(45),
    fld_username varchar(45),
	fld_password text,
    fld_password_salt varchar(45),
    fld_fk_id_privilige int(11) not null,
    primary key (fld_id_agent),
		index fld_fk_id_privilige_idx (fld_fk_id_privilige ASC),
	constraint fld_fk_id_privilige
		foreign key (fld_fk_id_privilige)
			references ticketdb.tbl_privilige (fld_id_privilige)
            ON DELETE NO ACTION
						ON UPDATE NO ACTION);


create table if not exists ticketdb.tbl_job_attachment_bridge(
	fld_id_job_attachment_bridge int(11) auto_increment not null,
    fld_fk_id_job int(11) not null,
    fld_fk_id_attachment int(11) not null,
    primary key (fld_id_job_attachment_bridge),
		index fld_fk_id_job_idx (fld_fk_id_job ASC),
        index fld_fk_id_attachment_idx (fld_fk_id_attachment ASC),
	constraint fld_fk_id_job
		foreign key (fld_fk_id_job)
			references ticketdb.tbl_job (fld_id_job),
	constraint fld_fk_id_attachment
		foreign key (fld_fk_id_attachment)
			references ticketdb.tbl_attachment (fld_id_attachment));


create table if not exists ticketdb.tbl_job(
	fld_id_job int(11) auto_increment not null,
    fld_start_date date,
	fld_finish_date date,
    fld_title varchar(60),
	fld_description text,
    fld_location varchar(45),
    fld_fk_id_client int(11) not null,
    fld_fk_id_job_type int(11) not null,
    fld_fk_id_status int(11) not null,
    fld_fk_id_agent int(11) not null,
	fld_fk_id_priority int(11) not null,
    primary key (fld_id_job),
		index fld_fk_id_status_idx (fld_fk_id_status ASC),
		index fld_fk_id_client_idx (fld_fk_id_client ASC),
		index fld_fk_id_job_type_idx (fld_fk_id_job_type ASC),
        index fld_fk_id_agent_idx (fld_fk_id_agent ASC),
		index fld_fk_id_priority_idx (fld_fk_id_priority ASC),
	constraint fld_fk_id_priority
		foreign key (fld_fk_id_priority)
			references ticketdb.tbl_priority (fld_id_priority),
	constraint fld_fk_id_agent
		foreign key (fld_fk_id_agent)
			references ticketdb.tbl_agent (fld_id_agent),
	constraint fld_fk_id_status
		foreign key (fld_fk_id_status)
			references ticketdb.tbl_status (fld_id_status),
		constraint fld_fk_id_client
			foreign key (fld_fk_id_client)
				references ticketdb.tbl_client (fld_id_client)
                    ON DELETE NO ACTION
					ON UPDATE NO ACTION,
        constraint fld_fk_id_job_type
			foreign key (fld_fk_id_job_type)
				references ticketdb.tbl_job_type (fld_id_job_type)
                    ON DELETE NO ACTION
					ON UPDATE NO ACTION);
        

create table if not exists ticketdb.tbl_agent_bridge(
	fld_id_agent_bridge int(11) auto_increment not null,
	fld_fk_id_agent int(11) not null,
    fld_fk_id_job int(11) not null,
    primary key (fld_id_agent_bridge),
		index fld_fk_id_agent_idx (fld_fk_id_agent ASC),
        index fld_fk_job_idx (fld_fk_id_job ASC),
	constraint fld_fk_id_agent1
		foreign key (fld_fk_id_agent)
			references ticketdb.tbl_agent (fld_id_agent),
	constraint fld_fk_id_job1
		foreign key (fld_fk_id_job)
			references ticketdb.tbl_job (fld_id_job));
    
    
create table if not exists ticketdb.tbl_note(
	fld_id_note int(11) auto_increment not null,
	fld_content text not null,
    fld_fk_id_agent_note int(11) not null,
    fld_fk_id_job_note int(11) not null,
    primary key (fld_id_note),
		index fld_fk_id_agent_note_idx (fld_fk_id_agent_note ASC),
		index fld_fk_id_job_note_idx (fld_fk_id_job_note ASC),
	constraint fld_fk_id_agent_note
		foreign key (fld_fk_id_agent_note)
			references ticketdb.tbl_agent (fld_id_agent),
	constraint fld_fk_id_job_note
		foreign key (fld_fk_id_job_note)
			references ticketdb.tbl_job (fld_id_job));
        
create table if not exists ticketdb.tbl_note_attachment_bridge(
	fld_id_note_attachment_bridge int(11) auto_increment not null,
    fld_fk_id_note int(11) not null,
    fld_fk_id_attachment int(11) not null,
    primary key (fld_id_note_attachment_bridge),
		index fld_fk_id_note_idx (fld_fk_id_note ASC),
        index fld_fk_id_attachment_idx (fld_fk_id_attachment ASC),
	constraint fld_fk_id_note
		foreign key (fld_fk_id_note)
			references ticketdb.tbl_note (fld_id_note),
	constraint fld_fk_id_attachment1
		foreign key (fld_fk_id_attachment)
			references ticketdb.tbl_attachment (fld_id_attachment));
        
        
        
	