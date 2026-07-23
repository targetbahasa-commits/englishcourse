const fs = require('fs');
let content = fs.readFileSync('resources/views/promo/promo_toolbar.blade.php', 'utf8');

// Patch 1
content = content.replace(
`                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Vocabulary of Change -->
                    <div class="space-y-2">`,
`                                </tbody>
                            </table>
                        </div>

                    <!-- Vocabulary of Change -->
                    <div class="space-y-2">`
);

// Patch 2
content = content.replace(
`                    </div>

                </div>
            </div>
    </div>
    </div>
    </template>
    </div>
@endif

<!-- 3.7. DESCRIBING PROCESS (Task 1 Only) -->`,
`                    </div>
                </div>
            </div>
        </template>
    </div>
@endif

<!-- 3.7. DESCRIBING PROCESS (Task 1 Only) -->`
);

let level = 0;
const lines = content.split('\n');
let bad = false;
for (let i = 0; i < lines.length; i++) {
    const opens = (lines[i].match(/<div/g) || []).length;
    const closes = (lines[i].match(/<\/div>/g) || []).length;
    level += opens - closes;
    if (level < 0) {
        console.log(`Negative level reached first at line ${i + 1}`);
        bad = true;
        break;
    }
}
if (!bad) {
    console.log('Final level:', level);
}
