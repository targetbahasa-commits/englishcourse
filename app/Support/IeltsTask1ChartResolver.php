<?php

namespace App\Support;

/**
 * Resolves the chart data needed to render a single IELTS Writing Task 1
 * meeting (line/bar/pie/table/mixed chart, or a flowchart/map image).
 *
 * This replaces a ~135KB inline <script> that embedded chart data for every
 * Task 1 meeting on every page load. Instead, the server looks up only the
 * data needed for the meeting currently being viewed, so a data error in one
 * entry can no longer break every other meeting's page.
 */
class IeltsTask1ChartResolver
{
    public static function resolve($meeting): array
    {
        $meetingNumber = (int) $meeting->meeting_number;
        $id = (int) $meeting->id;

        // Order mirrors the original @elseif chain exactly, including the
        // legacy special cases (meeting_number 111, id 67), so behavior is
        // unchanged for every meeting_number range except double-pie (see below).
        if ($meetingNumber === 111 || ($meetingNumber >= 1010 && $meetingNumber <= 1059)) {
            return self::resolveLine($meetingNumber);
        }

        if (($meetingNumber >= 1100 && $meetingNumber <= 1109) || ($meetingNumber >= 1140 && $meetingNumber <= 1149) || $id === 67) {
            // id === 67 only ever affected whether the bar canvas rendered at
            // all; the data lookup always used meeting_number, never id.
            //
            // 1110-1129 and 1130-1139 are excluded here: ielts_task1_bar_charts
            // only has real data for 1100-1109 (and 1149); every key from
            // 1110-1148 is generic "Data Comparison Metrics" filler. 1110-1129
            // is the genuine flowchart range, and 1130-1139 is the genuine map
            // range (10 legacy map images — Paradise Island, Felixstone, etc.
            // — that this bar check was shadowing), so neither may be caught
            // here.
            return self::resolveBar($meetingNumber);
        }

        if ($meetingNumber >= 1200 && $meetingNumber <= 1249) {
            // The original "double pie" range (1204-1249) had no matching data
            // in doublePieConfigs (its only keys, 1054-1069, are unreachable —
            // they fall inside the line-chart range instead), so every meeting
            // in 1204-1249 rendered a blank chart. pieConfigs already has valid
            // single-pie data for the entire 1200-1249 range, so we use that.
            return self::resolvePie($meetingNumber);
        }

        if ($meetingNumber >= 1300 && $meetingNumber <= 1349) {
            return self::resolveTable($meetingNumber);
        }

        if ($meetingNumber >= 1400 && $meetingNumber <= 1449) {
            // 1645-1649 must NOT be routed here: those 5 meeting_numbers are
            // genuine map topics (titles like "Deepwater Port Logistics Hub
            // Masterplan") and belong to the map range below. An earlier
            // change mistakenly rerouted them to reused mixed-chart data via
            // a -200 key offset, causing clicks on map practice items to show
            // an unrelated table instead of a map.
            return self::resolveMixed($meetingNumber);
        }

        if (($meetingNumber >= 1110 && $meetingNumber <= 1129) || ($meetingNumber >= 1470 && $meetingNumber <= 1549)) {
            return self::resolveFlowchart($meetingNumber);
        }

        if (($meetingNumber >= 1130 && $meetingNumber <= 1149) || ($meetingNumber >= 1600 && $meetingNumber <= 1649)) {
            return self::resolveMap($meetingNumber, $meeting->image ?? null);
        }

        return ['kind' => 'none'];
    }

    private static function resolveLine(int $meetingNumber): array
    {
        $configs = config('ielts_task1_line_charts');

        $config = $configs[$meetingNumber] ?? $configs[1010];

        return [
            'kind' => 'line',
            'title' => $config['title'],
            'labels' => $config['labels'],
            'datasets' => $config['datasets'],
            'scales' => $config['scales'] ?? null,
        ];
    }

    private static function resolveBar(int $meetingNumber): array
    {
        $configs = config('ielts_task1_bar_charts');

        $config = $configs[$meetingNumber] ?? $configs[1100] ?? $configs[1030];

        return [
            'kind' => 'bar',
            'title' => $config['title'],
            'labels' => $config['labels'],
            'datasets' => $config['datasets'],
        ];
    }

    private static function resolvePie(int $meetingNumber): array
    {
        $configs = config('ielts_task1_pie_charts');

        $config = $configs[$meetingNumber] ?? $configs[1200] ?? $configs[1030];

        $res = [
            'kind' => 'pie',
            'title' => $config['title'],
            'labels' => $config['labels'],
        ];

        if (isset($config['charts'])) {
            $res['charts'] = $config['charts'];
        }
        if (isset($config['datasets'])) {
            $res['datasets'] = $config['datasets'];
        }

        return $res;
    }

    private static function resolveTable(int $meetingNumber): array
    {
        $configs = config('ielts_task1_table_charts');

        if (isset($configs[$meetingNumber])) {
            $config = $configs[$meetingNumber];
        } else {
            // Same deterministic rotation as the original JS: only the
            // 1070-1089 subset of tableConfigs is used as a fallback pool.
            $fallbackIds = array_values(array_filter(
                array_keys($configs),
                fn ($id) => $id >= 1070 && $id <= 1089
            ));
            sort($fallbackIds);
            $fallbackId = $fallbackIds[abs($meetingNumber) % count($fallbackIds)] ?? 1070;
            $config = $configs[$fallbackId];
        }

        return [
            'kind' => 'table',
            'title' => $config['title'] ?? null,
            'headers' => $config['headers'] ?? null,
            'rows' => $config['rows'] ?? null,
            'doubleTables' => $config['doubleTables'] ?? null,
        ];
    }

    private static function resolveMixed(int $meetingNumber): array
    {
        $configs = config('ielts_task1_mixed_charts');

        $config = $configs[$meetingNumber] ?? $configs[1090] ?? $configs[1050] ?? [];

        return [
            'kind' => 'mixed',
            'charts' => $config,
        ];
    }

    private static function flowchartImages(): array
    {
        return [
            1110 => ['path' => 'images/practice/cement_production.png', 'alt' => 'Cement and Concrete Production Process', 'title' => 'the stages and equipment used in the cement-making process, and how cement is used to produce concrete for building purposes', 'type' => 'diagram'],
            1111 => ['path' => 'images/practice/coconut_oil_production.png', 'alt' => 'Coconut Oil Manufacturing Process', 'title' => 'the mass manufacturing of coconut oil', 'type' => 'process diagram'],
            1112 => ['path' => 'images/practice/glass_container_production.png', 'alt' => 'Glass Container Production Process', 'title' => 'how glass containers are made. The steps of the process are numbered 1 to 9', 'type' => 'process diagram'],
            1113 => ['path' => 'images/practice/sheep_cloning_process.png', 'alt' => 'Sheep Embryo Cloning Process', 'title' => 'the process by which sheep embryos are cloned', 'type' => 'diagram'],
            1114 => ['path' => 'images/practice/water_treatment_process.jpg', 'alt' => 'Water Treatment Process', 'title' => 'the process of the water treatment', 'type' => 'diagram'],
            1115 => ['path' => 'images/practice/hydroelectric_power_process.png', 'alt' => 'Hydroelectric Power Generation Process', 'title' => 'the process by which electricity is generated in two types of hydroelectric power station', 'type' => 'diagram'],
            1116 => ['path' => 'images/practice/frog_life_cycle.png', 'alt' => 'Life Cycle of a Frog', 'title' => 'the life cycle of a frog', 'type' => 'diagram'],
            1117 => ['path' => 'images/practice/silkworm_life_cycle.png', 'alt' => 'Life Cycle of the Silkworm', 'title' => 'the life cycle of the silkworm and the stages in the production of silk cloth', 'type' => 'diagrams'],
            1118 => ['path' => 'images/practice/water_cycle.png', 'alt' => 'Water Cycle', 'title' => 'the water cycle, which is the continuous movement of water on, above and below the surface of the Earth', 'type' => 'diagram'],
            1119 => ['path' => 'images/practice/milk_production.png', 'alt' => 'Milk Production Process', 'title' => 'the process by which milk and related products are produced', 'type' => 'diagram'],
            1125 => ['path' => 'images/practice/sea_turtle_life_cycle.png', 'alt' => 'Life Cycle of Sea Turtles', 'title' => 'the life cycle of sea turtles, from hatching through open ocean migration to adulthood and nesting', 'type' => 'diagram'],
            1120 => ['path' => 'images/practice/1120_butterfly_life_cycle.svg', 'alt' => 'Butterfly Life Cycle', 'title' => 'the four stages in the life cycle of a butterfly, from egg to adult', 'type' => 'diagram'],
            1122 => ['path' => 'images/practice/tea_processing_flowchart.png', 'alt' => 'Tea Processing: From Leaf to Cup', 'title' => 'the stages involved in processing tea leaves into yellow tea', 'type' => 'process diagram'],
            1471 => ['path' => 'images/practice/tea_processing_flowchart.png', 'alt' => 'Tea Processing: From Leaf to Cup', 'title' => 'the stages involved in processing tea leaves into yellow tea', 'type' => 'process diagram'],
            1129 => ['path' => 'images/practice/1129_offset_printing.svg', 'alt' => 'Offset Printing Press Mechanism', 'title' => 'how an offset printing press transfers ink onto paper to print a newspaper', 'type' => 'diagram'],
            1500 => ['path' => 'images/practice/1500_water_purification.png', 'alt' => 'Water Purification Process', 'title' => 'the typical stages of a drinking water treatment process', 'type' => 'process diagram'],
            1503 => ['path' => 'images/practice/1503_solar_pv_system.png', 'alt' => 'Solar Energy Conversion to Electricity', 'title' => 'how a residential solar photovoltaic system converts sunlight into electricity', 'type' => 'diagram'],
            1504 => ['path' => 'images/practice/1504_coffee_processing.svg', 'alt' => 'Coffee Bean Processing', 'title' => 'how coffee cherries are processed using the washed, natural, and honey methods', 'type' => 'process diagram'],
            1505 => ['path' => 'images/practice/1505_hydropower_dam.svg', 'alt' => 'Hydropower Electricity Generation', 'title' => 'how a hydropower dam generates electricity', 'type' => 'diagram'],
            1506 => ['path' => 'images/practice/1506_desalination_ro_plant.png', 'alt' => 'Desalination Plant Layout', 'title' => 'the sequential filtration stages of a reverse-osmosis desalination plant', 'type' => 'process diagram'],
            1509 => ['path' => 'images/practice/1509_wastewater_treatment.png', 'alt' => 'Wastewater Treatment Plant Operations', 'title' => 'the sequence of operations in a modern wastewater treatment plant', 'type' => 'process diagram'],
            1511 => ['path' => 'images/practice/1511_olive_oil_extraction.png', 'alt' => 'Olive Oil Extraction Process', 'title' => 'the modern method of extracting olive oil', 'type' => 'process diagram'],
            1512 => ['path' => 'images/practice/1512_geothermal_power.svg', 'alt' => 'Geothermal Power Generation', 'title' => 'how a geothermal power station generates electricity', 'type' => 'diagram'],
            1514 => ['path' => 'images/practice/1514_co_composting.svg', 'alt' => 'Co-Composting Process', 'title' => 'the co-composting process used to treat organic waste', 'type' => 'process diagram'],
            1516 => ['path' => 'images/practice/1516_rainwater_harvesting.svg', 'alt' => 'Rainwater Harvesting System', 'title' => 'a rainwater harvesting and filtration system', 'type' => 'diagram'],
            1517 => ['path' => 'images/practice/1517_blast_furnace_steel.png', 'alt' => 'Blast-Furnace Iron Production', 'title' => 'the blast-furnace process of producing iron from iron ore', 'type' => 'process diagram'],
            1518 => ['path' => 'images/practice/1518_milk_pasteurization.png', 'alt' => 'Milk Pasteurisation', 'title' => 'the stages of milk pasteurisation', 'type' => 'process diagram'],
            1520 => ['path' => 'images/practice/1520_coal_power_plant.svg', 'alt' => 'Thermal Power Station', 'title' => 'how a thermal (coal-fired) power station generates electricity', 'type' => 'diagram'],
            1524 => ['path' => 'images/practice/1524_biogas_plant.svg', 'alt' => 'Biogas Digester', 'title' => 'how a household biogas digester converts organic waste into biogas', 'type' => 'diagram'],
            1535 => ['path' => 'images/practice/1535_leather_tanning.png', 'alt' => 'Leather Tanning and Finishing Process', 'title' => 'the general stages of leather tanning and finishing, from the beamhouse through to finishing', 'type' => 'process diagram'],
            1538 => ['path' => 'images/practice/1538_concrete_batching.png', 'alt' => 'Concrete Batching Process', 'title' => 'a typical concrete batching process', 'type' => 'process diagram'],
            1539 => ['path' => 'images/practice/1539_fish_pond.svg', 'alt' => 'Fish Pond Aquaculture System', 'title' => 'a fish pond aquaculture system', 'type' => 'diagram'],
            1540 => ['path' => 'images/practice/1540_solar_thermal_heater.svg', 'alt' => 'Solar Water Heating System', 'title' => 'how an active solar water heating system works', 'type' => 'diagram'],
            1542 => ['path' => 'images/practice/1542_beer_brewing.svg', 'alt' => 'Beer Brewing Process', 'title' => 'the stages of the beer brewing and fermentation process', 'type' => 'process diagram'],
            1543 => ['path' => 'images/practice/1543_lithium_battery.png', 'alt' => 'Lithium-Ion Battery Manufacturing', 'title' => 'the manufacturing process of lithium-ion battery cells', 'type' => 'process diagram'],
            1545 => ['path' => 'images/practice/1545_natural_gas_processing.svg', 'alt' => 'Natural Gas Processing', 'title' => 'how raw natural gas is processed into pipeline sales gas', 'type' => 'process diagram'],
            1546 => ['path' => 'images/practice/1546_flour_milling.png', 'alt' => 'Flour Roller-Milling Process', 'title' => 'the roller-mill grinding process used in flour milling', 'type' => 'diagram'],
            1549 => ['path' => 'images/practice/1549_landfill_gas.svg', 'alt' => 'Landfill Gas Capture', 'title' => 'how methane gas from a landfill is captured and converted into electricity', 'type' => 'diagram'],
            1121 => ['path' => 'images/practice/chicken_incubation_process.png', 'alt' => 'Chicken Egg Incubation and Hatching Process', 'title' => 'the process of chicken egg incubation and hatching', 'type' => 'process diagram'],
            1470 => ['path' => 'images/practice/chicken_incubation_process.png', 'alt' => 'Chicken Egg Incubation and Hatching Process', 'title' => 'the process of chicken egg incubation and hatching', 'type' => 'process diagram'],
            1123 => ['path' => 'images/practice/honey_production_process.png', 'alt' => 'Honey Production Process', 'title' => 'the process of honey production', 'type' => 'process diagram'],
            1472 => ['path' => 'images/practice/honey_production_process.png', 'alt' => 'Honey Production Process', 'title' => 'the process of honey production', 'type' => 'process diagram'],
            1124 => ['path' => 'images/practice/1124_wine_making.svg', 'alt' => 'Wine Making Process', 'title' => 'the wine making process', 'type' => 'process diagram'],
            1126 => ['path' => 'images/practice/wool_production_process.png', 'alt' => 'Wool Production: From Sheep to Fabric', 'title' => 'the process of wool production, from sheep to fabric', 'type' => 'process diagram'],
            1475 => ['path' => 'images/practice/wool_production_process.png', 'alt' => 'Wool Production: From Sheep to Fabric', 'title' => 'the process of wool production, from sheep to fabric', 'type' => 'process diagram'],
            1127 => ['path' => 'images/practice/1127_pasta_manufacturing.svg', 'alt' => 'Pasta Manufacturing Process', 'title' => 'the pasta manufacturing process', 'type' => 'process diagram'],
            1128 => ['path' => 'images/practice/1128_ice_cream_manufacturing.svg', 'alt' => 'Ice Cream Manufacturing Process', 'title' => 'the ice cream manufacturing process', 'type' => 'process diagram'],
            1501 => ['path' => 'images/practice/1501_paper_recycling.svg', 'alt' => 'Paper Recycling Manufacturing Cycle', 'title' => 'the paper recycling manufacturing cycle', 'type' => 'process diagram'],
            1502 => ['path' => 'images/practice/1502_glass_bottle_recycling.svg', 'alt' => 'Glass Bottle Production & Recycling Loop', 'title' => 'the glass bottle production and recycling loop', 'type' => 'process diagram'],
            1507 => ['path' => 'images/practice/1507_cement_manufacturing.svg', 'alt' => 'Cement Manufacturing Production Stages', 'title' => 'the production stages of cement manufacturing', 'type' => 'process diagram'],
            1508 => ['path' => 'images/practice/1508_plastic_bottle_to_yarn.svg', 'alt' => 'Plastic Bottle Recycling to Fabric Yarn', 'title' => 'how plastic bottles are recycled into fabric yarn', 'type' => 'process diagram'],
            1510 => ['path' => 'images/practice/1510_aluminium_can_recycling.svg', 'alt' => 'Aluminium Can Recycling Process', 'title' => 'the aluminium can recycling process', 'type' => 'process diagram'],
            1513 => ['path' => 'images/practice/1513_sugar_cane_refining.svg', 'alt' => 'Sugar Cane Refining and Production', 'title' => 'the process of sugar cane refining and production', 'type' => 'process diagram'],
            1515 => ['path' => 'images/practice/1515_biofuel_production.svg', 'alt' => 'Biofuel Production from Agricultural Crops', 'title' => 'the production of biofuel from agricultural crops', 'type' => 'process diagram'],
            1519 => ['path' => 'images/practice/1519_wind_energy.svg', 'alt' => 'Wind Energy Harnessing & Grid Distribution', 'title' => 'how wind energy is harnessed and distributed to the grid', 'type' => 'process diagram'],
            1521 => ['path' => 'images/practice/1521_chocolate_manufacturing.jpg', 'alt' => 'Chocolate Manufacturing Production Cycle', 'title' => 'the chocolate manufacturing production cycle', 'type' => 'process diagram'],
            1522 => ['path' => 'images/practice/1522_car_battery_recycling.svg', 'alt' => 'Used Car Battery Recycling Process', 'title' => 'the process of recycling used car batteries', 'type' => 'process diagram'],
            1523 => ['path' => 'images/practice/1523_cotton_fabric_production.svg', 'alt' => 'Cotton Fabric Production from Raw Fibres', 'title' => 'the production of cotton fabric from raw fibres', 'type' => 'process diagram'],
            1525 => ['path' => 'images/practice/1525_sea_salt_extraction.svg', 'alt' => 'Sea Salt Extraction and Refining Steps', 'title' => 'the process of sea salt extraction and refining', 'type' => 'process diagram'],
            1526 => ['path' => 'images/practice/1526_rubber_tyre_manufacturing.svg', 'alt' => 'Rubber Tyre Manufacturing Process', 'title' => 'the rubber tyre manufacturing process', 'type' => 'process diagram'],
            1527 => ['path' => 'images/practice/1527_bread_bakery_production.svg', 'alt' => 'Bread Bakery Production Line Stages', 'title' => 'the production line stages of a bread bakery', 'type' => 'process diagram'],
            1528 => ['path' => 'images/practice/1528_ewaste_metal_recovery.svg', 'alt' => 'Electronic Waste Metal Recovery Steps', 'title' => 'the steps involved in recovering metal from electronic waste', 'type' => 'process diagram'],
            1529 => ['path' => 'images/practice/1529_paper_pulp_production.svg', 'alt' => 'Paper Pulp Production from Wood Chips', 'title' => 'the production of paper pulp from wood chips', 'type' => 'process diagram'],
            1530 => ['path' => 'images/practice/1530_microchip_fabrication.svg', 'alt' => 'Microchip Semiconductor Fabrication Flow', 'title' => 'the fabrication flow of a microchip semiconductor', 'type' => 'process diagram'],
            1531 => ['path' => 'images/practice/1531_apple_juice_production.svg', 'alt' => 'Apple Juice Production and Bottling Steps', 'title' => 'the production and bottling steps of apple juice', 'type' => 'process diagram'],
            1532 => ['path' => 'images/practice/1532_industrial_oxygen_separation.svg', 'alt' => 'Industrial Oxygen Gas Separation Process', 'title' => 'the industrial process of oxygen gas separation', 'type' => 'process diagram'],
            1533 => ['path' => 'images/practice/1533_automobile_assembly.svg', 'alt' => 'Automobile Assembly Line Flowchart', 'title' => 'the stages of an automobile assembly line', 'type' => 'process diagram'],
            1534 => ['path' => 'images/practice/1534_drinking_water_bottling.svg', 'alt' => 'Drinking Water Bottling Operations', 'title' => 'the operations involved in bottling drinking water', 'type' => 'process diagram'],
            1536 => ['path' => 'images/practice/1536_cardboard_box_packaging.svg', 'alt' => 'Cardboard Box Packaging Manufacture', 'title' => 'the manufacture of cardboard box packaging', 'type' => 'process diagram'],
            1537 => ['path' => 'images/practice/1537_biomedical_waste_sterilisation.svg', 'alt' => 'Biomedical Waste Sterilisation Flow', 'title' => 'the sterilisation flow of biomedical waste', 'type' => 'process diagram'],
            1541 => ['path' => 'images/practice/1541_greywater_treatment.svg', 'alt' => 'Soapy Water Greywater Treatment Cycle', 'title' => 'the greywater treatment cycle for soapy water', 'type' => 'process diagram'],
            1544 => ['path' => 'images/practice/1544_textile_dyeing.svg', 'alt' => 'Textile Dyeing & Treatment Stages', 'title' => 'the dyeing and treatment stages of textiles', 'type' => 'process diagram'],
            1547 => ['path' => 'images/practice/1547_used_motor_oil_rerefining.svg', 'alt' => 'Used Motor Oil Re-Refining Process', 'title' => 'the process of re-refining used motor oil', 'type' => 'process diagram'],
            1548 => ['path' => 'images/practice/1548_vegetable_oil_refining.svg', 'alt' => 'Vegetable Oil Refining Flowchart', 'title' => 'the vegetable oil refining process', 'type' => 'process diagram'],
        ];
    }

    private static function resolveFlowchart(int $meetingNumber): array
    {
        // 1110-1129 and 1500-1549 each have their own distinct topics, so both
        // ranges are keyed directly by meeting_number (no shared/offset keys).
        $entry = self::flowchartImages()[$meetingNumber] ?? null;

        if (!$entry) {
            return ['kind' => 'flowchart', 'imageUrl' => null, 'alt' => null, 'instructionTitle' => null, 'instructionType' => null];
        }

        $path = public_path($entry['path']);

        return [
            'kind' => 'flowchart',
            'imageUrl' => asset($entry['path']) . '?v=' . (file_exists($path) ? filemtime($path) : '1'),
            'localPath' => $path,
            'alt' => $entry['alt'],
            'instructionTitle' => $entry['title'],
            'instructionType' => $entry['type'],
        ];
    }

    private static function mapImages(): array
    {
        return [
            1130 => ['path' => 'images/practice/paradise_island.png', 'title' => 'Paradise Island in the past and at present', 'type' => 'maps'],
            1131 => ['path' => 'images/practice/happy_valley_shopping_center.png', 'title' => 'Happy Valley Shopping Center in 1982 and 2012', 'type' => 'maps'],
            1132 => ['path' => 'images/practice/felixstone.png', 'title' => 'Felixstone in 1967 and 2001', 'type' => 'maps'],
            1133 => ['path' => 'images/practice/seaville.png', 'title' => 'the coastal village of Seaville in 1980 and 2010', 'type' => 'diagrams'],
            1134 => ['path' => 'images/practice/islip_town_centre.png', 'title' => 'the centre of a small town called Islip as it is now, and plans for its development', 'type' => 'maps'],
            1135 => ['path' => 'images/practice/ryemouth_village.png', 'title' => 'the development of the village of Ryemouth between 1995 and present', 'type' => 'maps'],
            1136 => ['path' => 'images/practice/science_park.png', 'title' => 'a science park in 2008 and the same park today', 'type' => 'maps'],
            1137 => ['path' => 'images/practice/meadowside_fonton.png', 'title' => 'the changes that have taken place in Meadowside village and Fonton, a neighbouring town, since 1962', 'type' => 'maps'],
            1138 => ['path' => 'images/practice/university_sports_centre.png', 'title' => 'the layout of a university sports centre now, and how it will look after redevelopment', 'type' => 'maps'],
            1139 => ['path' => 'images/practice/beachfront_area.png', 'title' => 'a beachfront area in Australia in 1950 and today', 'type' => 'maps'],
            1600 => ['path' => 'images/practice/1600_island_resort.svg', 'title' => 'island resort infrastructure development, before and after', 'type' => 'maps'],
            1601 => ['path' => 'images/practice/1601_city_pedestrianization.svg', 'title' => 'a city center pedestrianization plan, before and after', 'type' => 'maps'],
            1602 => ['path' => 'images/practice/1602_university_campus.svg', 'title' => 'a university campus layout transformation, before and after', 'type' => 'maps'],
            1603 => ['path' => 'images/practice/1603_coastal_flood_defense.svg', 'title' => 'a coastal village flood defense redevelopment, before and after', 'type' => 'maps'],
            1604 => ['path' => 'images/practice/1604_shopping_center_expansion.svg', 'title' => 'a suburban shopping center expansion, before and after', 'type' => 'maps'],
            1605 => ['path' => 'images/practice/1605_park_recreation_redesign.svg', 'title' => 'a public park and recreation zone redesign, before and after', 'type' => 'maps'],
            1606 => ['path' => 'images/practice/1606_airport_expansion.svg', 'title' => 'an airport terminal and runway expansion, before and after', 'type' => 'maps'],
            1607 => ['path' => 'images/practice/1607_harbor_waterfront_renovation.svg', 'title' => 'a harbor district waterfront renovation, before and after', 'type' => 'maps'],
            1608 => ['path' => 'images/practice/1608_industrial_eco_conversion.svg', 'title' => 'an industrial park eco-zone conversion, before and after', 'type' => 'maps'],
            1609 => ['path' => 'images/practice/1609_market_square_modernization.svg', 'title' => 'a town market square modernization, before and after', 'type' => 'maps'],
            1610 => ['path' => 'images/practice/1610_hospital_expansion.svg', 'title' => 'a hospital complex expansion plan, before and after', 'type' => 'maps'],
            1611 => ['path' => 'images/practice/1611_school_facility_upgrades.svg', 'title' => 'high school campus facility upgrades, before and after', 'type' => 'maps'],
            1612 => ['path' => 'images/practice/1612_railway_precinct_redevelopment.svg', 'title' => 'a railway station precinct redevelopment, before and after', 'type' => 'maps'],
            1613 => ['path' => 'images/practice/1613_riverside_promenade_extension.svg', 'title' => 'a riverside promenade and park extension, before and after', 'type' => 'maps'],
            1614 => ['path' => 'images/practice/1614_residential_urban_renewal.svg', 'title' => 'a residential neighborhood urban renewal, before and after', 'type' => 'maps'],
            1615 => ['path' => 'images/practice/1615_sports_complex_upgrade.svg', 'title' => 'a sports complex infrastructure upgrade, before and after', 'type' => 'maps'],
            1616 => ['path' => 'images/practice/1616_business_park_layout_changes.svg', 'title' => 'commercial business park layout changes, before and after', 'type' => 'maps'],
            1617 => ['path' => 'images/practice/1617_heritage_trail_plan.svg', 'title' => 'a historic old town heritage trail plan, before and after', 'type' => 'maps'],
            1618 => ['path' => 'images/practice/1618_zoo_modernization.svg', 'title' => 'a metropolitan zoo facility modernization, before and after', 'type' => 'maps'],
            1619 => ['path' => 'images/practice/1619_brt_corridor.svg', 'title' => 'a bus rapid transit corridor, before and after', 'type' => 'maps'],
            1620 => ['path' => 'images/practice/1620_port_container_terminal.svg', 'title' => 'port container terminal infrastructure development, before and after', 'type' => 'maps'],
            1621 => ['path' => 'images/practice/1621_botanical_garden_layout.svg', 'title' => 'botanical garden landscaping layout, before and after', 'type' => 'maps'],
            1622 => ['path' => 'images/practice/1622_housing_estate_development.svg', 'title' => 'a suburban housing estate development plan, before and after', 'type' => 'maps'],
            1623 => ['path' => 'images/practice/1623_library_cultural_center.svg', 'title' => 'a city library and cultural center site, before and after', 'type' => 'maps'],
            1624 => ['path' => 'images/practice/1624_beachfront_resort_expansion.svg', 'title' => 'a beachfront promenade and resort expansion, before and after', 'type' => 'maps'],
            1625 => ['path' => 'images/practice/1625_farming_agricultural_zone.svg', 'title' => 'a farming village agricultural zone plan, before and after', 'type' => 'maps'],
            1626 => ['path' => 'images/practice/1626_tech_innovation_park.svg', 'title' => 'a tech innovation park development layout, before and after', 'type' => 'maps'],
            1627 => ['path' => 'images/practice/1627_wetland_conservation_zone.svg', 'title' => 'a river basin wetland conservation zone, before and after', 'type' => 'maps'],
            1628 => ['path' => 'images/practice/1628_science_park_master_plan.svg', 'title' => 'a university science park master plan, before and after', 'type' => 'maps'],
            1629 => ['path' => 'images/practice/1629_traffic_bypass_layout.svg', 'title' => 'a town center traffic bypass route layout, before and after', 'type' => 'maps'],
            1630 => ['path' => 'images/practice/1630_civic_plaza_community_center.svg', 'title' => 'a civic plaza and community center, before and after', 'type' => 'maps'],
            1631 => ['path' => 'images/practice/1631_ski_infrastructure_plan.svg', 'title' => 'a mountain resort ski infrastructure plan, before and after', 'type' => 'maps'],
            1632 => ['path' => 'images/practice/1632_marina_yacht_club_expansion.svg', 'title' => 'a coastal marina and yacht club expansion, before and after', 'type' => 'maps'],
            1633 => ['path' => 'images/practice/1633_urban_forest_reserve.svg', 'title' => 'an urban forest recreation reserve, before and after', 'type' => 'maps'],
            1634 => ['path' => 'images/practice/1634_railway_goods_yard_conversion.svg', 'title' => 'a railway station goods yard conversion, before and after', 'type' => 'maps'],
            1635 => ['path' => 'images/practice/1635_solar_farm_development.svg', 'title' => 'a solar energy farm site development, before and after', 'type' => 'maps'],
            1636 => ['path' => 'images/practice/1636_historical_fort_tourist_facility.svg', 'title' => 'a historical fort tourist facility, before and after', 'type' => 'maps'],
            1637 => ['path' => 'images/practice/1637_railway_line_extension.svg', 'title' => 'a suburban railway line extension route, before and after', 'type' => 'maps'],
            1638 => ['path' => 'images/practice/1638_arts_district_pedestrian_zone.svg', 'title' => 'a city arts district pedestrian zone, before and after', 'type' => 'maps'],
            1639 => ['path' => 'images/practice/1639_reservoir_catchment_plan.svg', 'title' => 'a water reservoir and catchment area plan, before and after', 'type' => 'maps'],
            1640 => ['path' => 'images/practice/1640_port_reclamation_site.svg', 'title' => 'an industrial port reclamation site plan, before and after', 'type' => 'maps'],
            1641 => ['path' => 'images/practice/1641_fairgrounds_redevelopment.svg', 'title' => 'a metropolitan fairgrounds redevelopment, before and after', 'type' => 'maps'],
            1642 => ['path' => 'images/practice/1642_school_sports_field_masterplan.svg', 'title' => 'a secondary school sports field masterplan, before and after', 'type' => 'maps'],
            1643 => ['path' => 'images/practice/1643_riverside_commercial_hub.svg', 'title' => 'a riverside commercial hub layout plan, before and after', 'type' => 'maps'],
            1644 => ['path' => 'images/practice/1644_nature_reserve_trail_system.svg', 'title' => 'a highland nature reserve trail system, before and after', 'type' => 'maps'],
            1645 => ['path' => 'images/practice/1645_green_belt_expansion.svg', 'title' => 'an urban green belt expansion layout, before and after', 'type' => 'maps'],
            1646 => ['path' => 'images/practice/1646_deepwater_port_logistics.svg', 'title' => 'a deepwater port logistics hub masterplan, before and after', 'type' => 'maps'],
            1647 => ['path' => 'images/practice/1647_landfill_rehabilitation.svg', 'title' => 'a municipal landfill site rehabilitation plan, before and after', 'type' => 'maps'],
            1648 => ['path' => 'images/practice/1648_canal_towpath_redesign.svg', 'title' => 'a historic canal towpath and park redesign, before and after', 'type' => 'maps'],
            1649 => ['path' => 'images/practice/1649_retail_hub_map.svg', 'title' => 'a suburban commercial retail hub, before and after', 'type' => 'maps'],
        ];
    }

    private static function resolveMap(int $meetingNumber, ?string $meetingImage): array
    {
        if ($meetingImage) {
            $mPath = public_path($meetingImage);
            return [
                'kind' => 'map',
                'imageUrl' => asset($meetingImage) . '?v=' . (file_exists($mPath) ? filemtime($mPath) : time()),
                'localPath' => $mPath,
                'instructionTitle' => null,
                'instructionType' => null,
            ];
        }

        $entry = self::mapImages()[$meetingNumber] ?? null;

        if (!$entry) {
            return ['kind' => 'map', 'imageUrl' => null, 'localPath' => null, 'instructionTitle' => null, 'instructionType' => null];
        }

        $base = preg_replace('/\.(svg|png|jpg|jpeg)$/', '', $entry['path']);
        $actualPath = $entry['path'];
        foreach (['.png', '.jpg', '.jpeg', '.svg'] as $ext) {
            if (file_exists(public_path($base . $ext))) {
                $actualPath = $base . $ext;
                break;
            }
        }

        $loc = public_path($actualPath);
        $v = file_exists($loc) ? filemtime($loc) : time();

        return [
            'kind' => 'map',
            'imageUrl' => asset($actualPath) . '?v=' . $v,
            'localPath' => $loc,
            'instructionTitle' => $entry['title'],
            'instructionType' => $entry['type'],
        ];
    }
}
