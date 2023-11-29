<?php

namespace Drupal\magnet\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure magnet settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'magnet_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['magnet.settings'];
  }

  public function getStates() {
    $states = [
        'drawing' => 7,
        'dimpleing' => 7,
        'shaping' => 7,
        'tunings and heat treatments' => 14,
        'gluing' => 28,
        'fine tuning' => 7,
        'flexing' => 7,
        'nanoing' => 0,
        'last check' => 7,
        'packaging' => 0,
    ];

    return $states;
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['id_offset'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Id offset (drupal id += magnet id)'),
      '#default_value' => $this->config('magnet.settings')->get('id_offset'),
    ];

    $states = $this->getStates();

    foreach ($states as $key => $time) {
      $state_name = 'timeframe_' . str_replace(' ', '_', $key);
      $form[$state_name] = [
        '#type' => 'textfield',
        '#title' => $this->t('Timeframe for @state in days', array('@state' => $key)),
        '#default_value' => $this->config('magnet.settings')->get($state_name),
      ];
    }

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('magnet.settings')
      ->set('id_offset', $form_state->getValue('id_offset'))->save();

    $states = $this->getStates();
    foreach ($states as $key => $time) {
      $state_name = 'timeframe_' . str_replace(' ', '_', $key);
      $this->config('magnet.settings')->set($state_name, $form_state->getValue($state_name))->save();
    }

    parent::submitForm($form, $form_state);
  }

}
