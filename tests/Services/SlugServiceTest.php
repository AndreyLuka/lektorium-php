<?php

namespace App\Tests\Services;

use App\Services\SlugService;
use PHPUnit\Framework\TestCase;

class SlugServiceTest extends TestCase
{
    /**
     * @var SlugService
     */
    private $slugService;

    public function setUp()
    {
        $this->slugService = new SlugService();
    }

    public function testSlugify()
    {
        $result = $this->slugService->slugify('Test Name');

        $this->assertNotNull($result);
        $this->assertSame('test-name', $result);
    }
}
