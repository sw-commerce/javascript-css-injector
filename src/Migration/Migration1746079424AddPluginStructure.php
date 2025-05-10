<?php

/**
 * @copyright © SWCOMMERCE
 *
 * Contact SWCommerce:
 * E-mail: help@swcommerce.com
 * https://swcommerce.com/
 */

declare(strict_types=1);

namespace SwCommerce\JavascriptCSSInjector\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1746079424AddPluginStructure extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1746079424;
    }

    public function update(Connection $connection): void
    {
        $connection->executeStatement('
            CREATE TABLE IF NOT EXISTS `sw_commerce_code_snippet` (
                `id` BINARY(16) NOT NULL,
                `name` VARCHAR(255) NOT NULL,
                `js` LONGTEXT NULL,
                `css` LONGTEXT NULL,
                `description` LONGTEXT NULL,
                `active` BOOLEAN DEFAULT \'0\',
                `created_at` DATETIME(3) NOT NULL,
                `updated_at` DATETIME(3) NULL,
                `render_pages` JSON NULL,
                `active_from` DATETIME(3),
                `active_to` DATETIME(3),
                PRIMARY KEY (`id`),
                CONSTRAINT `json.sw_commerce_code_snippet.render_pages` CHECK (JSON_VALID(`render_pages`))
            ) ENGINE=InnoDB
              DEFAULT CHARSET=utf8mb4
              COLLATE=utf8mb4_unicode_ci;
        ');

        $connection->executeStatement('
            CREATE TABLE IF NOT EXISTS `sw_commerce_code_snippet_sales_channel` (
                `sw_commerce_code_snippet_id` BINARY(16) NOT NULL,
                `sales_channel_id` BINARY(16) NOT NULL,
                PRIMARY KEY (`sw_commerce_code_snippet_id`, `sales_channel_id`),
                CONSTRAINT `fk.css_injector_sc.injector_id` FOREIGN KEY (`sw_commerce_code_snippet_id`)
                    REFERENCES `sw_commerce_code_snippet` (`id`)
                    ON DELETE CASCADE
                    ON UPDATE CASCADE,
                CONSTRAINT `fk.css_injector_sc.sales_channel_id` FOREIGN KEY (`sales_channel_id`)
                    REFERENCES `sales_channel` (`id`)
                    ON DELETE CASCADE
                    ON UPDATE CASCADE
            ) ENGINE=InnoDB
              DEFAULT CHARSET=utf8mb4
              COLLATE=utf8mb4_unicode_ci;
        ');
    }
}
