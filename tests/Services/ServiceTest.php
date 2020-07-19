<?php

namespace Tests\Services;

use Ayoolatj\Paystack\Contracts\ClientInterface;
use Ayoolatj\Paystack\Http\Response;
use Ayoolatj\Paystack\Paystack;
use Ayoolatj\Paystack\Resources\BaseResource;
use Ayoolatj\Paystack\Services\Service;
use Ayoolatj\Paystack\Support\Paginator;
use Ayoolatj\Paystack\Traits\ServiceOperations\All;
use Ayoolatj\Paystack\Traits\ServiceOperations\Create;
use Ayoolatj\Paystack\Traits\ServiceOperations\Delete;
use Ayoolatj\Paystack\Traits\ServiceOperations\Fetch;
use Ayoolatj\Paystack\Traits\ServiceOperations\Update;
use PHPUnit\Framework\TestCase;

class ServiceTest extends TestCase
{
    /**
     * @var \Ayoolatj\Paystack\Services\Service
     */
    private $service;

    /**
     * @var \Ayoolatj\Paystack\Paystack
     */
    private $paystack;

    /**
     * @var \Ayoolatj\Paystack\Contracts\ClientInterface
     */
    private $client;

    public function setUp(): void
    {
        $this->client = new class implements ClientInterface {
            public function handleRequest($verb, $absUri, $params = [], $headers = [])
            {
                return [$this->response, $this->code, []];
            }
        };
        $this->paystack = new Paystack('sk_', $this->client);
        $this->service = new class($this->paystack) extends Service {
            use All, Create, Delete, Fetch, Update;

            protected $primaryResource = BaseResource::class;
        };
    }

    public function request($response, $code = 200)
    {
        $this->client->response = $response;
        $this->client->code = $code;
    }

    public function testListOperation()
    {
        $response = [
            'status' => true,
            'message' => 'Message',
            'data' => [
                [
                    'id' => 1,
                    'code' => 'asdf'
                ],
                [
                    'id' => 2,
                    'code' => 'asdf'
                ],
            ],
            'meta' =>  [
                'total' =>  2,
                'skipped' =>  0,
                'perPage' =>  50,
                'page' =>  1,
                'pageCount' =>  1
            ]
        ];
        $this->request(json_encode($response));

        $list = $this->service->all();

        $this->assertInstanceOf(Paginator::class, $list);
    }

    public function testCreateOperation()
    {
        $data = ['email' => 'test@example.com'];
        $response = [
            'status' => true,
            'message' => 'Message',
            'data' => array_merge([
                'id' => 1,
                'code' => 'asdf'
            ], $data),
        ];
        $this->request(json_encode($response));

        $resource = $this->service->create($data);

        $this->assertInstanceOf(BaseResource::class, $resource);
        $this->assertEquals($resource->getLastResponse(), new Response(
            json_encode($response),
            200,
            []
        ));
    }

    public function testDeleteOperation()
    {
        $response = [
            'status' => true,
            'message' => 'Deleted',
        ];
        $this->request(json_encode($response));

        $delete = $this->service->delete(1);

        $this->assertInstanceOf(Response::class, $delete);
        $this->assertEquals($delete, new Response(
            json_encode($response),
            200,
            []
        ));
    }

    public function testFetchOperation()
    {
        $response = [
            'status' => true,
            'message' => 'Message',
            'data' => [
                'id' => 1,
                'code' => 'asdf',
                'email' => 'test@example.com'
            ],
        ];
        $this->request(json_encode($response));

        $resource = $this->service->fetch(1);

        $this->assertInstanceOf(BaseResource::class, $resource);
        $this->assertEquals($resource->getLastResponse(), new Response(
            json_encode($response),
            200,
            []
        ));
    }

    public function testUpdateOperation()
    {
        $response = [
            'status' => true,
            'message' => 'Message',
            'data' => [
                'id' => 1,
                'code' => 'asdf',
                'email' => 'test@example.com'
            ],
        ];
        $this->request(json_encode($response));

        $resource = $this->service->update(1, ['email' => 'tunji@example.com']);

        $this->assertInstanceOf(BaseResource::class, $resource);
        $this->assertEquals($resource->getLastResponse(), new Response(
            json_encode($response),
            200,
            []
        ));
    }
}
