<?php

namespace OpenAI\Endpoint;

class VectorStoreFileBatches extends Base {
	/**
	 * Create a file batch for a vector store
	 * @param string $vectorStoreId The id of your vector store
	 * @param array $data Data to send (e.g., ['file_ids' => ['file_1', 'file_2']])
	 * @return object The body response as object
	 */
	public function create(string $vectorStoreId, array $data): object {
		$result = $this->client->beta()->post(sprintf("/v1/vector_stores/%s/file_batches", $vectorStoreId), $data);
		return json_decode($result);
	}

	/**
	 * Retrieve a file batch
	 * @param string $vectorStoreId The id of your vector store
	 * @param string $batchId The id of your file batch
	 * @param null|array $data Request args to send
	 * @return object The body response as object
	 */
	public function retrieve(string $vectorStoreId, string $batchId, null|array $data = null): object {
		$result = $this->client->beta()->get(sprintf("/v1/vector_stores/%s/file_batches/%s", $vectorStoreId, $batchId), $data);
		return json_decode($result);
	}

	/**
	 * Cancel a file batch
	 * @param string $vectorStoreId The id of your vector store
	 * @param string $batchId The id of your file batch
	 * @return object The body response as object
	 */
	public function cancel(string $vectorStoreId, string $batchId): object {
		$result = $this->client->beta()->post(sprintf("/v1/vector_stores/%s/file_batches/%s/cancel", $vectorStoreId, $batchId), []);
		return json_decode($result);
	}

	/**
	 * List files within a file batch
	 * @param string $vectorStoreId The id of your vector store
	 * @param string $batchId The id of your file batch
	 * @param null|array $data Request args to send (e.g., pagination)
	 * @return object The body response as object
	 */
	public function files(string $vectorStoreId, string $batchId, null|array $data = null): object {
		$result = $this->client->beta()->get(sprintf("/v1/vector_stores/%s/file_batches/%s/files", $vectorStoreId, $batchId), $data);
		return json_decode($result);
	}
}
