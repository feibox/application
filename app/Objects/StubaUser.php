<?php

namespace App\Objects;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;

class StubaUser
{
    private $id;
    private $username;
    private $rank;
    private $full_name; // full string
    private $first_name; //string
    private $middle_name; //string
    private $last_name; //string
    private $title_prefix; // null or string
    private $title_suffix; // null or string
    private $study_level; // 1 or 2
    private $study_information;

    private $initialized;

    public function __construct()
    {
        $this->initialized = false;
    }

    public function initialize($username)
    {
        $this->username = $username;
        $data = $this->getData();

        try {
            $this->parseData($data);
            $this->initialized = true;
        } finally {
            return $this;
        }
    }

    private function getData()
    {
        $client = new Client();
        try {
            $result = $client->post('http://is.stuba.sk/uissuggest.pl', [
                'form_params' => [
                    '_suggestKey' => $this->username,
                    '_suggestMaxItems' => '1',
                    '_suggestHandler' => 'lide',
                ]
            ]);

            $body = $result->getBody()->getContents();
            if ($result->getStatusCode() == 200 && !empty($body)) {
                return $body;
            }

        } catch (TransferException $e) {
            return null;
        }
        return null;
    }

    private function parseData($data)
    {
        $data = json_decode($data, true);
        if (empty($data['data'])) {
            throw new \Exception('Stuba responded with empty result.');
        }

        $json = $data['data'][0];

        $this->full_name = $json[0];
        $this->id = $json[1];
        $this->study_information = $json[3];
        $this->parseNameAndDegree();
        $this->parseStudyInformation();
    }

    private function parseNameAndDegree()
    {
        //"Jhon Doe, Bc."
        //"Jhon James Doe, Mgr."
        //"Jhon Doe, Mgr. Ing., PhD."
        //"Jhon Doe, Ing., PhD."
        //"Jhon Doe"

        if (!str_contains($this->full_name, ',')) {
            $this->parseName($this->full_name);
        } else {
            $exploded = explode(',', $this->full_name);
            $this->parseName(array_shift($exploded));
            $this->parseDegree($exploded);
        }
    }

    private function parseName($full_name)
    {
        if (str_contains($full_name, ' ')) {
            $name_parts = explode(' ', $full_name);

            $this->first_name = array_shift($name_parts);
            $this->last_name = array_pop($name_parts);

            if (count($name_parts) !== 0) {
                $this->middle_name = implode(' ', $name_parts);
            }
        }
    }

    private function parseDegree(array $degree)
    {
        if (count($degree) === 2) {
            $this->title_suffix = trim($degree[1]);
        }

        $this->title_prefix = trim($degree[0]);
    }

    private function parseStudyInformation()
    {
        //"FEEIT I-API-MASUS den [term 3, year 2]"
        //"FEEIT B-RK den [term 3, year 3]"
        //"ICSM FEEIT, ext FIIT" //teacher

        if (str_contains($this->study_information, 'FEEIT I')) {
            $this->study_level = 2;
            $this->rank = substr($this->study_information, -2, 1) + 3;
        } elseif (str_contains($this->study_information, 'FEEIT B')) {
            $this->study_level = 1;
            $this->rank = substr($this->study_information, -2, 1);
        }
    }

    public function isValid()
    {
        if (!is_null($this->id) && !is_null($this->rank)) {
            return true;
        }
        return false;
    }

    public function __toString()
    {
        return sprintf("%s: %s\n", $this->full_name, $this->study_information);
    }

    /**
     * @return null|string
     */
    public function getStudyInformation()
    {
        return $this->study_information;
    }

    /**
     * @return null|string
     */
    public function getStudyLevel()
    {
        return $this->study_level;
    }

    /**
     * @return null|string
     */
    public function getTitleSuffix()
    {
        return $this->title_suffix;
    }

    /**
     * @return null|string
     */
    public function getTitlePrefix()
    {
        return $this->title_prefix;
    }

    /**
     * @return null|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return null|string
     */
    public function getFullName()
    {
        return $this->full_name;
    }

    /**
     * @return null|string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @return null|string
     */
    public function getMiddleName()
    {
        return $this->middle_name;
    }

    /**
     * @return null|string
     */
    public function getLastName()
    {
        return $this->last_name;
    }
}