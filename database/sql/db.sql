CREATE TABLE dbo.countries (
	country_code varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	country varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	CONSTRAINT PK_countries PRIMARY KEY (country_code)
)

CREATE TABLE dbo.auctions (
	id int IDENTITY(0,1) NOT NULL,
	title varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	description varchar(1000) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	start_price decimal(9,2) DEFAULT 0 NOT NULL,
	payment_instruction varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	duration tinyint NOT NULL DEFAULT 7,
	end_datetime datetime NOT NULL,
	city varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	country_code varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	user_id int NOT NULL,
	CONSTRAINT PK_auctions PRIMARY KEY (id),
	CONSTRAINT FK_countries_auctions FOREIGN KEY (country_code) REFERENCES dbo.countries(country_code),
	CONSTRAINT CHK_duration CHECK (
		duration IN (1, 3, 5, 7, 10)
	)
)

CREATE TABLE dbo.payment_methods (
	id int IDENTITY(0,1) NOT NULL,
	method varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	CONSTRAINT PK_paymentmethods PRIMARY KEY (id)
)

CREATE TABLE dbo.security_questions (
	id int IDENTITY(0,1) NOT NULL,
	question varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	CONSTRAINT PK_securityquestions PRIMARY KEY (id)
)

CREATE TABLE dbo.shipping_methods (
	id int IDENTITY(0,1) NOT NULL,
	method varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	CONSTRAINT PK_shippingmethods PRIMARY KEY (id)
)

CREATE TABLE dbo.auction_images (
	id int IDENTITY(0,1) NOT NULL,
	auction_id int NOT NULL,
	file_name varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	CONSTRAINT PK_auctionimages PRIMARY KEY (id),
	CONSTRAINT FK_auctions_auctionimages FOREIGN KEY (auction_id) REFERENCES dbo.auctions(id)
)

CREATE TABLE dbo.auction_payment_methods (
	id int IDENTITY(0,1) NOT NULL,
	auction_id int NOT NULL,
	payment_id int NOT NULL,
	CONSTRAINT PK_auctionpaymentmethods PRIMARY KEY (id),
	CONSTRAINT FK_auctions_auctionpaymentmethods FOREIGN KEY (auction_id) REFERENCES dbo.auctions(id),
	CONSTRAINT FK_paymentmethods_auctionpaymentmethods FOREIGN KEY (payment_id) REFERENCES dbo.payment_methods(id)
)

CREATE TABLE dbo.auction_shipping_methods (
	id int IDENTITY(0,1) NOT NULL,
	auction_id int NOT NULL,
	shipping_id int NOT NULL,
	price decimal(9,2) NULL,
	CONSTRAINT PK_auctionshippingmethods PRIMARY KEY (id),
	CONSTRAINT FK_auctions_auctionshippingmethods FOREIGN KEY (auction_id) REFERENCES dbo.auctions(id),
	CONSTRAINT FK_shippingmethods_auctionshippingmethods FOREIGN KEY (shipping_id) REFERENCES dbo.shipping_methods(id)
)

CREATE TABLE dbo.categories (
	id int IDENTITY(0,1) NOT NULL,
	name varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	parent_id int NULL,
	CONSTRAINT PK_category PRIMARY KEY (id),
	CONSTRAINT FK_categories_categories FOREIGN KEY (parent_id) REFERENCES dbo.categories(id)
)

CREATE TABLE dbo.users (
	id int IDENTITY(0,1) NOT NULL,
	username varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	email varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	password varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
    reset_token varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	first_name varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	last_name varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	address varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	postal_code varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	city varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	country_code varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	birth_date date NOT NULL,
	security_question_id int NOT NULL,
	security_answer varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	is_seller bit DEFAULT 0 NOT NULL,
	created_at datetime DEFAULT getdate() NOT NULL,
	CONSTRAINT PK_users PRIMARY KEY (id),
	CONSTRAINT FK_securityquestions_users FOREIGN KEY (security_question_id) REFERENCES dbo.security_questions(id),
	CONSTRAINT FK_countries_users FOREIGN KEY (country_code) REFERENCES dbo.countries(country_code),
	CONSTRAINT UC_users UNIQUE (email)
)

CREATE TABLE dbo.seller_verifications (
	user_id INT NOT NULL,
	method VARCHAR(20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	creditcard_number VARCHAR(50) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	bank_name VARCHAR(50) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	bank_account_number VARCHAR(50) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	CONSTRAINT PK_userid PRIMARY KEY (user_id),
	CONSTRAINT CHK_method CHECK (
		method IN ('Bank', 'Creditcard', 'Post')
	)
)

CREATE TABLE dbo.auction_categories (
	id int IDENTITY(0,1) NOT NULL,
	auction_id int NOT NULL,
	category_id int NOT NULL,
	CONSTRAINT PK_auctioncategories PRIMARY KEY (id),
	CONSTRAINT FK_auctions_auctioncategories FOREIGN KEY (auction_id) REFERENCES dbo.auctions(id),
	CONSTRAINT FK_categories_auctioncategories FOREIGN KEY (category_id) REFERENCES dbo.categories(id)
)

CREATE TABLE dbo.auction_hits (
	id int IDENTITY(0,1) NOT NULL,
	auction_id int NOT NULL,
	user_id int NULL,
	ip varchar(45) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	hit_datetime datetime DEFAULT getdate() NOT NULL,
	CONSTRAINT PK_auctionhits PRIMARY KEY (id),
	CONSTRAINT FK_users_auctionhits FOREIGN KEY (user_id) REFERENCES dbo.users(id)
)

CREATE TABLE dbo.bids (
	id int IDENTITY(0,1) NOT NULL,
	auction_id int NOT NULL,
	user_id int NOT NULL,
	amount decimal(9,2) NOT NULL,
	bid_datetime datetime DEFAULT getdate() NOT NULL,
	CONSTRAINT PK_bids PRIMARY KEY (id),
	CONSTRAINT FK_auctions_bids FOREIGN KEY (auction_id) REFERENCES dbo.auctions(id),
	CONSTRAINT FK_users_bids FOREIGN KEY (user_id) REFERENCES dbo.users(id)
)

CREATE TABLE dbo.phone_numbers (
	id int IDENTITY(0,1) NOT NULL,
	user_id int NOT NULL,
	phone_number varchar(15) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	CONSTRAINT PK_phonenumbers PRIMARY KEY (id),
	CONSTRAINT FK_users_phonenumbers FOREIGN KEY (user_id) REFERENCES dbo.users(id)
)

CREATE TABLE dbo.reviews (
	id int IDENTITY(0,1) NOT NULL,
	auction_id int NOT NULL,
	user_id int NOT NULL,
	review_datetime datetime DEFAULT getdate() NOT NULL,
	rating tinyint DEFAULT 5 NOT NULL,
	comment varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	CONSTRAINT PK_reviews PRIMARY KEY (id),
	CONSTRAINT FK_auctions_reviews FOREIGN KEY (auction_id) REFERENCES dbo.auctions(id),
	CONSTRAINT FK_users_reviews FOREIGN KEY (user_id) REFERENCES dbo.users(id),
    CONSTRAINT CHK_rating CHECK (
        rating BETWEEN 1 AND 5
    )
)

CREATE TABLE dbo.administrators (
	id int IDENTITY(0,1) NOT NULL,
	username varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	email varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	password varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	created_at datetime DEFAULT getdate() NOT NULL,
	CONSTRAINT PK_administrators PRIMARY KEY (id),
)
