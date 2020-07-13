<?php

namespace Tests\Support;

use ArrayIterator;
use Ayoolatj\Paystack\Http\Response;
use Ayoolatj\Paystack\Services\Service;
use Ayoolatj\Paystack\Support\Paginator;
use Mockery;
use PHPUnit\Framework\TestCase;

class PaginatorTest extends TestCase
{
    /**
     * @var \Ayoolatj\Paystack\Services\Service|\Mockery\LegacyMockInterface|\Mockery\MockInterface
     */
    private $s;

    /**
     * @var string[]
     */
    private $meta;

    public function setUp(): void
    {
        $this->s = Mockery::mock(Service::class);
        $this->s->shouldReceive('getLastResponse')->andReturn(
            new Response('{"status":true,"message":"a","data":{"a":"b"}}', 200, [])
        );
        $this->s->shouldReceive('getLastRequest')->zeroOrMoreTimes()->andReturn(['params' => []]);

        $this->meta = [
            'total' => '3',
            'perPage' => '2',
            'page' => '1',
            'pageCount' => '2',
        ];
        $this->s->shouldReceive('all')->zeroOrMoreTimes()->andReturn(
            new Paginator(['3'], array_merge($this->meta, ['page' => '2']), $this->s)
        );
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testArrayAccessOffsetExists()
    {
        $p = new Paginator(['foo', 'bar'], $this->meta, $this->s);
        $this->assertTrue($p->offsetExists(0));
        $this->assertTrue($p->offsetExists(1));
        $this->assertFalse($p->offsetExists(1000));
    }

    public function testArrayAccessOffsetGet()
    {
        $p = new Paginator(['foo', 'bar'], $this->meta, $this->s);
        $this->assertSame('foo', $p->offsetGet(0));
        $this->assertSame('bar', $p->offsetGet(1));
    }

    public function testArrayAccessOffsetSet()
    {
        $p = new Paginator(['foo', 'bar'], $this->meta, $this->s);

        $p->offsetSet(1, 'bar');
        $this->assertSame('bar', $p[1]);

        $p->offsetSet(null, 'qux');
        $this->assertSame('qux', $p[2]);
    }

    public function testArrayAccessOffsetUnset()
    {
        $p = new Paginator(['foo', 'bar'], $this->meta, $this->s);

        $p->offsetUnset(1);
        $this->assertFalse(isset($p[1]));
    }

    public function testCountable()
    {
        $p = new Paginator(['foo', 'bar'], $this->meta, $this->s);
        $this->assertCount(2, $p);
    }

    public function testIterable()
    {
        $p = new Paginator(['foo', 'bar'], $this->meta, $this->s);
        $this->assertInstanceOf(ArrayIterator::class, $p->getIterator());
    }

    public function testArrayable()
    {
        $p = new Paginator(['foo', 'bar'], $this->meta, $this->s);

        $this->assertSame(
            [
                'data' => ['foo', 'bar'],
                'page' => '1',
                'perPage' => '2',
                'total' => '3',
                'pageCount' => '2',
            ],
            $p->toArray()
        );
    }

    public function testJsonSerialize()
    {
        $p = new Paginator(['foo', 'bar'], $this->meta, $this->s);

        $this->assertSame(
            [
                'data' => ['foo', 'bar'],
                'page' => '1',
                'perPage' => '2',
                'total' => '3',
                'pageCount' => '2',
            ],
            $p->jsonSerialize()
        );
    }

    public function testAutoPagingIterator()
    {
        $p = new Paginator(['1', '2'], $this->meta, $this->s);

        $items = [];

        foreach ($p->autoPagingIterator() as $item) {
            $items[] = $item;
        }

        $this->assertSame(['1', '2', '3'], $items);
    }

    public function testAutoPagingIteratorSupportsIteratorToArray()
    {
        $p = new Paginator(['1', '2'], $this->meta, $this->s);

        $items = [];

        foreach (iterator_to_array($p->autoPagingIterator()) as $item) {
            $items[] = $item;
        }

        $this->assertSame(['1', '2', '3'], $items);
    }

    public function testNextPage()
    {
        $p = new Paginator(['1', '2'], $this->meta, $this->s);

        $nextPage = $p->nextPage();

        $this->assertNotSame($nextPage, $p);
        $this->assertSame(
            [
                'data' => ['3'],
                'page' => '2',
                'perPage' => '2',
                'total' => '3',
                'pageCount' => '2',
            ],
            $nextPage->toArray()
        );
    }

    public function testGetLastResponse()
    {
        $p = new Paginator(['1', '2'], $this->meta, $this->s);

        $response = $p->getLastResponse();

        $this->assertTrue($response->getStatus());
        $this->assertSame('a', $response->getMessage());
        $this->assertSame(200, $response->code);
        $this->assertEmpty($response->headers);
    }

    public function testGetLastRequest()
    {
        $p = new Paginator(['1', '2'], $this->meta, $this->s);
        $this->assertIsArray($p->getLastRequest());
    }
}
