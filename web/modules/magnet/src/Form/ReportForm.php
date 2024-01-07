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

    magnet_tuner_capacity();

    $form['#attached']['library'][] = 'magnet/report';
    $form['#attached']['drupalSettings']['magnet']['datasets'] = $form_state->getStorage();

    $form['datefrom'] = [
      '#type' => 'date',
      '#title' => $this->t('Start date'),
      '#required' => FALSE,
    ];

    $form['dateto'] = [
      '#type' => 'date',
      '#title' => $this->t('End date'),
      '#required' => FALSE,
    ];

    $form['actions'] = [
      '#type' => 'actions',
      'submit' => [
        '#type' => 'submit',
        '#value' => $this->t('Create report'),
      ],
    ];

    $form['markup'] = [
      '#type' => 'markup',
      '#markup' => $form_state->getValue('markup'),
      '#weight' => 1000,
    ];

    $form['chart'] = [
      '#type' => 'markup',
      '#markup' => Markup::create('<canvas id="canvas2" width="200"></canvas>'),
      '#weight' => 1001,
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

    $form_state->setRebuild(TRUE);

    $values = magnet_report($form_state->getValue('datefrom'), $form_state->getValue('dateto'));

    $states_dates_report = magnet_product_history_list($form_state->getValue('datefrom'), $form_state->getValue('dateto'));
    $states_dates_report = '<div id="state-change-report-per-products"><h2 id="opener">State change report per product (open)</h2><div id="report-wrapper" class="hidden">' . $states_dates_report . '</div></div>';

    $form_state->setValue('markup', $values['text'] . $states_dates_report);
    $form_state->setStorage($values);

  }

}
