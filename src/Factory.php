<?php

namespace OpenAI;

use OpenAI\Endpoint\Assistants;
use OpenAI\Endpoint\ChatCompletions;
use OpenAI\Endpoint\ContainerFiles;
use OpenAI\Endpoint\Containers;
use OpenAI\Endpoint\Files;
use OpenAI\Endpoint\Messages;
use OpenAI\Endpoint\Models;
use OpenAI\Endpoint\Moderations;
use OpenAI\Endpoint\Responses;
use OpenAI\Endpoint\Runs;
use OpenAI\Endpoint\Threads;
use OpenAI\Endpoint\VectorStore;
use OpenAI\Endpoint\VectorStoreFiles;

/**
 * Factory class for constructing objects with default values
 */
class Factory {
	/**
	 * @var Client $client The client object to use.
	 */
	protected null|Client $client = null;

	/**
	 * Get client being used
	 * @param string $apiKey
	 * @return Client
	 */
	public function getClient(string $apiKey): Client {
		return new Client($apiKey);
	}

	/**
	 * Get an Assistants endpoint instance.
	 *
	 * @param string $apiKey The OpenAI API key.
	 * @return Assistants Assistants endpoint wrapper.
	 */
	public function assistants(string $apiKey): Assistants {
		return new Assistants($this->getClient($apiKey));
	}

	/**
	 * Get a Chat Completions endpoint instance.
	 *
	 * @param string $apiKey The OpenAI API key.
	 * @return ChatCompletions Chat Completions endpoint wrapper.
	 */
	public function chatCompletions(string $apiKey): ChatCompletions {
		return new ChatCompletions($this->getClient($apiKey));
	}

	/**
	 * Get a Container Files endpoint instance.
	 *
	 * @param string $apiKey The OpenAI API key.
	 * @return ContainerFiles Container Files endpoint wrapper.
	 */
	public function containerFiles(string $apiKey): ContainerFiles {
		return new ContainerFiles($this->getClient($apiKey));
	}

	/**
	 * Get a Containers endpoint instance.
	 *
	 * @param string $apiKey The OpenAI API key.
	 * @return Containers Containers endpoint wrapper.
	 */
	public function containers(string $apiKey): Containers {
		return new Containers($this->getClient($apiKey));
	}

	/**
	 * Get a Files endpoint instance.
	 *
	 * @param string $apiKey The OpenAI API key.
	 * @return Files Files endpoint wrapper.
	 */
	public function files(string $apiKey): Files {
		return new Files($this->getClient($apiKey));
	}

	/**
	 * Get a Messages endpoint instance.
	 *
	 * @param string $apiKey The OpenAI API key.
	 * @return Messages Messages endpoint wrapper.
	 */
	public function messages(string $apiKey): Messages {
		return new Messages($this->getClient($apiKey));
	}

	/**
	 * Get a Models endpoint instance.
	 *
	 * @param string $apiKey The OpenAI API key.
	 * @return Models Models endpoint wrapper.
	 */
	public function models(string $apiKey): Models {
		return new Models($this->getClient($apiKey));
	}

	/**
	 * Get a Moderations endpoint instance.
	 *
	 * @param string $apiKey The OpenAI API key.
	 * @return Moderations Moderations endpoint wrapper.
	 */
	public function moderations(string $apiKey): Moderations {
		return new Moderations($this->getClient($apiKey));
	}

	/**
	 * Get a Responses endpoint instance.
	 *
	 * @param string $apiKey The OpenAI API key.
	 * @return Responses Responses endpoint wrapper.
	 */
	public function responses(string $apiKey): Responses {
		return new Responses($this->getClient($apiKey));
	}

	/**
	 * Get a Runs endpoint instance.
	 *
	 * @param string $apiKey The OpenAI API key.
	 * @return Runs Runs endpoint wrapper.
	 */
	public function runs(string $apiKey): Runs {
		return new Runs($this->getClient($apiKey));
	}

	/**
	 * Get a Threads endpoint instance.
	 *
	 * @param string $apiKey The OpenAI API key.
	 * @return Threads Threads endpoint wrapper.
	 */
	public function threads(string $apiKey): Threads {
		return new Threads($this->getClient($apiKey));
	}

	/**
	 * Get a Vector Store endpoint instance.
	 *
	 * @param string $apiKey The OpenAI API key.
	 * @return VectorStore Vector Store endpoint wrapper.
	 */
	public function vectorStore(string $apiKey): VectorStore {
		return new VectorStore($this->getClient($apiKey));
	}

	/**
	 * Get a Vector Store Files endpoint instance.
	 *
	 * @param string $apiKey The OpenAI API key.
	 * @return VectorStoreFiles Vector Store Files endpoint wrapper.
	 */
	public function vectorStoreFiles(string $apiKey): VectorStoreFiles {
		return new VectorStoreFiles($this->getClient($apiKey));
	}
}
