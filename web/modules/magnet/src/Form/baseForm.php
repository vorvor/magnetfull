<?php

namespace Drupal\magnet\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a Alap migrate from DB form.
 */
class baseForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'magnet_base';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {


    /*$path = \Drupal::service('extension.path.resolver')->getPath('module', 'magnet');
    $json = file_get_contents($path . '/source/users.json');
    $json = str_replace(' ', '', $json);
    $json = str_replace("\n\r", '', $json);
    $json = str_replace("\n", '', $json);
    file_put_contents($path . '/source/users.json', $json);*/

    $form['reset'] = [
      '#title' => 'Reset page',
      '#type' => 'checkbox',
    ];

    $form['product_id'] = [
      '#title' => 'One product id to import (former serial)',
      '#type' => 'textfield',
    ];

    $form['import'] = [
      '#title' => 'Run partial import',
      '#type' => 'checkbox',
    ];

    $form['full_import'] = [
      '#title' => 'Full import',
      '#type' => 'checkbox',
    ];

    $form['verbose'] = [
      '#title' => 'Verbose',
      '#type' => 'checkbox',
    ];

    $form['actions'] = [
      '#type' => 'actions',
    ];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Start'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

   

    
    $products = magnet_import();
    $product = null;
    foreach ($products as $one_product) {
      if ($one_product['serial'] == $form_state->getValue('product_id')) {
        $product = $one_product;

        break;
      }
    }

    // Delete all products and terms from page, for a new import.
    if ($form_state->getValue('reset') == 1) {
      magnet_reset_site();
    }

    // Run import
    if ($form_state->getValue('import') == 1) {
      magnet_import_scales();
      magnet_import_users();
      magnet_create_states();
      magnet_set_user_permissions();

      $context = [];
      magnet_save_product($product, $context);
   }

   if ($form_state->getValue('full_import') == 1) {
      magnet_import_scales();
      magnet_import_users();
      magnet_create_states();
      magnet_set_user_permissions();

      $i = 0;
      foreach ($products as $product) {
        $i++;
        if ($i > 50) {
          //break;
        }
        //magnet_save_product($product);
        $operations[] = ['magnet_save_product', [$product]];
      }

      $batch = [
        'title' => $this->t('Migrating data ...'),
        'operations' => $operations,
        'finished' => 'magnet_migrate_finished',
      ];
      batch_set($batch);
   }

   if ($form_state->getValue('verbose') == 1) {
      dpm($product);
    }

    $this->messenger()->addStatus($this->t('done.'));
    $form_state->setRebuild();

    //$form_state->setRedirect('<front>');
  }

}
