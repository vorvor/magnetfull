<?php

namespace Drupal\screenshot\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a screenshot block.
 *
 * @Block(
 *   id = "screenshot_block",
 *   admin_label = @Translation("Screenshot Block"),
 *   category = @Translation("Screenshot")
 * )
 */
class ScreenshotBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'screenshot_type' => 'modal',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['screenshot_type'] = [
      '#type' => 'select',
      '#title' => $this->t('Type'),
      '#options' => [
        'modal' => $this->t('Modal'),
        'tab' => $this->t('Crop in new tab'),
      ],
      '#description' => $this->t('Select type to display captured images?'),
      '#default_value' => $this->configuration['screenshot_type'],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['screenshot_type'] = $form_state->getValue('screenshot_type');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();
    $id = "screenshot-block-image";
    $build = [
      '#theme' => 'screenshot',
      '#id_image' => $id,
      '#attributes' => [
        'class' => ['screen-capture'],
        'data-id' => $id,
        'data-mode' => $config['screenshot_type'],
      ],
      '#attached' => [
        'library' => ['screenshot/screenshot'],
        'drupalSettings' => [
          'screenshot' => [$this->getFormId() => $config],
        ],
      ],
    ];
    if (!empty($config['screenshot_type']) && $config['screenshot_type'] == 'modal') {
      $build['#attached']['library'][] = 'screenshot/cropperjs';
      $build['#attached']['library'][] = 'screenshot/markerjs2';
    }

    return $build;
  }

  /**
   * {@inheritdoc}
   */
  private function getFormId() {
    return 'screenshot_block';
  }

}
