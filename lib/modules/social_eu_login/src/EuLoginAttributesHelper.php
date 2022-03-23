<?php

declare(strict_types = 1);

namespace Drupal\social_eu_login;

/**
 * Helper functions to map EU Login attributes to user profile.
 */
class EuLoginAttributesHelper {

  /**
   * Array mapping of EU Login attributes with user account fields.
   */
  const USER_EU_LOGIN_ATTRIBUTE_MAPPING = [
    'email' => ['user' => 'mail'],
    'firstName' => ['profile' => 'field_profile_first_name'],
    'lastName' => ['profile' => 'field_profile_last_name'],
    'domain' => ['profile' => 'field_profile_organization'],
  ];

  /**
   * Converts the EU Login attributes into a Drupal field/values array.
   *
   * @param array $attributes
   *   An array containing a series of EU Login attributes.
   *
   * @return array
   *   An associative array of field values indexed by the field name.
   */
  public static function convertEuLoginAttributesToFieldValues(array $attributes): array {
    $values = [];
    foreach (static::USER_EU_LOGIN_ATTRIBUTE_MAPPING as $property_name => $field) {
      foreach ($field as $entity_type => $field_name) {
        if (!empty($attributes[$property_name])) {
          $values[$entity_type][$field_name] = $attributes[$property_name];
        }
      }
    }
    return $values;
  }

}
