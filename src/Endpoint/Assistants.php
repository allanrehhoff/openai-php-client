<?php

namespace OpenAI\Endpoint;

class Assistants extends Base {
	/**
	 * Create an assistant with a model and instructions.
	 * @param array $data Data to send
	 * @return object The body response as object
	 */
	public function create(array $data = []): object {
		$result = $this->client->beta()->post("/v1/assistants", $data);
		return json_decode($result);
	}

	/**
	 * List all assistnats
	 * @param null|array $data Data to send
	 * @return object The body response as object
	 */
	public function list(null|array $data): object {
		$result = $this->client->beta()->get("/v1/assistants", $data);
		return json_decode($result);
	}

	/**
	 * Retrieves an assistant.
	 * @param string $assistantId
	 * @param array $data
	 * @return object The response body as object
	 */
	public function retrieve(string $assistantId): object {
		$result = $this->client->beta()->get(sprintf("/v1/assistants/%s", $assistantId));
		return json_decode($result);
	}

	/**
	 * Modifies an assistant.
	 * @param string $assistantId
	 * @param array $data
	 * @return object The response body as object
	 */
	public function modify(string $assistantId, array $data): object {
		$result = $this->client->beta()->post(sprintf("/v1/assistants/%s", $assistantId), $data);
		return json_decode($result);
	}

	/**
	 * Deletes an assistant.
	 * @param string $assistantId
	 * @param array $data
	 * @return object The response body as object
	 */
	public function delete(string $assistantId): object {
		$result = $this->client->beta()->delete(sprintf("/v1/assistants/%s", $assistantId));
		return json_decode($result);
	}
}
