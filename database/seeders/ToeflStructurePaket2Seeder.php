<?php

namespace Database\Seeders;

use App\Models\ToeflMockupQuestion;
use Illuminate\Database\Seeder;

class ToeflStructurePaket2Seeder extends Seeder
{
    public function run(): void
    {
        ToeflMockupQuestion::where('section', 'structure')
            ->where('package_number', 2)
            ->delete();

        $structure = [
            [1, "Since the early 1950's, _____ throughout the world has more than doubled.", 'the demand for food', 'there is demand for food', 'if food is in demand', 'food, a demand that', 'A'],
            [2, 'Even though he did not attend school until he was twelve, Dr. Samuel C.C. Ting was _____ the Nobel Prize in Physics in 1976.', 'won', 'the winning', 'the winner of', 'to be won', 'C'],
            [3, 'Gas particles move _____ when the gas is hot than when it is cold.', 'fast', 'faster', 'as fast', 'fastest', 'B'],
            [4, "The different colors of _____ the different temperatures of the stars' surfaces.", 'the stars indicate', 'indicating stars', 'the indication that the stars', 'stars indicating that', 'A'],
            [5, 'As a country develops from an agricultural to an industrial economy, the attitudes, values, structures, and functions of the family _____.', 'the change', 'which change', 'change', 'changing', 'C'],
            [6, 'Only a few sounds produced by insects are heard by humans _____ most of the sounds are pitched either too low or too high.', 'in spite of', 'because', 'as a result of', 'instead of', 'B'],
            [7, 'The ordinary chair _____ in countless shapes, sizes, styles, and materials.', 'has been made', 'to be made', 'is making', 'been making', 'A'],
            [8, 'For 125 years after _____ initial use at Harvard in 1642, the Bachelor of Arts degree was the only degree awarded by colleges in the United States.', 'its', 'it was', 'being', 'when', 'A'],
            [9, 'Since the Sun illuminates half the surface of the Moon, only half the surface _____ can be seen from the Earth.', 'most', 'much', 'with more', 'at most', 'D'],
            [10, 'The novels of Constance Fenimore Woolson, _____, have special interest for their regional settings.', 'in a nineteenth-century writer', 'a nineteenth-century writer', 'the nineteenth-century writing', 'wrote about the nineteenth century', 'B'],
            [11, '_____ Oklahoma is important as a farming state, it is even more important for its rich oil deposits.', 'By', 'Although', 'In order for', 'Concerning', 'B'],
            [12, 'No animal seems _____ on a diet of peat moss.', 'survived', 'can survive', 'of surviving', 'able to survive', 'D'],
            [13, 'The upper part in a harmonic arrangement _____ by mixed voices is usually written for a soprano voice.', 'to be sung', 'as singing', 'to be singing', 'was sung', 'A'],
            [14, 'The first school _____ the state of Washington was opened at old Fort Vancouver in 1832.', 'is now', 'is that in', 'what is that', 'in what is now', 'D'],
            [15, 'Radio, _____, developed from the theories and experiments of many people.', 'like other many inventions', 'like many other inventions', 'inventions like many other', 'many other like inventions', 'B'],
        ];

        $written = [
            [16, 'While attempting to fly **hers** **plane** **around** the world in 1937, Amelia Earhart **mysteriously** disappeared.', 'A'],
            [17, "Richard Wright's Uncle Tom's Children, a collection of **short** stories, **were** a critical **success** when it **appeared** in 1938.", 'B'],
            [18, 'The principle on which the boat called a hydrofoil **is identically** to that **demonstrated** by an airplane wing **moving** through **air**.', 'A'],
            [19, 'Migrating **butterflies** can **travel** long **distant** **over** water.', 'C'],
            [20, 'During **a early** period in the settlement of the western United States, pioneers claimed **parts** of the wilderness by **marking** trees **to establish** a boundary.', 'A'],
            [21, '**All** digital computers **use** binary, or two-valued, digits **instead** than decimal, or ten-valued, digits **to represent** and store data.', 'C'],
            [22, '**An** ambassador serves **as** a nation\'s highest-ranking **diplomacy** in another **country**.', 'C'],
            [23, '**Early** adolescence is a **developmental** phase consisting of **rapid** changes in behavior, **psychological**, and hormones.', 'D'],
            [24, '**Knowledge** from the frontiers of **research genetic** will increasingly pose **difficult** problems for policy makers and for society **in general**.', 'B'],
            [25, 'Pictures **called** glass mosaics are made **by setting** small pieces **of colors** glass **into** fresh plaster.', 'C'],
            [26, 'Approximately **every nineteen month** Venus and the Sun reach **their** greatest angular **separation** **in** the solar system.', 'A'],
            [27, 'Anthropologists recently have **found evidence** that, centuries ago, Inuits **used to entering** their subterranean homes through tunnels, which **helped keep** the cold out and **the heat in**.', 'B'],
            [28, 'The tree porcupine is found in **wooded** areas **throughout** **most from** North America.', 'C'],
            [29, 'To date, only a small percentage of all glass **manufactured** in the United States **is** recycled, but markets for recycled glass **that are** growing **steadily**.', 'C'],
            [30, 'The **oceans** are the **major source** of the **atmospheric** moisture that is obtained through **evaporator**.', 'D'],
            [31, 'Only those insects with **high** **developed**, multilensed eyes **have** good **color** vision.', 'A'],
            [32, "The Earth's atmosphere **functions** much like a giant greenhouse, admitting sunlight **between** outer space **but** preventing heat from **escaping**.", 'B'],
            [33, 'The almond tree **which produces** the **oldest** species of nut and is the most **widely grown** of all **nut** trees.', 'A'],
            [34, 'Fran Tannenbaum, a paleontology student **doing** summer **fieldwork**, **found** a **completely** seventy-five-million-year-old fossil egg near Chateau, Montana.', 'D'],
            [35, 'Fencing, originally developed as a sport **in fourteenth century**, was **included in** the **first modern** Olympic Games **of 1896**.', 'A'],
            [36, '**Depth** within **ancient** tombs, 3,000-year-old peanuts **have** been found **alongside** mummies.', 'A'],
            [37, 'Art Nouveau developed **in** the 1890\'s when artists **did** a **conscious** effort to break with what they regarded as worn-out formulas of **the past**.', 'B'],
            [38, 'The most widely cultivated **all of** fruit trees, the apple is second **only to** the grape in its **importance** **as** a temperate-zone fruit.', 'A'],
            [39, 'Pawnbroking, **or making loans** to customers **who** pledge **personal** or household goods as security, is one of the oldest **trade** known.', 'D'],
            [40, '**Of** 1901 to 1914, acclaimed actor Douglas Fairbanks appeared **on stage** in **a series** of light **comedies**.', 'A'],
        ];

        foreach ($structure as $q) {
            ToeflMockupQuestion::create([
                'section' => 'structure',
                'part' => 'Structure',
                'package_number' => 2,
                'question_number' => $q[0],
                'question_text' => $q[1],
                'option_a' => $q[2],
                'option_b' => $q[3],
                'option_c' => $q[4],
                'option_d' => $q[5],
                'correct_answer' => $q[6],
            ]);
        }

        foreach ($written as $q) {
            ToeflMockupQuestion::create([
                'section' => 'structure',
                'part' => 'Written Expression',
                'package_number' => 2,
                'question_number' => $q[0],
                'question_text' => $q[1],
                'option_a' => 'A',
                'option_b' => 'B',
                'option_c' => 'C',
                'option_d' => 'D',
                'correct_answer' => $q[2],
            ]);
        }

        $this->command?->info('ToeflStructurePaket2Seeder: seeded 40 questions for package 2.');
    }
}
