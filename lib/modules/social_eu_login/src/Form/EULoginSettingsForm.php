<?php

namespace Drupal\social_eu_login\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Render\Element\Checkboxes;

/**
 * Build a settings form for Social EU Login module.
 *
 * @package Drupal\social_eu_login\Form
 */
class EULoginSettingsForm extends ConfigFormBase {

  /**
   * The settings config identifier.
   *
   * @const
   */
  const CONFIG_NAME = 'social_eu_login.settings';

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {
    return [self::CONFIG_NAME];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'social_eu_login_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $config = $this->config(self::CONFIG_NAME);

    $form['disabled_fields_sync'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Disable EU Login synchronization for fields:'),
      '#description' => $this->t('The chosen fields will be disabled from synchronization when user sign up with EU Login.'),
      '#options' => [
        'field_profile_organization' => $this->t('Organization'),
      ],
      '#default_value' => $config->get('disabled_fields_sync') ?? [],
    ];

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save configuration'),
      '#button_type' => 'primary',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->config(self::CONFIG_NAME)
      ->set('disabled_fields_sync', Checkboxes::getCheckedCheckboxes($form_state->getValue('disabled_fields_sync')))
      ->save();
  }

}
