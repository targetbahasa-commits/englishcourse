<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IeltsReadingPractice17Seeder extends Seeder
{
    public function run(): void
    {
        $materialId = 17;

        // Clean up any existing records for this material
        $existingPassages = \App\Models\IeltsReadingPassage::where('material_id', $materialId)->get();
        foreach ($existingPassages as $passage) {
            $passage->questions()->delete();
            $passage->delete();
        }

        // --- PASSAGE 1 ---
        $passage1 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'LONGAEVA: Ancient Bristlecone Pine',
            'content' => '
<p><strong>A</strong></p>
<p>To understand more about the earth’s history, humans have often looked to the natural environment for insight into the past. The bristlecone pine (Pinus longaeva), of the White Mountains in California, has served this purpose greater than any other species of tree on the planet. Conditions here are brutal: scant precipitation and low average temperatures mean a short growing season, only intensified by ferocious wind and mal-nutritious rocky. Nevertheless, bristlecone pines have claimed these barren slopes as their permanent home. Evolving here in this harsh environment, super-adapted and without much competition, bristlecones have earned their seat on the longevity throne by becoming the oldest living trees on the planet. Results of extensive studies on bristlecone pine stands have shown that in fact such, environmental limitations are positively associated with the attainment of great age. This intriguing phenomenon will be discussed further on.</p>

<p><strong>B</strong></p>
<p>But exactly how old is old? Sprouted before the invention of Egyptian hieroglyphs and long before the teachings of Jesus of Nazareth, Methuselah is the oldest bristlecone alive at roughly 4,700 years. Although specimens of this age do not represent the species’ average, there are 200 trees more than 3,000 years old, and two dozen more than 4,000. Considering that these high ages are obtained in the face of such remarkable environmental adversity, the bristlecone pines have become the focus of much scientific examination over the past half-century.</p>

<p><strong>C</strong></p>
<p>Perhaps most interested in the bristlecone pine are dendrochronologists or tree-ring daters. With every strenuous year that passes in the While Mountains, each bristlecone grows and forms a new outer layer of cambium that reflects a season’s particular ease or hardship. So while growing seasons may expand or shrink, the trees carry on, their growth rings faithfully recording the bad years alongside the goods. Through examining the annual growth rings of both living and dead specimens, taking thousands of core samples, and by processes of cross-dating between trees and other qualitative records, scientists have compiled a continuous tree-ring record that dates back to the last Ice Age between eight and ten thousand years ago. Among other linked accomplishments, this record has enhanced the dating process, helping to double-check and correct the radiocarbon-14 method to more accurately estimate the age of organic material.</p>

<p><strong>D</strong></p>
<p>Now more than ever the importance of monitoring the bristlecone is being realized. As our global climate continues to undergo its most recent and abrupt atmospheric change, these ancient scribes continue to respond. Since, the rings of wood formed each year reveal the trees’ response to climatic conditions during a particular growing season, in their persistence they have left us natural recordings of the past, markers of the present, and clues to the future.</p>

<p><strong>E</strong></p>
<p>The species’ name originates from the appearance of its unusual cones and needles. The bristlecone’s short, pale needles are also trademarks, bunching together to form foxtail-like bundles. As is the case of most conifer needles, these specialized leaves cluster together to shelter the stomata so very little moisture is lost through them. This adaptation helps the bristlecone photosynthesize during particularly brutal months. Saving the energy of constant needle replacement and providing a stable supply of chlorophyll. For a plant trying to store so much energy, bristlecone seeds are relatively large in size. They are first reproduced when trees reach ages between thirty and seventy-five years old. Germination rates are generally high, in part because seeds require little to no initial stratification. Perhaps the most intriguing physical characteristic of a mature bristlecone, however, is its ratio of living to deadwood on harsh sites and how this relates to old age. In older trees, however, especially in individuals over 1,500 years, a strip-bark trait is adaptive. This condition occurs as a result of cambium dieback, which erodes and thereby exposes certain areas of the bole, leaving only narrow bands of bark intact.</p>

<p><strong>F</strong></p>
<p>The technique of cambial edge retreat has helped promote old age in bristlecone pine, but that certainly is no the only reason. Most crucial to these trees’ longevity is their compact size and slow rates of growth. By remaining in most cases under ten meters tall, bristlecones stay close to the limited water supply and can hence support more branches and photosynthesizing. Combined with the dry, windy, and often freezing mountain air, slow growth guarantees the bristlecones tight, fibrous rings with a high resin content and structural strength. The absence of natural disaster has also safeguarded the bristlecone’s lengthy lifespan. Due to a lack of ground cover vegetation and an evenly spaced layout, bristlecone stands on the White Mountain peaks have been practically unaffected by the fire. This lack of vegetation also means a lack of competition for the bristlecones.</p>

<p><strong>G</strong></p>
<p>Bristlecone pines restricted to numerous, rather isolated stands at higher altitudes in the southwestern United States. Stands occur from the Rocky Mountains, through the Colorado Plateau, to the western margin of the Great Basin. Within this natural range, the oldest and most widely researched stands of bristlecones occur in California’s the White Mountains. Even just 200 miles away from the Pacific Ocean, the White Mountains are home to one of this country’s few high-elevation deserts. Located in the extreme eastern rain shadow of the Sierra Nevada, this region receives only 12.54 inches of precipitation per year and experiences temperatures between -20F and +50F. The peaks south of the Owens Valley, are higher up than they might appear from a distance. Although most summits exist somewhere around 11,000 feet, snow-capped White Mountain Peak, for which the range is named, stands at 14,246 feet above sea level. That said, to reach areas of a pure bristlecone is an intense journey all to itself.</p>

<p><strong>H</strong></p>
<p>With seemingly endless areas of wonder and interest, the bristlecone pines have become subject to much research over the past half-century. Since the annual growth of these ancient organisms directly reflects the climatic conditions of a particular time period, bristlecones are of greatest significance to dendrochronologists or tree-ring specialists. Dating any tree is simple and can be done within reasonable accuracy just by counting out the rings made each year by the plant’s natural means of growth. By carefully compiling a nearly 10,000-year-old bristlecone pine record, these patient scientists have accurately corrected the carbon-14 dating method and estimated ages of past periods of global climate change. What makes this record so special to dendrochronologists, too, is that, nowhere, throughout time, is precisely the same long-term sequence of wide and narrow rings repeated, because year-to-year variations in climate are never exactly the same.</p>

<p><strong>I</strong></p>
<p>Historically the bristlecone’s remote location and gnarled wood have deterred commercial extraction, but nothing on earth will go unaffected by global warming. If temperatures rise by only 6 degrees F, which many experts say is likely this century, about two-thirds of the bristlecones’ ideal habitat in the White Mountains effectively will be gone. Almost 30,000 acres of National Forest now preserves the ancient bristlecone, but paved roads, campsites, and self-guided trails have led only to more human impact. In 1966, the U.S.F.S reported over 20,000 visitors to the Ancient Bristlecone Pine Forest, a figure which could exceed 40,000 today. Over the past hundreds of thousands of years, this species has endured in one of the earth’s most trying environments; they deserve our respect and reverence. As global climate change slowly alters their environment, we as humans must do our part to raise awareness and lower our impact.</p>',
            'order' => 1,
        ]);

        // Questions 1-4: Matching Paragraph Information
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 1,
            'type' => 'matching_paragraph_information',
            'question_text' => 'Which paragraph contains the following information?<br>Write the correct letter A-I, in boxes 1-4 on your answer sheet.',
            'options' => [
                'A' => 'Paragraph A',
                'B' => 'Paragraph B',
                'C' => 'Paragraph C',
                'D' => 'Paragraph D',
                'E' => 'Paragraph E',
                'F' => 'Paragraph F',
                'G' => 'Paragraph G',
                'H' => 'Paragraph H',
                'I' => 'Paragraph I',
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 0,
                'sub_questions' => [
                    ['id' => '1', 'label' => 'Human activity threats bristlecone pines habitat', 'correct_answer' => 'I'],
                    ['id' => '2', 'label' => 'Explanations for a ring of bristlecone pines', 'correct_answer' => 'C'],
                    ['id' => '3', 'label' => 'An accountable recording provided from the past until now', 'correct_answer' => 'D'],
                    ['id' => '4', 'label' => 'Survived in a hostile environment', 'correct_answer' => 'A'],
                ]
            ],
            'order' => 1,
        ]);

        // Questions 5-7: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 5,
            'type' => 'multiple_choice',
            'question_text' => 'Choose the correct letter, A, B, C or D.<br>Write your answers in boxes 5-7 on your answer sheet.<br><br>According to passage A, what aspect of bristlecone pines attracts author’s attention?',
            'options' => [
                'A' => 'Brutal environment they live',
                'B' => 'Remarkable long age',
                'C' => 'They only live in California',
                'D' => 'Outstanding height'
            ],
            'correct_answer' => 'B',
            'explanation' => null,
            'data' => [
                'start_number' => 4,
                'sub_questions' => [
                    ['id' => '5', 'label' => 'According to passage A, what aspect of bristlecone pines attracts author’s attention?', 'correct_answer' => 'B']
                ]
            ],
            'order' => 2,
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 6,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'Because of the oldest ones researched in this region',
                'B' => 'Because most bizarre ones are in this region',
                'C' => 'Because precipitation is rich in this region',
                'D' => 'Because sea level is comparatively high in this region'
            ],
            'correct_answer' => 'A',
            'explanation' => null,
            'data' => [
                'start_number' => 5,
                'sub_questions' => [
                    ['id' => '6', 'label' => 'Why do we investigate Bristlecone pines in higher altitudes of California’s the White Mountains?', 'correct_answer' => 'A']
                ]
            ],
            'order' => 3,
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 7,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'Because sea level rises which affect tree ring',
                'B' => 'Because tree ring pattern is completely random',
                'C' => 'Because ancient organisms affect their growth',
                'D' => 'Because the variation of climate change is different'
            ],
            'correct_answer' => 'D',
            'explanation' => null,
            'data' => [
                'start_number' => 6,
                'sub_questions' => [
                    ['id' => '7', 'label' => 'Why there are repeated patterns of wide and narrow rings?', 'correct_answer' => 'D']
                ]
            ],
            'order' => 4,
        ]);

        // Questions 8-13: Summary Completion
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 8,
            'type' => 'summary_completion',
            'question_text' => '',
            'options' => null,
            'correct_answer' => [
                '8' => 'energy',
                '9' => 'stratification',
                '10' => 'bands of bark',
                '11' => 'dry mountain air',
                '12' => 'ground cover',
                '13' => 'distance',
            ],
            'explanation' => null,
            'data' => [
                'start_number' => 7,
                'instruction' => 'Complete the following summary of the paragraphs of Reading Passage.<br>Using <strong>NO MORE THAN THREE WORDS</strong> from the Reading Passage for each answer.',
                'summary_text' => 'The bristlecone’s special adaptation is a benefit for photosynthesizing, and reserving the <strong>[8]</strong> of leave replacement and providing sufficient chlorophyll. Probably because seeds do not rely on primary <strong>[9]</strong>, Germination rate is high. Because of cambium dieback, only narrow <strong>[10]</strong> remain complete. Due to multiple factors such as windy, cold climate and <strong>[11]</strong>, bristlecones’ rings have a tight and solid structure full of resin. Moreover, bristlecone stands are safe from the fire because of little <strong>[12]</strong> plants spread in this place. The summits of Owens Valley is higher than they emerge if you observe from a <strong>[13]</strong>.',
                'placeholders' => [
                    '8' => 8,
                    '9' => 9,
                    '10' => 10,
                    '11' => 11,
                    '12' => 12,
                    '13' => 13
                ],
            ],
            'order' => 5,
        ]);


        // --- PASSAGE 2 ---
        $passage2 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'Corporate Social Responsibility',
            'content' => '
<p><i>Broadly speaking, proponents of CSR have used four arguments to make their case: moral obligation, sustainability, license to operate, and reputation. The moral appeal – arguing that companies have a duty to be good citizens and to “do the right thing” – is prominent in the goal of Business for Social Responsibility, the leading nonprofit CSR business association in the United States. It asks that its members “achieve commercial success in ways that honor ethical values and respect people, communities, and the natural environment.” Sustainability emphasizes the environment and community stewardship.</i></p>

<p><strong>A</strong></p>
<p>An excellent definition was developed in the 1980s by Norwegian Prime Minister Gro Harlem Brundtland and used by the World Business Council for Sustainable Development: “Meeting the needs of the present without compromising the ability of future generations to meet their own needs.” The notion of a license to operate derives from the fact that every company needs tacit or explicit permission from governments, communities, and numerous other stakeholders to do business. Finally, reputation is used by many companies to justify CSR initiatives on the grounds that they will improve a company’s image, strengthen its brand, enliven morale, and even raise the value of its stock.</p>

<p><strong>B</strong></p>
<p>To advance CSR, we must root it in a broad understanding of the interrelationship between a corporation and society while at the same time anchoring it in the strategies and activities of specific companies. To say broadly that business and society need each other might seem like a cliché, but it is also the basic truth that will pull companies out of the muddle that their current corporate-responsibility thinking has created. Successful corporations need a healthy society. Education, health care, and equal opportunity are essential to a productive workforce. Safe products and working conditions not only attract customers but lower the internal costs of accidents. Efficient utilization of land, water, energy, and other natural resources makes business more productive. Good government, the rule of law, and property rights are essential for efficiency and innovation. Strong regulatory standards protect both consumers and competitive companies from exploitation. Ultimately, a healthy society creates expanding demand for business, as more human needs are met and aspirations grow. Any business that pursues its ends at the expense of the society in which it operates will find its success to be illusory and ultimately temporary. At the same time, a healthy society needs successful companies. No social program can rival the business sector when it comes to creating the jobs, wealth, and innovation that improve standards of living and social conditions over time.</p>

<p><strong>C</strong></p>
<p>A company’s impact on society also changes over time, as social standards evolve and science progresses. Asbestos, now understood as a serious health risk, was thought to be safe in the early 1900s, given the scientific knowledge then available. Evidence of its risks gradually mounted for more than 50 years before any company was held liable for the harms it can cause. Many firms that failed to anticipate the consequences of this evolving body of research have been bankrupted by the results. No longer can companies be content to monitor only the obvious social impacts of today. Without a careful process for identifying evolving social effects of tomorrow, firms may risk their very survival.</p>

<p><strong>D</strong></p>
<p>No business can solve all of society’s problems or bear the cost of doing so. Instead, each company must select issues that intersect with its particular business. Other social agendas are best left to those companies in other industries, NGOs, or government institutions that are better positioned to address them. The essential test that should guide CSR is not whether a cause is worthy but whether it presents an opportunity to create shared value – that is, a meaningful benefit for society that is also valuable to the business. However, Corporations are not responsible for all the world’s problems, nor do they have the resources to solve them all. Each company can identify the particular set of societal problems that it is best equipped to help resolve and from which it can gain the greatest competitive benefit. Addressing social issues by creating shared value will lead to self-sustaining solutions that do not depend on private or government subsidies. When a well-run business applies its vast resources, expertise, and management talent to problems that it understands and in which it has a stake, it can have a greater impact on social good than any other institution or philanthropic organization.</p>

<p><strong>E</strong></p>
<p>The best corporate citizenship initiatives involve far more than writing a check: They specify clear, measurable goals and track results over time. A good example is GE’s program to adopt underperforming public high schools near several of its major U.S. facilities. The company contributes between $250,000 and $1 million over a five-year period to each school and makes in-kind donations as well. GE managers and employees take an active role by working with school administrators to assess needs and mentor or tutor students. In an independent study of ten schools in the program between 1989 and 1999, nearly all showed significant improvement, while the graduation rate in four of the five worst-performing schools doubled from an average of 30% to 60%. Effective corporate citizenship initiatives such as this one create goodwill and improve relations with local governments and other important constituencies. What’s more, GE’s employees feel great pride in their participation. Their effect is inherently limited, however. No matter how beneficial the program is, it remains incidental to the company’s business, and the direct effect on GE’s recruiting and retention is modest.</p>

<p><strong>F</strong></p>
<p>Microsoft’s Working Connections partnership with the American Association of Community Colleges (AACC) is a good example of a shared-value opportunity arising from investments in context. The shortage of information technology workers is a significant constraint on Microsoft’s growth; currently, there are more than 450,000 unfilled IT positions in the United States alone. Community colleges, with an enrollment of 11.6 million students, representing 45% of all U.S. undergraduates, could be a major solution. Microsoft recognizes, however, that community colleges face special challenges: IT curricula are not standardized, the technology used in classrooms is often outdated, and there are no systematic professional development programs to keep faculty up to date. Microsoft’s $50 million five-year initiative was aimed at all three problems. In addition to contributing money and products, Microsoft sent employee volunteers to colleges to assess needs, contribute to curriculum development, and create faculty development institutes. Note that in this case, volunteers and assigned staff were able to use their core professional skills to address a social need, a far cry from typical volunteer programs. Microsoft has achieved results that have benefited many communities while having a direct – and potentially significant – impact on the company.</p>

<p><strong>G</strong></p>
<p>At the heart of any strategy is a unique value proposition: a set of needs a company can meet for its chosen customers that others cannot. The most strategic CSR occurs when a company adds a social dimension to its value proposition, making social impact integral to the overall strategy. Consider Whole Foods Market, whose value proposition is to sell organic, natural, and healthy food products to customers who are passionate about food and the environment. The company’s sourcing emphasizes purchases from local farmers through each store’s procurement process. Buyers screen out foods containing any of nearly 100 common ingredients that the company considers unhealthy or environmentally damaging. The same standards apply to products made internally. Whole Foods’ commitment to natural and environmentally friendly operating practices extends well beyond sourcing. Stores are constructed using a minimum of virgin raw materials. Recently, the company purchased renewable wind energy credits equal to 100% of its electricity use in all of its stores and facilities, the only Fortune 500 company to offset its electricity consumption entirely. Spoiled produce and biodegradable waste are trucked to regional centers for composting. Whole Foods’ vehicles are being converted to run on biofuels. Even the cleaning products used in its stores are environmentally friendly. And through its philanthropy, the company has created the Animal Compassion Foundation to develop more natural and humane ways of raising farm animals. In short, nearly every aspect of the company’s value chain reinforces the social dimensions of its value proposition, distinguishing Whole Foods from its competitors.</p>',
            'order' => 2,
        ]);

        // Questions 14-20: Matching Headings
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 14,
            'type' => 'matching_headings',
            'question_text' => 'Choose the correct heading for paragraphs A-G from the list below.<br>Write the correct number, i-xi, in boxes 14-20 on your answer sheet.',
            'options' => [
                'i' => 'How CSR may help one business to expand',
                'ii' => 'CSR in many aspects of a company’s business',
                'iii' => 'A CSR initiative without a financial gain',
                'iv' => 'Lack of action by the state of social issues',
                'v' => 'Drives or pressures motivate companies to address CSR',
                'vi' => 'the past illustrates business are responsible for future outcomes',
                'vii' => 'Companies applying CSR should be selective',
                'viii' => 'Reasons that business and society benefit each other'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'box_title' => 'List of Headings',
                'start_number' => 13,
                'sub_questions' => [
                    ['id' => '14', 'label' => 'Paragraph A', 'correct_answer' => 'v'],
                    ['id' => '15', 'label' => 'Paragraph B', 'correct_answer' => 'viii'],
                    ['id' => '16', 'label' => 'Paragraph C', 'correct_answer' => 'vi'],
                    ['id' => '17', 'label' => 'Paragraph D', 'correct_answer' => 'vii'],
                    ['id' => '18', 'label' => 'Paragraph E', 'correct_answer' => 'iii'],
                    ['id' => '19', 'label' => 'Paragraph F', 'correct_answer' => 'i'],
                    ['id' => '20', 'label' => 'Paragraph G', 'correct_answer' => 'ii'],
                ]
            ],
            'order' => 1,
        ]);

        // Questions 21-22: Summary Completion
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 21,
            'type' => 'summary_completion',
            'question_text' => '',
            'options' => null,
            'correct_answer' => [
                '21' => 'equal opportunity',
                '22' => 'internal costs',
            ],
            'explanation' => null,
            'data' => [
                'start_number' => 20,
                'instruction' => 'Complete the following summary of the paragraphs of Reading Passage.<br>Using <strong>NO MORE THAN TWO WORDS</strong> from the Reading Passage for each answer.',
                'summary_text' => '<strong>The implement of CSR, HOW?</strong><br><br>Promotion of CSR requires the understanding of the interdependence between business and society. Corporations workers’ productivity generally needs health care, Education, and given <strong>[21]</strong>. Restrictions imposed by government and companies both protect consumers from being treated unfairly. Improvement of the safety standard can reduce the <strong>[22]</strong> of accidents in the workplace. Similarly, society becomes a pool of more human needs and aspirations.',
                'placeholders' => [
                    '21' => 21,
                    '22' => 22
                ],
            ],
            'order' => 2,
        ]);

        // Questions 23-26: Matching Features
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 23,
            'type' => 'matching_features',
            'question_text' => 'Use the information in the passage to match the companies (listed A-C) with opinions or deeds below.<br>Write the appropriate letters A, B or C in boxes 23-26 on your answer sheet.',
            'options' => [
                'A' => 'General Electronics',
                'B' => 'Microsoft',
                'C' => 'Whole foods market'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'box_title' => 'List of companies',
                'start_number' => 22,
                'sub_questions' => [
                    ['id' => '23', 'label' => 'The disposable waste', 'correct_answer' => 'C'],
                    ['id' => '24', 'label' => 'The way company purchases as goods', 'correct_answer' => 'C'],
                    ['id' => '25', 'label' => 'Helping the undeveloped', 'correct_answer' => 'A'],
                    ['id' => '26', 'label' => 'ensuring the people have the latest information', 'correct_answer' => 'B'],
                ]
            ],
            'order' => 3,
        ]);


        // --- PASSAGE 3 ---
        $passage3 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'The Exploration of Mars',
            'content' => '
<p><strong>A</strong></p>
<p>In 1877, Giovanni Schiaparelli, an Italian astronomer, made drawings and maps of the Martian surface that suggested strange features. The images from telescopes at this time were not as sharp as today. Schiaparelli said he could see a network of lines or canali. In 1894, an American astronomer, Percival Lowell, made a series of observations of Mars from his own observatory at Flagstaff, Arizona, USA. Lowell was convinced a great network of canals had been dug to irrigate crops for the Martian race! He suggested that each canal had fertile vegetation on either side, making them noticeable from Earth. Drawings and globes he made show a network of canals and oases all over the planet.</p>

<p><strong>B</strong></p>
<p>The idea that there was intelligent life on Mars gained strength in the late 19th century. In 1898, H.G. Wells wrote a science fiction classic, The War of the Worlds about an invading force of Martians who try to conquer Earth. They use highly advanced technology (advanced for 1898) to crush human resistance in their path. In 1917, Edgar Rice Burroughs wrote the first in a series of 11 novels about Mars. Strange beings and rampaging Martian monsters gripped the public’s imagination. A radio broadcast by Orson Welles on Halloween night in 1938 of The War of the Worlds caused widespread panic across America. People ran into the streets in their pyjamas-millions believed the dramatic reports of a Martian invasion.</p>

<p><strong>C</strong></p>
<p>Probes are very important to our understanding of other planets. Much of our recent knowledge comes from these robotic missions into space. The first images sent back from Mars came from Mariner 4 in July 1965. They showed a cratered and barren landscape, more like the surface of our moon than Earth. In 1969, Mariners 6 and 7 were launched and took 200 photographs of Mars’s southern hemisphere and pole on fly-by missions. But these showed little more information. In 1971, Mariner 9’s mission was to orbit the planet every 12 hours. In 1975, The USA sent two Viking probes to the planet, each with a lander and an orbiter. The Landers had sampler arms to scoop up Maritain rocks and did experiments to try and find signs of life. Although no life was found, they sent back the first colour pictures of the planet’s surface and atmosphere from pivoting cameras.</p>

<p><strong>D</strong></p>
<p>The Martian meteorite found in Earth aroused doubts to the above analysis. ALH84001 meteorite was discovered in December 1984 in Antarctica, by members of the ANSMET project; The sample was ejected from Mars about 17 million years ago and spent 11,000 years in or on the Antarctic ice sheets. Composition analysis by NASA revealed a kind of magnetite that on Earth, is only found in association with certain microorganisms. Some structures resembling the mineralized casts of terrestrial bacteria and their appendages fibrils of by-products occur in the rims of carbonate globules and pre-terrestrial aqueous alteration regions. The size and shape of the objects are consistent with Earthly fossilized nanobacteria, but the existence of nanobacteria itself is still controversial.</p>

<p><strong>E</strong></p>
<p>In 1965, the Mariner 4 probe discovered that Mars had no global magnetic field that would protect the planet from potentially life-threatening cosmic radiation and solar radiation; observations made in the late 1990s by the Mars Global Surveyor confirmed this discovery. Scientists speculate that the lack of magnetic shielding helped the solar wind blow away much of Mars’s atmosphere over the course of several billion years. After mapping cosmic radiation levels at various depths on Mars, researchers have concluded that any life within the first several meters of the planet’s surface would be killed by lethal doses of cosmic radiation. In 2007, it was calculated that DNA and RNA damage by cosmic radiation would limit life on Mars to depths greater than 7.5 metres below the planet’s surface. Therefore, the best potential locations for discovering life on Mars may be at subsurface environments that have not been studied yet. The disappearance of the magnetic field may be played a significant role in the process of Martian climate change. According to the valuation of the scientists, the climate of Mars gradually transits from warm and wet to cold and dry after magnetic field vanished.</p>

<p><strong>F</strong></p>
<p>NASA’s recent missions have focused on another question: whether Mars held lakes or oceans of liquid water on its surface in the ancient past. Scientists have found hematite, a mineral that forms in the presence of water. Thus, the mission of the Mars Exploration Rovers of 2004 was not to look for present or past life, but for evidence of liquid water on the surface of Mars in the planet’s ancient past. Liquid water, necessary for Earth life and for metabolism as generally conducted by species on Earth, cannot exist on the surface of Mars under its present low atmospheric pressure and temperature, except at the lowest shaded elevations for short periods and liquid water does not appear at the surface itself. In March 2004, NASA announced that its rover Opportunity had discovered evidence that Mars was, in the ancient past, a wet planet. This had raised hopes that evidence of past life might be found on the planet today. ESA confirmed that the Mars Express orbiter had directly detected huge reserves of water ice at Mars’ south pole in January 2004.</p>

<p><strong>G</strong></p>
<p>Researchers from the Center of Astrobiology (Spain) and the Catholic University of the North in Chile have found an ‘oasis’ of microorganisms two meters below the surface of the Atacama Desert, SOLID, a detector for signs of life which could be used in environments similar to subsoil on Mars. “We have named it a ‘microbial oasis’ because we found microorganisms developing in a habitat that was rich in rock salt and other highly hygroscopic compounds that absorb water” explained Victor Parro, a researcher from the Center of Astrobiology in Spain. “If there are similar microbes on Mars or remains in similar conditions to the ones we have found in the Atacama, we could detect them with instruments like SOLID” Parro highlighted.</p>

<p><strong>H</strong></p>
<p>Even more intriguing, however, is the alternative scenario by Spanish scientists: If those samples could be found to that use DNA, as Earthly life does, as their genetic code. It is extremely unlikely that such a highly specialised, complex molecule like DNA could have evolved separately on the two planets, indicating that there must be a common origin for Martian and Earthly life. Life-based on DNA first appeared on Mars and then spread to Earth, where it then evolved into the myriad forms of plants and creatures that exist today. If this was found to be the case, we would have to face the logical conclusion: we are all Martian. If not, we would continue to search the life of signs.</p>',
            'order' => 3,
        ]);

        // Questions 27-32: Matching Paragraph Information
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 27,
            'type' => 'matching_paragraph_information',
            'question_text' => 'Which paragraph contains the following information?<br>Write the correct letter A-H, in boxes 27-32 on your answer sheet.',
            'options' => [
                'A' => 'Paragraph A',
                'B' => 'Paragraph B',
                'C' => 'Paragraph C',
                'D' => 'Paragraph D',
                'E' => 'Paragraph E',
                'F' => 'Paragraph F',
                'G' => 'Paragraph G',
                'H' => 'Paragraph H',
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 26,
                'sub_questions' => [
                    ['id' => '27', 'label' => 'Martian evidence on Earth', 'correct_answer' => 'D'],
                    ['id' => '28', 'label' => 'Mars and Earth may share the same life origin', 'correct_answer' => 'H'],
                    ['id' => '29', 'label' => 'certain agricultural construction was depicted specifically', 'correct_answer' => 'A'],
                    ['id' => '30', 'label' => 'the project which aims to identify life under similar condition of Mars', 'correct_answer' => 'G'],
                    ['id' => '31', 'label' => 'Mars had experienced terrifying climate transformation', 'correct_answer' => 'E'],
                    ['id' => '32', 'label' => 'Attempts in scientific investigation to find liquid water', 'correct_answer' => 'F'],
                ]
            ],
            'order' => 1,
        ]);

        // Questions 33-36: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 33,
            'type' => 'multiple_choice',
            'question_text' => 'Choose the correct letter, A, B, C or D.<br>Write your answers in boxes 33-36 on your answer sheet.<br><br>How did Percival Lowell describe Mars in this passage?',
            'options' => [
                'A' => 'Perfect observation location is in Arizona.',
                'B' => 'Canals of Mars is broader than that of the earth.',
                'C' => 'Dedicated water and agriculture trace are similar to the earth.',
                'D' => 'Actively moving Martian lives are found by observation.'
            ],
            'correct_answer' => 'C',
            'explanation' => null,
            'data' => [
                'start_number' => 32,
                'sub_questions' => [
                    ['id' => '33', 'label' => 'How did Percival Lowell describe Mars in this passage?', 'correct_answer' => 'C']
                ]
            ],
            'order' => 2,
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 34,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'They experienced a Martian attack.',
                'B' => 'They learned knowledge of mars through some literature works.',
                'C' => 'They learned a new concept by listening to a famous radio program.',
                'D' => 'They attended lectures given by famous writers.'
            ],
            'correct_answer' => 'B',
            'explanation' => null,
            'data' => [
                'start_number' => 33,
                'sub_questions' => [
                    ['id' => '34', 'label' => 'How did people change their point of view towards Mars from the 19th century?', 'correct_answer' => 'B']
                ]
            ],
            'order' => 3,
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 35,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'It has a landscape full of rock and river',
                'B' => 'It was not as vivid as the earth',
                'C' => 'It contained the same substance as in the moon',
                'D' => 'It had different images from the following probes'
            ],
            'correct_answer' => 'B',
            'explanation' => null,
            'data' => [
                'start_number' => 34,
                'sub_questions' => [
                    ['id' => '35', 'label' => 'In the 1960s, which information is correct about Mars by a number of Probes sent to space?', 'correct_answer' => 'B']
                ]
            ],
            'order' => 4,
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 36,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'It could be employed to explore organisms under Martian condition.',
                'B' => 'This technology could NOT be used to identify life on similar condition of Mars.',
                'C' => 'Atacama Desert is the only place that has a suitable environment for organisms.',
                'D' => 'Life had not yet been found yet in the Atacama Desert.'
            ],
            'correct_answer' => 'A', // Answer key says A
            'explanation' => null,
            'data' => [
                'start_number' => 35,
                'sub_questions' => [
                    ['id' => '36', 'label' => 'What is the implication of the project proceeded by a technology called SOLID in the Atacama Desert?', 'correct_answer' => 'A']
                ]
            ],
            'order' => 5,
        ]);

        // Questions 37-40: True/False/Not Given
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 37,
            'type' => 'true_false_not_given',
            'question_text' => 'Do the following statements agree with the information given in Reading Passage 3?<br>In boxes 37-40 on your answer sheet, write',
            'options' => [
                'TRUE' => 'TRUE',
                'FALSE' => 'FALSE',
                'NOT GIVEN' => 'NOT GIVEN'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 36,
                'sub_questions' => [
                    ['id' => '37', 'label' => 'The technology of Martian creature was superior to what human had at that time in every field according to The War of the Worlds.', 'correct_answer' => 'NOT GIVEN'],
                    ['id' => '38', 'label' => 'Proof sent by Viking probes has not been challenged yet.', 'correct_answer' => 'FALSE'],
                    ['id' => '39', 'label' => 'Analysis of meteorite from Mars found a substance which is connected to some germs.', 'correct_answer' => 'TRUE'],
                    ['id' => '40', 'label' => 'According to Victor Parro, their project will be deployed on Mars after they identified DNA substance on earth.', 'correct_answer' => 'NOT GIVEN'],
                ]
            ],
            'order' => 6,
        ]);

    }
}
