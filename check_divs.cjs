const fs = require('fs');

const blade = fs.readFileSync('/Applications/MAMP/htdocs/TargetBahasaCourse/resources/views/brochure.blade.php', 'utf8');

// Match each case in the switch
const cases = ['toefl-itp', 'ielts-academic-full-package', 'pte-academic', 'fast-track-grammar-for-writing', 'speaking', 'ielts-academic-listening', 'default'];

for (const c of cases) {
    let blockStart, blockEnd;
    if (c === 'default') {
        blockStart = blade.indexOf('@default');
        blockEnd = blade.indexOf('@endswitch', blockStart);
    } else {
        blockStart = blade.indexOf(`@case('${c}')`);
        const nextCase = blade.indexOf('@break', blockStart);
        blockEnd = nextCase;
    }
    
    if (blockStart === -1) continue;
    
    const block = blade.substring(blockStart, blockEnd);
    const opens = (block.match(/<div[^>]*>/g) || []).length;
    const closes = (block.match(/<\/div>/g) || []).length;
    
    console.log(`Case ${c}: opens=${opens}, closes=${closes}, diff=${opens - closes}`);
}
