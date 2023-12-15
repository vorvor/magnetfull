<?php declare(strict_types = 1);

namespace Drupal\magnet\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Markup;

/**
 * Provides a magnet form.
 */
final class ReportForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'magnet_report';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {

    $form['#attached']['library'][] = 'magnet/report';
    $form['#attached']['drupalSettings']['magnet']['datasets'] = $form_state->getStorage();

    $form['datefrom'] = [
      '#type' => 'Start date',
      '#title' => $this->t('from'),
      '#required' => FALSE,
    ];

    $form['dateto'] = [
      '#type' => 'End date',
      '#title' => $this->t('to'),
      '#required' => FALSE,
    ];

    $form['markup'] = [
      '#type' => 'markup',
      '#markup' => $form_state->getValue('markup'),
    ];

    $form['chart'] = [
      '#type' => 'markup',
      '#markup' => Markup::create('<canvas id="canvas2" width="200"></canvas>'),
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
    $this->messenger()->addStatus($this->t('The message has been sent.'));

    $form_state->setRebuild(TRUE);

    $values = magnet_report($form_state->getValue('datefrom'), $form_state->getValue('dateto'));

    $form_state->setValue('markup', $values['text']);
    $form_state->setStorage($values);

  }

}
