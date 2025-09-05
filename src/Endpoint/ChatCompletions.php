<?php

namespace OpenAI\Endpoint;

class ChatCompletions extends Base {
	/**
	 * Get chat completion by ID
	 *
	 * @param string $completionId
	 * @return void
	 */
	public function list() {
		return $this->client->get("/v1/chat/completions");
	}

	/**
	 * Get chat completion by ID
	 *
	 * @param string $completionId
	 * @return void
	 */
	public function retrieve(string $completionId) {
		return $this->client->get(sprintf(
			"/v1/chat/completions/%s",
			$completionId
		));
	}

	/**
	 * Update a chat completion by id
	 *
	 * @param string $completionId
	 * @param array $data
	 * @return void
	 */
	public function update(string $completionId, array $data) {
		$result = $this->client->post(sprintf(
			"/v1/chat/completions/%s",
			$completionId
		), $data);
		return json_decode($result);
	}

	/**
	 * Delete chat completion
	 *
	 * @param string $completionId
	 * @return void
	 */
	public function delete(string $completionId) {
		return $this->client->delete(sprintf(
			"/v1/chat/completions/%s",
			$completionId
		));
	}

	/**
	 * Create chat completion
	 *
	 * @param array $data
	 * @return object
	 */
	public function create(array $data): object {
		$data = $this->filter($data, [
			'messages' => ["model", "role", "content"],
			'model' => null,
			'temperature' => null,
			'max_tokens' => null,
			'top_logprobs' => null,
			'n' => null,
			'top_p' => null,
			'frequency_penalty' => null,
			'logit_bias' => null,
			'presence_penalty' => null,
			'response_format' => null,
			'stop' => null,
			'seed' => null,
			'stream' => null,
			'tools' => null,
			'tool_choid' => null,
			'user' => null
		]);
		$result = $this->client->post("/v1/chat/completions", $data);

		return json_decode($result);
	}

	/**
	 * Recursively filters data based on allowed fields.
	 *
	 * @param array $data The data to filter.
	 * @param array $allowFields The allowed fields and their sub-fields if any.
	 * @return array The filtered data.
	 */
	private function filter(array $data, array $allowFields): array {
		$filtered = [];

		foreach ($data as $key => $value) {
			if (!array_key_exists($key, $allowFields)) {
				continue; // Skip fields not allowed
			}

			// If the field is an array of allowed sub-fields
			// Recursively filter sub-array items based on sub-fields
			if (is_array($allowFields[$key])) {
				if (is_array($value)) {
					$subFields = $allowFields[$key];
					$filtered[$key] = array_map(function ($item) use ($subFields) {
						return $this->filter($item, array_flip($subFields));
					}, $value);
				}
			} else {
				// For simple fields, just copy the value
				$filtered[$key] = $value;
			}
		}

		return $filtered;
	}
}
