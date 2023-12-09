<?php

/**
 * @file
 * Definition of Drupal\magnet\Plugin\views\field\NodeTypeFlagger
 */

namespace Drupal\magnet\Plugin\views\field;

use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\NodeType;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;
use Drupal\taxonomy\Entity\Term;

/**
 * Field handler to flag the node type.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("magnet_ndfield")
 */
class MagnetNDField extends FieldPluginBase {

  /**
   * @{inheritdoc}
   */
  public function query() {
    // Leave empty to avoid a query on this field.
  }

  /**
   * Define the available options
   * @return array
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['node_type'] = array('default' => 'article');

    return $options;
  }

  /**
   * Provide the options form.
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    $types = NodeType::loadMultiple();
    $options = [];
    foreach ($types as $key => $type) {
      $options[$key] = $type->label();
    }
    $form['node_type'] = array(
      '#title' => $this->t('Which node type should be flagged?'),
      '#type' => 'select',
      '#default_value' => $this->options['node_type'],
      '#options' => $options,
    );

    parent::buildOptionsForm($form, $form_state);
  }

  /**
   * @{inheritdoc}
   */
  public function render(ResultRow $values) {
    $node = $this->getEntity($values);
    $date = 'no data';
    if (!empty($node->get('field_state')->getValue())) {

        $state_tid = $node->get('field_state')->getValue()[0]['target_id'];
        $state_obj = Term::load($state_tid);
        $state_human_name = $state_obj->getName();
        $state_name = str_replace(' ', '_', strtolower($state_human_name));

        // Products only in progress are interesting.
        if (strpos($state_human_name, 'finished') !== FALSE) {
            $state_human_name = magnet_get_next_state($state_human_name);
            $state_name = str_replace(' ', '_', strtolower($state_human_name));
        }

        if ($state_name == 'tunings_and_heat_treatments') {
            $state_name = 'tunings_and_heat';
        }


        if ($state_name !== 'packaging_finished') {
            if ($node->hasField('field_date_' . $state_name)) {
                $next_deadline = $node->get('field_date_' . $state_name)->getValue();
                if (empty($next_deadline)) {
                    $date = 'no data.';
                } else {
                    $date = $next_deadline[0]['value'] . '<br />(->' . $state_human_name . ')';
                }
            } else {
                $date = 'no data';
            }
        }

    }

    return $date;
  }
}
