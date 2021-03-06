<?php

namespace Klaviyo\Tests;

use Klaviyo\KlaviyoApi;
use Klaviyo\PersonService;
use Klaviyo\Model\PersonModel;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

class PersonServiceTest extends KlaviyoTestCase {

  protected $responsePerson = [
    'object' => 'person',
    'id' => 'dqQnNW',
    '$email' => 'george.washington@example.com',
    '$first_name' => 'George',
    '$last_name' => 'Washington',
    '$organization' => 'U.S. Government',
    '$title' => 'President',
    '$city' => 'Mount Vernon',
    '$region' => 'Virginia',
    '$zip' => '22121',
    '$country' => 'United States',
    '$timezone' => 'US/Eastern',
    '$phone_number' => '',
  ];

  public function getPersonService(&$container, $responses) {
    $client = $this->getClient($container, $responses);
    $api = new KlaviyoApi($client, $this->apiKey);
    return new PersonService($api);
  }

  public function testGetPerson() {
    $container = $responses = [];
    $responses[] = new Response(200, [], json_encode($this->responsePerson));
    $person_manager = $this->getPersonService($container, $responses);
    $person = $person_manager->getPerson('abc');

    $this->assertTrue($person instanceof PersonModel, 'The person manager should had returned an instance of a PersonModel.');

    $response_person = PersonModel::create($this->responsePerson);
    $this->assertEquals($response_person, $person);
  }

}
