<?php

namespace Drupal\magnet\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;

/**
 * Provides a magnet form.
 */
class TestForm extends FormBase {

  public function states() {
    return ['Drawing','Dimpleing','Shaping','Tunings and heat','Gluing','Fine tuning','Flexing','Nanoing','Last check','Packaging'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'magnet_test';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $states = $this->states();

    $form['nid'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Nid'),
      '#required' => TRUE,
      '#default_value' => 5974,
    ];

    $form['revision_vids'] = [
        '#type' => 'textfield',
        '#value' => $form_state->getValue('revision_vids'),
      ];

    if (!is_null($form_state->getValue('revision_vids'))) {

      

      foreach($form_state->getValue('revision_vids') as $vid) {
        $form['revision_date_' . $vid] = [
          '#type' => 'textfield',
          '#title' => $form_state->getValue('revision_state_' . $vid),
          '#default_value' => date('Y-m-d', $form_state->getValue('revision_date_' . $vid)),
        ];
      }
    }

    $form['actions'] = [
      '#type' => 'actions',
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Fill date fields'),
    ];

    $form['actions']['update'] = [
      '#type' => 'submit',
      '#value' => $this->t('Update node values'),
      '#submit' => array([$this, 'submitFormUpdate']),
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

    $states = $this->states();
    $node = Node::load($form_state->getValue('nid'));
    $vids = \Drupal::entityTypeManager()->getStorage('node')->revisionIds($node);

    $c = 0;
    $state = '';
    foreach ($vids as $vid) {

        $node_rev = \Drupal::entityTypeManager()->getStorage('node')->loadRevision($vid);
        $date = magnet_get_revision_date($vid);
        $current_state = magnet_get_revision_state($vid);

        if ($current_state !== $state) {
          $form_state->setValue('revision_date_' . $vid, $date);
          $form_state->setValue('revision_state_' . $vid, $current_state);

          $vidss[] = $vid;
          $c++;
        }

        $state = $current_state;
        
    }

    $form_state->setValue('revision_num', $c);
    $form_state->setValue('revision_vids', $vidss);

    $form_state->setRebuild(true);
  }


  /**
   * {@inheritdoc}
   */
  public function submitFormUpdate(array &$form, FormStateInterface $form_state) {
    
    $node = Node::load($form_state->getValue('nid'));
    $vids = \Drupal::entityTypeManager()->getStorage('node')->revisionIds($node);


    $database = \Drupal::database();
    foreach($form_state->getValue('revision_vids') as $vid) {
      
      $query = $database->update('node_field_revision')
        ->fields([
          'changed' => strtotime($form_state->getValue('revision_date_' . $vid)),
        ])
        ->condition('vid', $vid)
        ->execute();

        dpm($vid . ':' . $form_state->getValue('revision_date_' . $vid));
        
    }

    $form_state->setRebuild(true);

    $this->submitForm($form, $form_state);

  }

}