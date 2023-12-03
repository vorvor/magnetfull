<?php

namespace Drupal\tablesorter\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Table sorter settings form.
 */
class TableSorterSettings extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'tablesorter_form';
  }

  /**
   * {@inheritdoc}
   */
  public function getEditableConfigNames() {
    return [
      'tablesorter.settings',
    ];

  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, Request $request = NULL) {
    $config = \Drupal::config('tablesorter.settings');

    $form['tablesorter_theme'] = [
      '#type' => 'select',
      '#title' => $this->t('Select Theme'),
      '#options' => [
        'system' => $this->t("System's Default"),
        'blue' => $this->t('Blue'),
        'green' => $this->t('Green'),
      ],
      '#default_value' => $config->get('tablesorter_theme'),
      '#description' => $this->t('Set the theme for header.'),
      '#required' => TRUE,
    ];
    $form['tablesorter_zebra'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Maintain zebra striping on tables'),
      '#description' => $this->t("Re-stripe table rows with 'odd', 'even' classes after sorting"),
      '#default_value' => $config->get('tablesorter_zebra'),
    ];

    $form['tablesorter_zebra_odd_class'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Odd row class'),
      '#description' => $this->t("Select the class added to odd rows.  Defaults to 'odd'"),
      '#default_value' => $config->get('tablesorter_zebra_odd_class'),
    ];

    $form['tablesorter_zebra_even_class'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Even row class'),
      '#description' => $this->t("Select the class added to even rows.  Defaults to 'even'"),
      '#default_value' => $config->get('tablesorter_zebra_even_class'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $userInputValues = $form_state->getUserInput();

    $config = $this->configFactory->getEditable('tablesorter.settings')
      ->set('tablesorter_theme', $userInputValues['tablesorter_theme'])
      ->set('tablesorter_zebra', $userInputValues['tablesorter_zebra'])
      ->set('tablesorter_zebra_odd_class', $userInputValues['tablesorter_zebra_odd_class'])
      ->set('tablesorter_zebra_even_class', $userInputValues['tablesorter_zebra_even_class'])
      ->save();

    parent::submitForm($form, $form_state);
  }

}
