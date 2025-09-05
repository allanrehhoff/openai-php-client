<?php

namespace OpenAI\Endpoint;

class Containers extends Base {
	/**
	 * Create a container
	 * @param array $data Payload to send
	 * @return object Response body as object
	 */
	public function create(array $data): object {
		$result = $this->client->beta()->post("/v1/containers", $data);
		return json_decode($result);
	}

	/**
	 * List containers
	 * @param null|array $data Optional request args
	 * @return object Response body as object
	 */
	public function list(null|array $data = null): object {
		$result = $this->client->beta()->get("/v1/containers", $data);
		return json_decode($result);
	}

	/**
	 * Retrieve a container
	 * @param string $containerId The id of your container
	 * @param null|array $data Optional request args
	 * @return object Response body as object
	 */
	public function retrieve(string $containerId, null|array $data = null): object {
		$result = $this->client->beta()->get(sprintf("/v1/containers/%s", $containerId), $data);
		return json_decode($result);
	}

	/**
	 * Delete a container
	 * @param string $containerId The id of your container
	 * @return object Response body as object
	 */
	public function delete(string $containerId): object {
		$result = $this->client->beta()->delete(sprintf("/v1/containers/%s", $containerId));
		return json_decode($result);
	}
}
