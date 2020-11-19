CREATE TABLE eenmaalandermaal.dbo.security_questions
(
    id       int IDENTITY (0,1)                                NOT NULL,
    question varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
    CONSTRAINT security_questions_PK PRIMARY KEY (id)
)

CREATE TABLE eenmaalandermaal.dbo.auction
(
    id                  int IDENTITY (0,1)                                 NOT NULL,
    title               varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS  NOT NULL,
    description         varchar(1000) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
    start_price         decimal(9, 2) DEFAULT 0                            NOT NULL,
    payment_instruction varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
    start_datetime      datetime      DEFAULT getdate()                    NOT NULL,
    end_datetime        datetime                                           NOT NULL,
    city                varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS  NOT NULL,
    country             varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS  NOT NULL,
    user_id             int                                                NOT NULL,
    CONSTRAINT auction_PK PRIMARY KEY (id)
)

CREATE TABLE eenmaalandermaal.dbo.payment_methods
(
    id       int IDENTITY (0,1)                                NOT NULL,
    [method] varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
    CONSTRAINT payment_methods_PK PRIMARY KEY (id)
)

CREATE TABLE eenmaalandermaal.dbo.shipping_methods
(
    id       int IDENTITY (0,1)                                NOT NULL,
    [method] varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
    CONSTRAINT shipping_methods_PK PRIMARY KEY (id)
)

CREATE TABLE eenmaalandermaal.dbo.users
(
    id                   int IDENTITY (0,1)                                NOT NULL,
    username             varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
    email                varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
    password             varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
    first_name           varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
    last_name            varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
    address              varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
    postal_code          char(6) COLLATE SQL_Latin1_General_CP1_CI_AS      NOT NULL,
    city                 varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
    country              varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
    birth_date           date                                              NOT NULL,
    security_question_id int                                               NOT NULL,
    security_answer      varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
    is_seller            bit      DEFAULT 0                                NOT NULL,
    is_admin             bit      DEFAULT 0                                NOT NULL,
    created_at           datetime DEFAULT getdate()                        NULL,
    CONSTRAINT users_PK PRIMARY KEY (id),
    CONSTRAINT security_question_FK FOREIGN KEY (security_question_id) REFERENCES eenmaalandermaal.dbo.security_questions (id)
)

CREATE TABLE eenmaalandermaal.dbo.phone_numbers
(
    id           int IDENTITY (0,1)                               NOT NULL,
    user_id      int                                              NOT NULL,
    phone_number varchar(15) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
    CONSTRAINT numbers_PK PRIMARY KEY (id),
    CONSTRAINT numbers_FK FOREIGN KEY (user_id) REFERENCES eenmaalandermaal.dbo.users (id)
)

CREATE TABLE eenmaalandermaal.dbo.auction_hits
(
    id           int IDENTITY (0,1)         NOT NULL,
    auction_id   int                        NOT NULL,
    user_id      int                        NULL,
    ip_binary    varbinary(16)              NOT NULL,
    hit_datetime datetime DEFAULT getdate() NOT NULL,
    CONSTRAINT auction_hits_FK FOREIGN KEY (user_id) REFERENCES eenmaalandermaal.dbo.users (id)
)

CREATE TABLE eenmaalandermaal.dbo.auction_shipping_methods
(
    id          int IDENTITY (0,1) NOT NULL,
    auction_id  int                NOT NULL,
    shipping_id int                NOT NULL,
    price       decimal(9, 2)      NULL,
    CONSTRAINT auction_shipping_methods_PK PRIMARY KEY (id),
    CONSTRAINT auction_shipping_methods_FK FOREIGN KEY (auction_id) REFERENCES eenmaalandermaal.dbo.auction (id),
    CONSTRAINT auction_shipping_methods_FK_1 FOREIGN KEY (shipping_id) REFERENCES eenmaalandermaal.dbo.shipping_methods (id)
)

CREATE TABLE eenmaalandermaal.dbo.auction_payment_methods
(
    id         int IDENTITY (0,1) NOT NULL,
    auction_id int                NOT NULL,
    payment_id int                NOT NULL,
    CONSTRAINT auction_payment_methods_PK PRIMARY KEY (id),
    CONSTRAINT auction_payment_methods_FK FOREIGN KEY (auction_id) REFERENCES eenmaalandermaal.dbo.auction (id),
    CONSTRAINT auction_payment_methods_FK_1 FOREIGN KEY (payment_id) REFERENCES eenmaalandermaal.dbo.payment_methods (id)
)

CREATE TABLE eenmaalandermaal.dbo.bids
(
    id           int IDENTITY (0,1)         NOT NULL,
    auction_id   int                        NOT NULL,
    user_id      int                        NOT NULL,
    amount       decimal(9, 2)              NOT NULL,
    bid_datetime datetime DEFAULT getdate() NOT NULL,
    CONSTRAINT bids_PK PRIMARY KEY (id),
    CONSTRAINT bids_FK FOREIGN KEY (auction_id) REFERENCES eenmaalandermaal.dbo.auction (id),
    CONSTRAINT bids_FK_1 FOREIGN KEY (user_id) REFERENCES eenmaalandermaal.dbo.users (id)
)

CREATE TABLE eenmaalandermaal.dbo.auction_images
(
    id         int IDENTITY (0,1)                                NOT NULL,
    auction_id int                                               NOT NULL,
    file_name  varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
    CONSTRAINT auction_images_PK PRIMARY KEY (id),
    CONSTRAINT auction_images_FK FOREIGN KEY (auction_id) REFERENCES eenmaalandermaal.dbo.auction (id)
)

CREATE TABLE eenmaalandermaal.dbo.reviews
(
    id              int IDENTITY (0,1)                                NOT NULL,
    auction_id      int                                               NOT NULL,
    user_id         int                                               NOT NULL,
    review_datetime datetime DEFAULT getdate()                        NOT NULL,
    is_positive     bit      DEFAULT 1                                NOT NULL,
    comment         varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
    CONSTRAINT reviews_PK PRIMARY KEY (id),
    CONSTRAINT reviews_FK FOREIGN KEY (auction_id) REFERENCES eenmaalandermaal.dbo.auction (id),
    CONSTRAINT reviews_FK_1 FOREIGN KEY (user_id) REFERENCES eenmaalandermaal.dbo.users (id)
)

CREATE TABLE eenmaalandermaal.dbo.categories
(
    id        int IDENTITY (0,1)                                NOT NULL,
    name      varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
    parent_id int                                               NULL,
    CONSTRAINT category_PK PRIMARY KEY (id),
    CONSTRAINT category_FK FOREIGN KEY (parent_id) REFERENCES eenmaalandermaal.dbo.categories (id)
)

CREATE TABLE eenmaalandermaal.dbo.auction_categories
(
    id          int IDENTITY (0,1) NOT NULL,
    auction_id  int                NOT NULL,
    category_id int                NOT NULL,
    CONSTRAINT auction_categories_PK PRIMARY KEY (id),
    CONSTRAINT auction_categories_FK FOREIGN KEY (auction_id) REFERENCES eenmaalandermaal.dbo.auction (id),
    CONSTRAINT auction_categories_FK_1 FOREIGN KEY (category_id) REFERENCES eenmaalandermaal.dbo.categories (id)
)
