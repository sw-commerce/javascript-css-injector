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

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;
use Shopware\Core\System\SalesChannel\SalesChannelCollection;

class CodeSnippetEntity extends Entity
{
    use EntityIdTrait;

    protected string $name;

    protected string $description;

    protected string $css;

    protected string $js;

    /**
     * @var array<string>
     */
    protected array $renderPages;

    protected ?\DateTimeImmutable $activeFrom;
    protected ?\DateTimeImmutable $activeTo;

    protected ?SalesChannelCollection $salesChannels = null;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getSalesChannels(): ?SalesChannelCollection
    {
        return $this->salesChannels;
    }

    public function setSalesChannels(?SalesChannelCollection $salesChannels): void
    {
        $this->salesChannels = $salesChannels;
    }

    /**
     * @return array<string>
     */
    public function getRenderPages(): array
    {
        return $this->renderPages;
    }

    /**
     * @param array<string> $renderPages
     */
    public function setRenderPages(array $renderPages): void
    {
        $this->renderPages = $renderPages;
    }

    public function getActiveFrom(): ?\DateTimeImmutable
    {
        return $this->activeFrom;
    }

    public function setActiveFrom(?\DateTimeImmutable $activeFrom): void
    {
        $this->activeFrom = $activeFrom;
    }

    public function getActiveTo(): ?\DateTimeImmutable
    {
        return $this->activeTo;
    }

    public function setActiveTo(?\DateTimeImmutable $activeTo): void
    {
        $this->activeTo = $activeTo;
    }

    public function getCss(): string
    {
        return $this->css;
    }

    public function setCss(string $css): void
    {
        $this->css = $css;
    }

    public function getJs(): string
    {
        return $this->js;
    }

    public function setJs(string $js): void
    {
        $this->js = $js;
    }
}
