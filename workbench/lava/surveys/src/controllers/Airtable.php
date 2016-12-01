<?php

namespace Armetiz\AirtableSDK;

use Assert\Assertion;
use Buzz;
use Buzz\Message\Response;

/**
 * @author : Thomas Tourlourat <thomas@tourlourat.com>
 */
class Airtable {

    /**
     * @var Buzz\Browser
     */
    private $browser;

    /**
     * @var string
     */
    private $base;

    /**
     * Airtable constructor.
     *
     * @param string $accessToken
     * @param string $base
     */
    public function __construct($accessToken, $base) {
        Assertion::string($accessToken);

        // @see https://github.com/kriswallsmith/Buzz/pull/186
        $listener = new Buzz\Listener\CallbackListener(function (Buzz\Message\RequestInterface $request, $response = null) use ($accessToken) {
            if ($response) {
                // postSend
            } else {
                // preSend
                $request->addHeader(sprintf('Authorization: Bearer %s', $accessToken));
            }
        });

        $this->browser = new Buzz\Browser(new Buzz\Client\Curl());
        $this->browser->addListener($listener);

        $this->base = $base;
    }

    public function createRecord($table, array $fields) {
        /** @var Response $response */
        $response = $this->browser->post(
                $this->getEndpoint($table), [
            "content-type" => "application/json",
                ], json_encode([
            "fields" => $fields,
                ])
        );

        $this->guardResponse($table, $response);
    }

    /**
     * This will update all fields of a table record, issuing a PUT request to the record endpoint. Any fields that are not included will be cleared ().
     *
     * @param string $table
     * @param array  $criteria
     * @param array  $fields
     */
    public function setRecord($table, array $criteria = [], array $fields) {
        $record = $this->findRecord($table, $criteria);

        /** @var Response $response */
        $response = $this->browser->put(
                $this->getEndpoint($table, $record->getId()), [
            "content-type" => "application/json",
                ], json_encode([
            "fields" => $fields,
                ])
        );

        $this->guardResponse($table, $response);
    }

    /**
     * This will update some (but not all) fields of a table record, issuing a PATCH request to the record endpoint. Any fields that are not included will not be updated.
     *
     * @param string $table
     * @param array  $criteria
     * @param array  $fields
     */
    public function updateRecord($table, array $criteria = [], array $fields) {
        $record = $this->findRecord($table, $criteria);

        /** @var Response $response */
        $response = $this->browser->patch(
                $this->getEndpoint($table, $record->getId()), [
            "content-type" => "application/json",
                ], json_encode([
            "fields" => $fields,
                ])
        );

        $this->guardResponse($table, $response);
    }

    public function containsRecord($table, array $criteria = []) {
        return !is_null($this->findRecord($table, $criteria));
    }

    public function flushRecords($table) {
        $records = $this->findRecords($table);

        /** @var Record $record */
        foreach ($records as $record) {
            /** @var Response $response */
            $response = $this->browser->delete(
                    $this->getEndpoint($table, $record->getId()), [
                "content-type" => "application/json",
                    ]
            );

            $this->guardResponse($table, $response);
        }
    }

    public function deleteRecord($table, array $criteria = []) {
        $record = $this->findRecord($table, $criteria);

        /** @var Response $response */
        $response = $this->browser->delete(
                $this->getEndpoint($table, $record->getId()), [
            "content-type" => "application/json",
                ]
        );

        $this->guardResponse($table, $response);
    }

    /**
     * @param       $table
     * @param array $criteria
     *
     * @return Record|null
     */
    public function findRecord($table, array $criteria = []) {
        return $this->findRecords($table, $criteria);
    }

    /**
     * TODO - Be able to loop over multiple pages. 
     * 
     * @param       $table
     * @param array $criteria
     *
     * @return Record[]
     */
    public function findRecords($table, array $criteria = []) {
        $url = $this->getEndpoint($table);

        if (count($criteria) > 0) {
            if (array_key_exists('id', $criteria)) {
                $url .= '/' . $criteria['id'];
            } else {
                $str = http_build_query($criteria);
                $url .='?' . $str;
            }//E# if else statement
        }

        /** @var Response $response */
        $response = $this->browser->get(
                $url, [
            "content-type" => "application/json",
                ]
        );

        $response = json_decode($response->getContent(), true);

        //$data['records'] = $data;
        if (array_key_exists('id', $criteria)) {
            $data['records'][0] = $response;
        } else {
            $data = $response;
        }

        return array_map(function (array $value) {
            return new Record($value["id"], $value["fields"]);
        }, $data["records"]);
        //}//E# if else statement
    }

    protected function getEndpoint($table, $id = null) {
        if ($id) {
            $urlPattern = "https://api.airtable.com/v0/%BASE%/%TABLE%/%ID%";

            return strtr($urlPattern, [
                '%BASE%' => $this->base,
                '%TABLE%' => $table,
                '%ID%' => $id,
            ]);
        }

        $urlPattern = "https://api.airtable.com/v0/%BASE%/%TABLE%";

        return strtr($urlPattern, [
            '%BASE%' => $this->base,
            '%TABLE%' => $table,
        ]);
    }

    /**
     * @param string   $table
     * @param Response $response
     */
    protected function guardResponse($table, Response $response) {
        if (429 === $response->getStatusCode()) {
            throw new \RuntimeException(sprintf(
                    'Rate limit reach on "%s:%s".', $this->base, $table
            )
            );
        }

        if (200 !== $response->getStatusCode()) {
            $content = json_decode($response->getContent(), true);
            $message = "No details";
            if (isset($content["error"]["message"])) {
                $message = $content["error"]["message"];
            }

            throw new \RuntimeException(sprintf(
                    'An "%s" error occurred when trying to create record on "%s:%s" : %s', $response->getStatusCode(), $this->base, $table, $message
            )
            );
        }
    }

}
