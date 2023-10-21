<?php
namespace App;

use Exception;

class Action {
  protected \GuzzleHttp\Client $client;
  protected $offset;
  protected $limit;

  public function __construct() {
    $this->client = new \GuzzleHttp\Client(['verify' => false]);
    session_start();
  }

  protected function clientRequest(String $metodo, String $url, $params = null) {

    if(empty($params) || !isset($params['language'])) {
      $params['language'] = 'pt-BR';
    }

    try {
      $response = $this->client->request(strtoupper($metodo), $url.'?'.http_build_query($params), [
          'headers' => [
            'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI2MTAzZmY5NDkzYTVmYjNmY2Q2ZjYwYWU0NWU5YzYwNyIsInN1YiI6IjY1MmE4NDU5ZjI4ODM4MDJhMWRiNjZjMyIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.i63GoMZKdzQqhpdvXgBQyPizGgZ9nXl80L8XallPp-8',
            'accept' => 'application/json',
          ],
      ]);
    } catch(Exception $e) {
      return null;
    }

    return json_decode($response->getBody());
  }
}

?>