<?php

declare(strict_types=1);

namespace Netbums\Quickpay\Tests\Fakes;

use QuickPay\API\Request;
use QuickPay\API\Response;

/**
 * Records the calls a resource makes and answers with a canned response, so no request leaves the machine.
 */
class FakeRequest extends Request
{
    /** @var list<array{method: string, path: string, data: array<mixed>}> */
    public array $calls = [];

    public int $statusCode = 200;

    public string $body = '{}';

    public function get(string $path, array $query = []): Response
    {
        return $this->record('get', $path, $query);
    }

    public function post(string $path, array $form = []): Response
    {
        return $this->record('post', $path, $form);
    }

    public function put(string $path, array $form = []): Response
    {
        return $this->record('put', $path, $form);
    }

    public function patch(string $path, array $form = []): Response
    {
        return $this->record('patch', $path, $form);
    }

    public function delete(string $path, array $form = []): Response
    {
        return $this->record('delete', $path, $form);
    }

    /**
     * @return array{method: string, path: string, data: array<mixed>}
     */
    public function lastCall(): array
    {
        return $this->calls[array_key_last($this->calls)];
    }

    private function record(string $method, string $path, array $data): Response
    {
        $this->calls[] = ['method' => $method, 'path' => $path, 'data' => $data];

        return new Response($this->statusCode, '', '', $this->body);
    }
}
