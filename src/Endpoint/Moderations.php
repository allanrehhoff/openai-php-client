<?php

namespace OpenAI\Endpoint;

class Moderations extends Base {
	/**
	 * Create a moderation check
	 *
	 * @param string|array $input Single string or array of inputs to check
	 * @param null|array $data Optional additional parameters (e.g., 'model')
	 * @return object The API response as an object
	 */
	public function create(string|array $input, null|array $data = null): object {
		$payload = $data ?? [];
		$payload['input'] = $input;

		$result = $this->client->post("/v1/moderations", $payload);
		return json_decode($result);
	}
}
