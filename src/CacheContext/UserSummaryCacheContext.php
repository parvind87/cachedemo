<?php

namespace Drupal\cachedemo\CacheContext;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Cache\Context\CacheContextInterface;
use Drupal\Core\Session\AccountProxy;
use Drupal\user\Entity\User;

/**
 * Class UserSummaryCacheContext.
 */
class UserSummaryCacheContext implements CacheContextInterface
{
    /**
       * @var \Drupal\Core\Session\AccountProxyInterface
       */
    protected $user_current;

    /**
     * Constructs a new UserSummaryCacheContext object.
     */
    public function __construct(AccountProxy $user_current)
    {
      $this->user_current = $user_current;
    }

    /**
     * {@inheritdoc}
     */
    public static function getLabel()
    {
        \Drupal::messenger()->addMessage('Lable of cache context');
        return t('User Summary cache context');
    }

    /**
     * {@inheritdoc}
     */
    public function getContext()
    {
        // Actual logic of context variation will lie here.
        $id = $this->user_current->id();
        $user_details = User::load($id);
        $summary = $user_details->get('field_summary')->getValue()[0]['value'];
        return $summary;
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheableMetadata()
    {
        return new CacheableMetadata();
    }
}
