<?php

/**
 * @copyright © SWCOMMERCE
 *
 * Contact SWCommerce:
 * E-mail: help@swcommerce.com
 * https://swcommerce.com/
 */

declare(strict_types=1);

namespace SwCommerce\JavascriptCSSInjector\Service;

use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\EntitySearchResult;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\OrFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\RangeFilter;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use SwCommerce\JavascriptCSSInjector\Core\Content\CodeSnippet\CodeSnippetCollection;
use SwCommerce\JavascriptCSSInjector\Core\Content\CodeSnippet\CodeSnippetEntity;

final class ResourcesService
{
    public const string CSS = 'css';
    public const string JS = 'js';

    /**
     * @param EntityRepository<CodeSnippetCollection> $swCommerceCodeSnippetRepository
     */
    public function __construct(
        private readonly EntityRepository $swCommerceCodeSnippetRepository
    ) {
    }

    public function getResources(string $field, SalesChannelContext $context, ?string $path = null): string
    {
        $out = '';

        /** @var CodeSnippetEntity $snippet */
        foreach ($this->getSnippets($context) as $snippet) {
            $content = $snippet->get($field) ?? '';
            $patterns = $snippet->getRenderPages();

            if ([] === $patterns) {
                $out .= $content . \PHP_EOL;

                continue;
            }

            if (null === $path) {
                continue;
            }

            foreach ($patterns as $pattern) {
                $pattern = trim((string) $pattern);
                if ('' === $pattern) {
                    continue;
                }

                $matched = ('/' === $pattern && '/' === $path) || str_contains($path, $pattern);

                if ($matched) {
                    $out .= $content . \PHP_EOL;

                    break;
                }
            }
        }

        return $out;
    }

    /**
     * @return EntitySearchResult<CodeSnippetCollection>
     */
    private function getSnippets(SalesChannelContext $context): EntitySearchResult
    {
        $criteria = new Criteria();

        $now = (new \DateTimeImmutable())->format('Y-m-d H:i:s');

        $criteria->addFilter(
            new EqualsFilter('active', true),
        );

        $criteria->addFilter(
            new EqualsFilter('salesChannels.id', $context->getSalesChannelId())
        );

        // active_from is null or <= now
        $criteria->addFilter(
            new OrFilter([
                new EqualsFilter('activeFrom', null),
                new RangeFilter('activeFrom', [RangeFilter::LTE => $now]),
            ])
        );

        // active_to is null or >= now
        $criteria->addFilter(
            new OrFilter([
                new EqualsFilter('activeTo', null),
                new RangeFilter('activeTo', [RangeFilter::GTE => $now]),
            ])
        );

        $criteria->addAssociation('salesChannels');

        return $this->swCommerceCodeSnippetRepository->search($criteria, $context->getContext());
    }
}
