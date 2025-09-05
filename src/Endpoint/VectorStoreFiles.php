<?php

namespace OpenAI\Endpoint;

class VectorStoreFiles extends Base {
	/**
	 * @param string $vectorStoreId The id of your vector store
	 * @param array $data Data to send
	 * @return object The body response as object
	 */
	public function create(string $vectorStoreId, array $data): object {
		$result = $this->client->beta()->post(sprintf("/v1/vector_stores/%s/files", $vectorStoreId), $data);
		return json_decode($result);
	}

	/**
	 * List vector store files
	 * @param string $vectorStoreId The id of your vector store
	 * @param null|array $data Request args to send
	 * @return object The body response as object
	 */
	public function list(string $vectorStoreId, null|array $data = null): object {
		$result = $this->client->beta()->get(sprintf("/v1/vector_stores/%s/files", $vectorStoreId), $data);
		return json_decode($result);
	}

	/**
	 * List vector store files
	 * @param string $vectorStoreId The id of your vector store
	 * @param string $fileId The id of your file
	 * @param null|array $data Request args to send
	 * @return object The body response as object
	 */
	public function retrieve(string $vectorStoreId, string $fileId, null|array $data = null): object {
		$result = $this->client->beta()->get(sprintf("/v1/vector_stores/%s/files/%s", $vectorStoreId, $fileId), $data);
		return json_decode($result);
	}

	/**
	 * Delete vector store file
	 * @param string $vectorStoreId The id of your vector store
	 * @param string $fileId The id of your file
	 * @return object The body response as object
	 */
	public function delete(string $vectorStoreId, string $fileId): object {
		$result = $this->client->beta()->delete(sprintf("/v1/vector_stores/%s/files/%s", $vectorStoreId, $fileId));
		return json_decode($result);
	}

	/**
	 * Update vector store file attributes
	 * @param string $vectorStoreId The id of your vector store
	 * @param string $fileId The id of your file
	 * @param array $data Data to send
	 * @return object The body response as object
	 */
	public function update(string $vectorStoreId, string $fileId, array $data): object {
		$result = $this->client->beta()->post(sprintf("/v1/vector_stores/%s/files/%s", $vectorStoreId, $fileId), $data);
		return json_decode($result);
	}
}
