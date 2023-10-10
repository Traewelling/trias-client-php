<?php

declare(strict_types=1);

namespace TriasClient;

use GuzzleHttp\Psr7\Request;

class RequestAndParse
{
    private string $url;
    private array $headers;
    private string $body;

    public function __construct(string $url, string $body, ?array $headers = [])
    {
        $this->url = $url;
        $this->headers = $headers;
        $this->body = $body;
    }

    public function request()
    {
        //convert all headers to lowercase
        $headers = array_change_key_case($this->headers, CASE_LOWER);
        $headers['content-type'] = 'application/xml';
        $headers['accept'] = 'application/xml';

        $options = [
            'headers' => $headers,
            'body' => $this->body
        ];

        $client = new \GuzzleHttp\Client();
        return $client->request('POST', $this->url, $options);
    }

    public function requestAndParse()
    {
        $response = $this->request();
        return $this->parse($response);
    }

    public function parse(\Psr\Http\Message\ResponseInterface $response)
    {
        $string = $response->getBody()->getContents();
        $string = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $string);
        $sxml = simplexml_load_string($string);

        $json = json_encode($sxml);
        return json_decode($json, true);
    }

}
