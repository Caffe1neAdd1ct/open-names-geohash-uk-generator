<?php

namespace App\Workflow;

use Port\Steps\StepAggregator as Workflow;
use \Port\Csv\CsvReader;
use \Port\Steps\Step\FilterStep;

/**
 * CSV Port Workflow
 *
 * @author Kevin Andrews <kevin@zvps.uk>
 */
class OpenNameImport extends Workflow
{
    /**
     * @var \DI\Container 
     */
    private $container;
    
    /**
     * 
     * @param CsvReader $reader
     * @param string $name
     */
    public function __construct(\DI\Container $container, CsvReader $reader, $name = null)
    {
        parent::__construct($reader, $name);
        $this->container = $container;
        $this->setLogger($this->container->get(\Psr\Log\LoggerInterface::class));
        $this->setup($reader);
    }
    
    private function setup(CsvReader $reader)
    {
        $reader->setColumnHeaders([
            'ID', 
            'NAMES_URI',
            'NAME1',
            'NAME1_LANG',
            'NAME2',
            'NAME2_LANG',
            'TYPE',
            'LOCAL_TYPE',
            'GEOMETRY_X',
            'GEOMETRY_Y',
            'MOST_DETAIL_VIEW_RES',
            'LEAST_DETAIL_VIEW_RES',
            'MBR_XMIN',
            'MBR_YMIN',
            'MBR_XMAX',
            'MBR_YMAX',
            'POSTCODE_DISTRICT',
            'POSTCODE_DISTRICT_URI',
            'POPULATED_PLACE',
            'POPULATED_PLACE_URI',
            'POPULATED_PLACE_TYPE',
            'DISTRICT_BOROUGH',
            'DISTRICT_BOROUGH_URI',
            'DISTRICT_BOROUGH_TYPE',
            'COUNTY_UNITARY',
            'COUNTY_UNITARY_URI',
            'COUNTY_UNITARY_TYPE',
            'REGION',
            'REGION_URI',
            'COUNTRY',
            'COUNTRY_URI',
            'RELATED_SPATIAL_OBJECT',
            'SAME_AS_DBPEDIA',
            'SAME_AS_GEONAMES',
        ]);
        $this->filters();
        $this->converters();
    }
    
    private function filters()
    {
        $filterPostcodes = new FilterStep();
        $filterPostcodes->add(function($input) {
            return (trim($input['LOCAL_TYPE']) === 'Postcode');
        });
        $this->addStep($filterPostcodes);
    }

    private function converters()
    {
        $coor = new \Port\Steps\Step\ConverterStep([
            function($input) {
                $coorConverter = new \PHPCoord\OSRef($input['GEOMETRY_X'], $input['GEOMETRY_Y']);
                $latLng = $coorConverter->toLatLng();
                $latLng->toWGS84();
                
                $input['LAT_X'] = $latLng->getLat();
                $input['LNG_Y'] = $latLng->getLng();
                $input['GEOHASH'] = \Lvht\GeoHash::encode($latLng->getLng(), $latLng->getLat());
                    
                return $input;
            },
            function($input) {
                $input['AREA'] = explode(' ', $input['NAME1'])[0];
                $input['DISTRICT'] = substr($input['AREA'], 0, 2);
                return $input;
            },
            function($input) {
                return array_intersect_key($input, array_flip(['ID', 'NAME1', 'AREA', 'DISTRICT', 'LOCAL_TYPE', 'GEOMETRY_X', 'GEOMETRY_Y', 'LAT_X', 'LNG_Y', 'GEOHASH', 'COUNTY_UNITARY', 'REGION']));
            },
            function($input) {
                return [
                    'postcode'      => $input['ID'],
                    'area_code'     => $input['AREA'],
                    'district_code' => $input['DISTRICT'],
                    'geometry_x'    => $input['GEOMETRY_X'],
                    'geometry_y'    => $input['GEOMETRY_Y'],
                    'lat_x'         => $input['LAT_X'],
                    'lng_y'         => $input['LNG_Y'],
                    'geohash'       => $input['GEOHASH'],
                    'county'        => $input['COUNTY_UNITARY'],
                    'region'        => $input['REGION'],
                ];
            }
        ]);
        $this->addStep($coor);
        
    }
}