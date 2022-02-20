<?php

/**
 * @file
 * Contains \Drupal\user_register_extend\Form\Multistep\MarioPizzaUserRegisterFinalForm.
 */

namespace Drupal\user_register_extend\Form\Multistep;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MarioPizzaUserRegisterFinalForm extends MultistepFormBase {

  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'user_register_final_step';
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form = parent::buildForm($form, $form_state);

    $form['mp_user_register'] = [
      '#type' => 'details',
      '#title' => t('Step 3 - User Choices'),
      '#open' => TRUE
    ];
    $form['mp_user_register']['pizza_type'] = [
      '#type' => 'checkboxes',
      '#options' => array('pepperoni' => $this->t('Pepperoni'), 'cheese' => $this->t('Cheese'),'meatlovers' => $this->t('Meatlovers'), 'vegetarian' => $this->t('Vegetarian'), 'hawaiian' => $this->t('Hawaiian')),
      '#title' => $this->t('Your Choices'),
      '#required' => TRUE,
    ];

    $form['actions']['submit']['#value'] = $this->t('Submit');
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Update the user saved data / user choices.
    $tempstore = \Drupal::service('tempstore.private')->get('user_register_multiform');
    $username = $tempstore->get('username');

    $type = $form_state->getValue('pizza_type');

    \Drupal::service('user_register_extend.helper_service')->updateUserData($tempstore, $type);

    // Set Messenger.    
    \Drupal::messenger()->addStatus(t('User Registration Successful.'));

    // Set Redirect to Step one.
    $form_state->setRedirect('user_register_extend.user_register_step_one');
  }
}