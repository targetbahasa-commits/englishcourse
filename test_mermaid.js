const puppeteer = require('puppeteer');
const fs = require('fs');

(async () => {
    const browser = await puppeteer.launch();
    const page = await browser.newPage();
    await page.setViewport({ width: 1200, height: 800, deviceScaleFactor: 2 });
    
    const html = `
    <!DOCTYPE html>
    <html>
    <head>
        <script src="https://cdn.jsdelivr.net/npm/mermaid/dist/mermaid.min.js"></script>
        <style>
            body { 
                background: #f4f7f6; 
                display: flex; 
                justify-content: center; 
                align-items: center; 
                height: 100vh; 
                margin: 0; 
                font-family: 'Arial', sans-serif;
            }
            .container {
                background: white;
                padding: 40px;
                border-radius: 20px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            }
            h1 {
                text-align: center;
                color: #2c3e50;
                margin-bottom: 30px;
                font-size: 32px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Hotel Check-In Process</h1>
            <div class="mermaid">
                graph TD
                A[Guest Arrives] --> B[Welcome by Receptionist]
                B --> C{Reservation?}
                C -->|Yes| D[Find Booking]
                C -->|No| E[Check Availability]
                E -->|Available| F[Create Walk-in Booking]
                E -->|Full| G[Apologize & Suggest Alternatives]
                D --> H[Request ID & Credit Card]
                F --> H
                H --> I[Assign Room & Hand Keys]
                I --> J[Guest Proceeds to Room]
                
                classDef default fill:#3498db,stroke:#2980b9,stroke-width:2px,color:white,font-size:18px,rx:10,ry:10;
                classDef decision fill:#f39c12,stroke:#e67e22,stroke-width:2px,color:white,font-size:18px;
                class C decision;
            </div>
        </div>
        <script>mermaid.initialize({startOnLoad:true, theme: 'default'});</script>
    </body>
    </html>
    `;
    
    await page.setContent(html, { waitUntil: 'networkidle0' });
    // wait a bit for mermaid to render
    await new Promise(r => setTimeout(r, 2000));
    await page.screenshot({ path: 'mermaid_test.png' });
    await browser.close();
    console.log("Screenshot saved as mermaid_test.png");
})();
