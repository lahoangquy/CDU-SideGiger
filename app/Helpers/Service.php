<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class Service
{
  static $localizeScript = [];

  function __construct()
  {
    self::$localizeScript['apiUrl'] = route('home');
    if (!empty(Auth::user())) {
      self::$localizeScript['auth'] = [
        'id' => Auth::user()->id,
        'name' => Auth::user()->name,
        'email' => Auth::user()->email,
        'role' => Auth::user()->getRoleName(),
      ];
    }
  }

  /**
   * @param  string $key
   *
   * @return array
   */
  static function getLocalizeScript(string $key)
  {
    return isset(self::$localizeScript[$key]) ? self::$localizeScript[$key] : [];
  }

  /**
   *
   * @return array
   */
  static function getAllLocalizeScript()
  {
    return self::$localizeScript;
  }

  /**
   * @param  string|array $key
   * @param  array  $value
   *
   * @return void
   */
  static function pushLocalizeScript(string $key, string|array $value)
  {
    if (!isset(self::$localizeScript[$key])) {
      self::$localizeScript[$key] = [];
    }

    if (is_array($value)) {
      self::$localizeScript[$key] = array_merge(self::$localizeScript[$key], $value);
    } else {
      self::$localizeScript[$key] = $value;
    }
  }
}
