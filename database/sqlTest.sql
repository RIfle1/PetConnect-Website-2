SELECT * FROM client ORDER BY cltUsername;

SELECT * FROM client ORDER BY cltFirstName desc;

SELECT DISTINCT sesMsgID, sesMsgStartDate ,sesMsgEndDate, cltUsername  FROM session_message
INNER JOIN client_message cm on session_message.sesMsgID = cm.Session_Message_sesMsgID
LEFT JOIN admin_message am on session_message.sesMsgID = am.Session_Message_sesMsgID
INNER JOIN client c on cm.Client_cltID = c.cltID
WHERE sesMsgID LIKE '%resolved%'
ORDER BY sesMsgEndDate;


SELECT distinct sesMsgID, cltMsgID, admMsgID As 'MessageID' FROM session_message
                                                 INNER JOIN client_message cm on session_message.sesMsgID = cm.Session_Message_sesMsgID
                                                 INNER JOIN admin_message am on session_message.sesMsgID = am.Session_Message_sesMsgID
WHERE sesMsgID = 'clt19-resolved-fc5e238c11b1a50da980';

DELETE FROM session_message WHERE sesMsgEndDate between '0-0-0' AND '2022-12-13' AND sesMsgID LIKE '%resolved%';

SELECT adrID, adrAddress, adrAddressOptional, adrPostalCode, adrCity FROM address
                                                                              INNER JOIN client c on address.Client_cltID = c.cltID
WHERE cltID = 'clt2';

UPDATE address SET adrDefault = 0 WHERE Client_cltID = 'clt2'; UPDATE address SET adrDefault = 1 WHERE adrID = 'adr777ed5eea5e58791cf519775d1b0818f'

SELECT prdID, prcColor FROM product
INNER JOIN product_color pc on product.prdID = pc.Product_prdID;