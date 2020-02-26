<?php

namespace Akeneo\Tool\Bundle\MeasureBundle\tests\EndToEnd\ExternalApi;

use Akeneo\Tool\Bundle\ApiBundle\tests\integration\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class GetMeasurementFamiliesEndToEnd extends ApiTestCase
{
    /**
     * @test
     */
    public function it_returns_the_list_of_measurement_families()
    {
        $client = $this->createAuthenticatedClient();

        $client->request('GET', 'api/rest/v1/measurement-family');

        $expected = $this->allMeasurementFamilies();
        $response = $client->getResponse();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString($expected, $response->getContent());
    }

    public function testOutOfRangeListMeasureFamily()
    {
        $client = $this->createAuthenticatedClient();
        $client->request('GET', 'api/rest/v1/measurement-family?page=300');

        $expected = <<<JSON
{
  "_links": {
    "self": {
      "href": "http:\/\/localhost\/api\/rest\/v1\/measurement-family?page=300&limit=10&with_count=false"
    },
    "first": {
      "href": "http:\/\/localhost\/api\/rest\/v1\/measurement-family?page=1&limit=10&with_count=false"
    },
    "previous": {
      "href": "http:\/\/localhost\/api\/rest\/v1\/measurement-family?page=299&limit=10&with_count=false"
    }
  },
  "current_page": 300,
  "_embedded": {
    "items": []
  }
}
JSON;

        $response = $client->getResponse();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString($expected, $response->getContent());
    }

    public function testPaginationListMeasureFamily()
    {
        $client = $this->createAuthenticatedClient();
        $client->request('GET', 'api/rest/v1/measurement-family?page=2&limit=3');

        $expected = $this->paginatedMeasurementFamilies();

        $response = $client->getResponse();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString($expected, $response->getContent());
    }

    public function testListOfMeasureFamiliesWithCount()
    {
        $client = $this->createAuthenticatedClient();
        $client->request('GET', 'api/rest/v1/measurement-family?with_count=true&limit=1');

        $expected = <<<JSON
{
    "_links": {
        "self": {
            "href": "http://localhost/api/rest/v1/measurement-family?page=1&limit=1&with_count=true"
        },
        "first": {
            "href": "http://localhost/api/rest/v1/measurement-family?page=1&limit=1&with_count=true"
        },
        "next": {
            "href": "http://localhost/api/rest/v1/measurement-family?page=2&limit=1&with_count=true"
        }
    },
    "current_page": 1,
    "items_count": 23,
    "_embedded": {
        "items": [
            {
                "code": "Angle",
                "labels": {
                    "de_DE": "Winkel",
                    "en_US": "Angle",
                    "fr_FR": "Angle"
                },
                "standard_unit_code": "RADIAN",
                "units": [
                    {
                        "code": "RADIAN",
                        "labels": {
                            "en_US": "Radian",
                            "fr_FR": "Radian"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "1"
                            }
                        ],
                        "symbol": "rad"
                    },
                    {
                        "code": "MILLIRADIAN",
                        "labels": {
                            "en_US": "Milliradian",
                            "fr_FR": "Milliradian"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "0.001"
                            }
                        ],
                        "symbol": "mrad"
                    },
                    {
                        "code": "MICRORADIAN",
                        "labels": {
                            "en_US": "Microradian",
                            "fr_FR": "Microradian"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "1.0E-6"
                            }
                        ],
                        "symbol": "µrad"
                    },
                    {
                        "code": "DEGREE",
                        "labels": {
                            "en_US": "Degree",
                            "fr_FR": "Degré"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "0.01745329"
                            }
                        ],
                        "symbol": "°"
                    },
                    {
                        "code": "MINUTE",
                        "labels": {
                            "en_US": "Minute",
                            "fr_FR": "Minute"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "0.0002908882"
                            }
                        ],
                        "symbol": "'"
                    },
                    {
                        "code": "SECOND",
                        "labels": {
                            "en_US": "Second",
                            "fr_FR": "Seconde"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "4.848137E-6"
                            }
                        ],
                        "symbol": "\""
                    },
                    {
                        "code": "GON",
                        "labels": {
                            "en_US": "Gon",
                            "fr_FR": "Gon"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "0.01570796"
                            }
                        ],
                        "symbol": "gon"
                    },
                    {
                        "code": "MIL",
                        "labels": {
                            "en_US": "Mil",
                            "fr_FR": "Mil"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "0.0009817477"
                            }
                        ],
                        "symbol": "mil"
                    },
                    {
                        "code": "REVOLUTION",
                        "labels": {
                            "en_US": "Revolution",
                            "fr_FR": "Révolution"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "6.283185"
                            }
                        ],
                        "symbol": "rev"
                    }
                ]
            }
        ]
    }
}
JSON;

        $response = $client->getResponse();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString($expected, $response->getContent());
    }

    public function testUnknownPaginationType()
    {
        $client = $this->createAuthenticatedClient();

        $client->request('GET', 'api/rest/v1/measurement-family?pagination_type=search_after');

        $response = $client->getResponse();

        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
        $expected = '{"code":422,"message":"Pagination type is not supported."}';
        $this->assertEquals($response->getContent(), $expected);
    }

    /**
     * {@inheritdoc}
     */
    protected function getConfiguration()
    {
        return $this->catalog->useTechnicalCatalog();
    }

    private function allMeasurementFamilies(): string
    {
        return <<<JSON
{
    "_links": {
        "self": {
            "href": "http://localhost/api/rest/v1/measurement-family?page=1&limit=10&with_count=false"
        },
        "first": {
            "href": "http://localhost/api/rest/v1/measurement-family?page=1&limit=10&with_count=false"
        },
        "next": {
            "href": "http://localhost/api/rest/v1/measurement-family?page=2&limit=10&with_count=false"
        }
    },
    "current_page": 1,
    "_embedded": {
        "items": [
            {
                "code": "Angle",
                "labels": {
                    "de_DE": "Winkel",
                    "en_US": "Angle",
                    "fr_FR": "Angle"
                },
                "standard_unit_code": "RADIAN",
                "units": [
                    {
                        "code": "RADIAN",
                        "labels": {
                            "en_US": "Radian",
                            "fr_FR": "Radian"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "1"
                            }
                        ],
                        "symbol": "rad"
                    },
                    {
                        "code": "MILLIRADIAN",
                        "labels": {
                            "en_US": "Milliradian",
                            "fr_FR": "Milliradian"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "0.001"
                            }
                        ],
                        "symbol": "mrad"
                    },
                    {
                        "code": "MICRORADIAN",
                        "labels": {
                            "en_US": "Microradian",
                            "fr_FR": "Microradian"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "1.0E-6"
                            }
                        ],
                        "symbol": "µrad"
                    },
                    {
                        "code": "DEGREE",
                        "labels": {
                            "en_US": "Degree",
                            "fr_FR": "Degré"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "0.01745329"
                            }
                        ],
                        "symbol": "°"
                    },
                    {
                        "code": "MINUTE",
                        "labels": {
                            "en_US": "Minute",
                            "fr_FR": "Minute"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "0.0002908882"
                            }
                        ],
                        "symbol": "'"
                    },
                    {
                        "code": "SECOND",
                        "labels": {
                            "en_US": "Second",
                            "fr_FR": "Seconde"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "4.848137E-6"
                            }
                        ],
                        "symbol": "\""
                    },
                    {
                        "code": "GON",
                        "labels": {
                            "en_US": "Gon",
                            "fr_FR": "Gon"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "0.01570796"
                            }
                        ],
                        "symbol": "gon"
                    },
                    {
                        "code": "MIL",
                        "labels": {
                            "en_US": "Mil",
                            "fr_FR": "Mil"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "0.0009817477"
                            }
                        ],
                        "symbol": "mil"
                    },
                    {
                        "code": "REVOLUTION",
                        "labels": {
                            "en_US": "Revolution",
                            "fr_FR": "Révolution"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "6.283185"
                            }
                        ],
                        "symbol": "rev"
                    }
                ]
            },
            {
                "code": "Area",
                "labels": {
                    "ca_ES": "Àrea",
                    "da_DK": "Areal",
                    "de_DE": "Fläche",
                    "en_GB": "Area",
                    "en_NZ": "Area",
                    "en_US": "Area",
                    "es_ES": "Superficie",
                    "fi_FI": "Alue",
                    "fr_FR": "Surface",
                    "it_IT": "Area",
                    "ja_JP": "エリア",
                    "pt_BR": "Área",
                    "ru_RU": "Площадь",
                    "sv_SE": "Område"
                },
                "standard_unit_code": "SQUARE_METER",
                "units": [
                    {
                        "code": "SQUARE_MILLIMETER",
                        "labels": {
                            "ca_ES": "Mil·límetre quadrat",
                            "da_DK": "Kvadrat millimeter",
                            "de_DE": "Quadratmillimeter",
                            "en_GB": "Square millimetre",
                            "en_NZ": "Square millimetre",
                            "en_US": "Square millimeter",
                            "es_ES": "Milímetro cuadrado",
                            "fi_FI": "Neliömillimetri",
                            "fr_FR": "Millimètre carré",
                            "it_IT": "Millimetro quadrato",
                            "ja_JP": "平方ミリメートル",
                            "pt_BR": "Milímetro quadrado",
                            "ru_RU": "Квадратный миллиметр",
                            "sv_SE": "Kvadratmillimeter"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "0.000001"
                            }
                        ],
                        "symbol": "mm²"
                    },
                    {
                        "code": "SQUARE_CENTIMETER",
                        "labels": {
                            "ca_ES": "Centímetre quadrat",
                            "da_DK": "Kvadratcentimeter",
                            "de_DE": "Quadratzentimeter",
                            "en_GB": "Square centimetre",
                            "en_NZ": "Square centimetre",
                            "en_US": "Square centimeter",
                            "es_ES": "Centímetro cuadrado",
                            "fi_FI": "Neliösenttimetri",
                            "fr_FR": "Centimètre carré",
                            "it_IT": "Centimetro quadrato",
                            "ja_JP": "平方センチメートル",
                            "pt_BR": "Centímetro quadrado",
                            "ru_RU": "Квадратный сантиметр",
                            "sv_SE": "Kvadratcentimeter"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "0.0001"
                            }
                        ],
                        "symbol": "cm²"
                    },
                    {
                        "code": "SQUARE_DECIMETER",
                        "labels": {
                            "ca_ES": "Decímetre quadrat",
                            "da_DK": "Kvadrat decimeter",
                            "de_DE": "Quadratdezimeter",
                            "en_GB": "Square decimetre",
                            "en_NZ": "Square decimetre",
                            "en_US": "Square decimeter",
                            "es_ES": "Decímetro cuadrado",
                            "fi_FI": "Neliödesimetri",
                            "fr_FR": "Décimètre carré",
                            "it_IT": "Decimetro quadrato",
                            "ja_JP": "平方デシメートル",
                            "pt_BR": "Decímetro quadrado",
                            "ru_RU": "Квадратный дециметр",
                            "sv_SE": "Kvadratdecimeter"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "0.01"
                            }
                        ],
                        "symbol": "dm²"
                    },
                    {
                        "code": "SQUARE_METER",
                        "labels": {
                            "ca_ES": "Metre quadrat",
                            "da_DK": "Kvadratmeter",
                            "de_DE": "Quadratmeter",
                            "en_GB": "Square metre",
                            "en_NZ": "Square metre",
                            "en_US": "Square meter",
                            "es_ES": "Metro cuadrado",
                            "fi_FI": "Neliömetri",
                            "fr_FR": "Mètre carré",
                            "it_IT": "Metro quadrato",
                            "ja_JP": "平方メートル",
                            "pt_BR": "Metro quadrado",
                            "ru_RU": "Квадратный метр",
                            "sv_SE": "Kvadratmeter"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "1"
                            }
                        ],
                        "symbol": "m²"
                    },
                    {
                        "code": "CENTIARE",
                        "labels": {
                            "ca_ES": "Centiàrees",
                            "da_DK": "Centiare",
                            "de_DE": "Quadratmeter",
                            "en_GB": "Centiare",
                            "en_NZ": "Centiare",
                            "en_US": "Centiare",
                            "es_ES": "Centiáreas",
                            "fi_FI": "Senttiaari",
                            "fr_FR": "Centiare",
                            "it_IT": "Centiara",
                            "ja_JP": "センチアール",
                            "pt_BR": "Centiare",
                            "ru_RU": "Центнер",
                            "sv_SE": "Kvadratmeter"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "1"
                            }
                        ],
                        "symbol": "ca"
                    },
                    {
                        "code": "SQUARE_DEKAMETER",
                        "labels": {
                            "ca_ES": "Decàmetre quadrat",
                            "da_DK": "Kvadrat dekameter",
                            "de_DE": "Quadratdekameter",
                            "en_GB": "Square decametre",
                            "en_NZ": "Square dekametre",
                            "en_US": "Square dekameter",
                            "es_ES": "Dekametro cuadrado",
                            "fi_FI": "Neliödekametri",
                            "fr_FR": "Décamètre carré",
                            "it_IT": "Decametro quadrato",
                            "ja_JP": "平方デカメートル",
                            "pt_BR": "Decametro quadrado",
                            "ru_RU": "Квадратный декаметр",
                            "sv_SE": "Kvadratdekameter"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "100"
                            }
                        ],
                        "symbol": "dam²"
                    },
                    {
                        "code": "ARE",
                        "labels": {
                            "ca_ES": "Àrea",
                            "da_DK": "Are",
                            "de_DE": "Ar",
                            "en_GB": "Sú",
                            "en_NZ": "Are",
                            "en_US": "Are",
                            "es_ES": "Área",
                            "fi_FI": "Aari",
                            "fr_FR": "Are",
                            "it_IT": "Ara",
                            "ja_JP": "アール",
                            "pt_BR": "Area",
                            "ru_RU": "Ар",
                            "sv_SE": "Hektar"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "100"
                            }
                        ],
                        "symbol": "a"
                    },
                    {
                        "code": "SQUARE_HECTOMETER",
                        "labels": {
                            "ca_ES": "Hectòmetre quadrat",
                            "da_DK": "Kvadrat hectometer",
                            "de_DE": "Quadrathektometer",
                            "en_GB": "Square hectometre",
                            "en_NZ": "Square hectometre",
                            "en_US": "Square hectometer",
                            "es_ES": "Hectómetro cuadrado",
                            "fi_FI": "Neliöhehtometri",
                            "fr_FR": "Hectomètre carré",
                            "it_IT": "Ettometro quadrato",
                            "ja_JP": "平方ヘクトメートル",
                            "pt_BR": "Hectómetro quadrado",
                            "ru_RU": "Квадратный гектометр",
                            "sv_SE": "Kvadrathektameter"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "10000"
                            }
                        ],
                        "symbol": "hm²"
                    },
                    {
                        "code": "HECTARE",
                        "labels": {
                            "ca_ES": "Hectàrees",
                            "da_DK": "Hektar",
                            "de_DE": "Hektar",
                            "en_GB": "Hectare",
                            "en_NZ": "Hectare",
                            "en_US": "Hectare",
                            "es_ES": "Hectárea",
                            "fi_FI": "Hehtaari",
                            "fr_FR": "Hectare",
                            "it_IT": "Ettaro",
                            "ja_JP": "ヘクタール",
                            "pt_BR": "Um hectare (conhecido também como hectômetro/hectómetro quadrado [hm²]), representado pelo símbolo ha,[1] é uma unidade de medida de área equivalente a 100 (cem) ares ou a 10. 000 (dez mil) metros quadrados",
                            "ru_RU": "Гектар",
                            "sv_SE": "Hektar"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "10000"
                            }
                        ],
                        "symbol": "ha"
                    },
                    {
                        "code": "SQUARE_KILOMETER",
                        "labels": {
                            "ca_ES": "Quilòmetre quadrat",
                            "da_DK": "Kvadrat kilometer",
                            "de_DE": "Quadratkilometer",
                            "en_GB": "Square kilometre",
                            "en_NZ": "Square kilometre",
                            "en_US": "Square kilometer",
                            "es_ES": "Kilómetro cuadrado",
                            "fi_FI": "Neliökilometri",
                            "fr_FR": "Kilomètre carré",
                            "it_IT": "Chilometro quadrato",
                            "ja_JP": "平方キロメートル",
                            "pt_BR": "Quilômetro quadrado",
                            "ru_RU": "Квадратный километр",
                            "sv_SE": "Kvadratkilometer"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "1000000"
                            }
                        ],
                        "symbol": "km²"
                    },
                    {
                        "code": "SQUARE_MIL",
                        "labels": {
                            "ca_ES": "Mil quadrat",
                            "da_DK": "Kvadrat mil",
                            "de_DE": "Quadratmil",
                            "en_GB": "Square mil",
                            "en_NZ": "Square mil",
                            "en_US": "Square mil",
                            "es_ES": "Mil cuadrado",
                            "fi_FI": "Neliötuhannesosatuuma",
                            "fr_FR": "Mil carré",
                            "it_IT": "Mil quadrati",
                            "ja_JP": "平方ミル",
                            "pt_BR": "Mil quadrada",
                            "ru_RU": "Квадратная миля",
                            "sv_SE": "Kvadratmil"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "0.00000000064516"
                            }
                        ],
                        "symbol": "sq mil"
                    },
                    {
                        "code": "SQUARE_INCH",
                        "labels": {
                            "ca_ES": "Polzada quadrada",
                            "da_DK": "Kvadrattomme",
                            "de_DE": "Quadratzoll",
                            "en_GB": "Square inch",
                            "en_NZ": "Square inch",
                            "en_US": "Square inch",
                            "es_ES": "Pulgada cuadrada",
                            "fi_FI": "Neliötuuma",
                            "fr_FR": "Pouce carré",
                            "it_IT": "Pollice quadrato",
                            "ja_JP": "平方インチ",
                            "pt_BR": "Polegada quadrada",
                            "ru_RU": "Квадратный дюйм",
                            "sv_SE": "Kvadrattum"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "0.00064516"
                            }
                        ],
                        "symbol": "in²"
                    },
                    {
                        "code": "SQUARE_FOOT",
                        "labels": {
                            "ca_ES": "Peu quadrat",
                            "da_DK": "Kvadratfod",
                            "de_DE": "Quadratfuß",
                            "en_GB": "Square foot",
                            "en_NZ": "Square foot",
                            "en_US": "Square foot",
                            "es_ES": "Pies cuadrados",
                            "fi_FI": "Neliöjalka",
                            "fr_FR": "Pied carré",
                            "it_IT": "Piede quadrato",
                            "ja_JP": "平方フィート",
                            "pt_BR": "Pé quadrado",
                            "ru_RU": "Квадратный фут",
                            "sv_SE": "Kvadratfot"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "0.09290304"
                            }
                        ],
                        "symbol": "ft²"
                    },
                    {
                        "code": "SQUARE_YARD",
                        "labels": {
                            "ca_ES": "Iarda quadrada",
                            "da_DK": "Kvadrat yard",
                            "de_DE": "Quadratyard",
                            "en_GB": "Square yard",
                            "en_NZ": "Square yard",
                            "en_US": "Square yard",
                            "es_ES": "Yarda cuadrada",
                            "fi_FI": "Neliöjaardi",
                            "fr_FR": "Yard carré",
                            "it_IT": "Yard quadrata",
                            "ja_JP": "平方ヤード",
                            "pt_BR": "Jarda quadrada",
                            "ru_RU": "Квадратный ярд",
                            "sv_SE": "Kvadratyard"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "0.83612736"
                            }
                        ],
                        "symbol": "yd²"
                    },
                    {
                        "code": "ARPENT",
                        "labels": {
                            "ca_ES": "Arpent",
                            "da_DK": "Arpent",
                            "de_DE": "Arpent",
                            "en_GB": "Arpent",
                            "en_NZ": "Arpent",
                            "en_US": "Arpent",
                            "es_ES": "Arpende",
                            "fi_FI": "Eekkeri",
                            "fr_FR": "Arpent",
                            "it_IT": "Arpenti",
                            "ja_JP": "アルパン",
                            "pt_BR": "Arpent",
                            "ru_RU": "Арпан",
                            "sv_SE": "Arpent"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "3418.89"
                            }
                        ],
                        "symbol": "arpent"
                    },
                    {
                        "code": "ACRE",
                        "labels": {
                            "ca_ES": "Acre",
                            "da_DK": "Tønder",
                            "de_DE": "Morgen",
                            "en_GB": "Acre",
                            "en_NZ": "Acre",
                            "en_US": "Acre",
                            "es_ES": "Acre",
                            "fi_FI": "Eekkeri",
                            "fr_FR": "Acre",
                            "it_IT": "Acri",
                            "ja_JP": "エーカー",
                            "pt_BR": "Acre é o nome de uma antiga unidade de medida usada para medir terras. Atualmente, o acre é uma unidade de área utilizada no sistema imperial e no sistema tradicional dos Estados Unidos. O acre não é mais usado na maioria dos países, apesar de algumas exceções notáveis, que incluem os EUA, Austrália, Índia, Paquistão e Birmânia. A partir de 2010, o acre deixou de ser oficialmente utilizado no Reino Unido, embora ainda seja usado em descrições de imóveis. Ele continua sendo usado, ainda, em certa medida, no Canadá. No Brasil e em Portugal, essa medida nunca foi utilizada, sendo que nestes países se utiliza o alqueire e o hectare (que seria a unidade mais simples de utilização) como unidades de medida em áreas rurais.",
                            "ru_RU": "Акр",
                            "sv_SE": "Tunnland"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "4046.856422"
                            }
                        ],
                        "symbol": "A"
                    },
                    {
                        "code": "SQUARE_FURLONG",
                        "labels": {
                            "ca_ES": "Furlong quadrat",
                            "da_DK": "Kvadratisk furlong",
                            "de_DE": "Quadrat-Achtelmeile",
                            "en_GB": "Square furlong",
                            "en_NZ": "Square furlong",
                            "en_US": "Square furlong",
                            "es_ES": "Estadio cuadrado",
                            "fi_FI": "Vakomitta",
                            "fr_FR": "Furlong carré",
                            "it_IT": "Furlong quadrato",
                            "ja_JP": "平方ハロン",
                            "pt_BR": "Furlong quadrado",
                            "ru_RU": "Квадратный фурлонг",
                            "sv_SE": "Kvadratfurlong"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "40468.726"
                            }
                        ],
                        "symbol": "fur²"
                    },
                    {
                        "code": "SQUARE_MILE",
                        "labels": {
                            "ca_ES": "Milla quadrada",
                            "da_DK": "Kvadrat mil",
                            "de_DE": "Quadratmeile",
                            "en_GB": "Square mile",
                            "en_NZ": "Square mile",
                            "en_US": "Square mile",
                            "es_ES": "Milla cuadrada",
                            "fi_FI": "Neliömaili",
                            "fr_FR": "Mile carré",
                            "it_IT": "Miglio quadrato",
                            "ja_JP": "平方マイル",
                            "pt_BR": "Milha quadrada",
                            "ru_RU": "Квадратная миля",
                            "sv_SE": "Kvadratmile"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "2589988.110336"
                            }
                        ],
                        "symbol": "mi²"
                    }
                ]
            },
            {
                "code": "Binary",
                "labels": {
                    "ca_ES": "Binari",
                    "da_DK": "Binær",
                    "de_DE": "Binär",
                    "en_GB": "Binary",
                    "en_NZ": "Binary",
                    "en_US": "Binary",
                    "es_ES": "Binario",
                    "fi_FI": "Binääri",
                    "fr_FR": "Binaire",
                    "it_IT": "Binario",
                    "ja_JP": "バイナリ",
                    "pt_BR": "Binário",
                    "ru_RU": "Двоичный",
                    "sv_SE": "Binär"
                },
                "standard_unit_code": "BYTE",
                "units": [
                    {
                        "code": "CHAR",
                        "labels": {
                            "en_US": "Char",
                            "fr_FR": "Char"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "8"
                            }
                        ],
                        "symbol": "char"
                    },
                    {
                        "code": "KILOBIT",
                        "labels": {
                            "en_US": "Kilobit",
                            "fr_FR": "Kilobit"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "125"
                            }
                        ],
                        "symbol": "kbit"
                    },
                    {
                        "code": "MEGABIT",
                        "labels": {
                            "en_US": "Megabit",
                            "fr_FR": "Mégabit"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "125000"
                            }
                        ],
                        "symbol": "Mbit"
                    },
                    {
                        "code": "GIGABIT",
                        "labels": {
                            "en_US": "Gigabit",
                            "fr_FR": "Gigabit"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "125000000"
                            }
                        ],
                        "symbol": "Gbit"
                    },
                    {
                        "code": "BIT",
                        "labels": {
                            "ca_ES": "Bit",
                            "da_DK": "Bit",
                            "de_DE": "Bit",
                            "en_GB": "Bit",
                            "en_NZ": "Bit",
                            "en_US": "Bit",
                            "es_ES": "Bit",
                            "fi_FI": "Bitti",
                            "fr_FR": "Bit",
                            "it_IT": "Bit",
                            "ja_JP": "ビット",
                            "pt_BR": "Bit",
                            "ru_RU": "Бит",
                            "sv_SE": "Bit"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "0.125"
                            }
                        ],
                        "symbol": "b"
                    },
                    {
                        "code": "BYTE",
                        "labels": {
                            "ca_ES": "Byte",
                            "da_DK": "Byte",
                            "de_DE": "Byte",
                            "en_GB": "Byte",
                            "en_NZ": "Byte",
                            "en_US": "Byte",
                            "es_ES": "Byte",
                            "fi_FI": "Tavu",
                            "fr_FR": "Octet",
                            "it_IT": "Byte",
                            "ja_JP": "バイト",
                            "pt_BR": "Byte",
                            "ru_RU": "Байт",
                            "sv_SE": "Byte"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "1"
                            }
                        ],
                        "symbol": "B"
                    },
                    {
                        "code": "KILOBYTE",
                        "labels": {
                            "ca_ES": "Kilobyte",
                            "da_DK": "Kilobyte",
                            "de_DE": "Kilobyte",
                            "en_GB": "Kilobyte",
                            "en_NZ": "Kilobyte",
                            "en_US": "Kilobyte",
                            "es_ES": "Kilobyte",
                            "fi_FI": "Kilotavu",
                            "fr_FR": "Kilo-octet",
                            "it_IT": "Kilobyte",
                            "ja_JP": "キロバイト",
                            "pt_BR": "Kilobyte (KB)",
                            "ru_RU": "Килобайт",
                            "sv_SE": "Kilobyte"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "1024"
                            }
                        ],
                        "symbol": "kB"
                    },
                    {
                        "code": "MEGABYTE",
                        "labels": {
                            "ca_ES": "Megabyte",
                            "da_DK": "Megabyte",
                            "de_DE": "Megabyte",
                            "en_GB": "Megabyte",
                            "en_NZ": "Megabyte",
                            "en_US": "Megabyte",
                            "es_ES": "Megabyte",
                            "fi_FI": "Megatavu",
                            "fr_FR": "Mégaoctet",
                            "it_IT": "Megabyte",
                            "ja_JP": "メガバイト",
                            "pt_BR": "Megabyte (MB)",
                            "ru_RU": "Мегабайт",
                            "sv_SE": "Megabyte"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "1048576"
                            }
                        ],
                        "symbol": "MB"
                    },
                    {
                        "code": "GIGABYTE",
                        "labels": {
                            "ca_ES": "Gigabyte",
                            "da_DK": "Gigabyte",
                            "de_DE": "Gigabyte",
                            "en_GB": "Gigabyte",
                            "en_NZ": "Gigabyte",
                            "en_US": "Gigabyte",
                            "es_ES": "Gigabyte",
                            "fi_FI": "Gigatavu",
                            "fr_FR": "Gigaoctet",
                            "it_IT": "Gigabyte",
                            "ja_JP": "ギガバイト",
                            "pt_BR": "Gigabyte (GB)",
                            "ru_RU": "Гигабайт",
                            "sv_SE": "Gigabyte"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "1073741824"
                            }
                        ],
                        "symbol": "GB"
                    },
                    {
                        "code": "TERABYTE",
                        "labels": {
                            "ca_ES": "Terabyte",
                            "da_DK": "Terabyte",
                            "de_DE": "Terabyte",
                            "en_GB": "Terabyte",
                            "en_NZ": "Terabyte",
                            "en_US": "Terabyte",
                            "es_ES": "Terabyte",
                            "fi_FI": "Teratavu",
                            "fr_FR": "Téraoctet",
                            "it_IT": "Terabyte",
                            "ja_JP": "テラバイト",
                            "pt_BR": "Terabyte (TB)",
                            "ru_RU": "Терабайт",
                            "sv_SE": "Terabyte"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "1099511627776"
                            }
                        ],
                        "symbol": "TB"
                    }
                ]
            },
            {
                "code": "Brightness",
                "labels": {
                    "de_DE": "Helligkeit",
                    "en_US": "Brightness",
                    "fr_FR": "Luminosité"
                },
                "standard_unit_code": "LUMEN",
                "units": [
                    {
                        "code": "LUMEN",
                        "labels": {
                            "de_DE": "Lumen",
                            "en_US": "Lumen",
                            "fr_FR": "Lumen"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "1"
                            }
                        ],
                        "symbol": "lm"
                    },
                    {
                        "code": "NIT",
                        "labels": {
                            "de_DE": "Nit",
                            "en_US": "Nit",
                            "fr_FR": "Nit"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "0.2918855809"
                            }
                        ],
                        "symbol": "nits"
                    }
                ]
            },
            {
                "code": "Capacitance",
                "labels": {
                    "de_DE": "Elektrische Kapazität",
                    "en_US": "Capacitance",
                    "fr_FR": "Capacité électrique"
                },
                "standard_unit_code": "FARAD",
                "units": [
                    {
                        "code": "ATTOFARAD",
                        "labels": {
                            "en_US": "Attofarad",
                            "fr_FR": "Attofarad"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "div",
                                "value": "1000000000000000000"
                            }
                        ],
                        "symbol": "aF"
                    },
                    {
                        "code": "PICOFARAD",
                        "labels": {
                            "en_US": "Picofarad",
                            "fr_FR": "Picofarad"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "div",
                                "value": "1000000000000"
                            }
                        ],
                        "symbol": "pF"
                    },
                    {
                        "code": "NANOFARAD",
                        "labels": {
                            "en_US": "Nanofarad",
                            "fr_FR": "Nanofarad"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "div",
                                "value": "1000000000"
                            }
                        ],
                        "symbol": "nF"
                    },
                    {
                        "code": "MICROFARAD",
                        "labels": {
                            "en_US": "Microfarad",
                            "fr_FR": "Microfarad"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "div",
                                "value": "1000000"
                            }
                        ],
                        "symbol": "µF"
                    },
                    {
                        "code": "MILLIFARAD",
                        "labels": {
                            "en_US": "Millifarad",
                            "fr_FR": "Millifarad"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "div",
                                "value": "1000"
                            }
                        ],
                        "symbol": "mF"
                    },
                    {
                        "code": "FARAD",
                        "labels": {
                            "en_US": "Farad",
                            "fr_FR": "Farad"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "1"
                            }
                        ],
                        "symbol": "F"
                    },
                    {
                        "code": "KILOFARAD",
                        "labels": {
                            "en_US": "Kilofarad",
                            "fr_FR": "Kilofarad"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "1000"
                            }
                        ],
                        "symbol": "kF"
                    }
                ]
            },
            {
                "code": "CaseBox",
                "labels": {
                    "ca_ES": "Embalatge",
                    "da_DK": "Emballage",
                    "de_DE": "Verpackung",
                    "en_GB": "Packaging",
                    "en_NZ": "Packaging",
                    "en_US": "Packaging",
                    "es_ES": "Embalaje",
                    "fi_FI": "Pakkaus",
                    "fr_FR": "Emballage",
                    "it_IT": "Imballo",
                    "ja_JP": "包装",
                    "pt_BR": "Embalagens",
                    "ru_RU": "Упаковка",
                    "sv_SE": "Förpackning"
                },
                "standard_unit_code": "PIECE",
                "units": [
                    {
                        "code": "PIECE",
                        "labels": {
                            "ca_ES": "Peça",
                            "da_DK": "Stykke",
                            "de_DE": "Stück",
                            "en_GB": "Piece",
                            "en_NZ": "Piece",
                            "en_US": "Piece",
                            "es_ES": "Pieza",
                            "fi_FI": "Kappale",
                            "fr_FR": "Unité",
                            "it_IT": "Pezzo",
                            "ja_JP": "作品",
                            "pt_BR": "Peça",
                            "ru_RU": "шт.",
                            "sv_SE": "Stycke"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "1"
                            }
                        ],
                        "symbol": "Pc"
                    },
                    {
                        "code": "DOZEN",
                        "labels": {
                            "ca_ES": "Dotzena",
                            "da_DK": "Dusin",
                            "de_DE": "Dutzend",
                            "en_GB": "Dozen",
                            "en_NZ": "Dozen",
                            "en_US": "Dozen",
                            "es_ES": "Docena",
                            "fi_FI": "Tusina",
                            "fr_FR": "Douzaine",
                            "it_IT": "Dozzina",
                            "ja_JP": "ダース",
                            "pt_BR": "Dúzia",
                            "ru_RU": "Дюжина",
                            "sv_SE": "Dussin"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "12"
                            }
                        ],
                        "symbol": "Dz"
                    }
                ]
            },
            {
                "code": "Decibel",
                "labels": {
                    "ca_ES": "Decibel",
                    "da_DK": "Decibel",
                    "de_DE": "Dezibel",
                    "en_GB": "Decibel",
                    "en_NZ": "Decibel",
                    "en_US": "Decibel",
                    "es_ES": "Decibelio",
                    "fi_FI": "Desibeli",
                    "fr_FR": "Décibel",
                    "it_IT": "Decibel",
                    "ja_JP": "デシベル",
                    "pt_BR": "Decibel",
                    "ru_RU": "Децибел",
                    "sv_SE": "Decibel"
                },
                "standard_unit_code": "DECIBEL",
                "units": [
                    {
                        "code": "DECIBEL",
                        "labels": {
                            "ca_ES": "Decibel",
                            "da_DK": "Decibel",
                            "de_DE": "Dezibel",
                            "en_GB": "Decibel",
                            "en_NZ": "Decibel",
                            "en_US": "Decibel",
                            "es_ES": "Decibelio",
                            "fi_FI": "Desibeli",
                            "fr_FR": "Décibel",
                            "it_IT": "Decibel",
                            "ja_JP": "デシベル",
                            "pt_BR": "Decibel",
                            "ru_RU": "Децибел",
                            "sv_SE": "Decibel"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "1"
                            }
                        ],
                        "symbol": "dB"
                    }
                ]
            },
            {
                "code": "Duration",
                "labels": {
                    "ca_ES": "Durada",
                    "da_DK": "Varighed",
                    "de_DE": "Dauer",
                    "en_GB": "Duration",
                    "en_NZ": "Duration",
                    "en_US": "Duration",
                    "es_ES": "Duración",
                    "fi_FI": "Kesto",
                    "fr_FR": "Durée",
                    "it_IT": "Durata",
                    "ja_JP": "期間",
                    "pt_BR": "Duração",
                    "ru_RU": "Длительности",
                    "sv_SE": "Varaktighet"
                },
                "standard_unit_code": "SECOND",
                "units": [
                    {
                        "code": "MILLISECOND",
                        "labels": {
                            "ca_ES": "Mil·lisegon",
                            "da_DK": "Millisekund",
                            "de_DE": "Millisekunde",
                            "en_GB": "Millisecond",
                            "en_NZ": "Millisecond",
                            "en_US": "Millisecond",
                            "es_ES": "Milisegundo",
                            "fi_FI": "Millisekunti",
                            "fr_FR": "Milliseconde",
                            "it_IT": "Millisecondi",
                            "ja_JP": "ミリ秒",
                            "pt_BR": "Milissegundo",
                            "ru_RU": "Миллисекунда",
                            "sv_SE": "Millisekund"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "0.001"
                            }
                        ],
                        "symbol": "ms"
                    },
                    {
                        "code": "SECOND",
                        "labels": {
                            "ca_ES": "Segon",
                            "da_DK": "Sekund",
                            "de_DE": "Sekunde",
                            "en_GB": "Second",
                            "en_NZ": "Second",
                            "en_US": "Second",
                            "es_ES": "Segundo",
                            "fi_FI": "Sekunti",
                            "fr_FR": "Seconde",
                            "it_IT": "Secondi",
                            "ja_JP": "秒",
                            "pt_BR": "Segundo",
                            "ru_RU": "Секунда",
                            "sv_SE": "Sekund"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "1"
                            }
                        ],
                        "symbol": "s"
                    },
                    {
                        "code": "MINUTE",
                        "labels": {
                            "ca_ES": "Minut",
                            "da_DK": "Minut",
                            "de_DE": "Minute",
                            "en_GB": "Minute",
                            "en_NZ": "Minute",
                            "en_US": "Minute",
                            "es_ES": "Minuto",
                            "fi_FI": "Minuutti",
                            "fr_FR": "Minute",
                            "it_IT": "Minuti",
                            "ja_JP": "分",
                            "pt_BR": "Minuto",
                            "ru_RU": "Минута",
                            "sv_SE": "Minut"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "60"
                            }
                        ],
                        "symbol": "m"
                    },
                    {
                        "code": "HOUR",
                        "labels": {
                            "ca_ES": "Hora",
                            "da_DK": "Time",
                            "de_DE": "Stunde",
                            "en_GB": "Hour",
                            "en_NZ": "Hour",
                            "en_US": "Hour",
                            "es_ES": "Hora",
                            "fi_FI": "Tunti",
                            "fr_FR": "Heure",
                            "it_IT": "Ora",
                            "ja_JP": "時",
                            "pt_BR": "Hora",
                            "ru_RU": "Час",
                            "sv_SE": "Timme"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "3600"
                            }
                        ],
                        "symbol": "h"
                    },
                    {
                        "code": "DAY",
                        "labels": {
                            "ca_ES": "Dia",
                            "da_DK": "Dag",
                            "de_DE": "Tag",
                            "en_GB": "Day",
                            "en_NZ": "Day",
                            "en_US": "Day",
                            "es_ES": "Día",
                            "fi_FI": "Päivä",
                            "fr_FR": "Jour",
                            "it_IT": "Giorno",
                            "ja_JP": "日",
                            "pt_BR": "Dia",
                            "ru_RU": "День",
                            "sv_SE": "Dag"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "86400"
                            }
                        ],
                        "symbol": "d"
                    },
                    {
                        "code": "WEEK",
                        "labels": {
                            "ca_ES": "Setmana",
                            "da_DK": "Uge",
                            "de_DE": "Woche",
                            "en_GB": "Week",
                            "en_NZ": "Week",
                            "en_US": "Week",
                            "es_ES": "Semana",
                            "fi_FI": "Viikko",
                            "fr_FR": "Semaine",
                            "it_IT": "Settimana",
                            "ja_JP": "週",
                            "pt_BR": "Semana",
                            "ru_RU": "Неделя",
                            "sv_SE": "Vecka"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "604800"
                            }
                        ],
                        "symbol": "week"
                    },
                    {
                        "code": "MONTH",
                        "labels": {
                            "ca_ES": "Mes",
                            "da_DK": "Måned",
                            "de_DE": "Monat",
                            "en_GB": "Month",
                            "en_NZ": "Month",
                            "en_US": "Month",
                            "es_ES": "Mes",
                            "fi_FI": "Kuukausi",
                            "fr_FR": "Mois",
                            "it_IT": "Mese",
                            "ja_JP": " 月",
                            "pt_BR": "Mês",
                            "ru_RU": "месяцев",
                            "sv_SE": "Månad"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "18748800"
                            }
                        ],
                        "symbol": "month"
                    },
                    {
                        "code": "YEAR",
                        "labels": {
                            "ca_ES": "Any",
                            "da_DK": "År",
                            "de_DE": "Jahr",
                            "en_GB": "Year",
                            "en_NZ": "Year",
                            "en_US": "Year",
                            "es_ES": "Año",
                            "fi_FI": "Vuosi",
                            "fr_FR": "Année",
                            "it_IT": "Anno",
                            "ja_JP": "年",
                            "pt_BR": "Ano",
                            "ru_RU": "лет",
                            "sv_SE": "År"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "31536000"
                            }
                        ],
                        "symbol": "year"
                    }
                ]
            },
            {
                "code": "ElectricCharge",
                "labels": {
                    "ca_ES": "Càrrega elèctrica",
                    "da_DK": "Elektrisk ladning",
                    "de_DE": "Elektrische Ladung",
                    "en_GB": "Electrical charge",
                    "en_NZ": "Electric charge",
                    "en_US": "Electric charge",
                    "es_ES": "Carga eléctrica",
                    "fi_FI": "Sähkövaraus",
                    "fr_FR": "Charge électrique",
                    "it_IT": "Carica elettrica",
                    "ja_JP": "電気料金",
                    "pt_BR": "Carga elétrica",
                    "ru_RU": "Электрический заряд",
                    "sv_SE": "Elektrisk laddning"
                },
                "standard_unit_code": "AMPEREHOUR",
                "units": [
                    {
                        "code": "MILLIAMPEREHOUR",
                        "labels": {
                            "ca_ES": "Microampers per hora",
                            "da_DK": "Milliampere time",
                            "de_DE": "Milliampere-Stunden",
                            "en_GB": "Milliampere hour",
                            "en_NZ": "Milliampere hour",
                            "en_US": "Milliampere hour",
                            "es_ES": "Miliamperio por hora",
                            "fi_FI": "Milliampeeritunti",
                            "fr_FR": "Milliampères heure",
                            "it_IT": "Milliamperora",
                            "ja_JP": "ミリ アンペア時間",
                            "pt_BR": "Miliampère/hora",
                            "ru_RU": "Миллиампер в час",
                            "sv_SE": "Milliampere timme"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "0.001"
                            }
                        ],
                        "symbol": "mAh"
                    },
                    {
                        "code": "AMPEREHOUR",
                        "labels": {
                            "ca_ES": "Ampers per hora",
                            "da_DK": "Ampere timer",
                            "de_DE": "Ampere-Stunden",
                            "en_GB": "Ampere hour",
                            "en_NZ": "Ampere hour",
                            "en_US": "Ampere hour",
                            "es_ES": "Amperio por hora",
                            "fi_FI": "Ampeeritunti",
                            "fr_FR": "Ampère heure",
                            "it_IT": "Amperora",
                            "ja_JP": "アンペア時間",
                            "pt_BR": "Ampère/hora",
                            "ru_RU": "Ампер в час",
                            "sv_SE": "Ampere timmar"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "1"
                            }
                        ],
                        "symbol": "Ah"
                    },
                    {
                        "code": "MILLICOULOMB",
                        "labels": {
                            "ca_ES": "Mil·licoulomb",
                            "da_DK": "Millicoulomb",
                            "de_DE": "Millicoulomb",
                            "en_GB": "Millicoulomb",
                            "en_NZ": "Millicoulomb",
                            "en_US": "Millicoulomb",
                            "es_ES": "Miliculombio",
                            "fi_FI": "Millicoulombi",
                            "fr_FR": "Millicoulomb",
                            "it_IT": "Millicoulomb",
                            "ja_JP": "ミリクーロン",
                            "pt_BR": "Milicoulomb",
                            "ru_RU": "Милликулон",
                            "sv_SE": "Millicoulomb"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "div",
                                "value": "3600000"
                            }
                        ],
                        "symbol": "mC"
                    },
                    {
                        "code": "CENTICOULOMB",
                        "labels": {
                            "ca_ES": "Centicoulomb",
                            "da_DK": "Centicoulomb",
                            "de_DE": "Centicoulomb",
                            "en_GB": "Centicoulomb",
                            "en_NZ": "Centicoulomb",
                            "en_US": "Centicoulomb",
                            "es_ES": "Centiculombio",
                            "fi_FI": "Sentticoulombi",
                            "fr_FR": "Centicoulomb",
                            "it_IT": "Centicoulomb",
                            "ja_JP": "センチクーロン",
                            "pt_BR": "Centicoulomb",
                            "ru_RU": "Сантикулон",
                            "sv_SE": "Centicoulomb"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "div",
                                "value": "360000"
                            }
                        ],
                        "symbol": "cC"
                    },
                    {
                        "code": "DECICOULOMB",
                        "labels": {
                            "ca_ES": "Decicoulomb",
                            "da_DK": "Decicoulomb",
                            "de_DE": "Decicoulomb",
                            "en_GB": "Decicoulomb",
                            "en_NZ": "Decicoulomb",
                            "en_US": "Decicoulomb",
                            "es_ES": "Deciculombio",
                            "fi_FI": "Desicoulombi",
                            "fr_FR": "Décicoulomb",
                            "it_IT": "Decicoulomb",
                            "ja_JP": "デシクーロン",
                            "pt_BR": "Decicoulomb",
                            "ru_RU": "Децикулон",
                            "sv_SE": "Decicoulomb"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "div",
                                "value": "36000"
                            }
                        ],
                        "symbol": "dC"
                    },
                    {
                        "code": "COULOMB",
                        "labels": {
                            "ca_ES": "Coulomb",
                            "da_DK": "Coulomb",
                            "de_DE": "Coulomb",
                            "en_GB": "Coulomb",
                            "en_NZ": "Coulomb",
                            "en_US": "Coulomb",
                            "es_ES": "Culombio",
                            "fi_FI": "Coulombi",
                            "fr_FR": "Coulomb",
                            "it_IT": "Coulomb",
                            "ja_JP": "クーロン",
                            "pt_BR": "Coulomb",
                            "ru_RU": "Кулон",
                            "sv_SE": "Coulomb"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "div",
                                "value": "3600"
                            }
                        ],
                        "symbol": "C"
                    },
                    {
                        "code": "DEKACOULOMB",
                        "labels": {
                            "ca_ES": "Decacoulomb",
                            "da_DK": "Dekacoulomb",
                            "de_DE": "Dekacoulomb",
                            "en_GB": "Dekacoulomb",
                            "en_NZ": "Dekacoulomb",
                            "en_US": "Dekacoulomb",
                            "es_ES": "Decaculombio",
                            "fi_FI": "Dekacoulombi",
                            "fr_FR": "Décacoulomb",
                            "it_IT": "Decacoulomb",
                            "ja_JP": "デカクーロン",
                            "pt_BR": "Dekacoulomb",
                            "ru_RU": "Декакулон",
                            "sv_SE": "Dekacoulomb"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "div",
                                "value": "360"
                            }
                        ],
                        "symbol": "daC"
                    },
                    {
                        "code": "HECTOCOULOMB",
                        "labels": {
                            "ca_ES": "Hectocoulomb",
                            "da_DK": "Hectocoulomb",
                            "de_DE": "Hectocoulomb",
                            "en_GB": "Hectocoulomb",
                            "en_NZ": "Hectocoulomb",
                            "en_US": "Hectocoulomb",
                            "es_ES": "Hectoculombio",
                            "fi_FI": "Hehtocoulombi",
                            "fr_FR": "Hectocoulomb",
                            "it_IT": "Hectocoulomb",
                            "ja_JP": "ヘクトクーロン",
                            "pt_BR": "Hectocoulomb",
                            "ru_RU": "Гектокулон",
                            "sv_SE": "Hectocoulomb"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "div",
                                "value": "36"
                            }
                        ],
                        "symbol": "hC"
                    },
                    {
                        "code": "KILOCOULOMB",
                        "labels": {
                            "ca_ES": "Quilocoulomb",
                            "da_DK": "Kilocoulomb",
                            "de_DE": "Kilocoulomb",
                            "en_GB": "Kilocoulomb",
                            "en_NZ": "Kilocoulomb",
                            "en_US": "Kilocoulomb",
                            "es_ES": "Kiloculombio",
                            "fi_FI": "Kilocoulombi",
                            "fr_FR": "Kilocoulomb",
                            "it_IT": "Kilocoulomb",
                            "ja_JP": "キロクーロン",
                            "pt_BR": "Quilocoulomb",
                            "ru_RU": "Килокулон",
                            "sv_SE": "Kilocoulomb"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "div",
                                "value": "3.6"
                            }
                        ],
                        "symbol": "kC"
                    }
                ]
            },
            {
                "code": "Energy",
                "labels": {
                    "ca_ES": "Energia",
                    "da_DK": "Energi",
                    "de_DE": "Energie",
                    "en_GB": "Energy",
                    "en_NZ": "Energy",
                    "en_US": "Energy",
                    "es_ES": "Energía",
                    "fi_FI": "Energia",
                    "fr_FR": "Energie",
                    "it_IT": "Energia",
                    "ja_JP": "エネルギー",
                    "pt_BR": "Energia",
                    "ru_RU": "Энергия",
                    "sv_SE": "Energi"
                },
                "standard_unit_code": "JOULE",
                "units": [
                    {
                        "code": "JOULE",
                        "labels": {
                            "de_DE": "Joule",
                            "en_US": "joule",
                            "fr_FR": "joule"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "1"
                            }
                        ],
                        "symbol": "J"
                    },
                    {
                        "code": "CALORIE",
                        "labels": {
                            "de_DE": "Kalorien",
                            "en_US": "calorie",
                            "fr_FR": "calorie"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "4.184"
                            }
                        ],
                        "symbol": "cal"
                    },
                    {
                        "code": "KILOCALORIE",
                        "labels": {
                            "ca_ES": "quilocalories",
                            "da_DK": "kilokalorie",
                            "de_DE": "Kilokalorien",
                            "en_GB": "kilocalorie",
                            "en_NZ": "kilocalorie",
                            "en_US": "kilocalorie",
                            "es_ES": "kilo caloría",
                            "fi_FI": "Kilokalori",
                            "fr_FR": "kilocalorie",
                            "it_IT": "kilocalorie",
                            "ja_JP": "キロカロリー",
                            "pt_BR": "quilocaloria",
                            "ru_RU": "килокалория",
                            "sv_SE": "kilokalori"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "4184"
                            }
                        ],
                        "symbol": "kcal"
                    },
                    {
                        "code": "KILOJOULE",
                        "labels": {
                            "ca_ES": "kilojoule",
                            "da_DK": "kJ",
                            "de_DE": "Kilojoule",
                            "en_GB": "kilojoule",
                            "en_NZ": "kilojoule",
                            "en_US": "kilojoule",
                            "es_ES": "kilojulio",
                            "fi_FI": "kilojoule",
                            "fr_FR": "kilojoule",
                            "it_IT": "kilojoule",
                            "ja_JP": "キロジュール",
                            "pt_BR": "kilojoule",
                            "ru_RU": "килоджоуль",
                            "sv_SE": "kilojoule"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "1000"
                            }
                        ],
                        "symbol": "kJ"
                    }
                ]
            }
        ]
    }
}
JSON;
    }

    private function paginatedMeasurementFamilies(): string
    {
        return <<<JSON
{
    "_links": {
        "self": {
            "href": "http://localhost/api/rest/v1/measurement-family?page=2&limit=3&with_count=false"
        },
        "first": {
            "href": "http://localhost/api/rest/v1/measurement-family?page=1&limit=3&with_count=false"
        },
        "previous": {
            "href": "http://localhost/api/rest/v1/measurement-family?page=1&limit=3&with_count=false"
        },
        "next": {
            "href": "http://localhost/api/rest/v1/measurement-family?page=3&limit=3&with_count=false"
        }
    },
    "current_page": 2,
    "_embedded": {
        "items": [
            {
                "code": "Brightness",
                "labels": {
                    "de_DE": "Helligkeit",
                    "en_US": "Brightness",
                    "fr_FR": "Luminosité"
                },
                "standard_unit_code": "LUMEN",
                "units": [
                    {
                        "code": "LUMEN",
                        "labels": {
                            "de_DE": "Lumen",
                            "en_US": "Lumen",
                            "fr_FR": "Lumen"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "1"
                            }
                        ],
                        "symbol": "lm"
                    },
                    {
                        "code": "NIT",
                        "labels": {
                            "de_DE": "Nit",
                            "en_US": "Nit",
                            "fr_FR": "Nit"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "0.2918855809"
                            }
                        ],
                        "symbol": "nits"
                    }
                ]
            },
            {
                "code": "Capacitance",
                "labels": {
                    "de_DE": "Elektrische Kapazität",
                    "en_US": "Capacitance",
                    "fr_FR": "Capacité électrique"
                },
                "standard_unit_code": "FARAD",
                "units": [
                    {
                        "code": "ATTOFARAD",
                        "labels": {
                            "en_US": "Attofarad",
                            "fr_FR": "Attofarad"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "div",
                                "value": "1000000000000000000"
                            }
                        ],
                        "symbol": "aF"
                    },
                    {
                        "code": "PICOFARAD",
                        "labels": {
                            "en_US": "Picofarad",
                            "fr_FR": "Picofarad"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "div",
                                "value": "1000000000000"
                            }
                        ],
                        "symbol": "pF"
                    },
                    {
                        "code": "NANOFARAD",
                        "labels": {
                            "en_US": "Nanofarad",
                            "fr_FR": "Nanofarad"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "div",
                                "value": "1000000000"
                            }
                        ],
                        "symbol": "nF"
                    },
                    {
                        "code": "MICROFARAD",
                        "labels": {
                            "en_US": "Microfarad",
                            "fr_FR": "Microfarad"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "div",
                                "value": "1000000"
                            }
                        ],
                        "symbol": "µF"
                    },
                    {
                        "code": "MILLIFARAD",
                        "labels": {
                            "en_US": "Millifarad",
                            "fr_FR": "Millifarad"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "div",
                                "value": "1000"
                            }
                        ],
                        "symbol": "mF"
                    },
                    {
                        "code": "FARAD",
                        "labels": {
                            "en_US": "Farad",
                            "fr_FR": "Farad"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "1"
                            }
                        ],
                        "symbol": "F"
                    },
                    {
                        "code": "KILOFARAD",
                        "labels": {
                            "en_US": "Kilofarad",
                            "fr_FR": "Kilofarad"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "1000"
                            }
                        ],
                        "symbol": "kF"
                    }
                ]
            },
            {
                "code": "CaseBox",
                "labels": {
                    "ca_ES": "Embalatge",
                    "da_DK": "Emballage",
                    "de_DE": "Verpackung",
                    "en_GB": "Packaging",
                    "en_NZ": "Packaging",
                    "en_US": "Packaging",
                    "es_ES": "Embalaje",
                    "fi_FI": "Pakkaus",
                    "fr_FR": "Emballage",
                    "it_IT": "Imballo",
                    "ja_JP": "包装",
                    "pt_BR": "Embalagens",
                    "ru_RU": "Упаковка",
                    "sv_SE": "Förpackning"
                },
                "standard_unit_code": "PIECE",
                "units": [
                    {
                        "code": "PIECE",
                        "labels": {
                            "ca_ES": "Peça",
                            "da_DK": "Stykke",
                            "de_DE": "Stück",
                            "en_GB": "Piece",
                            "en_NZ": "Piece",
                            "en_US": "Piece",
                            "es_ES": "Pieza",
                            "fi_FI": "Kappale",
                            "fr_FR": "Unité",
                            "it_IT": "Pezzo",
                            "ja_JP": "作品",
                            "pt_BR": "Peça",
                            "ru_RU": "шт.",
                            "sv_SE": "Stycke"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "1"
                            }
                        ],
                        "symbol": "Pc"
                    },
                    {
                        "code": "DOZEN",
                        "labels": {
                            "ca_ES": "Dotzena",
                            "da_DK": "Dusin",
                            "de_DE": "Dutzend",
                            "en_GB": "Dozen",
                            "en_NZ": "Dozen",
                            "en_US": "Dozen",
                            "es_ES": "Docena",
                            "fi_FI": "Tusina",
                            "fr_FR": "Douzaine",
                            "it_IT": "Dozzina",
                            "ja_JP": "ダース",
                            "pt_BR": "Dúzia",
                            "ru_RU": "Дюжина",
                            "sv_SE": "Dussin"
                        },
                        "convert_from_standard": [
                            {
                                "operator": "mul",
                                "value": "12"
                            }
                        ],
                        "symbol": "Dz"
                    }
                ]
            }
        ]
    }
}
JSON;
    }
}
