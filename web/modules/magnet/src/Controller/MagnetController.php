<?php

namespace Drupal\magnet\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\block\Entity\Block;
use Drupal\block_content\Entity\BlockContent;
use Drupal\views\Views;
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

    $content = magnet_calendar(13273);

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

  public function reportByTimeframe() {

    $date = date("Y-m-d", strtotime('+ 1 day'));

    $output = [];
    for ($c = 0; $c < 53; $c++) {
      $offset = '+' . ($c * 7) . ' day';
      $date = strtotime($offset);
      $monday = date('Y-m-d', strtotime('monday this week', $date));
      $friday = date('Y-m-d', strtotime('friday this week', $date));

      $arg = ($monday . '--' . $friday);
      $view = Views::getView('duplicate_of_report_kolos');
      $view->setDisplay('page_1');
      $view->setArguments([$arg]);
      $view->execute();
      $result = $view->buildRenderable('page_1', $view->args);
      $output[] = '<h3>' . $arg . '</h3>' . \Drupal::service('renderer')->render($result);
    }

    /*



    $view = Views::getView('duplicate_of_report_kolos');
    $view->setDisplay('page_1');
    $view->setArguments(['2024-01-01--2024-01-10']);
    $view->execute();
    $result = $view->buildRenderable('page_1', $view->args);
    $output = \Drupal::service('renderer')->render($result);
    */

    $build['content'] = [
      '#type' => 'item',
      '#markup' => implode($output),
    ];

    //return views_embed_view('duplicate_of_report_kolos','page_1', '2024-01-01--2024-01-10');
    return $build;
  }
}
