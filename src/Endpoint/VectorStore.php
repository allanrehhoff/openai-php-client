<?php

namespace OpenAI\Endpoint;

class VectorStore extends Base {
	/**
	 * Create a vector store
	 * @param array $data Data to send
	 * @return object The body response as object
	 */
	public function create(array $data): object {
		$result = $this->client->beta()->post("/v1/vector_stores", $data);
		return json_decode($result);
	}

	/**
	 * List vector stores
	 * @param null|array $data Request args to send
	 * @return object The body response as object
	 */
	public function list(null|array $data = null): object {
		$result = $this->client->beta()->get("/v1/vector_stores", $data);
		return json_decode($result);
	}

	/**
	 * Retrieve a vector store
	 * @param string $vectorStoreId The id of your vector store
	 * @param null|array $data Request args to send
	 * @return object The body response as object
	 */
	public function retrieve(string $vectorStoreId, null|array $data = null): object {
		$result = $this->client->beta()->get(sprintf("/v1/vector_stores/%s", $vectorStoreId), $data);
		return json_decode($result);
	}

	/**
	 * Update a vector store
	 * @param string $vectorStoreId The id of your vector store
	 * @param array $data Data to send
	 * @return object The body response as object
	 */
	public function update(string $vectorStoreId, array $data): object {
		$result = $this->client->beta()->post(sprintf("/v1/vector_stores/%s", $vectorStoreId), $data);
		return json_decode($result);
	}

	/**
	 * Delete a vector store
	 * @param string $vectorStoreId The id of your vector store
	 * @return object The body response as object
	 */
	public function delete(string $vectorStoreId): object {
		$result = $this->client->beta()->delete(sprintf("/v1/vector_stores/%s", $vectorStoreId));
		return json_decode($result);
	}
}
?>
