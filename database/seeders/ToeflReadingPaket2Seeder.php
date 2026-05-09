<?php

namespace Database\Seeders;

use App\Models\ToeflMockupQuestion;
use App\Models\ToeflReadingMeeting;
use App\Models\ToeflReadingPassage;
use App\Models\ToeflReadingQuestion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ToeflReadingPaket2Seeder extends Seeder
{
    public function run(): void
    {
        $canSeedPassages = Schema::hasColumn('toefl_reading_passages', 'package_number');
        $meeting = null;
        if ($canSeedPassages) {
            $meeting = ToeflReadingMeeting::firstOrCreate(
                ['meeting_number' => 998],
                ['title' => 'Mockup Package 2 Reading', 'is_locked' => false]
            );

            $passages = ToeflReadingPassage::where('package_number', 2)
                ->whereIn('passage_number', [1, 2, 3, 4, 5])
                ->get();

            foreach ($passages as $passage) {
                ToeflReadingQuestion::where('passage_id', $passage->id)->delete();
                $passage->delete();
            }
        }

        ToeflMockupQuestion::where('section', 'reading')
            ->where('package_number', 2)
            ->whereBetween('question_number', [1, 50])
            ->delete();

        $passage1 = null;
        if ($canSeedPassages) {
            $passage1 = ToeflReadingPassage::create([
                'meeting_id' => $meeting->id,
                'package_number' => 2,
                'passage_number' => 1,
                'content' => '<div class="toefl-passage-text"><p class="toefl-passage-paragraph">The ballpoint pen is the universal writing instrument of the twentieth century. When the tiny metal ball at the writing tip is drawn across a sheet of paper, it rotates within a housing at the end of an ink reservoir and is coated with ink, which it transfers to the paper.</p><p class="toefl-passage-paragraph">The first ballpoint pen was invented by John Loud in 1888. Loud has been working on a design for a nonleaking pen to mark leather and fabrics and, although his cumbersome design was similar in essence to the modern item, it was never manufactured in large quantities and the patent was allowed to expire. The first workable design was patented in 1938 and became widely accepted in 1942 when the United States Army required a pen that would not leak in high-flying aircraft.</p><p class="toefl-passage-paragraph">The ball of the pen is fitted into a socket so that it rotates freely. Several internal ducts in the socket feed ink to the ball; the other end of the socket is fitted onto a metal or plastic tube that contains the ink. When the ball is pressed on paper and moved, the capillary action draws the ink from the reservoir. In effect, the ball functions as a valve to prevent overflow, and on rotation it acts as a suction pump drawing out the ink.</p><p class="toefl-passage-paragraph">One problem was that as some of the ink ran out, a partial vacuum was formed between the back of the ball and ink reservoir, which cut off the supply. This was solved by making a small hole at the far end of the reservoir. As the ink at the tip is sucked out, more ink from the tube is drawn into the socket to fill its place, the vacuum being prevented by air that is drawn through the vent.</p><p class="toefl-passage-paragraph">Disposable ballpoints have improved considerably in efficiency and reliability since 1938. Further improvements made recently include the production of a pen that writes at any angle, even upside down, and the development of a new ink that is erasable.</p></div>',
            ]);
        }

        $q1to10 = [
            [1, 'The word "it" in line 2 refers to', 'paper', 'ink reservoir', 'writing instrument', 'ball', 'D'],
            [2, 'The word "housing" in line 3 is closest in meaning to', 'point', 'residence', 'case', 'orbit', 'C'],
            [3, 'It can be inferred from the passage that there was interest in designing a new type of pen because the old ones', 'were too big', 'were expensive', 'leaked', 'cracked', 'C'],
            [4, 'The word "expire" in line 8 is closest in meaning to', 'end', 'change', 'copy', 'expand', 'A'],
            [5, 'It can be inferred that the ballpoint pen first gained popularity among', 'military personnel', 'businesspeople', 'scientists', 'artists', 'A'],
            [6, 'Which of the following statements is true of the ball in a ballpoint pen?', 'It is fitted directly into the tube.', 'It controls the flow of ink.', 'It has a small hole.', 'It contains a reservoir of ink.', 'B'],
            [7, 'The author mentions a "suction pump" in line 17 to indicate a function of the', 'reservoir', 'plastic tube', 'socket', 'ball', 'D'],
            [8, 'The word "which" in line 19 refers to', 'supply', 'back of the ball', 'partial vacuum', 'ink reservoir', 'C'],
            [9, 'What was the purpose of the small hole mentioned in line 20?', 'To drain off excess ink', 'To improve ink flow to the tip of the pen', 'To reduce the amount of air in the pen', 'To allow the reservoir to be refilled', 'B'],
            [10, 'Until recently one limitation of ballpoint pens was', 'their inability to function upside down', 'the cost of replacing empty reservoirs', 'the fragility of the point', 'corrosion due to the ink', 'A'],
        ];

        foreach ($q1to10 as $q) {
            if ($canSeedPassages && $passage1) {
                ToeflReadingQuestion::create([
                    'passage_id' => $passage1->id,
                    'question_number' => $q[0],
                    'question_text' => $q[1],
                    'option_a' => $q[2],
                    'option_b' => $q[3],
                    'option_c' => $q[4],
                    'option_d' => $q[5],
                    'correct_answer' => $q[6],
                ]);
            }

            ToeflMockupQuestion::create([
                'section' => 'reading',
                'part' => 'R',
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

        $passage2 = null;
        if ($canSeedPassages) {
            $passage2 = ToeflReadingPassage::create([
                'meeting_id' => $meeting->id,
                'package_number' => 2,
                'passage_number' => 2,
                'content' => '<div class="toefl-passage-text"><p class="toefl-passage-paragraph">By the 1920\'s in the United States, great change had been made in daily life by an accumulation of inventions that had been produced in increasing numbers since the Civil War. These technological innovations created what, in effect, was a social revolution.</p><p class="toefl-passage-paragraph">Improvements in communications served to knit more closely citizens of diverse ethnic and political backgrounds. Rapid printing presses, typesetting devices, and page-plate processes made printed matter more widely accessible. The telephone simplified person-to-person communication. The phonograph, the silent motion picture, the radio, and the sound picture for the first time made auditory and visual impact simultaneously possible over the whole country and had the inevitable, and perhaps undesirable, effect of establishing a trend to national conformity in thought and feeling. One could call this revolution the nationalization of thought and taste.</p><p class="toefl-passage-paragraph">Improvements in transportation made all parts of the country less remote from each other when measured by the time required to go from one place to another. Bicycles and trolleys put the nation on wheels. Then the automobile provided the means for speed and mobility, now so dear to Americans, and brought a demand for better highways. By the 1920\'s cargo trucks were beginning to cut into railroad revenues, and the latest wonder, the airplane, was a fairly common sight.</p><p class="toefl-passage-paragraph">The transport revolution was made possible by the development and perfection of new engines and motors. The internal-combustion engine, using gasoline or oil, could be built in compact power units admirably suited to automobiles, aircraft, and boats. The use of electricity, generated by water power or coal-burning plants, simplified the problems of mechanical power for industrial use and made electrical illumination commonplace in cities, indoors and out. Electricity also powered an increasing variety of domestic appliances.</p></div>',
            ]);
        }

        $q11to20 = [
            [11, "The passage focuses on the United States in the 1920's primarily in terms of the", 'creativity of American inventors', 'decline in social relationships', 'influence of technology on society', 'negative side of technological progress', 'C'],
            [12, 'The word "knit" in line 5 is closest in meaning to', 'unite', 'attract', 'inform', 'study', 'A'],
            [13, 'The word "accessible" in line 7 is closest in meaning to', 'understandable', 'read', 'printed', 'available', 'D'],
            [14, 'According to the author, expanded communications led to a decrease in', 'individuality', 'travel', 'patriotism', 'entertainment', 'A'],
            [15, 'The words "each other" in line 15 refer to', 'improvements in transportation', 'parts of the country', 'bicycles and trolleys', 'better highways', 'B'],
            [16, 'The word "mobility" in line 17 is closest in meaning to', 'excitement', 'movement', 'modernity', 'control', 'B'],
            [17, 'According to the passage, which of the following modes of transportation was negatively affected by motor vehicles?', 'Trolleys', 'Bicycles', 'Trains', 'Airplanes', 'C'],
            [18, 'The passage suggests that a major advantage of the internal-combustion engine was its', 'safety', 'size', 'durability', 'price', 'B'],
            [19, 'The author identifies all of the following as contributors to the "social revolution" of the 1920\'s EXCEPT', 'improved communication', 'improved transportation', 'improvements resulting from electricity', 'improvements in the arts', 'D'],
            [20, 'Where in the passage does the author give an example of a technological advance that led to a demand for improvement in another area?', 'Lines 6-7', 'Lines 16-17', 'Lines 21-23', 'Line 26', 'B'],
        ];

        foreach ($q11to20 as $q) {
            if ($canSeedPassages && $passage2) {
                ToeflReadingQuestion::create([
                    'passage_id' => $passage2->id,
                    'question_number' => $q[0],
                    'question_text' => $q[1],
                    'option_a' => $q[2],
                    'option_b' => $q[3],
                    'option_c' => $q[4],
                    'option_d' => $q[5],
                    'correct_answer' => $q[6],
                ]);
            }

            ToeflMockupQuestion::create([
                'section' => 'reading',
                'part' => 'R',
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

        $passage3 = null;
        if ($canSeedPassages) {
            $passage3 = ToeflReadingPassage::create([
                'meeting_id' => $meeting->id,
                'package_number' => 2,
                'passage_number' => 3,
                'content' => '<div class="toefl-passage-text"><p class="toefl-passage-paragraph">Astronomers have long used direct photography to gather large amounts of information from telescopes. To do this, they have special light-sensitive coatings on glass plates, whose size depends on the type of telescope employed. Certain wide-field telescopes commonly required very large glass plates. These plates do not bend, can be measured accurately, and can preserve information over a long period of time, providing a record that an astronomer at a later time can examine.</p><p class="toefl-passage-paragraph">However, even though long time exposures increase the amount of light striking the plate so that very faint objects in the sky eventually show up clearly, even the most sensitive plates convert only a small percent of the photons striking them into an image. For this reason, photography cannot make very efficient use of short time exposures on a telescope. Despite this inefficiency, photography is still very useful because it works as a two-dimensional detector covering a large area at a telescope\'s focus. Hence, the information contained in a single photograph can be enormous, especially when the photograph is taken with wide-field telescopes.</p><p class="toefl-passage-paragraph">Today, the technology of newer radio and x-ray telescopes has allowed astronomers to view images otherwise invisible to the eye, and direct photography is now used less often to gather images. Today\'s astronomers can study an enhanced view of a telescope\'s focus on a television monitor; and in most cases, the data can later be converted by computer into digital form. This procedure, called image processing, plays a central role in astronomy today. Using false colors, the computer can display images of information otherwise undetectable to the unaided eye. These colors are false in the sense that they are not the actual colors of the object in the visual range of the spectrum. Rather, they are codes to a specific property, such as the x-ray emissions from stars.</p></div>',
            ]);
        }

        $q21to30 = [
            [21, 'What is the main topic of the passage?', 'The use of false colors in image processing', 'The use of wide-field telescopes in astronomy', 'New astronomical theories', 'Methods used by astronomers to obtain information', 'D'],
            [22, 'The word "employed" in line 3 is closest in meaning to', 'measured', 'inspected', 'used', 'purchased', 'C'],
            [23, 'The word "efficient" in line 10 is closest in meaning to', 'productive', 'frequent', 'objective', 'visible', 'A'],
            [24, 'Which of the following is NOT mentioned as an advantage of glass-plate photographs?', 'They can be measured accurately.', 'They can capture the images of faint objects.', 'They can be stored for a long time.', 'They can be processed quickly.', 'D'],
            [25, 'Astronomers most probably use direct photography less frequently today than in the past because', 'glass plates are no longer available', 'only a small amount of information is contained in a single photograph', 'alternate ways of observing images have been developed', 'photographic data deteriorates quickly', 'C'],
            [26, 'What is image processing?', 'The process of light waves striking a glass plate', 'A way to produce images more quickly', 'A reevaluation of old photographs', 'A way computers can present data for analysis', 'D'],
            [27, 'The word "undetectable" in line 23 is closest in meaning to', 'immense', 'inferior', 'imperceptible', 'intolerable', 'C'],
            [28, 'Why do computer-generated images use false colors?', 'The real objects are too bright to look at.', 'The computer screens have a limited range of colors.', 'The properties represented in the image are not otherwise visible.', 'The colors are used to convert black-and-white photographs.', 'C'],
            [29, 'Why does the author mention "x-ray emissions" in line 25?', 'To discuss the measurement of energy flow', 'To emphasize the precision of direct photography', 'To provide an example of what false colors represent', 'To compare the properties of color and movement', 'C'],
            [30, 'Where in the passage does the author mention a disadvantage of photography?', 'Lines 1-3', 'Lines 7-11', 'Lines 18-21', 'Lines 24-25', 'B'],
        ];

        foreach ($q21to30 as $q) {
            if ($canSeedPassages && $passage3) {
                ToeflReadingQuestion::create([
                    'passage_id' => $passage3->id,
                    'question_number' => $q[0],
                    'question_text' => $q[1],
                    'option_a' => $q[2],
                    'option_b' => $q[3],
                    'option_c' => $q[4],
                    'option_d' => $q[5],
                    'correct_answer' => $q[6],
                ]);
            }

            ToeflMockupQuestion::create([
                'section' => 'reading',
                'part' => 'R',
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

        $passage4 = null;
        if ($canSeedPassages) {
            $passage4 = ToeflReadingPassage::create([
                'meeting_id' => $meeting->id,
                'package_number' => 2,
                'passage_number' => 4,
                'content' => '<div class="toefl-passage-text"><p class="toefl-passage-paragraph">The artistic movement known as Impressionism was first identified in 1874 when a group of artists, dissatisfied with the reception of their works by the academic art establishment of their period, chose to hold a separate exhibition of their paintings.</p><p class="toefl-passage-paragraph">Despite obvious differences in style, all of these painters were connected by an ability to catch a moment and preserve it on canvas, and in their belief in the importance of that moment. They readily accepted and made use of the technological advances available to them, and in the end became recognized as proponents of one of the most significant movements in the history of art, a movement that produced an aesthetic revolution in art.</p><p class="toefl-passage-paragraph">Several technological breakthroughs were responsible, to some degree, for the creation and execution of the new Impressionist style. One of these was the invention of a new brush that gave artists greater control. Another useful invention was the collapsible tin tube. This easily reclosed container preserved the oil paint in a stable condition without altering the color. It was a great improvement over animal bladders, which had been used for centuries to hold oil paint. The new tube was portable and made it possible for artists to work outside. This freedom made it possible for Impressionist paintings to "capture the moment," giving them a feeling of immediacy.</p><p class="toefl-passage-paragraph">Another innovation was color. Nineteenth-century chemists had created a new palette of colors, derived from coal tar and other substances. These were first used by textile manufacturers and then adopted by artists. They included some of the brighter colors - new shades of blue, green, and yellow, whose tones gave the Impressionist paintings their characteristic shimmering quality.</p></div>',
            ]);
        }

        $q31to39 = [
            [31, 'What did the group of Impressionist artists do in 1874?', 'They radically changed their style of painting.', 'They held their own exhibition.', 'They adopted new techniques and technologies.', 'They refused to paint anything that year.', 'B'],
            [32, 'The word "it" in line 6 refers to', 'style', 'moment', 'ability', 'canvas', 'B'],
            [33, 'The word "readily" in line 7 is closest in meaning to', 'purposely', 'cautiously', 'cleverly', 'eagerly', 'D'],
            [34, 'According to the passage, Impressionism is regarded historically as', 'a significant, revolutionary movement', 'an innovative yet minor style', 'an unenlightened, radical phase', 'a traditional form of nineteenth-century painting', 'A'],
            [35, 'In line 15 the word "It" refers to', 'container', 'condition', 'oil paint', 'color', 'A'],
            [36, 'Which of the following words does NOT refer to something that holds paint?', 'Bladder', 'Tube', 'Condition', 'Container', 'C'],
            [37, 'What contribution did chemists make to the Impressionist movement?', 'New textiles', 'Better canvases', 'Additional colors', 'Tin tubes', 'C'],
            [38, 'It can be inferred that Impressionist paintings differed from other nineteenth-century paintings in terms of which of the following?', 'The size of the canvas', 'The brightness of the colors', 'The value of the painting', 'The talent of the artists', 'B'],
            [39, 'Where in the passage does the author mention two new technologies available to artists in the nineteenth century?', 'First paragraph', 'Second paragraph', 'Third paragraph', 'Fourth paragraph', 'C'],
        ];

        foreach ($q31to39 as $q) {
            if ($canSeedPassages && $passage4) {
                ToeflReadingQuestion::create([
                    'passage_id' => $passage4->id,
                    'question_number' => $q[0],
                    'question_text' => $q[1],
                    'option_a' => $q[2],
                    'option_b' => $q[3],
                    'option_c' => $q[4],
                    'option_d' => $q[5],
                    'correct_answer' => $q[6],
                ]);
            }

            ToeflMockupQuestion::create([
                'section' => 'reading',
                'part' => 'R',
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

        $passage5 = null;
        if ($canSeedPassages) {
            $passage5 = ToeflReadingPassage::create([
                'meeting_id' => $meeting->id,
                'package_number' => 2,
                'passage_number' => 5,
                'content' => '<div class="toefl-passage-text"><p class="toefl-passage-paragraph">Radiocarbon dating and tree-ring dating, in combination, have provided a very powerful tool to establish a time spectrum for more recent dates in the past. The initial idea for dating by tree rings can be traced back to 1811. Modern scientific tree-ring dating, dendrochronology, stems from pioneering work in early 1900\'s.</p><p class="toefl-passage-paragraph">Usually, but not always, trees produce one ring each year. This ring is formed by the cambium, which lies between the old wood and the bark. In spring, wood cells with large lumens are manufactured, but in summer and autumn, the cells become smaller and more thick-walled until with the onset of winter the production of a new cell stops. The same process is repeated the following year. In this way a year\'s growth (annual ring) is imprinted as new wood. The demarcation line between summer and autumn wood of the previous year, with its characteristic small cells, and the spring wood of the year following, with its large cells, enables annual rings to be counted relatively easily.</p><p class="toefl-passage-paragraph">Growth rings, however, are not always the same thickness. They vary for several reasons. Environmental factors rigidly control the degree of growth of an annual ring or determine whether, in fact, an annual ring appears at all in any particular year. Thus in a specific locale or, more accurately, a specific climatic province, tree-ring counts will reflect climatic conditions and variations due to inequalities of climate from year to year. In years with abnormal drought, for example, narrow rings are produced and sometimes no ring at all. In this way a fossil record is imprinted for as long as the wood remains intact. From this pattern a historical template can be constructed to correlate one set of growth rings in one tree with a set of growth rings in another tree or piece of timber.</p><p class="toefl-passage-paragraph">Another important factor is that tree-ring growth varies with age of the tree. As the tree matures, the rings become narrower, and this results in the central rings being wider than those on the outer part of the tree.</p></div>',
            ]);
        }

        $q40to50 = [
            [40, 'What does the passage mainly discuss?', 'The effect of drought on tree-ring growth', 'The history of dating trees', 'The problems of tree-ring dating', 'The formation of growth rings in trees', 'D'],
            [41, 'The word "stems" in line 4 is closest in meaning to', 'distinguishes', 'recovers', 'derives', 'returns', 'C'],
            [42, 'The approximate age of a tree can be determined by', 'counting the rings', 'analyzing the structure of the cells', 'examining the cambium', 'measuring the width of the rings', 'A'],
            [43, 'The word "onset" in line 9 is closest in meaning to', 'beginning', 'coldness', 'difficulty', 'darkness', 'A'],
            [44, 'The word "enables" in line 14 is closest in meaning to', 'combines', 'forces', 'encourages', 'allows', 'D'],
            [45, 'The word "They" in line 15 refers to', 'large cells', 'growth rings', 'several reasons', 'environmental factors', 'B'],
            [46, 'According to the passage, the production of rings from year to year in any given tree is', 'random', 'predetermined', 'variable', 'accelerated', 'C'],
            [47, 'The word "reflect" in line 19 is closest in meaning to', 'indicate', 'affect', 'confuse', 'limit', 'A'],
            [48, 'A narrow growth ring between two wide growth rings would probably indicate', 'an unusually warm winter', 'the death of an old tree', 'unfavorable climatic conditions during a single year', 'wood cells that had grown to be very large', 'C'],
            [49, 'Which of the following terms is defined in the passage?', 'dendrochronology (line 4)', 'lumens (line 8)', 'drought (line 20)', 'template (line 23)', 'A'],
            [50, 'The phrase "this pattern" in line 22 refers to', 'the change of seasons', 'different climates in different places', 'the destruction of trees and forests', 'variation in the thickness of tree rings', 'D'],
        ];

        foreach ($q40to50 as $q) {
            if ($canSeedPassages && $passage5) {
                ToeflReadingQuestion::create([
                    'passage_id' => $passage5->id,
                    'question_number' => $q[0],
                    'question_text' => $q[1],
                    'option_a' => $q[2],
                    'option_b' => $q[3],
                    'option_c' => $q[4],
                    'option_d' => $q[5],
                    'correct_answer' => $q[6],
                ]);
            }

            ToeflMockupQuestion::create([
                'section' => 'reading',
                'part' => 'R',
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

        if (!$canSeedPassages) {
            $this->command?->warn('ToeflReadingPaket2Seeder: passage table has no package_number column; only mockup reading questions were seeded.');
        }
        $this->command?->info('ToeflReadingPaket2Seeder: seeded package 2 reading data for questions 1-50.');
    }
}
