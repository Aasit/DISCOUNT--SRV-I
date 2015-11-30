<?php

namespace Akzo\Scheme;

class Validator
{
    private $retriever;
    private $refResolver;
    private $logger;

    public function __construct()
    {
        $this->retriever = new \JsonSchema\Uri\UriRetriever;
        $this->refResolver = new \JsonSchema\RefResolver($this->retriever);
        $this->logger = $GLOBALS['logger'];
    }

    public function processString($jsonString)
    {
        if (empty($jsonString)) {
            return array('error' => 'Provide JSON file');
        }

        // Get the schema and data as objects
        $schema = $this->retriever->retrieve('file://' . __DIR__ . '/schema.json');
        $data = json_decode($jsonString);

        // If you use $ref or if you are unsure, resolve those references here
        // This modifies the $schema object
        $this->refResolver->resolve($schema, 'file://' . __DIR__);

        // Validate
        $validator = new \JsonSchema\Validator();
        $validator->check($data, $schema);

        $this->logger->info("Schema is: ".print_r($schema, 1));
        $this->logger->info("Data is: ".print_r($data, 1));

        $retArr = array();

        if ($validator->isValid()) {
            return true;
        } else {
            foreach ($validator->getErrors() as $error) {
                $retArr[$error['property']] = $error['message'];
                return $retArr;
            }
        }
    }

    public function processFile($jsonFile)
    {
        if (empty($jsonFile)) {
            return array('error' => 'Provide JSON file');
        }

        $this->processString(file_get_contents($jsonFile));
    }
}
