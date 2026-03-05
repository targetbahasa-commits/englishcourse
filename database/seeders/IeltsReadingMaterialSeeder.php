<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IeltsReadingMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cleanup existing Material 1 and 7
        $existingPassages = \App\Models\IeltsReadingPassage::whereIn('material_id', [1, 7, 2, 8])->get();
        foreach ($existingPassages as $p) {
            $p->delete(); 
        }

        // Material 1
        $materialId = 1;

        // Passage 1: The Architecture of Silence
        $p1 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'The Architecture of Silence',
            'content' => '<p><strong>A</strong> Noise pollution is an increasingly omnipresent byproduct of modern urban life, yet its impact on human health remains dangerously underestimated. While sudden, loud sounds trigger an immediate \'fight or flight\' response, chronic exposure to low-level urban hums—traffic, air conditioning, and distant construction—exerts a sustained physiological toll. Research indicates that persistent noise elevates cortisol levels and contributes to cardiovascular distress. Consequently, architects and urban planners are beginning to prioritize \'acoustic comfort\' not as a luxury, but as a fundamental biological necessity for city dwellers.</p>
            <p><strong>B</strong> The challenge for modern designers lies in the limitations of traditional soundproofing. For decades, the standard approach was \'blocking\'—using thick, dense materials like concrete and lead to stop sound waves. However, in the era of sustainable architecture, these heavy materials are often impractical or environmentally costly. New research focuses on \'acoustic metamaterials,\' which are engineered to manipulate sound waves at a structural level. By using geometric patterns instead of raw mass, these materials can reflect or absorb specific frequencies, allowing for lightweight, breathable walls that offer superior silence.</p>
            <p><strong>C</strong> Beyond physical barriers, there is a growing interest in \'biophonic masking.\' This technique involves introducing natural sounds—such as falling water or rustling leaves—into urban spaces to cover unpleasant mechanical noise. Psychologically, humans find natural sounds less intrusive than synthetic ones, even at the same decibel level. By integrating fountains or wind-sensitive installations into plazas, designers can create a \'perceived\' sense of quiet. This shift from total silence to \'pleasant soundscapes\' represents a more nuanced understanding of how the human brain processes environmental information.</p>
            <p><strong>D</strong> The economic implications of acoustic design are also becoming clearer. Studies in corporate environments have shown that poor acoustics lead to a significant drop in employee productivity and an increase in absenteeism. In open-plan offices, the constant distraction of overheard conversations can reduce cognitive performance by up to 60%. Conversely, workplaces that invest in high-quality acoustic treatments report higher levels of staff retention and focus. As a result, \'quiet\' is increasingly being marketed as a premium feature in commercial real estate, driving up property values in noisy metropolitan hubs.</p>
            <p><strong>E</strong> Looking ahead, the future of urban silence may lie in \'active\' technologies similar to noise-canceling headphones but on a structural scale. \'Active Noise Control\' (ANC) systems use microphones to detect incoming sound and speakers to produce an \'anti-noise\' wave that cancels it out. While currently expensive and energy-intensive to implement in large buildings, advancements in smart-city infrastructure could eventually see these systems integrated into windows and facades. This would allow residents to keep their windows open to fresh air while electronically filtering out the roar of the city outside.</p>',
            'order' => 1
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p1->id,
            'question_number' => 1,
            'question_text' => 'The Reading Passage has five paragraphs, A–E. Choose the correct heading for each paragraph from the list of headings below.',
            'type' => 'matching_headings',
            'options' => [
                'i' => 'The financial benefits of acoustic investment',
                'ii' => 'The psychological advantage of natural soundscapes',
                'iii' => 'The physiological consequences of persistent noise',
                'iv' => 'A shift towards active electronic cancellation',
                'v' => 'The environmental cost of traditional building materials',
                'vi' => 'Innovative structural approaches to sound management',
                'vii' => 'The history of urban noise regulation',
            ],
            'correct_answer' => ['1a' => 'iii', '1b' => 'vi', '1c' => 'ii', '1d' => 'i', '1e' => 'iv'],
            'explanation' => 'A: iii (persistent noise elevates cortisol). B: vi (acoustic metamaterials, geometric patterns). C: ii (psychologically... natural sounds). D: i (economic implications, productivity). E: iv (active technologies, noise-canceling).',
            'data' => [
                'sub_questions' => [
                    ['id' => '1a', 'label' => 'Paragraph A', 'correct_answer' => 'iii'],
                    ['id' => '1b', 'label' => 'Paragraph B', 'correct_answer' => 'vi'],
                    ['id' => '1c', 'label' => 'Paragraph C', 'correct_answer' => 'ii'],
                    ['id' => '1d', 'label' => 'Paragraph D', 'correct_answer' => 'i'],
                    ['id' => '1e', 'label' => 'Paragraph E', 'correct_answer' => 'iv']
                ]
            ],
            'order' => 1
        ]);

        // Passage 2: The Evolutionary Purpose of Ritual
        $p2 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'The Evolutionary Purpose of Ritual',
            'content' => '<p><strong>A</strong> Ritualized behavior is a cross-cultural universal, observed in every human society from hunter-gatherer tribes to modern metropolitan civilizations. To a detached observer, many rituals—such as elaborate dance ceremonies or the repetitive chanting of mantras—may appear \'non-functional\' because they do not produce a direct material result like gathering food or building shelter. However, evolutionary anthropologists argue that these behaviors are far from purposeless. Instead, they serve as vital social glue, signaling an individual\'s commitment to a group and reducing the potential for internal conflict.</p>
            <p><strong>B</strong> One prominent theory suggests that rituals act as a \'costly signaling\' mechanism. In evolutionary biology, a signal is considered reliable only if it is difficult or \'costly\' to perform. For instance, a ritual that requires significant time, physical effort, or even pain serves as a badge of loyalty. By enduring these costs, participants demonstrate that their commitment to the community is genuine, making it harder for \'free-riders\'—individuals who take the benefits of the group without contributing—to infiltrate the social circle. This ensures that cooperation remains stable and trust is maintained.</p>
            <p><strong>C</strong> From a neurological perspective, collective rituals have a profound impact on the human endocrine system. Engaging in rhythmic, synchronized movements—such as marching or collective drumming—triggers the release of endorphins and oxytocin. These chemicals are known to enhance feelings of social bonding and empathy. This \'inter-brain synchrony\' allows participants to feel as though they are part of a single, larger organism. In the harsh environments of our ancestors, this heightened sense of unity provided a decisive survival advantage during tribal warfare or periods of resource scarcity.</p>
            <p><strong>D</strong> Rituals also play a crucial role in managing existential anxiety. Life is inherently unpredictable, filled with risks that are beyond human control, such as natural disasters or illness. Psychological studies have shown that in times of high stress, people tend to revert to repetitive, ritualized actions. These \'control-simulating\' behaviors provide a sense of order and predictability in a chaotic world. Even if the ritual does not change the external outcome, the internal psychological stability it provides allows individuals to remain functional and proactive rather than becoming paralyzed by fear.</p>
            <p><strong>E</strong> In the contemporary era, the form of rituals has shifted, but their underlying function persists. While traditional religious ceremonies may be declining in some secular societies, they are being replaced by \'secular rituals\' in sports, politics, and technology. The intense fervor of fans at a football stadium or the meticulously choreographed product launches in the tech industry mirror the structure of ancient rites. These modern iterations continue to satisfy the deep-seated human need for belonging and shared meaning, proving that the ritualistic brain is a permanent feature of our species.</p>',
            'order' => 2
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p2->id,
            'question_number' => 2,
            'question_text' => 'The Reading Passage has five paragraphs, A–E. Choose the correct heading for each paragraph from the list of headings below.',
            'type' => 'matching_headings',
            'options' => [
                'i' => 'The role of ritual in stress regulation',
                'ii' => 'The shift from religious to industrial ceremonies',
                'iii' => 'Ritual as a method to prevent social exploitation',
                'iv' => 'The biological rewards of synchronized action',
                'v' => 'The apparent lack of practical utility in rituals',
                'vi' => 'Rituals as a tool for geographical expansion',
                'vii' => 'The persistence of ritualistic structures in modern life',
            ],
            'correct_answer' => ['2a' => 'v', '2b' => 'iii', '2c' => 'iv', '2d' => 'i', '2e' => 'vii'],
            'explanation' => 'A: v (appear non-functional). B: iii (prevent free-riders/exploitation). C: iv (endorphins/synchronized action). D: i (managing anxiety/stress). E: vii (persistence/permanent feature).',
            'data' => [
                'start_number' => 5,
                'sub_questions' => [
                    ['id' => '2a', 'label' => 'Paragraph A', 'correct_answer' => 'v'],
                    ['id' => '2b', 'label' => 'Paragraph B', 'correct_answer' => 'iii'],
                    ['id' => '2c', 'label' => 'Paragraph C', 'correct_answer' => 'iv'],
                    ['id' => '2d', 'label' => 'Paragraph D', 'correct_answer' => 'i'],
                    ['id' => '2e', 'label' => 'Paragraph E', 'correct_answer' => 'vii']
                ]
            ],
            'order' => 1
        ]);


        $p3 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'Nature’s Blueprints: The Rise of Biomimicry',
            'content' => '<p><strong>A</strong> For centuries, human engineering has relied on \'brute force\' methods—using high heat, extreme pressure, and synthetic chemicals to manufacture materials. However, as the environmental cost of these processes becomes untenable, scientists are increasingly looking to biomimicry. This discipline involves studying nature’s time-tested patterns and strategies to solve 21st-century design challenges. Unlike traditional manufacturing, nature assembles complex structures at ambient temperatures and without toxic byproducts, offering a paradigm shift in how we conceive of \'innovation.\'</p>
            <p><strong>B</strong> One of the most celebrated examples is the study of the lotus leaf, which possesses a self-cleaning surface. On a microscopic level, the leaf is covered in tiny, wax-capped protrusions that prevent water droplets from adhering to the surface. Instead, water spheres roll off, carrying dirt particles with them. This \'lotus effect\' has been successfully replicated to create hydrophobic paints and glass surfaces for skyscrapers, significantly reducing the need for chemical detergents and labor-intensive maintenance in urban environments.</p>
            <p><strong>C</strong> Another breakthrough has emerged from the study of the Namib Desert beetle, which survives in one of the most arid regions on Earth. The beetle’s back features a unique arrangement of hydrophilic (water-attracting) bumps and hydrophobic (water-repelling) troughs. This allows it to capture moisture from morning fogs, which then trickles directly into its mouth. Engineers are now developing \'fog-harvesting\' nets based on this biological blueprint to provide clean drinking water for impoverished coastal communities where rainfall is scarce but humidity is high.</p>
            <p><strong>D</strong> Despite its potential, biomimicry faces significant hurdles in scaling from laboratory prototypes to industrial applications. Biological structures are often \'multifunctional,\' meaning a single surface might provide structural support, thermal regulation, and sensory input simultaneously. Replicating this level of integrated complexity using current 3D printing or chemical vapor deposition is extraordinarily difficult. Critics also point out that while nature is efficient, it operates on an evolutionary timescale of millions of years, whereas market demands require immediate results.</p>
            <p><strong>E</strong> The philosophical underpinning of biomimicry represents a move away from \'human exceptionalism\'—the idea that humans are separate from and superior to the natural world. Instead, it positions nature as a mentor rather than a mere warehouse of resources. By observing how a spider weaves silk that is stronger than steel yet flexible, or how coral reefs build massive calcium structures while sequestering carbon, we may find the keys to a \'regenerative\' economy that restores the planet rather than merely depleting it.</p>',
            'order' => 3
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p3->id,
            'question_number' => 3,
            'question_text' => 'The Reading Passage has five paragraphs, A–E. Choose the correct heading for each paragraph from the list of headings below.',
            'type' => 'matching_headings',
            'options' => [
                'i' => 'The challenge of imitating biological complexity',
                'ii' => 'A fundamental change in the human-nature relationship',
                'iii' => 'The failure of traditional engineering in arid climates',
                'iv' => 'A comparison between industrial and natural production',
                'v' => 'Utilizing biological textures for urban maintenance',
                'vi' => 'Harnessing atmospheric moisture through mimicry',
                'vii' => 'The role of evolution in modern chemical manufacturing',
            ],
            'correct_answer' => ['3a' => 'iv', '3b' => 'v', '3c' => 'vi', '3d' => 'i', '3e' => 'ii'],
            'explanation' => 'A: iv (brute force vs ambient temps). B: v (lotus effect/maintenance). C: vi (fog-harvesting/Namib beetle). D: i (hurdles/complexity). E: ii (move away from human exceptionalism).',
            'data' => [
                'start_number' => 11,
                'sub_questions' => [
                    ['id' => '3a', 'label' => 'Paragraph A', 'correct_answer' => 'iv'],
                    ['id' => '3b', 'label' => 'Paragraph B', 'correct_answer' => 'v'],
                    ['id' => '3c', 'label' => 'Paragraph C', 'correct_answer' => 'vi'],
                    ['id' => '3d', 'label' => 'Paragraph D', 'correct_answer' => 'i'],
                    ['id' => '3e', 'label' => 'Paragraph E', 'correct_answer' => 'ii']
                ]
            ],
            'order' => 1
        ]);

        // Passage 4: The Ethics of the Augmented Mind
        $p4 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'The Ethics of the Augmented Mind',
            'content' => '<p><strong>A</strong> Brain-Computer Interfaces (BCIs) were once the province of science fiction, but recent breakthroughs in neural engineering have brought them into the clinical mainstream. At its core, BCI technology establishes a direct communication pathway between the brain’s electrical signals and an external device, such as a robotic limb or a computer cursor. For individuals with locked-in syndrome or severe paralysis, these devices offer a radical restoration of autonomy. By bypassing damaged spinal cords, BCIs allow patients to re-engage with the world, proving that the boundary between biological thought and digital action is increasingly porous.</p>
            <p><strong>B</strong> However, as the technology migrates from restorative medicine to \'human enhancement,\' a host of neuroethical concerns has emerged. If a BCI can be used to restore lost motor function, could it also be used to augment the cognitive abilities of healthy individuals? The prospect of \'neural implants\' that enhance memory or processing speed raises the specter of a cognitive divide. In a society where mental performance can be purchased, the gap between the \'enhanced\' elite and the \'unaugmented\' majority could lead to a new form of systemic inequality, far more profound than wealth alone.</p>
            <p><strong>C</strong> A more subtle but equally troubling issue involves the concept of \'agency\' and moral responsibility. When a person operates a device through a BCI, the line between the user’s intent and the machine’s autonomous algorithms becomes blurred. If a robotic arm controlled by a BCI accidentally causes harm, is the user responsible, or was it a software malfunction? Current legal frameworks are ill-equipped to handle actions that originate in a hybrid of human thought and machine code, necessitating a complete re-evaluation of what it means to be a \'responsible actor.\'</p>
            <p><strong>D</strong> Data privacy also takes on a new dimension when the data being harvested is neural. Unlike traditional digital footprints, which track our external behaviors, BCIs have the potential to access \'brain-data\'—the raw signals of our subconscious reactions and emotions. Critics warn that without strict regulations, corporations could theoretically monitor a user\'s private thoughts or predispositions for marketing purposes. This \'neuro-surveillance\' represents the ultimate intrusion into the final frontier of privacy: the human mind.</p>
            <p><strong>E</strong> Despite these risks, proponents argue that the development of BCIs is an inevitable step in human evolution. They suggest that our current tools—smartphones and computers—already act as \'external brains,\' albeit with slow input methods like typing. BCIs simply eliminate the \'bottleneck\' of the physical body, allowing for a more seamless integration with the vast information networks we have created. From this perspective, the ethical hurdles are not reasons to halt progress, but rather parameters that must be carefully managed as we transition into a post-biological era.</p>',
            'order' => 4
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p4->id,
            'question_number' => 4,
            'question_text' => 'The Reading Passage has five paragraphs, A–E. Choose the correct heading for each paragraph from the list of headings below.',
            'type' => 'matching_headings',
            'options' => [
                'i' => 'The potential for a new era of social disparity',
                'ii' => 'The technical evolution from biology to digital tools',
                'iii' => 'A breakthrough in restoring independence to the disabled',
                'iv' => 'The difficulty of assigning blame in hybrid systems',
                'v' => 'The environmental impact of neural engineering',
                'vi' => 'The threat of unauthorized access to inner thoughts',
                'vii' => 'The inevitability of human-machine integration',
            ],
            'correct_answer' => ['4a' => 'iii', '4b' => 'i', '4c' => 'iv', '4d' => 'vi', '4e' => 'vii'],
            'explanation' => 'A: iii (restoration of autonomy). B: i (cognitive divide/inequality). C: iv (agency/responsibility). D: vi (privacy/neuro-surveillance). E: vii (inevitable step/integration).',
            'data' => [
                'start_number' => 16,
                'sub_questions' => [
                    ['id' => '4a', 'label' => 'Paragraph A', 'correct_answer' => 'iii'],
                    ['id' => '4b', 'label' => 'Paragraph B', 'correct_answer' => 'i'],
                    ['id' => '4c', 'label' => 'Paragraph C', 'correct_answer' => 'iv'],
                    ['id' => '4d', 'label' => 'Paragraph D', 'correct_answer' => 'vi'],
                    ['id' => '4e', 'label' => 'Paragraph E', 'correct_answer' => 'vii']
                ]
            ],
            'order' => 1
        ]);


        // Material 7
        $materialId = 7;

        // Passage 1: The Evolution of Biomimicry in Modern Engineering
        $p1 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'The Evolution of Biomimicry in Modern Engineering',
            'content' => '<p>The field of biomimicry—the practice of looking to nature for solutions to complex human problems—is not a new concept, but its application in high-tech engineering has reached unprecedented levels in recent years. Unlike traditional manufacturing, which often relies on \'brute force\' methods like high heat and toxic chemicals, nature produces intricate structures at ambient temperatures using life-friendly chemistry.</p>
            <p>One of the most remarkable breakthroughs in this field involves the study of the Kingfisher bird. For years, engineers in Japan faced a significant challenge with the Shinkansen, or \'bullet train.\' As the train emerged from narrow tunnels at high speeds, it created a thunderous \'sonic boom\' due to the sudden change in air pressure, causing severe noise pollution in residential areas. The solution was found by Eiji Nakatsu, an engineer and birdwatcher, who noticed the Kingfisher’s beak. The bird is capable of diving from the air into water with very little splash, thanks to its wedge-shaped beak which allows for a smooth transition between different mediums. By redesigning the nose of the bullet train to mimic the Kingfisher’s beak, engineers not only eliminated the noise problem but also increased the train\'s efficiency and reduced electricity consumption.</p>
            <p>In the realm of architecture, the Eastgate Centre in Zimbabwe stands as a testament to biological inspiration. Architect Mick Pearce avoided using a conventional, energy-heavy air conditioning system by studying the structural design of termite mounds. These mounds maintain a constant internal temperature despite extreme external fluctuations. By using a series of chimneys that naturally draw in cool air at night and vent hot air during the day, the building remains comfortable while using 90% less energy than a standard building of its size.</p>',
            'order' => 1
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p1->id,
            'question_number' => 1,
            'question_text' => '',
            'type' => 'summary_completion',
            'options' => null, // No options for this one
            'correct_answer' => null, // TODO: Add correct answers structurally if needed, but summary completion usually embedded or specific
            'explanation' => '1: bruteforce, 2: sonic boom, 3: noise pollution, 4: beak, 5: electricity, 6: termite mounds',
            'data' => [
                'box_title' => 'Nature as a Solution for Engineering',
                'instruction' => 'Complete the summary below. Choose NO MORE THAN TWO WORDS from the passage for each answer.',
                'summary_text' => 'While human manufacturing often involves [1] and harmful chemicals, biomimicry focuses on natural, sustainable processes. A famous example is the Japanese bullet train, which originally produced a [2] whenever it exited a tunnel. This resulted in [3] that disturbed people living nearby.<br><br>By observing the [4] of a Kingfisher, engineers modified the train’s design. This change successfully stopped the loud sounds and lowered the amount of [5] the train used. Similarly, in Zimbabwe, an architect utilized the design of [6] to create a natural cooling system for a large building, significantly reducing its reliance on traditional air conditioning.',
                'placeholders' => [
                    '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6
                ]
            ],
            'order' => 1
        ]);

        // Passage 2: The Science of Vertical Farming
        $p2 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'The Science of Vertical Farming',
            'content' => '<p>By the year 2050, nearly 80% of the Earth\'s population is expected to reside in urban centers. To feed this burgeoning population, traditional agriculture would require an estimated landmass 20% larger than the entire territory of Brazil. With arable land becoming a scarce resource due to climate change and urban expansion, scientists are turning to vertical farming as a sustainable alternative. This method involves cultivating crops in stacked layers, often within controlled indoor environments such as repurposed warehouses or shipping containers.</p>
            <p>Vertical farms utilize hydroponic or aeroponic systems, which deliver nutrients directly to the roots without the need for soil. Because these environments are entirely enclosed, they are not subject to the unpredictability of weather patterns, allowing for year-round production. Furthermore, these systems are remarkably efficient; they consume approximately 95% less water than conventional farming by recycling every drop within a closed-loop system. The absence of natural pests in these sterilized facilities also eliminates the requirement for chemical pesticides, resulting in cleaner, organic-grade produce.</p>
            <p>However, the primary obstacle to widespread adoption is energy consumption. Vertical farms rely heavily on artificial LED lighting to simulate the solar spectrum. While LED technology has become more efficient, the electricity costs associated with powering these lights 24 hours a day can be prohibitive. Critics argue that unless these facilities are powered by renewable energy sources, their carbon footprint might actually exceed that of traditional farms, despite the reduced transportation distances to urban markets.</p>',
            'order' => 2
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p2->id,
            'question_number' => 2,
            'question_text' => '',
            'type' => 'summary_completion',
            'options' => null, // Box options are in data
            'correct_answer' => null,
            'explanation' => '7: G (shortage), 8: C (enclosed), 9: A (predictable), 10: E (reduction), 11: I (pest-free), 12: B (cost)',
            'data' => [
                'box_title' => 'A Sustainable Shift in Food Production',
                'instruction' => 'Complete the summary using the list of words, A–I, below.',
                'summary_text' => 'As the global population becomes more concentrated in cities, there is a significant [7] of land suitable for traditional farming. Vertical farming offers a solution by growing plants in [8] structures. One of the main benefits of this method is its [9] nature, as it is unaffected by external climate conditions.<br><br>These farms use advanced irrigation techniques that result in a massive [10] in water usage. Moreover, because the environment is [11], farmers do not need to use toxic substances to protect their crops. Despite these advantages, the high [12] of maintaining artificial light remains a major challenge for the industry.',
                'placeholders' => [
                    '7' => 7, '8' => 8, '9' => 9, '10' => 10, '11' => 11, '12' => 12
                ],
                // Box options for Summary Completion (with box)
                'box_options' => [
                    'A' => 'predictable',
                    'B' => 'cost',
                    'C' => 'enclosed',
                    'D' => 'organic',
                    'E' => 'reduction',
                    'F' => 'variety',
                    'G' => 'shortage',
                    'H' => 'traditional',
                    'I' => 'pest-free'
                ]
            ],
            'order' => 1
        ]);

        // Passage 3: The Psychology of Choice Architecture in Retail
        $p3 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'The Psychology of Choice Architecture in Retail',
            'content' => '<p>In the competitive world of retail, the way products are displayed is rarely accidental. Marketers employ a strategy known as \'choice architecture\' to influence consumer behavior without explicitly restricting their options. One common technique is the \'decoy effect.\' This occurs when a third, less attractive option is introduced to make one of the other two choices seem more valuable. For instance, if a customer is choosing between a small coffee for $3 and a large one for $7, they might choose the smaller one. However, by adding a \'medium\' option for $6.50—which is only slightly cheaper than the large—the large coffee suddenly appears to be a much better deal, leading to an increase in its sales.</p>
            <p>Another psychological tool is \'anchor pricing.\' When a consumer sees a high price first, their brain uses that number as a mental benchmark, or \'anchor,\' for all subsequent evaluations. Retailers often display a \'suggested retail price\' (SRP) next to a discounted price. Even if the SRP is artificially inflated, the discount feels more significant because the consumer\'s perception is anchored to the higher initial figure. This creates a sense of urgency and perceived savings that might not exist in a more transparent market.</p>
            <p>The physical layout of a store also plays a crucial role. Most supermarkets are designed to maximize \'dwell time\'—the amount of time a customer spends in the building. Essential items like bread and milk are typically placed at the very back of the store. This forces customers to navigate through multiple aisles filled with high-margin \'impulse\' goods, such as snacks or luxury items, increasing the likelihood of unplanned purchases. By controlling the flow of traffic, retailers can manipulate the consumer\'s journey to ensure maximum exposure to their most profitable stock.</p>',
            'order' => 3
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p3->id,
            'question_number' => 3,
            'question_text' => '',
            'type' => 'summary_completion',
            'options' => null,
            'correct_answer' => null,
            'explanation' => '1: less attractive option, 2: better deal, 3: high price, 4: significant discount, 5: layout, 6: essential items', 
            'data' => [
                'box_title' => 'Strategic Marketing in Retail',
                'instruction' => 'Complete the summary below. Choose NO MORE THAN TWO WORDS from the passage for each answer.',
                'summary_text' => 'Retailers use a method called \'choice architecture\' to guide customers. One specific approach is the \'decoy effect,\' where an additional, [1] is used to make a different product look like a [2]. This effectively shifts the customer\'s preference toward a more expensive item.<br><br>Another common tactic is \'anchor pricing.\' In this case, a [3] is presented first to act as a reference point. This makes a lower price seem like a [4] even if the original price was not realistic. Finally, the internal [5] of a supermarket is designed to increase \'dwell time.\' By putting [6] at the back of the shop, retailers ensure that people pass by many other products, which often leads to spontaneous buying.',
                'placeholders' => [
                    '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6
                ]
            ],
            'order' => 1
        ]);

        // Passage 4: The Physics of Thrills: Engineering the Modern Roller Coaster
        $p4 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'The Physics of Thrills: Engineering the Modern Roller Coaster',
            'content' => '<p>The heart of a roller coaster’s excitement lies not in its speed, but in the clever manipulation of gravitational potential energy and kinetic energy. Most roller coasters do not have engines; instead, they are pulled up a \'lift hill\' by a motorized chain. As the train ascends, it accumulates potential energy based on its height. Once it reaches the summit and begins its descent, this stored energy is rapidly converted into kinetic energy, providing the momentum required to complete the entire circuit.</p>
            <p>A crucial aspect of the rider’s experience is the sensation of \'g-forces.\' When a coaster enters a sharp curve or a loop, the change in direction creates centripetal force, which pushes the rider’s body against the seat. This can result in \'positive g-forces,\' making the rider feel much heavier than usual. Conversely, as the train crests a hill at high speed, it creates \'negative g-forces\' or \'airtime,\' where the rider feels a momentary sensation of weightlessness as they are lifted out of their seat. Engineers must carefully calculate these forces to ensure they are thrilling but remain within the limits of human physiological endurance.</p>
            <p>Safety in modern coasters is managed through complex braking systems. Most contemporary designs utilize magnetic brakes rather than friction-based ones. These systems use powerful magnets on the track to induce \'eddy currents\' in metal fins attached to the train. This interaction creates a silent, smooth deceleration without any physical contact between parts, significantly reducing mechanical wear and tear. Furthermore, a \'block system\' is employed, dividing the track into sections that only allow one train at a time, preventing the possibility of mid-track collisions.</p>',
            'order' => 4
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p4->id,
            'question_number' => 4,
            'question_text' => '',
            'type' => 'summary_completion',
            'options' => null,
            'correct_answer' => null,
            'explanation' => '1: engines, 2: potential energy, 3: centripetal force, 4: weightlessness, 5: magnetic brakes, 6: physical contact/friction',
            'data' => [
                'box_title' => 'How Roller Coasters Work',
                'instruction' => 'Complete the summary below. Choose NO MORE THAN TWO WORDS from the passage for each answer.',
                'summary_text' => 'Unlike most vehicles, a roller coaster typically lacks [1] and relies on energy transformation. During the initial climb, the train builds up [2], which later turns into the motion needed to finish the track.<br><br>As the train moves through turns, passengers experience [3], which is responsible for the feeling of increased weight. On the other hand, \'airtime\' occurs at the top of hills, giving a brief feeling of [4]. To ensure safety, modern coasters use [5] to slow down. This technology is preferred because it avoids [6] and lasts longer than older friction brakes. Additionally, the \'block system\' ensures that trains remain separated at all times.',
                'placeholders' => [
                    '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6
                ]
            ],
            'order' => 1
        ]);
        
        // Material 8
        $materialId = 8;

        // Passage 1: The Urban Forestry Revolution
        $p1 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'The Urban Forestry Revolution',
            'content' => '<p><strong>The Urban Forestry Revolution</strong></p>
            <p>As cities become denser and the effects of climate change more pronounced, the concept of the \'urban forest\' has moved from a niche aesthetic preference to a central pillar of urban planning. Urban forestry involves the management of all tree populations within a city, from those in large public parks to individual trees lining residential streets.</p>
            <p>While the visual appeal of greenery is undeniable, the ecological and economic benefits are far more significant. One of the most critical roles of urban trees is the mitigation of the \'urban heat island\' effect.</p>
            <p>Dark surfaces like asphalt and concrete absorb vast amounts of solar radiation, causing city temperatures to be several degrees higher than surrounding rural areas. Trees counteract this by providing shade and through a process called evapotranspiration.</p>
            <p>This natural cooling mechanism functions similarly to human sweating; as trees release water vapor from their leaves, the surrounding air temperature drops.</p>
            <p>Consequently, cities with high canopy coverage report substantial reductions in the energy required for mechanical air conditioning. Beyond temperature control, urban forests act as a sophisticated filtration system for stormwater.</p>
            <p>In traditional urban environments, rain falls on impermeable surfaces and flows directly into sewer systems, often carrying pollutants and causing flash floods. A well-placed tree intercepting rainfall with its leaves and bark can significantly slow the movement of water. Furthermore, the root systems of urban trees increase soil permeability, allowing the earth to act as a natural sponge.</p>
            <p>This decentralized approach to water management reduces the burden on aging municipal infrastructure and protects local waterways from contamination. Despite these advantages, the survival of urban trees is often compromised by the harsh conditions of the \'concrete jungle.\' Soil compaction, limited rooting space, and exposure to road salt can lead to premature tree death.</p>
            <p>To address this, some cities are implementng \'structural soil\'—a mix of crushed stone and soil that provides both the structural support needed for pavements and the aeration required for root growth. By treating trees as \'green infrastructure\' rather than merely decorative elements, urban planners are ensuring that the cities of the future remain habitable.</p>',
            'order' => 1
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p1->id,
            'question_number' => 1,
            'question_text' => 'Questions 1–5<br>Complete each sentence with the correct ending, A–G, below.<br>Write the correct letter, A–G, in boxes 1–5 on your answer sheet.',
            'type' => 'matching_sentence_endings',
            'options' => [
                'A' => 'helps to lower the costs associated with cooling buildings.',
                'B' => 'mimics a biological cooling effect found in humans.',
                'C' => 'increases the risk of contamination in local waterways.',
                'D' => 'has evolved into a vital component of modern city design.',
                'E' => 'improves the ground’s ability to absorb excess rainwater.',
                'F' => 'provides a way for roots to thrive under heavy pavement.',
                'G' => 'is primarily focused on the aesthetic beauty of the streets.'
            ],
            'correct_answer' => ['1' => 'D', '2' => 'B', '3' => 'A', '4' => 'E', '5' => 'F'],
            'explanation' => '1: D (central pillar of urban planning), 2: B (mimics human sweating), 3: A (reductions in energy for AC), 4: E (increase soil permeability/sponge), 5: F (structural soil/aeration)',
            'data' => [
                'box_title' => 'List of Endings',
                'sub_questions' => [
                    ['id' => '1', 'label' => 'The strategic management of tree populations in metropolitan areas ............', 'correct_answer' => 'D'],
                    ['id' => '2', 'label' => 'The process of evapotranspiration in urban trees ............', 'correct_answer' => 'B'],
                    ['id' => '3', 'label' => 'The presence of large canopy coverage in a city ............', 'correct_answer' => 'A'],
                    ['id' => '4', 'label' => 'The complex root systems of trees in urban environments ............', 'correct_answer' => 'E'],
                    ['id' => '5', 'label' => 'The use of \'structural soil\' in city planning ............', 'correct_answer' => 'F']
                ]
            ],
            'order' => 1
        ]);

        // Passage 2: The Myth of Multitasking
        $p2 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'The Myth of Multitasking',
            'content' => '<p><strong>The Myth of Multitasking</strong></p>
            <p>In the modern digital workplace, the ability to \'multitask\' is often celebrated as a necessary skill for productivity. However, cognitive scientists argue that the human brain is not architecturally designed to process multiple, attention-demanding tasks simultaneously. Instead of performing tasks in parallel, the brain engages in \'context switching\'—a rapid toggling of focus from one activity to another. While this transition may feel instantaneous, it imposes a significant \'switching cost\' on the prefrontal cortex, the area of the brain responsible for executive function and goal-setting.</p>
            <p>Research conducted at Stanford University has shown that individuals who identify as \'heavy multitaskers\' actually perform worse in filtering out irrelevant information compared to those who prefer to focus on a single task. This is because constant switching prevents the brain from entering a \'flow state\'—a period of deep immersion where complex problem-solving occurs. Furthermore, the frequent interruption caused by digital notifications triggers the release of dopamine, the brain\'s reward chemical. This creates a \'feedback loop\' that makes the brain crave more distractions, ultimately reducing the individual\'s ability to maintain sustained concentration on long-term goals.</p>
            <p>The long-term implications of chronic multitasking may also extend to emotional intelligence. Some neuroscientists suggest that the rapid-fire nature of digital interaction discourages the \'slow\' thinking required for empathy and social reflection. When the brain is constantly overloaded with superficial data, it lacks the cognitive resources to process the nuanced emotional cues of others. To combat this, some organizations are implementing \'monotasking\' periods—designated times of the day where all digital communication is disabled to allow employees to engage in deep, uninterrupted labor.</p>',
            'order' => 2
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p2->id,
            'question_number' => 2,
            'question_text' => 'Questions 6–10<br>Complete each sentence with the correct ending, A–G, below.<br>Write the correct letter, A–G, in boxes 6–10 on your answer sheet.',
            'type' => 'matching_sentence_endings',
            'options' => [
                'A' => 'results in a chemical reaction that encourages further interruptions.',
                'B' => 'improves the brain\'s ability to filter out unnecessary data.',
                'C' => 'involves a rapid shift in focus rather than true simultaneous processing.',
                'D' => 'limits the mental energy available for understanding the feelings of others.',
                'E' => 'is designed to provide a space for intense, focused work.',
                'F' => 'places an unnecessary burden on the brain\'s executive control center.',
                'G' => 'increases the speed at which individuals reach a state of deep immersion.'
            ],
            'correct_answer' => ['6' => 'F', '7' => 'C', '8' => 'A', '9' => 'D', '10' => 'E'],
            'explanation' => '6: F (unnecessary burden on executive control center), 7: C (rapid shift in focus), 8: A (chemical reaction encourages interruptions), 9: D (limits mental energy for feelings of others), 10: E (space for intense focused work)',
            'data' => [
                'box_title' => 'List of Endings',
                'sub_questions' => [
                    ['id' => '6', 'label' => 'The human brain’s attempt to handle several complex activities at once ............', 'correct_answer' => 'F'],
                    ['id' => '7', 'label' => 'The constant transition between different work contexts ............', 'correct_answer' => 'C'],
                    ['id' => '8', 'label' => 'The brain\'s habit of responding to digital alerts ............', 'correct_answer' => 'A'],
                    ['id' => '9', 'label' => 'A continuous state of cognitive overload ............', 'correct_answer' => 'D'],
                    ['id' => '10', 'label' => 'The practice of \'monotasking\' in the workplace ............', 'correct_answer' => 'E']
                ]
            ],
            'order' => 1
        ]);

        // Passage 3: The Vanishing Night: The Global Impact of Light Pollution
        $p3 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'The Vanishing Night: The Global Impact of Light Pollution',
            'content' => '<p>For most of human history, the night sky was a source of wonder, navigation, and spiritual inspiration. However, the rapid expansion of artificial lighting has resulted in a phenomenon known as \'skyglow,\' where the haze of electric light from cities obscures our view of the cosmos. This form of environmental degradation, known as light pollution, is not merely an aesthetic loss for stargazers; it has profound ecological and physiological consequences that scientists are only beginning to quantify.</p>
            <p>One of the most significant impacts of excessive artificial light is the disruption of the circadian rhythm in both humans and animals. This internal biological clock, which regulates sleep-wake cycles and the release of hormones like melatonin, is highly sensitive to blue-wavelength light. When the sky remains bright throughout the night, the production of melatonin is suppressed, which researchers have linked to an increased risk of chronic sleep disorders and metabolic diseases. Furthermore, nocturnal animals are particularly vulnerable; for instance, sea turtle hatchlings, which rely on the natural glow of the horizon to find the ocean, are frequently disoriented by the harsh glare of coastal streetlights, leading them toward dangerous roads instead of the sea.</p>
            <p>To address this, astronomers and environmentalists are advocating for \'dark sky\' initiatives. These programs encourage cities to adopt \'full-cutoff\' light fixtures, which direct light downward toward the ground rather than upward into the atmosphere. By utilizing warmer-toned LEDs and implementing motion sensors, urban areas can significantly reduce their light footprint without compromising public safety. International Dark Sky Reserves are now being established in remote locations to preserve the few remaining areas where the Milky Way is still visible, serving as a reminder of the environmental heritage that is being erased by modern industrialization.</p>',
            'order' => 3
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p3->id,
            'question_number' => 3,
            'question_text' => 'Questions 11–15<br>Complete each sentence with the correct ending, A–G, below.<br>Write the correct letter, A–G, in boxes 11–15 on your answer sheet.',
            'type' => 'matching_sentence_endings',
            'options' => [
                'A' => 'encourages the production of essential sleep hormones.',
                'B' => 'ensures that light is focused only where it is needed on the ground.',
                'C' => 'causes young marine animals to move in the wrong direction.',
                'D' => 'is primarily designed to improve public safety in large cities.',
                'E' => 'acts as a way to protect regions that still have naturally dark nights.',
                'F' => 'depends on periods of darkness to function correctly.',
                'G' => 'prevents the majority of people from seeing stars in the night sky.'
            ],
            'correct_answer' => ['11' => 'G', '12' => 'F', '13' => 'C', '14' => 'B', '15' => 'E'],
            'explanation' => '11: G (skyglow obscures view of cosmos), 12: F (circadian rhythm depends on darkness), 13: C (sea turtles disoriented), 14: B (full-cutoff fixtures direct light downward), 15: E (Dark Sky Reserves preserve areas)',
            'data' => [
                'box_title' => 'List of Endings',
                'sub_questions' => [
                    ['id' => '11', 'label' => 'The widespread use of artificial lighting in urban environments ............', 'correct_answer' => 'G'],
                    ['id' => '12', 'label' => 'The human body’s internal biological clock ............', 'correct_answer' => 'F'],
                    ['id' => '13', 'label' => 'The presence of bright artificial light along coastlines ............', 'correct_answer' => 'C'],
                    ['id' => '14', 'label' => 'The installation of \'full-cutoff\' light fixtures ............', 'correct_answer' => 'B'],
                    ['id' => '15', 'label' => 'The creation of International Dark Sky Reserves ............', 'correct_answer' => 'E']
                ]
            ],
            'order' => 1
        ]);

        // Passage 4: The Future of Protein: Cultivated Meat
        $p4 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'The Future of Protein: Cultivated Meat',
            'content' => '<p>The global livestock industry is one of the largest contributors to greenhouse gas emissions, land degradation, and water scarcity. To address these environmental pressures, a new field of cellular agriculture has emerged, aiming to produce \'cultivated\' or \'lab-grown\' meat. Unlike plant-based substitutes that mimic the taste of meat using soy or pea protein, cultivated meat is biologically identical to animal tissue. It is produced by harvesting a small sample of stem cells from a living animal and placing them in a bioreactor—a vessel that provides the warmth, oxygen, and nutrients necessary for the cells to multiply and differentiate into muscle and fat.</p>
            <p>Proponents of this technology argue that it offers a far more efficient way to feed a growing global population. Traditional cattle farming requires vast amounts of grain and water to produce a single kilogram of beef, a process that is inherently caloric-inefficient. In contrast, cultivated meat can be produced in a fraction of the time and space, with significantly lower environmental overhead. Furthermore, because the production occurs in a sterile, controlled environment, the risks of foodborne illnesses and the need for antibiotics—common in industrial factory farms—are virtually eliminated.</p>

            <p>However, the transition from laboratory prototypes to supermarket shelves faces significant hurdles. The primary challenge is \'scaling up\'—the ability to produce meat in massive quantities at a competitive price. Currently, the growth media used to nourish the cells is expensive, and the energy required to maintain bioreactors at large scales could offset some of the environmental gains if not sourced from renewables. Moreover, consumer acceptance remains a wildcard. Surveys suggest that many people feel a \'disgust response\' to the idea of lab-grown tissue, viewing it as \'unnatural.\' For cultivated meat to become a staple of the human diet, scientists and marketers must not only lower production costs but also bridge the psychological gap between high-tech innovation and culinary tradition.</p>',
            'order' => 4
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p4->id,
            'question_number' => 4,
            'question_text' => 'Questions 16–20<br>Complete each sentence with the correct ending, A–G, below.<br>Write the correct letter, A–G, in boxes 16–20 on your answer sheet.',
            'type' => 'matching_sentence_endings',
            'options' => [
                'A' => 'results in a product that is fundamentally different from real animal tissue.',
                'B' => 'currently prevents the technology from being affordable for most consumers.',
                'C' => 'provides the essential components for the growth of muscle and fat cells.',
                'D' => 'often involves the heavy use of medication to prevent disease.',
                'E' => 'acts as a barrier to the public\'s willingness to eat these products.',
                'F' => 'allows for the creation of meat without the need for traditional slaughter.',
                'G' => 'reduces the amount of energy required to operate large-scale facilities.'
            ],
            'correct_answer' => ['16' => 'C', '17' => 'F', '18' => 'D', '19' => 'B', '20' => 'E'],
            'explanation' => '16: C (bioreactor provides essential components), 17: F (stem cells allow meat without slaughter), 18: D (factory farming involves medication), 19: B (expensive growth media prevents affordability), 20: E (perception of artificiality barrier to willingness)',
            'data' => [
                'box_title' => 'List of Endings',
                'sub_questions' => [
                    ['id' => '16', 'label' => 'The production of cultivated meat in a bioreactor ............', 'correct_answer' => 'C'],
                    ['id' => '17', 'label' => 'The use of stem cells in cellular agriculture ............', 'correct_answer' => 'F'],
                    ['id' => '18', 'label' => 'Industrial factory farming methods ............', 'correct_answer' => 'D'],
                    ['id' => '19', 'label' => 'The high cost of specialized growth media ............', 'correct_answer' => 'B'],
                    ['id' => '20', 'label' => 'A widespread perception that lab-grown meat is artificial ............', 'correct_answer' => 'E']
                ]
            ],
            'order' => 1
        ]);

        // Material 9
        $p9 = \App\Models\IeltsReadingPassage::create([
            'material_id' => 9,
            'title' => 'The Resilience of the Tardigrade',
            'content' => '<p>In the realm of extreme biology, few organisms possess the extraordinary survival capabilities of the tardigrade. Often referred to as \'water bears\' due to their slow, lumbering gait and eight-legged appearance, these microscopic invertebrates are found in virtually every corner of the globe, from the frigid peaks of the Himalayas to the crushing depths of the Atlantic Ocean. While most life forms require a stable environment to thrive, tardigrades have mastered the art of survival in conditions that would be instantaneous death for almost any other creature.</p>
            <p>The secret to their resilience lies in a physiological state known as cryptobiosis. When faced with extreme environmental stress, such as severe dehydration, the tardigrade undergoes a remarkable transformation. It retracts its head and legs, curling into a dried-out, ball-like structure called a \'tun\'. During this process, the organism expels almost all the water from its body and replaces it with a unique type of sugar known as trehalose. This sugar forms a glass-like solid that protects the tardigrade’s internal cellular membranes and DNA from being damaged.</p>
            <p>In this dormant \'tun\' state, tardigrades become nearly indestructible. Researchers have exposed them to temperatures as low as -272°C—just a fraction above absolute zero—and as high as 150°C. They can withstand pressures six times greater than those found in the deepest ocean trenches and, perhaps most surprisingly, can survive the vacuum of outer space. In 2007, thousands of tardigrades were launched into orbit on the FOTON-M3 mission; when returned to Earth and rehydrated, the majority of them were successfully revived, proving that solar radiation and a lack of oxygen were no match for these microscopic survivors.</p>',
            'order' => 1
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p9->id,
            'question_number' => 1,
            'question_text' => 'Questions 1–6<br>Complete the sentences below.<br>Choose NO MORE THAN TWO WORDS from the passage for each answer.',
            'type' => 'sentence_completion',
            'data' => [
                'summary_text' => '<div class="space-y-6">
                    <div class="flex gap-3 text-lg leading-relaxed"><span class="font-bold min-w-[20px]">1.</span> <div>Tardigrades are commonly known as [1] because of the way they move and their physical look.</div></div>
                    <div class="flex gap-3 text-lg leading-relaxed"><span class="font-bold min-w-[20px]">2.</span> <div>The tardigrade can endure environments that are usually considered [2] to other living things.</div></div>
                    <div class="flex gap-3 text-lg leading-relaxed"><span class="font-bold min-w-[20px]">3.</span> <div>In order to survive harsh conditions, the tardigrade enters a state called [3].</div></div>
                    <div class="flex gap-3 text-lg leading-relaxed"><span class="font-bold min-w-[20px]">4.</span> <div>When a tardigrade becomes a \'tun\', it uses a [4] to act as a protective layer for its cells and genetic material.</div></div>
                    <div class="flex gap-3 text-lg leading-relaxed"><span class="font-bold min-w-[20px]">5.</span> <div>In laboratory tests, these organisms survived temperatures that were only slightly higher than [5].</div></div>
                    <div class="flex gap-3 text-lg leading-relaxed"><span class="font-bold min-w-[20px]">6.</span> <div>The 2007 space mission demonstrated that tardigrades could be [6] even after being exposed to the conditions of a vacuum.</div></div>
                </div>',
                'placeholders' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6]
            ],
            'correct_answer' => [
                '1' => 'water bears',
                '2' => 'instantaneous death',
                '3' => 'cryptobiosis',
                '4' => 'unique type of sugar',
                '5' => 'absolute zero',
                '6' => 'successfully revived'
            ],
            'explanation' => '1: water bears (para 1), 2: instantaneous death (para 1), 3: cryptobiosis (para 2), 4: unique type of sugar (para 2), 5: absolute zero (para 3), 6: successfully revived (para 3)',
            'order' => 1
        ]);

        $p9_2 = \App\Models\IeltsReadingPassage::create([
            'material_id' => 9,
            'title' => 'The Avian Compass: Secrets of Bird Migration',
            'content' => '<p>Every year, billions of birds undertake arduous journeys spanning thousands of kilometers, navigating with a precision that rivals modern satellite technology. For decades, the mechanism behind this extraordinary feat of orientation remained one of biology\'s greatest enigmas. Recent breakthroughs in biophysics suggest that birds do not rely on a single sense, but rather a sophisticated multi-modal navigation system that utilizes the Earth’s magnetic field, celestial cues, and even olfactory maps.</p>
            <p>A leading theory focuses on a process called magnetoreception. Scientists have discovered that certain species, such as the European Robin, possess specialized proteins in their eyes known as cryptochromes. These proteins are sensitive to blue light and are believed to trigger quantum reactions that allow birds to effectively \'see\' the Earth’s magnetic field lines as patterns of light or shadow. This biological compass provides the birds with their primary sense of direction, helping them maintain a consistent heading over trackless oceans and vast forests.</p>
            <p>However, the magnetic compass is only one part of the puzzle. During the day, birds utilize the sun as a secondary reference point, adjusting their flight paths based on the time of day using their internal circadian clock. At night, nocturnal migrants switch to a stellar compass, memorizing the rotation of constellations around the North Star to determine their position. Interestingly, younger birds appear to learn these celestial patterns during their first few weeks of life, suggesting that migratory expertise is a combination of innate instinct and environmental learning.</p>
            <p>Furthermore, research indicates that as birds approach their final destination, they switch from large-scale magnetic guidance to more localized cues. This is where the \'olfactory hypothesis\' comes into play. By detecting minute concentrations of atmospheric chemicals and scents carried by the wind, birds can identify specific landmarks or nesting sites with remarkable accuracy. This \'smell-map\' allows them to return to the exact same tree or cliffside year after year, completing a journey that began half a world away.</p>',
            'order' => 2
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p9_2->id,
            'question_number' => 1,
            'question_text' => 'Questions 1–6<br>Complete the sentences below.<br>Choose NO MORE THAN TWO WORDS from the passage for each answer.',
            'type' => 'sentence_completion',
            'data' => [
                'summary_text' => '<div class="space-y-6">
                    <div class="flex gap-3 text-lg leading-relaxed"><span class="font-bold min-w-[20px]">1.</span> <div>Modern research indicates that birds use a navigation system that is described as [1] because it involves multiple senses.</div></div>
                    <div class="flex gap-3 text-lg leading-relaxed"><span class="font-bold min-w-[20px]">2.</span> <div>The presence of [2] in the eyes of some birds may allow them to visualize magnetic fields.</div></div>
                    <div class="flex gap-3 text-lg leading-relaxed"><span class="font-bold min-w-[20px]">3.</span> <div>Birds can keep a [3] even when flying over areas without any visible landmarks.</div></div>
                    <div class="flex gap-3 text-lg leading-relaxed"><span class="font-bold min-w-[20px]">4.</span> <div>To use the sun for navigation, birds must coordinate their flight with a biological [4].</div></div>
                    <div class="flex gap-3 text-lg leading-relaxed"><span class="font-bold min-w-[20px]">5.</span> <div>Younger birds need to spend time [5] the movement of stars to develop their navigational skills.</div></div>
                    <div class="flex gap-3 text-lg leading-relaxed"><span class="font-bold min-w-[20px]">6.</span> <div>When nearing the end of their journey, birds rely on [6] in the air to find their precise nesting locations.</div></div>
                </div>',
                'placeholders' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6]
            ],
            'correct_answer' => [
                '1' => 'multi-modal',
                '2' => 'cryptochromes',
                '3' => 'consistent heading',
                '4' => 'circadian clock',
                '5' => 'memorizing',
                '6' => 'atmospheric chemicals'
            ],
            'explanation' => '1: multi-modal (para 1), 2: cryptochromes (para 2), 3: consistent heading (para 2), 4: circadian clock (para 3), 5: memorizing (para 3), 6: atmospheric chemicals (para 4)',
            'order' => 1
        ]);

        $p9_3 = \App\Models\IeltsReadingPassage::create([
            'material_id' => 9,
            'title' => 'The Script of Civilization',
            'content' => '<p>The development of writing is arguably the most significant technological leap in human history, marking the transition from prehistory to recorded history. Long before the invention of the alphabet, early humans used pictographs—simple drawings representing physical objects—to communicate basic ideas. While effective for tallying livestock or grain supplies, these images were limited by their inability to express abstract concepts or complex grammatical structures.</p>
            <p>The first major breakthrough occurred in ancient Mesopotamia around 3200 BCE with the emergence of Cuneiform. Developed by the Sumerians, this system involved pressing a wedge-shaped stylus into soft clay tablets. Over centuries, Cuneiform evolved from literal pictures into a series of stylized symbols that represented sounds or syllables. This transition, known as the Rebus Principle, allowed writers to communicate any word in their spoken language, regardless of whether it could be easily drawn. Consequently, writing shifted from a mere accounting tool to a medium for literature, law, and diplomacy.</p>
            <p>In ancient Egypt, a different but equally complex system was unfolding. Hieroglyphs were used for monumental inscriptions, while a more cursive script called \'hieratic\' was developed for everyday administrative tasks on papyrus, a paper-like material made from river reeds. Unlike the Sumerian script, Egyptian writing remained highly decorative, blending phonetic signs with symbolic imagery. It was not until the discovery of the Rosetta Stone in 1799 that scholars were finally able to decipher these ancient texts, as the stone featured the same decree written in three different scripts, providing the necessary \'key\' for translation.</p>
            <p>The final evolution toward modern writing came with the Phoenicians, who developed the world’s first phonetic alphabet. Unlike previous systems that required memorizing hundreds of unique symbols, the Phoenician script used a small set of characters to represent individual vocal sounds. This innovation democratized literacy, as it was far easier for the average person to learn. This alphabet was later adapted by the Greeks and Romans, forming the basis for the Latin script used by much of the world today.</p>',
            'order' => 3
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p9_3->id,
            'question_number' => 1,
            'question_text' => 'Questions 1–6<br>Complete the sentences below.<br>Choose NO MORE THAN TWO WORDS from the passage for each answer.',
            'type' => 'sentence_completion',
            'data' => [
                'summary_text' => '<div class="space-y-6">
                    <div class="flex gap-3 text-lg leading-relaxed"><span class="font-bold min-w-[20px]">1.</span> <div>Early humans utilized [1] to record information about tangible items like animals and food.</div></div>
                    <div class="flex gap-3 text-lg leading-relaxed"><span class="font-bold min-w-[20px]">2.</span> <div>The Sumerians used a tool called a [2] to create markings on tablets made of clay.</div></div>
                    <div class="flex gap-3 text-lg leading-relaxed"><span class="font-bold min-w-[20px]">3.</span> <div>The introduction of the [3] enabled the Sumerian script to represent the sounds of speech for the first time.</div></div>
                    <div class="flex gap-3 text-lg leading-relaxed"><span class="font-bold min-w-[20px]">4.</span> <div>For routine government work, Egyptians preferred a script known as [4] instead of formal hieroglyphs.</div></div>
                    <div class="flex gap-3 text-lg leading-relaxed"><span class="font-bold min-w-[20px]">5.</span> <div>Scholars used the [5] to unlock the meaning of Egyptian writing after centuries of mystery.</div></div>
                    <div class="flex gap-3 text-lg leading-relaxed"><span class="font-bold min-w-[20px]">6.</span> <div>The Phoenician alphabet made [6] more accessible because there were fewer characters to remember.</div></div>
                </div>',
                'placeholders' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6]
            ],
            'correct_answer' => [
                '1' => 'pictographs',
                '2' => 'stylus',
                '3' => 'Rebus Principle',
                '4' => 'hieratic',
                '5' => 'Rosetta Stone',
                '6' => 'literacy'
            ],
            'explanation' => '1: pictographs (para 1), 2: stylus (para 2), 3: Rebus Principle (para 2), 4: hieratic (para 3), 5: Rosetta Stone (para 3), 6: literacy (para 4)',
            'order' => 1
        ]);

        // Material 10
        // Idempotency: Cleanup existing Material 10 passages to prevent duplication
        \App\Models\IeltsReadingPassage::where('material_id', 10)->each(function ($passage) {
            $passage->questions()->delete();
            $passage->delete();
        });

        $p10 = \App\Models\IeltsReadingPassage::create([
            'material_id' => 10,
            'title' => 'The Urban Heat Island Effect',
            'content' => '<p><strong>A</strong> As global populations continue to shift toward metropolitan centers, a climatic phenomenon known as the Urban Heat Island (UHI) effect has become a focal point for environmental scientists. This condition occurs when a city experiences significantly warmer temperatures than its surrounding rural hinterlands. The temperature disparity is primarily attributed to the high concentration of dark, non-reflective surfaces such as asphalt and concrete. These materials possess a high thermal mass, meaning they absorb vast quantities of solar radiation during daylight hours and gradually release that trapped heat throughout the night.</p>
            <p><strong>B</strong> The environmental and economic consequences of UHI are far-reaching. Higher urban temperatures directly correlate with an increased demand for energy, particularly for air conditioning systems. This spike in electricity consumption not only places a strain on local power grids but also contributes to a surge in greenhouse gas emissions if the energy is derived from fossil fuels. Furthermore, the intensified heat can exacerbate existing health issues among vulnerable populations, leading to a higher incidence of heat-related respiratory and cardiovascular distress during peak summer months.</p>
            <p><strong>C</strong> A less obvious but equally significant driver of UHI is the geometric configuration of modern cities. The phenomenon of \'urban canyons\'—narrow streets flanked by towering skyscrapers—restricts the flow of air at ground level. In a natural landscape, wind provides a cooling effect through convection, but in a dense urban environment, buildings act as physical barriers that trap stagnant, warm air. Additionally, these vertical structures provide more surface area for solar absorption, further compounding the heat retention within the city\'s core.</p>
            <p><strong>D</strong> To combat these rising temperatures, urban planners are exploring various \'passive\' cooling strategies. One such innovation is the \'cool roof,\' which involves coating rooftops with highly reflective materials to bounce sunlight back into the atmosphere before it can be absorbed as heat. Another approach is the integration of \'green\' infrastructure, such as living walls and rooftop gardens. These biological additions provide natural shade and facilitate evapotranspiration—a process where plants release moisture into the air, effectively lowering the ambient temperature of the immediate surroundings.</p>
            <p><strong>E</strong> The efficacy of these interventions, however, depends largely on the specific climate and architectural heritage of a city. While reflective roofs may be ideal for sun-drenched cities in Mediterranean climates, they might be less effective in regions with high cloud cover. Similarly, the maintenance of green roofs requires a consistent water supply, which can be a challenge in arid environments. Consequently, experts argue that a \'one-size-fits-all\' approach is impractical; instead, cities must develop bespoke strategies that harmonize with their unique geographical and meteorological conditions.</p>',
            'order' => 1
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p10->id,
            'question_number' => 1,
            'question_text' => 'Questions 1–6<br>The Reading Passage has five paragraphs, A–E.<br>Which paragraph contains the following information?<br>NB: You may use any letter more than once.',
            'type' => 'matching_paragraph_information',
            'options' => [
                'A' => 'Paragraph A',
                'B' => 'Paragraph B',
                'C' => 'Paragraph C',
                'D' => 'Paragraph D',
                'E' => 'Paragraph E'
            ],
            'correct_answer' => [
                '1' => 'C',
                '2' => 'A',
                '3' => 'E',
                '4' => 'B',
                '5' => 'D',
                '6' => 'B'
            ],
            'explanation' => '1: C (geometric configuration/shape of city), 2: A (dark surfaces/materials for heat retention), 3: E (local conditions/one-size-fits-all impractical), 4: B (greenhouse gas emissions/global warming impact), 5: D (evapotranspiration/biological process), 6: B (health issues/human well-being)',
            'data' => [
                'sub_questions' => [
                    ['id' => '1', 'label' => 'A mention of how the physical shape of a city affects its temperature.'],
                    ['id' => '2', 'label' => 'An explanation of why certain materials are responsible for heat retention.'],
                    ['id' => '3', 'label' => 'The suggestion that local conditions should dictate the choice of cooling methods.'],
                    ['id' => '4', 'label' => 'A reference to the indirect impact of urban heat on global warming.'],
                    ['id' => '5', 'label' => 'A description of a biological process that helps to cool the air.'],
                    ['id' => '6', 'label' => 'An account of how urban heat can negatively affect human physical well-being.']
                ]
            ],
            'order' => 1
        ]);

        $p10_2 = \App\Models\IeltsReadingPassage::create([
            'material_id' => 10,
            'title' => 'The Antikythera Mechanism: An Ancient Computer',
            'content' => '<p><strong>A</strong> In 1901, divers exploring a Roman shipwreck off the Greek island of Antikythera discovered a calcified, corroded lump of bronze that would eventually rewrite the history of technology. Initial inspections revealed a complex system of interlocking gearwheels, a level of mechanical sophistication previously thought to have originated in 18th-century Europe. This device, now known as the Antikythera Mechanism, dates back to the 2nd century BCE and is widely regarded as the world’s first analogue computer.</p>
            <p><strong>B</strong> For decades, the internal workings of the mechanism remained a mystery due to its fragile state. It was not until the application of high-resolution X-ray tomography and surface imaging that researchers could peer through the layers of corrosion. These techniques revealed more than 30 bronze gears, as well as thousands of tiny inscriptions. The markings acted as a user manual, explaining the device\'s functions, which included predicting the positions of the sun, the moon, and the five planets known to the Greeks at the time.</p>
            <p><strong>C</strong> The ingenuity of the mechanism lies in its ability to model the \'irregular\' orbit of the moon. The Greeks noticed that the moon appears to speed up and slow down as it moves across the sky. To replicate this, the makers of the device used an ingenious \'pin-and-slot\' mechanism—one gear set slightly off-center inside another—to create a variable motion. This sophisticated mathematical modeling suggests that ancient Greek scientists possessed a far deeper understanding of celestial mechanics and engineering than historians had previously credited them with.</p>
            <p><strong>D</strong> Beyond its astronomical functions, the device also served a significant social and cultural purpose. One of the dials on the back of the mechanism tracked the four-year cycle of the Panhellenic Games, including the Olympics. This indicates that the device was not just a tool for academic study, but a practical calendar used to coordinate major events across the Greek world. It bridged the gap between the abstract movements of the stars and the concrete rhythms of human life.</p>
            <p><strong>E</strong> The ultimate fate of this technology remains a subject of intense speculation. After the period in which the Antikythera Mechanism was built, such complex gear-based machines vanished from the historical record for over a thousand years. Some scholars suggest that the knowledge was lost during the Roman conquest of Greece, while others argue that such devices were so expensive and difficult to maintain that they were never mass-produced. Whatever the reason, its existence serves as a humbling reminder of the advanced knowledge that can be lost to time.</p>',
            'order' => 2
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p10_2->id,
            'question_number' => 1,
            'question_text' => 'Questions 1–6<br>The Reading Passage has five paragraphs, A–E.<br>Which paragraph contains the following information?<br>NB: You may use any letter more than once.',
            'type' => 'matching_paragraph_information',
            'options' => [
                'A' => 'Paragraph A',
                'B' => 'Paragraph B',
                'C' => 'Paragraph C',
                'D' => 'Paragraph D',
                'E' => 'Paragraph E'
            ],
            'correct_answer' => [
                '1' => 'C',
                '2' => 'D',
                '3' => 'B',
                '4' => 'A',
                '5' => 'E',
                '6' => 'B'
            ],
            'explanation' => '1: C (pin-and-slot mechanism/irregular orbit), 2: D (social/cultural purpose/Olympics), 3: B (X-ray tomography/modern technology), 4: A (18th-century Europe/comparison), 5: E (speculation on fate/lost knowledge), 6: B (inscriptions/user manual)',
            'data' => [
                'sub_questions' => [
                    ['id' => '1', 'label' => 'A mention of a specific physical feature used to simulate the moon’s inconsistent movement.'],
                    ['id' => '2', 'label' => 'An explanation of the non-scientific role the device played in ancient society.'],
                    ['id' => '3', 'label' => 'A reference to the modern technology used to examine the device\'s interior.'],
                    ['id' => '4', 'label' => 'A comparison between the device and much later mechanical inventions.'],
                    ['id' => '5', 'label' => 'An account of different theories regarding the disappearance of this technology.'],
                    ['id' => '6', 'label' => 'The suggestion that the device also contained written instructions for the operator.']
                ]
            ],
            'order' => 1
        ]);

        $p10_3 = \App\Models\IeltsReadingPassage::create([
            'material_id' => 10,
            'title' => 'The Psychology of the Workplace',
            'content' => '<p><strong>A</strong> The transition from cellular, private offices to open-plan environments was initially hailed by management theorists as a way to dismantle corporate hierarchies and foster spontaneous collaboration. The rationale was simple: by removing physical barriers like walls and doors, employees would communicate more frequently, leading to a surge in creative synergy. This architectural shift, which gained momentum in the late 20th century, was also driven by the pragmatic need to reduce real estate costs by fitting more workers into a smaller square footage.</p>
            <p><strong>B</strong> However, empirical research has begun to paint a more nuanced picture of the open-office reality. Studies in environmental psychology suggest that the lack of visual and acoustic privacy can significantly impair cognitive performance. The constant exposure to \'overheard conversations\'—a phenomenon known as the \'irrelevant sound effect\'—forces the brain to exert extra effort to filter out non-essential data. This cognitive load not only reduces accuracy in complex tasks but also increases stress levels, as employees feel a loss of control over their immediate environment.</p>
            <p><strong>C</strong> A surprising secondary effect of open-plan layouts is the decline in face-to-face interaction, despite the absence of walls. Researchers at Harvard University found that when employees were moved to an open environment, the volume of in-person conversation actually dropped by approximately 70%. Instead, workers resorted to digital messaging and email to communicate. This \'defensive\' behavior is attributed to the fact that in a transparent space, employees feel \'socially exposed,\' leading them to use headphones and screens as psychological shields to signal that they are unavailable for interruption.</p>
            <p><strong>D</strong> In response to these findings, some forward-thinking firms are adopting \'Activity-Based Working\' (ABW). This design philosophy recognizes that different tasks require different psychological states. Instead of assigned desks, an ABW office provides a variety of zones: \'library\' spaces for deep concentration, \'huddle\' rooms for quick team meetings, and \'social hubs\' for casual networking. By giving employees the autonomy to choose an environment that matches their current objective, companies can balance the need for collaboration with the necessity of quiet, focused labor.</p>
            <p><strong>E</strong> Beyond layout, the integration of \'biophilic design\'—the practice of incorporating natural elements into the built environment—is gaining scientific backing. The presence of indoor plants, natural light, and views of greenery has been shown to lower heart rates and improve mental restoration. This is based on the \'Attention Restoration Theory,\' which posits that urban environments drain our finite cognitive resources, whereas nature provides a \'soft fascination\' that allows the brain to recharge. Consequently, the office of the future is likely to look less like a sterile laboratory and more like a living ecosystem.</p>',
            'order' => 3
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p10_3->id,
            'question_number' => 1,
            'question_text' => 'Questions 1–6<br>The Reading Passage has five paragraphs, A–E.<br>Which paragraph contains the following information?<br>NB: You may use any letter more than once.',
            'type' => 'matching_paragraph_information',
            'options' => [
                'A' => 'Paragraph A',
                'B' => 'Paragraph B',
                'C' => 'Paragraph C',
                'D' => 'Paragraph D',
                'E' => 'Paragraph E'
            ],
            'correct_answer' => [
                '1' => 'A',
                '2' => 'E',
                '3' => 'C',
                '4' => 'B',
                '5' => 'D',
                '6' => 'C'
            ],
            'explanation' => '1: A (financial motivation/reduce real estate costs), 2: E (nature/brain recover/Attention Restoration Theory), 3: C (transparency/preference for electronic communication/defensive behavior), 4: B (noise/irrelevant sound effect/mental processing), 5: D (choice/ABW/autonomy), 6: C (symbolic barriers/headphones and screens)',
            'data' => [
                'sub_questions' => [
                    ['id' => '1', 'label' => 'A mention of the financial motivation behind certain office designs.'],
                    ['id' => '2', 'label' => 'A reference to a theory explaining how nature helps the brain recover from fatigue.'],
                    ['id' => '3', 'label' => 'The suggestion that physical transparency can lead to a preference for electronic communication.'],
                    ['id' => '4', 'label' => 'An account of the specific ways noise in the office affects mental processing.'],
                    ['id' => '5', 'label' => 'An explanation of how giving workers more choice in their location can improve productivity.'],
                    ['id' => '6', 'label' => 'A description of how employees create symbolic barriers to avoid being disturbed.']
                ]
            ],
            'order' => 1
        ]);

        $p10_4 = \App\Models\IeltsReadingPassage::create([
            'material_id' => 10,
            'title' => 'The Mystery of Easter Island: New Perspectives',
            'content' => '<p><strong>A</strong> The isolated Pacific territory of Rapa Nui, commonly known as Easter Island, has long captivated the Western imagination. The island is famous for its nearly 1,000 monumental statues, known as moai, which were carved from volcanic tuff and transported across rugged terrain to stand on stone platforms called ahu. For decades, the dominant narrative, popularized by scholars like Jared Diamond, suggested that the island’s inhabitants suffered an \'ecocide\'—a self-inflicted environmental collapse caused by overpopulation and the reckless clearing of palm forests to facilitate the movement of the massive statues.</p>
            <p><strong>B</strong> However, recent archaeological evidence is beginning to dismantle this cautionary tale of environmental suicide. Modern soil analysis and radiocarbon dating suggest that the deforestation of Rapa Nui was a much slower process than previously thought and was not solely the result of human activity. New theories point to the arrival of the Polynesian rat, which likely hitched a ride on the early settlers\' canoes. These rodents consumed the seeds of the native palms, preventing the forest from regenerating. This biological factor, rather than human mismanagement alone, may have been the primary driver of the island\'s landscape transformation.</p>
            <p><strong>C</strong> Furthermore, the assumption that the Rapa Nui people were a primitive, warlike society has also been challenged. Early explorers described findind large numbers of \'obsidian points\' scattered across the island, which were interpreted as spearheads used in tribal warfare. However, microscopic analysis of these artifacts reveals that they lack the impact damage associated with weapons. Instead, they were more likely used as domestic tools for scrapng wood or processing plants. This suggests that the collapse of the civilization was not characterized by internal violence, but rather by a resilient community that adapted to a changing environment.</p>
            <p><strong>D</strong> The technological ingenuity of the islanders is most evident in the transportation of the moai. While earlier theories envisioned the statues being dragged on wooden rollers, local oral tradition insists that the statues \'walked\' to their destinations. Experimental archaeology has proven this plausible; by using a system of ropes and a rhythmic rocking motion, a small group of people can move a standing moai forward. This \'walking\' technique required a precise understanding of the center of gravity, as the statues were carved with a heavy base and a forward-leaning tilt that was only corrected once they reached the ahu.</p>
            <p><strong>E</strong> The true downfall of the Rapa Nui civilization likely came from external rather than internal forces. When European ships began arriving in the 18th century, they brought with them diseases to which the islanders had no immunity. This was followed by the devastating impact of 19th-century slave raids, which kidnapped a significant portion of the population. These external shocks, combined with the earlier ecological changes, led to a rapid decline in the population. The story of Easter Island is thus shifting from a fable of self-destruction to a complex history of resilience and external tragedy.</p>',
            'order' => 4
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p10_4->id,
            'question_number' => 1,
            'question_text' => 'Questions 1–6<br>The Reading Passage has five paragraphs, A–E.<br>Which paragraph contains the following information?<br>NB: You may use any letter more than once.',
            'type' => 'matching_paragraph_information',
            'options' => [
                'A' => 'Paragraph A',
                'B' => 'Paragraph B',
                'C' => 'Paragraph C',
                'D' => 'Paragraph D',
                'E' => 'Paragraph E'
            ],
            'correct_answer' => [
                '1' => 'B',
                '2' => 'D',
                '3' => 'C',
                '4' => 'D',
                '5' => 'E',
                '6' => 'A'
            ],
            'explanation' => '1: B (creatures/Polynesian rat/loss of trees), 2: D (traditional belief/oral tradition/statues walked), 3: C (scientific examination/microscopic analysis/tools/violence), 4: D (design features/center of gravity/forward-leaning tilt), 5: E (non-native illnesses/diseases/slave raids/population crash), 6: A (theory/ecocide/Jared Diamond/environmental ruin)',
            'data' => [
                'sub_questions' => [
                    ['id' => '1', 'label' => 'A mention of how specific creatures may have contributed to the loss of trees.'],
                    ['id' => '2', 'label' => 'An account of a traditional belief regarding the movement of the statues.'],
                    ['id' => '3', 'label' => 'A reference to a scientific examination of tools that changed historians\' views on island violence.'],
                    ['id' => '4', 'label' => 'A description of the physical design features that enabled the statues to be moved upright.'],
                    ['id' => '5', 'label' => 'An explanation of how non-native illnesses and human exploitation led to a population crash.'],
                    ['id' => '6', 'label' => 'The mention of a well-known theory that blames the islanders for their own environmental ruin.']
                ]
            ],
            'order' => 1
        ]);

        $p10_5 = \App\Models\IeltsReadingPassage::create([
            'material_id' => 10,
            'title' => 'The Secret Life of Plants: Communication and Defense',
            'content' => '<p><strong>A</strong> For centuries, the plant kingdom was viewed as a passive backdrop to the more dynamic lives of animals. However, a growing body of research in plant neurobiology is overturning this perception. It is now understood that plants possess a complex sensory apparatus that allows them to perceive and respond to their environment in sophisticated ways. They can sense light, gravity, and touch, but perhaps most remarkably, they can communicate with one another. This communication is not through sound or gesture, but through a hidden network of chemical signals and underground fungal connections.</p>
            <p><strong>B</strong> One of the most well-documented forms of plant communication involves the release of Volatile Organic Compounds (VOCs) into the air. When a plant, such as a willow or a sagebrush, is attacked by an herbivore, it emits a specific chemical "scent." This scent serves as a warning to neighboring plants of the same species. Upon detecting these airborne signals, the "listening" plants begin to bolster their own chemical defenses, producing bitter toxins that make their leaves unpalatable to insects. This preemptive response suggests a level of cooperation that was once thought to be unique to social animals.</p>
            <p><strong>C</strong> The communication network extends below the surface as well, through what researchers have dubbed the "Wood Wide Web." Most land plants form a symbiotic relationship with mycorrhizal fungi. These fungi weave their hyphae—tiny, thread-like structures—around plant roots, creating a massive underground grid. Through this network, plants can exchange nutrients such as phosphorus and nitrogen. More surprisingly, "mother trees" have been observed using this system to send surplus sugar to younger saplings growing in the shade, significantly increasing their chances of survival.</p>
            <p><strong>D</strong> Plants also exhibit an extraordinary ability to defend themselves through mimicry and deception. Certain species of orchids, for instance, have evolved flowers that perfectly replicate the appearance and scent of female bees. This "sexual deception" lures male bees into attempting to mate with the flower, inadvertently picking up pollen and transporting it to the next plant. Other plants use mimicry to avoid being eaten. The Boquila trifoliolata vine in South America can change the shape, size, and color of its leaves to match the foliage of the tree it is climbing, effectively hiding in plain sight from hungry herbivores.</p>
            <p><strong>E</strong> The implications of these findings are profound, challenging our traditional definitions of intelligence and agency. While plants lack a centralized brain or nervous system, they demonstrate a capacity for memory and learning. Experiments with the Mimosa pudica, a plant that folds its leaves when touched, showed that the plant could "learn" to ignore a stimulus that was not harmful, retaining this memory for weeks. As we uncover the depths of plant cognition, the boundary between the "thinking" animal world and the "unthinking" botanical world continues to blur.</p>',
            'order' => 5
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p10_5->id,
            'question_number' => 1,
            'question_text' => 'Questions 1–6<br>The Reading Passage has five paragraphs, A–E.<br>Which paragraph contains the following information?<br>NB: You may use any letter more than once.',
            'type' => 'matching_paragraph_information',
            'options' => [
                'A' => 'Paragraph A',
                'B' => 'Paragraph B',
                'C' => 'Paragraph C',
                'D' => 'Paragraph D',
                'E' => 'Paragraph E'
            ],
            'correct_answer' => [
                '1' => 'E',
                '2' => 'C',
                '3' => 'D',
                '4' => 'B',
                '5' => 'D',
                '6' => 'C'
            ],
            'explanation' => '1: E (Mimosa pudica/distinguish dangerous harm/ignore stimulus), 2: C (Wood Wide Web/underground/fungi/sharing food/mother trees), 3: D (mimicry/change shape/color/visual camouflage/Boquila trifoliolata), 4: B (airborne chemicals/VOCs/warning/prepare defense), 5: D (orchids/manipulate insects/reproduction/sexual deception), 6: C (symbiotic relationship/mycorrhizal fungi/roots)',
            'data' => [
                'sub_questions' => [
                    ['id' => '1', 'label' => 'A mention of a specific plant that can distinguish between dangerous and harmless physical contact.'],
                    ['id' => '2', 'label' => 'A reference to a subterranean system that facilitates the sharing of food between trees.'],
                    ['id' => '3', 'label' => 'The suggestion that plants can use visual camouflage to escape predators.'],
                    ['id' => '4', 'label' => 'An account of how airborne chemicals allow plants to prepare for a potential threat.'],
                    ['id' => '5', 'label' => 'A description of how certain plants manipulate insects for the purpose of reproduction.'],
                    ['id' => '6', 'label' => 'An explanation of the symbiotic link between plant roots and another type of organism.']
                ]
            ],
            'order' => 1
        ]);

        $p10_6 = \App\Models\IeltsReadingPassage::create([
            'material_id' => 10,
            'title' => 'The Chronometer: Solving the Longitude Problem',
            'content' => '<p><strong>A</strong> For early mariners, determining latitude—one\'s position north or south of the equator—was relatively straightforward, involving the measurement of the angle of the sun or the North Star above the horizon. However, calculating longitude—one\'s east-west position—was a much more formidable challenge. Because the Earth rotates 15 degrees every hour, longitude is directly linked to time. To know where you are, you must know the exact time at a fixed reference point (like Greenwich) and compare it to the local time on your ship. In the 17th and 18th centuries, the lack of an accurate sea-going clock led to countless shipwrecks and the loss of thousands of lives.</p>
            <p><strong>B</strong> The British Parliament\'s Longitude Act of 1714 offered a massive prize of £20,000 for a solution to this problem. Most scientists of the day, including Sir Isaac Newton, believed the answer lay in the heavens. The \'Lunar Distance Method\' involved complex observations of the moon\'s position relative to the stars. While theoretically sound, this method was incredibly difficult to perform on a rocking ship and required hours of grueling mathematical calculations. The scientific establishment was convinced that a mechanical clock could never be precise enough to withstand the humidity, temperature changes, and motion of a long sea voyage.</p>
            <p><strong>C</strong> John Harrison, a self-taught carpenter and clockmaker from Yorkshire, challenged this consensus. Over several decades, he developed a series of "marine chronometers." His first versions were large, heavy machines, but his breakthrough came with the H4—a device no larger than a pocket watch. Harrison utilized bimetallic strips to compensate for temperature fluctuations and high-precision gears made of materials that required no lubrication. These innovations allowed the clock to maintain nearly perfect time even in the harshest oceanic environments.</p>
            <p><strong>D</strong> The journey to recognition was not easy for Harrison. The Board of Longitude, dominated by astronomers, was reluctant to award the prize to a craftsman. They repeatedly changed the rules of the competition and demanded more trials. It was only after the personal intervention of King George III, who tested one of Harrison\'s clocks himself and found it to be incredibly accurate, that the aging inventor finally received the financial reward and the recognition he deserved. Harrison\'s clocks fundamentally transformed navigation, allowing for the accurate mapping of the world\'s oceans.</p>
            <p><strong>E</strong> Today, the legacy of the chronometer lives on in our modern Global Positioning System (GPS). While we now use satellites and atomic clocks that measure the vibrations of atoms rather than the swing of a pendulum or the ticking of a balance wheel, the underlying principle remains identical. Navigation is still, at its heart, a matter of timekeeping. By measuring the time it takes for a signal to travel from a satellite to a receiver, we can determine our position on Earth with a precision that John Harrison could only have dreamed of.</p>',
            'order' => 6
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p10_6->id,
            'question_number' => 1,
            'question_text' => 'Questions 1–6<br>The Reading Passage has five paragraphs, A–E.<br>Which paragraph contains the following information?<br>NB: You may use any letter more than once.',
            'type' => 'matching_paragraph_information',
            'options' => [
                'A' => 'Paragraph A',
                'B' => 'Paragraph B',
                'C' => 'Paragraph C',
                'D' => 'Paragraph D',
                'E' => 'Paragraph E'
            ],
            'correct_answer' => [
                '1' => 'C',
                '2' => 'A',
                '3' => 'D',
                '4' => 'E',
                '5' => 'B',
                '6' => 'B'
            ],
            'explanation' => '1: C (bimetallic strips/components/environmental changes), 2: A (Earth rotates 15 degrees/longitude/time/position), 3: D (King George III/political figure/intervention), 4: E (GPS/legacy/timekeeping/underlying principle), 5: B (scientific establishment/mechanical clock impossible/doubt), 6: B (Lunar Distance Method/moon position/difficult/celestial)',
            'data' => [
                'sub_questions' => [
                    ['id' => '1', 'label' => 'A mention of the specific physical components used to handle environmental changes.'],
                    ['id' => '2', 'label' => 'An explanation of the relationship between the Earth\'s movement and geographic coordinates.'],
                    ['id' => '3', 'label' => 'A reference to the interference of a high-ranking political figure in a scientific dispute.'],
                    ['id' => '4', 'label' => 'The suggestion that modern technology still relies on the same core concept as 18th-century inventions.'],
                    ['id' => '5', 'label' => 'An account of why the scientific community initially doubted a mechanical solution.'],
                    ['id' => '6', 'label' => 'A description of the difficulties involved in using celestial bodies for navigation.']
                ]
            ],
            'order' => 1
        ]);

        $p10_7 = \App\Models\IeltsReadingPassage::create([
            'material_id' => 10,
            'title' => 'The Steam Engine: The Heart of the Industrial Age',
            'content' => '<p><strong>A</strong> Prior to the 18th century, the energy available for human work was limited to the muscle power of animals, the flow of rivers, or the unpredictable force of the wind. This placed a natural ceiling on production and transport. The breakthrough that shattered this ceiling was the development of the steam engine. While early designs by Thomas Savery and Thomas Newcomen were primarily used to pump water out of deep coal mines, they were notoriously inefficient, losing the vast majority of their heat during each stroke of the piston.</p>
            <p><strong>B</strong> The turning point came in 1765 when James Watt, a Scottish instrument maker, identified the primary flaw in Newcomen’s design. He realized that cooling the entire cylinder after every stroke wasted immense amounts of fuel. Watt’s solution was the \'separate condenser,\' a device that allowed the main cylinder to remain hot while the steam was cooled elsewhere. This single innovation increased fuel efficiency by more than 300%, transforming the steam engine from a specialized mining tool into a versatile power source that could be installed anywhere.</p>
            <p><strong>C</strong> The consequences of this efficiency were felt almost immediately across the textile industry. Traditionally, mills had to be located near fast-flowing streams to power water wheels. With the advent of Watt’s engine, factories could be moved into urban centers, closer to labor pools and transport hubs. This shifted the population from the countryside to the city, marking the beginning of the modern urban landscape. It also led to the development of the \'rotary motion\' engine, which allowed steam power to drive complex machinery, not just pumps.</p>
            <p><strong>D</strong> Despite its benefits, the rapid adoption of steam power brought about a series of social and environmental crises. The burning of vast quantities of coal to feed these \'iron horses\' led to the first instances of severe urban smog. In cities like Manchester, the air became thick with soot, affecting the health of the working class who lived in cramped conditions near the factories. Furthermore, the mechanization of labor led to the Luddite protests, where textile workers destroyed machinery, fearing that the steam engine would render their artisanal skills obsolete and lead to permanent unemployment.</p>
            <p><strong>E</strong> The legacy of the steam engine is complex. On one hand, it laid the foundation for the modern world, powering the locomotives and steamships that shrunk the globe. On the other, it initiated the massive release of carbon dioxide into the atmosphere, a process that continues to drive global climate change today. As we move toward renewable energy sources, the story of the steam engine serves as a reminder of how a single technological leap can permanently alter the trajectory of human civilization, for better and for worse.</p>',
            'order' => 7
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p10_7->id,
            'question_number' => 1,
            'question_text' => 'Questions 1–6<br>The Reading Passage has five paragraphs, A–E.<br>Which paragraph contains the following information?<br>NB: You may use any letter more than once.',
            'type' => 'matching_paragraph_information',
            'options' => [
                'A' => 'Paragraph A',
                'B' => 'Paragraph B',
                'C' => 'Paragraph C',
                'D' => 'Paragraph D',
                'E' => 'Paragraph E'
            ],
            'correct_answer' => [
                '1' => 'D',
                '2' => 'B',
                '3' => 'C',
                '4' => 'A',
                '5' => 'E',
                '6' => 'D'
            ],
            'explanation' => '1: D (Luddite protests/textile workers/destroyed machinery/opposed technology), 2: B (separate condenser/single innovation/increased fuel efficiency/reduced waste), 3: C (mills located near streams/factories moved to urban centers/location changed), 4: A (Savery and Newcomen/pump water/coal mines/specialized mining tool/single industry), 5: E (massive release of carbon dioxide/global climate change/environmental problems), 6: D (urban smog/soot/health of working class/cramped conditions/physical health)',
            'data' => [
                'sub_questions' => [
                    ['id' => '1', 'label' => 'A mention of the specific group of people who opposed the introduction of new technology.'],
                    ['id' => '2', 'label' => 'A reference to a modification that significantly reduced the waste of energy.'],
                    ['id' => '3', 'label' => 'An explanation of how the location of manufacturing changed due to a new energy source.'],
                    ['id' => '4', 'label' => 'The suggestion that early versions of a machine were limited to a single industry.'],
                    ['id' => '5', 'label' => 'An account of how a historical invention is linked to current environmental problems.'],
                    ['id' => '6', 'label' => 'A description of the physical health impacts caused by industrial pollution.']
                ]
            ],
            'order' => 1
        ]);

        $p10_8 = \App\Models\IeltsReadingPassage::create([
            'material_id' => 10,
            'title' => 'The Resilience of Natural Rubber',
            'content' => '<p><strong>A</strong> For much of human history, natural rubber was a curiosity confined to the indigenous peoples of the Amazon Basin. Derived from the milky sap, or latex, of the Hevea brasiliensis tree, it was used to create waterproof footwear and bouncing balls. However, in its raw state, the material was deeply flawed: it became sticky and soft in the heat of summer and brittle and cracked in the cold of winter. It was not until 1839, when Charles Goodyear accidentally discovered the process of \'vulcanization\'—adding sulfur to heated rubber—that the material became stable enough for industrial use.</p>
            <p><strong>B</strong> The global demand for rubber exploded with the invention of the pneumatic tire, turning the Amazon into a site of immense wealth and staggering cruelty. This period, known as the \'Rubber Boom,\' saw the rise of \'Rubber Barons\' who exploited indigenous labor to harvest wild trees. However, the monopoly held by South America was fragile. In 1876, an Englishman named Henry Wickham smuggled 70,000 rubber seeds out of Brazil. These seeds were nurtured at London’s Kew Gardens and eventually shipped to British colonies in Southeast Asia, where they were grown in organized plantations.</p>
            <p><strong>C</strong> This shift from wild harvesting to plantation agriculture fundamentally altered the global market. Unlike the scattered wild trees of the Amazon, Asian plantations allowed for a systematic and efficient extraction process. This led to a dramatic drop in prices, making rubber accessible for the mass production of automobiles. However, this transition also created a biological vulnerability. Because the plantations in Asia were grown from a very small genetic pool, they were—and remain—highly susceptible to diseases.</p>
            <p><strong>D</strong> The most significant threat to the rubber industry today is Microcyclus ulei, a fungus that causes South American Leaf Blight (SALB). This pathogen has effectively prevented the establishment of successful rubber plantations in the Americas. If SALB were to reach the vast monocultures of Southeast Asia, the global supply of natural rubber could vanish almost overnight. Unlike synthetic rubber, which is derived from petroleum, natural rubber possesses unique properties of heat resistance and elasticity that are essential for the tires of heavy aircraft and high-performance vehicles.</p>
            <p><strong>E</strong> In response to this potential catastrophe, scientists are looking for alternatives. One promising candidate is the guayule shrub, native to the deserts of the southwestern United States and Mexico. Another is the Russian dandelion, which produces a high-quality latex in its roots. These alternatives could provide a \'biological backup\' for the industry, ensuring that a single fungal outbreak does not paralyze global transport. As the world moves toward more sustainable materials, the history of rubber serves as a stark lesson in the risks of over-reliance on a single, genetically uniform crop.</p>',
            'order' => 8
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p10_8->id,
            'question_number' => 1,
            'question_text' => 'Questions 1–6<br>The Reading Passage has five paragraphs, A–E.<br>Which paragraph contains the following information?<br>NB: You may use any letter more than once.',
            'type' => 'matching_paragraph_information',
            'options' => [
                'A' => 'Paragraph A',
                'B' => 'Paragraph B',
                'C' => 'Paragraph C',
                'D' => 'Paragraph D',
                'E' => 'Paragraph E'
            ],
            'correct_answer' => [
                '1' => 'B',
                '2' => 'D',
                '3' => 'A',
                '4' => 'E',
                '5' => 'B',
                '6' => 'C'
            ],
            'explanation' => '1: B (end of regional monopoly/Henry Wickham smuggled seeds/Brazil monopoly ended), 2: D (laboratory-made alternative/synthetic rubber/cannot fully replace/unique properties), 3: A (accidental discovery/Charles Goodyear/vulcanization/improved physical properties), 4: E (two different plants/guayule shrub/Russian dandelion/future sources), 5: B (human suffering/Rubber Boom/Rubber Barons/exploited indigenous labor), 6: C (lack of genetic variety/small genetic pool/vulnerable to disaster/diseases)',
            'data' => [
                'sub_questions' => [
                    ['id' => '1', 'label' => 'A reference to a specific event that led to the end of a regional monopoly.'],
                    ['id' => '2', 'label' => 'An explanation of why a laboratory-made alternative cannot fully replace the natural product.'],
                    ['id' => '3', 'label' => 'A description of how an accidental discovery improved the physical properties of a substance.'],
                    ['id' => '4', 'label' => 'A mention of two different plants that could serve as future sources of latex.'],
                    ['id' => '5', 'label' => 'An account of the human suffering that occurred during a period of high economic growth.'],
                    ['id' => '6', 'label' => 'The suggestion that a lack of genetic variety makes current crops vulnerable to disaster.']
                ]
            ],
            'order' => 1
        ]);
        // Material 11
        // Idempotency: Cleanup existing Material 11 passages
        \App\Models\IeltsReadingPassage::where('material_id', 11)->each(function ($passage) {
            $passage->questions()->delete();
            $passage->delete();
        });

        $p11 = \App\Models\IeltsReadingPassage::create([
            'material_id' => 11,
            'title' => 'The Pioneers of Mars Exploration',
            'content' => '<p>The human fascination with Mars, often referred to as the \'Red Planet\', has evolved from distant telescopic observations to sophisticated robotic missions. Since the 1960s, space agencies have dispatched a variety of orbiters, landers, and rovers to uncover the planet’s geological and climatic history. Each mission has contributed a unique piece to the puzzle, helping scientists determine whether Mars ever hosted life.</p>
            <p>One of the earliest successes was the Mariner 4 flyby in 1965. This mission provided the first close-up images of another planet, revealing a cratered, moon-like surface. This shattered earlier myths of Martian civilizations and canals, showing instead a barren, frozen world. However, it wasn\'t until the Viking 1 mission in 1976 that humanity successfully placed a lander on the Martian surface. Viking 1 was equipped with biological experiments designed to look for signs of metabolic activity in the soil. While the results were inconclusive and sparked decades of debate, the mission was a triumph of engineering, operating for over six years.</p>
            <p>In the late 1990s, the Mars Pathfinder mission introduced a new era of exploration with the deployment of the first rover, Sojourn. Unlike stationary landers, Sojourn could move across the terrain to analyze different rocks. It utilized an Alpha Proton X-ray Spectrometer to determine the chemical composition of the \'Barnacle Bill\' rock, suggesting that Mars once had a more varied geological past.</p>
            <p>The most significant leap in mobile exploration came with the Curiosity rover, which touched down in Gale Crater in 2012. Roughly the size of a small car, Curiosity was designed as a mobile laboratory. Its primary goal was to investigate the role of water in the planet\'s history. By drilling into sedimentary rocks, Curiosity found evidence of ancient streambeds and organic molecules—the building blocks of life. Most recently, the Perseverance rover, which arrived in 2021, has taken the mission a step further by collecting soil samples that will be returned to Earth by a future mission. Perseverance also carried Ingenuity, a miniature helicopter that achieved the first powered flight on another planet, proving that aerial exploration is possible in Mars’ thin atmosphere.</p>',
            'order' => 1
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p11->id,
            'question_number' => 1,
            'question_text' => 'Questions 1–6<br>Complete the table below.<br>Choose NO MORE THAN TWO WORDS AND/OR A NUMBER from the passage for each answer.',
            'type' => 'table_completion',
            'options' => null,
            'correct_answer' => [
                '1' => 'barren, frozen',
                '2' => 'Viking 1', 
                '3' => 'metabolic activity',
                '4' => 'Spectrometer',
                '5' => 'mobile laboratory',
                '6' => 'powered flight'
            ],
            'explanation' => '1: barren, frozen (para 2), 2: Viking 1 (para 2), 3: metabolic activity (para 2), 4: Spectrometer (para 3), 5: mobile laboratory (para 4), 6: powered flight (para 4)',
            'data' => [
                'instruction' => 'Write your answers in boxes 1–6 on your answer sheet.',
                'columns' => ['Mission Name', 'Year of Arrival', 'Key Achievement or Tool', 'Findings / Purpose'],
                'rows' => [
                    ['Mariner 4', '1965', 'First close-up photos', 'Proved the surface was [1] and lacked civilization.'],
                    ['[2]', '1976', 'Biological experiments', 'Searched for [3] in Martian soil.'],
                    ['Mars Pathfinder', 'late 1990s', 'Sojourn (first rover)', 'Used a [4] to study rock chemistry.'],
                    ['Curiosity', '2012', '[5]', 'Confirmed existence of ancient water and organic molecules.'],
                    ['Perseverance', '2021', 'Ingenuity (helicopter)', 'Achieved first [6] in the atmosphere of Mars.']
                ],
                'placeholders' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6]
            ],
            'order' => 1
        ]);

        $p11_2 = \App\Models\IeltsReadingPassage::create([
            'material_id' => 11,
            'title' => 'The Rise of Alternative Energy Sources',
            'content' => '<p>As the global community seeks to reduce its reliance on fossil fuels, three primary renewable technologies have emerged as leaders in the transition to a low-carbon economy: Photovoltaic (PV) solar power, Wind turbines, and Geothermal systems. While all three harness natural forces, they differ significantly in their operational requirements and environmental impact.</p>
            <p>Solar Photovoltaic technology has seen the most rapid cost reduction over the last decade. PV panels function by using semi-conductive materials, typically silicon, to convert sunlight directly into electricity. Modern \'thin-film\' panels are increasingly popular due to their flexibility, though traditional monocrystalline panels remain the industry standard for efficiency. The primary limitation of solar energy is its intermittent nature, as power generation ceases during the night.</p>
            <p>Wind Energy has become a cornerstone of the European energy grid, particularly through offshore developments. Giant turbines utilize aerodynamic blades to capture the kinetic energy of the wind, which rotates a shaft connected to a generator. To maximize output, engineers have developed \'variable-pitch\' blades that can adjust their angle depending on wind speed. While highly efficient, wind farms are often criticized for their visual impact on landscapes and their potential threat to local bird populations.</p>
            <p>Geothermal Energy offers a more consistent alternative, known as \'baseload\' power, because it does not depend on weather conditions. This technology taps into the heat stored beneath the Earth\'s crust. In a \'Flash Steam\' plant, high-pressure hot water is pulled from deep underground and converted into steam to drive turbines. Some modern systems now use \'Binary Cycle\' technology, which allows for electricity production at much lower water temperatures by using a secondary fluid with a lower boiling point. Although geothermal plants have a very small physical footprint, they are geographically limited to regions with high tectonic activity, such as Iceland or the Philippines.</p>',
            'order' => 2
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p11_2->id,
            'question_number' => 1,
            'question_text' => 'Questions 1–6<br>Complete the table below.<br>Choose NO MORE THAN TWO WORDS from the passage for each answer.',
            'type' => 'table_completion',
            'options' => null,
            'correct_answer' => [
                '1' => 'silicon',
                '2' => 'intermittent nature',
                '3' => 'aerodynamic',
                '4' => 'visual impact',
                '5' => 'secondary fluid',
                '6' => 'geographically limited'
            ],
            'explanation' => '1: silicon (para 2), 2: intermittent nature (para 2), 3: aerodynamic (para 3), 4: visual impact (para 3), 5: secondary fluid (para 4), 6: geographically limited (para 4)',
            'data' => [
                'instruction' => 'Write your answers in boxes 1–6 on your answer sheet.',
                'columns' => ['Technology', 'Primary Component / Material', 'Main Advantage', 'Significant Drawback'],
                'rows' => [
                    ['Solar PV', '[1] (mostly)', 'Rapidly falling costs', 'Known for its [2]'],
                    ['Wind Power', '[3] blades', 'High efficiency for power grids', 'Negative [4] and risk to wildlife'],
                    ['Geothermal', '[5] (in some plants)', 'Provides consistent \'baseload\' power', 'It is [6] to tectonic regions']
                ],
                'placeholders' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6]
            ],
            'order' => 1
        ]);

        $p11_3 = \App\Models\IeltsReadingPassage::create([
            'material_id' => 11,
            'title' => 'Engineering the Roman Empire',
            'content' => '<p>The longevity of the Roman Empire was due, in no small part, to its revolutionary approach to infrastructure. Roman engineers mastered the use of materials and geometric forms that allowed them to build structures that have survived for two millennia.</p>
            <p>The most critical innovation was the development of Roman concrete (opus caementicium). Unlike modern concrete, which often degrades in saltwater, the Roman version contained volcanic ash sourced from the Pozzuoli region. When mixed with lime, this created a chemical reaction that allowed the concrete to harden underwater and become even stronger over time. This enabled the construction of massive harbors and the foundations of the Colosseum, which could support the weight of 50,000 spectators.</p>
            <p>To provide water to their growing cities, the Romans built a network of aqueducts. These were marvels of gravitational engineering. To maintain a steady flow, engineers had to ensure a precise, consistent gradient over many kilometers. Where the water needed to cross a valley, they utilized the arch. This shape was superior to the traditional \'post-and-lintel\' system because it distributed weight outward toward the supports rather than downward, allowing for taller and more stable structures.</p>
            <p>Finally, the Roman road system, or viae, was the \'internet\' of the ancient world. These roads were built using a layered technique. The bottom layer consisted of large stones for drainage, followed by a middle layer of gravel or sand. The top surface was paved with flat polygonal stones that were fitted tightly together. This design prevented the roads from becoming muddy or washing away during heavy rain, ensuring that the Roman army and trade caravans could move at high speeds across the empire regardless of the season.</p>',
            'order' => 3
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p11_3->id,
            'question_number' => 1,
            'question_text' => 'Questions 1–6<br>Complete the table below.<br>Choose NO MORE THAN TWO WORDS from the passage for each answer.',
            'type' => 'table_completion',
            'options' => null,
            'correct_answer' => [
                '1' => 'volcanic ash',
                '2' => 'gradient',
                '3' => 'distribution',
                '4' => 'large stones',
                '5' => 'heavy rain',
                '6' => 'polygonal stones'
            ],
            'explanation' => '1: volcanic ash (para 2), 2: gradient (para 3), 3: distribution (para 3 - inference from distributed), 4: large stones (para 4), 5: heavy rain (para 4), 6: polygonal stones (para 4)',
            'data' => [
                'instruction' => 'Write your answers in boxes 1–6 on your answer sheet.',
                'columns' => ['Infrastructure', 'Key Material or Feature', 'Engineering Purpose', 'Result / Benefit'],
                'rows' => [
                    ['Foundations', '[1]', 'To enable building in or near water', 'Structures like the Colosseum remained stable.'],
                    ['Aqueducts', 'A very specific [2]', 'To keep water moving using gravity', 'Reliable water supply for cities.'],
                    ['Bridges / Arches', 'Curved shape', 'To achieve better [3] of weight', 'Possible to build across valleys.'],
                    ['Roman Roads', '[4]', 'To provide a base for effective drainage', 'Roads stayed dry during [5]'],
                    ['Road Surface', '[6]', 'To create a durable, tight-fitting top layer', 'Fast movement for military and trade.']
                ],
                'placeholders' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6]
            ],
            'order' => 1
        ]);

        $p11_4 = \App\Models\IeltsReadingPassage::create([
            'material_id' => 11,
            'title' => 'The Role of Vertical Stratification in Rainforests',
            'content' => '<p>Tropical rainforests are not merely a dense collection of trees; they are complex, multi-layered ecosystems. Scientists use the term \'vertical stratification\' to describe the distinct layers of vegetation, each characterized by different sunlight levels, humidity, and specialized wildlife.</p>
            <p>The highest layer is the Emergent Layer, where a few giant trees tower above the rest of the forest, reaching heights of up to 60 meters. These trees must be incredibly resilient to withstand high winds and intense solar radiation. Their leaves are often small and covered in a waxy coating to prevent water loss. Below them lies the Canopy, a thick, continuous ceiling of foliage. This layer acts as the forest\'s \'powerhouse,\' capturing about 90% of the sunlight. Because the branches are so tightly interwoven, many animals here use vines or \'lianas\' to navigate between trees without ever touching the ground.</p>
            <p>Beneath the canopy is the Understory, a dimly lit environment where plants have evolved large, broad leaves to capture the minimal light that filters through. This layer is very humid and still, providing a perfect habitat for many species of amphibians. Finally, there is the Forest Floor. Sunlight here is extremely scarce, often less than 2% of what reaches the top. Consequently, the floor is dominated by the process of decomposition. A massive network of fungi and bacteria breaks down fallen leaves and branches almost instantly, recycling nutrients back into the soil to fuel the growth of the giant trees above.</p>',
            'order' => 4
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p11_4->id,
            'question_number' => 1,
            'question_text' => 'Questions 1–6<br>Complete the table below.<br>Choose NO MORE THAN TWO WORDS from the passage for each answer.',
            'type' => 'table_completion',
            'options' => null,
            'correct_answer' => [
                '1' => 'waxy coating',
                '2' => 'lianas',
                '3' => '90%',
                '4' => 'broad leaves',
                '5' => 'decomposition',
                '6' => 'recycling'
            ],
            'explanation' => '1: waxy coating (para 2), 2: lianas (para 2), 3: 90% (para 2), 4: broad leaves (para 3), 5: decomposition (para 3), 6: recycling (para 3)',
            'data' => [
                'instruction' => 'Write your answers in boxes 1–6 on your answer sheet.',
                'columns' => ['Forest Layer', 'Typical Height / Feature', 'Survival Adaptation', 'Primary Role or Condition'],
                'rows' => [
                    ['Emergent', 'Up to 60 meters', 'Leaves have a [1]', 'To survive wind and sun'],
                    ['Canopy', 'Thick layer of foliage', 'Use of [2] for movement', 'Captures [3] of available light'],
                    ['Understory', 'Dimly lit', 'Possession of [4]', 'High humidity; home to amphibians'],
                    ['Forest Floor', 'Extremely low light', 'Reliance on [5]', 'Rapid [6] of organic matter']
                ],
                'placeholders' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6]
            ],
            'order' => 1
        ]);

        $p11_5 = \App\Models\IeltsReadingPassage::create([
            'material_id' => 11,
            'title' => 'The Mechanics of Avian Flight',
            'content' => '<p>The ability of birds to fly is one of the most sophisticated examples of natural engineering. This feat is made possible by a combination of specialized anatomy and the laws of physics. To achieve lift, a bird’s wing is shaped like an airfoil, being curved on the top and flatter on the bottom. This shape forces air to move faster over the upper surface, creating lower pressure and allowing the bird to rise.</p>
            <p>Different species have evolved specific wing shapes to suit their environments. For instance, the Albatross possesses extremely long, narrow wings designed for \'dynamic soaring.\' This allows the bird to travel vast distances over the ocean with minimal flapping. In contrast, the Peregrine Falcon has pointed, swept-back wings that reduce drag, enabling it to reach record-breaking speeds during a dive.</p>
            <p>The internal structure of birds is equally important. To minimize weight, birds have evolved hollow bones reinforced with internal struts. Furthermore, their respiratory system is highly efficient; they possess air sacs that ensure a constant flow of oxygen through the lungs, even during exhalation. This high oxygen intake is necessary to power the large pectoral muscles, which provide the strength required for flight.</p>',
            'order' => 5
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p11_5->id,
            'question_number' => 1,
            'question_text' => 'Questions 1–6<br>Complete the table below.<br>Choose NO MORE THAN ONE WORD AND/OR A NUMBER from the passage for each answer.',
            'type' => 'table_completion',
            'options' => null,
            'correct_answer' => [
                '1' => 'airfoil',
                '2' => 'flapping',
                '3' => 'drag',
                '4' => 'hollow',
                '5' => 'sacs',
                '6' => 'muscles'
            ],
            'explanation' => '1: airfoil (para 1), 2: flapping (para 2), 3: drag (para 2), 4: hollow (para 3), 5: sacs (para 3 - from air sacs), 6: muscles (para 3 - from pectoral muscles)',
            'data' => [
                'instruction' => 'Write your answers in boxes 1–6 on your answer sheet.',
                'columns' => ['Bird / Feature', 'Anatomical Part', 'Primary Function', 'Physical Result'],
                'rows' => [
                    ['General Bird', 'Wing', 'Acts as an [1]', 'Generates lift'],
                    ['Albatross', 'Long wings', 'Reduces the need for [2]', 'Energy-efficient travel'],
                    ['Falcon', 'Pointed wings', 'Minimizes [3]', 'High-speed diving'],
                    ['Skeleton', '[4] bones', 'Decreases total mass', 'Easier takeoff'],
                    ['Respiratory', '[5]', 'Supplies continuous oxygen', 'Sustained energy'],
                    ['Muscles', '[6]', 'Provides power for wings', 'Strong flight']
                ],
                'placeholders' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6]
            ],
            'order' => 1
        ]);
        // Material 12
        // Idempotency: Cleanup existing Material 12 passages
        \App\Models\IeltsReadingPassage::where('material_id', 12)->each(function ($passage) {
            $passage->questions()->delete();
            $passage->delete();
        });

        $p12 = \App\Models\IeltsReadingPassage::create([
            'material_id' => 12,
            'title' => 'School Experiments Reading Passage',
            'content' => '<p>It is essential when conducting this experiment to wear safety goggles. This experiment is divided into four distinct sections. The first, the reaction stage, is when a glass beaker is placed on top of a tripod, and 20cm of dilute sulphuric acid poured into it. The acid is then heated. When it is almost boiling, a small quantity of copper oxide powder is added to the beaker. The mixture is then stirred with a glass spatula until the copper oxide has dissolved. This process is then repeated until 1g of powder has been added to the sulphuric acid. The heat is then removed from the beaker and the solution allowed to cool. The second stage is the filtration stage and, as the name suggests, is where a filter and conical flask are used to remove any copper oxide that has not reacted. A clear copper sulphate solution will be left in the glass dish. The third stage is where heat is applied to the copper sulphate solution in order to concentrate the solution: the concentration stage. The final crystallization stage happens when the solution begins to cool, and pure copper sulphate crystals start to form.</p>',
            'order' => 1
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $p12->id,
            'question_number' => 1,
            'question_text' => 'Questions 1–6<br>The diagram below shows how copper sulphate can be made using simple laboratory equipment.<br>Choose NO MORE THAN THREE WORDS AND/OR A NUMBER from the passage for each answer.<br>Label the diagram.',
            'type' => 'diagram_labelling',
            'options' => null,
            'correct_answer' => [
                '1' => 'filtration',
                '2' => 'crystallization',
                '3' => 'beaker',
                '4' => 'filter',
                '5' => 'glass dish',
                '6' => 'crystals'
            ],
            'explanation' => '1: filtration (para 1 - second stage), 2: crystallization (para 1 - final stage), 3: beaker (para 1 - placed on tripod), 4: filter (para 1 - used in filtration), 5: glass dish (para 1 - solution left in), 6: crystals (para 1 - copper sulphate crystals form)',
            'data' => [
                'image' => '/images/ielts-reading/copper_sulphate_process.png',
                'sub_questions' => [
                    ['id' => '1', 'label' => '1', 'x' => 30, 'y' => 53],
                    ['id' => '2', 'label' => '2', 'x' => 72, 'y' => 53],
                    ['id' => '3', 'label' => '3', 'x' => 10, 'y' => 73],
                    ['id' => '4', 'label' => '4', 'x' => 45, 'y' => 66],
                    ['id' => '5', 'label' => '5', 'x' => 45, 'y' => 89],
                    ['id' => '6', 'label' => '6', 'x' => 75, 'y' => 89]
                ]
            ],
            'order' => 1
        ]);
    }
}
