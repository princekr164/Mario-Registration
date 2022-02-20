<?php
/**
 * @file
 * Contains \Drupal\user_register_extend\Plugin\Block.
 */
namespace Drupal\user_register_extend\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\user\Entity\User;

/**
 * Provides a block for Pizza Coupons.
 *
 * @Block(
 *   id = "pizza_coupon_block",
 *   admin_label = @Translation("My Coupon block"),
 * )
 */
class PizzaCouponBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    // Load the current User.
    $current_user = \Drupal::currentUser();

    $user = \Drupal::entityTypeManager()->getStorage('user')->load($current_user->id());
    $user_dob = $user->field_date_of_birth->value;
    $pizza_type = $user->field_pizza_type->value;

    if (date("m", strtotime($user_dob)) == date("m")) {
      $offerMessage = 'Happy Birthday '. $user->name->value .'. You have an offer of 10$ for Pizza Choice - '. $pizza_type .'.';
    }
    else {
      $offerMessage = 'No Offers Available!';
    }

    return array(
      '#theme' => 'coupon_block',
      '#data' => [
        'offer' => $offerMessage
      ],
      "#cache" => [
        'max-age' => 0
      ]
    );
  }
}