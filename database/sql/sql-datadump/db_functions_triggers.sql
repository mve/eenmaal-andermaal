SET IDENTITY_INSERT dbo.MyTable ON  -- Statement Allows explicit values to be inserted into 
                                -- the identity column of a table.
GO


CREATE TABLE dbo.gebruiker
( 
  Username VARCHAR(200),
  Postalcode VARCHAR(9),
  Location VARCHAR(MAX),
  Country VARCHAR(100),
  Rating NUMERIC(4,1) 
)

CREATE TABLE dbo.Categorieen
(
	ID int NOT NULL,
	Name varchar(100) NULL,
	Parent int NULL,
)

CREATE TABLE dbo.Items
(
	ID bigint NOT NULL,
	Titel varchar(max) NULL,
	Beschrijving nvarchar(max) NULL,
	Categorie int NULL,
	Postcode varchar(max) NULL,
	Locatie varchar(max) NULL,
	Land varchar(max) NULL,
	Verkoper varchar(max) NULL,
	Prijs varchar(max) NULL,
	Valuta varchar(max) NULL,
	Conditie varchar(max) NULL,
	Thumbnail varchar(max) NULL,
)

CREATE TABLE dbo.Illustraties
(
	ItemID bigint NOT NULL,
	IllustratieFile varchar(100) NOT NULL,
)
GO
-------------------------------------------

CREATE TRIGGER insertusers on dbo.gebruiker
INSTEAD OF INSERT 
AS
BEGIN 
INSERT INTO dbo.users(
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
	security_answer,
	is_seller
)
SELECT 
	Username,
	Username + '@mail.com',
	'$2y$10$dyjvsG8FpkB13AAkGuEQsOxt84O9fJk9E6nTsUmYvk87Ei5z4XtRe',
	Username,
	Username,
	Location,
	Postalcode,
	Location,
	Country,
	'2020-12-07',
	0,
	'hond',
	0
FROM INSERTED
END
GO

---------------------------------------------------

CREATE TRIGGER insert_illustraties on dbo.Illustraties
INSTEAD OF INSERT 
AS
BEGIN 
INSERT INTO dbo.auction_images(
	auction_id,
	file_name
)
SELECT 
	ItemID,
	'../images/' + IllustratieFile
FROM INSERTED
END
GO

-----------------------------------------------------

CREATE TRIGGER insert_categories on dbo.Categorieen
INSTEAD OF INSERT 
AS
BEGIN 
INSERT INTO dbo.categories(
	id,
	name,
	parent_id
)
SELECT 
	ID,
	Name,
	Parent
FROM INSERTED
END
GO

--------------------------------------------------------

CREATE TRIGGER insert_auctions on dbo.Items
INSTEAD OF INSERT 
AS
BEGIN 
INSERT INTO dbo.auctions(
	id,
	title,
	description,
	start_price,
	payment_instruction,
	duration,
	end_datetime,
	city,
	country_code ,
	user_id
)
SELECT 
	ID,
	Titel,
	dbo.strip_html(Beschrijving),
	Prijs,
	Land,
	'2',
	GETDATE(),
	Locatie,
	Land,
	(SELECT us.id FROM dbo.users as us WHERE us.username=Verkoper collate SQL_Latin1_General_CP1_CI_AS)

FROM INSERTED

INSERT INTO dbo.auction_images(
	auction_id,
	file_name
)
SELECT 
	ID,
	'../images/' + Thumbnail
FROM INSERTED

END

GO

--------------------------------------------------------


-- CREATE TRIGGER tgrOnItemsInsert on dbo.Items
-- INSTEAD OF INSERT 
-- AS
-- BEGIN 
-- INSERT INTO dbo.Items(
-- 	ID,
-- 	Titel,
-- 	Categorie,
-- 	Postcode,
-- 	Locatie,
-- 	Land,
-- 	Verkoper,
-- 	Prijs,
-- 	Valuta,
-- 	Conditie,
-- 	Thumbnail,
-- 	Beschrijving
-- )
-- SELECT 
-- 	ID,
-- 	Titel,
-- 	Categorie,
-- 	Postcode,
-- 	Locatie,
-- 	Land,
-- 	Verkoper,
-- 	Prijs,
-- 	Valuta,
-- 	Conditie,
-- 	Thumbnail,
-- 	dbo.strip_html(Beschrijving)
-- FROM INSERTED
-- END
-- GO

---------------------------------------------------
-- Geurian's remove_spaces-functie

-- CREATE FUNCTION dbo.remove_spaces(@input NVARCHAR(MAX))
--  RETURNS NVARCHAR(MAX)
--  AS BEGIN
--      DECLARE @stripped NVARCHAR(MAX)
--  	SELECT @stripped = input.value('.', 'NVARCHAR(MAX)')
--  	FROM (
--  		SELECT input = 
--              CAST(REPLACE(
-- 				REPLACE(
-- 					REPLACE(
-- 						LTRIM(RTRIM(@input))
-- 					,'  ',' '+CHAR(182))
-- 				,CHAR(182)+' ','')
-- 			,CHAR(182),'') AS XML)
-- 	) r
--  	RETURN LTRIM(RTRIM(@stripped))
-- END
-- GO
---------------------------------------------------

-- https://stackoverflow.com/questions/457701/how-to-strip-html-tags-from-a-string-in-sql-server
CREATE FUNCTION [dbo].[strip_html] (@html varchar(MAX))
RETURNS varchar(MAX)
AS
BEGIN
DECLARE @Start  int
DECLARE @End    int
DECLARE @Length int

set @html = replace(@html, CHAR(13) + CHAR(10), ' ')
set @html = replace(@html, '<br>',CHAR(13) + CHAR(10))
set @html = replace(@html, '<br/>',CHAR(13) + CHAR(10))
set @html = replace(@html, '<br />',CHAR(13) + CHAR(10))
set @html = replace(@html, '<li>','- ')
set @html = replace(@html, '</li>',CHAR(13) + CHAR(10))

set @html = replace(@html, '&rsquo;' collate Latin1_General_CS_AS, ''''  collate Latin1_General_CS_AS)
set @html = replace(@html, '&quot;' collate Latin1_General_CS_AS, '"'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&amp;' collate Latin1_General_CS_AS, '&'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&euro;' collate Latin1_General_CS_AS, '€'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&lt;' collate Latin1_General_CS_AS, '<'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&gt;' collate Latin1_General_CS_AS, '>'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&oelig;' collate Latin1_General_CS_AS, 'oe'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&nbsp;' collate Latin1_General_CS_AS, ''  collate Latin1_General_CS_AS)
set @html = replace(@html, '&copy;' collate Latin1_General_CS_AS, '©'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&laquo;' collate Latin1_General_CS_AS, '«'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&reg;' collate Latin1_General_CS_AS, '®'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&plusmn;' collate Latin1_General_CS_AS, '±'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&sup2;' collate Latin1_General_CS_AS, '²'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&sup3;' collate Latin1_General_CS_AS, '³'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&micro;' collate Latin1_General_CS_AS, 'µ'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&middot;' collate Latin1_General_CS_AS, '·'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&ordm;' collate Latin1_General_CS_AS, 'º'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&raquo;' collate Latin1_General_CS_AS, '»'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&frac14;' collate Latin1_General_CS_AS, '¼'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&frac12;' collate Latin1_General_CS_AS, '½'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&frac34;' collate Latin1_General_CS_AS, '¾'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&Aelig' collate Latin1_General_CS_AS, 'Æ'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&Ccedil;' collate Latin1_General_CS_AS, 'Ç'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&Egrave;' collate Latin1_General_CS_AS, 'È'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&Eacute;' collate Latin1_General_CS_AS, 'É'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&Ecirc;' collate Latin1_General_CS_AS, 'Ê'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&Ouml;' collate Latin1_General_CS_AS, 'Ö'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&agrave;' collate Latin1_General_CS_AS, 'à'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&acirc;' collate Latin1_General_CS_AS, 'â'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&auml;' collate Latin1_General_CS_AS, 'ä'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&aelig;' collate Latin1_General_CS_AS, 'æ'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&ccedil;' collate Latin1_General_CS_AS, 'ç'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&egrave;' collate Latin1_General_CS_AS, 'è'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&eacute;' collate Latin1_General_CS_AS, 'é'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&ecirc;' collate Latin1_General_CS_AS, 'ê'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&euml;' collate Latin1_General_CS_AS, 'ë'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&icirc;' collate Latin1_General_CS_AS, 'î'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&ocirc;' collate Latin1_General_CS_AS, 'ô'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&ouml;' collate Latin1_General_CS_AS, 'ö'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&divide;' collate Latin1_General_CS_AS, '÷'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&oslash;' collate Latin1_General_CS_AS, 'ø'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&ugrave;' collate Latin1_General_CS_AS, 'ù'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&uacute;' collate Latin1_General_CS_AS, 'ú'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&ucirc;' collate Latin1_General_CS_AS, 'û'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&uuml;' collate Latin1_General_CS_AS, 'ü'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&quot;' collate Latin1_General_CS_AS, '"'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&amp;' collate Latin1_General_CS_AS, '&'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&lsaquo;' collate Latin1_General_CS_AS, '<'  collate Latin1_General_CS_AS)
set @html = replace(@html, '&rsaquo;' collate Latin1_General_CS_AS, '>'  collate Latin1_General_CS_AS)

-- Remove anything between <STYLE> tags
SET @Start = CHARINDEX('<STYLE', @html)
SET @End = CHARINDEX('</STYLE>', @html, CHARINDEX('<', @html)) + 7
SET @Length = (@End - @Start) + 1

WHILE (@Start > 0 AND @End > 0 AND @Length > 0) BEGIN
SET @html = STUFF(@html, @Start, @Length, '')
SET @Start = CHARINDEX('<STYLE', @html)
SET @End = CHARINDEX('</STYLE>', @html, CHARINDEX('</STYLE>', @html)) + 7
SET @Length = (@End - @Start) + 1
END

-- Remove anything between <SCRIPT> tags
SET @Start = CHARINDEX('<SCRIPT', @html)
SET @End = CHARINDEX('</SCRIPT>', @html, CHARINDEX('<', @html)) + 7
SET @Length = (@End - @Start) + 1

WHILE (@Start > 0 AND @End > 0 AND @Length > 0) BEGIN
SET @html = STUFF(@html, @Start, @Length, '')
SET @Start = CHARINDEX('<SCRIPT', @html)
SET @End = CHARINDEX('</SCRIPT>', @html, CHARINDEX('</SCRIPT>', @html)) + 7
SET @Length = (@End - @Start) + 1
END

-- Remove any HTML
SET @Start = CHARINDEX('<', @html)
SET @End = CHARINDEX('>', @html, CHARINDEX('<', @html))
SET @Length = (@End - @Start) + 1

WHILE (@Start > 0 AND @End > 0 AND @Length > 0) BEGIN
SET @html = STUFF(@html, @Start, @Length, '')
SET @Start = CHARINDEX('<', @html)
SET @End = CHARINDEX('>', @html, CHARINDEX('<', @html))
SET @Length = (@End - @Start) + 1
END

RETURN dbo.remove_spaces(@html)

END
GO

---------------------------------------------------
-- Roel's remove_spaces-functie
CREATE FUNCTION [dbo].[remove_spaces](@html varchar(MAX))
RETURNS varchar(MAX)
AS
BEGIN
	DECLARE @Demo TABLE(OriginalString VARCHAR(8000))
	INSERT INTO @Demo (OriginalString)
	SELECT @html
	SELECT @stripped = REPLACE(
			REPLACE(
				REPLACE(
					LTRIM(RTRIM(OriginalString))
				,'  ',' '+CHAR(182))
			,CHAR(182)+' ','')
		,CHAR(182),'')
	FROM @Demo
	WHERE CHARINDEX('  ',OriginalString) > 0
	RETURN @stripped
END

---------------------------------------------------
