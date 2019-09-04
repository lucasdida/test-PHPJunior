<?php

namespace App\API;

class ApiError
{
	public static function errorMessage($message, $code)
	{
		return [
			'data' => [
				'mensagem' => $message,
				'código' => $code
			]
		];
	}
}