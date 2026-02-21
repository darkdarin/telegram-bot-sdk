<?php

namespace DarkDarin\TelegramBotSdk\TransportClient;

use Argo\RestClient\RestMethodDefinition;
use Argo\RestClient\RestRequestFactory;
use Argo\Serializer\JsonEncoder\JsonEncoder;
use DarkDarin\TelegramBotSdk\Attribute\MultipartRequest;
use Http\Message\MultipartStream\MultipartStreamBuilder;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;

class TelegramRequestFactory extends RestRequestFactory implements TelegramRequestFactoryInterface
{
    private string $token = '';

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function makeRequest(RestMethodDefinition $methodDefinition): RequestInterface
    {
        $multipartRequest = $methodDefinition->methodDefinition->attributes->getByType(MultipartRequest::class);
        if (!empty($multipartRequest)) {
            $request = $this->makeMultipartRequest($methodDefinition, $multipartRequest);
        } else {
            $request = $this->makeJsonRequest($methodDefinition);
        }

        return $request->withHeader('Authorization', sprintf('Bearer %s', $this->token));
    }

    protected function makeJsonRequest(RestMethodDefinition $methodDefinition): RequestInterface
    {
        $data = $this->parametersMapper->getNamedArguments($method, $parameters);

        $dataStream = $this->streamFactory->createStream(
            $this->serializer->serialize((object) $data, 'json'),
        );

        return $this->requestFactory
            ->createRequest('POST', $this->getUrl($token, $this->getMethodName($method)))
            ->withBody($dataStream)
            ->withHeader('Content-Type', 'application/json');
    }

    /**
     * @throws \ReflectionException
     */
    protected function makeMultipartRequest(RestMethodDefinition $methodDefinition): RequestInterface
    {
        $data = $this->parametersMapper->getNamedArguments($method, $parameters);

        $builder = new MultipartStreamBuilder($this->streamFactory);

        foreach ($data as $fieldName => $value) {
            if ($fieldName === $multipartField && $value instanceof StreamInterface) {
                $builder->addResource($fieldName, $value);
            } elseif ($value !== null) {
                $normalizedValue = $this->serializer->normalize(
                    $this->normalizeValue($value, $builder),
                    JsonEncoder::FORMAT,
                );

                if (is_array($normalizedValue) || is_object($normalizedValue)) {
                    $builder->addResource(
                        $fieldName,
                        $this->streamFactory->createStream(
                            $this->serializer->encode($normalizedValue, JsonEncoder::FORMAT),
                        ),
                        ['headers' => ['Content-Type' => 'application/json']],
                    );
                } else {
                    $builder->addResource(
                        $fieldName,
                        $this->streamFactory->createStream($normalizedValue),
                        ['headers' => ['Content-Type' => 'text/plain']],
                    );
                }
            }
        }

        return $this->requestFactory
            ->createRequest('POST', $this->getUrl($token, $this->getMethodName($method)))
            ->withBody($builder->build())
            ->withHeader('Content-Type', 'multipart/form-data; boundary="' . $builder->getBoundary() . '"');
    }

    public function getUrl(string $url, RestMethodDefinition $methodDefinition): string
    {
        return sprintf(
            '%s/bot%s/%s',
            trim(self::BASE_URL, '/'),
            $this->token,
            $method,
        );
    }
}
