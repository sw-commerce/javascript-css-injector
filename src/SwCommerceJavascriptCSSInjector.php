<?php

/**
 * @copyright © SWCOMMERCE
 *
 * Contact SWCommerce:
 * E-mail: help@swcommerce.com
 * https://swcommerce.com/
 */

declare(strict_types=1);

namespace SwCommerce\JavascriptCSSInjector;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;

class SwCommerceJavascriptCSSInjector extends Plugin
{
    public function uninstall(UninstallContext $uninstallContext): void
    {
        if (null === $this->container) {
            throw new \RuntimeException('No container set');
        }

        if (!$uninstallContext->keepUserData()) {
            /** @var Connection $connection */
            $connection = $this->container->get(Connection::class);

            $connection->executeStatement(
                'DROP TABLE IF EXISTS `sw_commerce_code_snippet_sales_channel`;'
            );
            $connection->executeStatement(
                'DROP TABLE IF EXISTS `sw_commerce_code_snippet`;'
            );
        }
    }
}
