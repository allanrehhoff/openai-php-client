<?php

namespace OpenAI\Endpoint;

class Runs extends Base {
	/**
	 * Create a run
	 * @param string $threadId The ID of the thread to run.
	 * @param array $data Data to send
	 * @return object
	 */
	public function create(string $threadId, array $data): object {
		$result = $this->client->beta()->post(sprintf("/v1/threads/%s/runs", $threadId), $data);
		return json_decode($result);
	}

	/**
	 * Returns a list of runs belonging to a thread.
	 * @param string $threadId The ID of the thread to run.
	 * @param null|array $data Data to send
	 * @return object
	 */
	public function list(string $threadId, null|array $data = null): object {
		$result = $this->client->beta()->get(sprintf("/v1/threads/%s/runs", $threadId), $data);
		return json_decode($result);
	}

	/**
	 * Retrieves a run.
	 * @param string $threadId The ID of the thread that was run.
	 * @param string $runId The ID of the run to retrieve.
	 * @return object
	 */
	public function retrieve(string $threadId, string $runId): object {
		$result = $this->client->beta()->get(sprintf("/v1/threads/%s/runs/%s", $threadId, $runId));
		return json_decode($result);
	}

	/**
	 * Modifies a run.
	 * @param string $threadId The ID of the thread that was run.
	 * @param string $runId The ID of the run to retrieve.
	 * @param array $data Data to send
	 * @return object
	 */
	public function modify(string $threadId, string $runId, array $data): object {
		$result = $this->client->beta()->post(sprintf("/v1/threads/%s/runs/%s", $threadId, $runId), $data);
		return json_decode($result);
	}

	/**
	 * Cancels a run.
	 * @param string $threadId The ID of the thread that was run.
	 * @param string $runId The ID of the run to retrieve.
	 * @return object
	 */
	public function cancel(string $threadId, string $runId): object {
		$result = $this->client->beta()->post(sprintf("/v1/threads/%s/runs/%s/cancel", $threadId, $runId));
		return json_decode($result);
	}

	/**
	 * When a run has the status: "requires_action" and required_action.type is submit_tool_outputs,
	 * this endpoint can be used to submit the outputs from the tool calls once they're all completed.
	 * All outputs must be submitted in a single request.
	 * @param string $threadId The ID of the thread that was run.
	 * @param string $runId The ID of the run to retrieve.
	 * @return object
	 */
	public function submitToolOutput(string $threadId, string $runId): object {
		$result = $this->client->beta()->post(sprintf("/v1/threads/%s/runs/%s/submit_tool_outputs", $threadId, $runId));
		return json_decode($result);
	}
}
