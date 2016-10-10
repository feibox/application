<?php

namespace App\Objects;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;

class StubaUser
{
    /**
     * @var integer
     */
    private $id;
    /**
     * @var string
     */
    private $username;
    /**
     * @var null|integer
     */
    private $rank;
    /**
     * @var null|string
     */
    private $full_name;
    /**
     * @var null|string
     */
    private $first_name;
    /**
     * @var null|string
     */
    private $middle_name;
    /**
     * @var null|string
     */
    private $last_name;
    /**
     * @var null|string
     */
    private $title_prefix;
    /**
     * @var null|string
     */
    private $title_suffix;
    /**
     * @var null|integer
     */
    private $study_level;
    /**
     * @var null|string
     */
    private $study_information;
    /**
     * @var bool
     */
    private $initialized;

    /**
     * StubaUser constructor.
     */
    public function __construct()
    {
        $this->initialized = false;
    }

    /**
     * @param $username
     * @return $this
     */
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

    /**
     * @return null|string
     */
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

    /**
     * @param $data
     * @throws \Exception
     */
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

    /**
     *
     */
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

    /**
     * @param $full_name
     */
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

    /**
     * @param array $degree
     */
    private function parseDegree(array $degree)
    {
        if (count($degree) === 2) {
            $this->title_suffix = trim($degree[1]);
        }

        $this->title_prefix = trim($degree[0]);
    }

    /**
     *
     */
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

    /**
     * @return bool
     */
    public function isValid()
    {
        if (!is_null($this->id)) {
            return true;
        }
        return false;
    }

    /**
     * @return string
     */
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
