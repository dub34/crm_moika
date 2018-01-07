DELIMITER $$
CREATE PROCEDURE `calculateBalanceValue`(IN cont_id INT, IN start_period text, OUT balance DOUBLE)
BEGIN
declare ticket_sum double;
declare pay_sum double;


IF (start_period IS NULL) THEN
SELECT coalesce(SUM(sum_price),0) INTO ticket_sum FROM actualServiceVersions WHERE contract_id=cont_id;
SELECT coalesce(SUM(payment_sum),0) INTO pay_sum FROM payment where contract_id=cont_id AND status<>0;
ELSE
SELECT coalesce(SUM(sum_price),0) INTO ticket_sum FROM actualServiceVersions WHERE contract_id=cont_id AND date_format(closed_at,'%Y-%m-%d') < start_period;
SELECT coalesce(SUM(payment_sum),0) INTO pay_sum FROM payment where contract_id=cont_id AND date_format(created_at,'%Y-%m-%d') < start_period AND status<>0;
END IF;

select pay_sum-ticket_sum into balance;

END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE `updateBalance`(IN cont_id INT)
BEGIN
declare ticket_sum INT;
declare payment_sum INT;

-- SELECT coalesce(SUM(price),0) INTO ticket_sum FROM actualServiceVersions WHERE contract_id=cont_id;

-- select SUM(p.payment_sum) INTO payment_sum FROM payment p WHERE p.contract_id = cont_id;

call calculateBalanceValue(cont_id,null,@balance);

UPDATE contract c SET balance = @balance WHERE id=cont_id;

END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE `allClientsTicketClose`(IN start_date text, IN stop_date text)
BEGIN
SELECT coalesce(SUM(price),0) as summ, date_format(closed_at,'%Y-%m') as closed_at FROM actualServiceVersions WHERE
date_format(closed_at,'%Y-%m-%d') BETWEEN start_date AND stop_date GROUP BY date_format(closed_at,'%Y-%m') ORDER BY closed_at;
END$$
DELIMITER ;