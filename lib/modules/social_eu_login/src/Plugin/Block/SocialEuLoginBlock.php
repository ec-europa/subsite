<?php

declare(strict_types=1);

namespace Drupal\social_eu_login\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Menu\MenuLinkTreeInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a block that renders links to login or logout.
 *
 * @Block(
 *  id = "social_eu_login_block",
 *  admin_label = @Translation("Social EU Login Block"),
 *   context_definitions = {
 *     "user" = @ContextDefinition("entity:user")
 *   }
 * )
 */
class SocialEuLoginBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\Core\Session\AccountProxy definition.
   */
  protected AccountProxyInterface $currentUser;

  /**
   * The menu tree.
   */
  protected MenuLinkTreeInterface $menuTree;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, AccountProxyInterface $current_user, MenuLinkTreeInterface $menu_tree) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->currentUser = $current_user;
    $this->menuTree = $menu_tree;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): self {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_user'),
      $container->get('menu.link_tree'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    $links = [];
    if ($this->currentUser->isAnonymous()) {
      $links['login'] = [
        '#type' => 'account_header_element',
        '#title' => $this->t('Log in'),
        '#label' => $this->t('Log in'),
        '#url' => Url::fromRoute('<none>'),
        '#wrapper_attributes' => [
          'class' => ['dropdown'],
        ],
      ];
      // Always show Log in link first for Anonymous User.
      $links['login']['sign_in'] = [
        '#type' => 'link',
        '#title' => $this->t('Sign in with the EU Login'),
        '#url' => Url::fromRoute('user.login'),
      ];

      // Show all custom menu links from User account menu for Anonymous User.
      $menu_name = 'account';
      $parameters = $this->menuTree->getCurrentRouteMenuTreeParameters($menu_name);
      $tree = $this->menuTree->load($menu_name, $parameters);
      $manipulators = [
        ['callable' => 'menu.default_tree_manipulators:checkAccess'],
        ['callable' => 'menu.default_tree_manipulators:generateIndexAndSort'],
      ];
      $tree = $this->menuTree->transform($tree, $manipulators);
      foreach ($tree as $item) {
        if ($item->link->isEnabled() && $item->link->getProvider() === 'menu_link_content') {
          $title = $item->link->getTitle();
          $url = $item->link->getUrlObject();
          $links['login'][] = [
            '#type' => 'link',
            '#title' => $title,
            '#url' => $url,
          ];
        }
      }
    }
    else {
      // Always show 'Logged in as' and 'Log out' links for Logged in User.
      /** @var \Drupal\Core\Session\AccountInterface $account */
      $account = $this->getContextValue('user');
      $account_name = $account->getDisplayName();
      $links['logged_in'] = [
        '#type' => 'account_header_element',
        '#title' => $this->t('Logged in'),
        '#label' => $this->t('Logged in'),
        '#url' => Url::fromRoute('<none>'),
        '#wrapper_attributes' => [
          'class' => ['dropdown'],
        ],
      ];
      $links['logged_in']['signed_in_as'] = [
        '#type' => 'inline_template',
        '#template' => '<a href="/user">{{ tagline }}<strong class="text-truncate">{{ object }} </strong></a>',
        '#context' => [
          'tagline' => $this->t('Signed in as'),
          'object' => $account_name,
        ],
      ];

      $links['logged_in']['logout'] = [
        '#type' => 'link',
        '#title' => $this->t('Log out'),
        '#url' => Url::fromRoute('user.logout'),
      ];
    }

    $block = [
      '#attributes' => [
        'class' => ['navbar-user'],
      ],
      'menu_items' => [
        '#theme' => 'item_list',
        '#list_type' => 'ul',
        '#attributes' => [
          'class' => ['nav', 'navbar-nav'],
        ],
        '#items' => $links,
      ],
    ];

    return $block;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheContexts(): array {
    return Cache::mergeContexts(parent::getCacheContexts(), ['user.roles:anonymous']);
  }

}
