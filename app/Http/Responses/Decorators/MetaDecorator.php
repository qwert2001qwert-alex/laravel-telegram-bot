<?php

namespace App\Http\Responses\Decorators;

use Flugg\Responder\Http\Responses\Decorators\ResponseDecorator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;

/**
 * Class EtagDecorator
 * @package App\Http\Responses\Decorators
 */
class MetaDecorator extends ResponseDecorator
{
    /**
     * Generate a JSON response.
     *
     * @param  array $data
     * @param  int   $status
     * @param  array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function make(array $data, int $status, array $headers = []): JsonResponse
    {
        $timestamp = date('c');
        $hash      = sha1($timestamp . json_encode($data));
        $eTag      = sha1($content ?? '');

        $dataPayload = Arr::pull($data, 'data');
        $errorPayload = Arr::pull($data, 'error');

        // Responder::success(... will not accept a Primitive object, so we wrap it in an array with the data key
        $dataPayload = ['data' => Arr::has($dataPayload, 'data') ? $dataPayload['data'] : $dataPayload];


        $jsonapi = [
            'jsonapi' => [
                'version' => '1.0',
            ],
        ];
        $meta = [
            'meta' => array_merge(
                [
                    'timestamp' => $timestamp,
                    'hash'      => $hash,
                ],
                $data
            )
        ];

        return $this->factory->make(
            array_merge($jsonapi, $errorPayload ? ['error' => $errorPayload] : $dataPayload, $meta),
            $status,
            array_merge($headers, ['E-Tag' => $eTag])
        );
    }
}
