<?php declare(strict_types = 1);

namespace Drupal\magnet\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a tuner_capacity block.
 *
 * @Block(
 *   id = "magnet_tuner_capacity",
 *   admin_label = @Translation("tuner_capacity"),
 *   category = @Translation("Custom"),
 * )
 */
final class TunerCapacityBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build(): array {

    $content = magnet_tuner_capacity();

    return [
      '#theme' => 'magnet_tuner_capacity_block',
      '#attached' => [
        'library' => [
          'magnet/tuner_capacity',
        ],
      ],
      '#content' => $content,
    ];
  }

}
