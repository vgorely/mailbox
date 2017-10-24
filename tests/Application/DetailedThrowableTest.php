<?php declare(strict_types = 1);

namespace Tests\HelloFresh\ShippingLabel\Common\Throwable;

use Mailbox\Domain\Throwable\DetailedThrowable;
use PHPUnit\Framework\TestCase;

final class DetailedThrowableTest extends TestCase
{
    /**
     * @return void
     */
    public function testThatItReturnsArray() : void
    {
        $throwable = new \Error('An error occurred', 0, new \Exception('An exception occurred'));
        $array = (new DetailedThrowable($throwable))->toArray();

        $this->assertEquals(2, count($array));

        $this->assertInternalType('array', $array[0]);
        $this->assertEquals(\Error::class, $array[0]['type']);
        $this->assertEquals(0, $array[0]['code']);
        $this->assertEquals('An error occurred', $array[0]['message']);
        $this->assertInternalType('string', $array[0]['file']);
        $this->assertInternalType('integer', $array[0]['line']);
        $this->assertInternalType('array', $array[0]['trace']);

        $this->assertInternalType('array', $array[1]);
        $this->assertEquals(\Exception::class, $array[1]['type']);
        $this->assertEquals(0, $array[1]['code']);
        $this->assertEquals('An exception occurred', $array[1]['message']);
        $this->assertInternalType('string', $array[1]['file']);
        $this->assertInternalType('integer', $array[1]['line']);
        $this->assertInternalType('array', $array[1]['trace']);
    }
}
