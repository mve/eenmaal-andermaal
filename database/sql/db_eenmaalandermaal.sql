
---------------------------------------------------------
--------------------- CREATE TABLES ---------------------
---------------------------------------------------------
---------------------------------------------------------

CREATE TABLE dbo.countries (
	country_code varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	country varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	CONSTRAINT PK_countries PRIMARY KEY (country_code)
)

CREATE TABLE dbo.auctions (
	id bigint IDENTITY(0,1) NOT NULL,
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
	id bigint IDENTITY(0,1) NOT NULL,
	auction_id bigint NOT NULL,
	file_name varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	CONSTRAINT PK_auctionimages PRIMARY KEY (id),
	CONSTRAINT FK_auctions_auctionimages FOREIGN KEY (auction_id) REFERENCES dbo.auctions(id)
)

CREATE TABLE dbo.auction_payment_methods (
	id int IDENTITY(0,1) NOT NULL,
	auction_id bigint NOT NULL,
	payment_id int NOT NULL,
	CONSTRAINT PK_auctionpaymentmethods PRIMARY KEY (id),
	CONSTRAINT FK_auctions_auctionpaymentmethods FOREIGN KEY (auction_id) REFERENCES dbo.auctions(id),
	CONSTRAINT FK_paymentmethods_auctionpaymentmethods FOREIGN KEY (payment_id) REFERENCES dbo.payment_methods(id)
)

CREATE TABLE dbo.auction_shipping_methods (
	id int IDENTITY(0,1) NOT NULL,
	auction_id bigint NOT NULL,
	shipping_id int NOT NULL,
	price decimal(9,2) NULL,
	CONSTRAINT PK_auctionshippingmethods PRIMARY KEY (id),
	CONSTRAINT FK_auctions_auctionshippingmethods FOREIGN KEY (auction_id) REFERENCES dbo.auctions(id),
	CONSTRAINT FK_shippingmethods_auctionshippingmethods FOREIGN KEY (shipping_id) REFERENCES dbo.shipping_methods(id)
)

CREATE TABLE dbo.categories (
	id int IDENTITY(0,1) NOT NULL,
	name varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	parent_id bigint NULL,
	CONSTRAINT PK_category PRIMARY KEY (id),
	--CONSTRAINT FK_categories_categories FOREIGN KEY (parent_id) REFERENCES dbo.categories(id)
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
	auction_id bigint NOT NULL,
	category_id int NOT NULL,
	CONSTRAINT PK_auctioncategories PRIMARY KEY (id),
	CONSTRAINT FK_auctions_auctioncategories FOREIGN KEY (auction_id) REFERENCES dbo.auctions(id),
	CONSTRAINT FK_categories_auctioncategories FOREIGN KEY (category_id) REFERENCES dbo.categories(id)
)

CREATE TABLE dbo.auction_hits (
	id int IDENTITY(0,1) NOT NULL,
	auction_id bigint NOT NULL,
	user_id int NULL,
	ip varchar(45) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	hit_datetime datetime DEFAULT getdate() NOT NULL,
	CONSTRAINT PK_auctionhits PRIMARY KEY (id),
	CONSTRAINT FK_users_auctionhits FOREIGN KEY (user_id) REFERENCES dbo.users(id)
)

CREATE TABLE dbo.bids (
	id int IDENTITY(0,1) NOT NULL,
	auction_id bigint NOT NULL,
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
	auction_id bigint NOT NULL,
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
GO





---------------------------------------------------------
---------------------------------------------------------
--------------------- INSERT VALUES ---------------------
---------------------------------------------------------
---------------------------------------------------------

INSERT INTO dbo.countries (country_code, country)
VALUES ('NL', 'Nederland'),
    ('DE', 'Duitsland'),
    ('BE', 'België')

INSERT INTO dbo.security_questions (question)
VALUES ('Wat voor een huisdier heb je?')

INSERT INTO dbo.users (
        username,
        email,
        password,
        first_name,
        last_name,
        address,
        postal_code,
        city,
        country_code,
        birth_date,
        security_question_id,
        security_answer
    )
VALUES (
        'user',
        'user@mail.com',
        '$2y$10$dyjvsG8FpkB13AAkGuEQsOxt84O9fJk9E6nTsUmYvk87Ei5z4XtRe',
        'user',
        'lastname',
        'Straatnaam 1',
        '9999AA',
        'Stad',
        'NL',
        '2020-11-10',
        0,
        'Hond'
    ),
    (
        'seller',
        'seller@mail.com',
        '$2y$10$dyjvsG8FpkB13AAkGuEQsOxt84O9fJk9E6nTsUmYvk87Ei5z4XtRe',
        'seller',
        'lastname',
        'Straatnaam 1',
        '9999AA',
        'Stad',
        'NL',
        '2020-11-10',
        0,
        'Kat'
    ),
    (
        'german',
        'german@mail.com',
        '$2y$10$dyjvsG8FpkB13AAkGuEQsOxt84O9fJk9E6nTsUmYvk87Ei5z4XtRe',
        'german',
        'lastname',
        'Straße 1',
        '46395',
        'Stadt',
        'DE',
        '2020-11-10',
        0,
        'Katze'
    ),
    (
        'belgian',
        'belgian@mail.com',
        '$2y$10$dyjvsG8FpkB13AAkGuEQsOxt84O9fJk9E6nTsUmYvk87Ei5z4XtRe',
        'belgian',
        'lastname',
        'Straat 1',
        '2200',
        'Stad',
        'BE',
        '2020-11-10',
        0,
        'Konijn'
    )

INSERT INTO dbo.phone_numbers (user_id, phone_number)
VALUES (0, '0612345678'),
    (1, '0612345678'),
    (2, '0612345678')

INSERT INTO dbo.seller_verifications (
        user_id,
        method,
        bank_name,
        bank_account_number
    )
VALUES (1, 'Bank', 'Rabobank', 'NL13RABO012345678')

INSERT INTO dbo.auctions (
        title,
        description,
        start_price,
        payment_instruction,
        duration,
        end_datetime,
        city,
        country_code,
        user_id
    )
VALUES (
        'Fiets te koop',
        'Mooie fiets, gekregen van mijn vader. Ik heb hem niet langer nodig wegens aanschaf van een auto',
        10.00,
        'Het liefst contant',
        3,
        '2020-12-01',
        'Arnhem',
        'NL',
        1
    ),
    (
        'Stadsbrommer',
        'Blauwe plaat en zeer compact. Ideaal voor korte reizen!',
        20.00,
        NULL,
        7,
        '2020-12-17',
        'Nijmegen',
        'NL',
        1
    ),
    (
        'Auto ALS NIEUW',
        'Halfjaar geleden tweedehands gekocht, bleek achteraf niet nodig. OV is in mijn omgeving veel eenvoudiger, dus kan de auto beter van de hand doen.',
        8000.00,
        'Alle Nederlandse betaalmethodes worden geaccepteerd!',
        10,
        '2020-12-22',
        'Amsterdam',
        'NL',
        1
    ),
    (
        'Nvidia RTX 3090',
        'Nieuw gekocht maar ik kan nog wel even wachten. Mag weg, maar hoeft niet!',
        2000.00,
        'Bij verzenden, eerst betalen!',
        3,
        '2020-12-25',
        'Utrecht',
        'NL',
        1
    )

INSERT INTO dbo.auction_hits (auction_id, user_id, ip)
VALUES (0, 0, '1.1.1.1'),
    (1, 0, '1.1.1.1'),
    (1, 0, '1.1.1.1'),
    (1, 0, '1.1.1.1'),
    (2, 0, '1.1.1.1'),
    (3, 0, '1.1.1.1'),
    (3, 0, '1.1.1.1'),
    (3, 0, '1.1.1.1'),
    (3, 0, '1.1.1.1'),
    (3, 0, '1.1.1.1'),
    (3, 0, '1.1.1.1'),
    (3, 0, '1.1.1.1'),
    (3, 0, '1.1.1.1')

INSERT INTO dbo.bids (auction_id, user_id, amount)
VALUES (0, 0, 15),
    (0, 0, 20),
    (0, 0, 22.50),
    (1, 0, 20),
    (1, 0, 25),
    (1, 0, 40),
    (2, 0, 8050),
    (3, 0, 2000),
    (3, 0, 2100)

INSERT INTO dbo.auction_images (auction_id, file_name)
VALUES (0, '../images/fiets.jpeg'),
    (1, '../images/brommer.jpg'),
    (2, '../images/unsplash-ferrari.jpg'),
    (3, '../images/3090.png')

INSERT INTO dbo.shipping_methods (method)
VALUES ('Afhalen'),
    ('Verzenden (binnenland)'),
    ('Verzenden (buitenland)')

INSERT INTO dbo.auction_shipping_methods (auction_id, shipping_id, price)
VALUES (0, 0, 0),
    (1, 0, 0),
    (2, 0, 0),
    (3, 1, 6.95),
    (3, 2, 10.95)

INSERT INTO dbo.payment_methods (method)
VALUES ('Contant'),
    ('iDeal'),
    ('Creditcard'),
    ('PayPal')

INSERT INTO dbo.auction_payment_methods (auction_id, payment_id)
VALUES (0, 0),
    (1, 0),
    (1, 1),
    (2, 0),
    (2, 1),
    (3, 0),
    (3, 1)

INSERT INTO dbo.categories (name, parent_id)
VALUES ('Computer', NULL),
    ('Accessoires', 0),
    ('Monitoren', 1),
    ('Muizen', 1),
    ('Speakers', 1),
    ('Toetsenborden', 1),
    ('Desktops', 0),
    ('All-in-ones', 6),
    ('Tower', 6),
    ('Componenten', 0),
    ('Moederborden', 9),
    ('Processoren', 9),
    ('SSD''s', 9),
    ('Videokaarten', 9),
    ('Laptops', 0),
    ('Muziek', NULL),
    ('Instrumenten', 15),
    ('Gitaren en versterkers', 16),
    ('Akoestische gitaren', 17),
    ('Versterkers', 18),
    ('Drumstellen', 16),
    ('Blaasinstrumenten', 16),
    ('Blokfluiten', 21),
    ('Trombones', 21),
    ('Trompetten', 21),
    ('Tuba''s', 21),
    ('Keyboards en piano''s', 16),
    ('Keyboards', 26),
    ('Piano''s', 26),
    ('Transport', NULL),
    ('Auto''s', 29),
    ('Aanhangers', 29),
    ('Boten', 29),
    ('Tweewielers', 29),
    ('Brommers en scooters', 33),
    ('Brommers', 34),
    ('Fietsen', 33),
    ('Motoren', 33),
    ('Scooters', 34),
    ('Overig', 29),
    ('JDM', 30),
    ('Subaru', 40),
    ('Accessoires', 41),
    ('Performance', 42),
    ('Turbo''s', 44),
    ('FISPA', 45),
    ('RIDEX', 45),
    ('Motorblokken', 44)

INSERT INTO dbo.auction_categories (auction_id, category_id)
VALUES (0, 36),
    (1, 35),
    (2, 30),
    (3, 13)

INSERT INTO dbo.reviews (
        auction_id,
        user_id,
        review_datetime,
        rating,
        comment
    )
VALUES (
        0,
        0,
        '2020-11-26',
        1,
        'Fiets was in slechte staat, was niet te zien in de foto''s. Heb er niet lang mee kunnen doen voordat ik op zoek kon naar een andere.'
    ),
    (
        1,
        0,
        '2020-11-26',
        4,
        'Leuk klein dingetje, verkoper was ook zeer vriendelijk.'
    ),
    (
        2,
        0,
        '2020-11-26',
        5,
        'Auto was als beschreven, zeer tevreden!'
    ),
    (
        3,
        0,
        '2020-11-26',
        3,
        'Blij dat ik de kaart heb, maar toch ontevreden dat ik er een premium voor heb moeten betalen t.o.v. de winkelprijs!'
    )

INSERT INTO dbo.administrators (username, email, password)
VALUES (
        'admin',
        'admin@mail.com',
        '$2y$10$dyjvsG8FpkB13AAkGuEQsOxt84O9fJk9E6nTsUmYvk87Ei5z4XtRe'
    )
