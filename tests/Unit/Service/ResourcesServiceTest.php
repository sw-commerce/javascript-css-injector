<?php

namespace SwCommerce\JavascriptCSSInjector\Test\Unit\Service;

use PHPUnit\Framework\TestCase;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\EntitySearchResult;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use SwCommerce\JavascriptCSSInjector\Service\ResourcesService;
use SwCommerce\JavascriptCSSInjector\Core\Content\CodeSnippet\CodeSnippetEntity;
use SwCommerce\JavascriptCSSInjector\Core\Content\CodeSnippet\CodeSnippetCollection;

class ResourcesServiceTest extends TestCase
{
    private EntityRepository $repo;
    private ResourcesService $svc;
    private SalesChannelContext $salesChannelContext;

    protected function setUp(): void
    {
        parent::setUp();

        // stub repository
        $this->repo = $this->createMock(EntityRepository::class);
        $this->svc  = new ResourcesService($this->repo);

        $context = Context::createDefaultContext();
        $this->salesChannelContext = $this->createMock(SalesChannelContext::class);
        $this->salesChannelContext
            ->method('getSalesChannelId')
            ->willReturn('dummy-channel-id');
        $this->salesChannelContext
            ->method('getContext')
            ->willReturn($context);
    }

    private function makeSearchResult(array $entities): EntitySearchResult
    {
        return new EntitySearchResult(
            'sw_commerce_code_snippet',
            count($entities),
            new CodeSnippetCollection($entities),
            null,
            new Criteria(),
            $this->salesChannelContext->getContext()
        );
    }

    public function testReturnsAllWhenNoPatterns(): void
    {
        $this->assertSame(true, true);
        $snippet = new CodeSnippetEntity();

        $snippet->setId(Uuid::randomHex());
        $snippet->setCss('body { color: red; }');
        $snippet->setRenderPages([]); // no filter

        $this->repo
            ->expects($this->once())
            ->method('search')
            ->willReturn($this->makeSearchResult([$snippet]));

        $out = $this->svc->getResources(ResourcesService::CSS, $this->salesChannelContext, '/anything');
        $this->assertSame("body { color: red; }\n", $out);
    }

    public function testFiltersByPatternMatching(): void
    {
        $snippet = new CodeSnippetEntity();
        $snippet->setId(Uuid::randomHex());
        $snippet->setJs('console.log("hi");');
        $snippet->setRenderPages(['/foo']);

        $this->repo
            ->method('search')
            ->willReturn($this->makeSearchResult([$snippet]));

        // matching path
        $yes = $this->svc->getResources(ResourcesService::JS, $this->salesChannelContext, '/foo/bar');
        $this->assertSame("console.log(\"hi\");\n", $yes);

        // non-matching path
        $no = $this->svc->getResources(ResourcesService::JS, $this->salesChannelContext, '/bar');
        $this->assertSame('', $no);
    }

        public function testNilWhenPathNullAndHavePatterns(): void
    {
        $snippet = new CodeSnippetEntity();
        $snippet->setId(Uuid::randomHex());
        $snippet->setCss('h1 { }');
        $snippet->setRenderPages(['/']); // pattern exists

        $this->repo
            ->method('search')
            ->willReturn($this->makeSearchResult([$snippet]));

        $out = $this->svc->getResources(ResourcesService::CSS, $this->salesChannelContext, null);
        $this->assertSame('', $out);
    }
}
