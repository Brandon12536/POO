<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Exceptions\InvalidEmployeeDataException;

class SupabaseClient
{
    private Client $client;
    private string $baseUrl;
    private string $apiKey;

    public function __construct()
    {
        $this->baseUrl = env('SUPABASE_URL') . '/rest/v1/';
        $this->apiKey = env('SUPABASE_ANON_KEY');
        
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'apikey' => $this->apiKey,
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
                'Prefer' => 'return=representation'
            ]
        ]);
    }

    public function select(string $table, array $columns = ['*'], array $filters = []): array
    {
        try {
            $query = implode(',', $columns);
            $url = $table . '?select=' . $query;
            
            foreach ($filters as $key => $value) {
                $url .= '&' . $key . '=eq.' . $value;
            }

            $response = $this->client->get($url);
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            throw new InvalidEmployeeDataException('Error al consultar datos: ' . $e->getMessage());
        }
    }

    public function insert(string $table, array $data): array
    {
        try {
            $response = $this->client->post($table, [
                'json' => $data
            ]);
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            throw new InvalidEmployeeDataException('Error al insertar datos: ' . $e->getMessage());
        }
    }

    public function update(string $table, array $data, array $filters): array
    {
        try {
            $url = $table;
            $queryParams = [];
            
            foreach ($filters as $key => $value) {
                $queryParams[] = $key . '=eq.' . $value;
            }
            
            if (!empty($queryParams)) {
                $url .= '?' . implode('&', $queryParams);
            }

            $response = $this->client->patch($url, [
                'json' => $data
            ]);
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            throw new InvalidEmployeeDataException('Error al actualizar datos: ' . $e->getMessage());
        }
    }

    public function delete(string $table, array $filters): bool
    {
        try {
            $url = $table;
            $queryParams = [];
            
            foreach ($filters as $key => $value) {
                $queryParams[] = $key . '=eq.' . $value;
            }
            
            if (!empty($queryParams)) {
                $url .= '?' . implode('&', $queryParams);
            }

            $this->client->delete($url);
            return true;
        } catch (RequestException $e) {
            throw new InvalidEmployeeDataException('Error al eliminar datos: ' . $e->getMessage());
        }
    }
}
