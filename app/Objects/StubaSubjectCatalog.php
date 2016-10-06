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
        //$client->post()
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
            $name = explode(' ', $anchor->innerHtml, 2);
            $code = $name[0];
            $name = $name[1];
            $ais_id = $this->getAisId($anchor);
            echo $code . ': ' . $name . ' / ' . $ais_id . "\n";
        }
    }

    private function getAisId($anchor)
    {
        $start = strpos($anchor->outerHtml,
                '<a href="syllabus.pl?predmet=') + strlen('<a href="syllabus.pl?predmet=');
        $end = strpos($anchor->outerHtml, ';zpet=/katalog/index.pl', $start);
        $r = substr($anchor->outerHtml, $start, $end - $start);
        return $r;
    }
}