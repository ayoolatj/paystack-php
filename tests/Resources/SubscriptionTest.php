<?php

namespace Tests\Resources;

use Ayoolatj\Paystack\Resources\BaseResource;
use Ayoolatj\Paystack\Resources\Subscription;
use Ayoolatj\Paystack\Services\Service;
use Mockery;
use PHPUnit\Framework\TestCase;

class SubscriptionTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testGetRoot()
    {
        $s = Mockery::mock(Service::class);
        $r = new Subscription([], $s);

        $this->assertSame('/subscription', $r->getRoot());
    }

    /**
     * @dataProvider subscriptionProvider
     */
    public function testResourceMethods($method, $response)
    {
        $s = Mockery::mock(Service::class);
        $attributes = [
            'subscription_code' => '10',
            'email_token' => 'token'
        ];
        $p = new Subscription($attributes, $s);
        $query = ['code' => '10', 'token' => 'token'];

        $s->shouldReceive($method)->with($query)->andReturn($response);
        $r = $p->$method();

        $this->assertSame($response, $r);
    }

    public function subscriptionProvider()
    {
        $bR = Mockery::mock(BaseResource::class);

        return [
            ['enable', $bR],
            ['disable', $bR],
        ];
    }
}
