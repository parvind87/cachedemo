<?php

namespace Drupal\cachedemo\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class CachedemoController.
 */
class CachedemoController extends ControllerBase {

  /**
   * Cachedemo.
   *
   * @return string
   *   Return Hello string.
   */
  public function cachedemo() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Demonstration of Cache Demo')
    ];
  }

}
