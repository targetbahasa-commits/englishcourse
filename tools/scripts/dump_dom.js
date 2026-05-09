console.log(document.querySelector('.formal-sheet-container') ? 'Page 1 exists' : 'Page 1 missing');
console.log(document.querySelector('[x-show="Number(listeningPage) === 2"]') ? 'Page 2 exists' : 'Page 2 missing');
console.log(document.querySelector('[x-show="Number(currentPartAIndex) === 0"]') ? 'Card 0 exists' : 'Card 0 missing');
console.log(document.querySelector('[x-show="Number(currentPartAIndex) === 0"]') ? document.querySelector('[x-show="Number(currentPartAIndex) === 0"]').innerHTML.substring(0, 300) : '');
