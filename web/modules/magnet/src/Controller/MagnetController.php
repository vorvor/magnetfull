<?php

namespace Drupal\magnet\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\block\Entity\Block;
use Drupal\block_content\Entity\BlockContent;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Returns responses for magnet routes.
 */
class MagnetController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function import() {

     $products = magnet_import();

     foreach ($products as $product) {
      if ($product['serial'] == '1938') {
        magnet_save_product($product);
        dpm($product);
      }
     }

/*

    // full import.
    $products = magnet_import();

    foreach ($products as $product) {
      magnet_save_product($product);
    }
*/





    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

  public function importTest() {

    $products = magnet_import();

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

  public function setState($nid, $state) {

    $html = magnet_set_state($nid, $state);

    return new JsonResponse($html);
  }

  public function setNextState($nid) {

    $html = magnet_set_next_state($nid);

    return new JsonResponse($html);
  }

  public function dropState($nid) {

    $html = magnet_drop_state($nid);

    return new JsonResponse($html);
  }

  public function inventory() {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('Inventory'),
    ];

    return $build;
  }

  public function inventoryAdd($nid) {

    $html = magnet_inventory_add($nid);

    return new JsonResponse($html);
  }

  public function calendar() {

    $im = imagegrabscreen();
    imagepng($im, "myscreenshot.png");
    imagedestroy($im);


    $content = magnet_calendar();

    // Header days.
    $header_string = '';
    for ($c = 0; $c < 32; $c++) {
      $char = '<span class="char header">' . $c . '</span>';
      $header_string .= $char;
    }
    $header_days = '<div id="calendar-header">' . $header_string . '</div>';

    return [
      '#theme' => 'magnet_calendar',
      '#attached' => [
        'library' => [
          'magnet/calendar',
        ],
      ],
      '#header' => $header_days,
      '#content' => $content,
    ];
  }

  public function trackStates() {
    magnet_report('2023-11-01', '2023-12-12');

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('Inventory'),
    ];

    return $build;
  }
}
