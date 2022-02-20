<?php

/**
 * @file
 * Contains \Drupal\user_register_extend\Form\Multistep\MarioPizzaUserRegisterSecondForm.
 */

namespace Drupal\user_register_extend\Form\Multistep;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

class MarioPizzaUserRegisterSecondForm extends MultistepFormBase {

  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'user_register_step_two';
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form = parent::buildForm($form, $form_state);

    $countryList = \Drupal::service('country_manager')->getStandardList();

    $form['mp_user_register'] = [
      '#type' => 'details',
      '#title' => t('Step 2 - User Details'),
      '#open' => TRUE
    ];
    $form['mp_user_register']['full_name'] = [
      '#title'       => $this->t('Full Name'),
      '#placeholder' => $this->t('Enter your full name'),
      '#type'        => 'textfield',
    ];
    $form['mp_user_register']['dob'] = [
      '#title'       => $this->t('Date of Birth'),
      '#placeholder' => $this->t('Enter your date of birth'),
      '#type'        => 'date',
      '#required' => TRUE,
    ];

    $form['mp_user_register']['country'] = [
      '#type' => 'select',
      '#title'    => $this->t('Select Country *'),
      '#default_value' => '',
      "#empty_option" => t('Country'),
      '#options' => ($countryList) ? $countryList : [],
      '#attributes' => ['class' => ['selectpicker', 'country'], 'tabindex' => 17],
    ];

    $form['actions']['submit']['#value'] = $this->t('Final Step');
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $countryList = \Drupal::service('country_manager')->getStandardList();
    // Get the user details.
    $tempstore = \Drupal::service('tempstore.private')->get('user_register_multiform');
    $tempstore->set('full_name', $form_state->getValue('full_name'));
    $tempstore->set('dob', $form_state->getValue('dob'));
    $tempstore->set('country', $countryList[$form_state->getValue('country')]->__toString());

    // Set Redirect to Final step.
    $form_state->setRedirect('user_register_extend.user_register_final_step');
  }
}