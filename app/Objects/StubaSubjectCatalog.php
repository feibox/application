<?php
namespace App\Objects;

use GuzzleHttp\Client;
use PHPHtmlParser\Dom;

class StubaSubjectCatalog
{
    public function getData()
    {
        $client = new Client();
        $dom = new Dom;

        /** @noinspection PhpDuplicateArrayKeysInspection */
        $result = $client->post('http://is.stuba.sk/katalog/index.pl', [
            'headers' => [
                'content-type' => 'application/x-www-form-urlencoded',
                'Accept' => '*/*',
                'Accept-Encoding' => 'gzip, deflate'
            ],
            'form_params' => [
                'kredity_od' => '',
                'kredity_do' => '',
                'fakulta' => '21030',
                'obdobi' => '221',
                'obdobi_fak' => '474',
                'obdobi_fak' => '473',
                'vyhledat_rozsirene' => 'Search+for+courses',
                'jak' => 'rozsirene'
            ]
        ]);

        $body = $result->getBody()->getContents();
        $anchors = $dom->load($body)->find('form a');

        foreach ($anchors as $key => $anchor) {
            list($code, $name) = explode(' ', $anchor->innerHtml, 2);
            $ais_id = $this->getAisId($anchor);
            $subjects = [
                'ais_id' => $ais_id,
                'code' => $code,
                'study_level' => $this->getStudyLevel($code),
                'en' => [
                    'name' => $name,
                ]
            ];
            $data[] = $subjects;
            unset($anchors[$key]);
        }

        return isset($data) ? $data : [];
    }

    private function getAisId($anchor)
    {
        $start = strpos($anchor->outerHtml,
                '<a href="syllabus.pl?predmet=') + strlen('<a href="syllabus.pl?predmet=');
        $end = strpos($anchor->outerHtml, ';zpet=/katalog/index.pl', $start);
        $r = substr($anchor->outerHtml, $start, $end - $start);
        return $r;
    }

    private function getStudyLevel($code)
    {
        if (starts_with($code, 'I-')) {
            return 2;
        }
        return 1;
    }

    /**
     * @param $ais_id
     * @param null|string $only 'sk' / 'en' / null - both
     * @return array
     */
    public function getFreshSubjectData($ais_id, $only = null)
    {
        $client = new Client();

        if (is_null($only) || $only === 'sk') {
            $result_sk = $client->get('http://is.stuba.sk/katalog/syllabus.pl', [
                'query' => [
                    'predmet' => $ais_id,
                    'lang' => 'sk'
                ]
            ]);

            $data['sk'] = $this->extractCodeAndName($result_sk->getBody()->getContents());
        }

        if (is_null($only) || $only === 'en') {
            $result_en = $client->get('http://is.stuba.sk/katalog/syllabus.pl', [
                'query' => [
                    'predmet' => $ais_id,
                    'lang' => 'en'
                ]
            ]);

            $data['en'] = $this->extractCodeAndName($result_en->getBody()->getContents());
        }

        return isset($data) ? $data : [];
    }

    private function extractCodeAndName($body)
    {
        $dom = new Dom();
        $header = $dom->load($body)->find('div#titulek h1');
        $header->innerHtml;

        $partial = array_slice(explode(' ', $header->innerHtml, 3), 2)[0];
        $partial = array_slice(explode(' (FE', $partial), 0, 1)[0];
        $name = explode(' - ', $partial)[1];
        return ['name' => $name];
    }
}
