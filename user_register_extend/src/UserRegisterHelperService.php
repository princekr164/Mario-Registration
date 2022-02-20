<?php

namespace Drupal\user_register_extend;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Logger\LoggerChannelFactory;
use Drupal\Core\Database\Connection;
use Drupal\user\Entity\User;

/**
 * Class UserRegisterHelperService.
 */
class UserRegisterHelperService {

  /**
   * Drupal\Core\Entity\EntityTypeManagerInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * [$logger description]
   * @var [Drupal\Core\Logger\LoggerChannelFactory]
   */
  protected $logger;

  /**
   * [$connection description]
   * @var \Drupal\Core\Database\Connection
   */
  protected $connection;

	/**
   * Constructs a new DeviceListingService object.
   */
  public function __construct(
    LoggerChannelFactory $logger,
    EntityTypeManagerInterface $entity_type_manager,
    Connection $connection
  ) {
    $this->logger = $logger;
    $this->entityTypeManager = $entity_type_manager;
    $this->connection = $connection;
  }
  
  /**
   *  Mario Pizza User Register - Create new user account.
   */
  public function updateUserData($temp, $type) {
    $name = $temp->get('username');
    $password = $temp->get('password');
    $actualName = $temp->get('full_name');
    $dob = $temp->get('dob');
    $country = $temp->get('country');
    $email = 'test@gm.in';

    //set up the user fields
    $user = User::create([
        'name' => $name,
        'mail' => $email,
        'pass' => $password,
        'field_full_name' => $actualName,
        'field_date_of_birth' => $dob,
        'field_country' => $country,
        'field_pizza_type' => reset(array_filter($type)),
        'status' => 1,
        'roles' => array('customer'),
    ]);

    $user->save();
  }
  
}