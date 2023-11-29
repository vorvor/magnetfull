<?php

namespace Drupal\magnet\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Term;

/**
 * Provides a states block.
 *
 * @Block(
 *   id = "magnet_my_works_block",
 *   admin_label = @Translation("Magnet my works block"),
 *   category = @Translation("Magnet Custom Blokk"),
 * )
 */

class MyWorks extends BlockBase {

	/**
   * {@inheritdoc}
   */

  public function build() {

    $myworks = '';
    $mypickups = '';
    if (\Drupal::currentUser()->isAuthenticated()) {
      // My works.
      $uid = \Drupal::currentUser()->id();
      //$uid = 457;

      $nids = \Drupal::entityQuery('node')
        ->condition('type', 'product')
        ->condition('uid', $uid)
        ->sort('nid')
        ->accessCheck(TRUE)
        ->execute();

      $products = [];
      foreach ($nids as $nid) {
        $node = Node::load($nid);
        $state_tid = $node->get('field_state')->getValue()[0]['target_id'];
        $state_obj = Term::load($state_tid);
        if (is_null($state_obj)) {

          continue;
        }

        $state_name = $state_obj->getName();

        if (strpos($state_name, 'finished') !== FALSE) {
          // Show only products in progress state, not finished.
          continue;
        }
        $products[] = $nid;
      }

      $views = views_embed_view('products', 'page_2', implode('+', $products));
      $myworks = \Drupal::service('renderer')->render($views);

      // My pickups.
      $states = magnet_get_user_state_permissions($uid);

      $products = [];
      // If user has Drawing permission add products with no state - new products in starting phase.
      if (in_array('Drawing', $states)) {
        $database = \Drupal::database();
        $query = $database->select('node', 'n');
        $query->addJoin('LEFT', 'node__field_state', 'f', 'f.entity_id = n.nid');
        $query
          ->fields('n', array('nid', 'type'))
          ->fields('f', array('field_state_target_id'))
          ->condition('n.type', 'product', '=')
          ->isNull('f.field_state_target_id')
          ->orderBy('nid', 'DESC');

        $results = $query->execute()->fetchAll();

        foreach ($results as $result) {
          $products[] = $result->nid;
        }
      }

      // User shall pickup only product, if it's in previous (finished) state of his skills.
      $prevstates = [0];
      foreach ($states as $state) {
        $prevstates[] = magnet_get_prev_state_tid($state);
        $prevstatesname[] = magnet_get_prev_state($state);
      }

      $nids = \Drupal::entityQuery('node')
        ->condition('type', 'product')
        ->condition('field_state', $prevstates, 'IN')
        ->sort('nid')
        ->accessCheck(TRUE)
        ->execute();

      foreach ($nids as $nid) {

        /* Tuners shall pickup products (and should be listed) for these works:
        Tunings and heat treatments
        Gluing
        Fine tuning
        Last check

        only if they are the tuners of that product (field_tuner).
        If not skip product.
        */

        $node = Node::load($nid);
        $state_tid = $node->get('field_state')->getValue()[0]['target_id'];
        $state_obj = Term::load($state_tid);
        $state_name = $state_obj->getName();
        $next_state = magnet_get_next_state($state_name);
        $tuner = $node->get('field_tuner')->getValue()[0]['target_id'];

        if (in_array($next_state, [
          'Tunings and heat treatments',
          'Gluing',
          'Fine tuning',
          'Last check',
        ]) && ($uid !== $tuner)) {

          continue;
        }

        $products[] = $nid;
      }

      $views = views_embed_view('products', 'page_3', implode('+', $products));
      $mypickups = \Drupal::service('renderer')->render($views);
    }


    return [
      '#theme' => 'magnet_my_works',
      '#attached' => [
        'library' => [
          'magnet/myworks',
        ],
      ],
      '#products' => [],
      '#myworks' => $myworks,
      '#mypickups' => $mypickups,
    ];




  }


  public function getCacheMaxAge() {
    return 0;
}

}
