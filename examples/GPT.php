<?php

use OpenAI\Factory;

class GPT {
	/**
	 * Returns OpenAI API key secret.
	 * Stores the API key statically for the
	 * remainder of the request to save I/O
	 * @return string
	 */
	private static function getApiKey(): string {
		return getenv('OPENAI_API_KEY');
	}

	/**
	 * Creates a new Open AI Client with the given API token.
	 * @param array $payload
	 * @return object
	 */
	public static function prompt(array $payload): object {
		$iChat = (new Factory)->chat(static::getApiKey());
		return $iChat->completions($payload);
	}

	/**
	 * Create a thread
	 * @param array $payload Data to send
	 * @return object
	 */
	public static function createThread(array $payload = []): object {
		$iThreads = (new Factory)->threads(static::getApiKey());
		return $iThreads->create($payload);
	}

	/**
	 * Get a thread
	 * @param array $payload Data to send
	 * @return object
	 */
	public static function getThread(string $threadId): object {
		$iThreads = (new Factory)->threads(static::getApiKey());
		return $iThreads->retrieve($threadId);
	}

	/**
	 * Delete a thread
	 * @param string $threadId Data to send
	 * @return object
	 */
	public static function deleteThread(string $threadId): object {
		$iThreads = (new Factory)->threads(static::getApiKey());
		return $iThreads->delete($threadId);
	}

	/**
	 * Rertrieve information about a file
	 * @param string $fileId OpenAI provided file id
	 * @return object
	 */
	public static function getFile(string $fileId): object {
		$iFiles = (new Factory)->files(static::getApiKey());
		return $iFiles->retrieve($fileId);
	}

	/**
	 * Returns the contents of the specified file.
	 * @param string $fileId OpenAI provided file id
	 * @return string
	 */
	public static function getFileContent(string $fileId): string {
		$iFiles = (new Factory)->files(static::getApiKey());
		return $iFiles->content($fileId);
	}

	/**
	 * Create an OpenAI "run" and poll it until it's not longer running.
	 * Invokes provided callback function when "run" is completed.
	 * @param string $threadId The ID (from API) of the thread to create a message for.
	 * @param array $data Key value pairs of the request body
	 * @return object
	 */
	public static function createMessage(string $threadId, array $payload): object {
		$iThreads = (new Factory)->threads(static::getApiKey());
		return $iThreads->message($threadId, $payload);
	}

	/**
	 * Returns a list of messages for a given thread.
	 * @param string $threadId The ID (from API) of the thread to retrieve messages from
	 * @return object
	 */
	public static function listMessages(string $threadId): object {
		$iMessages = (new Factory)->messages(static::getApiKey());
		return $iMessages->list($threadId);
	}

	/**
	 * Create run and poll until it's completed
	 * @param string $threadId The ID (from API) of the thread to create a message for.
	 * @param array $data Key value pairs of the request body
	 */
	public static function runAndWaitUntilDone(string $threadId, array $payload): object {
		$iRuns = (new Factory)->runs(static::getApiKey());
		$iStdClass = $iRuns->create($threadId, $payload);

		while (is_null($iStdClass->completed_at) && is_null($iStdClass->failed_at) && is_null($iStdClass->cancelled_at) && $iStdClass->expires_at > time()) {
			usleep(333);
			$iStdClass = $iRuns->retrieve($threadId, $iStdClass->id);
		}

		return $iStdClass;
	}

	/**
	 * Creates a new Open AI Client with the given API token.
	 * @param array $payload Data to send
	 * @return object
	 */
	public static function getAssistants(array $payload = []): object {
		$iAssistants = (new Factory)->assistants(static::getApiKey());
		return $iAssistants->list($payload);
	}
}
