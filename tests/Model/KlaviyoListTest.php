<?php

namespace Klaviyo\Tests\Model;

use Klaviyo\KlaviyoApi;
use Klaviyo\Model\MembershipModel;
use Klaviyo\Model\PersonModel;
use Klaviyo\Model\ModelInterface;
use Psr\Http\Message\ResponseInterface;

class KlaviyoMembershipTest extends KlaviyoBaseTest {

  protected $class = 'Klaviyo\Model\MembershipModel';
  protected $configuration;

  public function setUp() {
    $this->configuration = [
      'object' => 'membership',
      'email' => 'george.washington@example.com',
      'date_added' => '2013-06-10 13:00:00',
      'person' => [
        'object' => 'person',
        'id' => '0mzwQ7',
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
      ]
    ];
  }

  public function assertModelMatchesConfiguration(ModelInterface $list, $configuration = array()) {
    if (empty($configuration)) {
      $configuration = $this->configuration;
    }

    $this->assertSame($configuration['object'], $list->getObjectType());
    $this->assertSame($configuration['email'], $list->getEmail());
    $date_added = new \DateTime($configuration['date_added']);
    $this->assertEquals($date_added, $list->getDateAdded());


    $person = PersonModel::create($configuration['person']);
    $this->assertEquals($person, $list->getPerson());
  }

}
