<?php

namespace Dusterio\LinkPreview\Readers;

use Dusterio\LinkPreview\Contracts\LinkInterface;
use Dusterio\LinkPreview\Contracts\ReaderInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\TransferStats;
use GuzzleHttp\Exception\ConnectException;

class HttpReader implements ReaderInterface
{
    private ?Client $client = null;

    private array $config;

    private CookieJar $jar;

    public function __construct(?array $config = null)
    {
        $this->jar = new CookieJar();

        $this->config = $config ?: [
            'allow_redirects' => ['max' => 10],
            'cookies' => $this->jar,
            'connect_timeout' => 5,
            'headers' => [
                'User-Agent' => 'dusterio/link-preview v1.2'
            ]
        ];
    }

    public function setTimeout(int $timeout): void
    {
        $this->config(['connect_timeout' => $timeout]);
    }

    public function config(array $parameters): void
    {
        foreach ($parameters as $key => $value) {
            $this->config[$key] = $value;
        }
    }

    public function getClient(): Client
    {
        if (is_null($this->client)) {
            $this->client = new Client();
        }

        return $this->client;
    }

    public function setClient(Client $client): void
    {
        $this->client = $client;
    }

    public function readLink(LinkInterface $link): LinkInterface
    {
        try {
            $response = $this->getClient()->request('GET', $link->getUrl(), array_merge($this->config, [
                'on_stats' => function (TransferStats $stats) use (&$link) {
                    $link->setEffectiveUrl($stats->getEffectiveUri());
                }
            ]));

            $link->setContent($response->getBody())
                ->setContentType($response->getHeader('Content-Type')[0]);
        } catch (ConnectException $e) {
            $link->setContent(false)->setContentType(false);
        }

        return $link;
    }
}
