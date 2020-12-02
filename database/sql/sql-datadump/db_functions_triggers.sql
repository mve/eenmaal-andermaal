CREATE OR REPLACE FUNCTION fnStripHtml()
                           RETURNS trigger AS
$BODY$
BEGIN
  IF NEW.beschrijving IS NOT NULL THEN
    
  END IF;
  RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql;
GO

CREATE TRIGGER tgrStripItemDescription
               BEFORE INSERT
               ON dbo.Items
               FOR EACH ROW
               EXECUTE PROCEDURE fnStripHtml();

-----------------------------------------------------

CREATE TRIGGER InsteadOfINSERTTriggerExample on dbo.Items
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
	Beschrijving
FROM INSERTED
PRINT 'We Successfully Fired Our INSTEAD OF INSERT Triggers in SQL Server.'
END
GO

-----------------------------------------------------

CREATE FUNCTION strip_html(@input NVARCHAR(MAX))
RETURNS NVARCHAR(MAX)
AS BEGIN
    DECLARE @stripped NVARCHAR(MAX)
	SELECT @stripped = input.value('.', 'NVARCHAR(MAX)')
	FROM (
		SELECT input = 
            CAST(REPLACE(REPLACE(REPLACE(REPLACE(@input, '>', '/> '), '</', '<'), '--/>', '-->'), '&nbsp;', '') AS XML)
	) r
	RETURN @stripped
END

---------------------------------------------------

CREATE FUNCTION [dbo].[udf_StripHTML]
--by Patrick Honorez --- www.idevlop.com
--inspired by http://stackoverflow.com/questions/457701/best-way-to-strip-html-tags-from-a-string-in-sql-server/39253602#39253602
(
@HTMLText varchar(MAX)
)
RETURNS varchar(MAX)
AS
BEGIN
DECLARE @Start  int
DECLARE @End    int
DECLARE @Length int

set @HTMLText = replace(@htmlText, '<br>',CHAR(13) + CHAR(10))
set @HTMLText = replace(@htmlText, '<br/>',CHAR(13) + CHAR(10))
set @HTMLText = replace(@htmlText, '<br />',CHAR(13) + CHAR(10))
set @HTMLText = replace(@htmlText, '<li>','- ')
set @HTMLText = replace(@htmlText, '</li>',CHAR(13) + CHAR(10))

set @HTMLText = replace(@htmlText, '&rsquo;' collate Latin1_General_CS_AS, ''''  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&quot;' collate Latin1_General_CS_AS, '"'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&amp;' collate Latin1_General_CS_AS, '&'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&euro;' collate Latin1_General_CS_AS, '€'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&lt;' collate Latin1_General_CS_AS, '<'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&gt;' collate Latin1_General_CS_AS, '>'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&oelig;' collate Latin1_General_CS_AS, 'oe'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&nbsp;' collate Latin1_General_CS_AS, ' '  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&copy;' collate Latin1_General_CS_AS, '©'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&laquo;' collate Latin1_General_CS_AS, '«'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&reg;' collate Latin1_General_CS_AS, '®'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&plusmn;' collate Latin1_General_CS_AS, '±'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&sup2;' collate Latin1_General_CS_AS, '²'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&sup3;' collate Latin1_General_CS_AS, '³'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&micro;' collate Latin1_General_CS_AS, 'µ'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&middot;' collate Latin1_General_CS_AS, '·'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&ordm;' collate Latin1_General_CS_AS, 'º'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&raquo;' collate Latin1_General_CS_AS, '»'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&frac14;' collate Latin1_General_CS_AS, '¼'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&frac12;' collate Latin1_General_CS_AS, '½'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&frac34;' collate Latin1_General_CS_AS, '¾'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&Aelig' collate Latin1_General_CS_AS, 'Æ'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&Ccedil;' collate Latin1_General_CS_AS, 'Ç'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&Egrave;' collate Latin1_General_CS_AS, 'È'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&Eacute;' collate Latin1_General_CS_AS, 'É'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&Ecirc;' collate Latin1_General_CS_AS, 'Ê'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&Ouml;' collate Latin1_General_CS_AS, 'Ö'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&agrave;' collate Latin1_General_CS_AS, 'à'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&acirc;' collate Latin1_General_CS_AS, 'â'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&auml;' collate Latin1_General_CS_AS, 'ä'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&aelig;' collate Latin1_General_CS_AS, 'æ'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&ccedil;' collate Latin1_General_CS_AS, 'ç'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&egrave;' collate Latin1_General_CS_AS, 'è'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&eacute;' collate Latin1_General_CS_AS, 'é'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&ecirc;' collate Latin1_General_CS_AS, 'ê'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&euml;' collate Latin1_General_CS_AS, 'ë'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&icirc;' collate Latin1_General_CS_AS, 'î'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&ocirc;' collate Latin1_General_CS_AS, 'ô'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&ouml;' collate Latin1_General_CS_AS, 'ö'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&divide;' collate Latin1_General_CS_AS, '÷'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&oslash;' collate Latin1_General_CS_AS, 'ø'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&ugrave;' collate Latin1_General_CS_AS, 'ù'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&uacute;' collate Latin1_General_CS_AS, 'ú'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&ucirc;' collate Latin1_General_CS_AS, 'û'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&uuml;' collate Latin1_General_CS_AS, 'ü'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&quot;' collate Latin1_General_CS_AS, '"'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&amp;' collate Latin1_General_CS_AS, '&'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&lsaquo;' collate Latin1_General_CS_AS, '<'  collate Latin1_General_CS_AS)
set @HTMLText = replace(@htmlText, '&rsaquo;' collate Latin1_General_CS_AS, '>'  collate Latin1_General_CS_AS)


-- Remove anything between <STYLE> tags
SET @Start = CHARINDEX('<STYLE', @HTMLText)
SET @End = CHARINDEX('</STYLE>', @HTMLText, CHARINDEX('<', @HTMLText)) + 7
SET @Length = (@End - @Start) + 1

WHILE (@Start > 0 AND @End > 0 AND @Length > 0) BEGIN
SET @HTMLText = STUFF(@HTMLText, @Start, @Length, '')
SET @Start = CHARINDEX('<STYLE', @HTMLText)
SET @End = CHARINDEX('</STYLE>', @HTMLText, CHARINDEX('</STYLE>', @HTMLText)) + 7
SET @Length = (@End - @Start) + 1
END

-- Remove anything between <whatever> tags
SET @Start = CHARINDEX('<', @HTMLText)
SET @End = CHARINDEX('>', @HTMLText, CHARINDEX('<', @HTMLText))
SET @Length = (@End - @Start) + 1

WHILE (@Start > 0 AND @End > 0 AND @Length > 0) BEGIN
SET @HTMLText = STUFF(@HTMLText, @Start, @Length, '')
SET @Start = CHARINDEX('<', @HTMLText)
SET @End = CHARINDEX('>', @HTMLText, CHARINDEX('<', @HTMLText))
SET @Length = (@End - @Start) + 1
END

RETURN LTRIM(RTRIM(@HTMLText))

END