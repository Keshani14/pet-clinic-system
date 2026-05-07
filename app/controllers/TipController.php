<?php

/**
 * TipController — manages health tips and educational content for pet owners.
 */
class TipController extends Controller {

    public function __construct() {
        Auth::requireRole('owner');
    }

    /**
     * Show the health tips page.
     */
    public function index() {
        // Tips data could be fetched from DB, but for now hardcoded for speed and reliability
        $tips = [
            [
                'id' => 1,
                'title' => 'Hydration is Key',
                'category' => 'Nutrition',
                'icon' => '💧',
                'content' => 'Always ensure your pet has access to clean, fresh water. Dehydration can lead to serious kidney issues, especially in cats and senior dogs.',
                'tags' => ['water', 'hydration', 'summer']
            ],
            [
                'id' => 2,
                'title' => 'The Danger of Grapes',
                'category' => 'Nutrition',
                'icon' => '🍇',
                'content' => 'Never feed grapes or raisins to dogs. Even small amounts can cause acute renal failure. Stick to dog-safe treats like carrots or apples.',
                'tags' => ['toxic', 'food', 'safety']
            ],
            [
                'id' => 3,
                'title' => 'Daily Brushing',
                'category' => 'Hygiene',
                'icon' => '🪥',
                'content' => 'Dental health is often overlooked. Brushing your pet\'s teeth daily can prevent periodontal disease, which can affect the heart and kidneys.',
                'tags' => ['dental', 'teeth', 'cleaning']
            ],
            [
                'id' => 4,
                'title' => 'Consistent Exercise',
                'category' => 'Exercise',
                'icon' => '🏃',
                'content' => 'At least 30 minutes of active play or walking keeps joints healthy and prevents obesity. Tailor the intensity to your pet\'s age and breed.',
                'tags' => ['walking', 'play', 'fitness']
            ],
            [
                'id' => 5,
                'title' => 'Tick & Flea Prevention',
                'category' => 'Preventive',
                'icon' => '🦟',
                'content' => 'Use veterinarian-recommended flea and tick preventatives year-round. These parasites can transmit Lyme disease and tapeworms.',
                'tags' => ['parasites', 'seasonal', 'safety']
            ],
            [
                'id' => 6,
                'title' => 'Mental Stimulation',
                'category' => 'Mental Health',
                'icon' => '🧠',
                'content' => 'Puzzle toys and scent games are as exhausting as a long walk. Mental stimulation prevents destructive behaviors caused by boredom.',
                'tags' => ['toys', 'brain', 'training']
            ],
            [
                'id' => 7,
                'title' => 'Portion Control',
                'category' => 'Nutrition',
                'icon' => '⚖️',
                'content' => 'Measure your pet\'s food every time. Obesity is the #1 health problem in pets and can shorten their lifespan by up to 2 years.',
                'tags' => ['weight', 'food', 'diet']
            ],
            [
                'id' => 8,
                'title' => 'Nail Trimming',
                'category' => 'Hygiene',
                'icon' => '✂️',
                'content' => 'If you can hear your pet\'s nails clicking on the floor, they are too long. Long nails can cause pain and permanent joint damage.',
                'tags' => ['grooming', 'nails']
            ]
        ];

        $this->view('tips/index', [
            'tips' => $tips
        ]);
    }
}
