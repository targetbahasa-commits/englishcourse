<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IeltsReadingPractice13Seeder extends Seeder
{
    public function run(): void
    {
        $materialId = 13;

        // Clean up any existing records for this material
        $existingPassages = \App\Models\IeltsReadingPassage::where('material_id', $materialId)->get();
        foreach ($existingPassages as $passage) {
            $passage->questions()->delete();
            $passage->delete();
        }

        // --- PASSAGE 1 ---
        $passage1 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'Learning By Examples',
            'content' => '
<p><strong>A</strong></p>
<p>Learning theory is rooted in the work of Ivan Pavlov, the famous scientist who discovered and documented the principles governing how animals (humans included) learn in the 1900s. two basic kinds of learning or conditioning occur, one of which is famously known as the classical condition. Classical conditioning happens when an animal learns to associate a neutral stimulus (signal) with a stimulus that has intrinsic meaning based on how closely in time the two stimuli are presented. The classic example of classical conditioning is a dog’s ability to associate the sound of a bell (something that originally has no meaning to the dog) with the presentation of food (something that has a lot of meaning for the dog) a few moments later. Dogs are able to learn the association between bell and food and will salivate immediately after hearing the bell once this connection has been made. Years of learning research have led to the creation of a highly precise learning theory that can be used to understand and predict how and under what circumstances most any animal will learn, including human beings, and eventually help people figure out how to change their behaviors.</p>

<p><strong>B</strong></p>
<p>Role models are a popular notion for guiding child development, but in recent years very interesting research has been done on learning by example in other animals. If the subject of animal learning is taught very much in terms of classical or operant conditioning, it places too much emphasis on how we allow animals to learn and not enough on how they are equipped to learn. To teach a course of mine I have been dipping profitably into a very interesting and accessible compilation of papers on social learning in mammals, including chimps and human children, edited by Heyes and Galef.</p>

<p><strong>C</strong></p>
<p>The research reported in one paper started with a school field trip to Israel to a pine forest where many pine cones were discovered, stripped to the central core. So the investigation started with no weighty theoretical intent but was directed at finding out what was eating the nutritious pine seeds and how they managed to get them out of the cones. The culprit proved to be the versatile and athletic black rat (Rattus rattus) and the technique was to bite each cone scale off at its base, in sequence from base to tip following the spiral growth pattern of the cone.</p>

<p><strong>D</strong></p>
<p>Urban black rats were found to lack the skill and were unable to learn it even if housed with experiences cone strippers. However, infants of urban mothers cross-fostered to stripper mothers acquired the skill, whereas infants of stripper mothers fostered by an urban mother could not. Clearly, the skill had to be learned from the mother. Further elegant experiments showed that naïve adults could develop the skill if they were provided with cones from which the first complete spiral of scales had been removed, rather like our new photocopier which you can work out how to use once someone has shown you how to switch it on. In the case of rats, the youngsters take cones away from the mother when she is still feeding on them, allowing them to acquire the complete stripping skill.</p>

<p><strong>E</strong></p>
<p>A good example of adaptive bearing we might conclude, but let’s see the economies. This was determined by measuring oxygen uptake of a rat stripping a cone in a metabolic chamber to calculate the energetic cost and comparing it with the benefit of the pine seeds measured by the calorimeter. The cost proved to be less than 10% of the energetic value of the cone. An acceptable profit margin.</p>

<p><strong>F</strong></p>
<p>A paper in 1996 Animal Behavior by Bednekoff and Balda provides a different view of the adaptiveness of social learning. It concerns the seed caching behavior of Clark’s nutcracker (Nucifraga Columbiana) and the Mexican jay (Aphelocoma ultramarine). The former is a specialist, catching 30,000 or so seeds in scattered locations that it will recover over the months of winter, the Mexican jay will also cache food but is much less dependent upon this than the nutcracker. The two species also differ in their social structure, the nutcracker being rather solitary while the jay forages in social groups.</p>

<p><strong>G</strong></p>
<p>The experiment is to discover not just whether a bird can remember where it hid a seed but also if it can remember where it saw another bird hide a seed. The design is slightly comical with a cacher bird wandering about a room with lots of holes in the floor hiding food in some of the holes, while watched by an observer bird perched in a cage. Two days later cachers and observers are tested for their discovery rate against an estimated random performance. In the role of cacher, not only nutcracker but also the less specialized jay performed above chance; more surprisingly, however, jay observers were as successful as jay cachers whereas nutcracker observes did no better than chance. It seems that, whereas the nutcracker is highly adapted at remembering where it hid its own seeds, the social living Mexican jay is more adept at remembering, and so exploiting, the caches of others.</p>',
            'order' => 1,
        ]);

        // Questions 1-4: Matching Paragraph Information
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 1,
            'type' => 'matching_paragraph_information',
            'question_text' => 'Reading Passage 1 has seven paragraphs A-G<br>Which paragraph contains the following information?<br>Write the correct letter A-G in boxes 1-4 on your answer sheet.',
            'options' => [
                'A' => 'Paragraph A',
                'B' => 'Paragraph B',
                'C' => 'Paragraph C',
                'D' => 'Paragraph D',
                'E' => 'Paragraph E',
                'F' => 'Paragraph F',
                'G' => 'Paragraph G',
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 0,
                'sub_questions' => [
                    ['id' => '1', 'label' => 'A comparison between rats’ learning and human learning', 'correct_answer' => 'D'],
                    ['id' => '2', 'label' => 'A reference to the earliest study in animal learning', 'correct_answer' => 'A'],
                    ['id' => '3', 'label' => 'The discovery of who stripped the pine cone', 'correct_answer' => 'C'],
                    ['id' => '4', 'label' => 'A description of a cost-effectiveness experiment.', 'correct_answer' => 'E'],
                ]
            ],
            'order' => 1,
        ]);

        // Questions 5-8: True/False/Not Given
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 5,
            'type' => 'true_false_not_given',
            'question_text' => 'Do the following statements agree with the information given in Reading Passage 1.<br>In boxes 5-8 on your answer sheet write',
            'options' => [
                'TRUE' => 'TRUE',
                'FALSE' => 'FALSE',
                'NOT GIVEN' => 'NOT GIVEN'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'start_number' => 4,
                'sub_questions' => [
                    ['id' => '5', 'label' => 'The field trip to Israel was to investigate how black rats learn to trip pine cones.', 'correct_answer' => 'FALSE'],
                    ['id' => '6', 'label' => 'The pine cones were stripped from bottom to top by black rats.', 'correct_answer' => 'TRUE'],
                    ['id' => '7', 'label' => 'It can be learned from other relevant experiences to use a photocopier.', 'correct_answer' => 'TRUE'],
                    ['id' => '8', 'label' => 'Stripping the pine cones is an instinct of the black rats.', 'correct_answer' => 'FALSE'],
                ]
            ],
            'order' => 2,
        ]);

        // Questions 9-13: Summary Completion with box options
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 9,
            'type' => 'summary_completion',
            'question_text' => '',
            'options' => null,
            'correct_answer' => [
                '9' => 'less',
                '10' => 'social',
                '11' => 'watched',
                '12' => 'observer',
                '13' => 'Nutcracker',
            ],
            'explanation' => null,
            'data' => [
                'start_number' => 8,
                'instruction' => 'Complete the summary below using words A-J from the box.<br>Write your answers in boxes 9-13 on your answer sheet.',
                'summary_text' => 'While the Nutcracker is more able to cache seed, the Jay relies <strong>[9]</strong> on caching food and is thus less specialized in this ability, but more <strong>[10]</strong>. To study their behavior of caching and finding their caches, an experiment was designed and carried out to test these two birds for their ability to remember where they hid the seeds. <br><br>In the experiment, the cacher bird hid seeds in the ground while the other <strong>[11]</strong>. As a result, the Nutcracker and the Mexican Jay showed different performance in the role of <strong>[12]</strong>. At finding the seeds— the observing <strong>[13]</strong> didn’t do as well as its counterpart.',
                'placeholders' => [
                    '9' => 9,
                    '10' => 10,
                    '11' => 11,
                    '12' => 12,
                    '13' => 13
                ],
                'box_options' => [
                    'A' => 'less', 'B' => 'more', 'C' => 'solitary', 'D' => 'social', 'E' => 'cacher',
                    'F' => 'observer', 'G' => 'remembered', 'H' => 'watched', 'I' => 'Jay', 'J' => 'Nutcracker'
                ]
            ],
            'order' => 3,
        ]);


        // --- PASSAGE 2 ---
        $passage2 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'Tasmanian Tiger',
            'content' => '
<p><strong>A</strong></p>
<p>Although it was called tiger, it looked like a clog with black stripes on its hack and it was the largest known carnivorous marsupial of modem times. Yet, despite its fame for being one of the most fabled animals in the world, it is one of the least understood of Tasmania’s native animals. The scientific name for the Tasmanian tiger is Thylacine and it is believed that they have become extinct in the 20th century.</p>

<p><strong>B</strong></p>
<p>Fossils of thylacines dating from about almost 12 million years ago have been dug up at various places in Victoria, South Australia and Western Australia. They were widespread in Australia 7,000 years ago, but have probably been extinct on the continent for 2,000 years ago. This is believed to be because of the introduction of dingoes around 8,000 years ago. Because of disease, thylacine numbers may have been declining in Tasmania at the time of European settlement 200 years ago, but the decline was certainly accelerated by the new arrivals. The last known Titsmanijin Tiger died in I lobar! Zoo in 193fi and the animal is officially classified as extinct. Technically, this means that it has not been officially sighted in the wild or captivity for 50 years. However, there are still unsubstantiated sightings.</p>

<p><strong>C</strong></p>
<p>Hans Naarding, whose study of animals had taken him around the world, was conducting a survey of a species of endangered migratory bird. The hat he saw that night is now regarded as the most credible sighting recorded of thylacine that many believe has been extinct for more than 70 years.</p>

<p><strong>D</strong></p>
<p>“I had to work at night.” Naarding takes up the story. “I was in the habit of intermittently shining a spotlight around. The beam fell on an animal in front of the vehicle, less than 10m away. Instead of risking movement by grabbing for a camera, I decided to register very carefully what I was seeing. The animal was about the size of a small shepherd dog, a very healthy male in prime condition. What set it apart from a dog, though, was a slightly sloping hindquarter, with a fairly thick tail being a straight continuation of the backline of the animal. It had 12 distinct stripes on its back, continuing onto its butt. I knew perfectly well what I was seeing. As soon as I reached for the camera, it disappeared into the tea-tree undergrowth and scrub.”</p>

<p><strong>E</strong></p>
<p>The director of Tasmania’s National Parks at the time, Peter Morrow, decided in his wisdom to keep Naarding’s sighting of the thylacine secret for two years. When the news finally broke, it was accompanied by pandemonium. “I was besieged by television crews, including four to five from Japan, and others from the United Kingdom, Germany, New Zealand and South America,” said Naarding.</p>

<p><strong>F</strong></p>
<p>Government and private search parties combed the region, but no further sightings were made. The tiger, as always, had escaped to its lair, a place many insist exists only in our imagination. But since then, the thylacine has staged something of a comeback, becoming part of Australian mythology.</p>

<p><strong>G</strong></p>
<p>There have been more than 4,000 claimed sightings of the beast since it supposedly died out, and the average claims each year reported to authorities now number 150. Associate professor of zoology at the University of Tasmania, Randolph Rose, has said he dreams of seeing a thylacine. But Rose, who in his 35 years in Tasmanian academia has fielded countless reports of thylacine sightings, is now convinced that his dream will go unfulfilled.</p>

<p><strong>H</strong></p>
<p>“The consensus among conservationists is that usually; any animal with a population base of less than 1,000 is headed for extinction within 60 years,” says Rose. “Sixty years ago, there was only one thylacine that we know of, and that was in Hobart Zoo,” he says.</p>

<p><strong>I</strong></p>
<p>Dr. David Pemberton, curator of zoology at the Tasmanian Museum and Art Gallery, whose PhD thesis was on the thylacine, says that despite scientific thinking that 500 animals are required to sustain a population, the Florida panther is down to a dozen or so animals and, while it does have some inbreeding problems, is still ticking along. “I’ll take a punt and say that, if we manage to find a thylacine in the scrub, it means that there are 50-plus animals out there.”</p>

<p><strong>J</strong></p>
<p>After all, animals can be notoriously elusive. The strange fish is known as the coelacanth’ with its “proto-legs”, was thought to have died out along with the dinosaurs 700 million years ago until a specimen was dragged to the surface in a shark net off the south-east coast of South Africa in 1938.</p>

<p><strong>K</strong></p>
<p>Wildlife biologist Nick Mooney has the unenviable task of investigating all “sightings” of the tiger totaling 4,000 since the mid-1980s, and averaging about 150 a year. It was Mooney who was first consulted late last month about the authenticity of digital photographic images purportedly taken by a German tourist while on a recent bushwalk in the state. On face value, Mooney says, the account of the sighting, and the two photographs submitted as the proof amount to one of the most convincing cases for the species’ survival he has seen.</p>

<p><strong>L</strong></p>
<p>And Mooney has seen it all – the mistakes, the hoaxes, the illusions and the plausible accounts of sightings. Hoaxers aside, most people who report sightings end up believing they have been a thylacine, and are themselves believable to the point they could pass a lie-detector test, according to Mooney. Others, having tabled a creditable report, then become utterly obsessed like the Tasmanian who has registered 99 thylacine sightings to date. Mooney has seen individuals bankrupted by the obsession, and families destroyed. “It is a blind optimism that something is, rather than a cynicism that something isn’t,” Mooney says. “If something crosses the road, it’s not a case of ‘I wonder what that was?’ Rather, it is a case of ‘that’s a thylacine!’ It is a bit like a gold prospector’s blind faith, ‘it has got to be there’.”</p>

<p><strong>M</strong></p>
<p>However, Mooney treats all reports on face value. “I never try to embarrass people or make fools of them. But the fact that I don’t pack the car immediately they ring can often be taken as ridicule. Obsessive characters get irate that someone in my position is not out there when they think the thylacine is there.”</p>

<p><strong>N</strong></p>
<p>But Hans Naarding, whose sighting of a striped animal two decades ago was the highlight of “a life of animal spotting”, remains bemused by the time and money people waste on tiger searches. He says resources would be better applied to save the Tasmanian devil, and helping migratory bird populations that are declining as a result of shrinking wetlands across Australia.</p>

<p><strong>O</strong></p>
<p>Could the thylacine still be out there? “Sure,” Naarding says. But he also says any discovery of surviving thylacines would be “rather pointless”. “How do you save a species from extinction? What could you do with it? If there are thylacines out there, they are better off right where they are.”</p>',
            'order' => 2,
        ]);

        // Question 14-17 (Summary completion)
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 14,
            'type' => 'summary_completion',
            'question_text' => '',
            'options' => null,
            'correct_answer' => [
                '14' => 'black stripes',
                '15' => '12 million',
                '16' => 'Australia',
                '17' => 'European',
            ],
            'explanation' => null,
            'data' => [
                'start_number' => 13,
                'instruction' => 'Complete the summary below.<br>Choose <strong>NO MORE THAN TWO WORDS</strong> from the passage for each answer.<br>Write your answers in boxes 14-17 on your answer sheet.',
                'summary_text' => 'The Tasmanian tiger, also called thylacine, resembles the look of a dog and has <strong>[14]</strong> on its fur coat. Many fossils have been found, showing that thylacines had existed as early as <strong>[15]</strong> years ago. They lived throughout <strong>[16]</strong> before disappearing from the mainland. And soon after the <strong>[17]</strong> settlers arrived the size of thylacine population in Tasmania shrunk at a higher speed.',
                'placeholders' => [
                    '14' => 14,
                    '15' => 15,
                    '16' => 16,
                    '17' => 17
                ],
            ],
            'order' => 1,
        ]);

        // Questions 18-23: Matching People
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 18,
            'type' => 'matching_features',
            'question_text' => 'Look at the following statements (Questions 18-23) and the list of people below, match each statement with the correct person A, B, C or D.<br>Write the correct letter A, B, C or D in boxes 18-23 on your answer sheet.<br>NB You may use any letter more than once.',
            'options' => [
                'A' => 'Hans Naarding',
                'B' => 'Randolph Rose',
                'C' => 'David Pemberton',
                'D' => 'Nick Mooney'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'box_title' => 'List of People',
                'start_number' => 17,
                'sub_questions' => [
                    ['id' => '18', 'label' => 'His report of seeing a live thylacine in the wild attracted international interest.', 'correct_answer' => 'A'],
                    ['id' => '19', 'label' => 'Many eye-witnesses’ reports are not trustworthy.', 'correct_answer' => 'D'],
                    ['id' => '20', 'label' => 'It doesn’t require a certain number of animals to ensure the survival of a species.', 'correct_answer' => 'C'],
                    ['id' => '21', 'label' => 'There is no hope of finding a surviving Tasmanian tiger.', 'correct_answer' => 'B'],
                    ['id' => '22', 'label' => 'Do not disturb them if there are any Tasmanian tigers still living today.', 'correct_answer' => 'A'],
                    ['id' => '23', 'label' => 'The interpretation of evidence can be affected by people’s beliefs.', 'correct_answer' => 'D'],
                ]
            ],
            'order' => 2,
        ]);

        // Questions 24-26: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 24,
            'type' => 'multiple_choice',
            'question_text' => 'Choose the correct letter A, B, C or D.<br>Write the correct letter in boxes 24-26 on your answer sheet.',
            'options' => [
                'A' => 'government and organisations’ cooperative efforts to protect thylacine',
                'B' => 'extensive interests to find a living thylacine.',
                'C' => 'increase in the number of reports of thylacine worldwide.',
                'D' => 'growth of popularity of thylacine in literature.'
            ],
            'correct_answer' => 'B',
            'explanation' => null,
            'data' => [
                'start_number' => 23,
                'sub_questions' => [
                    ['id' => '24', 'label' => 'Hans Naarding’s sighting has resulted in', 'correct_answer' => 'B']
                ]
            ],
            'order' => 3,
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 25,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'it lived in the same period with dinosaurs.',
                'B' => 'hos dinosaurs evolved legs.',
                'C' => 'some animals are difficult to catch in the wild.',
                'D' => 'extinction of certain species can be mistaken.'
            ],
            'correct_answer' => 'D',
            'explanation' => null,
            'data' => [
                'start_number' => 24,
                'sub_questions' => [
                    ['id' => '25', 'label' => 'The example of the coelacanth is to illustrate', 'correct_answer' => 'D']
                ]
            ],
            'order' => 4,
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 26,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'given some credit as they claim even if they are untrue.',
                'B' => 'acted upon immediately.',
                'C' => 'viewed as equally untrustworthy.',
                'D' => 'questioned and carefully investigated.'
            ],
            'correct_answer' => 'A',
            'explanation' => null,
            'data' => [
                'start_number' => 25,
                'sub_questions' => [
                    ['id' => '26', 'label' => 'Mooney believes that all sighting reports should be', 'correct_answer' => 'A']
                ]
            ],
            'order' => 5,
        ]);

        // --- PASSAGE 3 ---
        $passage3 = \App\Models\IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => 'Music: Language We All Speak',
            'content' => '
<p><strong>Section A:</strong></p>
<p>Music is one of the human species’s relatively few universal abilities. Without formal training, any individual, from Stone Age tribesman to suburban teenager has the ability to recognize music and, in some fashion, to make it. Why this should be so is a mystery. After all, music isn’t necessary for getting through the day, and if it aids in reproduction, it does so only in highly indirect ways. Language, by contrast, is also everywhere-but for reasons that are more obvious. With language, you and the members of your tribe can organize a migration across Africa, build reed boats and cross the seas, and communicate at night even when you can’t see each other. Modern culture, in all its technological extravagance, springs directly from the human talent for manipulating symbols and syntax. Scientists have always been intrigued by the connection between music and language. Yet over the years, words and melody have acquired a vastly different status in the lab and the seminar room. While language has long been considered essential to unlocking the mechanisms of human intelligence, music is generally treated as an evolutionary frippery – mere “auditory cheesecake,” as the Harvard cognitive scientist Steven Pinker puts it.</p>

<p><strong>Section B:</strong></p>
<p>But thanks to a decade-long ware of neuroscience research, that tune is changing. A flurry of recent publications suggests that language and music may equally be able to tell us who we are and where we’re from – not just emotionally, but biologically. In July, the journal Nature Neuroscience devoted a special issue to the topic. And in an article in the August 6 issue of the Journal of Neuroscience, David Schwartz, Catherine Howe, and Dale Purves of Duke University argued that the sounds of music and the sounds of language are intricately connected.</p>
<p>To grasp the originality of this idea, it’s necessary to realize two things about how music has traditionally been understood. First, musicologists have long emphasized that while each culture stamps a special identity onto its music; the music itself has some universal qualities. For example, in virtually all cultures sound is divided into some or all of the 12 intervals that make up the chromatic scale – that is, the scale represented by the keys on a piano. For centuries, observers have attributed this preference for certain combinations of tones to the mathematical properties of sound itself. Some 2,500 years ago, Pythagoras was the first to note a direct relationship between the harmoniousness of a tone combination and the physical dimensions of the object that produced it. For example, a plucked string will always play an octave lower than a similar string half its size, and a fifth lower than a similar string two-thirds it’s length. This link between simple ratios and harmony has influenced music theory ever since.</p>

<p><strong>Section C:</strong></p>
<p>This music-is-math idea often accompanied by the notion that music formally speaking at least exists apart from the world in which it was created. Writing recently in The New York Review of Books, pianist and critic Charles Rosen discussed the long-standing notion that while painting and sculpture reproduce at least some aspects of the natural world, and writing describes thoughts and feelings we are all familiar with, music is entirely abstracted from the world in which we live. Neither idea is right, according to David Schwartz and his colleagues. Human musical preferences are fundamentally shaped not by elegant algorithms or ration but by the messy sounds of real life, and of speech in particular – which in turn is shaped by our evolutionary heritage. “The explanation of music, like the explanation of any product of the mind, must be rooted in biology, not in numbers per se,” says Schwartz.</p>
<p>Schwartz, Howe, and Purves analyzed a vast selection of speech sounds from a variety of languages to reveal the underlying patterns common to all utterances. In order to focus only on the raw sound, they discarded all theories about speech and meaning and sliced sentences into random bites. Using a database of over 100,000 brief segments of speech, they noted which frequency had the greatest emphasis in each sound. The resulting set of frequencies, they discovered, corresponded closely to the chromatic scale. In short, the building blocks of music are to be found in speech.</p>
<p>Far from being abstract, music presents a strange analogue to the patterns created by the sounds of speech. “Music, like the visual arts, is rooted in our experience of the natural world,” says Schwartz. “It emulates our sound environment in the way that visual arts emulate the visual environment.” In music, we hear the echo of our basic sound-making instrument – the vocal tract. The explanation for human music is simple; still than Pythagoras’s mathematical equations. We like the sounds that are familiar to us-specifically, we like sounds that remind us of us.</p>
<p>This brings up some chicken-or-egg evolutionary questions. It may be that music imitates speech directly, the researchers say, in which case it would seem that language evolved first. It’s also conceivable that music came first and language is in effect an Imitation of the song – that in everyday speech we hit the musical notes we especially like. Alternately, it may be that music imitates the general products of the human sound-making system, which just happens to be mostly speech. “We can’t know this,” says Schwartz. “What we do know is that they both come from the same system, and it is this that shapes our preferences.”</p>

<p><strong>Section D:</strong></p>
<p>Schwartz’s study also casts light on the long-running question of whether animals understand or appreciate music. Despite the apparent abundance of “music” in the natural world- birdsong, whalesong, wolf howls, synchronized chimpanzee hooting previous studies have found that many laboratory animals don’t show a great affinity for the human variety of music-making. Marc Hauser and Josh McDermott of Harvard argued in the July issue of Nature Neuroscience that animals don’t create or perceive music the way we do. The act that laboratory monkeys can show recognition of human tunes is evidence, they say, of shared general features of the auditory system, not any specific chimpanzee musical ability. As for birds, those most musical beasts, they generally recognize their own tunes – a narrow repertoire – but don’t generate novel melodies as we do. There are no avian Mozarts.</p>
<p>But what’s been played to the animals, Schwartz notes, is human music. If animals evolve preferences for sound as we do – based upon the soundscape in which they live – then their “music” would be fundamentally different from ours. In the same way, our scales derive from human utterances, a cat’s idea of a good tune would derive from yowls and meows. To demonstrate that animals don’t appreciate sounds the way we do, we’d need evidence that they don’t respond to “music” constructed from their own sound environment.</p>

<p><strong>Section E:</strong></p>
<p>No matter how the connection between language and music is parsed, what is apparent is that our sense of music, even our love for it, is as deeply rooted in our biology and in our brains as language is. This is most obvious with babies, says Sandra Trehub at the University of Toronto, who also published a paper in the Nature Neuroscience special issue.</p>
<p>For babies, music and speech are on a continuum. Mothers use musical speech to “regulate infants’ emotional states.” Trehub says. Regardless of what language they speak, the voice all mothers use with babies is the same: “something between speech and song.” This kind of communication “puts the baby in a trance-like state, which may proceed to sleep or extended periods of rapture.” So if the babies of the world could understand the latest research on language and music, they probably wouldn’t be very surprised. The upshot, says Trehub, is that music maybe even more of a necessity than we realize.</p>',
            'order' => 3,
        ]);

        // Questions 27-31: Matching Headings
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 27,
            'type' => 'matching_headings',
            'question_text' => 'Reading Passage 3 has five paragraphs A-E<br>Choose the correct heading for each section from the list of headings below.<br>Write the correct number i-viii in boxes 27-31 on your answer sheet.',
            'options' => [
                'i' => 'Animal sometimes make music.',
                'ii' => 'Recent research on music',
                'iii' => 'Culture embedded in music',
                'iv' => 'Historical theories review',
                'v' => 'Communication in music with animals',
                'vi' => 'Contrast between music and language',
                'vii' => 'Questions on a biological link with human and music',
                'viii' => 'Music is good for babies.'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'box_title' => 'List of Headings',
                'start_number' => 26,
                'sub_questions' => [
                    ['id' => '27', 'label' => 'Section A', 'correct_answer' => 'vi'],
                    ['id' => '28', 'label' => 'Section B', 'correct_answer' => 'iv'],
                    ['id' => '29', 'label' => 'Section C', 'correct_answer' => 'ii'],
                    ['id' => '30', 'label' => 'Section D', 'correct_answer' => 'v'],
                    ['id' => '31', 'label' => 'Section E', 'correct_answer' => 'vii']
                ]
            ],
            'order' => 1,
        ]);

        // Questions 32-38: Matching People
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 32,
            'type' => 'matching_features',
            'question_text' => 'Look at the following people and list of statements below.<br>Match each person with the correct statement.<br>Write the correct letter A-G in boxes 32-38 on your answer sheet.',
            'options' => [
                'A' => 'Music exists outside of the world in which it is created',
                'B' => 'Music has a common feature though cultural influences affect',
                'C' => 'Humans need music.',
                'D' => 'Music priority connects to the disordered sound around.',
                'E' => 'Discovery of mathematical musical foundation.',
                'F' => 'Music is not treated equally well compared with the language',
                'G' => 'Humans and monkeys have similar traits in perceiving sound.'
            ],
            'correct_answer' => null,
            'explanation' => null,
            'data' => [
                'box_title' => 'List of Statements',
                'start_number' => 31,
                'sub_questions' => [
                    ['id' => '32', 'label' => 'Steven Pinker', 'correct_answer' => 'F'],
                    ['id' => '33', 'label' => 'Musicologists', 'correct_answer' => 'B'],
                    ['id' => '34', 'label' => 'Greek philosopher Pythagoras', 'correct_answer' => 'E'],
                    ['id' => '35', 'label' => 'Schwartz, Howe, and Purves', 'correct_answer' => 'D'],
                    ['id' => '36', 'label' => 'Marc Hauser and Josh McDermott', 'correct_answer' => 'G'],
                    ['id' => '37', 'label' => 'Charles Rosen', 'correct_answer' => 'A'],
                    ['id' => '38', 'label' => 'Sandra Trehub', 'correct_answer' => 'C'],
                ]
            ],
            'order' => 2,
        ]);

        // Questions 39-40: Multiple Choice
        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 39,
            'type' => 'multiple_choice',
            'question_text' => 'Choose the correct letter A, B, C or D<br>Write your answers in boxes 39-40 on your answer sheet.',
            'options' => [
                'A' => 'Animals don’t have the same auditory system as humans.',
                'B' => 'Experiments on animal’s music are limited.',
                'C' => 'tunes are impossible for the animal to make up.',
                'D' => 'Animals don’t have the spontaneous ability for the tests.'
            ],
            'correct_answer' => 'B',
            'explanation' => null,
            'data' => [
                'start_number' => 38,
                'sub_questions' => [
                    ['id' => '39', 'label' => 'Why was the study of animal’s music uncertain?', 'correct_answer' => 'B']
                ]
            ],
            'order' => 3,
        ]);

        \App\Models\IeltsReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 40,
            'type' => 'multiple_choice',
            'question_text' => '',
            'options' => [
                'A' => 'Language and psychology.',
                'B' => 'Music formation.',
                'C' => 'Role of music in human society.',
                'D' => 'Music experiments for animals.'
            ],
            'correct_answer' => 'C',
            'explanation' => null,
            'data' => [
                'start_number' => 39,
                'sub_questions' => [
                    ['id' => '40', 'label' => 'what is the main subject of this passage?', 'correct_answer' => 'C']
                ]
            ],
            'order' => 4,
        ]);
        
    }
}
