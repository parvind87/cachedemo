<?php

namespace Drupal\cachedemo\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\user\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Provides a 'UserSummary' block.
 *
 * @Block(
 *  id = "user_summary",
 *  admin_label = @Translation("User summary"),
 * )
 */
class UserSummary extends BlockBase {

  /**
   * {@inheritdoc}
   */
  // protected $cacheBackend;
  // public function __construct(
  //   CacheBackendInterface $cache_backend
  // ) {
  //   $this->cacheBackend = $cache_backend;
  // }

  

  public function build() {
    $start_time = microtime(TRUE);
    $tags = array(
      'my_custom_tag'
     );

    if ($cache = \Drupal::cache()->get('cache_example_files_count',CacheBackendInterface::CACHE_PERMANENT,$tags)) {
      $files_count = $cache->data;
      $source = 'Cache';
    }
    else {
      $files_count = count(file_scan_directory('core', '/.php/'));
      \Drupal::cache()->set('cache_example_files_count', $files_count, CacheBackendInterface::CACHE_PERMANENT,$tags);
      $source = 'No Cache';
    }
    $build = [];
    $UserId = \Drupal::currentUser()->id();
    $user = User::load($UserId);
    $summary = $user->get('field_summary')->getValue()[0]['value'];
     $end_time = microtime(TRUE);
     $duration = $end_time - $start_time;
    $summary.= number_format($duration * 1000, 2); 
    $summary.='<br>'.$source;
    $build['user_summary'] = [
			'#markup' => $summary
    ]; 
    return $build;
  }
  public function getCacheContexts() {
  	return Cache::mergeContexts(
  		parent::getCacheContexts(),
  		['user_summary']
  	);
  }

}
