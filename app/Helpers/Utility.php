<?php

namespace App\Helpers;

use Symfony\Component\HttpFoundation\StreamedResponse;
use GuzzleHttp\Client;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Carbon;

class Utility
{
	/**
	 * @param  string  $msg
	 * @param  integer $statusCode
	 *
	 * @return mixed
	 */
	static function die(string $msg = '', int $statusCode = 400)
	{
		throw new HttpResponseException(
			response()->json([
				'status' => 'error',
				'msg' => !empty($msg) ? $msg : 'You don’t have permission to access this item!',
			], $statusCode)
		);
	}

	/**
	 * @param  integer $length
	 *
	 * @return string
	 */
	static function strRand(int $length = 10)
	{
		return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ~!@#$%^&*()', ceil($length / strlen($x)))), 1, $length);
	}

	/**
	 * @param  array  $array
	 * @param  string $field
	 *
	 * @return void
	 */
	static function sort(array &$array, string $field = 'priority')
	{
		uasort($array, function ($a, $b) use ($field) {
			return ((isset($a[$field]) ? $a[$field] : 10) > (isset($b[$field]) ? $b[$field] : 10)) ? 1 : -1;
		});
	}

	/**
	 * @param  array  $array
	 * @param  string $field
	 *
	 * @return void
	 */
	static function rsort(array &$array, string $field = 'priority')
	{
		uasort($array, function ($a, $b) use ($field) {
			return ((isset($a[$field]) ? $a[$field] : 10) > (isset($b[$field]) ? $b[$field] : 10)) ? -1 : 1;
		});
	}

	/**
	 * @param  array $array
	 *
	 * @return array
	 */
	static function array_unique(array $array)
	{
		$array = array_map('json_encode', $array);
		$array = array_unique($array);
		return array_map(function ($item) {
			return json_decode($item, true);
		}, $array);
	}

	/**
	 * @param string $text
	 *
	 * @return void
	 */
	static function dataEncode(string|array $text = '')
	{
		$data = '';
		if (!empty($text)) {
			$data = base64_encode(rawurlencode(@json_encode($text)));
		}
		return $data;
	}

	/**
	 * @param  string $text
	 * @param  mixed  $default
	 *
	 * @return mixed
	 */
	static function dataDecode(string $text = '', mixed $default = null)
	{
		$data = array();
		if (!empty($text)) {
			$data = @json_decode(rawurldecode(base64_decode($text)), true);
		}
		if (empty($data)) {
			return $default;
		}
		return $data;
	}
}
