<?php

namespace OpenAI\Endpoint;

class ContainerFiles extends Base {
	/**
	 * Create a file within a container
	 * @param string $containerId The id of your container
	 * @param array $data Payload to send (e.g. file data or metadata)
	 * @return object Response body as object
	 */
	public function create(string $containerId, array $data): object {
		$result = $this->client->beta()->post(sprintf("/v1/containers/%s/files", $containerId), $data);
		return json_decode($result);
	}

	/**
	 * List files in a container
	 * @param string $containerId The id of your container
	 * @param null|array $data Optional request args
	 * @return object Response body as object
	 */
	public function list(string $containerId, null|array $data = null): object {
		$result = $this->client->beta()->get(sprintf("/v1/containers/%s/files", $containerId), $data);
		return json_decode($result);
	}

	/**
	 * Retrieve a file from a container
	 * @param string $containerId The id of your container
	 * @param string $fileId The id of the file
	 * @param null|array $data Optional request args
	 * @return object Response body as object
	 */
	public function retrieve(string $containerId, string $fileId, null|array $data = null): object {
		$result = $this->client->beta()->get(sprintf("/v1/containers/%s/files/%s", $containerId, $fileId), $data);
		return json_decode($result);
	}

	/**
	 * Delete a file from a container
	 * @param string $containerId The id of your container
	 * @param string $fileId The id of the file
	 * @return object Response body as object
	 */
	public function delete(string $containerId, string $fileId): object {
		$result = $this->client->beta()->delete(sprintf("/v1/containers/%s/files/%s", $containerId, $fileId));
		return json_decode($result);
	}
}
