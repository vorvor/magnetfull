<?php

namespace Drupal\magnet\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\node\Entity\Node;

/**
 * Provides a states block.
 *
 * @Block(
 *   id = "magnet_revisions_block",
 *   admin_label = @Translation("Magnet revisions block"),
 *   category = @Translation("Magnet Custom Blokk"),
 * )
 */

class Revisions extends BlockBase {

	/**
   * {@inheritdoc}
   */

  public function build($nid = null) {

    $parts = explode('/', \Drupal::service('path.current')->getPath());
    if (is_null($nid) && $parts[1] == 'node' && is_numeric($parts[2])) {
      $nid = $parts[2];
    }

    $states = '';
    
    
      $node = Node::load($nid);
      if (is_null($node)) {
        return null;
      }
      
      $type_name = $node->type->entity->label();
      
      if ($type_name == 'Product') {
        $states = magnet_show_statebar($nid);
      }

    



    return [
      '#theme' => 'magnet_states',
      '#attached' => [
        'library' => [
          'magnet/statesblock',
        ],
      ],
      '#states_list' => $states['states'],
      '#next_state' => $states['next_state'],
      '#phase' => $states['phase'],
      '#nid' => $nid,
      '#user_had_permission' => $states['user_had_permission'],
    ];

   
    

  }


  public function getCacheMaxAge() {
    return 0;
}

}
