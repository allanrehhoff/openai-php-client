<?php

namespace OpenAI\Endpoint;

class Files extends Base {
	/**
	 * Upload file to assistant
	 * @param array $data The payload
	 * @return object
	 */
	public function create(array $data): object {
		$result = $this->client->addHeader("Content-Type", "multipart/form-data")->post("/v1/files", $data);
		return json_decode($result);
	}

	/**
	 * Returns a list of files that belong to the user's organization.
	 * @return object
	 */
	public function list(): object {
		$result = $this->client->get("/v1/files");
		return json_decode($result);
	}

	/**
	 * Returns information about a specific file.
	 * @param string $fileId The ID of the file to use for this request.
	 * @return object
	 */
	public function retrieve(string $fileId): object {
		$result = $this->client->get(sprintf("/v1/files/%s", $fileId));
		return json_decode($result);
	}

	/**
	 * Delete a file.
	 * @param string $fileId The ID of the file to use for this request.
	 * @return object
	 */
	public function delete(string $fileId): object {
		$result = $this->client->delete(sprintf("/v1/files/%s", $fileId));
		return json_decode($result);
	}

	/**
	 * Returns the contents of the specified file.
	 * @param string $fileId The ID of the file to use for this request.
	 * @return string
	 */
	public function content(string $fileId): string {
		$result = $this->client->get(sprintf("/v1/files/%s/content", $fileId));
		return $result;
	}
}
