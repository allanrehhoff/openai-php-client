<?php
	namespace OpenAI\Endpoint;

	/**
	 * The endpoint base class that all endpoint-related
	 * classes should extend upon.
	 */
	class Base {
		protected $client;

		/**
		 * Constructor for the 'Base' class.
		 *
		 * @param mixed $client The client instance used to interact with the OpenAI API.
		 */
		public function __construct($client) {
			$this->client = $client;
		}
	}