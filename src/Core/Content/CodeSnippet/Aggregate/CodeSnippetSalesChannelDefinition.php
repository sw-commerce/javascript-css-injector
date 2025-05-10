<?php

/**
 * @copyright © SWCOMMERCE
 *
 * Contact SWCommerce:
 * E-mail: help@swcommerce.com
 * https://swcommerce.com/
 */

declare(strict_types=1);

namespace SwCommerce\JavascriptCSSInjector\Core\Content\CodeSnippet\Aggregate;

use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\MappingEntityDefinition;
use Shopware\Core\System\SalesChannel\SalesChannelDefinition;
use SwCommerce\JavascriptCSSInjector\Core\Content\CodeSnippet\CodeSnippetDefinition;

class CodeSnippetSalesChannelDefinition extends MappingEntityDefinition
{
    public const ENTITY_NAME = 'sw_commerce_code_snippet_sales_channel';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new FkField(
                'sw_commerce_code_snippet_id',
                'swCommerceJavascriptCssInjectorId',
                CodeSnippetDefinition::class
            ))->addFlags(
                new PrimaryKey(),
                new Required()
            ),

            (new FkField(
                'sales_channel_id',
                'salesChannelId',
                SalesChannelDefinition::class
            ))->addFlags(
                new PrimaryKey(),
                new Required()
            ),

            new ManyToOneAssociationField(
                'swCommerceJavascriptCssInjector',
                'sw_commerce_code_snippet_id',
                CodeSnippetDefinition::class
            ),

            new ManyToOneAssociationField(
                'salesChannel',
                'sales_channel_id',
                SalesChannelDefinition::class
            ),
        ]);
    }
}
