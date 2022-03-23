<?php

namespace Drupal\oec_core_footer\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements settings for OEC Core Footer module.
 */
class OecCoreFooterSettingsForm extends ConfigFormBase {

  /**
   * The settings ID.
   *
   * @const string
   */
  const SETTINGS = 'oec_core_footer.settings';

  /**
   * An array with social media links names.
   *
   * @const string
   */
  const SOCIAL_MEDIA_LINKS = ['facebook', 'twitter', 'instagram'];

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {
    return [self::SETTINGS];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'oec_core_footer_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form = parent::buildForm($form, $form_state);
    $settings = $this->config(self::SETTINGS);

    // Vertical tab field group.
    $form['settings_tabs'] = [
      '#type' => 'vertical_tabs',
    ];
    // Wrapper for "Footer style" form field.
    $form['footer_style_wrapper'] = [
      '#type' => 'details',
      '#title' => $this->t('Footer style'),
      '#group' => 'settings_tabs',
    ];
    // "Footer style" element itself.
    $form['footer_style_wrapper']['footer_style'] = [
      '#type' => 'select',
      '#title' => $this->t('Footer style'),
      '#description' => $this->t('Select how footer will look like.'),
      '#options' => [
        'ec' => $this->t('EC'),
        'eu' => $this->t('EU'),
      ],
      '#default_value' => $settings->get('footer_style'),
      '#group' => 'footer_style_wrapper',
    ];
    // Wrapper for "Social medial links" form field.
    $form['social_media_links'] = [
      '#type' => 'details',
      '#title' => $this->t('Social media links'),
      '#tree' => TRUE,
      '#group' => 'settings_tabs',
    ];
    // "Social medial link" form field itself.
    foreach (self::SOCIAL_MEDIA_LINKS as $name) {
      $title = ucfirst($name);
      $form['social_media_links'][$name] = [
        '#type' => 'textfield',
        // @codingStandardsIgnoreLine
        '#title' => $this->t($title),
        '#description' => $this->t('Type an external link here.'),
        '#default_value' => $settings->get("social_media_links.{$name}"),
        '#group' => 'social_media_links_wrapper',
      ];
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    parent::submitForm($form, $form_state);

    $config = $this->config(self::SETTINGS);
    $config->set('footer_style', $form_state->getValue('footer_style'));
    $config->set('social_media_links', $form_state->getValue('social_media_links'));
    $config->save();
  }

}
