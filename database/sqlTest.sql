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
WHERE sesMsgID = 'clt19-resolved-fc5e238c11b1a50da980'
ORDER BY ;


