<?php declare(strict_types = 1);

namespace Drupal\magnet\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a magnet form.
 */
final class UpdateProducts extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'magnet_update_products';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {

    $form['message'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Message'),
      '#required' => TRUE,
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


    $type = 'product';
    $nodes = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => $type]);

    foreach ($nodes as $node) {
      $node->set('field_next_deadline', magnet_get_current_deadline($node));
      $node->save();
      $this->messenger()->addStatus($this->t($node->id() . ' updated.'));
    }
  }

}
