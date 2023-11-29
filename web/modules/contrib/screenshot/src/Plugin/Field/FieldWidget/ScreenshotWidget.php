<?php

namespace Drupal\screenshot\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\image\Plugin\Field\FieldWidget\ImageWidget;

/**
 * Plugin implementation of the 'image_image' widget.
 *
 * @FieldWidget(
 *   id = "screenshot",
 *   label = @Translation("Screenshot"),
 *   field_types = {
 *     "image",
 *   }
 * )
 */
class ScreenshotWidget extends ImageWidget {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'show_file_input' => FALSE,
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = parent::settingsForm($form, $form_state);
    $elements['show_file_input'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Show file select button'),
      '#default_value' => $this->getSetting('show_file_input'),
    ];
    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = parent::settingsSummary();
    if (!empty($this->getSetting('show_file_input'))) {
      $summary[] = $this->t('Show file select button');
    }
    return $summary;
  }

  /**
   * Overrides FileWidget::formMultipleElements().
   *
   * Special handling for draggable multiple widgets and 'add more' button.
   */
  protected function formSingleElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formSingleElement($items, $delta, $element, $form, $form_state);
    $id = "screenshot-field-image-$delta";
    $url_object = Url::fromRoute('screenshot.send', ['selector' => $id], ['absolute' => TRUE]);
    $url = $url_object->toString();
    $entity = $items->getEntity();
    $entity_type = $entity->getEntityTypeId();
    $entity_id = $entity->id();
    $field_name = $items->getName();
    $element["#alt_field_required"] = FALSE;
    $element["#title_field_required"] = FALSE;
    $showInput = $this->getSetting('show_file_input');
    if (empty($showInput)) {
      $element['#attributes']['class'][] = 'hidden';
    }
    $fid = $element["#default_value"]["target_id"] ?? NULL;
    $element['screenshot'] = [
      '#theme' => 'screenshot',
      '#id_image' => $id,
      '#attributes' => [
        'class' => ['screen-capture'],
        'data-mode' => 'modal',
        'data-id' => $id,
        'data-url' => $url,
        'data-entity_type' => $entity_type,
        'data-entity_id' => $entity_id,
        'data-field_name' => $field_name,
        'data-delta' => $delta,
        'data-file_input' => $showInput,
        'data-fid' => $fid,
        'data-bundle' => $entity->bundle(),
      ],
      '#attached' => [
        'library' => [
          'screenshot/markerjs2',
          'screenshot/cropperjs',
          'screenshot/screenshot',
        ],
      ],
    ];
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function getPluginClass($type) {
    return $this->getDefinition($type)['class'];
  }

}
