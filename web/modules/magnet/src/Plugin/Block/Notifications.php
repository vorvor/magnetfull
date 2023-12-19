<?php

namespace Drupal\magnet\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Link;
use Drupal\Core\Render\Markup;
use Drupal\Core\Url;
use Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Term;

/**
 * Provides an example block.
 *
 * @Block(
 *   id = "notifications",
 *   admin_label = @Translation("Notification"),
 *   category = @Translation("Notification")
 * )
 */
class Notifications extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $now = date('Y-m-d, D');
    $date_offset = '+ 7 day';
    //$now = '2023-10-12';
    $between = [date('Y-m-d', strtotime($now)), date('Y-m-d', strtotime($now . ' ' . $date_offset))];
    $database = \Drupal::database();
    $query = $database->select('node', 'n');
    $query->leftJoin('node__field_date_dimpleing', 'd', 'd.entity_id = n.nid');
    $query->leftJoin('node__field_date_shaping', 's', 's.entity_id = n.nid');
    $query->leftJoin('node__field_date_tunings_and_heat', 't', 't.entity_id = n.nid');
    $query->leftJoin('node__field_date_gluing', 'g', 'g.entity_id = n.nid');
    $query->leftJoin('node__field_date_fine_tuning', 'fi', 'fi.entity_id = n.nid');
    $query->leftJoin('node__field_date_flexing', 'fl', 'fl.entity_id = n.nid');
    $query->leftJoin('node__field_date_nanoing', 'na', 'na.entity_id = n.nid');
    $query->leftJoin('node__field_date_last_check', 'l', 'l.entity_id = n.nid');
    $query->leftJoin('node__field_date_packaging', 'p', 'p.entity_id = n.nid');
    $query->leftJoin('node__field_serial', 'se', 'se.entity_id = n.nid');

    $datesGroup = $query->orConditionGroup()
      ->condition('d.field_date_dimpleing_value', $between, 'BETWEEN')
      ->condition('s.field_date_shaping_value', $between, 'BETWEEN')
      ->condition('t.field_date_tunings_and_heat_value', $between, 'BETWEEN')
      ->condition('g.field_date_gluing_value', $between, 'BETWEEN')
      ->condition('fi.field_date_fine_tuning_value', $between, 'BETWEEN')
      ->condition('fl.field_date_flexing_value', $between, 'BETWEEN')
      ->condition('na.field_date_nanoing_value', $between, 'BETWEEN')
      ->condition('l.field_date_last_check_value', $between, 'BETWEEN')
      ->condition('p.field_date_packaging_value', $between, 'BETWEEN');

    $query
      ->fields('n')
      ->fields('se', ['field_serial_value'])
      ->condition($datesGroup);

    $results = $query->execute()->fetchAll();

    $actual_deadlines = [];
    foreach ($results as $key => $result) {
      $node = Node::load($result->nid);
      $next_deadline = magnet_get_current_deadline($node);
      if ((strtotime($next_deadline) > strtotime($now))
        && (strtotime($next_deadline) < strtotime($now . $date_offset))) {
          $current_state = magnet_find_active_state($result->nid);
          $next_state = magnet_get_next_state($current_state);

        $actual_deadlines[] = Link::fromTextAndUrl(Markup::create('<span>' . $result->field_serial_value . '</span>'
          . '<span>' . $current_state . '</span>'
          . '<span>-></span><span>' .  $next_state . '</span>'
          . '<span>' . date('Y-m-d, D', strtotime($next_deadline)) . '</span>'), $node->toUrl())->toString();
      } else {
        unset($results[$key]);
      }
    }

    $build['content'] = [
      '#markup' => '<div><h2>Upcoming deadlines (' . $now . ')</h2></div>' . implode('<br />', $actual_deadlines),
      '#cache' => ['contexts' => ['user']],
    ];

    return $build;
  }

}
