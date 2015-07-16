<?php

namespace Pennyblossom\Client;

// use GuzzleHttp\Post\PostFile;
use GuzzleHttp\Client as GuzzleClient;
use Symfony\Component\Yaml\Parser as YamlParser;

class Client
{
    private $parameters = null;

    public function __construct()
    {
        $this->getConfig();
    }

    private function getConfig()
    {
        if ($this->parameters === null) {
            $parser = new YamlParser();
            $this->parameters = $parser->parse(file_get_contents(__DIR__.'/../config.yml'));
        }

        return $this->parameters;
    }

    public function create()
    {
        $guzzleclient = new GuzzleClient();

        $data = $this->getSampleData();
        $data['debug'] = $this->parameters['debug'];

        $res = $guzzleclient->post(
            ($this->parameters['api_url'].'/create'),
            [
                'auth' => [$this->parameters['username'], $this->parameters['api_key']],
                'headers' => ['content-type' => 'application/json'],
                'body' => json_encode($data),
            ]
        );

        $body = $res->getBody();
        if ($body) {
            return $body->read(2048);
        }

        return false;
    }

    private function getSampleData()
    {
        $o = [
            'email' => 'h.wang@linkorb.com',
            'vat_number' => '893764837042',
        ];
        $o['address'] = [
            'billing' => [
                'company' => 'LinkORB',
                'fullname' => 'Hongliang',
                'address' => 'Kerkstraat 4a',
                'postalcode' => '5658 BC',
                'city' => 'Oirschot',
            ],
            'shipping' => [
                'company' => 'LinkORB',
                'fullname' => 'Hongliang',
                'address' => 'Kerkstraat 4a',
                'postalcode' => '5658 BC',
                'city' => 'Oirschot',
            ],
        ];

        return $o;
    }

    public function preview()
    {
        $guzzleclient = new GuzzleClient();

        $url = $this->apiUrl.'/preview/';
        $url .= $this->patchTemplateName($message->getTemplate(), $skipNamePrefix).'/';
        $url .= '?to='.$message->getToAddress();

        $res = $guzzleclient->post($url, [
            'auth' => [$this->username, $this->password],
            'headers' => ['content-type' => 'application/json'],
            'body' => $message->serializeData(true),
        ]);

        return json_decode($res->getBody());
    }

    public function templateExists($templateName, $skipNamePrefix = false)
    {
        $guzzleclient = new GuzzleClient();

        $url = $this->apiUrl.'/checktemplate/'.$this->patchTemplateName($templateName, $skipNamePrefix);

        $res = $guzzleclient->post($url, [
            'auth' => [$this->username, $this->password],
        ]);

        $body = $res->getBody();
        if ($body) {
            if ($body->read(2) == 'ok') {
                return true;
            }
        }

        return false;
    }
}
