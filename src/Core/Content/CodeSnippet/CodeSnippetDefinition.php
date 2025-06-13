<?php

/**
 * @copyright © SWCOMMERCE
 *
 * Contact SWCommerce:
 * E-mail: help@swcommerce.com
 * https://swcommerce.com/
 */

declare(strict_types=1);

namespace SwCommerce\JavascriptCSSInjector\Core\Content\CodeSnippet;

use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\BoolField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\DateTimeField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\AllowHtml;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\ApiAware;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\SearchRanking;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ListField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\LongTextField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\System\SalesChannel\SalesChannelDefinition;
use SwCommerce\JavascriptCSSInjector\Core\Content\CodeSnippet\Aggregate\CodeSnippetSalesChannelDefinition;

class CodeSnippetDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'sw_commerce_code_snippet';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getEntityClass(): string
    {
        return CodeSnippetEntity::class;
    }

    public function getCollectionClass(): string
    {
        return CodeSnippetCollection::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField(
                'id',
                'id'
            ))->addFlags(
                new Required(),
                new PrimaryKey()
            ),

            (new StringField(
                'name',
                'name'
            ))->addFlags(
                new Required(),
                new SearchRanking(500)
            ),

            new LongTextField(
                'description',
                'description'
            ),

            new BoolField(
                'active',
                'active'
            ),

            (new ListField(
                'render_pages',
                'renderPages',
                StringField::class
            ))->addFlags(
                new ApiAware(),
                new SearchRanking(
                    SearchRanking::HIGH_SEARCH_RANKING
                )
            ),

            (new DateTimeField(
                'active_from',
                'activeFrom'
            )
            )->addFlags(
                new ApiAware(),
            ),

            (new DateTimeField(
                'active_to',
                'activeTo'
            )
            )->addFlags(
                new ApiAware(),
            ),

            (new LongTextField(
                'js',
                'js'
            ))->addFlags(
                new AllowHtml(false),
                new SearchRanking(SearchRanking::HIGH_SEARCH_RANKING)
            ),

            (new LongTextField(
                'css',
                'css'
            ))->addFlags(
                new AllowHtml(false),
                new SearchRanking(SearchRanking::HIGH_SEARCH_RANKING)
            ),

            new ManyToManyAssociationField(
                'salesChannels',
                SalesChannelDefinition::class,
                CodeSnippetSalesChannelDefinition::class,
                'sw_commerce_code_snippet_id',
                'sales_channel_id'
            ),
        ]);
    }
}
