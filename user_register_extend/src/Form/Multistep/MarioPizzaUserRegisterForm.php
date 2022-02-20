<?php

/**
 * @file
 * Contains \Drupal\user_register_extend\Form\Multistep\MarioPizzaUserRegisterForm.
 */

namespace Drupal\user_register_extend\Form\Multistep;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\user\Entity\User;

class MarioPizzaUserRegisterForm extends MultistepFormBase {

  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'user_register_step_one';
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form = parent::buildForm($form, $form_state);

    $form['mp_user_register'] = [
      '#type' => 'details',
      '#title' => t('Step 1 - User Basic Info'),
      '#open' => TRUE
    ];
    $form['mp_user_register']['username'] = [
      '#title'       => $this->t('Username'),
      '#placeholder' => $this->t('Enter your username'),
      '#type'        => 'textfield',
      '#required' => TRUE,
    ];
    $form['mp_user_register']['password'] = [
      '#title'       => $this->t('Password'),
      '#placeholder' => $this->t('Enter your password'),
      '#type'        => 'password',
      '#required' => TRUE,
    ];

    $form['actions']['submit']['#value'] = $this->t('Next Step');
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Get the user basic info.
    $tempstore = \Drupal::service('tempstore.private')->get('user_register_multiform');
    $tempstore->set('username', $form_state->getValue('username'));
    $tempstore->set('password', $form_state->getValue('password'));

    // Set Redirect to Step two.
    $form_state->setRedirect('user_register_extend.user_register_step_two');
  }
}