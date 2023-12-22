<?php declare(strict_types = 1);

namespace Drupal\magnet\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a magnet_state_changes block.
 *
 * @Block(
 *   id = "magnet_magnet_state_changes",
 *   admin_label = @Translation("State changes"),
 *   category = @Translation("Custom"),
 * )
 */
final class MagnetStateChangesBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    $node = \Drupal::routeMatch()->getParameter('node');
    if ($node instanceof \Drupal\node\NodeInterface) {
      $nid = $node->id();
      $content = magnet_calendar($nid);
      $content .= magnet_product_history($nid);
    }

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

}
