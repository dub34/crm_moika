<?php

use yii\db\Schema;
use yii\db\Migration;

class m160702_123455_add_stored_procedure extends Migration
{
    public function up()
    {

        $this->execute('update service set price = price/10000');
        $this->execute('update service_history set price = price/10000');
                $sql = <<<SQL
    CREATE PROCEDURE `actual_ticket_services`(IN ticket_id INTEGER)
BEGIN
select
        count(1) AS `count`,
        `sh`.`id` AS `id`,
        `sh`.`version` AS `version`,
        `sh`.`price` AS `price`,
        sum(`sh`.`price`) AS `sum_price`,
        `sh`.`name` AS `name`,
        `sh`.`version_created_by` AS `version_created_by`,
        `sh`.`version_created_at` AS `version_created_at`,
        `sh`.`version_comment` AS `version_comment`,
        `sh`.`description` AS `description`,
        `sh`.`nds` AS `nds`,
        `t`.`contract_id` AS `contract_id`,
        `t`.`id` AS `ticket_id`,
        `t`.`closed_at` AS `closed_at`
    from
        ((`ticket_has_service` `ts`
        left join `ticket` `t` ON ((`ts`.`ticket_id` = `t`.`id`)))
        left join `service_history` `sh` ON (((`sh`.`id` = `ts`.`service_id`)
            and (`ts`.`version_id` = `sh`.`version`))))
 where `t`.id = ticket_id
    group by `sh`.`name`;
END
SQL;
        $this->execute($sql);
        $this->execute('update payment set payment_sum = payment_sum/10000');
    }

    public function down()
    {

    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
