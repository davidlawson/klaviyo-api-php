<?php

namespace Klaviyo\Tests;

use Klaviyo\KlaviyoApi;
use Klaviyo\KlaviyoFacade;
use Klaviyo\TemplateService;
use Klaviyo\Model\CampaignModel;
use Klaviyo\Model\ListModel;
use Klaviyo\Model\TemplateModel;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

class TemplateServiceTest extends KlaviyoTestCase {

  protected $templateConfiguration = [
    'object' => 'email-template',
    'id' => 'dqQnNW',
    'name' => 'My New Template',
    'html' => '<html><body><p>This is an email for {{ email }}.</p></body></html>',
    'created' => '2013-06-17 14:00:00',
    'updated' => '2013-06-17 14:00:00',
  ];

  public function testUpdateTemplate() {
    $container = $responses = [];
    $template = $this->templateConfiguration;
    $template['html'] = '<html><body>Yay it was changed.</body></html>';
    $responses[] = new Response(200, [], json_encode($template));
    $client = $this->getClient($container, $responses);

    $api = new KlaviyoApi($client, $this->apiKey);
    $template_service = new TemplateService($api);

    $template = TemplateModel::create($this->templateConfiguration);
    $template->html = '<html><body>Yay it was changed.</body></html>';

    $response = $template_service->updateTemplate($template);
    $this->assertEquals($template, $response);
  }

}
