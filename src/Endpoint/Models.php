<?php

namespace OpenAI\Endpoint;

class Models extends Base {
	/**
	 * List models
	 * @param null|array $data Request args to send
	 * @return object The body response as object
	 */
	public function list(null|array $data = null): object {
		$result = $this->client->get("/v1/models", $data);
		return json_decode($result);
	}

	/**
	 * Retrieve a model
	 * @param string $modelId The id of the model
	 * @param null|array $data Request args to send
	 * @return object The body response as object
	 */
	public function retrieve(string $modelId, null|array $data = null): object {
		$result = $this->client->get(sprintf("/v1/models/%s", $modelId), $data);
		return json_decode($result);
	}

	/**
	 * Delete a fine-tuned/owned model
	 * @param string $modelId The id of the model
	 * @return object The body response as object
	 */
	public function delete(string $modelId): object {
		$result = $this->client->delete(sprintf("/v1/models/%s", $modelId));
		return json_decode($result);
	}
}
