# OpenAI PHP API Client
A dependency-free PHP client for interacting with OpenAI's API.

> [!NOTE]
> The OpenAI API changes quickly.  
> Endpoints marked beta add the header `OpenAI-Beta: assistants=v2` automatically.

## Installing the library
Copy the `src/` directory into your application and configure PSR-4 autoloading so that the `OpenAI\` namespace maps to `src/`.

## Obtaining an API Key
To use this library, you'll need an API key from OpenAI.

1. Go to https://platform.openai.com/
2. Create an account and generate an API key
3. Set `OPENAI_API_KEY` in your environment or modify getClient accordingly.

## Using the `OpenAI\Factory` class
The `OpenAI\Factory` class simplifies creating endpoint clients. See `examples/GPT.php` for a wrapper pattern.

## Initializing the Client
```php
<?php

function getClient(): OpenAI\Client {
    $apiKey = getenv('OPENAI_API_KEY');
    return (new \OpenAI\Factory())->getClient($apiKey);
}
```

## Usage examples
Below are minimal snippets for each supported endpoint under `src/Endpoint`.

```php
<?php

$apiKey  = getenv('OPENAI_API_KEY');
$factory = new \OpenAI\Factory();
```

### Chat Completions
```php
$chat = $factory->chatCompletions($apiKey);

$resp = $chat->create([
    'model' => 'gpt-4o-mini',
    'messages' => [
        ['role' => 'user', 'content' => 'Hello there']
    ]
]);

// Other operations
$chat->list();
$chat->retrieve($resp->id);
$chat->update($resp->id, ['metadata' => ['topic' => 'demo']]);
$chat->delete($resp->id);
```

### Assistants (beta)
```php
$assistants = $factory->assistants($apiKey);

$asst = $assistants->create([
    'name' => 'Helper',
    'model' => 'gpt-4o-mini',
    'instructions' => 'Be helpful.'
]);

$assistants->list();
$assistants->retrieve($asst->id);
$assistants->modify($asst->id, ['description' => 'General helper']);
$assistants->delete($asst->id);
```

### Threads (beta)
```php
$threads = $factory->threads($apiKey);

$thread = $threads->create();
$threads->retrieve($thread->id);
$threads->modify($thread->id, ['metadata' => ['ticket' => '123']]);
$threads->message($thread->id, ['role' => 'user', 'content' => 'Hi!']);

// Create and run in one request
$threads->createAndRun([
    'assistant_id' => 'asst_...',
    'thread' => [ 'messages' => [['role' => 'user', 'content' => 'Start!']] ]
]);

$threads->delete($thread->id);
```

### Messages (beta)
```php
$messages = $factory->messages($apiKey);

$msg = $messages->create($thread->id, ['role' => 'user', 'content' => 'Question?']);
$messages->list($thread->id);
$messages->retrieve($thread->id, $msg->id);
$messages->modify($thread->id, $msg->id, ['metadata' => ['source' => 'faq']]);
$messages->delete($thread->id, $msg->id);
```

### Runs (beta)
```php
$runs = $factory->runs($apiKey);

$run = $runs->create($thread->id, ['assistant_id' => 'asst_...']);
$runs->list($thread->id);
$runs->retrieve($thread->id, $run->id);
$runs->modify($thread->id, $run->id, ['metadata' => ['priority' => 'high']]);
$runs->cancel($thread->id, $run->id);

// If run requires tool output
$runs->submitToolOutput($thread->id, $run->id);
```

#### Run and wait until it's completed
```php
function runAndWaitUntilDone(string $threadId, array $payload): object {
	$factory = getClient();

    $runs = $factory->runs($apiKey);
    $run = $runs->create($threadId, $payload);

    while (is_null($run->completed_at) && is_null($run->failed_at) && is_null($run->cancelled_at) && $run->expires_at > time()) {
        usleep(333);
        $run = $runs->retrieve($threadId, $run->id);
    }

    return $run;
}
```

### Files
```php
$files = $factory->files($apiKey);

// Upload (multipart/form-data). Provide your own file handle/path.
$uploaded = $files->create([
    // e.g.: 'file' => new CURLFile('/path/to/file.txt'), 'purpose' => 'assistants'
]);

$files->list();
$files->retrieve($uploaded->id);
$content = $files->content($uploaded->id); // string bytes
$files->delete($uploaded->id);
```

### Models
```php
$models = $factory->models($apiKey);

$models->list();
$models->retrieve('gpt-4o-mini');
// Delete only for fine-tuned/owned models
// $models->delete('ft_model_...');
```

### Moderations
```php
$moderations = $factory->moderations($apiKey);

$check = $moderations->create('Please review this text.');
```

### Responses
```php
$responses = $factory->responses($apiKey);

$r = $responses->create(['model' => 'gpt-4o-mini', 'input' => 'Hello']);
$responses->list();
$responses->retrieve($r->id);
$responses->cancel($r->id);
```

### Containers (beta)
```php
$containers = $factory->containers($apiKey);

$ctr = $containers->create(['name' => 'demo']);
$containers->list();
$containers->retrieve($ctr->id);
$containers->delete($ctr->id);
```

### Container Files (beta)
```php
$containerFiles = $factory->containerFiles($apiKey);

$cf = $containerFiles->create($ctr->id, [/* file payload */]);
$containerFiles->list($ctr->id);
$containerFiles->retrieve($ctr->id, $cf->id);
$containerFiles->delete($ctr->id, $cf->id);
```

### Vector Stores (beta)
```php
$vectorStore = $factory->vectorStore($apiKey);

$vs = $vectorStore->create(['name' => 'kb']);
$vectorStore->list();
$vectorStore->retrieve($vs->id);
$vectorStore->update($vs->id, ['name' => 'kb-renamed']);
$vectorStore->delete($vs->id);
```

### Vector Store Files (beta)
```php
$vectorStoreFiles = $factory->vectorStoreFiles($apiKey);

$vsf = $vectorStoreFiles->create($vs->id, ['file_id' => 'file_...']);
$vectorStoreFiles->list($vs->id);
$vectorStoreFiles->retrieve($vs->id, $vsf->id);
$vectorStoreFiles->update($vs->id, $vsf->id, ['metadata' => ['tag' => 'doc']]);
$vectorStoreFiles->delete($vs->id, $vsf->id);
```

### Vector Store File Batches (beta)
Factory does not expose this helper yet. Instantiate it directly with a `Client`.

```php
use OpenAI\Endpoint\VectorStoreFileBatches;

$client = (new Factory())->getClient($apiKey);
$batches = new VectorStoreFileBatches($client);

$batch = $batches->create($vs->id, ['file_ids' => ['file_1', 'file_2']]);
$batches->retrieve($vs->id, $batch->id);
$batches->files($vs->id, $batch->id);
$batches->cancel($vs->id, $batch->id);
```

---

Notes
- Methods return decoded response bodies as `stdClass` unless otherwise documented (e.g., `Files::content` returns string bytes).
- Beta endpoints automatically include the `OpenAI-Beta` header via the client used by those classes.
