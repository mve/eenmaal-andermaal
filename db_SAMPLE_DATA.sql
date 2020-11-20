INSERT INTO dbo.security_questions (question)
VALUES ('What is love?')
INSERT INTO dbo.users (
        username,
        email,
        password,
        first_name,
        last_name,
        address,
        postal_code,
        city,
        country,
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
        'Nederland',
        '2020-11-10',
        0,
        'Baby don''t hurt me'
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
        'Nederland',
        '2020-11-10',
        0,
        'Baby don''t hurt me'
    ),
    (
        'admin',
        'admin@mail.com',
        '$2y$10$dyjvsG8FpkB13AAkGuEQsOxt84O9fJk9E6nTsUmYvk87Ei5z4XtRe',
        'admin',
        'lastname',
        'Straatnaam 1',
        '9999AA',
        'Stad',
        'Nederland',
        '2020-11-10',
        0,
        'Baby don''t hurt me'
    )
INSERT INTO dbo.phone_numbers (user_id, phone_number)
VALUES (0, 0612345678),
    (1, 0612345678),
    (2, 0612345678)
INSERT INTO auction (
        title,
        description,
        start_price,
        payment_instruction,
        start_datetime,
        end_datetime,
        city,
        country,
        user_id
    )
VALUES (
        'Fiets te koop',
        'Mooie fiets, mogelijk gestolen. Om die reden ook geen foto''s',
        10.00,
        'Alleen munten!',
        '2020-11-20',
        '2020-11-27',
        'Stad',
        'Nederland',
        1
    ),
    (
        'Tantoesnelle brommer',
        'Gaat moeilijk hard. Niet doorvertellen!',
        20.00,
        NULL,
        '2020-11-22',
        '2020-11-29',
        'Stad',
        'Nederland',
        1
    ),
    (
        'Kutauto',
        'Ik heb echt een hekel aan dit ding. Moet weg!',
        25.00,
        'Al betaal je met knikkers!',
        '2020-11-24',
        '2020-12-01',
        'Stad',
        'Nederland',
        1
    ),
    (
        'Nvidia RTX 3090',
        'Ik ben heel gul, dus gun jullie deze videokaart voor een vriendenprijsje',
        2500.00,
        'Bij verzenden, eerst betalen!',
        '2020-11-20',
        '2020-12-15',
        'Stad',
        'Nederland',
        1
    )
INSERT INTO auction_images (auction_id, file_name)
VALUES (1, '1picturepath 1 here'),
    (1, '1picturepath2 here'),
    (1, '1picture3 here')
INSERT INTO shipping_methods (method)
VALUES ('Afhalen'),
    ('Verzenden (binnenland)'),
    ('Verzenden (buitenland)')
INSERT INTO auction_shipping_methods (auction_id, shipping_id, price)
VALUES (0, 0, 0),
    (1, 0, 0),
    (2, 0, 0),
    (3, 1, 6.95),
    (3, 2, 10.95)
INSERT INTO payment_methods (method)
VALUES ('Contant'),
    ('iDeal'),
    ('Creditcard'),
    ('PayPal')
INSERT INTO auction_payment_methods (auction_id, payment_id)
VALUES (0, 0),
    (1, 0),
    (1, 1),
    (2, 0),
    (2, 1),
    (3, 0),
    (3, 1)
INSERT INTO categories (name, parent_id)
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
INSERT INTO auction_categories (auction_id, category_id)
VALUES (0, 36),
    (1, 35),
    (2, 30),
    (3, 13)
INSERT INTO reviews (
        auction_id,
        user_id,
        review_datetime,
        is_positive,
        comment
    )
VALUES (
        0,
        0,
        '2020-11-20',
        0,
        'Fiets was inderdaad gestolen'
    ),
    (
        1,
        0,
        '2020-11-20',
        1,
        'Met 90 km/h door het centrum, helemaal prima!'
    ),
    (
        2,
        0,
        '2020-11-20',
        1,
        'Auto was als beschreven dus er is maar één schuldige'
    ),
    (
        3,
        0,
        '2020-11-20',
        0,
        'Vieze afzetter, en nog een lul ook!'
    )
    
-- CATEGORIES:
    -- Computer
    --     Accessoires
    --         Monitoren
    --         Muizen
    --         Speakers
    --         Toetsenborden
    --     Desktops
    --         All-in-ones
    --         Tower
    --     Componenten 
    --         Moederborden
    --         Processoren
    --         SSDs
    --         Videokaarten
    --     Laptops
    -- Muziek
    --     Instrumenten
    --         Gitaren en versterkers
    --             Akoestische gitaren
    --             Elektrische Gitaren
    --             Versterkers
    --         Drumstellen
    --         Blaasinstrumenten
    --             Blokfluiten
    --             Trombones
    --             Trompetten
    --             Tubas
    --         Keyboards en pianos 
    --             Keyboards,
    --             Pianos
    -- Transport 
    --     Autos
    --     Aanhangers
    --     Boten
    --     Tweewielers
    --         Brommers en Scooters
    --             Brommers
    --             Fietsen
    --             Motoren
    --             Scooters
    --     Overig