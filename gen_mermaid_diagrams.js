const puppeteer = require('puppeteer');
const fs = require('fs');
const path = require('path');

const OUT_DIR = "public/storage/describe-image";
if (!fs.existsSync(OUT_DIR)) {
    fs.mkdirSync(OUT_DIR, { recursive: true });
}

const diagrams = {
    // Sciences
    169: { title: "Soil Formation Process", code: `graph TD; A[Bedrock] --> B[Weathering of Rock]; B --> C[Organic Matter Accumulates]; C --> D[Topsoil Formation]; D --> E[Mature Soil Profile]; classDef def fill:#e67e22,stroke:#d35400,stroke-width:2px,color:white; class A,B,C,D,E def;` },
    266: { title: "Nitrogen Cycle", code: `graph TD; A[Atmospheric Nitrogen N2] --> B[Nitrogen Fixation by Bacteria]; B --> C[Ammonification]; C --> D[Nitrification to Nitrates]; D --> E[Assimilation by Plants]; D --> F[Denitrification back to Atmosphere]; E --> G[Animals Eat Plants]; G --> C; classDef def fill:#2ecc71,stroke:#27ae60,stroke-width:2px,color:white; class A,B,C,D,E,F,G def;` },
    295: { title: "Water Cycle", code: `graph TD; A[Ocean/Water Bodies] --> B[Evaporation]; C[Trees/Plants] --> D[Transpiration]; B --> E[Condensation in Clouds]; D --> E; E --> F[Precipitation]; F --> G[Surface Runoff]; F --> H[Groundwater Infiltration]; G --> A; H --> A; classDef def fill:#3498db,stroke:#2980b9,stroke-width:2px,color:white; class A,B,C,D,E,F,G,H def;` },
    226: { title: "Frog Life Cycle", code: `graph LR; A[Eggs/Spawn] --> B[Tadpole]; B --> C[Tadpole with Legs]; C --> D[Froglet]; D --> E[Adult Frog]; E --> A; classDef def fill:#1abc9c,stroke:#16a085,stroke-width:2px,color:white; class A,B,C,D,E def;` },
    109: { title: "Ladybug Life Cycle", code: `graph LR; A[Eggs] --> B[Larva]; B --> C[Pupa]; C --> D[Adult Ladybug]; D --> A; classDef def fill:#e74c3c,stroke:#c0392b,stroke-width:2px,color:white; class A,B,C,D def;` },
    131: { title: "Chicken Life Cycle", code: `graph LR; A[Egg] --> B[Embryo Growth]; B --> C[Hatching]; C --> D[Chick]; D --> E[Adult Chicken]; E --> A; classDef def fill:#f1c40f,stroke:#f39c12,stroke-width:2px,color:white; class A,B,C,D,E def;` },
    140: { title: "Honey Bee Life Cycle", code: `graph LR; A[Egg] --> B[Larva]; B --> C[Pupa]; C --> D[Adult Bee]; D --> A; classDef def fill:#f39c12,stroke:#d35400,stroke-width:2px,color:white; class A,B,C,D def;` },
    202: { title: "Butterfly Metamorphosis", code: `graph LR; A[Egg] --> B[Caterpillar/Larva]; B --> C[Chrysalis/Pupa]; C --> D[Adult Butterfly]; D --> A; classDef def fill:#9b59b6,stroke:#8e44ad,stroke-width:2px,color:white; class A,B,C,D def;` },
    224: { title: "Sea Turtle Life Cycle", code: `graph LR; A[Eggs in Sand] --> B[Hatchlings]; B --> C[Journey to Ocean]; C --> D[Juvenile Turtle]; D --> E[Adult Turtle]; E --> A; classDef def fill:#34495e,stroke:#2c3e50,stroke-width:2px,color:white; class A,B,C,D,E def;` },
    236: { title: "Sunflower Life Cycle", code: `graph LR; A[Seed] --> B[Germination]; B --> C[Sprout]; C --> D[Vegetative Growth]; D --> E[Budding & Flowering]; E --> F[Seed Maturation]; F --> A; classDef def fill:#f1c40f,stroke:#f39c12,stroke-width:2px,color:white; class A,B,C,D,E,F def;` },
    249: { title: "Mosquito Life Cycle", code: `graph LR; A[Egg Rafts in Water] --> B[Larva]; B --> C[Pupa]; C --> D[Adult Mosquito]; D --> A; classDef def fill:#7f8c8d,stroke:#95a5a6,stroke-width:2px,color:white; class A,B,C,D def;` },
    296: { title: "Salmon Life Cycle", code: `graph LR; A[Eggs/Alevin] --> B[Fry/Parr in River]; B --> C[Smolt Estuary]; C --> D[Adult Ocean]; D --> E[Spawning in River]; E --> A; classDef def fill:#e67e22,stroke:#d35400,stroke-width:2px,color:white; class A,B,C,D,E def;` },

    // Industry / Process
    123: { title: "Olive Oil Extraction Process", code: `graph TD; A[Harvesting Olives] --> B[Washing & Sorting]; B --> C[Crushing/Milling into Paste]; C --> D[Malaxation/Mixing]; D --> E[Centrifugation Separation]; E --> F[Filtration]; F --> G[Bottling & Storage]; classDef def fill:#8e44ad,stroke:#9b59b6,stroke-width:2px,color:white; class A,B,C,D,E,F,G def;` },
    201: { title: "Glass Recycling Process", code: `graph TD; A[Collection & Sorting by Color] --> B[Crushing into Cullet]; B --> C[Cleaning & Contaminant Removal]; C --> D[Melting in Furnace]; D --> E[Molding into New Products]; E --> F[Cooling & Quality Check]; classDef def fill:#1abc9c,stroke:#16a085,stroke-width:2px,color:white; class A,B,C,D,E,F def;` },
    222: { title: "Plastic Recycling Process", code: `graph TD; A[Collection] --> B[Sorting & Baling]; B --> C[Shredding into Flakes]; C --> D[Washing]; D --> E[Melting]; E --> F[Extruding into Pellets]; F --> G[Manufacturing New Products]; classDef def fill:#3498db,stroke:#2980b9,stroke-width:2px,color:white; class A,B,C,D,E,F,G def;` },
    243: { title: "Papermaking Process", code: `graph TD; A[Wood Logs] --> B[Debarking & Chipping]; B --> C[Pulping & Screening]; C --> D[Bleaching]; D --> E[Paper Machine Wet End]; E --> F[Pressing & Drying]; F --> G[Rolling into Paper Rolls]; classDef def fill:#c0392b,stroke:#e74c3c,stroke-width:2px,color:white; class A,B,C,D,E,F,G def;` },
    247: { title: "Coffee Production Process", code: `graph TD; A[Harvesting Cherries] --> B[Processing Wet/Dry]; B --> C[Milling/Hulling]; C --> D[Exporting Green Beans]; D --> E[Roasting]; E --> F[Grinding]; F --> G[Brewing]; classDef def fill:#5d4037,stroke:#3e2723,stroke-width:2px,color:white; class A,B,C,D,E,F,G def;` },
    248: { title: "Aluminum Recycling Process", code: `graph TD; A[Collection] --> B[Sorting & Cleaning]; B --> C[Shredding]; C --> D[Melting in Furnace]; D --> E[Casting into Ingots]; E --> F[Rolling into Sheets]; F --> G[Manufacturing Cans]; classDef def fill:#7f8c8d,stroke:#95a5a6,stroke-width:2px,color:white; class A,B,C,D,E,F,G def;` },

    // Energy / Power
    139: { title: "Electric Power Distribution", code: `graph LR; A[Power Plant] --> B[Step-Up Transformer]; B --> C[High-Voltage Transmission Lines]; C --> D[Substation Step-Down]; D --> E[Distribution Lines]; E --> F[Pole Transformer]; F --> G[Residential Homes]; classDef def fill:#e67e22,stroke:#d35400,stroke-width:2px,color:white; class A,B,C,D,E,F,G def;` },
    145: { title: "Wind Turbine Operation", code: `graph TD; A[Wind Turns Blades] --> B[Rotor Spins]; B --> C[Gearbox Increases Speed]; C --> D[Generator Produces Electricity]; D --> E[Transformer Increases Voltage]; E --> F[Export to Grid]; classDef def fill:#3498db,stroke:#2980b9,stroke-width:2px,color:white; class A,B,C,D,E,F def;` },
    153: { title: "Geothermal Power Station", code: `graph TD; A[Hot Water from Deep Well] --> B[Steam Separator]; B --> C[Steam Drives Turbine]; C --> D[Generator Produces Electricity]; D --> E[Transformer & Power Grid]; C --> F[Condenser cools steam]; F --> G[Injection Well pushes water back]; classDef def fill:#e74c3c,stroke:#c0392b,stroke-width:2px,color:white; class A,B,C,D,E,F,G def;` },
    159: { title: "Thermal Power Station (Coal)", code: `graph TD; A[Coal Boiler] --> B[Water Turns to High-Pressure Steam]; B --> C[Steam Drives Turbine]; C --> D[Generator Produces Electricity]; D --> E[Power Grid]; C --> F[Condenser Cooling]; F --> B; classDef def fill:#2c3e50,stroke:#34495e,stroke-width:2px,color:white; class A,B,C,D,E,F def;` },
    180: { title: "Nuclear Power Plant", code: `graph TD; A[Nuclear Reactor Core Fission] --> B[Coolant Heats Water]; B --> C[Steam Generator]; C --> D[Steam Drives Turbine]; D --> E[Generator Produces Power]; C --> F[Condenser/Cooling Tower]; F --> C; classDef def fill:#f39c12,stroke:#d35400,stroke-width:2px,color:white; class A,B,C,D,E,F def;` },
    196: { title: "Hydroelectric Power Plant", code: `graph TD; A[Reservoir/Dam] --> B[Water Flows through Penstock]; B --> C[Turbine Spins]; C --> D[Generator Produces Electricity]; D --> E[Transformer to Grid]; C --> F[Water Discharged to River]; classDef def fill:#2980b9,stroke:#3498db,stroke-width:2px,color:white; class A,B,C,D,E,F def;` },
    204: { title: "Tidal Power Generation", code: `graph TD; A[High Tide/Low Tide Flow] --> B[Water Enters/Exits Barrage]; B --> C[Turbines Spin]; C --> D[Generator Creates Electricity]; D --> E[Power Exported to Grid]; classDef def fill:#8e44ad,stroke:#9b59b6,stroke-width:2px,color:white; class A,B,C,D,E def;` },
    244: { title: "Photovoltaic System", code: `graph LR; A[Solar Panels/DC] --> B[Charge Controller]; B --> C[Battery Bank]; B --> D[Inverter/AC]; D --> E[Household Appliances]; D --> F[Utility Grid]; classDef def fill:#f1c40f,stroke:#f39c12,stroke-width:2px,color:white; class A,B,C,D,E,F def;` },
    283: { title: "Wave Power Generation", code: `graph LR; A[Ocean Waves] --> B[Wave Energy Converter Device]; B --> C[Mechanical/Hydraulic Motion]; C --> D[Turbine & Generator]; D --> E[Submarine Cable]; E --> F[Power Grid]; classDef def fill:#1abc9c,stroke:#16a085,stroke-width:2px,color:white; class A,B,C,D,E,F def;` },
    288: { title: "Biomass Energy Cycle", code: `graph TD; A[Sunlight + CO2] --> B[Plant Growth Biomass]; B --> C[Harvesting & Processing]; C --> D[Combustion in Boiler]; D --> E[Steam Turbine & Generator]; E --> F[Electricity]; D --> G[CO2 Emission Absorbed by Plants]; classDef def fill:#27ae60,stroke:#2ecc71,stroke-width:2px,color:white; class A,B,C,D,E,F,G def;` },

    // Business
    166: { title: "Airport Passenger Departure", code: `graph TD; A[Arrival at Airport] --> B[Check-In & Baggage Drop]; B --> C[Security Screening]; C --> D[Passport Control/Immigration]; D --> E[Duty-Free & Waiting Lounge]; E --> F[Boarding at Gate]; F --> G[Aircraft Takeoff]; classDef def fill:#34495e,stroke:#2c3e50,stroke-width:2px,color:white; class A,B,C,D,E,F,G def;` },
    188: { title: "Online Food Ordering", code: `graph TD; A[Customer Browses Menu on App] --> B[Adds to Cart & Checkout]; B --> C[Payment Processing]; C --> D[Restaurant Confirms & Prepares Food]; D --> E[Driver Picks Up Order]; E --> F[Delivery to Customer]; classDef def fill:#e74c3c,stroke:#c0392b,stroke-width:2px,color:white; class A,B,C,D,E,F def;` },
    228: { title: "Library Book Borrowing", code: `graph TD; A[Patron Searches Catalog] --> B[Locate Book on Shelf]; B --> C{Has Library Card?}; C -->|No| D[Register for Card]; C -->|Yes| E[Go to Circulation Desk/Kiosk]; D --> E; E --> F[Scan Book & Card]; F --> G[Take Book Home]; classDef def fill:#2c3e50,stroke:#34495e,stroke-width:2px,color:white; class A,B,C,D,E,F,G def;` },
    246: { title: "Customer Complaint Handling", code: `graph TD; A[Receive Complaint] --> B[Log Issue in CRM]; B --> C[Acknowledge Customer]; C --> D[Investigate Root Cause]; D --> E[Resolve Issue]; E --> F[Communicate Resolution]; F --> G[Close Ticket]; classDef def fill:#c0392b,stroke:#e74c3c,stroke-width:2px,color:white; class A,B,C,D,E,F,G def;` },
    264: { title: "Order Fulfillment Process", code: `graph TD; A[Customer Places Order] --> B[Inventory Check]; B --> C[Order Processing]; C --> D[Picking from Warehouse]; D --> E[Packing]; E --> F[Shipping / Courier Pickup]; F --> G[Delivery to Customer]; classDef def fill:#16a085,stroke:#1abc9c,stroke-width:2px,color:white; class A,B,C,D,E,F,G def;` },
    291: { title: "Software Bug Fixing Process", code: `graph TD; A[User Reports Bug] --> B[QA Reproduces Issue]; B --> C[Developer Analyzes Code]; C --> D[Fix Implementation]; D --> E[Code Review]; E --> F[QA Testing]; F -->|Pass| G[Deploy to Production]; F -->|Fail| C; classDef def fill:#8e44ad,stroke:#9b59b6,stroke-width:2px,color:white; class A,B,C,D,E,F,G def;` }
};

(async () => {
    console.log("Starting Mermaid generation...");
    const browser = await puppeteer.launch();
    const page = await browser.newPage();
    await page.setViewport({ width: 1200, height: 800, deviceScaleFactor: 2 });
    const mermaidJS = fs.readFileSync('mermaid.min.js', 'utf8');
    for (const [tid, info] of Object.entries(diagrams)) {
        console.log(`Rendering Topic ${tid}: ${info.title}`);
        const html = `
        <!DOCTYPE html>
        <html>
        <head>
            <script>${mermaidJS}</script>
            <style>
                body { 
                    background: #f8f9fa; 
                    display: flex; 
                    justify-content: center; 
                    align-items: center; 
                    height: 100vh; 
                    margin: 0; 
                    font-family: 'Segoe UI', Arial, sans-serif;
                }
                .container {
                    background: white;
                    padding: 50px;
                    border-radius: 20px;
                    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
                    width: 90%;
                    max-width: 1000px;
                    box-sizing: border-box;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                }
                h1 {
                    text-align: center;
                    color: #2c3e50;
                    margin-bottom: 40px;
                    font-size: 38px;
                    font-weight: 700;
                    letter-spacing: 1px;
                }
                .mermaid {
                    width: 100%;
                    display: flex;
                    justify-content: center;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>${info.title}</h1>
                <div class="mermaid">${info.code}</div>
            </div>
            <script>mermaid.initialize({startOnLoad:true, theme: 'default', securityLevel: 'loose'});</script>
        </body>
        </html>
        `;
        
        await page.setContent(html, { waitUntil: 'load', timeout: 60000 });
        // wait for mermaid to fully render
        await new Promise(r => setTimeout(r, 2000));
        
        const fp = path.join(OUT_DIR, `di_topic_${tid}.png`);
        await page.screenshot({ path: fp });
        console.log(`  ✓ Saved ${fp}`);
    }
    
    await browser.close();
    console.log("All diagrams successfully generated!");
})();
