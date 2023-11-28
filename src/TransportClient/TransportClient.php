<?php

namespace DarkDarin\TelegramBotSdk\TransportClient;

use DarkDarin\Serializer\ApiSerializer\ApiSerializerInterface;
use DarkDarin\Serializer\MethodParametersSerializer\MethodParametersMapperInterface;
use DarkDarin\TelegramBotSdk\DTO\Response;
use DarkDarin\TelegramBotSdk\Exceptions\TelegramException;
use Http\Message\MultipartStream\MultipartStreamBuilder;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class TransportClient implements TransportClientInterface
{
    private const BASE_URL = 'https://api.telegram.org';

    public function __construct(
        private readonly ClientInterface $client,
        private readonly RequestFactoryInterface $requestFactory,
        private readonly StreamFactoryInterface $streamFactory,
        private readonly ApiSerializerInterface $serializer,
        private readonly MethodParametersMapperInterface $parametersMapper,
        private ?string $token = null,
    ) {}

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * @template TObject of object
     * @template TType of string|class-string<TObject>
     * @param string $method
     * @param array $parameters
     * @param class-string<TType>|null $responseType
     * @param string|bool|null $multipartField
     * @psalm-return (TType is class-string<TObject> ? TObject : mixed)
     * @return mixed
     */
    public function executeMethod(
        string $method,
        array $parameters,
        ?string $responseType = null,
        string|bool|null $multipartField = null,
    ): mixed {
        try {
            if ($multipartField !== null) {
                $request = $this->makeMultipartRequest($method, $parameters, $multipartField);
            } else {
                $request = $this->makeJsonRequest($method, $parameters);
            }
            $rawResponse = $this->client->sendRequest($request);
            /** @var Response $response */
            $response = $this->serializer->deserialize($rawResponse->getBody()->getContents(), Response::class, 'json');

            if ($response->error_code !== null || $rawResponse->getStatusCode() !== 200) {
                throw new TelegramException(
                    $response->description ?? $rawResponse->getReasonPhrase(),
                    $response->error_code ?? $rawResponse->getStatusCode()
                );
            }

            if ($responseType === null || is_scalar($response->result)) {
                return $response->result;
            } else {
                return $this->serializer->denormalize($response->result, $responseType);
            }
        } catch (TelegramException $e) {
            throw $e;
        } catch (\Throwable $e) {
            throw new TelegramException($e->getMessage(), $e->getCode(), $e);
        }
    }

    protected function makeJsonRequest(string $method, array $parameters): RequestInterface
    {
        $data = $this->parametersMapper->getNamedArguments($method, $parameters);

        $dataStream = $this->streamFactory->createStream(
            $this->serializer->serialize((object)$data, 'json')
        );

        return $this->requestFactory
            ->createRequest('POST', $this->getUrl($this->getMethodName($method)))
            ->withBody($dataStream)
            ->withHeader('Content-Type', 'application/json');
    }

    /**
     * @throws ExceptionInterface
     * @throws \ReflectionException
     */
    protected function makeMultipartRequest(
        string $method,
        array $parameters,
        string|bool $multipartField
    ): RequestInterface {
        $data = $this->parametersMapper->getNamedArguments($method, $parameters);

        $builder = new MultipartStreamBuilder($this->streamFactory);

        foreach ($data as $fieldName => $value) {
            if ($fieldName === $multipartField && $value instanceof StreamInterface) {
                $builder->addResource($fieldName, $value);
            } elseif ($value !== null) {
                $normalizedValue = $this->normalizeValue($value, $builder);
                if (is_array($normalizedValue) || is_object($normalizedValue)) {
                    $builder->addResource(
                        $fieldName,
                        $this->streamFactory->createStream(
                            $this->serializer->encode($normalizedValue, 'json')
                        ),
                        ['headers' => ['Content-Type' => 'application/json']]
                    );
                } else {
                    $builder->addResource(
                        $fieldName,
                        $this->streamFactory->createStream($normalizedValue),
                        ['headers' => ['Content-Type' => 'text/plain']]
                    );
                }
            }
        }

        return $this->requestFactory
            ->createRequest('POST', $this->getUrl($this->getMethodName($method)))
            ->withBody($builder->build())
            ->withHeader('Content-Type', 'multipart/form-data; boundary="' . $builder->getBoundary() . '"');
    }

    private function getUrl(string $method): string
    {
        return sprintf(
            '%s/bot%s/%s',
            trim(self::BASE_URL, '/'),
            $this->token,
            $method
        );
    }

    private function getMethodName(string $method): string
    {
        [$_, $normalizedMethod] = explode('::', $method);

        return $normalizedMethod;
    }

    /**
     * @throws ExceptionInterface
     * @throws \ReflectionException
     */
    private function normalizeValue(mixed $value, MultipartStreamBuilder $builder): mixed
    {
        if ($value instanceof StreamInterface) {
            $fileName = uniqid('attach-');
            $builder->addResource($fileName, $value);

            return 'attach://' . $fileName;
        }

        if (is_scalar($value)) {
            return $value;
        }

        if (is_object($value)) {
            $properties = [];
            $reflection = new \ReflectionClass($value);
            foreach ($reflection->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
                $properties[$property->getName()] = $this->normalizeValue($property->getValue($value), $builder);
            }
            $value = new ($reflection->getName())(...$properties);
        }

        if (is_array($value)) {
            foreach ($value as $fieldName => $fieldValue) {
                $normalizedValue = $this->normalizeValue($fieldValue, $builder);
                $value[$fieldName] = $normalizedValue;
            }
        }

        return $this->serializer->normalize($value, 'json');
    }
}
