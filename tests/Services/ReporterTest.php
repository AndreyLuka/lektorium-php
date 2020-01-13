<?php

namespace App\Tests\Services;

use App\Services\Reporter;
use App\Services\SlugService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ReporterTest extends TestCase
{
    /**
     * @var Reporter
     */
    private $reporter;

    /**
     * @var HttpClientInterface|MockObject
     */
    private $httpClient;

    /**
     * @var SlugService|MockObject
     */
    private $slugService;

    public function setUp()
    {
        $this->httpClient = $this->getMockBuilder(HttpClientInterface::class)->getMock();
        $this->slugService = $this->getMockBuilder(SlugService::class)->getMock();

        $this->reporter = new Reporter($this->httpClient, $this->slugService);
    }

    public function testReportNewRegistration()
    {
        $this->httpClient->expects($this->once())->method('request');
        $this->slugService->expects($this->once())->method('slugify');

        $this->reporter->reportNewRegistration(1);
    }

    public function testSlugifyForReport()
    {
        $this->slugService->expects($this->once())->method('slugify')->willReturn('test-text');

        $result = $this->reporter->slugifyForReport('Test Text');

        $this->assertSame('test-text', $result);
    }
}
