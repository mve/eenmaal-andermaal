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
        '2020-11-30',
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
        '2020-12-03',
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
        '2020-12-06',
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
        '2020-12-15',
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
    ('Overig', 29)

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
        5,
        'Fiets was in slechte staat, was niet te zien in de foto''s. Heb er niet lang mee kunnen doen voordat ik op zoek kon naar een andere.'
    ),
    (
        1,
        0,
        '2020-11-26',
        1,
        'Leuk klein dingetje, verkoper was ook zeer vriendelijk.'
    ),
    (
        2,
        0,
        '2020-11-26',
        2,
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
