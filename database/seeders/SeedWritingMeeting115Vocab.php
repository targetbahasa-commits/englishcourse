<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IeltsWritingMeeting;

class SeedWritingMeeting115Vocab extends Seeder
{
    public function run()
    {
        $meeting = IeltsWritingMeeting::find(115);

        if ($meeting) {
            $meeting->update([
                'idioms' => [
                    [
                        'phrase' => 'learn the ropes',
                        'meaning' => 'to learn how to do a job or activity',
                        'example' => 'It takes a few months to learn the ropes of any new profession.'
                    ],
                    [
                        'phrase' => 'get a foot in the door',
                        'meaning' => 'to enter a business or organization at a low level, but with a chance to be more successful in the future',
                        'example' => 'An internship is a great way to get a foot in the door at a major company.'
                    ],
                    [
                        'phrase' => 'bring something to the table',
                        'meaning' => 'to provide something that will be a benefit',
                        'example' => 'University graduates bring fresh perspectives and theoretical knowledge to the table.'
                    ],
                    [
                        'phrase' => 'hit the ground running',
                        'meaning' => 'to start something and proceed at a fast pace with great enthusiasm',
                        'example' => 'Employers often prefer candidates who can hit the ground running without extensive training.'
                    ],
                    [
                        'phrase' => 'climb the corporate ladder',
                        'meaning' => 'to advance in a company by getting promotions',
                        'example' => 'Networking is often essential for those wishing to climb the corporate ladder quickly.'
                    ]
                ],
                'collocations' => [
                    [
                        'word' => 'acquire',
                        'collocation' => 'skills/knowledge',
                        'meaning' => 'to gain or learn',
                        'example' => 'Students attend university to acquire in-depth knowledge in their chosen field.'
                    ],
                    [
                        'phrase' => 'theoretical knowledge',
                        'meaning' => 'knowledge based on ideas rather than experience',
                        'example' => 'While theoretical knowledge is important, practical skills are often more valued by employers.'
                    ],
                    [
                        'phrase' => 'hands-on experience',
                        'meaning' => 'knowledge or skill that someone gets from doing something rather than just reading about it',
                        'example' => 'Vocational training provides students with valuable hands-on experience.'
                    ],
                    [
                        'phrase' => 'career prospects',
                        'meaning' => 'chances of being successful in a career',
                        'example' => 'A degree from a prestigious university can significantly improve one\'s career prospects.'
                    ],
                    [
                        'phrase' => 'tertiary education',
                        'meaning' => 'education at a college or university level',
                        'example' => 'The cost of tertiary education has risen dramatically in recent years.'
                    ]
                ]
            ]);
            
            $this->command->info('Updated Meeting 115 with idioms and collocations.');
        } else {
            $this->command->error('Meeting 115 not found!');
        }
    }
}
