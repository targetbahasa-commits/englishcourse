<?php

namespace App\Application\IeltsReading;

class BuildLegacyIeltsReadingMaterialData
{
    private const MATERIALS = [
        1 => [
            'title' => 'Practice Test 1',
            'content' => [
                [
                    'passage_title' => 'The Architecture of Silence',
                    'passage_text' => '<p><strong>A</strong> Noise pollution is an increasingly omnipresent byproduct of modern urban life, yet its impact on human health remains dangerously underestimated. While sudden, loud sounds trigger an immediate \'fight or flight\' response, chronic exposure to low-level urban hums—traffic, air conditioning, and distant construction—exerts a sustained physiological toll. Research indicates that persistent noise elevates cortisol levels and contributes to cardiovascular distress. Consequently, architects and urban planners are beginning to prioritize \'acoustic comfort\' not as a luxury, but as a fundamental biological necessity for city dwellers.</p>
                    <p><strong>B</strong> The challenge for modern designers lies in the limitations of traditional soundproofing. For decades, the standard approach was \'blocking\'—using thick, dense materials like concrete and lead to stop sound waves. However, in the era of sustainable architecture, these heavy materials are often impractical or environmentally costly. New research focuses on \'acoustic metamaterials,\' which are engineered to manipulate sound waves at a structural level. By using geometric patterns instead of raw mass, these materials can reflect or absorb specific frequencies, allowing for lightweight, breathable walls that offer superior silence.</p>
                    <p><strong>C</strong> Beyond physical barriers, there is a growing interest in \'biophonic masking.\' This technique involves introducing natural sounds—such as falling water or rustling leaves—into urban spaces to cover unpleasant mechanical noise. Psychologically, humans find natural sounds less intrusive than synthetic ones, even at the same decibel level. By integrating fountains or wind-sensitive installations into plazas, designers can create a \'perceived\' sense of quiet. This shift from total silence to \'pleasant soundscapes\' represents a more nuanced understanding of how the human brain processes environmental information.</p>
                    <p><strong>D</strong> The economic implications of acoustic design are also becoming clearer. Studies in corporate environments have shown that poor acoustics lead to a significant drop in employee productivity and an increase in absenteeism. In open-plan offices, the constant distraction of overheard conversations can reduce cognitive performance by up to 60%. Conversely, workplaces that invest in high-quality acoustic treatments report higher levels of staff retention and focus. As a result, \'quiet\' is increasingly being marketed as a premium feature in commercial real estate, driving up property values in noisy metropolitan hubs.</p>
                    <p><strong>E</strong> Looking ahead, the future of urban silence may lie in \'active\' technologies similar to noise-canceling headphones but on a structural scale. \'Active Noise Control\' (ANC) systems use microphones to detect incoming sound and speakers to produce an \'anti-noise\' wave that cancels it out. While currently expensive and energy-intensive to implement in large buildings, advancements in smart-city infrastructure could eventually see these systems integrated into windows and facades. This would allow residents to keep their windows open to fresh air while electronically filtering out the roar of the city outside.</p>',
                    'questions' => [
                        [
                            'id' => 1,
                            'text' => 'The Reading Passage has five paragraphs, A–E. Choose the correct heading for each paragraph from the list of headings below.',
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
                            'sub_questions' => [
                                ['id' => '1a', 'label' => 'Paragraph A', 'correct_answer' => 'iii'],
                                ['id' => '1b', 'label' => 'Paragraph B', 'correct_answer' => 'vi'],
                                ['id' => '1c', 'label' => 'Paragraph C', 'correct_answer' => 'ii'],
                                ['id' => '1d', 'label' => 'Paragraph D', 'correct_answer' => 'i'],
                                ['id' => '1e', 'label' => 'Paragraph E', 'correct_answer' => 'iv'],
                            ],
                            'correct_answer' => ['1a' => 'iii', '1b' => 'vi', '1c' => 'ii', '1d' => 'i', '1e' => 'iv'],
                            'explanation' => 'A: iii (persistent noise elevates cortisol). B: vi (acoustic metamaterials, geometric patterns). C: ii (psychologically... natural sounds). D: i (economic implications, productivity). E: iv (active technologies, noise-canceling).',
                        ],
                    ],
                ],
                [
                    'passage_title' => 'The Evolutionary Purpose of Ritual',
                    'passage_text' => '<p><strong>A</strong> Ritualized behavior is a cross-cultural universal, observed in every human society from hunter-gatherer tribes to modern metropolitan civilizations. To a detached observer, many rituals—such as elaborate dance ceremonies or the repetitive chanting of mantras—may appear \'non-functional\' because they do not produce a direct material result like gathering food or building shelter. However, evolutionary anthropologists argue that these behaviors are far from purposeless. Instead, they serve as vital social glue, signaling an individual\'s commitment to a group and reducing the potential for internal conflict.</p>
                    <p><strong>B</strong> One prominent theory suggests that rituals act as a \'costly signaling\' mechanism. In evolutionary biology, a signal is considered reliable only if it is difficult or \'costly\' to perform. For instance, a ritual that requires significant time, physical effort, or even pain serves as a badge of loyalty. By enduring these costs, participants demonstrate that their commitment to the community is genuine, making it harder for \'free-riders\'—individuals who take the benefits of the group without contributing—to infiltrate the social circle. This ensures that cooperation remains stable and trust is maintained.</p>
                    <p><strong>C</strong> From a neurological perspective, collective rituals have a profound impact on the human endocrine system. Engaging in rhythmic, synchronized movements—such as marching or collective drumming—triggers the release of endorphins and oxytocin. These chemicals are known to enhance feelings of social bonding and empathy. This \'inter-brain synchrony\' allows participants to feel as though they are part of a single, larger organism. In the harsh environments of our ancestors, this heightened sense of unity provided a decisive survival advantage during tribal warfare or periods of resource scarcity.</p>
                    <p><strong>D</strong> Rituals also play a crucial role in managing existential anxiety. Life is inherently unpredictable, filled with risks that are beyond human control, such as natural disasters or illness. Psychological studies have shown that in times of high stress, people tend to revert to repetitive, ritualized actions. These \'control-simulating\' behaviors provide a sense of order and predictability in a chaotic world. Even if the ritual does not change the external outcome, the internal psychological stability it provides allows individuals to remain functional and proactive rather than becoming paralyzed by fear.</p>
                    <p><strong>E</strong> In the contemporary era, the form of rituals has shifted, but their underlying function persists. While traditional religious ceremonies may be declining in some secular societies, they are being replaced by \'secular rituals\' in sports, politics, and technology. The intense fervor of fans at a football stadium or the meticulously choreographed product launches in the tech industry mirror the structure of ancient rites. These modern iterations continue to satisfy the deep-seated human need for belonging and shared meaning, proving that the ritualistic brain is a permanent feature of our species.</p>',
                    'questions' => [
                        [
                            'id' => 2,
                            'start_number' => 5,
                            'text' => 'The Reading Passage has five paragraphs, A–E. Choose the correct heading for each paragraph from the list of headings below.',
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
                            'sub_questions' => [
                                ['id' => '2a', 'label' => 'Paragraph A', 'correct_answer' => 'v'],
                                ['id' => '2b', 'label' => 'Paragraph B', 'correct_answer' => 'iii'],
                                ['id' => '2c', 'label' => 'Paragraph C', 'correct_answer' => 'iv'],
                                ['id' => '2d', 'label' => 'Paragraph D', 'correct_answer' => 'i'],
                                ['id' => '2e', 'label' => 'Paragraph E', 'correct_answer' => 'vii'],
                            ],
                            'correct_answer' => ['2a' => 'v', '2b' => 'iii', '2c' => 'iv', '2d' => 'i', '2e' => 'vii'],
                            'explanation' => 'A: v (appear non-functional). B: iii (prevent free-riders/exploitation). C: iv (endorphins/synchronized action). D: i (managing anxiety/stress). E: vii (persistence/permanent feature).',
                        ],
                    ],
                ],
                [
                    'passage_title' => 'Nature’s Blueprints: The Rise of Biomimicry',
                    'passage_text' => '<p><strong>A</strong> For centuries, human engineering has relied on \'brute force\' methods—using high heat, extreme pressure, and synthetic chemicals to manufacture materials. However, as the environmental cost of these processes becomes untenable, scientists are increasingly looking to biomimicry. This discipline involves studying nature’s time-tested patterns and strategies to solve 21st-century design challenges. Unlike traditional manufacturing, nature assembles complex structures at ambient temperatures and without toxic byproducts, offering a paradigm shift in how we conceive of \'innovation.\'</p>
                <p><strong>B</strong> One of the most celebrated examples is the study of the lotus leaf, which possesses a self-cleaning surface. On a microscopic level, the leaf is covered in tiny, wax-capped protrusions that prevent water droplets from adhering to the surface. Instead, water spheres roll off, carrying dirt particles with them. This \'lotus effect\' has been successfully replicated to create hydrophobic paints and glass surfaces for skyscrapers, significantly reducing the need for chemical detergents and labor-intensive maintenance in urban environments.</p>
                <p><strong>C</strong> Another breakthrough has emerged from the study of the Namib Desert beetle, which survives in one of the most arid regions on Earth. The beetle’s back features a unique arrangement of hydrophilic (water-attracting) bumps and hydrophobic (water-repelling) troughs. This allows it to capture moisture from morning fogs, which then trickles directly into its mouth. Engineers are now developing \'fog-harvesting\' nets based on this biological blueprint to provide clean drinking water for impoverished coastal communities where rainfall is scarce but humidity is high.</p>
                <p><strong>D</strong> Despite its potential, biomimicry faces significant hurdles in scaling from laboratory prototypes to industrial applications. Biological structures are often \'multifunctional,\' meaning a single surface might provide structural support, thermal regulation, and sensory input simultaneously. Replicating this level of integrated complexity using current 3D printing or chemical vapor deposition is extraordinarily difficult. Critics also point out that while nature is efficient, it operates on an evolutionary timescale of millions of years, whereas market demands require immediate results.</p>
                <p><strong>E</strong> The philosophical underpinning of biomimicry represents a move away from \'human exceptionalism\'—the idea that humans are separate from and superior to the natural world. Instead, it positions nature as a mentor rather than a mere warehouse of resources. By observing how a spider weaves silk that is stronger than steel yet flexible, or how coral reefs build massive calcium structures while sequestering carbon, we may find the keys to a \'regenerative\' economy that restores the planet rather than merely depleting it.</p>',
                    'questions' => [
                        [
                            'id' => 3,
                            'start_number' => 11,
                            'text' => 'The Reading Passage has five paragraphs, A–E. Choose the correct heading for each paragraph from the list of headings below.',
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
                            'sub_questions' => [
                                ['id' => '3a', 'label' => 'Paragraph A', 'correct_answer' => 'iv'],
                                ['id' => '3b', 'label' => 'Paragraph B', 'correct_answer' => 'v'],
                                ['id' => '3c', 'label' => 'Paragraph C', 'correct_answer' => 'vi'],
                                ['id' => '3d', 'label' => 'Paragraph D', 'correct_answer' => 'i'],
                                ['id' => '3e', 'label' => 'Paragraph E', 'correct_answer' => 'ii'],
                            ],
                            'correct_answer' => ['3a' => 'iv', '3b' => 'v', '3c' => 'vi', '3d' => 'i', '3e' => 'ii'],
                            'explanation' => 'A: iv (brute force vs ambient temps). B: v (lotus effect/maintenance). C: vi (fog-harvesting/Namib beetle). D: i (hurdles/complexity). E: ii (move away from human exceptionalism).',
                        ],
                    ],
                ],
                [
                    'passage_title' => 'The Ethics of the Augmented Mind',
                    'passage_text' => '<p><strong>A</strong> Brain-Computer Interfaces (BCIs) were once the province of science fiction, but recent breakthroughs in neural engineering have brought them into the clinical mainstream. At its core, BCI technology establishes a direct communication pathway between the brain’s electrical signals and an external device, such as a robotic limb or a computer cursor. For individuals with locked-in syndrome or severe paralysis, these devices offer a radical restoration of autonomy. By bypassing damaged spinal cords, BCIs allow patients to re-engage with the world, proving that the boundary between biological thought and digital action is increasingly porous.</p>
                    <p><strong>B</strong> However, as the technology migrates from restorative medicine to \'human enhancement,\' a host of neuroethical concerns has emerged. If a BCI can be used to restore lost motor function, could it also be used to augment the cognitive abilities of healthy individuals? The prospect of \'neural implants\' that enhance memory or processing speed raises the specter of a cognitive divide. In a society where mental performance can be purchased, the gap between the \'enhanced\' elite and the \'unaugmented\' majority could lead to a new form of systemic inequality, far more profound than wealth alone.</p>
                    <p><strong>C</strong> A more subtle but equally troubling issue involves the concept of \'agency\' and moral responsibility. When a person operates a device through a BCI, the line between the user’s intent and the machine’s autonomous algorithms becomes blurred. If a robotic arm controlled by a BCI accidentally causes harm, is the user responsible, or was it a software malfunction? Current legal frameworks are ill-equipped to handle actions that originate in a hybrid of human thought and machine code, necessitating a complete re-evaluation of what it means to be a \'responsible actor.\'</p>
                    <p><strong>D</strong> Data privacy also takes on a new dimension when the data being harvested is neural. Unlike traditional digital footprints, which track our external behaviors, BCIs have the potential to access \'brain-data\'—the raw signals of our subconscious reactions and emotions. Critics warn that without strict regulations, corporations could theoretically monitor a user\'s private thoughts or predispositions for marketing purposes. This \'neuro-surveillance\' represents the ultimate intrusion into the final frontier of privacy: the human mind.</p>
                    <p><strong>E</strong> Despite these risks, proponents argue that the development of BCIs is an inevitable step in human evolution. They suggest that our current tools—smartphones and computers—already act as \'external brains,\' albeit with slow input methods like typing. BCIs simply eliminate the \'bottleneck\' of the physical body, allowing for a more seamless integration with the vast information networks we have created. From this perspective, the ethical hurdles are not reasons to halt progress, but rather parameters that must be carefully managed as we transition into a post-biological era.</p>',
                    'questions' => [
                        [
                            'id' => 4,
                            'start_number' => 16,
                            'text' => 'The Reading Passage has five paragraphs, A–E. Choose the correct heading for each paragraph from the list of headings below.',
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
                            'sub_questions' => [
                                ['id' => '4a', 'label' => 'Paragraph A', 'correct_answer' => 'iii'],
                                ['id' => '4b', 'label' => 'Paragraph B', 'correct_answer' => 'i'],
                                ['id' => '4c', 'label' => 'Paragraph C', 'correct_answer' => 'iv'],
                                ['id' => '4d', 'label' => 'Paragraph D', 'correct_answer' => 'vi'],
                                ['id' => '4e', 'label' => 'Paragraph E', 'correct_answer' => 'vii'],
                            ],
                            'correct_answer' => ['4a' => 'iii', '4b' => 'i', '4c' => 'iv', '4d' => 'vi', '4e' => 'vii'],
                            'explanation' => 'A: iii (restoration of autonomy). B: i (cognitive divide/inequality). C: iv (agency/responsibility). D: vi (privacy/neuro-surveillance). E: vii (inevitable step/integration).',
                        ],
                    ],
                ],
            ],
        ],
        2 => [
            'title' => 'Practice Test 2',
            'content' => [
                [
                    'passage_title' => 'The Dynamics of Modern Environments',
                    'passage_text' => 'Urban planning today often incorporates biophilic design, a philosophy suggesting that humans have an innate need to connect with nature. By integrating natural light and vegetation into buildings, architects aim to reduce stress and improve mental well-being. This approach views nature not as a decoration, but as a fundamental requirement for healthy urban living.<br><br>However, the effectiveness of our surroundings also impacts how we learn. The encoding specificity principle in psychology states that memory retrieval is most successful when the environment of recall matches the environment where the information was first learned. Sensory cues, such as the specific lighting of a room, become linked to the data in our brains. Consequently, moving from a comfortable study area to a sterile exam hall can hinder a student\'s performance.<br><br>On a larger scale, human actions can disrupt biological balances through trophic cascades. This occurs when the removal of a top predator—like a wolf or shark—triggers a ripple effect throughout the entire food web. Without a predator to control their numbers, prey populations may explode and overconsume primary resources, leading to a collapse of local biodiversity and ecosystem stability.',
                    'questions' => [
                        ['id' => 1, 'text' => 'What is the primary belief behind \'biophilic design\'?', 'options' => ['A' => 'Buildings should be decorated with expensive organic materials.', 'B' => 'Human health is improved through a physical connection to nature.', 'C' => 'Natural light is the only factor that reduces stress in cities.', 'D' => 'Architecture should prioritize aesthetic beauty over functionality.'], 'correct_answer' => 'B', 'explanation' => 'The text states that biophilic design suggests "humans have an innate need to connect with nature" and aims to "reduce stress and improve mental well-being".'],
                        ['id' => 2, 'text' => 'According to the \'encoding specificity principle\', students perform better when:', 'options' => ['A' => 'They study in a completely silent and sterile environment.', 'B' => 'They use sensory cues to distract themselves from exam pressure.', 'C' => 'The place where they take an exam is similar to where they studied.', 'D' => 'They memorize data without relying on their physical surroundings.'], 'correct_answer' => 'C', 'explanation' => 'The principle states that "memory retrieval is most successful when the environment of recall matches the environment where the information was first learned".'],
                        ['id' => 3, 'text' => 'What happens during a \'trophic cascade\' if a top predator is removed?', 'options' => ['A' => 'The entire food web immediately becomes more stable.', 'B' => 'Prey populations decrease because they have no one to follow.', 'C' => 'Other species in the ecosystem begin to evolve more quickly.', 'D' => 'A chain reaction occurs that can lead to the loss of biodiversity.'], 'correct_answer' => 'D', 'explanation' => 'The text explains that removing a top predator "triggers a ripple effect" (chain reaction) leading to "a collapse of local biodiversity".'],
                    ],
                ],
                [
                    'passage_title' => 'The Future of Food: Vertical Farming',
                    'passage_text' => 'As the global population is projected to reach nearly 10 billion by 2050, traditional agriculture faces unprecedented pressure. The depletion of arable land and the unpredictability of climate change have led to the rise of vertical farming. This method involves growing crops in stacked layers, often integrated into urban structures like warehouses or skyscrapers. Unlike conventional farming, vertical farms use controlled-environment agriculture (CEA) technology, which allows for total regulation of temperature, light, and humidity.<br><br>One of the primary advantages of this system is its extreme resource efficiency. Vertical farming typically utilizes hydroponics or aeroponics, where plants are grown in nutrient-rich water or mist rather than soil. This can reduce water consumption by up to 95% compared to traditional field farming. Furthermore, because these farms are located indoors, they are immune to weather-related crop failures and can produce food year-round, significantly increasing the annual yield per square meter.<br><br>However, the high energy demand remains a significant drawback. To replace natural sunlight, vertical farms rely on powerful LED lighting systems that consume vast amounts of electricity. If this energy is sourced from fossil fuels, the carbon footprint of vertical farming could potentially exceed that of traditional methods, despite the reduction in transportation distances. Consequently, the long-term sustainability of urban agriculture depends heavily on the integration of renewable energy sources and the continuous improvement of light-emitting technology.',
                    'questions' => [
                        ['id' => 4, 'text' => 'According to the first paragraph, what is a key feature of vertical farming?', 'options' => ['A' => 'It relies on the availability of vast areas of traditional arable land.', 'B' => 'It is primarily used to grow crops in rural, open-field environments.', 'C' => 'It allows for complete control over the climate conditions of the crops.', 'D' => 'It is a method developed to reduce the global population by 2050.'], 'correct_answer' => 'C', 'explanation' => 'The text states that vertical farms use "controlled-environment agriculture (CEA) technology, which allows for total regulation of temperature, light, and humidity".'],
                        ['id' => 5, 'text' => 'What is mentioned about the use of water in vertical farming?', 'options' => ['A' => 'It requires more water than traditional farming due to the misting systems.', 'B' => 'It uses hydroponics to ensure that soil stays nutrient-rich for longer periods.', 'C' => 'It is significantly more efficient than conventional methods of irrigation.', 'D' => 'It depends on natural rainfall to maintain the humidity in urban warehouses.'], 'correct_answer' => 'C', 'explanation' => 'The text mentions that vertical farming "can reduce water consumption by up to 95% compared to traditional field farming", making it significantly more efficient.'],
                        ['id' => 6, 'text' => 'What is the main concern regarding the environmental impact of vertical farms?', 'options' => ['A' => 'The large amount of electricity required for artificial lighting.', 'B' => 'The long distances that food must travel to reach urban consumers.', 'C' => 'The lack of renewable energy sources available in modern skyscrapers.', 'D' => 'The inability of LED lights to produce enough food for the entire year.'], 'correct_answer' => 'A', 'explanation' => 'The text identifies "the high energy demand" as a "significant drawback", specifically mentioning that vertical farms "rely on powerful LED lighting systems that consume vast amounts of electricity".'],
                    ],
                ],
                [
                    'passage_title' => 'The Plasticity of the Linguistic Brain',
                    'passage_text' => 'Neuroplasticity, the brain\'s remarkable ability to reorganize itself by forming new neural connections throughout life, is perhaps most evident in the realm of language acquisition. Historically, it was believed that the brain\'s structural development was largely fixed after a \'critical period\' in early childhood. However, contemporary neuroimaging techniques have debunked this notion, revealing that the adult brain retains a surprising degree of malleability. When an individual learns a secondary language, the structural density of the grey matter in the left inferior parietal cortex typically increases. This structural density is positively correlated with proficiency and the age at which the language was acquired; the earlier the start, the more profound the anatomical transformation.<br><br>Despite this inherent flexibility, the process of bilingualism presents a significant cognitive load. The brain must develop executive control mechanisms to suppress the \'interfering\' language while the target language is being spoken. This constant mental gymnastics is thought to provide a form of \'cognitive reserve,\' which can delay the onset of neurodegenerative symptoms in later life. Researchers have observed that bilingual seniors often exhibit stronger \'inhibitory control\'—the ability to ignore irrelevant stimuli—compared to their monolingual counterparts.<br><br>Nevertheless, the degree of plasticity is influenced by several variables. Intensity and consistency of exposure are paramount. Passive listening, for instance, fails to trigger the same level of synaptic firing as active production and social interaction. Furthermore, emotional engagement plays a subtle yet vital role; information processed in a state of high motivation or emotional relevance is more likely to be encoded into long-term memory through the strengthening of synaptic pathways.',
                    'questions' => [
                        ['id' => 7, 'text' => 'Which TWO of the following findings are mentioned by the author in the text?', 'type' => 'checkbox', 'options' => ['A' => 'The brain’s physical structure remains unchanged once a child reaches a certain age.', 'B' => 'Learning a second language can lead to physical changes in specific parts of the brain.', 'C' => 'Proficiency in a language is unrelated to the structural density of the brain\'s grey matter.', 'D' => 'Bilingual individuals may experience a delay in the symptoms of certain brain diseases.', 'E' => 'Passive listening is as effective as active conversation for creating new neural pathways.'], 'correct_answer' => ['B', 'D'], 'explanation' => 'Finding B is supported by "structural density... typically increases". Finding D is supported by "can delay the onset of neurodegenerative symptoms".'],
                        ['id' => 8, 'text' => 'Which TWO factors are identified as essential for maximizing the brain’s ability to reorganize during language learning?', 'type' => 'checkbox', 'options' => ['A' => 'The use of advanced neuroimaging techniques during the learning process.', 'B' => 'High levels of personal motivation or emotional connection to the material.', 'C' => 'Constant exposure to irrelevant stimuli to improve inhibitory control.', 'D' => 'Regular and active participation in social communication.', 'E' => 'Focusing exclusively on the critical period of early childhood development.'], 'correct_answer' => ['B', 'D'], 'explanation' => 'Factor B is supported by "information processed in a state of high motivation... is more likely to be encoded". Factor D is supported by "active production and social interaction" as opposed to passive listening.'],
                    ],
                ],
                [
                    'passage_title' => 'The Chronometry of Trees: Insights into Paleoclimatology',
                    'passage_text' => 'The study of tree rings, or dendrochronology, has transcended its original purpose of dating archaeological artifacts to become a cornerstone of paleoclimatology. By analyzing the annual growth rings of long-lived species, such as the Great Basin bristlecone pine, scientists can reconstruct climatic conditions dating back thousands of years. Each ring\'s width, density, and isotopic composition serve as a proxy for environmental variables. A wide ring typically indicates a growing season with abundant moisture and optimal temperatures, whereas narrow rings signify periods of environmental stress, such as prolonged droughts or volcanic winters.<br><br>However, interpreting this biological data requires a sophisticated understanding of \'limiting factors.\' According to this principle, tree growth is not influenced by every environmental change but is primarily restricted by the single most deficient resource. In arid regions, ring width is almost exclusively a reflection of precipitation levels. Conversely, in subarctic tree lines, the rings are more sensitive to fluctuations in thermal intensity. Therefore, a researcher must carefully select the site of their sample; a tree growing in a sheltered valley with consistent groundwater may produce \'complacent\' rings, which are uniform in width and provide negligible climatic information.<br><br>Beyond simple growth patterns, the emerging field of \'blue intensity\' (BI) and stable isotope analysis is refining our climate reconstructions. By measuring the way wood cells reflect blue light, scientists can determine summer temperatures with unprecedented precision, bypassing some of the statistical noise inherent in traditional ring-width measurements. These high-resolution records are vital for distinguishing between natural climatic variability—such as the Medieval Warm Period—and the accelerated warming trends of the Anthropocene, providing a critical historical baseline for contemporary climate models.',
                    'questions' => [
                        ['id' => 9, 'text' => 'Which TWO of the following environmental indicators can be determined by studying tree rings?', 'type' => 'checkbox', 'options' => ['A' => 'The exact date of future volcanic eruptions in a specific region.', 'B' => 'Historical periods of extreme dryness or lack of rainfall.', 'C' => 'The precise age of all archaeological artifacts found globally.', 'D' => 'Fluctuations in temperature levels over thousands of years.', 'E' => 'The rate of groundwater depletion in sheltered valleys.'], 'correct_answer' => ['B', 'D'], 'explanation' => 'Indicator B (periods of extreme dryness) is supported by "narrow rings signify periods of environmental stress, such as prolonged droughts". Indicator D (fluctuations in temperature) is supported by "scientists can reconstruct climatic conditions dating back thousands of years" and "determine summer temperatures".'],
                        ['id' => 10, 'text' => 'Which TWO conditions are described by the author as problematic for accurate climate reconstruction?', 'type' => 'checkbox', 'options' => ['A' => 'Trees that have access to a constant and stable water supply.', 'B' => 'The use of blue light reflection to measure wood cell density.', 'C' => 'Analyzing trees that are located at subarctic tree lines.', 'D' => 'Statistical noise that often occurs in traditional ring-width data.', 'E' => 'The presence of nutrient-rich soil in arid regions.'], 'correct_answer' => ['A', 'D'], 'explanation' => 'Condition A is problematic because "a tree growing in a sheltered valley with consistent groundwater may produce \'complacent\' rings... providing negligible climatic information". Condition D is implied as a problem that BI overcomes ("bypassing some of the statistical noise inherent in traditional ring-width measurements").'],
                    ],
                ],
            ],
        ],
        3 => [
            'title' => 'Practice Test 3',
            'content' => [
                [
                    'passage_title' => 'The Resilience of Mangrove Ecosystems',
                    'passage_text' => '<p>Mangroves are a unique group of salt-tolerant trees and shrubs that flourish in the harsh, brackish waters of tropical and subtropical coastlines. For decades, these coastal forests were dismissed as swampy wastelands, often cleared to make way for urban development and commercial aquaculture. However, modern environmental science has revealed that mangroves are among the most productive and complex ecosystems on Earth, providing a biological buffer between the land and the sea.</p>
                    <p>The most striking feature of the mangrove is its complex root system. Because the coastal soil is typically waterlogged and lacks oxygen (anaerobic), mangroves have evolved specialized structures known as pneumatophores. These are aerial roots that grow upward from the mud into the air, acting like snorkels to absorb oxygen for the submerged parts of the plant. Additionally, the dense tangle of \'prop roots\' helps the trees withstand the relentless force of tides and storm surges, while simultaneously trapping sediments that would otherwise smother coral reefs further offshore.</p>
                    <p>Beyond coastal protection, mangroves are extraordinary carbon sinks. They are capable of sequestering carbon dioxide at rates up to four times greater than mature tropical rainforests. Most of this carbon is stored not in the wood of the trees, but in the thick, organic-rich mud beneath them. This \'blue carbon\' remains trapped for centuries unless the ecosystem is disturbed. If these forests are destroyed, the stored carbon is released back into the atmosphere, significantly accelerating global warming.</p>
                    <p>Furthermore, mangroves serve as vital \'nurseries\' for marine life. The sheltered waters within the root networks provide a safe haven for juvenile fish, crabs, and shrimp, protecting them from larger predators. It is estimated that approximately 75% of commercially caught fish species in many tropical regions depend on mangroves at some point during their life cycle. Thus, the preservation of these forests is not just an environmental concern, but a prerequisite for the economic stability of global fishing industries.</p>',
                    'questions' => [
                        ['id' => 1, 'text' => 'What was the historical perception of mangrove forests before they were valued by scientists?', 'type' => 'short_answer', 'correct_answer' => 'swampy wastelands'],
                        ['id' => 2, 'text' => 'Which part of the mangrove plant allows it to take in oxygen in anaerobic soil conditions?', 'type' => 'short_answer', 'correct_answer' => 'pneumatophores'],
                        ['id' => 3, 'text' => 'What material is prevented from reaching coral reefs by the mangrove\'s prop roots?', 'type' => 'short_answer', 'correct_answer' => 'sediments'],
                        ['id' => 4, 'text' => 'Where is the majority of a mangrove’s \'blue carbon\' kept?', 'type' => 'short_answer', 'correct_answer' => 'organic-rich mud'],
                        ['id' => 5, 'text' => 'Which group of animals relies on the protection of mangrove roots during their early stages of growth?', 'type' => 'short_answer', 'correct_answer' => 'juvenile fish'],
                    ],
                ],
                [
                    'passage_title' => 'The Hunt for Earth 2.0: Methods of Exoplanet Detection',
                    'passage_text' => '<p>For most of human history, the existence of planets outside our solar system remained purely speculative. It was not until the 1990s that astronomers confirmed the presence of \'exoplanets\'—worlds orbiting distant stars. Since then, the field has transitioned from mere discovery to a sophisticated analysis of planetary atmospheres, driven by the desire to find a \'habitable\' twin to Earth.</p>
                    <p>The most prolific technique used by space telescopes, such as Kepler and TESS, is the Transit Photometry method. This approach involves monitoring the brightness of a star over an extended period. If a planet passes—or \'transits\'—directly between the star and the observer, it causes a minuscule, periodic dip in the star\'s luminosity. By measuring the depth and duration of this dimming, researchers can calculate the planet’s physical size and its orbital period. However, this method is limited by \'geometric probability,\' as it requires the planet\'s orbit to be perfectly aligned with our line of sight.</p>
                    <p>For planets that do not transit, astronomers rely on the Radial Velocity method, often referred to as \'Doppler Spectroscopy.\' This technique detects the subtle \'wobble\' of a star caused by the gravitational tug of an orbiting planet. As the star moves slightly toward or away from Earth, its light undergoes a frequency shift. Using high-precision spectrometers, scientists can measure these shifts to determine the planet\'s mass. While highly effective, this method is most sensitive to massive, \'Jupiter-sized\' planets located close to their host stars.</p>
                    <p>The ultimate frontier in exoplanet research is Direct Imaging. This is exceptionally challenging because the faint light reflected by a planet is usually overwhelmed by the intense glare of its parent star. To overcome this, astronomers use a device called a coronagraph to mask the star\'s light, much like using a visor to block the sun while driving. This allows the much dimmer planetary bodies to become visible. Through this method, we can begin to analyze the chemical composition of a planet\'s atmosphere, searching for \'biosignatures\' such as oxygen and methane that might indicate the presence of life.</p>',
                    'questions' => [
                        ['id' => 6, 'start_number' => 6, 'text' => 'What was the status of exoplanet existence before the late 20th century?', 'type' => 'short_answer', 'correct_answer' => 'purely speculative'],
                        ['id' => 7, 'text' => 'What specific change in a star’s appearance is measured during Transit Photometry?', 'type' => 'short_answer', 'correct_answer' => 'luminosity'],
                        ['id' => 8, 'text' => 'What determines the success of the transit method besides the planet\'s movement?', 'type' => 'short_answer', 'correct_answer' => 'geometric probability'],
                        ['id' => 9, 'text' => 'What physical force from a planet causes the \'wobble\' detected in Radial Velocity?', 'type' => 'short_answer', 'correct_answer' => 'gravitational tug'],
                        ['id' => 10, 'text' => 'Which instrument is utilized to obstruct starlight, enabling scientists to see faint planets?', 'type' => 'short_answer'],
                    ],
                ],
                [
                    'passage_title' => 'The Silent Loss: The Phenomenon of Language Death',
                    'passage_text' => '<p>Linguists estimate that of the roughly 7,000 languages spoken worldwide today, nearly half are in danger of disappearing by the end of this century. This process, termed \'language death,\' occurs when a community shifts toward a more dominant tongue, often due to economic pressure or political assimilation. When the last native speaker of a language passes away, the world loses more than just a means of communication; it loses a unique epistemological framework—a specific way of perceiving and categorizing reality that has evolved over millennia.</p>
                    <p>The decline typically begins with \'bilingualism with diglossia,\' where a minority language is relegated to domestic use while a \'prestige\' language dominates public life, education, and commerce. Over generations, parents may stop transmitting their ancestral tongue to their children, believing that proficiency in a global language like English, Mandarin, or Spanish is a prerequisite for social mobility. This results in \'semi-speakers\'—younger generations who understand the language but lack the grammatical fluency to produce it, eventually leading to a complete cessation of linguistic transmission.</p>
                    <p>The loss of a language also has profound implications for \'traditional ecological knowledge\' (TEK). Many indigenous languages contain highly specialized vocabularies for local flora, fauna, and medicinal plants that do not exist in major world languages. For instance, certain Amazonian tribes have dozens of specific terms for different stages of a plant’s growth, information that is vital for pharmaceutical research and conservation efforts. Without the original language, this vast \'biological library\' is effectively burned, leaving a gap in our collective scientific understanding.</p>
                    <p>To combat this, linguists are engaging in \'language documentation\' using digital recording technologies. However, documentation is not the same as \'revitalization.\' While the former creates a record for scholars in a digital archive, the latter seeks to restore a language to daily, communal use. Successful examples, such as the revival of Hebrew or the New Zealand Māori \'language nests,\' demonstrate that with sufficient political will and community engagement, the tide of linguistic extinction can, in rare cases, be reversed.</p>',
                    'questions' => [
                        ['id' => 11, 'start_number' => 11, 'text' => 'What term refers to the distinct method of understanding reality that is lost when a language dies?', 'type' => 'short_answer', 'correct_answer' => 'epistemological framework'],
                        ['id' => 12, 'text' => 'What is the primary motivation for parents who choose not to teach their children a minority language?', 'type' => 'short_answer', 'correct_answer' => 'social mobility'],
                        ['id' => 13, 'text' => 'What group of people can comprehend a language but are unable to speak it with correct grammar?', 'type' => 'short_answer', 'correct_answer' => 'semi-speakers'],
                        ['id' => 14, 'text' => 'What specific type of information about the natural world is frequently stored within indigenous languages?', 'type' => 'short_answer', 'correct_answer' => 'ecological knowledge'],
                        ['id' => 15, 'text' => 'Where is linguistic information typically stored during the process of language documentation?', 'type' => 'short_answer', 'correct_answer' => 'digital archive'],
                    ],
                ],
                [
                    'passage_title' => 'The Engine of Earth: Mechanisms of Plate Tectonics',
                    'passage_text' => '<p>For decades after Alfred Wegener proposed the theory of continental drift, the scientific community remained skeptical, primarily due to the absence of a viable driving mechanism. It was not until the mid-20th century, with the discovery of the mid-ocean ridge system, that the theory of plate tectonics gained universal acceptance. This model describes the Earth\'s outer shell, or lithosphere, as a series of rigid plates that glide over the more fluid, semi-viscous layer known as the asthenosphere.</p>
                    <p>The movement of these plates is primarily driven by \'mantle convection.\' Within the Earth’s interior, intense heat from radioactive decay causes molten rock to rise toward the surface. As it cools, it becomes denser and sinks back down, creating massive circular currents. This process is supplemented by a force called \'ridge push,\' where newly formed, hot crust at oceanic ridges slides down the flanks of the ridge due to gravity. However, many geologists now believe that \'slab pull\'—the weight of a subducting plate dragging the rest of the plate behind it into a subduction zone—is the most powerful force in the entire system.</p>
                    <p>The interaction at plate boundaries is responsible for the planet\'s most dramatic geological features. At \'divergent boundaries,\' plates pull apart, creating rift valleys and new seafloor. Conversely, \'convergent boundaries\' involve the collision of plates, often resulting in the formation of massive mountain ranges or volcanic arcs. A third type, the \'transform boundary,\' occurs when plates slide past each other horizontally. The most famous example is the San Andreas Fault, where the accumulated elastic strain between the North American and Pacific plates is periodically released in the form of devastating earthquakes.</p>
                    <p>Understanding these movements is crucial for human safety. By studying the rate of \'crustal deformation\' using satellite technology, geologists can identify areas where pressure is building up along fault lines. While we cannot yet predict the exact timing of seismic events, these \'geodetic measurements\' allow for more accurate hazard mapping and the implementation of stricter building codes in high-risk zones, potentially saving thousands of lives.</p>',
                    'questions' => [
                        ['id' => 16, 'start_number' => 16, 'text' => 'Which layer of the Earth provides a flexible surface for the lithospheric plates to move upon?', 'type' => 'short_answer', 'correct_answer' => 'asthenosphere'],
                        ['id' => 17, 'text' => 'What is the source of the heat that initiates the process of mantle convection?', 'type' => 'short_answer', 'correct_answer' => 'radioactive decay'],
                        ['id' => 18, 'text' => 'Which geological force is currently considered the most influential in moving tectonic plates?', 'type' => 'short_answer', 'correct_answer' => 'slab pull'],
                        ['id' => 19, 'text' => 'What specific type of energy builds up when two plates fail to slide smoothly past each other?', 'type' => 'short_answer', 'correct_answer' => 'elastic strain'],
                        ['id' => 20, 'text' => 'What modern technology is used to monitor the speed at which the Earth\'s crust changes shape?', 'type' => 'short_answer', 'correct_answer' => 'satellite technology'],
                    ],
                ],
            ],
        ],
        4 => [
            'title' => 'Practice Test 4',
            'content' => [
                [
                    'passage_title' => 'The Future of Urban Transportation',
                    'passage_text' => '<p>The rapid evolution of autonomous vehicles (AVs) and smart infrastructure has sparked a diverse debate among urban planners and technologists regarding how cities should adapt to the coming decades. While the technology promises to eliminate human error—the cause of over 90% of road accidents—the systemic implications for urban design remain a subject of intense academic scrutiny.</p>
                    <p>Dr. Aris Thorne, a leading robotics engineer, argues that the transition to fully automated systems must be absolute to be effective. Thorne maintains that a \'hybrid\' period, where human drivers share the road with AI, is inherently dangerous due to the unpredictability of human behavior. He suggests that urban centers should eventually be restricted exclusively to autonomous pods to ensure maximum efficiency and safety.</p>
                    <p>In contrast, Professor Elena Vance, a social geographer, expresses concern over the \'spatial footprint\' of self-driving cars. Vance warns that if AVs make commuting more comfortable, they may inadvertently encourage \'urban sprawl.\' She posits that people might choose to live much further from their workplaces if they can work or sleep during their transit, potentially leading to the destruction of green belts and increased energy consumption.</p>
                    <p>Taking a more economic perspective, Dr. Marcus Halloway emphasizes the shift from individual ownership to \'Mobility as a Service\' (MaaS). Halloway predicts that the concept of owning a private vehicle will become obsolete within two generations. He envisions a subscription-based model where fleets of shared AVs circulate continuously, significantly reducing the need for parking infrastructure, which currently occupies up to 30% of land in some metropolitan areas.</p>
                    <p>However, Sarah Jenkins, a specialist in urban ethics, highlights the \'algorithmic transparency\' problem. She argues that the programming behind AVs contains \'invisible biases\' that could prioritize the safety of certain demographics over others in unavoidable accident scenarios. Jenkins insists that before these vehicles are deployed at scale, there must be a rigorous public audit of the decision-making logic embedded in their software to prevent ethical catastrophes.</p>',
                    'questions' => [[
                        'id' => 1,
                        'start_number' => 0,
                        'text' => 'Match each statement with the correct person, A–D.',
                        'type' => 'matching_features',
                        'box_title' => 'List of People',
                        'options' => ['A' => 'Dr. Aris Thorne', 'B' => 'Professor Elena Vance', 'C' => 'Dr. Marcus Halloway', 'D' => 'Sarah Jenkins'],
                        'sub_questions' => [
                            ['id' => 'q1', 'label' => 'The belief that autonomous technology might lead to people living in more distant locations.', 'correct_answer' => 'B'],
                            ['id' => 'q2', 'label' => 'The insistence that a complete ban on human drivers is necessary for traffic systems to work.', 'correct_answer' => 'A'],
                            ['id' => 'q3', 'label' => 'The suggestion that private car ownership will eventually be replaced by shared digital services.', 'correct_answer' => 'C'],
                            ['id' => 'q4', 'label' => 'The requirement for a legal and ethical review of the software used in automated driving.', 'correct_answer' => 'D'],
                        ],
                    ]],
                ],
                [
                    'passage_title' => 'The Foundations of the Human Mind',
                    'passage_text' => '<p>The question of how and when the human mind developed its unique capacity for abstract thought, symbolic language, and complex tool-making remains one of the most debated topics in paleoanthropology. While fossilized skulls provide a physical record of brain volume, they offer little insight into the cognitive processes that occurred within. To bridge this gap, various scholars have proposed theories based on the archaeological record of our ancestors.</p>
                    <p>Dr. Julian Mercer, a cognitive archaeologist, suggests that the \'Great Leap Forward\' occurred approximately 50,000 years ago due to a sudden genetic mutation. Mercer argues that this mutation allowed for \'fluid intelligence,\' enabling the brain to connect previously isolated functions, such as social interaction and technical skill. He points to the sudden appearance of intricate cave paintings and bone needles as evidence of this newly integrated mind.</p>
                    <p>In contrast, Professor Linda Hsieh challenges the idea of a sudden explosion in human intelligence. Hsieh posits that cognitive evolution was a \'slow-burn\' process characterized by incremental changes. She maintains that the development of complex language was not an overnight event but a gradual refinement that occurred over hundreds of thousands of years. According to Hsieh, the focus on \'spectacular\' art overlooks the subtle technological shifts in stone tool symmetry that suggest a much earlier onset of abstract planning.</p>
                    <p>Dr. Robert Sterling takes a more environmental approach, focusing on the role of \'social complexity\' as a driver for brain growth. Sterling maintains that the primary challenge for early humans was not the physical environment, but the need to navigate increasingly large and complex social groups. He argues that the \'Machiavellian Intelligence\' required to track alliances, deceits, and hierarchies within a tribe pushed the human brain to expand its prefrontal cortex, far more than the pressure of hunting or gathering did.</p>
                    <p>However, Dr. Naomi Katsui emphasizes the importance of \'niche construction.\' Katsui suggests that humans did not just evolve in an environment; they actively shaped the environment that, in turn, shaped their brains. She emphasizes that the control of fire was the pivotal turning point. By cooking food, early humans could access more calories with less digestive effort, allowing the body to redirect energy from the gut to the brain, effectively \'financing\' the expensive metabolic cost of a larger cranium.</p>',
                    'questions' => [[
                        'id' => 1,
                        'start_number' => 0,
                        'text' => 'Match each statement with the correct person, A–D.',
                        'type' => 'matching_features',
                        'box_title' => 'List of People',
                        'options' => ['A' => 'Dr. Julian Mercer', 'B' => 'Professor Linda Hsieh', 'C' => 'Dr. Robert Sterling', 'D' => 'Dr. Naomi Katsui'],
                        'sub_questions' => [
                            ['id' => 'q1', 'label' => 'The choice to consume different types of food and use energy differently led to brain growth.', 'correct_answer' => 'D'],
                            ['id' => 'q2', 'label' => 'Human intelligence became advanced very quickly due to a biological change.', 'correct_answer' => 'A'],
                            ['id' => 'q3', 'label' => 'The need to manage relationships with others was the main reason the brain grew.', 'correct_answer' => 'C'],
                            ['id' => 'q4', 'label' => 'Language and thinking skills developed slowly over a long period of time.', 'correct_answer' => 'B'],
                            ['id' => 'q5', 'label' => 'Early tools show that humans could think abstractly before they made art.', 'correct_answer' => 'B'],
                        ],
                    ]],
                ],
                [
                    'passage_title' => 'The Science of Academic Motivation',
                    'passage_text' => '<p>The question of why some students persist in the face of failure while others succumb to helplessness has led to several influential psychological frameworks. Understanding these motivational drivers is essential for educators aiming to cultivate resilient and high-performing learning environments.</p>
                    <p>Dr. Richard Ryan, a pioneer in motivational psychology, emphasizes the concept of \'Autonomy Support.\' He argues that external rewards, such as grades or financial incentives, can actually diminish long-term interest in a subject. Ryan maintains that for deep learning to occur, students must feel a sense of \'volition\'—the belief that they are the authors of their own actions. When students are driven by intrinsic curiosity rather than the fear of punishment or the desire for praise, their conceptual understanding and creativity are significantly enhanced.</p>
                    <p>In contrast, Professor Carol Dweck focuses on the power of \'Mindsets.\' Dweck\'s research distinguishes between a \'fixed\' mindset—the belief that intelligence is a static trait—and a \'growth\' mindset—the belief that abilities can be developed through dedication and hard work. She posits that the type of praise a student receives is critical; praising a student’s innate intelligence can lead to a fear of taking risks, whereas praising their \'process\' or effort encourages them to embrace challenges as opportunities for neural growth.</p>
                    <p>Dr. Albert Bandura takes a different approach, highlighting the role of \'Self-Efficacy.\' Bandura argues that a student’s performance is less about their actual ability and more about their perception of that ability. He suggests that \'mastery experiences\'—small, incremental successes—are the most powerful way to build a student\'s confidence. According to Bandura, if a student believes they possess the tools to succeed in a specific task, they are far more likely to exert effort and remain resilient when encountering obstacles.</p>
                    <p>Finally, Dr. Martin Seligman explores the phenomenon of \'Learned Helplessness.\' Seligman warns that when students repeatedly experience failure that they perceive as being beyond their control, they may eventually stop trying altogether, even when success becomes possible. He advocates for \'Learned Optimism,\' a technique where students are taught to reframe their failures as temporary and specific rather than permanent and universal. By changing their explanatory style, Seligman suggests that students can be \'immunized\' against the psychological impact of academic setbacks.</p>',
                    'questions' => [[
                        'id' => 1,
                        'start_number' => 0,
                        'text' => 'Match each statement with the correct person, A–D.',
                        'type' => 'matching_features',
                        'box_title' => 'List of People',
                        'options' => ['A' => 'Dr. Richard Ryan', 'B' => 'Professor Carol Dweck', 'C' => 'Dr. Albert Bandura', 'D' => 'Dr. Martin Seligman'],
                        'sub_questions' => [
                            ['id' => 'q1', 'label' => 'The belief that students can be protected from the negative effects of failure by changing how they interpret it.', 'correct_answer' => 'D'],
                            ['id' => 'q2', 'label' => 'The claim that an individual\'s confidence in their own skills is a better predictor of success than their actual talent.', 'correct_answer' => 'C'],
                            ['id' => 'q3', 'label' => 'The warning that providing tangible rewards for learning can reduce a student\'s genuine interest in a topic.', 'correct_answer' => 'A'],
                            ['id' => 'q4', 'label' => 'The theory that the way a teacher provides feedback can influence a student\'s willingness to try difficult tasks.', 'correct_answer' => 'B'],
                            ['id' => 'q5', 'label' => 'The suggestion that experiencing small wins is the most effective way to improve a learner\'s self-assurance.', 'correct_answer' => 'C'],
                        ],
                    ]],
                ],
                [
                    'passage_title' => 'The Value of Biodiversity',
                    'passage_text' => '<p>As the rate of global species extinction accelerates, philosophers and conservation biologists are engaged in a rigorous debate over how we should value the natural world. The justifications for conservation range from purely functional arguments to deeply ethical and aesthetic ones.</p>
                    <p>Dr. Simon Vance, an environmental economist, champions the \'Ecosystem Services\' model. He argues that nature should be valued based on the quantifiable benefits it provides to human civilization, such as water filtration, crop pollination, and carbon sequestration. Vance maintains that until we assign a precise monetary value to these \'natural assets,\' they will continue to be overlooked in global economic accounting. He suggests that framing conservation as a high-return investment is the only pragmatic way to influence government policy.</p>
                    <p>In contrast, Professor Helena Thorne is a vocal advocate for \'Intrinsic Value.\' Thorne rejects the idea that nature’s worth is dependent on its utility to humans. She posits that every species has an inherent right to exist regardless of its economic contribution. According to Thorne, the \'anthropocentric\' (human-centered) approach to conservation is morally flawed; she maintains that we have an ethical obligation to protect biodiversity as a matter of justice for the non-human world.</p>
                    <p>Dr. Marcus Galt takes a more \'Biocultural\' approach, focusing on the link between linguistic diversity and biodiversity. Galt argues that the loss of indigenous languages directly correlates with the degradation of local ecosystems. He emphasizes that traditional communities possess \'encoded knowledge\' about plant medicines and sustainable land management that is lost when their cultures are assimilated. For Galt, protecting a species cannot be separated from protecting the human culture that has co-evolved alongside it.</p>
                    <p>Finally, Dr. Julian Estanza explores the \'Aesthetic Argument.\' Estanza suggests that the primary driver for public support in conservation is often \'charismatic megafauna\'—large, attractive animals like pandas or tigers. While critics argue this focus is scientifically arbitrary, Estanza maintains that these species serve as \'umbrellas.\' By protecting the vast habitats required by these popular animals, we inadvertently save thousands of less \'attractive\' but ecologically vital species, such as insects and fungi, that the public might otherwise ignore.</p>',
                    'questions' => [[
                        'id' => 1,
                        'start_number' => 0,
                        'text' => 'Match each statement with the correct person, A–D.',
                        'type' => 'matching_features',
                        'box_title' => 'List of People',
                        'options' => ['A' => 'Dr. Simon Vance', 'B' => 'Professor Helena Thorne', 'C' => 'Dr. Marcus Galt', 'D' => 'Dr. Julian Estanza'],
                        'sub_questions' => [
                            ['id' => 'q1', 'label' => 'The claim that protecting famous animal species can indirectly preserve entire ecosystems.', 'correct_answer' => 'D'],
                            ['id' => 'q2', 'label' => 'The belief that nature should be protected because it has its own right to exist, not for human gain.', 'correct_answer' => 'B'],
                            ['id' => 'q3', 'label' => 'The argument that preserving biological variety requires the simultaneous protection of human traditions.', 'correct_answer' => 'C'],
                            ['id' => 'q4', 'label' => 'The suggestion that translating nature’s functions into financial terms is essential for policy change.', 'correct_answer' => 'A'],
                            ['id' => 'q5', 'label' => 'The warning that a human-centered view of the environment is an ethically incorrect position.', 'correct_answer' => 'B'],
                        ],
                    ]],
                ],
            ],
        ],
        5 => [
            'title' => 'Practice Test 5',
            'content' => [
                [
                    'passage_title' => 'The Urban Heat Island Effect',
                    'passage_text' => '<p>As global temperatures rise, metropolitan areas are facing a specific climatic phenomenon known as the Urban Heat Island (UHI) effect. This occurs when a city experiences significantly warmer temperatures than its surrounding rural areas. The primary cause is the prevalence of dark, non-reflective surfaces such as asphalt and concrete, which absorb solar radiation during the day and release it as heat at night. In contrast, rural landscapes, characterized by abundant vegetation and permeable soil, dissipate heat through a process called evapotranspiration.</p>
                    <p>The consequences of UHI are not merely limited to physical discomfort. Higher urban temperatures lead to increased energy demand for air conditioning, which in turn spikes carbon emissions if the electricity is sourced from fossil fuels. Furthermore, the heat can exacerbate respiratory and cardiovascular conditions among vulnerable populations, particularly the elderly. To mitigate these effects, urban planners are exploring \'cool roof\' technologies, which involve coating rooftops with reflective materials to bounce sunlight away from buildings.</p>
                    <p>Recent studies in Singapore and Tokyo have also highlighted the importance of \'urban canyons\'—the narrow spaces between tall buildings. While skyscrapers can provide shade, they can also trap heat by preventing wind from circulating at street level. Researchers have found that strategic orientation of buildings and the preservation of \'wind corridors\' are essential for natural ventilation. Additionally, the integration of \'vertical forests\'—high-rise buildings covered in trees—is being tested as a way to lower ambient temperatures through natural shade and moisture release.</p>',
                    'questions' => [[
                        'id' => 1,
                        'start_number' => 0,
                        'text' => 'Do the following statements agree with the information given in the Reading Passage?',
                        'type' => 'matching_features',
                        'box_title' => '',
                        'options' => ['TRUE' => 'TRUE', 'FALSE' => 'FALSE', 'NOT GIVEN' => 'NOT GIVEN'],
                        'sub_questions' => [
                            ['id' => 'q1', 'label' => 'Darker materials in cities contribute to the UHI effect by storing heat during daylight hours.', 'correct_answer' => 'TRUE'],
                            ['id' => 'q2', 'label' => 'Rural areas stay cooler because they have better drainage systems than cities.', 'correct_answer' => 'FALSE'],
                            ['id' => 'q3', 'label' => 'The UHI effect can indirectly lead to an increase in greenhouse gas production.', 'correct_answer' => 'TRUE'],
                            ['id' => 'q4', 'label' => '\'Cool roof\' technology is currently the most expensive method for reducing urban heat.', 'correct_answer' => 'NOT GIVEN'],
                            ['id' => 'q5', 'label' => 'Narrow gaps between skyscrapers can sometimes obstruct the flow of air.', 'correct_answer' => 'TRUE'],
                            ['id' => 'q6', 'label' => 'The primary purpose of \'vertical forests\' is to provide fruit for urban residents.', 'correct_answer' => 'FALSE'],
                            ['id' => 'q6b', 'label' => 'Higher temperatures in cities lead to an increase in the use of air conditioning.', 'correct_answer' => 'TRUE'],
                            ['id' => 'q6c', 'label' => 'Skyscrapers always reduce urban temperatures by blocking sunlight at street level.', 'correct_answer' => 'FALSE'],
                            ['id' => 'q6d', 'label' => 'Maintaining clear pathways for wind movement is considered important for natural ventilation in cities.', 'correct_answer' => 'TRUE'],
                            ['id' => 'q6e', 'label' => 'Vertical forests have been proven to completely eliminate the need for air conditioning in urban buildings.', 'correct_answer' => 'NOT GIVEN'],
                        ],
                    ]],
                ],
                [
                    'passage_title' => 'The Rise of Antibiotic Resistance',
                    'passage_text' => '<p>The discovery of penicillin by Alexander Fleming in 1928 marked the beginning of the antibiotic era, a revolution that transformed once-fatal infections into manageable conditions. However, the initial euphoria surrounding these \'wonder drugs\' obscured a fundamental biological reality: bacteria are highly adaptive organisms. Through a process of natural selection, bacteria can develop mutations that allow them to survive exposure to the chemicals designed to kill them. This phenomenon, known as antimicrobial resistance (AMR), is now considered one of the most significant threats to global health in the 21st century.</p>
                    <p>The primary driver of AMR is the persistent misuse and overprescription of antibiotic medications. In many regions, antibiotics can be purchased without a medical consultation, leading to their inappropriate use for viral infections like the common cold, against which they are entirely ineffective. Furthermore, the agricultural sector accounts for a staggering proportion of global antibiotic consumption. Livestock are frequently administered sub-therapeutic doses of antibiotics—not to treat illness, but to promote growth and prevent infections in crowded farming environments. This practice creates an ideal breeding ground for resistant strains that can eventually reach human populations through the food chain.</p>
                    <p>While pharmaceutical companies were once prolific in developing new classes of antibiotics, the pipeline has slowed to a crawl in recent decades. The research and development (R&D) of a new antibiotic is a costly, time-consuming process with a low return on investment. Because antibiotics are typically taken for a short duration—unlike chronic medications for blood pressure or diabetes—they are less profitable for manufacturers. Consequently, the medical community is now facing a \'post-antibiotic\' future where routine surgeries and minor injuries could once again become life-threatening due to the lack of effective treatment options.</p>',
                    'questions' => [[
                        'id' => 2,
                        'start_number' => 0,
                        'text' => 'Do the following statements agree with the information given in the Reading Passage?',
                        'type' => 'matching_features',
                        'box_title' => '',
                        'options' => ['TRUE' => 'TRUE', 'FALSE' => 'FALSE', 'NOT GIVEN' => 'NOT GIVEN'],
                        'sub_questions' => [
                            ['id' => 'q7', 'label' => 'Alexander Fleming immediately realized that bacteria would eventually become resistant to penicillin.', 'correct_answer' => 'NOT GIVEN'],
                            ['id' => 'q8', 'label' => 'Antimicrobial resistance occurs because bacteria have the ability to evolve in response to drugs.', 'correct_answer' => 'TRUE'],
                            ['id' => 'q9', 'label' => 'Antibiotics are an effective treatment for most types of common cold.', 'correct_answer' => 'FALSE'],
                            ['id' => 'q10', 'label' => 'The majority of antibiotics used in agriculture are intended to cure sick animals.', 'correct_answer' => 'FALSE'],
                            ['id' => 'q11', 'label' => 'Developing new antibiotics is more expensive than developing drugs for chronic conditions.', 'correct_answer' => 'NOT GIVEN'],
                            ['id' => 'q12', 'label' => 'The short-term nature of antibiotic treatment makes them less attractive to pharmaceutical companies.', 'correct_answer' => 'TRUE'],
                            ['id' => 'q12b', 'label' => 'Antimicrobial resistance is currently regarded as one of the most significant global health threats of this century.', 'correct_answer' => 'TRUE'],
                            ['id' => 'q12c', 'label' => 'Antibiotics are freely available without a prescription in every country in the world.', 'correct_answer' => 'FALSE'],
                            ['id' => 'q12d', 'label' => 'Low doses of antibiotics are given to farm animals mainly to treat active infections.', 'correct_answer' => 'FALSE'],
                            ['id' => 'q12e', 'label' => 'Investing in antibiotic development is considered less profitable than investing in drugs for long-term conditions.', 'correct_answer' => 'TRUE'],
                        ],
                    ]],
                ],
                [
                    'passage_title' => 'The Fragile Giants: Coral Reefs in a Warming Ocean',
                    'passage_text' => '<p>Coral reefs, often referred to as the \'rainforests of the sea,\' occupy less than 0.1% of the ocean floor yet support approximately 25% of all marine species. These complex structures are built by coral polyps—tiny animals that live in a symbiotic relationship with microscopic algae called zooxanthellae. The algae reside within the coral\'s tissues, providing the polyps with essential nutrients through photosynthesis and giving reefs their vibrant colors. In return, the coral provides the algae with a protected environment and the compounds necessary for photosynthesis.</p>
                    <p>However, this delicate balance is highly sensitive to thermal fluctuations. When water temperatures rise by as little as 1–2°C above the normal summer maximum, corals experience physiological stress. In response, they expel the zooxanthellae from their tissues. Without the algae, the coral loses its primary food source and its color, turning stark white in a phenomenon known as \'coral bleaching.\' While bleached corals are not dead, they are in a weakened state and are far more susceptible to disease and starvation. If the heat stress persists for several weeks, the coral polyps eventually perish, leading to the collapse of the entire reef architecture.</p>
                    <p>The Great Barrier Reef in Australia has experienced several mass bleaching events over the last decade, sparking urgent discussions about \'assisted evolution.\' Some marine biologists are experimenting with selectively breeding coral strains that exhibit higher heat tolerance. Others are investigating the use of \'sun shields\'—ultra-thin, biodegradable films that float on the water\'s surface to reduce the intensity of light reaching the reefs. Despite these innovative interventions, environmentalists emphasize that such local measures are merely \'band-aid\' solutions. They argue that without a drastic global reduction in carbon emissions to stabilize ocean temperatures, the long-term survival of coral reefs remains highly improbable.</p>',
                    'questions' => [[
                        'id' => 3,
                        'start_number' => 0,
                        'text' => 'Do the following statements agree with the information given in the Reading Passage?',
                        'type' => 'matching_features',
                        'box_title' => '',
                        'options' => ['TRUE' => 'TRUE', 'FALSE' => 'FALSE', 'NOT GIVEN' => 'NOT GIVEN'],
                        'sub_questions' => [
                            ['id' => 'q13', 'label' => 'Coral reefs cover a significant portion of the total area of the world\'s oceans.', 'correct_answer' => 'FALSE'],
                            ['id' => 'q14', 'label' => 'The relationship between coral polyps and zooxanthellae is mutually beneficial for both organisms.', 'correct_answer' => 'TRUE'],
                            ['id' => 'q15', 'label' => 'Corals can only survive if the water temperature remains exactly the same throughout the year.', 'correct_answer' => 'FALSE'],
                            ['id' => 'q16', 'label' => 'Bleached coral is considered dead as soon as it loses its zooxanthellae.', 'correct_answer' => 'FALSE'],
                            ['id' => 'q17', 'label' => 'Scientists have successfully restored the entire Great Barrier Reef using assisted evolution.', 'correct_answer' => 'NOT GIVEN'],
                            ['id' => 'q18', 'label' => 'Some experts believe that local interventions are insufficient to guarantee the future of reefs.', 'correct_answer' => 'TRUE'],
                            ['id' => 'q18b', 'label' => 'Coral reefs support a disproportionately large number of marine species relative to the area they occupy.', 'correct_answer' => 'TRUE'],
                            ['id' => 'q18c', 'label' => 'Coral bleaching is a process that immediately results in the death of the coral polyp.', 'correct_answer' => 'FALSE'],
                            ['id' => 'q18d', 'label' => 'Scientists have already developed a coral strain that is fully resistant to the effects of climate change.', 'correct_answer' => 'NOT GIVEN'],
                            ['id' => 'q18e', 'label' => 'The use of biodegradable sun shields is one approach being explored to protect coral reefs from heat damage.', 'correct_answer' => 'TRUE'],
                        ],
                    ]],
                ],
                [
                    'passage_title' => 'The Cognitive Architecture of Deep Work',
                    'passage_text' => '<p>In the modern digital economy, the ability to maintain intense focus is becoming increasingly rare yet exponentially more valuable. Cal Newport, a professor of computer science, coined the term \'Deep Work\' to describe professional activities performed in a state of distraction-free concentration that push cognitive capabilities to their limit. These efforts create new value, improve skills, and are hard to replicate. In contrast, \'shallow work\' consists of non-cognitively demanding, logistical-style tasks, often performed while distracted. These efforts tend not to create much new value in the world and are easy to replicate.</p>
                    <p>The biological basis for the effectiveness of deep work lies in the process of myelination. When an individual focuses intensely on a specific skill, they trigger a neural circuit to fire repeatedly. This repetitive firing prompts oligodendrocytes to wrap layers of myelin—a fatty tissue—around the neurons in that circuit. Myelin acts as an insulator, allowing electrical signals to travel faster and more efficiently. Consequently, the more myelin that is developed around a specific circuit, the more fluently and effortlessly the associated skill can be performed.</p>
                    <p>However, the transition to a state of deep concentration is often hindered by \'attention residue.\' Research by business professor Sophie Leroy suggests that when someone switches from Task A to Task B, their attention does not follow immediately. Instead, a \'residue\' of their focus remains stuck on the previous task. This is particularly problematic in modern offices characterized by \'active monitoring\'—the habit of constantly checking emails and messaging apps. Even a quick glance at an inbox can leave a person\'s brain fragmented for up to twenty minutes, significantly reducing their capacity for high-level problem-solving.</p>',
                    'questions' => [[
                        'id' => 4,
                        'start_number' => 0,
                        'text' => 'Do the following statements agree with the information given in the Reading Passage?',
                        'type' => 'matching_features',
                        'box_title' => '',
                        'options' => ['TRUE' => 'TRUE', 'FALSE' => 'FALSE', 'NOT GIVEN' => 'NOT GIVEN'],
                        'sub_questions' => [
                            ['id' => 'q19', 'label' => 'Deep work is defined as a method of working that requires minimal mental effort.', 'correct_answer' => 'FALSE'],
                            ['id' => 'q20', 'label' => 'The benefits of shallow work are generally considered difficult for others to copy.', 'correct_answer' => 'FALSE'],
                            ['id' => 'q21', 'label' => 'The production of myelin is stimulated by the frequent activation of certain brain pathways.', 'correct_answer' => 'TRUE'],
                            ['id' => 'q22', 'label' => 'Myelination helps to increase the speed at which information moves through the nervous system.', 'correct_answer' => 'TRUE'],
                            ['id' => 'q23', 'label' => 'Sophie Leroy\'s study proved that multitasking increases overall workplace productivity.', 'correct_answer' => 'FALSE'],
                            ['id' => 'q24', 'label' => 'Briefly checking an email can negatively impact a person\'s concentration for a measurable period of time.', 'correct_answer' => 'TRUE'],
                            ['id' => 'q24b', 'label' => 'Cal Newport is primarily known for his research in neuroscience.', 'correct_answer' => 'FALSE'],
                            ['id' => 'q24c', 'label' => 'Oligodendrocytes are the cells responsible for wrapping myelin around neural circuits.', 'correct_answer' => 'TRUE'],
                            ['id' => 'q24d', 'label' => 'Shallow work tasks are described as activities that are difficult to replicate and highly valuable.', 'correct_answer' => 'FALSE'],
                            ['id' => 'q24e', 'label' => '\'Active monitoring\' refers to the habit of frequently checking emails and messaging applications.', 'correct_answer' => 'TRUE'],
                        ],
                    ]],
                ],
            ],
        ],
        6 => [
            'title' => 'The Paradox of the Digital Nomad',
            'content' => [
                [
                    'passage_title' => 'The Paradox of the Digital Nomad',
                    'passage_text' => '<p>The rise of remote work has birthed a new class of global citizen: the digital nomad. Armed with a laptop and a stable internet connection, these individuals have traded traditional office cubicles for Balinese cafes and Mediterranean coastlines. On the surface, this lifestyle appears to be the ultimate realization of human freedom—a liberation from the geographical constraints of the industrial age. However, as the novelty of \'working from anywhere\' begins to wear off, a more critical perspective is emerging regarding the social and psychological costs of this hyper-mobile existence.</p>
                    <p>Critics argue that the digital nomad movement is essentially a new form of \'gentrification without borders.\' By relocating to low-cost-of-living countries while earning Western salaries, nomads inadvertently drive up local rents and displace the very communities they claim to admire. Furthermore, the transient nature of their stay prevents the formation of deep, meaningful social bonds. While a nomad may have thousands of digital followers, the absence of a \'physical\' community often leads to a profound sense of isolation. I believe that true belonging requires \'place-attachment\'—a long-term commitment to a specific geography and its people—which is fundamentally at odds with the nomadic ethos.</p>
                    <p>Moreover, the promise of \'work-life balance\' in idyllic locations often proves to be an illusion. In a traditional office, the physical commute serves as a psychological boundary between labor and leisure. For the nomad, this boundary is erased. When your office is your bedroom or a beachside bar, the \'always-on\' culture of digital capitalism becomes inescapable. Without a structural separation of space, the mind remains in a state of perpetual productivity, leading to a unique form of burnout that is masked by the beauty of one\'s surroundings.</p>',
                    'questions' => [[
                        'id' => 1,
                        'start_number' => 0,
                        'text' => 'Do the following statements agree with the claims of the writer in the Reading Passage?',
                        'type' => 'matching_features',
                        'box_title' => '',
                        'options' => ['YES' => 'YES', 'NO' => 'NO', 'NOT GIVEN' => 'NOT GIVEN'],
                        'sub_questions' => [
                            ['id' => 'q1', 'label' => 'The digital nomad lifestyle represents a significant break from the work structures of the past.', 'correct_answer' => 'YES'],
                            ['id' => 'q2', 'label' => 'Digital nomads contribute more to the local economy than traditional tourists do.', 'correct_answer' => 'NOT GIVEN'],
                            ['id' => 'q3', 'label' => 'The writer suggests that it is difficult for highly mobile workers to build genuine relationships.', 'correct_answer' => 'YES'],
                            ['id' => 'q4', 'label' => 'In the writer’s view, a sense of belonging is incompatible with a life of constant travel.', 'correct_answer' => 'YES'],
                            ['id' => 'q5', 'label' => 'The \'always-on\' culture is more prevalent in Western Europe than in Southeast Asia.', 'correct_answer' => 'NOT GIVEN'],
                            ['id' => 'q6', 'label' => 'The writer believes that a lack of physical boundaries between work and home can be mentally exhausting.', 'correct_answer' => 'YES'],
                        ],
                    ]],
                ],
                [
                    'passage_title' => 'The Radical Promise of Rewilding',
                    'passage_text' => '<p>In the face of unprecedented biodiversity loss, traditional conservation methods—which often focus on protecting isolated pockets of \'wilderness\'—are increasingly seen as insufficient. A more ambitious and controversial strategy has emerged: rewilding. Unlike standard restoration, which aims to return an ecosystem to a specific historical state, rewilding seeks to restore self-sustaining natural processes by reintroducing \'keystone species\' that have been driven to extinction by human activity. By bringing back top predators like wolves or large herbivores like bison, proponents believe we can trigger beneficial ecological chain reactions that revitalize entire landscapes.</p>
                    <p>However, the implementation of rewilding is fraught with socio-political tension. I am concerned that the enthusiasm for \'wildness\' often ignores the lived realities of rural communities who have inhabited and managed these landscapes for generations. To many farmers, the reintroduction of apex predators is not a biological triumph but a direct threat to their livelihoods and traditional ways of life. I contend that any conservation project that fails to secure the \'social license\' of the local population is doomed to fail, regardless of its scientific merit. We cannot impose a prehistoric vision of nature onto a modern, populated world without causing significant friction.</p>
                    <p>Furthermore, the philosophical premise of rewilding—that nature is \'best\' when left entirely alone—is open to critique. This perspective assumes that human intervention is inherently destructive. Yet, for millennia, human practices such as controlled burning and selective harvesting have actually enhanced the biodiversity of certain regions. I suspect that the move toward \'passive\' management might lead to a different kind of ecological decline, where dominant, invasive species thrive at the expense of rare ones that require human-maintained habitats. Ultimately, I believe we should aim for a \'partnership\' with nature, rather than a total withdrawal from it.</p>',
                    'questions' => [[
                        'id' => 2,
                        'start_number' => 0,
                        'text' => 'Do the following statements agree with the claims of the writer in the Reading Passage?',
                        'type' => 'matching_features',
                        'box_title' => '',
                        'options' => ['YES' => 'YES', 'NO' => 'NO', 'NOT GIVEN' => 'NOT GIVEN'],
                        'sub_questions' => [
                            ['id' => 'q7', 'label' => 'Rewilding differs from traditional restoration by prioritizing the return of natural processes over specific historical accuracy.', 'correct_answer' => 'YES'],
                            ['id' => 'q8', 'label' => 'The reintroduction of bison has been more successful in Europe than in North America.', 'correct_answer' => 'NOT GIVEN'],
                            ['id' => 'q9', 'label' => 'The writer believes that scientific data is the most important factor in the success of a rewilding project.', 'correct_answer' => 'NO'],
                            ['id' => 'q10', 'label' => 'In the writer\'s view, the interests of local inhabitants are sometimes overlooked by rewilding advocates.', 'correct_answer' => 'YES'],
                            ['id' => 'q11', 'label' => 'The writer suggests that all forms of human intervention are damaging to the diversity of an ecosystem.', 'correct_answer' => 'NO'],
                            ['id' => 'q12', 'label' => 'The writer concludes that humans should maintain an active role in managing the natural world.', 'correct_answer' => 'YES'],
                        ],
                    ]],
                ],
                [
                    'passage_title' => 'The Architecture of Choice',
                    'passage_text' => '<p>The traditional economic model of Homo Economicus—a rational being who makes decisions solely based on maximizing personal utility—is increasingly being viewed as a flawed abstraction. In reality, human decision-making is a messy, inconsistent process influenced by a myriad of cognitive biases. To address this, some economists and policymakers have championed the concept of \'Nudge Theory.\' This approach involves designing \'choice architectures\' that subtly encourage individuals to make decisions that are in their long-term best interest, such as saving for retirement or choosing healthier food, without restricting their freedom to choose otherwise.</p>
                    <p>While the successes of \'nudging\' are well-documented, I am deeply skeptical of its long-term implications for human agency. Proponents argue that since no choice is ever presented in a neutral way, we might as well design environments that favor \'good\' outcomes. However, I contend that this paternalistic approach risks infantilizing the public. By smoothing over the friction of decision-making, we deprive individuals of the opportunity to engage in the difficult, conscious deliberation that is essential for moral and intellectual growth. A life lived through a series of pre-configured \'correct\' choices is a life that lacks true autonomy.</p>
                    <p>Furthermore, the transparency of these interventions is often questionable. I suspect that the effectiveness of many nudges relies on the fact that the individuals being nudged are unaware of the psychological mechanisms being exploited. If the public were fully conscious that their behavior was being steered by a government agency, the resulting \'reactance\' might lead them to reject the intervention altogether. I believe that for a democratic society to function, we should prioritize \'boosts\'—transparent efforts to improve an individual\'s underlying competence and knowledge—rather than \'nudges\' that bypass the rational mind. True progress lies in education, not in the invisible manipulation of our environment.</p>',
                    'questions' => [[
                        'id' => 3,
                        'start_number' => 0,
                        'text' => 'Do the following statements agree with the claims of the writer in the Reading Passage?',
                        'type' => 'matching_features',
                        'box_title' => '',
                        'options' => ['YES' => 'YES', 'NO' => 'NO', 'NOT GIVEN' => 'NOT GIVEN'],
                        'sub_questions' => [
                            ['id' => 'q13', 'label' => 'The traditional economic view of humans as purely rational decision-makers is accurate in most modern contexts.', 'correct_answer' => 'NO'],
                            ['id' => 'q14', 'label' => 'Nudge Theory allows people to make their own choices while guiding them toward better results.', 'correct_answer' => 'YES'],
                            ['id' => 'q15', 'label' => 'The writer believes that making decisions easier for people can have a negative effect on their personal development.', 'correct_answer' => 'YES'],
                            ['id' => 'q16', 'label' => 'Nudging is a more cost-effective method for governments than traditional advertising campaigns.', 'correct_answer' => 'NOT GIVEN'],
                            ['id' => 'q17', 'label' => 'The writer suggests that some nudges only work because people do not realize they are being influenced.', 'correct_answer' => 'YES'],
                            ['id' => 'q18', 'label' => 'In the writer\'s view, improving a person\'s actual skills and understanding is better than using nudges.', 'correct_answer' => 'YES'],
                        ],
                    ]],
                ],
                [
                    'passage_title' => 'Resurrecting the Past: The Ethics of De-extinction',
                    'passage_text' => '<p>The rapid advancement of CRISPR gene-editing technology has brought a once-fanciful concept into the realm of biological possibility: de-extinction. Scientists are currently working on projects to \'resurrect\' iconic species such as the woolly mammoth and the passenger pigeon. By inserting fragments of ancient DNA into the genomes of their closest living relatives, researchers hope to create proxy species that can fulfill the ecological roles left vacant by their predecessors. Proponents argue that we have a moral obligation to undo the damage caused by human-driven extinctions and that these animals could help restore struggling ecosystems, such as the Arctic tundra.</p>
                    <p>However, I am deeply unconvinced by the \'ecological restoration\' argument. The environments into which these creatures would be released have changed fundamentally since their disappearance. A mammoth returned to the 21st century would be an exotic alien in a world defined by a warming climate and fragmented habitats. I suspect that instead of stabilizing ecosystems, these \'reborn\' species might inadvertently disrupt existing food webs, acting more like invasive species than native ones. We are attempting to fix a broken puzzle by forcing in pieces from a different box entirely.</p>
                    <p>Furthermore, the staggering cost of these projects raises a significant ethical red flag. I believe that our primary conservation priority should be the protection of species that are currently on the brink of extinction. Diverting massive amounts of funding and scientific talent toward \'vanity projects\' like the woolly mammoth is, in my view, a reckless misappropriation of resources. We risk losing thousands of existing, unique organisms for the sake of a high-tech spectacle. I contend that the \'glamour\' of de-extinction is a dangerous distraction from the unglamorous, urgent work of protecting the biodiversity we still have.</p>',
                    'questions' => [[
                        'id' => 4,
                        'start_number' => 0,
                        'text' => 'Do the following statements agree with the claims of the writer in the Reading Passage?',
                        'type' => 'matching_features',
                        'box_title' => '',
                        'options' => ['YES' => 'YES', 'NO' => 'NO', 'NOT GIVEN' => 'NOT GIVEN'],
                        'sub_questions' => [
                            ['id' => 'q19', 'label' => 'Modern gene-editing tools have made the idea of bringing back extinct species more realistic.', 'correct_answer' => 'YES'],
                            ['id' => 'q20', 'label' => 'The woolly mammoth\'s DNA is more difficult to reconstruct than that of the passenger pigeon.', 'correct_answer' => 'NOT GIVEN'],
                            ['id' => 'q21', 'label' => 'The writer doubts that reintroduced extinct species will successfully integrate into modern environments.', 'correct_answer' => 'YES'],
                            ['id' => 'q22', 'label' => 'The writer compares de-extinction projects to the introduction of invasive species.', 'correct_answer' => 'YES'],
                            ['id' => 'q23', 'label' => 'De-extinction research is cheaper than traditional methods of preserving endangered animals.', 'correct_answer' => 'NO'],
                            ['id' => 'q24', 'label' => 'The writer argues that the focus on de-extinction takes away necessary attention from current conservation efforts.', 'correct_answer' => 'YES'],
                        ],
                    ]],
                ],
            ],
        ],
        7 => [
            'title' => 'IELTS Academic Reading: Summary Completion',
            'content' => [
                [
                    'passage_title' => 'The Evolution of Biomimicry in Modern Engineering',
                    'passage_text' => '<p>The field of biomimicry—the practice of looking to nature for solutions to complex human problems—is not a new concept, but its application in high-tech engineering has reached unprecedented levels in recent years. Unlike traditional manufacturing, which often relies on \'brute force\' methods like high heat and toxic chemicals, nature produces intricate structures at ambient temperatures using life-friendly chemistry.</p>
                    <p>One of the most remarkable breakthroughs in this field involves the study of the Kingfisher bird. For years, engineers in Japan faced a significant challenge with the Shinkansen, or \'bullet train.\' As the train emerged from narrow tunnels at high speeds, it created a thunderous \'sonic boom\' due to the sudden change in air pressure, causing severe noise pollution in residential areas. The solution was found by Eiji Nakatsu, an engineer and birdwatcher, who noticed the Kingfisher’s beak. The bird is capable of diving from the air into water with very little splash, thanks to its wedge-shaped beak which allows for a smooth transition between different mediums. By redesigning the nose of the bullet train to mimic the Kingfisher’s beak, engineers not only eliminated the noise problem but also increased the train\'s efficiency and reduced electricity consumption.</p>
                    <p>In the realm of architecture, the Eastgate Centre in Zimbabwe stands as a testament to biological inspiration. Architect Mick Pearce avoided using a conventional, energy-heavy air conditioning system by studying the structural design of termite mounds. These mounds maintain a constant internal temperature despite extreme external fluctuations. By using a series of chimneys that naturally draw in cool air at night and vent hot air during the day, the building remains comfortable while using 90% less energy than a standard building of its size.</p>',
                    'questions' => [[
                        'id' => 1,
                        'start_number' => 0,
                        'type' => 'summary_completion',
                        'text' => '',
                        'box_title' => 'Nature as a Solution for Engineering',
                        'instruction' => 'Complete the summary below. Choose NO MORE THAN TWO WORDS from the passage for each answer.',
                        'summary_text' => 'While human manufacturing often involves [1] and harmful chemicals, biomimicry focuses on natural, sustainable processes. A famous example is the Japanese bullet train, which originally produced a [2] whenever it exited a tunnel. This resulted in [3] that disturbed people living nearby.<br><br>By observing the [4] of a Kingfisher, engineers modified the train’s design. This change successfully stopped the loud sounds and lowered the amount of [5] the train used. Similarly, in Zimbabwe, an architect utilized the design of [6] to create a natural cooling system for a large building, significantly reducing its reliance on traditional air conditioning.',
                        'placeholders' => ['1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6],
                    ]],
                ],
                [
                    'passage_title' => 'The Science of Vertical Farming',
                    'passage_text' => '<p>By the year 2050, nearly 80% of the Earth\'s population is expected to reside in urban centers. To feed this burgeoning population, traditional agriculture would require an estimated landmass 20% larger than the entire territory of Brazil. With arable land becoming a scarce resource due to climate change and urban expansion, scientists are turning to vertical farming as a sustainable alternative. This method involves cultivating crops in stacked layers, often within controlled indoor environments such as repurposed warehouses or shipping containers.</p>
                    <p>Vertical farms utilize hydroponic or aeroponic systems, which deliver nutrients directly to the roots without the need for soil. Because these environments are entirely enclosed, they are not subject to the unpredictability of weather patterns, allowing for year-round production. Furthermore, these systems are remarkably efficient; they consume approximately 95% less water than conventional farming by recycling every drop within a closed-loop system. The absence of natural pests in these sterilized facilities also eliminates the requirement for chemical pesticides, resulting in cleaner, organic-grade produce.</p>
                    <p>However, the primary obstacle to widespread adoption is energy consumption. Vertical farms rely heavily on artificial LED lighting to simulate the solar spectrum. While LED technology has become more efficient, the electricity costs associated with powering these lights 24 hours a day can be prohibitive. Critics argue that unless these facilities are powered by renewable energy sources, their carbon footprint might actually exceed that of traditional farms, despite the reduced transportation distances to urban markets.</p>',
                    'questions' => [[
                        'id' => 2,
                        'start_number' => 0,
                        'type' => 'summary_completion',
                        'text' => '',
                        'box_title' => 'A Sustainable Shift in Food Production',
                        'instruction' => 'Complete the summary using the list of words, A–I, below.',
                        'summary_text' => 'As the global population becomes more concentrated in cities, there is a significant [7] of land suitable for traditional farming. Vertical farming offers a solution by growing plants in [8] structures. One of the main benefits of this method is its [9] nature, as it is unaffected by external climate conditions.<br><br>These farms use advanced irrigation techniques that result in a massive [10] in water usage. Moreover, because the environment is [11], farmers do not need to use toxic substances to protect their crops. Despite these advantages, the high [12] of maintaining artificial light remains a major challenge for the industry.',
                        'placeholders' => ['7' => 7, '8' => 8, '9' => 9, '10' => 10, '11' => 11, '12' => 12],
                        'box_options' => ['A' => 'expense', 'B' => 'reduction', 'C' => 'vertical', 'D' => 'shortage', 'E' => 'reliable', 'F' => 'expanded', 'G' => 'artificial', 'H' => 'sterile', 'I' => 'seasonal'],
                    ]],
                ],
                [
                    'passage_title' => 'The Psychology of Choice Architecture in Retail',
                    'passage_text' => '<p>In the competitive world of retail, the way products are displayed is rarely accidental. Marketers employ a strategy known as \'choice architecture\' to influence consumer behavior without explicitly restricting their options. One common technique is the \'decoy effect.\' This occurs when a third, less attractive option is introduced to make one of the other two choices seem more valuable. For instance, if a customer is choosing between a small coffee for $3 and a large one for $7, they might choose the smaller one. However, by adding a \'medium\' option for $6.50—which is only slightly cheaper than the large—the large coffee suddenly appears to be a much better deal, leading to an increase in its sales.</p>
                    <p>Another psychological tool is \'anchor pricing.\' When a consumer sees a high price first, their brain uses that number as a mental benchmark, or \'anchor,\' for all subsequent evaluations. Retailers often display a \'suggested retail price\' (SRP) next to a discounted price. Even if the SRP is artificially inflated, the discount feels more significant because the consumer\'s perception is anchored to the higher initial figure. This creates a sense of urgency and perceived savings that might not exist in a more transparent market.</p>
                    <p>The physical layout of a store also plays a crucial role. Most supermarkets are designed to maximize \'dwell time\'—the amount of time a customer spends in the building. Essential items like bread and milk are typically placed at the very back of the store. This forces customers to navigate through multiple aisles filled with high-margin \'impulse\' goods, such as snacks or luxury items, increasing the likelihood of unplanned purchases. By controlling the flow of traffic, retailers can manipulate the consumer\'s journey to ensure maximum exposure to their most profitable stock.</p>',
                    'questions' => [[
                        'id' => 3,
                        'start_number' => 0,
                        'type' => 'summary_completion',
                        'text' => '',
                        'box_title' => 'Strategic Marketing in Retail',
                        'instruction' => 'Complete the summary below. Choose NO MORE THAN TWO WORDS from the passage for each answer.',
                        'summary_text' => 'Retailers use a method called \'choice architecture\' to guide customers. One specific approach is the \'decoy effect,\' where an additional, [13] is used to make a different product look like a [14]. This effectively shifts the customer\'s preference toward a more expensive item.<br><br>Another common tactic is \'anchor pricing.\' In this case, a [15] is presented first to act as a reference point. This makes a lower price seem like a [16] even if the original price was not realistic. Finally, the internal [17] of a supermarket is designed to increase \'dwell time.\' By putting [18] at the back of the shop, retailers ensure that people pass by many other products, which often leads to spontaneous buying.',
                        'placeholders' => ['13' => 13, '14' => 14, '15' => 15, '16' => 16, '17' => 17, '18' => 18],
                    ]],
                ],
                [
                    'passage_title' => 'The Physics of Thrills: Engineering the Modern Roller Coaster',
                    'passage_text' => '<p>The heart of a roller coaster’s excitement lies not in its speed, but in the clever manipulation of gravitational potential energy and kinetic energy. Most roller coasters do not have engines; instead, they are pulled up a \'lift hill\' by a motorized chain. As the train ascends, it accumulates potential energy based on its height. Once it reaches the summit and begins its descent, this stored energy is rapidly converted into kinetic energy, providing the momentum required to complete the entire circuit.</p>
                    <p>A crucial aspect of the rider’s experience is the sensation of \'g-forces.\' When a coaster enters a sharp curve or a loop, the change in direction creates centripetal force, which pushes the rider’s body against the seat. This can result in \'positive g-forces,\' making the rider feel much heavier than usual. Conversely, as the train crests a hill at high speed, it creates \'negative g-forces\' or \'airtime,\' where the rider feels a momentary sensation of weightlessness as they are lifted out of their seat. Engineers must carefully calculate these forces to ensure they are thrilling but remain within the limits of human physiological endurance.</p>
                    <p>Safety in modern coasters is managed through complex braking systems. Most contemporary designs utilize magnetic brakes rather than friction-based ones. These systems use powerful magnets on the track to induce \'eddy currents\' in metal fins attached to the train. This interaction creates a silent, smooth deceleration without any physical contact between parts, significantly reducing mechanical wear and tear. Furthermore, a \'block system\' is employed, dividing the track into sections that only allow one train at a time, preventing the possibility of mid-track collisions.</p>',
                    'questions' => [[
                        'id' => 4,
                        'start_number' => 0,
                        'type' => 'summary_completion',
                        'text' => '',
                        'box_title' => 'How Roller Coasters Work',
                        'instruction' => 'Complete the summary below. Choose NO MORE THAN TWO WORDS from the passage for each answer.',
                        'summary_text' => 'Unlike most vehicles, a roller coaster typically lacks [19] and relies on energy transformation. During the initial climb, the train builds up [20], which later turns into the motion needed to finish the track.<br><br>As the train moves through turns, passengers experience [21], which is responsible for the feeling of increased weight. On the other hand, \'airtime\' occurs at the top of hills, giving a brief feeling of [22]. To ensure safety, modern coasters use [23] to slow down. This technology is preferred because it avoids [24] and lasts longer than older friction brakes. Additionally, the \'block system\' ensures that trains remain separated at all times.',
                        'placeholders' => ['19' => 19, '20' => 20, '21' => 21, '22' => 22, '23' => 23, '24' => 24],
                    ]],
                ],
            ],
        ],
    ];

    public function material(int $id): ?array
    {
        if (!isset(self::MATERIALS[$id])) {
            return null;
        }

        return [
            'title' => self::MATERIALS[$id]['title'],
            'id' => $id,
            'content' => self::MATERIALS[$id]['content'],
        ];
    }
}