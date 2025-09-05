<?php

namespace OpenAI\Endpoint;

class Responses extends Base {
	/**
	 * Create a response
	 * @param array $data Payload to send (e.g., ['model' => 'gpt-4o-mini', 'input' => 'Hello'])
	 * @return object The body response as object
	 */
	public function create(array $data): object {
		$result = $this->client->post("/v1/responses", $data);
		return json_decode($result);
	}

	/**
	 * List responses
	 * @param null|array $data Optional request args (e.g., pagination)
	 * @return object The body response as object
	 */
	public function list(null|array $data = null): object {
		$result = $this->client->get("/v1/responses", $data);
		return json_decode($result);
	}

	/**
	 * Retrieve a response
	 * @param string $responseId The id of the response
	 * @param null|array $data Optional request args
	 * @return object The body response as object
	 */
	public function retrieve(string $responseId, null|array $data = null): object {
		$result = $this->client->get(sprintf("/v1/responses/%s", $responseId), $data);
		return json_decode($result);
	}

	/**
	 * Cancel a response
	 * @param string $responseId The id of the response
	 * @return object The body response as object
	 */
	public function cancel(string $responseId): object {
		$result = $this->client->post(sprintf("/v1/responses/%s/cancel", $responseId), []);
		return json_decode($result);
	}
}
