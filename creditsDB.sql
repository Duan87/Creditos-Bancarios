drop database if exists creditsDB;
create database creditsDB;
use creditsDB;

set @PRUEBAS = 'test';

create table Cat_User_Types(
pk_type_id int not null primary key auto_increment,
type_description varchar (64) not null);

create table Users(
pk_user_id int primary key auto_increment,
fk_user_type int not null,
first_name varchar (64) not null,
first_surname varchar (64) not null,
second_surname varchar (64) not null,
house_number int (5) not null,
street varchar (64) not null, # en estos rubros tengo dudas se podria quitar el "not null"  por ser datos que no todos tienen?
telephone int (8) not null,       
email nvarchar (128) not null,      
pswd nvarchar (32) not null,
salt nvarchar(16) not null default 'salt',
foreign key (fk_user_type) references Cat_User_Types(pk_type_id));  


create table Customers(
pk_customer_id int not null primary key auto_increment,
fk_user_id int not null,   
rfc varchar (13) not null,
curp varchar (18) not null,
company varchar (64) not null,
job varchar (64) not null,
salary int,
foreign key (fk_user_id) references Users(pk_user_id));

create table Cat_Credit_Types(
pk_credit_type_id int not null primary key auto_increment, 
credit_name varchar (64) not null,
credit_term int(2) not null,
credit_rate int(2) not null,
credit_fixed_amount int(5) default null);

create table Cat_Request_Status(
pk_status_id int not null primary key auto_increment,
status_description varchar (64) not null);


create table Requests(
pk_request_id int not null primary key auto_increment,
fk_customer int not null,
fk_credit_type int not null,
amount int(7) default null,
request_date datetime not null default current_timestamp(),
recons_count int(1) not null default 0,
fk_request_status int not null default 6, #Default 'investigación'
foreign key (fk_credit_type) references Cat_Credit_Types (pk_credit_type_id),
foreign key (fk_customer) references Customers(pk_customer_id),
foreign key (fk_request_status) references Cat_Request_Status(pk_status_id));


create table Customer_References(
pk_reference_id int not null primary key auto_increment,
fk_referenced_request int not null,
reference_name varchar (64) not null,
first_surname varchar (64) not null,
second_surname varchar (64) not null,
telephone nvarchar (8) not null,
timeMeeting int (2) not null,
investigation_remark nvarchar(500) default null,
foreign key (fk_referenced_request) references Requests(pk_request_id) on delete cascade);

create table Requests_Record(
pk_record_id int not null primary key auto_increment,
fk_request int not null,
fk_saved_status int not null,
date_stamp datetime not null,
foreign key (fk_request)  references Requests(pk_request_id) on delete cascade,
foreign key (fk_saved_status) references Cat_Request_Status(pk_status_id));



create table Bureau_Reasons(
pk_reason_id int primary key not null auto_increment,
reason nvarchar(64) not null);

CREATE TABLE Bureau (
    pk_bureau_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	fk_customer int not null,
    fk_reason INT NOT NULL,
    FOREIGN KEY (fk_reason) REFERENCES Bureau_Reasons (pk_reason_id),
    foreign key (fk_customer) references Customers(pk_customer_id)
);

#------------------------------------------------------------------
#								VIEWS

create view vw_customers as
select
	Customers.pk_customer_id as id,concat(first_name,' ',first_surname,' ',second_surname) as full_name,
    Users.street,Users.house_number,Users.telephone,
	email as mail,Customers.rfc as RFC,Customers.curp as CURP,Customers.company,Customers.job,Customers.salary
from Users inner join Customers on Customers.fk_user_id = pk_user_id where fk_user_type = 1 ;

create view vw_employees as
select 
	pk_user_id as id,Cat_User_Types.type_description as employee_type,
    concat(first_name,' ',first_surname,' ',second_surname) as full_name,
    email as mail
from Users inner join Cat_User_Types on Cat_User_Types.pk_type_id = fk_user_type where fk_user_type != 1;

create view vw_cat_credits as
select 
	pk_credit_type_id as id,credit_name, concat(credit_term,' anios') as term, 
    concat(credit_rate,'%') as rate,(select ifnull(credit_fixed_amount,'No aplica')) as fixed_amount
from Cat_Credit_Types;


create view vw_credits as
select
	pk_request_id as id,vw_customers.id as customer_id,vw_customers.full_name as customer,vw_customers.mail,
    vw_customers.street,vw_customers.house_number,vw_customers.telephone,
    vw_customers.rfc,vw_customers.curp,vw_customers.job,vw_customers.company,vw_customers.salary,
	vw_cat_credits.credit_name,vw_cat_credits.term,vw_cat_credits.rate,vw_cat_credits.fixed_amount,
    (select ifnull(amount,'No aplica')) as amount,request_date as date_stamp,Cat_Request_Status.status_description as state
from Requests inner join vw_customers on vw_customers.id = fk_customer
inner join vw_cat_credits on vw_cat_credits.id = fk_credit_type
inner join Cat_Request_Status on Cat_Request_Status.pk_status_id = fk_request_status;


create view vw_notifications as
select
	pk_record_id as id,Requests.pk_request_id as request,Requests.fk_customer as customer,
    Cat_Request_Status.status_description as state,date_stamp
from Requests_Record inner join Requests on fk_request = Requests.pk_request_id 
inner join Cat_Request_Status on fk_saved_status = Cat_Request_Status.pk_status_id order by id desc;

#------------------------------------------------------------------
#								TRIGGERS

DELIMITER **
CREATE TRIGGER tr_UUID BEFORE INSERT ON Users
FOR EACH ROW 
BEGIN 
	SET NEW.salt = LEFT(UUID(),16);
    SET NEW.pswd = MD5(concat(NEW.salt,NEW.pswd));
END; **
DELIMITER ;

DELIMITER **
CREATE TRIGGER tr_regist_new_credit AFTER INSERT ON Requests
FOR EACH ROW 
BEGIN 
	insert into Requests_Record(fk_request,fk_saved_status,date_stamp) values
    (NEW.pk_request_id,GET_REQUEST_STATUS_ID('Solicitado'),current_timestamp());
END; **
DELIMITER ;

drop trigger if exists tr_generate_notification;
delimiter **
create trigger tr_generate_notification after update on Requests
for each row 
begin
	declare new_status_name nvarchar(64);
	if(OLD.fk_request_status <> NEW.fk_request_status) then
		set new_status_name = ifnull(GET_REQUEST_STATUS_NAME(NEW.fk_request_status),'Invalido');
        if new_status_name != 'Invalido' then
			#set @PRUEBAS = new_status_name;
			insert into Requests_Record (fk_request,fk_saved_status,date_stamp) values
			(NEW.pk_request_id,NEW.fk_request_status,current_timestamp());
		end if;
    end if;
end; **
delimiter ;


#------------------------------------------------------------------
#								STORED PROCEDURES

/*
	nombre: sp_get_credits
    tipo: stored procedure
    parametros:
		customer_id -> int
	retorno
		result	-> int
        message -> nvarchar(128)
        id -> int 
        customer_id -> int 
        customer -> nvarchar 
        mail -> nvarchar 
        street 	-> nvarchar
        house_number -> int 
        telephone	-> int
        rfc	-> nvarchar
        curp -> nvarchar
        job	-> nvarchar
        company	-> nvarchar
        salary	-> int
        credit_name -> nvarchar
        term	-> nvarchar
        rate	-> nvarchar
        fixed_amount	-> int | 'No aplica'
        amount		-> int | 'No aplica'
        date_stamp	->	nvarchar
        state	-> nvarchar
	Regresa todos los registros de solicitudes de crédito asociados
    al customer_id.
    Si hubo un error al realizar la búsqueda result to            <label for="" class="content__header__user__col__lbl-user"><?php echo $userName; ?></label>
            <button onclick="logOutUser();" id="btnLogOff"class="content__header__user__col__btn btn btn-primary" type="button" name="button">Cerrar sesión</button>
          </aside>


        </div>
mará el valor 0, de lo
    contrario será 1 o bien -1 en caso de no tener registrados créditos del cliente
    aún . Si ocurre un error, message contendrá una descripción del mismo.
*/
drop procedure if exists sp_get_credits;
delimiter **
create procedure sp_get_credits(in customer_id int)
begin
	declare is_valid int(1);
    declare msg nvarchar(128);
    declare has_credits int(1);
    
    set is_valid = 0;
    if USER_EXISTS(customer_id) then
		if IS_CUSTOMER(customer_id) then
			set is_valid = -1;
			set has_credits = (select count(id) from vw_credits where vw_credits.customer_id = customer_id );							
            if has_credits > 0 then
				set is_valid = 1;
				select is_valid as result,msg as message, vw_credits.id,vw_credits.credit_name as credit,
                vw_credits.term,vw_credits.rate,vw_credits.fixed_amount,vw_credits.amount,vw_credits.state
                from vw_credits where vw_credits.customer_id = customer_id;
            else
				set msg = 'No tienes solicitudes de credito';
            end if;
        else
			set msg = 'Inconsistencias en el tipo de usuario';
        end if;
    else
		set msg = 'Inconsistencias al buscar registros del cliente';
    end if;
    if is_valid != 1 then
		select is_valid as result, msg as message;
    end if;
end; **
delimiter ;


drop procedure if exists sp_search_requests;
delimiter **
create procedure sp_search_requests(in userEmail nvarchar(128), in userName nvarchar(64))
begin
	declare is_valid int(1);
    declare msg nvarchar(128);
    declare count int;
    set count = (select count(*) from requests inner join users on fk_customer = users.pk_user_id where email = userEmail and first_name = userName);
    if count > 0 then
		set is_valid = 1;
        set msg ='Creditos encontrados';
		select is_valid as result,msg as message, vw_credits.* from vw_credits where state = 'Autorizacion' or state = 'Pendiente de cancelacion' and mail = userEmail;
	else
		set is_valid = -1;
        set msg = 'Sin resultados encontrados';
        select is_valid as result, msg as message;
    end if;
end; **
delimiter ;

drop procedure if exists sp_get_reconsiderations_pending;
delimiter **
create procedure sp_get_reconsiderations_pending(in employee_id int)
begin
declare is_valid int(1);
    declare msg nvarchar(128);
    declare counter int;
    set is_valid = 0;
    if USER_EXISTS(employee_id) then
		if IS_CUSTOMER(employee_id) = 0 then
			set is_valid = 1;
            set msg = 'Creditos pendientes';
			case
				when GET_EMPLOYEE_TYPE_NAME(employee_id) = 'Gerente' then
					set counter = (select count(id) from vw_credits where state ='Reconsideracion' or state='Renovado');
					if counter != 0 then
						select is_valid as result,msg as message,vw_credits.* from vw_credits where state='Reconsideracion' or state='Renovado';
                    else
						set msg = 'No hay solicitudes pendientes';
                        select -1 as result, msg as message;
                    end if;
                else
					set is_valid = 0;
					set msg = 'Inconsistencias con el tipo de empleado';
            end case;
        else
			set msg = 'Inconsistencias con el tipo de usuario';
        end if;
    else
		set msg = 'Inconsistencias al buscar registros del empleado';
    end if;
    if is_valid != 1 then
		select is_valid as result, msg as message;
    end if;
end; **
delimiter ;

/*
nombre: sp_get_credits
    tipo: stored procedure
    parametros:
		employee_id -> int
	retorno
		result	-> int
        message -> nvarchar(128)
        id -> int 
        customer_id -> int 
        customer -> nvarchar 
        mail -> nvarchar 
        street 	-> nvarchar
        house_number -> int 
        telephone	-> int
        rfc	-> nvarchar
        curp -> nvarchar
        job	-> nvarchar
        company	-> nvarchar
        salary	-> int
        credit_name -> nvarchar
        term	-> nvarchar
        rate	-> nvarchar
        fixed_amount	-> int | 'No aplica'
        amount		-> int | 'No aplica'
        date_stamp	->	nvarchar
        state	-> nvarchar
	Regresa todos los registros de solicitudes de crédito asociados
    a la función del empleado en función de su id.
    Si es un gerente quien solicita ver sus solicitudes de crédito pendientes,
    entonces se regresan todas las solicitudes que hay pendientes para la autorización
    por parte del gerente. Funciona de manera análoga con los otros dos tipos de empleado
    
    Si hubo un error al realizar la búsqueda result tomará el valor 0, de lo
    contrario será 1. Si ocurre un error, message contendrá una descripción del mismo.
*/
drop procedure if exists sp_get_pending_credits;
delimiter **
create procedure sp_get_pending_credits(in employee_id int)
begin
	declare is_valid int(1);
    declare msg nvarchar(128);
    declare counter int;
    set is_valid = 0;
    if USER_EXISTS(employee_id) then
		if IS_CUSTOMER(employee_id) = 0 then
			set is_valid = 1;
            set msg = 'Creditos pendientes';
			case
				when GET_EMPLOYEE_TYPE_NAME(employee_id) = 'Gerente' then
					set counter = (select count(id) from vw_credits where state = 'Autorizacion' or state ='Pendiente de cancelacion');
					if counter != 0 then
						select is_valid as result,msg as message,vw_credits.* from vw_credits where state = 'Autorizacion' or state ='Pendiente de cancelacion';
                    else
						set msg = 'No hay creditos pendientes';
                        select -1 as result, msg as message;
                    end if;
                when GET_EMPLOYEE_TYPE_NAME(employee_id) = 'Dictaminador' then
					set counter = (select count(id) from vw_credits where state = 'Dictaminacion');
                    if counter != 0 then
						select is_valid as result,msg as message,vw_credits.* from vw_credits where state = 'Dictaminacion';
                    else
						set msg = 'No hay creditos pendientes';
                        select -1 as result, msg as message;
                    end if;
                    
                when GET_EMPLOYEE_TYPE_NAME(employee_id) = 'Administrativo' then
					set counter = (select count(id) from vw_credits where state = 'Investigacion');
                    if counter != 0 then
						select is_valid as result,msg as message,vw_credits.* from vw_credits where state = 'Investigacion';
                    else
						set msg = 'No hay creditos pendientes';
                        select -1 as result, msg as message;
                    end if;
					
                else
					set is_valid = 0;
					set msg = 'Inconsistencias con el tipo de empleado';
            end case;
        else
			set msg = 'Inconsistencias con el tipo de usuario';
        end if;
    else
		set msg = 'Inconsistencias al buscar registros del empleado';
    end if;
    if is_valid != 1 then
		select is_valid as result, msg as message;
    end if;
end; **
delimiter ;

/*
	nombre: sp_log_in
    tipo: stored procedure
    parametros:
		user_email -> nvarchar(128)
		user_pswd -> nvarchar(32)
	retorno
		id	-> int
        message -> nvarchar(128)
*/
#Recibe un correo y una contraseña encriptada con MD5 y busca el registro
#asociado a esos datos haciendo uso de la "salt" .
drop procedure if exists sp_log_in;
delimiter **
create procedure sp_log_in(
in user_mail nvarchar(128),in user_pswd nvarchar(32))
begin
	declare result_id int;
    declare msg nvarchar(128);
    
	set result_id = (select ifnull(
		(select pk_user_id from Users 
		 where Users.pswd = MD5(concat(Users.salt,user_pswd)) and Users.email = user_mail
         ),-1));
	if result_id = -1 then
		set msg = 'Usuario y/o clave incorrectos';
        select result_id as id,msg as message;
	else
		set msg = 'Bienvenido';
        select result_id as id,msg as message,first_name as user_name, fk_user_type as user_type from Users where pk_user_id = result_id;
	end if;
end; **
delimiter ;

/*
	nombre: sp_request_reconsideration
    tipo: stored procedure
    parametros:
		request_id -> int
		user_id -> int
	retorno
		result	-> int
        message -> nvarchar(128)	
	Solicita una reconsideración sobre la solicitud asociada al
    request_id validando que dicha solicitud sea del usuario
    asociado al user_id así como verificando que no haya más de 2
    reconsideraciones solicitadas anteriormente y que la solicitud
    no se encuentre en proceso de reconsideración actualmente.
    
    result es 1 si todo salió bien 0 si hubo algún error.
    
*/
drop procedure if exists sp_request_reconsideration;
delimiter **
create procedure sp_request_reconsideration(
in request_id int, in user_id int)
begin
	declare msg nvarchar(128);
    declare recons_counter int(1);
    declare valid_owner int(1);
    declare result int(1);
    
    set result = 0;
    set valid_owner = (select fk_customer = user_id from Requests where pk_request_id = request_id);
    if valid_owner then
		set recons_counter = ifnull((select count(pk_record_id) from Requests_Record where fk_saved_status = GET_REQUEST_STATUS_ID('Reconsideracion') and fk_request = request_id),-1);
		if recons_counter != -1 then
			if recons_counter < 2 then
				set recons_counter = ifnull((select fk_request_status from Requests where pk_request_id = request_id),0);
				if recons_counter <> GET_REQUEST_STATUS_ID('Reconsideracion') then
					update Requests set fk_request_status = GET_REQUEST_STATUS_ID('Reconsideracion') where
					pk_request_id = request_id;
                    set result = 1;
					set msg = 'Su solicitud ha entrado en proceso de reconsideracion';
				else
					set msg = 'La solicitud ya se encuentra en proceso de reconsideracion';
				end if;
			else
				set msg = 'La solicitud agota la cantidad de reconsideraciones permitidas';
			end if;
		else
			set msg = 'Fallo al obtener registro de estatus';
		end if;
	else
		set msg = 'Inconsistencias al solicitar reconsideracion';
    end if;
    select result, msg as message;
end; **
delimiter ;

drop procedure if exists sp_request_cancellation;
delimiter **
create procedure sp_request_cancellation(
in request_id int, in customer_id int)
begin
	declare msg nvarchar(128);
    declare valid_owner int(1);
    declare recons_counter int(1);
    declare result int(2);
    
    set result = 0;
    set valid_owner = (select fk_customer = customer_id from Requests where pk_request_id = request_id);
    if valid_owner then
        set recons_counter = ifnull((select fk_request_status from Requests where pk_request_id = request_id),0);
        if recons_counter = GET_REQUEST_STATUS_ID('Adeudado') then
			set msg = 'La solicitud tiene adeudos. No puede ser cancelada';
		else
			if recons_counter <> GET_REQUEST_STATUS_ID('Pendiente de cancelacion') then
				update Requests set fk_request_status = GET_REQUEST_STATUS_ID('Pendiente de cancelacion') where
					pk_request_id = request_id;
				set result = 1;
				set msg = 'Su solicitud de cancelacion ha sido enviada';
			else
				set msg = 'La solicitud ya se encuentra en proceso de cancelacion';
			end if;
        end if;
	else
		set msg = 'Inconsistencias al solicitar cancelación';
    end if;
    select result, msg as message;
end; **
delimiter ;

drop procedure if exists sp_approve_cancellation;
delimiter **
create procedure sp_approve_cancellation(in employee_id int,in pswd nvarchar(32),in request_id int)
begin
	declare msg nvarchar(128);
    declare is_valid int(1);
    declare result int(1);
    
    set result = 0;
    set is_valid = (select count(id) from vw_credits where id = request_id);
    if is_valid then
		if USER_EXISTS(employee_id) and IS_CUSTOMER(employee_id) = 0 then
			if GET_EMPLOYEE_TYPE_NAME(employee_id) = 'Gerente' then
				set is_valid = (select MD5(CONCAT(Users.salt,pswd)) = Users.pswd from Users where pk_user_id = employee_id);
				if is_valid then
					update Requests set fk_request_status = GET_REQUEST_STATUS_ID('Cancelacion') where pk_request_id = request_id;
					set result = 1;
                    set msg = 'Solicitud de cancelacion aprobada correctamente';
                else
					set msg='Autorizacion denegada, clave incorrecta';
				end if;
			else
				set msg= 'Usuario con permisos insuficientes';
			end if;
		else
			set msg= 'Inconsistencias con el registro y tipo de usuario';
		end if;
	else
		set msg = 'Solicitud no encontrada';
    end if;
    select result,msg as message;
end; **
delimiter ;


/*
	nombre: sp_request_credit
    tipo: stored procedure
    parametros:
		user_id -> int
		credit_type -> int
        amount ->	int(7)
        ref_1_name -> varchar
        rf_1_fst_surname varchar
        rf_1_snd_surname varchar
        ref_1_phone nvarchar
        ref_1_time nvarchar
        rf_1_remark nvarchar
        ref_2_name -> varchar
        rf_2_fst_surname varchar
        rf_2_snd_surname varchar
        ref_2_phone nvarchar
        ref_2_time nvarchar
        rf_2_remark nvarchar
        
	retorno
		result	-> int
        message -> nvarchar(128)	
	Agrega una solicitud de crédito a los registros
    validando que cumpla con las restricciones establecidas.
    
    result es 1 si todo salió bien 0 si hubo algún error.
    
*/

drop procedure if exists sp_request_credit;
delimiter **
create procedure sp_request_credit(
in user_id int,in credit_type int,in amount int(7),in ref_1_name varchar(64),
in ref_1_fst_surname varchar(64),in ref_1_snd_surname varchar(64),in ref_1_phone nvarchar(8),in ref_1_time int(2),
in ref_2_name nvarchar(64),in ref_2_fst_surname varchar(64),in ref_2_snd_surname varchar(64),in ref_2_phone nvarchar(8),in ref_2_time int(2))
begin
	declare msg nvarchar(128);
    declare is_valid_credit int(1);
    declare new_request_id int;
    
    call sp_validate_credit_request(user_id,credit_type,amount,msg,is_valid_credit);
    if is_valid_credit then 
		insert into Requests(fk_customer,fk_credit_type,amount) values 
        (user_id,credit_type,amount);
        
        set new_request_id = (select max(pk_request_id) from Requests);
       # set new_request_id = (select pk_request_id from Requests where fk_customer = user_id and fk_credit_type = credit_type and Requests.amount = amount);
        
        insert into Customer_References(fk_referenced_request,reference_name,first_surname,second_surname,telephone,timeMeeting) values
        (new_request_id,ref_1_name,ref_1_fst_surname,ref_1_snd_surname,ref_1_phone,ref_1_time),
        (new_request_id,ref_2_name,ref_2_fst_surname,ref_2_snd_surname,ref_2_phone,ref_2_time);
        set msg = 'Solicitud exitosa. Su peticion ya entro en proceso';
	end if;
    select is_valid_credit as result, msg as message;
end; **
delimiter ;


/*
	Valida una solicitud de crédito verificando 
    que el usuario que la solicita exista, que la
    solicitud no esté ya en proceso y que el monto proporcionado
    sea compatible con el monto correspondiente al tipo de crédito solicitado
    
    Retorna 1 si es válida la solicitud, 0 si no.
*/
drop procedure if exists sp_validate_credit_request;
delimiter **
create procedure sp_validate_credit_request(
in user_id int,in credit_type int,in amount int(7),out msg nvarchar(128),out is_valid int(1))
begin
    declare duplicated_request int(1);
    
    set is_valid = 0;
    
    if IS_NOT_IN_BUREAU(user_id) then
		if USER_EXISTS(user_id) then
			if IS_VALID_CREDIT_TYPE(credit_type) then
				if IS_VALID_CREDIT_AMOUNT(credit_type,amount) then
					set duplicated_request = (select count(pk_request_id) 
								from Requests where fk_customer = user_id and fk_credit_type = credit_type);
					if duplicated_request = 0 then
						set is_valid = 1;
					else
						set msg = 'Ya hay una solicitud en proceso';
					end if;
				else
					set msg = 'Tipo de credito incompatible con el monto proporcionado';
				end if;
			else
				set msg = 'Tipo de credito no valido.';
			end if;
		else
			set msg = 'Inconsistencias al registrar credito';
		end if;
	else
		set msg = 'Solicitud rechazada automaticamente. Presencia en buro.';
    end if;
end; **
delimiter ;

/*
	Dictamina una solicitud de crédito si el verdicto es verdadero (1)
*/
drop procedure if exists sp_dictaminate;
delimiter **
create procedure sp_dictaminate(in request_id int, in verdict int(1))
begin
	declare result int(1);
    declare msg nvarchar(128);
    
    set result = ifnull((select count(id) from vw_credits where id = request_id),0);
	if result then #existe request
		if verdict then
			update Requests set fk_request_status = GET_REQUEST_STATUS_ID('Autorizacion') where pk_request_id = request_id;
        else
			update Requests set fk_request_status = GET_REQUEST_STATUS_ID('Rechazo') where pk_request_id = request_id;
        end if;
        set msg='Veredicto guardado exitosamente';
    else
		set msg = 'Inconsistencias con el identificador de la solicitud';
    end if;
    select result, msg as message;
end; **
delimiter ;
#call sp_dictaminate(1,1);
#update Requests set fk_request_status = 6 where pk_request_id = 1;
#select * from vw_credits;

drop procedure if exists sp_renovate;
delimiter **
create procedure sp_renovate(in request_id int)
begin
	declare result int(1);
    declare msg nvarchar(128);
    declare credit nvarchar(128);
        set result = ifnull((select count(id) from vw_credits where id = request_id),0);
	if result then #existe request
			update Requests set fk_request_status = GET_REQUEST_STATUS_ID('Renovado') where pk_request_id = request_id;
            #set credit = (select credit_name from vw_credits where id = request_id);
			set msg='Solicitud de renovacion de credito enviada exitosamente';
    else
		set msg = 'Inconsistencias con el identificador de la solicitud';
    end if;
    select result, msg as message;
end; **
delimiter ;
/*
	Lleva a cabo la aprobación de un crédito verificando que el empleado
    haya ingresado una contraseña consistente con su registro y que este registro
    sea de un empleado del tipo gerente.
    Regresa 1 si todo salió bien, 0 si no.
*/
drop procedure if exists sp_credit_authorization;
delimiter **
create procedure sp_credit_authorization(in employee_id int,in pswd nvarchar(32),in request_id int)
begin
	declare msg nvarchar(128);
    declare is_valid int(1);
    declare result int(1);
    
    set result = 0;
    set is_valid = (select count(id) from vw_credits where id = request_id);
    if is_valid then
		if USER_EXISTS(employee_id) and IS_CUSTOMER(employee_id) = 0 then
			if GET_EMPLOYEE_TYPE_NAME(employee_id) = 'Gerente' then
				set is_valid = (select MD5(CONCAT(Users.salt,pswd)) = Users.pswd from Users where pk_user_id = employee_id);
				if is_valid then
					update Requests set fk_request_status = GET_REQUEST_STATUS_ID('Aprobado') where pk_request_id = request_id;
					set result = 1;
                    set msg = 'Solicitud autorizada correctamente';
                else
					set msg='Autorizacion denegada, clave incorrecta';
				end if;
			else
				set msg= 'Usuario con permisos insuficientes';
			end if;
		else
			set msg= 'Inconsistencias con el registro y tipo de usuario';
		end if;
	else
		set msg = 'Solicitud no encontrada';
    end if;
    select result,msg as message;
end; **
delimiter ;

drop procedure if exists sp_approve_reconsideration;
delimiter **
create procedure sp_approve_reconsideration(in employee_id int,in pswd nvarchar(32),in empMail nvarchar(128),in request_id int)
begin
	declare msg nvarchar(128);
    declare is_valid int(1);
    declare result int(1);
    
    set result = 0;
    set is_valid = (select count(id) from vw_credits where id = request_id);
    if is_valid then
		if USER_EXISTS(employee_id) and IS_CUSTOMER(employee_id) = 0 then
			if GET_EMPLOYEE_TYPE_NAME(employee_id) = 'Gerente' then
				set is_valid = (select MD5(CONCAT(Users.salt,pswd)) = Users.pswd from Users where pk_user_id = employee_id and email = empMail);
				if is_valid then
					update Requests set fk_request_status = GET_REQUEST_STATUS_ID('Aprobado') where pk_request_id = request_id;
					set result = 1;
                    set msg = 'Solicitud aprobada correctamente';
                else
					set msg='Autorizacion denegada, email o clave de acceso incorrectos';
				end if;
			else
				set msg= 'Usuario con permisos insuficientes';
			end if;
		else
			set msg= 'Inconsistencias con el registro y tipo de usuario';
		end if;
	else
		set msg = 'Solicitud no encontrada';
    end if;
    select result,msg as message;
end; **
delimiter ;



/*
	Agrega el resultado de la investigación telefónica de una referencia.
*/
drop procedure if exists sp_set_reference_remark;
delimiter **
create procedure sp_set_reference_remark(in reference_id int,in remark nvarchar(500))
begin
	update Customer_References set investigation_remark = remark where pk_reference_id = reference_id;
end; **
delimiter ;


drop procedure if exists sp_get_customer_references;
delimiter **
create procedure sp_get_customer_references(in request_id int)
begin
	declare result int(1);
    declare msg nvarchar(128);
    
    set result = (select count(pk_reference_id) from Customer_References where fk_referenced_request = request_id);
	if result > 0 then
        select pk_reference_id as id,reference_name as 'name',first_surname,second_surname,
		telephone,timeMeeting,investigation_remark as remark from Customer_References where
		fk_referenced_request = request_id;
    else
		set msg ='No hay references asociadas a la solicitud';
		select result as noReferences, msg as message;
    end if;
end; **
delimiter ;


#------------------------------------------------------------------
#								FUNCTIONS

/*
	Retorna el ID asociado al request_status recibido buscando
    en la tabla Cat_Request_Status
    Regresa NULL si no hay registro asociado al request_status enviado.
*/
delimiter **
create function GET_REQUEST_STATUS_ID(status_name nvarchar(64)) returns int deterministic
begin
	return (select pk_status_id from Cat_Request_Status where status_description = status_name);
end;**
delimiter ;

#	Retorna el nombre de un estatus según su id
#	buscando en la tabla Cat_Request_Status.
#	Regresa NULL si no hay un registro asociado al status_id enviado.
delimiter **
create function GET_REQUEST_STATUS_NAME(status_id int) returns nvarchar(64) deterministic
begin
	declare status_name nvarchar(64);
    set status_name = (select status_description from Cat_Request_Status where pk_status_id = status_id);
    return (status_name);
end; **
delimiter ;

/*
	Regresa el nombre del crédito asociado a un tipo de crédito dado
*/
delimiter **
create function GET_CREDIT_TYPE_NAME(credit_type int) returns nvarchar(64) deterministic
begin
	declare type_name nvarchar(64);
    set type_name = (select  credit_name from Cat_Credit_Types where pk_credit_type_id = credit_type);
	return (type_name);
end; **
delimiter ;

/*
	Valida que el amount de un crédito sea compatible con el
    tipo de crédito escogido o si es incopatible debido a que el
    tipo de crédito tiene un monto fijo.
    Regresa 0 en caso de ser inválido y 1 en caso de ser valido.
*/
drop function if exists IS_VALID_CREDIT_AMOUNT;
delimiter **
create function IS_VALID_CREDIT_AMOUNT(credit_type int,amount int) returns int(1) deterministic
begin
	declare is_valid int(1);
    declare fixed_amount int(5);
	set fixed_amount = (select credit_fixed_amount from Cat_Credit_Types where pk_credit_type_id = credit_type);
	if ((fixed_amount IS NULL and amount IS NOT NULL) || (fixed_amount IS NOT NULL and amount IS NULL)) then
		set is_valid = 1;
	else
		set is_valid = 0;
	end if;
    return (is_valid);
end; **
delimiter ;

/*
	Verifica que el credi_type realmente exista en 
    la tabla Cat_Credit_Types.
    Regresa 0 en caso de no encontrar algún registro asociado
    al credit_type
*/
drop function if exists IS_VALID_CREDIT_TYPE;
delimiter **
create function IS_VALID_CREDIT_TYPE(credit_type int) returns int(1) deterministic
begin
	declare credit_exist int(1);
    set credit_exist = (select count(pk_credit_type_id) from Cat_Credit_Types where pk_credit_type_id = credit_type);
	return (credit_exist);
end; **
delimiter ;

/*
	Verifica si el cliente se encuentra en el buró 
    por crédito o fraude. 
    Regresa 1 si hay algún registro, 0 si no.
*/
drop function if exists IS_NOT_IN_BUREAU;
delimiter **
create function IS_NOT_IN_BUREAU(customer_id int)returns int(1) deterministic
begin
	declare is_in int(1);
    set is_in = (select count(pk_bureau_id) from Bureau where fk_customer = customer_id);
    if is_in = 0 then
		return 1;
    else
		return 0;
    end if;
end; **
delimiter ;

/*
	Verifica que exista un registro asociado al id de usuario
    proporcionado.
    Regresa 1 si existe, regresa 0 si no.
*/
drop function if exists USER_EXISTS;
delimiter **
create function USER_EXISTS(user_id int) returns int(1) deterministic
begin
	return (select count(pk_user_id) from Users where pk_user_id = user_id);
end; **
delimiter ;

/*
	Verifica si el id de usuario ingresado corresponde a un usuario
    de tipo cliente, si es así retorna 1 sino retorna 0.
*/
drop function if exists IS_CUSTOMER;
delimiter **
create function IS_CUSTOMER(user_id int) returns int(1) deterministic
begin
	declare customer int(1);
    set customer = ifnull((select 1 from Users inner join 
    Cat_User_Types on fk_user_type = Cat_User_Types.pk_type_id
    where pk_user_id = user_id and Cat_User_Types.type_description = 'Cliente'),0);
    return (customer);
end; **
delimiter ;

/*
	Regresa el tipo de empleado asociado a un id de empleado.
    Puede regresar null en caso de que el id ingresado no corresponda a algún tipo de
	empleado.
*/
drop function if exists GET_EMPLOYEE_TYPE_NAME;
delimiter **
create function GET_EMPLOYEE_TYPE_NAME(employee_id int) returns nvarchar(64) deterministic
begin
	return (select employee_type from vw_employees where id = employee_id);
end; **
delimiter ;


#------------------------------------------------------------------
#------------------------------------------------------------------
# Inserts

insert into Bureau_Reasons(reason) values 
('Fraude'),
('Adeudo');

insert into Cat_User_Types (type_description) values
('Cliente'),
('Gerente'),
('Dictaminador'),
('Administrativo');

insert into Cat_Request_Status (status_description) values
('Aprobado'),
('Rechazo'),
('Reconsideracion'),
('Cancelacion'),
('Dictaminacion'),
('Investigacion'),
('Renovado'),
('Autorizacion'),
('Solicitado'),
('Adeudado'),
('Pendiente de cancelacion');

insert into Cat_Credit_Types (credit_name,credit_term,credit_rate,credit_fixed_amount) values
('Tarjeta debito I',3,0,10000),
('Tarjeta debito II',4,0,20000),
('Tarjeta debito III',5,0,30000),
('Tarjeta credito I',3,0,10000),
('Tarjeta credito II',4,0,20000),
('Tarjeta credito III',5,0,30000),
('Hipoteca I',15,8,NULL),
('Hipoteca II',20,10,NULL),
('Hipoteca III',25,13,NULL),
('Auto I',1,5,NULL),
('Auto II',2,6,NULL),
('Auto III',3,7,NULL),
('Auto IV',4,8,NULL),
('Auto V',5,9,NULL);

#------------------------------------------------------------------
#Tests

insert into Users(fk_user_type,first_name,first_surname,second_surname,
house_number,street,telephone,email,pswd) values
(1,'Cliente1','Pat1','Mat1',10,'Calle',00000000,'cliente1@example.com',MD5('12345678')),
(1,'Cliente2','Pat2','Mat2',10,'Calle',00000000,'cliente2@example.com',MD5('12345678')),
(2,'Gerente1','Pat','Mat',10,'Calle',00000000,'gerente1@example.com',MD5('12345678')),
(3,'Dictaminador1','Pat','Mat',10,'Calle',00000000,'dictaminador1@example.com',MD5('12345678')),
(4,'Administrativo1','Pat','Mat',10,'Calle',00000000,'administrativo1@example.com',MD5('12345678'));

insert into Customers(fk_user_id,rfc,curp,company,job,salary) values
(1,'rfc1','curp1','enterprise','work',1000),
(2,'rfc2','curp2','enterprise','work',1000);

call sp_request_credit(1,1,NULL,'Saul1','pat','mat','12345678',3
,'Saul2','pat2','mat2','87654321',1);
call sp_request_credit(2,7,100,'Saul3','pat','mat','13578642',3,'Saul4','pat2','mat2','24687531',1);
insert into requests(fk_customer,fk_credit_type,amount,request_date,fk_request_status) values(1,4,NULL,'2020-12-26 14:00:00',10);



