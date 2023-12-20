<?php

namespace Drupal\magnet\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a magnet form.
 */
class MailDashboard extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'magnet_magnet_mail_dashboard';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {

    $form['email_types'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('E-mails to send'),
      '#options' => [
        'upcoming_deadlines' => 'Upcoming deadlines',
      ],
    ];

    $form['actions'] = [
      '#type' => 'actions',
      'submit' => [
        '#type' => 'submit',
        '#value' => $this->t('Send'),
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    // @todo Validate the form here.
    // Example:
    // @code
    //   if (mb_strlen($form_state->getValue('message')) < 10) {
    //     $form_state->setErrorByName(
    //       'message',
    //       $this->t('Message should be at least 10 characters.'),
    //     );
    //   }
    // @endcode
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    if ($form_state->getValue('email_types') !== 0) {
      magnet_mail_upcoming_deadlines();
    }
  }

}
