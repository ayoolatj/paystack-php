<?php

namespace Tests\Resources;

use Ayoolatj\Paystack\Resources\BaseResource;
use Ayoolatj\Paystack\Services\Service;
use Mockery;
use PHPUnit\Framework\TestCase;

class BaseResourceTest extends TestCase
{
    /**
     * @var \Ayoolatj\Paystack\Services\Service|\Mockery\LegacyMockInterface|\Mockery\MockInterface
     */
    private $s;

    public function setUp(): void
    {
        $this->s = Mockery::mock(Service::class);
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testResourceFillsAttributes()
    {
        $r = new BaseResource(['foo' => '1', 'bar' => '2'], $this->s);

        $this->assertObjectHasAttribute('foo', $r);
        $this->assertObjectHasAttribute('bar', $r);
        $this->assertSame('1', $r->foo);
        $this->assertSame('2', $r->bar);
    }

    public function testResourceAttributeCamelCased()
    {
        $r = new BaseResource(['foo_bar' => '1', 'bar_foo' => '2'], $this->s);

        $this->assertObjectHasAttribute('fooBar', $r);
        $this->assertObjectHasAttribute('barFoo', $r);
    }

    public function testResourceGetRoot()
    {
        $r = new class($this->s) extends BaseResource {
            protected $root = 'tunji';

            public function __construct($s)
            {
                parent::__construct([], $s);
            }
        };

        $this->assertSame('tunji', $r->getRoot());
    }

    public function testArrayAccessOffsetExists()
    {
        $p = new BaseResource(['foo', 'bar'], $this->s);
        $this->assertTrue($p->offsetExists(0));
        $this->assertTrue($p->offsetExists(1));
        $this->assertFalse($p->offsetExists(1000));
    }

    public function testArrayAccessOffsetGet()
    {
        $p = new BaseResource(['foo', 'bar'], $this->s);
        $this->assertSame('foo', $p->offsetGet(0));
        $this->assertSame('bar', $p->offsetGet(1));
    }

    public function testArrayAccessOffsetSet()
    {
        $p = new BaseResource(['foo', 'bar'], $this->s);

        $p->offsetSet(1, 'bar');
        $this->assertSame('bar', $p[1]);
    }

    public function testArrayAccessOffsetUnset()
    {
        $p = new BaseResource(['foo', 'bar'], $this->s);

        $p->offsetUnset(1);
        $this->assertFalse(isset($p[1]));
    }

    public function testArrayable()
    {
        $p = new BaseResource(['foo', 'bar'], $this->s);

        $this->assertSame(
            ['foo', 'bar'],
            $p->toArray()
        );
    }
}
