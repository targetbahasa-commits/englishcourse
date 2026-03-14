<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IeltsWritingMeeting;

class IeltsWritingPracticeItemsSeeder extends Seeder
{
    public function run(): void
    {
        // =========================================================
        // Task 1 - PRACTICE ITEMS (20 items per type)
        // =========================================================

        $practiceItems = [];

        // LINE CHART PRACTICES (1010-1029) - 20 items
        $lineCharts = [
            1010 => ['Website Traffic Over Time', 'Analyse the line graph showing website traffic trends over a 6-month period.'],
            1011 => ['Car Sales Market Share (%)', 'Describe the trends in car sales market share between electric and petrol vehicles.'],
            1012 => ['Book Sales', 'Summarise the changes in digital versus physical book sales over a 20-year period.'],
            1013 => ['Daily Consumption (Cups per Person)', 'Compare the consumption trends of coffee, tea, and water over time.'],
            1014 => ['Population Growth (Millions)', 'Analyse the population growth trends for urban, rural, and suburban areas.'],
            1015 => ['Internet Users (% of Population)', 'Describe the differences in internet adoption between developed and developing countries.'],
            1016 => ['Global Temperature Anomaly (°C)', 'Summarise the temperature trends for land and ocean surfaces over 40 years.'],
            1017 => ['Weekly Fast Food Consumption (Times)', 'Compare the consumption patterns of pizza, burgers, and salads over time.'],
            1018 => ['Smartphone Ownership by Age Group (%)', 'Analyse the smartphone adoption rates across different age groups.'],
            1019 => ['Average Precious Metal Prices (USD per oz)', 'Describe the price trends for gold, silver, platinum, and palladium.'],
            1020 => ['Radio and Television Audiences (UK Oct–Dec 1992)', 'Compare the percentage of UK population over 4 years old listening to radio and watching television at different times of the day and night.'],
            1021 => ['Channel One News Viewing Figures', 'Describe the variation in millions of viewers per day for Channel One news at four different times (1pm, 6pm, 9:30pm and 11pm) throughout the year.'],
            1022 => ['Tourist Attractions in Scotland', 'Analyse the percentage of tourists visiting different attractions (Aquarium, Castle, Zoo, Festival) over a period of years.'],
            1023 => ['Daily Energy Consumption Fluctuations', 'Summarise the changes in energy consumption by different sectors over a 24‑hour period.'],
            1024 => ['Internet Usage by Age Group', 'Compare the internet usage patterns of various age groups during different times of the day.'],
            1025 => ['Temperature Variations Over a Week', 'Describe how temperature readings varied at different times of day over a seven‑day period.'],
            1026 => ['Stock Market Index Changes', 'Analysize the fluctuations of a stock market index at hourly intervals during trading days.'],
            1027 => ['Water Usage Throughout the Day', 'Compare domestic water usage in litres at different hours of the day.'],
            1028 => ['Flight Departures by Time of Day', 'Summarise the number of domestic flights departing from an airport during each hour of operation.'],
            1029 => ['Retail Store Footfall', 'Describe how customer footfall in a retail store varies at different times over a 12‑hour period.'],
        ];

        foreach ($lineCharts as $num => $data) {
            $practiceItems[] = [
                'task_type' => 1,
                'meeting_number' => $num,
                'category' => 'practice_item',
                'title' => $data[0],
                'prompt' => $data[1],
                'view_type' => 'writing_practice',
            ];
        }

        // BAR CHART PRACTICES (1030-1049) - 20 items
        $barCharts = [
            1030 => ['Trade Volume (Billion USD)', 'Describe the export and import volumes for five major trading countries.'],
            1031 => ['Graduate Employment Rates by Field (%)', 'Compare employment rates for graduates across different fields between 2010 and 2020.'],
            1032 => ['Annual Tourist Arrivals (Millions)', 'Summarise the tourist arrival statistics for top tourism destinations.'],
            1033 => ['Average Daily Screen Time (Hours)', 'Analyse the mobile and desktop screen time usage across age groups.'],
            1034 => ['Renewable Energy Capacity (GW)', 'Describe the growth of renewable energy sources including wind, solar, and hydro power.'],
            1035 => ['Average Hourly Earnings ($)', 'Compare the gender pay gap across different industries.'],
            1036 => ['Weekly Household Waste (kg)', 'Summarise the breakdown of household waste disposal by type and method.'],
            1037 => ['Commuting Method to Work (%)', 'Analyse the transportation preferences for commuting across different cities.'],
            1038 => ['Housing Preferences by Age Group (%)', 'Describe the housing type preferences for young adults, families, and retirees.'],
            1039 => ['Olympic Medals Won (Top 5 Countries)', 'Compare the Olympic medal distribution across top-performing countries.'],
            1040 => ['Manufacturing Output by Country', 'Describe manufacturing output levels for different countries across various years.'],
            1041 => ['Retail Sales by Category', 'Analyse retail sales trends across different product categories.'],
            1042 => ['Annual Coffee Consumption (kg per capita)', 'Compare coffee consumption patterns across different countries.'],
            1043 => ['Internet Connectivity Speed by Region', 'Summarise average internet speeds across different geographical regions.'],
            1044 => ['Public Transportation Usage Trends', 'Describe public transportation usage across different types of services.'],
            1045 => ['Movie Box Office Revenue by Genre', 'Analyse box office earnings for different genres of films.'],
            1046 => ['Average Life Expectancy by Country', 'Compare life expectancy trends across developed and developing nations.'],
            1047 => ['Fast Food Restaurant Growth', 'Describe the expansion of various fast food chains across regions.'],
            1048 => ['University Funding by Department (%)', 'Analyse budget allocation and funding distribution across university departments.'],
            1049 => ['Vehicle Ownership Across Age Groups', 'Compare vehicle ownership rates and vehicle types preferred by different age groups.'],
        ];

        foreach ($barCharts as $num => $data) {
            $practiceItems[] = [
                'task_type' => 1,
                'meeting_number' => $num,
                'category' => 'practice_item',
                'title' => $data[0],
                'prompt' => $data[1],
                'view_type' => 'writing_practice',
            ];
        }

        // PIE CHART PRACTICES (1050-1069) - 20 items
        $pieCharts = [
            1050 => ['Average Household Spending', 'Describe how an average household budget is distributed across different expense categories.'],
            1051 => ['Global Energy Consumption by Source', 'Summarise the proportion of global energy consumption from different sources.'],
            1052 => ['Average Daily Calorie Intake', 'Analyse the breakdown of daily calorie intake by food groups.'],
            1053 => ['Time Allocation in a Typical Day', 'Describe how time is distributed across work, sleep, leisure, and other activities.'],
            1054 => ['Market Share in Tech Industry', 'Summarise the market share distribution among major technology companies.'],
            1055 => ['Causes of Workplace Absenteeism', 'Analyse the proportion of workplace absences attributed to various causes.'],
            1056 => ['Waste Composition in Landfills', 'Describe the breakdown of different types of waste in landfill sites.'],
            1057 => ['Source of Information for News Media', 'Summarise how people obtain news from different information sources.'],
            1058 => ['Water Usage by Sector', 'Analyse the proportion of water consumption across agriculture, industry, and household sectors.'],
            1059 => ['Distribution of Students by Faculty', 'Describe the enrollment distribution across different university faculties.'],
            1060 => ['Global Population Distribution by Continent', 'Analyse the proportion of world population distributed across continents.'],
            1061 => ['Annual Budget Allocation by Sector', 'Describe how government budget is allocated to different sectors.'],
            1062 => ['Website Traffic Sources', 'Summarise the distribution of website traffic from different sources.'],
            1063 => ['University Student Demographics', 'Analyse the breakdown of student population by nationality and program type.'],
            1064 => ['Smartphone Operating System Market Share', 'Describe the market share distribution of different smartphone operating systems.'],
            1065 => ['Restaurant Cuisine Type Distribution', 'Compare the proportion of different cuisine types available in a city.'],
            1066 => ['Annual Spending by Household Category', 'Analyse household spending distribution across entertainment, health, and education.'],
            1067 => ['Forest Area by Usage Type', 'Describe the distribution of forest areas for different purposes.'],
            1068 => ['Hospital Patient Care Distribution', 'Summarise the proportion of patients across different hospital departments.'],
            1069 => ['Vehicle Insurance Claims by Type', 'Analyse the breakdown of insurance claims by type of accident or damage.'],
        ];

        foreach ($pieCharts as $num => $data) {
            $practiceItems[] = [
                'task_type' => 1,
                'meeting_number' => $num,
                'category' => 'practice_item',
                'title' => $data[0],
                'prompt' => $data[1],
                'view_type' => 'writing_practice',
            ];
        }

        // TABLE PRACTICES (1070-1089) - 20 items
        $tables = [
            1070 => ['Population Statistics', 'Summarise the population data across different countries and regions.'],
            1071 => ['Annual Revenue by Sector', 'Analyse the revenue figures for different industrial sectors over multiple years.'],
            1072 => ['Nutritional Content of Foods', 'Describe the nutritional values and macronutrient breakdown of various food items.'],
            1073 => ['Travel Destinations', 'Compare the cost, visitor numbers, and ratings for popular travel destinations.'],
            1074 => ['Internet Speeds by Country', 'Summarise the average internet speeds and global rankings for selected countries.'],
            1075 => ['Top Tech Companies', 'Analyse the market capitalisation, headquarters, founding dates, and employee counts of major tech companies.'],
            1076 => ['Weather and Climate Data', 'Describe monthly temperature, rainfall, and humidity patterns for a selected location.'],
            1077 => ['Vehicle Sales Data', 'Compare sales figures and trends for different vehicle types.'],
            1078 => ['Coffee Production Statistics', 'Summarise global coffee production, market share, and export data by country.'],
            1079 => ['Smartphone Technical Specifications', 'Analyse and compare technical specifications of leading smartphone models.'],
            1080 => ['Hotel Amenities and Ratings', 'Compare available amenities and guest ratings across different hotel chains.'],
            1081 => ['Student Test Scores by Subject', 'Describe average test scores and performance metrics by academic subject.'],
            1082 => ['Annual Rainfall and Precipitation', 'Summarise precipitation patterns across different months and regions.'],
            1083 => ['E-commerce Sales Performance', 'Analyse sales data, profit margins, and growth rates for online retailers.'],
            1084 => ['University Degree Statistics', 'Compare graduation rates, degree types, and employment outcomes.'],
            1085 => ['Air Quality Measurements', 'Describe air pollution indices and emission levels by pollutant type.'],
            1086 => ['Airline Flight Statistics', 'Analyse passenger numbers, revenue, and route information across airlines.'],
            1087 => ['Healthcare Cost Analysis', 'Compare healthcare expenditure across different regions and service types.'],
            1088 => ['Publishing Industry Data', 'Summarise book sales, author earnings, and publication trends by genre.'],
            1089 => ['Renewable Energy Investment', 'Analyse capital investment and energy generation capacity for renewable sources.'],
        ];

        foreach ($tables as $num => $data) {
            $practiceItems[] = [
                'task_type' => 1,
                'meeting_number' => $num,
                'category' => 'practice_item',
                'title' => $data[0],
                'prompt' => $data[1],
                'view_type' => 'writing_practice',
            ];
        }

        // MIXED CHARTS PRACTICES (1090-1109) - 20 items
        $mixed = [
            1090 => ['Multiple Chart Types - Energy Data', 'Analyse the combination of pie and bar charts showing energy production and consumption.'],
            1091 => ['Mixed Data - Population and Healthcare', 'Describe the relationship between population statistics and healthcare resource allocation.'],
            1092 => ['Combined Charts - Economic Indicators', 'Summarise the combined line and bar chart data on economic indicators.'],
            1093 => ['Multiple Visualizations - Education Stats', 'Analyse the multiple chart representations of education-related statistics.'],
            1094 => ['Mixed Format - Transportation Data', 'Compare data presented in both chart and table format for transportation trends.'],
            1095 => ['Combined Analysis - Environmental Data', 'Describe the environmental data presented across multiple chart formats.'],
            1096 => ['Multi-Chart Comparison - Technology Usage', 'Analyse technology usage data shown across different visualization types.'],
            1097 => ['Mixed Presentation - Sports Statistics', 'Summarise sports-related data presented in mixed chart formats.'],
            1098 => ['Combined Charts - Healthcare Trends', 'Compare healthcare statistics presented as both charts and tables.'],
            1099 => ['Multiple Format - Retail and Commerce', 'Describe retail and commerce data across multiple chart representations.'],
            1100 => ['Dual Axis Charts - Financial Data', 'Analyse financial performance using dual-axis visualization combining revenue and growth rate.'],
            1101 => ['Stacked Comparison - Market Analysis', 'Compare market segments using stacked data representations alongside trend lines.'],
            1102 => ['Combined Infographic - Tourism', 'Describe tourism information presented through combined charts and geographical data.'],
            1103 => ['Multiple Metrics - Manufacturing', 'Analyse production output through multiple correlated data visualizations.'],
            1104 => ['Mixed Visual - Climate Change', 'Summarise climate data combining temperature trends, CO2 levels, and regional impacts.'],
            1105 => ['Comparative Charts - Consumer Behavior', 'Describe consumer purchasing patterns across different product categories and demographics.'],
            1106 => ['Integrated Data - Real Estate', 'Analyse real estate market data combining price trends, supply levels, and demographic factors.'],
            1107 => ['Overlay Charts - Weather Patterns', 'Compare weather phenomena using overlaid precipitation, temperature, and wind data.'],
            1108 => ['Complex Analysis - Global Trade', 'Describe international trade relationships using multiple chart types and data formats.'],
            1109 => ['Synthesized Charts - Public Health', 'Analyse public health indicators combining disease prevalence, vaccination rates, and mortality data.'],
        ];

        foreach ($mixed as $num => $data) {
            $practiceItems[] = [
                'task_type' => 1,
                'meeting_number' => $num,
                'category' => 'practice_item',
                'title' => $data[0],
                'prompt' => $data[1],
                'view_type' => 'writing_practice',
            ];
        }

        // PROCESS DIAGRAM / FLOWCHART PRACTICES (1110-1129) - 20 items
        $flowcharts = [
            1110 => ['Cement and Concrete Production Process', 'Describe the stages and equipment used in the cement-making process, and how cement is used to produce concrete for building purposes.'],
            1111 => ['Coconut Oil Manufacturing Process', 'Summarise the mass manufacturing process of coconut oil from raw coconuts.'],
            1112 => ['Glass Container Production Process', 'Explain how glass containers are made. The steps of the process are numbered 1 to 9.'],
            1113 => ['Sheep Embryo Cloning Process', 'Describe the process by which sheep embryos are cloned in scientific laboratories.'],
            1114 => ['Water Treatment Process', 'Summarise the process of water treatment from raw source to distribution.'],
            1115 => ['Hydroelectric Power Generation Process', 'Describe the process by which electricity is generated in two types of hydroelectric power stations.'],
            1116 => ['Life Cycle of a Frog', 'Explain the biological life cycle of a frog from eggs to adult.'],
            1117 => ['Life Cycle of the Silkworm and Silk Production', 'Describe the life cycle of the silkworm and the stages in the production of silk cloth.'],
            1118 => ['Water Cycle', 'Summarise the water cycle, which is the continuous movement of water on, above and below the surface of the Earth.'],
            1119 => ['Milk Production Process', 'Explain the process by which milk and related dairy products are produced.'],
            1120 => ['Paper Manufacturing Process', 'Describe the complete process from raw wood to finished paper product.'],
            1121 => ['Petroleum Refining Process', 'Summarise how crude oil is processed into various fuel and chemical products.'],
            1122 => ['Pharmaceutical Drug Manufacturing', 'Analyse the steps involved in producing medicines from raw materials.'],
            1123 => ['Beer Production Process', 'Describe the brewing and fermentation stages in beer production.'],
            1124 => ['Wine Making Process', 'Summarise the stages from grape harvest to bottled wine.'],
            1125 => ['Bread Baking Industrial Process', 'Explain the mechanized process of producing bread on a large scale.'],
            1126 => ['Steel Manufacturing Process', 'Describe how iron ore is processed into steel.'],
            1127 => ['Recycling Process for Plastics', 'Analyse the steps in plastic waste collection and reprocessing.'],
            1128 => ['Nuclear Power Generation', 'Summarise the process of electricity generation in nuclear power plants.'],
            1129 => ['Aluminum Can Production', 'Describe the manufacturing process from bauxite ore to finished aluminum cans.'],
        ];

        foreach ($flowcharts as $num => $data) {
            $practiceItems[] = [
                'task_type' => 1,
                'meeting_number' => $num,
                'category' => 'practice_item',
                'title' => $data[0],
                'prompt' => $data[1],
                'view_type' => 'writing_practice',
            ];
        }

        // MAP DIAGRAM PRACTICES (1130-1149) - 20 items
        $maps = [
            1130 => ['Paradise Island Maps', 'Compare the layout of Paradise Island in the past and at present.'],
            1131 => ['Happy Valley Shopping Center Maps', 'Describe the changes to Happy Valley Shopping Center between 1982 and 2012.'],
            1132 => ['Felixstone Maps', 'Summarise the development of Felixstone from 1967 to 2001.'],
            1133 => ['Seaville Village Maps', 'Compare the coastal village of Seaville in 1980 and 2010.'],
            1134 => ['Islip Town Centre', 'Analyse the centre of a small town called Islip as it is now, and plans for its future development.'],
            1135 => ['Ryemouth Village Development', 'Describe the development of the village of Ryemouth between 1995 and the present day.'],
            1136 => ['Science Park Maps', 'Compare a science park in 2008 and the same park today, describing the changes.'],
            1137 => ['Meadowside and Fonton Maps', 'Analyse the changes that have taken place in Meadowside village and Fonton, a neighbouring town, since 1962.'],
            1138 => ['University Sports Centre Layout', 'Describe the layout of a university sports centre now, and how it will look after redevelopment.'],
            1139 => ['Beachfront Area Development', 'Compare a beachfront area in Australia in 1950 and today, highlighting the changes.'],
            1140 => ['Downtown Business District', 'Describe the urban development and infrastructure changes in a downtown business area.'],
            1141 => ['Coastal Resort Development', 'Compare the layout of a coastal resort showing expansion and new facilities.'],
            1142 => ['Industrial Park Layout Changes', 'Analyse the transformation of an industrial park over time.'],
            1143 => ['Residential Quarter Development', 'Describe the residential area changes including new housing and amenities.'],
            1144 => ['University Campus Expansion', 'Summarise the campus layout showing new buildings and infrastructure improvements.'],
            1145 => ['City Park Redesign', 'Compare a public park layout showing recreational area modifications.'],
            1146 => ['Airport Terminal Expansion', 'Describe airport infrastructure development and terminal layout changes.'],
            1147 => ['Shopping Mall Interior Layout', 'Analyse the floor plan and tenant distribution in a modern shopping complex.'],
            1148 => ['Agricultural Land Use Changes', 'Compare rural area maps showing changes in land usage patterns.'],
            1149 => ['Port Development Timeline', 'Describe the expansion and modernization of a commercial port facility.'],
        ];

        foreach ($maps as $num => $data) {
            $practiceItems[] = [
                'task_type' => 1,
                'meeting_number' => $num,
                'category' => 'practice_item',
                'title' => $data[0],
                'prompt' => $data[1],
                'view_type' => 'writing_practice',
            ];
        }

        // Upsert all practice items
        foreach ($practiceItems as $item) {
            IeltsWritingMeeting::updateOrCreate(
                [
                    'task_type' => $item['task_type'],
                    'meeting_number' => $item['meeting_number'],
                    'category' => 'practice_item',
                ],
                $item
            );
        }

        $this->command->info('✅ IELTS Writing Practice Items seeded: ' . count($practiceItems) . ' items (20 per type)');
    }
}
