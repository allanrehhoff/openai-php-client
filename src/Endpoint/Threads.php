<?php

namespace OpenAI\Endpoint;

class Threads extends Base {
	/**
	 * List all threads
	 * @param array $data Data to send
	 * @return object The body response as object
	 */
	public function create(array $data = []): object {
		$result = $this->client->beta()->post("/v1/threads", $data);
		return json_decode($result);
	}

	/**
	 * Delete a thread
	 * @param string $threadId The ID of the thread to modify.
	 * @return object
	 */
	public function delete(string $threadId): object {
		$result = $this->client->beta()->delete(sprintf("/v1/threads/%s", $threadId));
		return json_decode($result);
	}

	/**
	 * Modifies a thread.
	 * @param string $threadId The ID of the thread to modify.
	 * @param null|array $data Data to send
	 * @return object
	 */
	public function modify(string $threadId, null|array $data = null): object {
		$result = $this->client->beta()->post(sprintf("/v1/threads/%s", $threadId), $data);
		return json_decode($result);
	}

	/**
	 * Append message to thread
	 * @param string $threadId The ID of the thread to modify.
	 * @param null|array $data Data to send
	 * @return object
	 */
	public function message(string $threadId, null|array $data = null): object {
		$result = $this->client->beta()->post(sprintf("/v1/threads/%s/messages", $threadId), $data);
		return json_decode($result);
	}

	/**
	 * Create a thread and run it in one request.
	 * @param array $data Data to send
	 * @return object
	 */
	public function createAndRun(array $data): object {
		$result = $this->client->beta()->post("/v1/threads/runs", $data);
		return json_decode($result);
	}

	/**
	 * Append message to thread
	 * @param string $threadId The ID of the thread to modify.
	 * @return object
	 */
	public function retrieve(string $threadId): object {
		$result = $this->client->beta()->get(sprintf("/v1/threads/%s", $threadId));
		return json_decode($result);
	}
}
