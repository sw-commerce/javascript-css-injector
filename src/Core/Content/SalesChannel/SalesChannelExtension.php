<?php

/**
 * @copyright © SWCOMMERCE
 *
 * Contact SWCommerce:
 * E-mail: help@swcommerce.com
 * https://swcommerce.com/
 */

declare(strict_types=1);

namespace SwCommerce\JavascriptCSSInjector\Core\Content\SalesChannel;

use Shopware\Core\Framework\DataAbstractionLayer\EntityExtension;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Inherited;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\System\SalesChannel\SalesChannelDefinition;
use SwCommerce\JavascriptCSSInjector\Core\Content\CodeSnippet\Aggregate\CodeSnippetSalesChannelDefinition;
use SwCommerce\JavascriptCSSInjector\Core\Content\CodeSnippet\CodeSnippetDefinition;

class SalesChannelExtension extends EntityExtension
{
    public function extendFields(FieldCollection $collection): void
    {
        $collection->add(
            (new ManyToManyAssociationField(
                'swCommerceJavascriptCssInjector',
                CodeSnippetDefinition::class,
                CodeSnippetSalesChannelDefinition::class,
                'sales_channel_id',
                'sw_commerce_code_snippet_id'
            ))->addFlags(new Inherited())
        );
    }

    public function getDefinitionClass(): string
    {
        return SalesChannelDefinition::class;
    }
}
