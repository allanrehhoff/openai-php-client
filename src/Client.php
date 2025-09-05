<?php

namespace OpenAI;

use \OpenAI\Throwable\ClientError;
use \OpenAI\Throwable\ExternalServiceError;

class Client {
	/**
	 * @var array Additional custom headers to send with each request
	 */
	private array $headers = [];

	/**
	 * @var string $baseurl Baseurl of the OpennAI API
	 */
	private string $baseurl = "https://api.openai.com";

	/**
	 * @var null|string $apiKey The api key being used
	 */
	private null|string $apiKey;

	/**
	 * @param null|string $apiKey Default null
	 */
	public function __construct(null|string $apiKey = null) {
		$this->addHeader("Content-Type", "application/json");
		$this->setApiKey($apiKey);
	}

	/**
	 * @param string $method Request method
	 * @param string $endpoint Endpoint relative to domain
	 * @param mixed $data Data to send, default null.
	 * @return string|bool
	 */
	public function request(string $method, string $endpoint, mixed $data = null): string|bool {
		$responseHeaders = '';

		$ch = curl_init();

		if ($method == "GET" && $data !== null) {
			$endpoint .= (str_contains($endpoint, '?') ? '&' : '?') . http_build_query($data);
		} elseif (in_array($method, ["POST", "PUT", "PATCH", "OPTIONS", "DELETE"])) {
			if ((is_array($data) || is_object($data)) && $this->headers["Content-Type"] == "application/json") {
				$json = json_encode($data, flags: JSON_THROW_ON_ERROR);
			} else {
				$json = $data;
			}

			curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		}

		$headers = [];
		foreach ($this->headers as $name => $value) {
			$headers[] = sprintf("%s: %s", $name, $value);
		}

		$url = $this->baseurl . "/" . ltrim($endpoint, '/');

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		curl_setopt($ch, CURLOPT_HEADERFUNCTION, function (\CurlHandle $curl, string $header) use (&$responseHeaders) {
			$responseHeaders .= $header;
			return strlen($header);
		});

		$response = curl_exec($ch);
		$curlInfo = curl_getinfo($ch);

		if (curl_errno($ch) != CURLE_OK) {
			throw new ClientError('cURL error: ' . curl_error($ch));
		}

		if ($curlInfo["http_code"] >= 400) {
			throw new ExternalServiceError('OpenAI request failed, response: ' . $response);
		}

		curl_close($ch);
		$ch = null;

		return $response;
	}

	/**
	 * @param string $endpoint
	 * @param array $data
	 */
	public function get(string $endpoint, null|array $data = null) {
		return $this->request("GET", $endpoint, $data);
	}

	/**
	 * @param string $endpoint
	 * @param mixed $data
	 */
	public function post(string $endpoint, mixed $data = null) {
		return $this->request("POST", $endpoint, $data);
	}

	/**
	 * @param string $endpoint
	 * @param mixed $data
	 */
	public function patch(string $endpoint, mixed $data = null) {
		return $this->request("PATCH", $endpoint, $data);
	}

	/**
	 * @param string $endpoint
	 * @param mixed $data
	 */
	public function options(string $endpoint, mixed $data = null) {
		return $this->request("OPTIONS", $endpoint, $data);
	}

	/**
	 * @param string $endpoint
	 * @param mixed $data
	 */
	public function put(string $endpoint, mixed $data = null) {
		return $this->request("PUT", $endpoint, $data);
	}

	/**
	 * @param string $endpoint
	 * @param mixed $data
	 */
	public function delete(string $endpoint, mixed $data = null) {
		return $this->request("DELETE", $endpoint, $data);
	}

	/**
	 * Adds a custom header for this client to send
	 * @param string $name Name of the header
	 * @param string $value Value of the header
	 * @return Client
	 */
	public function addHeader(string $name, string $value): Client {
		$this->headers[$name] = $value;
		return $this;
	}

	/**
	 * @param string $apiKey The API key to use
	 */
	public function setApiKey(null|string $apiKey = null): void {
		$this->addHeader("Authorization", sprintf(
			"Bearer %s",
			$apiKey
		));
	}

	/**
	 * Opt-in for beta API usage
	 * @return Client
	 */
	public function beta(): Client {
		$this->addHeader("OpenAI-Beta", "assistants=v2");
		return $this;
	}
}
