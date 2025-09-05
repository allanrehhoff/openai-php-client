<?php

namespace OpenAI\Endpoint;

class Messages extends Base {
	/**
	 * Create a message.
	 * @param string $threadId The ID of the thread to create a message for.
	 * @return object
	 */
	public function create(string $threadId, array $data): object {
		$result = $this->client->beta()->post(sprintf("/v1/threads/%s/messages", $threadId), $data);
		return json_decode($result);
	}

	/**
	 * Returns a list of messages for a given thread.
	 * @param string $threadId The ID of the thread the messages belong to.
	 * @return object
	 */
	public function list(string $threadId): object {
		$result = $this->client->beta()->get(sprintf("/v1/threads/%s/messages", $threadId));
		return json_decode($result);
	}

	/**
	 * Retrieve a message.
	 * @param string $threadId The ID of the thread to create a message for.
	 * @param string $messageId The ID of the message to retrieve.
	 * @return object
	 */
	public function retrieve(string $threadId, string $messageId): object {
		$result = $this->client->beta()->get(sprintf("/v1/threads/%s/messages/%s", $threadId, $messageId));
		return json_decode($result);
	}

	/**
	 * Retrieve a message.
	 * @param string $threadId The ID of the thread to create a message for.
	 * @param string $messageId The ID of the message to retrieve.
	 * @return object
	 */
	public function modify(string $threadId, string $messageId, array $data): object {
		$result = $this->client->beta()->post(sprintf("/v1/threads/%s/messages/%s", $threadId, $messageId), $data);
		return json_decode($result);
	}

	/**
	 * Delete a message.
	 * @param string $threadId The ID of the thread to create a message for.
	 * @param string $messageId The ID of the message to retrieve.
	 * @return object
	 */
	public function delete(string $threadId, string $messageId): object {
		$result = $this->client->beta()->delete(sprintf("/v1/threads/%s/messages/%s", $threadId, $messageId));
		return json_decode($result);
	}
}
