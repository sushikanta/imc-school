create table addresses
(
  id            serial not null
    constraint address_pkey
    primary key,
  obj_table_ref varchar(255),
  object_id     integer,
  is_default    boolean default false,
  address1      varchar(255),
  address2      varchar(255),
  zipcode       integer,
  city          varchar(49),
  state         varchar(50),
  country_id    integer,
  contact1      varchar(20),
  contact2      varchar(20),
  created_at    timestamp,
  updated_at    timestamp,
  user_id       integer
);

comment on table addresses
is 'address details of user';




ALTER TABLE public.businesses ADD business_name varchar(255) NULL
ALTER TABLE public.businesses ADD timezone_id int NULL
ALTER TABLE public.businesses ADD business_picture varchar(255) NULL
ALTER TABLE public.staffs ADD timezone_id int NULL
ALTER TABLE public.staffs ADD profile_picture varchar(255) NULL


ALTER TABLE public.addresses ADD type varchar(50) DEFAULT 'profile' NULL;



ALTER TABLE public.staffs ADD staff_details text NULL;



ALTER TABLE public.staffs ALTER COLUMN profile_picture TYPE text USING profile_picture::text;
ALTER TABLE public.businesses ALTER COLUMN business_picture TYPE text USING business_picture::text;


ALTER TABLE public.job_applications ALTER COLUMN status TYPE varchar(50) USING status::varchar(50);
ALTER TABLE public.businesses ADD business_detail text NULL;


ALTER TABLE public.job_titles ADD is_deleted boolean DEFAULT false NULL;
ALTER TABLE public.job_titles ADD created_at timestamp NULL;
ALTER TABLE public.job_titles ADD updated_at timestamp NULL;


ALTER TABLE public.skills ADD is_deleted boolean DEFAULT false NULL;
ALTER TABLE public.skills ADD created_at timestamp NULL;
ALTER TABLE public.skills ADD updated_at timestamp NULL;


ALTER TABLE public.job_categories ADD is_deleted boolean DEFAULT false  NULL;
ALTER TABLE public.job_categories ADD created_at timestamp NULL;
ALTER TABLE public.job_categories ADD updated_at timestamp NULL;



ALTER TABLE public.countries ADD is_deleted boolean DEFAULT false NULL;
ALTER TABLE public.timezones ADD is_deleted boolean DEFAULT false  NULL;



ALTER TABLE public.business_categories ADD is_deleted boolean DEFAULT false NULL;
ALTER TABLE public.business_categories ADD created_at timestamp NULL;
ALTER TABLE public.business_categories ADD updated_at timestamp NULL;


ALTER TABLE public.staffs ADD account_holder_name varchar(255) NULL;
ALTER TABLE public.staffs ADD bank_name varchar(255) NULL;
ALTER TABLE public.staffs ADD account_number varchar(255) NULL;
ALTER TABLE public.staffs ADD ifsc_code varchar(255) NULL;


ALTER TABLE public.users ALTER COLUMN is_deleted SET DEFAULT false ;
update users set is_deleted=false


ALTER TABLE public.sys_settings ALTER COLUMN published SET DEFAULT false;
ALTER TABLE public.staffs ALTER COLUMN is_online SET DEFAULT false;
update staffs set is_online=false
ALTER TABLE public.jobs ALTER COLUMN immediate_staffing SET DEFAULT false;
ALTER TABLE public.jobs ALTER COLUMN same_as_business_address SET DEFAULT false;

update jobs set immediate_staffing=false
update jobs set same_as_business_address=false


ALTER TABLE public.jobs ALTER COLUMN is_deleted SET DEFAULT false;
update jobs set is_deleted=false;

ALTER TABLE public.job_titles ALTER COLUMN published SET DEFAULT true;
ALTER TABLE public.job_categories ALTER COLUMN published SET DEFAULT true;
ALTER TABLE public.job_applications ALTER COLUMN is_deleted SET DEFAULT false ;

update job_applications set is_deleted=false

ALTER TABLE public.faqs ALTER COLUMN published SET DEFAULT true ;
ALTER TABLE public.faqs ALTER COLUMN display_client SET DEFAULT false ;
ALTER TABLE public.faqs ALTER COLUMN display_staff SET DEFAULT false ;
ALTER TABLE public.contact_us ALTER COLUMN subscribe_news SET DEFAULT false ;





ALTER TABLE public.users ADD last_login timestamp NULL;


CREATE TABLE public.log_login
(
    id serial PRIMARY KEY,
    user_id int,
    login_time timestamp,
    ip_addpress varchar(50),
    user_agent varchar(255),
    other_data text
);
COMMENT ON TABLE public.log_login IS 'user logged in log history';



ALTER TABLE public.job_applications ALTER COLUMN updated_at TYPE timestamp USING updated_at::timestamp;

ALTER TABLE public.businesses ADD strip_data json NULL;
ALTER TABLE public.addon_cards ADD strip_card_data json NULL;
ALTER TABLE public.staff_job_skills ADD staff_user_id int NULL;
ALTER TABLE public.jobs ADD address_id int NULL;
ALTER TABLE public.staff_job_skills ADD job_title_id int NULL;






create table wallet_operation
(
  id                 serial not null
    constraint wallet_pkey
    primary key,
  user_id            integer,
  job_id             integer,
  wallet_amount      double precision default 0,
  plus_minus_amount  double precision default 0,
  final_amount       double precision default 0,
  plus_minus_type    varchar(50),
  operation_date     timestamp,
  description        text,
  trancation_details text
);

comment on column wallet_operation.plus_minus_type
is 'plus or minus';



ALTER TABLE public.users ADD wallet_amount double precision DEFAULT 0 NULL;


create table checkin_checkout
(
  id              serial not null
    constraint checkin_checkout_pkey
    primary key,
  job_id          integer,
  user_id         integer,
  checkin_time    timestamp,
  checkin_status  varchar(50) default 'pending' :: character varying,
  checkout_time   timestamp,
  checkout_status varchar(40) default 'pending' :: character varying,
  total_work_time time,
  comments        text
);


ALTER TABLE public.checkin_checkout ADD checkin_client_update timestamp NULL;
ALTER TABLE public.checkin_checkout ADD checkout_client_update timestamp NULL;


ALTER TABLE public.checkin_checkout ADD checkout_comment text NULL;
ALTER TABLE public.checkin_checkout RENAME COLUMN comments TO checkin_comments;


ALTER TABLE public.checkin_checkout RENAME COLUMN checkin_comments TO checkin_client_comments;
ALTER TABLE public.checkin_checkout RENAME COLUMN checkout_comment TO checkout_client_comment;



CREATE TABLE public.business_payment
(
    id serial PRIMARY KEY,
    user_id int,
    payment_amount double precision DEFAULT 0,
    payment_time timestamp,
    payment_status varchar(50) DEFAULT 'pending',
    payment_method varchar(255),
    transaction_id varchar(255),
    payment_card varchar(255),
    payment_gateway_response text,
    created_at timestamp
);

## 25march2019
ALTER TABLE public.checkin_checkout ALTER COLUMN checkout_status DROP DEFAULT;
## 26march2019

ALTER TABLE public.checkin_checkout ADD checkin_lat varchar(50) NULL;
ALTER TABLE public.checkin_checkout ADD checkin_lng varchar(50) NULL;
ALTER TABLE public.checkin_checkout ADD checkout_lat varchar(50) NULL;
ALTER TABLE public.checkin_checkout ADD checkout_lng varchar(50) NULL;


create table bank_accounts
(
  id serial not null
    constraint bank_accounts_pkey
    primary key,
  user_id             integer,
  account_holder_name varchar(50),
  account_holder_type varchar(50),
  routing_number      varchar(50),
  account_number      varchar(50),
  stripe_response     json,
  updated_at          timestamp,
  created_at          timestamp,
  is_default          boolean,
  country             varchar(50),
  currency            varchar(50)
);;

ALTER TABLE public.staffs ADD stripe_response json NULL;


## 27march2019

ALTER TABLE public.jobs ADD geometry_location varchar NULL;
CREATE EXTENSION postgis;


## 29march2019

ALTER TABLE public.job_titles ADD hourly_rate double precision DEFAULT 100 NULL;


ALTER TABLE public.checkin_checkout ADD checkin_type varchar(50) DEFAULT 'self' NULL;
ALTER TABLE public.checkin_checkout ADD checkout_type varchar(50) DEFAULT 'self' NULL;
ALTER TABLE public.wallet_operation RENAME COLUMN trancation_details TO transation_details;
ALTER TABLE public.users ADD is_online boolean DEFAULT false NULL;
ALTER TABLE public.business_payment ADD payment_currency varchar(20) NULL;

## 2Apr2019
ALTER TABLE public.ratings ADD review text NULL;
ALTER TABLE public.ratings ALTER COLUMN rated_by TYPE integer USING rated_by::integer;
ALTER TABLE public.ratings ALTER COLUMN created_at TYPE timestamp USING created_at::timestamp;


ALTER TABLE public.jobs ADD vacencies integer;