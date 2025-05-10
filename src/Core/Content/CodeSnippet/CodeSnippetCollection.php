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

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @extends EntityCollection<CodeSnippetEntity>
 */
class CodeSnippetCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return CodeSnippetEntity::class;
    }
}
