<?php

namespace Drupal\screenshot\Ajax;

use Drupal\Core\Ajax\CommandInterface;

/**
 * AJAX command to send an image base64 field formatter.
 */
class SendImageCommand implements CommandInterface {

  /**
   * The ID for the image element.
   *
   * @var string
   */
  protected $selector;

  /**
   * The url for the image element.
   *
   * @var string
   */
  protected $imageSrc;

  /**
   * The file id.
   *
   * @var int
   */
  protected $fid;

  /**
   * The input name of fid.
   *
   * @var string
   */
  private string $inputFid;

  /**
   * Constructor.
   *
   * @param string $selector
   *   The ID for the image element.
   * @param string $image_src
   *   The url image element.
   * @param string $inputFid
   *   The input fid hidden.
   * @param int $fid
   *   File id.
   */
  public function __construct($selector, $image_src, $inputFid, $fid) {
    $this->selector = $selector;
    $this->imageSrc = $image_src;
    $this->inputFid = $inputFid;
    $this->fid = $fid;
  }

  /**
   * Implements Drupal\Core\Ajax\CommandInterface:render().
   */
  public function render() {
    return [
      'command' => 'SendImage',
      'selector' => $this->selector,
      'image_src' => $this->imageSrc,
      'input_fid' => $this->inputFid,
      'fid' => $this->fid,
    ];
  }

}
