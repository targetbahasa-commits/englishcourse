<?php

namespace App\Application\FreeLesson;

class VocabularyDataProvider
{
    public function getTopicsForLevel(string $level): array
    {
        return match (strtoupper($level)) {
            'A1' => [
                ['no' => '01', 'topic' => 'Greetings & Introductions', 'keywords' => 'Hello, Good morning, Name, Meet, Nice'],
                ['no' => '02', 'topic' => 'Family & Friends', 'keywords' => 'Mother, Father, Friend, Best friend, Sister'],
                ['no' => '03', 'topic' => 'Daily Routine', 'keywords' => 'Wake up, Breakfast, Work, Sleep, Lunch'],
                ['no' => '04', 'topic' => 'Numbers & Time', 'keywords' => "One, Two, O'clock, Minute, Hour"],
                ['no' => '05', 'topic' => 'Food & Drink', 'keywords' => 'Water, Bread, Rice, Eat, Drink'],
                ['no' => '06', 'topic' => 'Colors & Shapes', 'keywords' => 'Red, Blue, Circle, Square, Green'],
                ['no' => '07', 'topic' => 'Weather & Seasons', 'keywords' => 'Rain, Sun, Summer, Winter, Cold'],
                ['no' => '08', 'topic' => 'Clothing', 'keywords' => 'Shirt, Pants, Shoes, Hat, Dress'],
                ['no' => '09', 'topic' => 'House & Furniture', 'keywords' => 'Bed, Chair, Table, Kitchen, Room'],
                ['no' => '10', 'topic' => 'Animals & Nature', 'keywords' => 'Dog, Cat, Bird, Tree, Flower'],
                ['no' => '11', 'topic' => 'Body Parts & Health', 'keywords' => 'Head, Hand, Foot, Sick, Doctor'],
                ['no' => '12', 'topic' => 'Places in Town', 'keywords' => 'Bank, Hospital, Park, Store, School'],
                ['no' => '13', 'topic' => 'Jobs & Occupations', 'keywords' => 'Teacher, Doctor, Police, Chef, Driver'],
                ['no' => '14', 'topic' => 'Transport & Travel', 'keywords' => 'Car, Bus, Train, Plane, Ticket'],
                ['no' => '15', 'topic' => 'Hobbies & Free Time', 'keywords' => 'Play, Read, Watch, Music, Sport'],
                ['no' => '16', 'topic' => 'Days & Months', 'keywords' => 'Monday, Friday, January, Week, Year'],
                ['no' => '17', 'topic' => 'School & Classroom', 'keywords' => 'Book, Pen, Desk, Teacher, Student'],
                ['no' => '18', 'topic' => 'Feelings & Emotions', 'keywords' => 'Happy, Sad, Angry, Tired, Scared'],
                ['no' => '19', 'topic' => 'Shopping & Money', 'keywords' => 'Buy, Sell, Price, Cheap, Expensive'],
                ['no' => '20', 'topic' => 'Technology & Media', 'keywords' => 'Computer, Phone, Internet, Email, Video'],
            ],
            'A2' => [
                ['no' => '01', 'topic' => 'Personal Information & Background', 'keywords' => 'Name, Age, Country, Nationality, Married'],
                ['no' => '02', 'topic' => 'Home & Daily Life', 'keywords' => 'Routine, Chore, Apartment, Neighborhood, Key'],
                ['no' => '03', 'topic' => 'Work & Career', 'keywords' => 'Career, Salary, Employee, Boss, Meeting'],
                ['no' => '04', 'topic' => 'Education & Learning', 'keywords' => 'College, Course, Exam, Lesson, Degree'],
                ['no' => '05', 'topic' => 'Health & Fitness', 'keywords' => 'Exercise, Diet, Pain, Pill, Energy'],
                ['no' => '06', 'topic' => 'Travel & Transport', 'keywords' => 'Flight, Luggage, Passenger, Ticket, Journey'],
                ['no' => '07', 'topic' => 'Shopping & Services', 'keywords' => 'Receipt, Customer, Cashier, Mall, Pharmacy'],
                ['no' => '08', 'topic' => 'Food & Eating Out', 'keywords' => 'Menu, Order, Delicious, Serve, Tip'],
                ['no' => '09', 'topic' => 'Entertainment & Media', 'keywords' => 'Concert, Screen, Channel, Audience, Review'],
                ['no' => '10', 'topic' => 'Sports & Hobbies', 'keywords' => 'Match, Player, Team, Goal, Practice'],
                ['no' => '11', 'topic' => 'Nature & Environment', 'keywords' => 'Climate, Pollution, Forest, Ocean, Wild'],
                ['no' => '12', 'topic' => 'Socializing & Events', 'keywords' => 'Invite, Party, Guest, Celebrate, Host'],
                ['no' => '13', 'topic' => 'Holidays & Festivals', 'keywords' => 'Vacation, Trip, Guide, Pack, Souvenir'],
                ['no' => '14', 'topic' => 'Technology & Internet', 'keywords' => 'Download, Screen, Password, Network, App'],
                ['no' => '15', 'topic' => 'Feelings & Opinions', 'keywords' => 'Argue, Believe, Suggest, Decide, Agree'],
                ['no' => '16', 'topic' => 'Money & Finance', 'keywords' => 'Bank, Save, Loan, Account, Cash'],
                ['no' => '17', 'topic' => 'Culture & Traditions', 'keywords' => 'Custom, Belief, Traditional, Heritage, Society'],
                ['no' => '18', 'topic' => 'Future Plans & Intentions', 'keywords' => 'Goal, Dream, Plan, Expect, Hope'],
                ['no' => '19', 'topic' => 'Geography & Places', 'keywords' => 'Capital, Border, Region, Continent, Landscape'],
                ['no' => '20', 'topic' => 'History & Past Events', 'keywords' => 'Century, Ancient, Rule, Battle, Historic'],
            ],
            'B1' => [
                ['no' => '01', 'topic' => 'Education & Learning Styles', 'keywords' => 'Semester, Assignment, Curriculum, Memorize, Graduate'],
                ['no' => '02', 'topic' => 'Work & Professions', 'keywords' => 'Profession, Recruit, Challenge, Promotion, Resume'],
                ['no' => '03', 'topic' => 'Health & Medicine', 'keywords' => 'Symptom, Treatment, Prescription, Recovery, Surgeon'],
                ['no' => '04', 'topic' => 'Travel & Tourism', 'keywords' => 'Destination, Excursion, Itinerary, Backpack, Souvenir'],
                ['no' => '05', 'topic' => 'Environment & Nature', 'keywords' => 'Pollution, Recycle, Wildlife, Resource, Conserve'],
                ['no' => '06', 'topic' => 'Technology & Gadgets', 'keywords' => 'Device, Wireless, Update, Install, Digital'],
                ['no' => '07', 'topic' => 'Media & Entertainment', 'keywords' => 'Broadcast, Audience, Episode, Commercial, Review'],
                ['no' => '08', 'topic' => 'Shopping & Consumerism', 'keywords' => 'Consumer, Bargain, Refund, Guarantee, Purchase'],
                ['no' => '09', 'topic' => 'Food & Restaurants', 'keywords' => 'Cuisine, Ingredient, Recipe, Vegetarian, Flavor'],
                ['no' => '10', 'topic' => 'Relationships & Family', 'keywords' => 'Relative, Generation, Engaged, Divorced, Arguments'],
                ['no' => '11', 'topic' => 'Hobbies & Leisure', 'keywords' => 'Pastime, Collection, Tournament, Perform, Creative'],
                ['no' => '12', 'topic' => 'City Life & Transport', 'keywords' => 'Commute, Traffic, Pedestrian, Suburb, Downtown'],
                ['no' => '13', 'topic' => 'Crime & Law', 'keywords' => 'Arrest, Suspect, Evidence, Court, Illegal'],
                ['no' => '14', 'topic' => 'Feelings & Emotions', 'keywords' => 'Anxious, Confused, Jealous, Proud, Ashamed'],
                ['no' => '15', 'topic' => 'Communication & Language', 'keywords' => 'Dialect, Accent, Fluency, Express, Grammar'],
                ['no' => '16', 'topic' => 'Science & Discoveries', 'keywords' => 'Experiment, Laboratory, Theory, Analyze, Element'],
                ['no' => '17', 'topic' => 'Culture & Arts', 'keywords' => 'Heritage, Tradition, Exhibition, Sculpture, Canvas'],
                ['no' => '18', 'topic' => 'Money & Economy', 'keywords' => 'Currency, Invest, Profit, Budget, Debt'],
                ['no' => '19', 'topic' => 'Holidays & Traditions', 'keywords' => 'Celebrate, Festival, Custom, Ritual, Occasion'],
                ['no' => '20', 'topic' => 'Future & Predictions', 'keywords' => 'Predict, Decade, Forecast, Advance, Humanity'],
            ],
            'B2' => [
                ['no' => '01', 'topic' => 'Global Issues & Politics', 'keywords' => 'Democracy, Policy, Campaign, Poverty, Election'],
                ['no' => '02', 'topic' => 'Business & Economy', 'keywords' => 'Corporate, Entrepreneur, Subsidize, Revenue, Strategy'],
                ['no' => '03', 'topic' => 'Advanced Technology & AI', 'keywords' => 'Innovation, Artificial, Database, Algorithm, Automate'],
                ['no' => '04', 'topic' => 'Environment & Climate Change', 'keywords' => 'Deforestation, Emission, Sustainable, Ecosystem, Species'],
                ['no' => '05', 'topic' => 'Psychology & Mind', 'keywords' => 'Cognitive, Empathy, Subconscious, Motivation, Behavior'],
                ['no' => '06', 'topic' => 'Arts & Literature', 'keywords' => 'Masterpiece, Metaphor, Genre, Canvas, Symphony'],
                ['no' => '07', 'topic' => 'Media & Journalism', 'keywords' => 'Censorship, Circulation, Tabloid, Bias, Objective'],
                ['no' => '08', 'topic' => 'Health & Medical Science', 'keywords' => 'Therapy, Epidemic, Transplant, Immunity, Diagnosis'],
                ['no' => '09', 'topic' => 'Education & Academics', 'keywords' => 'Scholarship, Pedagogy, Discipline, Enroll, Evaluate'],
                ['no' => '10', 'topic' => 'Crime, Justice & Law', 'keywords' => 'Verdict, Sentence, Prosecution, Testimony, Convict'],
                ['no' => '11', 'topic' => 'Social Issues & Inequality', 'keywords' => 'Discrimination, Prejudice, Welfare, Privilege, Marginalized'],
                ['no' => '12', 'topic' => 'Travel & Migration', 'keywords' => 'Immigrant, Refugee, Heritage, Nomadic, Settle'],
                ['no' => '13', 'topic' => 'Relationships & Communication', 'keywords' => 'Acquaintance, Compromise, Reconcile, Interpersonal, Mutual'],
                ['no' => '14', 'topic' => 'History & Archaeology', 'keywords' => 'Excavate, Artifact, Civilization, Decipher, Prehistoric'],
                ['no' => '15', 'topic' => 'Sports & Competitions', 'keywords' => 'Spectator, Endure, Opponent, Tactic, Referee'],
                ['no' => '16', 'topic' => 'Work Ethic & Corporate Life', 'keywords' => 'Productivity, Delegate, Maternity, Redundant, Pension'],
                ['no' => '17', 'topic' => 'Language & Linguistics', 'keywords' => 'Bilingual, Dialect, Phonetic, Interpretation, Syntax'],
                ['no' => '18', 'topic' => 'Ethics & Philosophy', 'keywords' => 'Moral, Dilemma, Utilitarian, Rational, Conscience'],
                ['no' => '19', 'topic' => 'Beliefs & Religion', 'keywords' => 'Sacred, Secular, Dogma, Ritual, Tolerance'],
                ['no' => '20', 'topic' => 'Architecture & Urban Planning', 'keywords' => 'Infrastructure, Renovation, Skyscraper, Demolish, Aesthetic'],
            ],
            'C1' => [
                ['no' => '01', 'topic' => 'Abstract Concepts & Ideologies', 'keywords' => 'Paradigm, Pragmatic, Egalitarian, Dogmatic, Nihilism'],
                ['no' => '02', 'topic' => 'Advanced Science & Physics', 'keywords' => 'Quantum, Hypothesis, Empirical, Catalyst, Velocity'],
                ['no' => '03', 'topic' => 'Philosophy & Human Existence', 'keywords' => 'Existential, Consciousness, Metaphysics, Epistemology, Altruism'],
                ['no' => '04', 'topic' => 'Global Law & International Relations', 'keywords' => 'Jurisdiction, Sovereignty, Diplomat, Embargo, Treaty'],
                ['no' => '05', 'topic' => 'Economics & Global Markets', 'keywords' => 'Macroeconomics, Volatility, Oligopoly, Deflation, Subsidy'],
                ['no' => '06', 'topic' => 'Literature & Rhetoric', 'keywords' => 'Satire, Hyperbole, Rhetorical, Irony, Protagonist'],
                ['no' => '07', 'topic' => 'Sociology & Cultural Shifts', 'keywords' => 'Assimilation, Stratification, Demographic, Paradigm, Mores'],
                ['no' => '08', 'topic' => 'Linguistics & Etymology', 'keywords' => 'Syntax, Phonetics, Etymology, Jargon, Colloquial'],
                ['no' => '09', 'topic' => 'Complex Medical Jargon', 'keywords' => 'Neurology, Placebo, Oncology, Pathogen, Prognosis'],
                ['no' => '10', 'topic' => 'Corporate Management & Leadership', 'keywords' => 'Delegation, Meritocracy, Synergize, Bureaucracy, Autonomy'],
                ['no' => '11', 'topic' => 'Environmental Crisis & Solutions', 'keywords' => 'Biodegradable, Mitigation, Salinity, Desertification, Ecology'],
                ['no' => '12', 'topic' => 'Advanced Computing & Cybernetics', 'keywords' => 'Encryption, Heuristic, Cybernetics, Bandwidth, Syntax'],
                ['no' => '13', 'topic' => 'Architecture & Urban Geometrics', 'keywords' => 'Symmetry, Cantilever, Urbanization, Aesthetic, Facade'],
                ['no' => '14', 'topic' => 'Aeronautics & Space Exploration', 'keywords' => 'Trajectory, Orbit, Cosmos, Propulsion, Nebula'],
                ['no' => '15', 'topic' => 'Fine Arts & Criticism', 'keywords' => 'Surrealism, Motif, Critique, Avant-garde, Chiaroscuro'],
                ['no' => '16', 'topic' => 'Historical Epochs & Antiquity', 'keywords' => 'Renaissance, Feudalism, Antiquity, Monarch, Dynasty'],
                ['no' => '17', 'topic' => 'Forensics & Criminology', 'keywords' => 'Autopsy, Ballistics, Interrogation, Perpetrator, Criminology'],
                ['no' => '18', 'topic' => 'Human Psychology & Pathologies', 'keywords' => 'Psychopath, Narcissism, Subconscious, Neurotic, Schizophrenia'],
                ['no' => '19', 'topic' => 'Journalism & Media Ethics', 'keywords' => 'Sensationalism, Plagiarism, Defamation, Libel, Slander'],
                ['no' => '20', 'topic' => 'Future Technologies & Speculation', 'keywords' => 'Nanotechnology, Transhumanism, Singularity, Utopia, Dystopia'],
            ],
            default => [],
        };
    }

    public function getVocabularyForTopic(string $level, string $id): array
    {
        $level = strtoupper($level);

        // A1 has its own hardcoded fallbacks for ids 01 and 02
        if ($level === 'A1') {
            return $this->getA1TopicData($id);
        }

        $jsonKey = strtolower($level) . '_vocabulary';
        $jsonPath = storage_path("app/{$jsonKey}.json");
        $topicsMeta = $this->getTopicsMeta($level);

        if (file_exists($jsonPath)) {
            $json = json_decode(file_get_contents($jsonPath), true);
            if (isset($json[$id])) {
                return [
                    'title' => $topicsMeta[$id] ?? "Topic $id ($level)",
                    'vocabularies' => $json[$id],
                ];
            }
        }

        return [
            'title' => $topicsMeta[$id] ?? "Topic $id ($level)",
            'vocabularies' => $this->getMockVocabularies($level, $id),
        ];
    }

    public function getMockLevels(string $type): array
    {
        $levels = ['A1', 'A2', 'B1', 'B2', 'C1'];
        $data = [];
        foreach ($levels as $lvl) {
            $data[] = [
                'level' => $lvl,
                'title' => ucfirst($type) . " $lvl",
                'description' => "Essential $type for $lvl level learners.",
                'count' => 50,
                'image' => "https://via.placeholder.com/150?text=$lvl",
            ];
        }
        return $data;
    }

    public function getMockLevels3(string $type): array
    {
        $levels = ['Basic', 'Intermediate', 'Advanced'];
        $data = [];
        foreach ($levels as $lvl) {
            $count = 30;
            $levelLower = strtolower($lvl);
            $fileSuffix = match ($type) {
                'expression' => 'expressions',
                'idiom' => 'idioms',
                'phrasal verb' => 'phrasal_verbs',
                default => '',
            };

            if ($fileSuffix) {
                $filePath = storage_path("app/{$levelLower}_{$fileSuffix}.json");
                if (file_exists($filePath)) {
                    $items = json_decode(file_get_contents($filePath), true);
                    if (is_array($items)) {
                        $count = count($items);
                    }
                }
            }

            $data[] = [
                'level' => $lvl,
                'title' => ucfirst($type) . " $lvl",
                'description' => "Learn $lvl $type usage.",
                'count' => $count,
                'image' => "https://via.placeholder.com/150?text=$lvl",
            ];
        }
        return $data;
    }

    public function getMockExpressions(string $level): array
    {
        $data = [];
        for ($i = 1; $i <= 15; $i++) {
            $data[] = [
                'expression' => "Expression $i",
                'meaning' => "Meaning of expression $i",
                'translation' => "Terjemahan $i",
                'example' => "This is how you use expression $i in a sentence.",
            ];
        }
        return $data;
    }

    public function getMockIdioms(string $level): array
    {
        $data = [];
        for ($i = 1; $i <= 15; $i++) {
            $data[] = [
                'idiom' => "Idiom $i",
                'meaning' => "Meaning of idiom $i",
                'translation' => "Terjemahan $i",
                'example' => "Example sentence for idiom $i.",
            ];
        }
        return $data;
    }

    public function getMockPhrasalVerbs(string $level): array
    {
        $data = [];
        for ($i = 1; $i <= 15; $i++) {
            $data[] = [
                'phrasal_verb' => "Phrasal Verb $i",
                'meaning' => "Meaning of phrasal verb $i",
                'translation' => "Terjemahan $i",
                'example' => "Example usage of phrasal verb $i.",
            ];
        }
        return $data;
    }

    public function getMockVocabularies(string $level, string $id): array
    {
        $data = [];
        for ($i = 1; $i <= 20; $i++) {
            $data[] = [
                'word' => "Word $i ($level)",
                'translation' => "Kata $i",
                'example_en' => "This is an example for word $i in $level.",
                'example_id' => "Ini adalah contoh untuk kata $i di $level.",
            ];
        }
        return $data;
    }

    private function getTopicsMeta(string $level): array
    {
        return match (strtoupper($level)) {
            'A1' => [
                '01' => 'Greetings & Introductions', '02' => 'Family & Friends',
                '03' => 'Daily Routine', '04' => 'Numbers & Time', '05' => 'Food & Drink',
                '06' => 'Colors & Shapes', '07' => 'Weather & Seasons', '08' => 'Clothing',
                '09' => 'House & Furniture', '10' => 'Animals & Nature', '11' => 'Body Parts & Health',
                '12' => 'Places in Town', '13' => 'Jobs & Occupations', '14' => 'Transport & Travel',
                '15' => 'Hobbies & Free Time', '16' => 'Days & Months', '17' => 'School & Classroom',
                '18' => 'Feelings & Emotions', '19' => 'Shopping & Money', '20' => 'Technology & Media',
            ],
            'A2' => [
                '01' => 'Personal Information & Background', '02' => 'Home & Daily Life',
                '03' => 'Work & Career', '04' => 'Education & Learning', '05' => 'Health & Fitness',
                '06' => 'Travel & Transport', '07' => 'Shopping & Services', '08' => 'Food & Eating Out',
                '09' => 'Entertainment & Media', '10' => 'Sports & Hobbies', '11' => 'Nature & Environment',
                '12' => 'Socializing & Events', '13' => 'Holidays & Festivals', '14' => 'Technology & Internet',
                '15' => 'Feelings & Opinions', '16' => 'Money & Finance', '17' => 'Culture & Traditions',
                '18' => 'Future Plans & Intentions', '19' => 'Geography & Places', '20' => 'History & Past Events',
            ],
            'B1' => [
                '01' => 'Education & Learning Styles', '02' => 'Work & Professions', '03' => 'Health & Medicine',
                '04' => 'Travel & Tourism', '05' => 'Environment & Nature', '06' => 'Technology & Gadgets',
                '07' => 'Media & Entertainment', '08' => 'Shopping & Consumerism', '09' => 'Food & Restaurants',
                '10' => 'Relationships & Family', '11' => 'Hobbies & Leisure', '12' => 'City Life & Transport',
                '13' => 'Crime & Law', '14' => 'Feelings & Emotions', '15' => 'Communication & Language',
                '16' => 'Science & Discoveries', '17' => 'Culture & Arts', '18' => 'Money & Economy',
                '19' => 'Holidays & Traditions', '20' => 'Future & Predictions',
            ],
            'B2' => [
                '01' => 'Global Issues & Politics', '02' => 'Business & Economy', '03' => 'Advanced Technology & AI',
                '04' => 'Environment & Climate Change', '05' => 'Psychology & Mind', '06' => 'Arts & Literature',
                '07' => 'Media & Journalism', '08' => 'Health & Medical Science', '09' => 'Education & Academics',
                '10' => 'Crime, Justice & Law', '11' => 'Social Issues & Inequality', '12' => 'Travel & Migration',
                '13' => 'Relationships & Communication', '14' => 'History & Archaeology', '15' => 'Sports & Competitions',
                '16' => 'Work Ethic & Corporate Life', '17' => 'Language & Linguistics', '18' => 'Ethics & Philosophy',
                '19' => 'Beliefs & Religion', '20' => 'Architecture & Urban Planning',
            ],
            'C1' => [
                '01' => 'Abstract Concepts & Ideologies', '02' => 'Advanced Science & Physics',
                '03' => 'Philosophy & Human Existence', '04' => 'Global Law & International Relations',
                '05' => 'Economics & Global Markets', '06' => 'Literature & Rhetoric',
                '07' => 'Sociology & Cultural Shifts', '08' => 'Linguistics & Etymology',
                '09' => 'Complex Medical Jargon', '10' => 'Corporate Management & Leadership',
                '11' => 'Environmental Crisis & Solutions', '12' => 'Advanced Computing & Cybernetics',
                '13' => 'Architecture & Urban Geometrics', '14' => 'Aeronautics & Space Exploration',
                '15' => 'Fine Arts & Criticism', '16' => 'Historical Epochs & Antiquity',
                '17' => 'Forensics & Criminology', '18' => 'Human Psychology & Pathologies',
                '19' => 'Journalism & Media Ethics', '20' => 'Future Technologies & Speculation',
            ],
            default => [],
        };
    }

    private function getA1TopicData(string $id): array
    {
        $topicsMeta = $this->getTopicsMeta('A1');

        if ($id === '01') {
            return [
                'title' => 'Greetings & Introductions',
                'vocabularies' => [
                    ['word' => 'Hello', 'translation' => 'Halo', 'example_en' => 'Hello, how are you?', 'example_id' => 'Halo, apa kabar?'],
                    ['word' => 'Good morning', 'translation' => 'Selamat pagi', 'example_en' => 'Good morning, everyone.', 'example_id' => 'Selamat pagi, semuanya.'],
                    ['word' => 'Good afternoon', 'translation' => 'Selamat siang/sore', 'example_en' => 'Good afternoon, sir.', 'example_id' => 'Selamat siang, Pak.'],
                    ['word' => 'Good evening', 'translation' => 'Selamat malam (Sapaan)', 'example_en' => 'Good evening, welcome to our restaurant.', 'example_id' => 'Selamat malam, selamat datang di restoran kami.'],
                    ['word' => 'Good night', 'translation' => 'Selamat malam (Perpisahan/Tidur)', 'example_en' => 'Good night, sleep well.', 'example_id' => 'Selamat malam, tidur yang nyenyak.'],
                    ['word' => 'Goodbye', 'translation' => 'Selamat tinggal / Sampai jumpa', 'example_en' => 'Goodbye, see you tomorrow.', 'example_id' => 'Sampai jumpa, sampai ketemu besok.'],
                    ['word' => 'See you later', 'translation' => 'Sampai jumpa lagi', 'example_en' => 'I have to go now. See you later!', 'example_id' => 'Saya harus pergi sekarang. Sampai jumpa lagi!'],
                    ['word' => 'How are you?', 'translation' => 'Apa kabar?', 'example_en' => 'Hi Sarah, how are you today?', 'example_id' => 'Hai Sarah, apa kabarmu hari ini?'],
                    ['word' => 'I am fine', 'translation' => 'Saya baik-baik saja', 'example_en' => 'I am fine, thank you.', 'example_id' => 'Saya baik-baik saja, terima kasih.'],
                    ['word' => 'Nice to meet you', 'translation' => 'Senang bertemu denganmu', 'example_en' => 'Nice to meet you, Sarah.', 'example_id' => 'Senang bertemu denganmu, Sarah.'],
                    ['word' => 'Name', 'translation' => 'Nama', 'example_en' => 'My name is John.', 'example_id' => 'Nama saya John.'],
                    ['word' => 'Thank you', 'translation' => 'Terima kasih', 'example_en' => 'Thank you for your help.', 'example_id' => 'Terima kasih atas bantuan Anda.'],
                    ['word' => "You're welcome", 'translation' => 'Sama-sama', 'example_en' => "You're welcome. Have a good day!", 'example_id' => 'Sama-sama. Semoga harimu menyenangkan!'],
                    ['word' => 'Please', 'translation' => 'Tolong / Silakan', 'example_en' => 'Can you help me, please?', 'example_id' => 'Bisakah Anda menolong saya?'],
                    ['word' => 'Excuse me', 'translation' => 'Permisi / Maaf', 'example_en' => 'Excuse me, where is the restroom?', 'example_id' => 'Permisi, di mana toiletnya?'],
                    ['word' => 'Sorry', 'translation' => 'Maaf', 'example_en' => 'I am sorry, I am late.', 'example_id' => 'Maaf, saya terlambat.'],
                    ['word' => 'Yes', 'translation' => 'Ya', 'example_en' => 'Yes, I understand.', 'example_id' => 'Ya, saya mengerti.'],
                    ['word' => 'No', 'translation' => 'Tidak', 'example_en' => "No, I don't know.", 'example_id' => 'Tidak, saya tidak tahu.'],
                    ['word' => 'Mr.', 'translation' => 'Bapak / Tuan', 'example_en' => 'This is Mr. Smith.', 'example_id' => 'Ini Bapak Smith.'],
                    ['word' => 'Mrs.', 'translation' => 'Ibu / Nyonya', 'example_en' => 'Mrs. Johnson is my teacher.', 'example_id' => 'Ibu Johnson adalah guru saya.'],
                    ['word' => 'Miss', 'translation' => 'Nona', 'example_en' => 'Excuse me, Miss.', 'example_id' => 'Permisi, Nona.'],
                ],
            ];
        }

        if ($id === '02') {
            return [
                'title' => 'Family & Friends',
                'vocabularies' => [
                    ['word' => 'Family', 'translation' => 'Keluarga', 'example_en' => 'I have a big family.', 'example_id' => 'Saya punya keluarga besar.'],
                    ['word' => 'Mother', 'translation' => 'Ibu', 'example_en' => 'My mother is very kind.', 'example_id' => 'Ibu saya sangat baik.'],
                    ['word' => 'Father', 'translation' => 'Ayah', 'example_en' => 'My father works hard.', 'example_id' => 'Ayah saya bekerja keras.'],
                    ['word' => 'Parents', 'translation' => 'Orang tua', 'example_en' => 'I love my parents.', 'example_id' => 'Saya menyayangi orang tua saya.'],
                    ['word' => 'Brother', 'translation' => 'Saudara laki-laki', 'example_en' => 'He is my older brother.', 'example_id' => 'Dia adalah kakak laki-laki saya.'],
                    ['word' => 'Sister', 'translation' => 'Saudara perempuan', 'example_en' => 'My sister likes reading.', 'example_id' => 'Saudara perempuan saya suka membaca.'],
                    ['word' => 'Son', 'translation' => 'Anak laki-laki', 'example_en' => 'Their son is a student.', 'example_id' => 'Anak laki-laki mereka adalah seorang siswa.'],
                    ['word' => 'Daughter', 'translation' => 'Anak perempuan', 'example_en' => 'She has one daughter.', 'example_id' => 'Dia memiliki satu anak perempuan.'],
                    ['word' => 'Grandmother', 'translation' => 'Nenek', 'example_en' => 'My grandmother cooks well.', 'example_id' => 'Nenek saya pintar memasak.'],
                    ['word' => 'Grandfather', 'translation' => 'Kakek', 'example_en' => 'My grandfather is very wise.', 'example_id' => 'Kakek saya sangat bijaksana.'],
                    ['word' => 'Uncle', 'translation' => 'Paman', 'example_en' => 'My uncle lives in Jakarta.', 'example_id' => 'Paman saya tinggal di Jakarta.'],
                    ['word' => 'Aunt', 'translation' => 'Bibi', 'example_en' => 'Aunt Maria is a doctor.', 'example_id' => 'Bibi Maria adalah seorang dokter.'],
                    ['word' => 'Cousin', 'translation' => 'Sepupu', 'example_en' => 'I play with my cousin.', 'example_id' => 'Saya bermain dengan sepupu saya.'],
                    ['word' => 'Husband', 'translation' => 'Suami', 'example_en' => 'Her husband is a teacher.', 'example_id' => 'Suaminya adalah seorang guru.'],
                    ['word' => 'Wife', 'translation' => 'Istri', 'example_en' => 'His wife is very beautiful.', 'example_id' => 'Istrinya sangat cantik.'],
                    ['word' => 'Child', 'translation' => 'Anak (Tunggal)', 'example_en' => 'The child is playing outside.', 'example_id' => 'Anak itu sedang bermain di luar.'],
                    ['word' => 'Children', 'translation' => 'Anak-anak (Jamak)', 'example_en' => 'The children are happy.', 'example_id' => 'Anak-anak itu bahagia.'],
                    ['word' => 'Friend', 'translation' => 'Teman', 'example_en' => 'She is my best friend.', 'example_id' => 'Dia adalah sahabat saya.'],
                    ['word' => 'Best friend', 'translation' => 'Sahabat', 'example_en' => 'We are best friends forever.', 'example_id' => 'Kita adalah sahabat selamanya.'],
                    ['word' => 'Neighbor', 'translation' => 'Tetangga', 'example_en' => 'My neighbor is friendly.', 'example_id' => 'Tetangga saya ramah.'],
                ],
            ];
        }

        // For other A1 IDs, load from JSON
        $jsonPath = storage_path('app/a1_vocabulary.json');
        if (file_exists($jsonPath)) {
            $json = json_decode(file_get_contents($jsonPath), true);
            if (isset($json[$id])) {
                return [
                    'title' => $topicsMeta[$id] ?? "Topic $id",
                    'vocabularies' => $json[$id],
                ];
            }
        }

        return [
            'title' => $topicsMeta[$id] ?? "Topic $id",
            'vocabularies' => $this->getMockVocabularies('A1', $id),
        ];
    }
}
