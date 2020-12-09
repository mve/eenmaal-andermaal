-- CREATE FUNCTION strip_html(@input NVARCHAR(MAX))
-- RETURNS NVARCHAR(MAX)
-- AS BEGIN
--     DECLARE @stripped NVARCHAR(MAX)
-- 	SELECT @stripped = input.value('.', 'NVARCHAR(MAX)')
-- 	FROM (
-- 		SELECT input = 
--             CAST(REPLACE(REPLACE(REPLACE(REPLACE(@input, '>', '/> '), '</', '<'), '--/>', '-->'), '&nbsp;', '') AS XML)
-- 	) r
-- 	RETURN @stripped
-- END

---------------------------------------------------

CREATE TRIGGER tgrOnItemsInsert on dbo.Items
INSTEAD OF INSERT 
AS
BEGIN 
INSERT INTO dbo.Items(
	ID,
	Titel,
	Categorie,
	Postcode,
	Locatie,
	Land,
	Verkoper,
	Prijs,
	Valuta,
	Conditie,
	Thumbnail,
	Beschrijving
)
SELECT 
	ID,
	Titel,
	Categorie,
	Postcode,
	Locatie,
	Land,
	Verkoper,
	Prijs,
	Valuta,
	Conditie,
	Thumbnail,
	dbo.clean_text(Beschrijving)
FROM INSERTED
END
GO

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