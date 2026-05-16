<?php

class HomeController extends Controller {

    public function index() {
        $this->view("home");
    }

    public function about() {
        $this->view('about');
    }

    public function team() {
        $this->view('team');
    }

    public function services() {
        $this->view('services');
    }

    public function contact() {
        $this->view('contact');
    }

    public function serviceDetail() {
        $slug = $_GET['service'] ?? '';

        $services = [
            'pain-control' => [
                'name'       => 'Comprehensive Pain Control',
                'icon'       => '💊',
                'image'      => 'https://images.unsplash.com/photo-1587300003388-59208cc962cb?auto=format&fit=crop&w=1400&q=80',
                'heading'    => 'Expert <span>Pain Management</span> for Your Pet',
                'summary'    => 'Advanced multimodal pain relief strategies for cats, dogs and more.',
                'paragraphs' => [
                    'Pain management is a cornerstone of compassionate veterinary care. At Furry Friends, we believe every animal deserves to live comfortably and free from unnecessary suffering. Our team of specialists uses the latest multimodal pain control techniques to ensure your pet recovers quickly and comfortably.',
                    'Whether your pet is recovering from surgery, managing a chronic condition like arthritis, or receiving treatment for an acute injury, our evidence-based pain protocols are tailored specifically to their needs and species.',
                ],
                'features' => [
                    'Pre-surgical and post-surgical pain assessment',
                    'Chronic pain management programs (arthritis, cancer)',
                    'Non-opioid and opioid analgesic options',
                    'Rehabilitation therapy integration',
                    'Regular follow-up monitoring and dose adjustments',
                ],
            ],
            'anesthesia' => [
                'name'       => 'Advanced Anesthesia',
                'icon'       => '😴',
                'image'      => 'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=1400&q=80',
                'heading'    => 'Safe & <span>Monitored Anesthesia</span>',
                'summary'    => 'State-of-the-art anesthesia care with continuous patient monitoring.',
                'paragraphs' => [
                    'Anesthesia is one of the most critical aspects of veterinary medicine. Our board-certified anesthesiologists and highly trained technicians use the latest monitoring equipment to ensure your pet is safe throughout every procedure.',
                    'We perform thorough pre-anesthetic evaluations, including bloodwork and physical exams, to identify any risk factors before administering anesthesia. Throughout the procedure, vital signs are continuously tracked to guarantee the highest level of safety.',
                ],
                'features' => [
                    'Pre-anesthetic blood screening',
                    'ECG, pulse oximetry, and capnography monitoring',
                    'Species-specific anesthetic protocols',
                    'Dedicated anesthesia technician for every procedure',
                    'Smooth and pain-free recovery protocols',
                ],
            ],
            'surgery' => [
                'name'       => 'Companion Animal Surgery',
                'icon'       => '🔬',
                'image'      => 'https://images.unsplash.com/photo-1596492784531-6e6eb5ea9993?auto=format&fit=crop&w=1400&q=80',
                'heading'    => 'Advanced <span>Surgical Procedures</span>',
                'summary'    => 'Routine and complex surgeries performed in state-of-the-art suites.',
                'paragraphs' => [
                    'Our surgical team performs a wide range of procedures from routine spays and neuters to complex orthopaedic and soft-tissue surgeries. Every operating suite is fully equipped with the latest surgical instruments and monitoring technology.',
                    'We prioritize minimally invasive techniques wherever possible to reduce recovery time and discomfort. Post-operative care is meticulously planned to ensure a smooth and speedy return to health.',
                ],
                'features' => [
                    'Spay, neuter, and routine soft tissue surgery',
                    'Orthopaedic surgery (fractures, ligament repair)',
                    'Minimally invasive laparoscopic options',
                    'Dedicated surgical recovery suite',
                    'Comprehensive post-operative care plans',
                ],
            ],
            'medical-services' => [
                'name'       => 'Companion Animal Medical Services',
                'icon'       => '🏥',
                'image'      => 'https://images.unsplash.com/photo-1548767797-d8c844163c4c?auto=format&fit=crop&w=1400&q=80',
                'heading'    => 'Comprehensive <span>Internal Medicine</span>',
                'summary'    => 'Diagnosis and treatment of complex medical conditions in dogs and cats.',
                'paragraphs' => [
                    'From diabetes to heart disease, our internal medicine specialists are equipped to diagnose and manage a full spectrum of medical conditions in your companion animals. We work hand-in-hand with your primary vet to provide specialist-level care.',
                    'Using cutting-edge diagnostic equipment and a thorough case-by-case approach, we develop personalized treatment plans that address the root cause of your pet\'s illness rather than just the symptoms.',
                ],
                'features' => [
                    'Cardiology and respiratory medicine',
                    'Endocrinology (diabetes, thyroid disease)',
                    'Gastroenterology and hepatology',
                    'Neurology consultations',
                    'Oncology (cancer diagnosis and treatment)',
                ],
            ],
            'dental' => [
                'name'       => 'Dental Services',
                'icon'       => '🦷',
                'image'      => 'https://images.unsplash.com/photo-1559839914-17aae19cec71?auto=format&fit=crop&w=1400&q=80',
                'heading'    => 'Professional <span>Pet Dental Care</span>',
                'summary'    => 'Oral health exams, professional cleaning, and dental x-rays for pets.',
                'paragraphs' => [
                    'Dental disease is one of the most common health problems in pets, yet it is largely preventable. Our dental team provides comprehensive oral health assessments, professional cleaning under anesthesia, and digital dental radiographs to catch problems early.',
                    'Healthy teeth mean a healthier, happier pet. We also offer guidance on at-home dental care routines so you can keep your pet\'s smile bright between visits.',
                ],
                'features' => [
                    'Full oral health examination',
                    'Professional scaling and polishing under anesthesia',
                    'Digital dental radiography (x-rays)',
                    'Tooth extractions and oral surgery',
                    'At-home dental care coaching',
                ],
            ],
            'grooming' => [
                'name'       => 'Professional Grooming',
                'icon'       => '✂️',
                'image'      => 'https://images.unsplash.com/photo-1553531889-e6cf4d692b1b?auto=format&fit=crop&w=1400&q=80',
                'heading'    => 'Premium <span>Pet Grooming</span> Services',
                'summary'    => 'Full-service grooming to keep your pet looking and feeling their best.',
                'paragraphs' => [
                    'Our professional grooming studio offers a relaxing and stress-free experience for your pet. From breed-specific haircuts to full spa treatments, our certified groomers are skilled in handling pets of all sizes and temperaments.',
                    'Regular grooming is not just about aesthetics — it plays a vital role in your pet\'s overall health, preventing matting, skin conditions, and ear infections.',
                ],
                'features' => [
                    'Full bath with premium pet-safe shampoos',
                    'Breed-specific haircuts and styling',
                    'Nail trimming and ear cleaning',
                    'De-shedding treatments',
                    'Teeth brushing and cologne finish',
                ],
            ],
            'laboratory' => [
                'name'       => 'Laboratory Services',
                'icon'       => '🧪',
                'image'      => 'https://images.unsplash.com/photo-1576671081837-49000212a370?auto=format&fit=crop&w=1400&q=80',
                'heading'    => 'In-House <span>Diagnostic Laboratory</span>',
                'summary'    => 'Fast, accurate in-house blood, urine, and pathology testing.',
                'paragraphs' => [
                    'Our fully equipped in-house laboratory allows us to run a comprehensive range of diagnostic tests and receive results within minutes — not days. This means faster diagnosis, faster treatment, and better outcomes for your pet.',
                    'From routine wellness blood panels to urgent diagnostics during emergencies, our lab handles it all with precision and speed.',
                ],
                'features' => [
                    'Complete blood count (CBC) and chemistry panels',
                    'Urinalysis and culture testing',
                    'Parasite screening (fecal, heartworm)',
                    'Allergy and hormone testing',
                    'Rapid infectious disease panels',
                ],
            ],
            'emergency' => [
                'name'       => '24-Hour Emergency Service',
                'icon'       => '🚑',
                'image'      => 'https://images.unsplash.com/photo-1551190822-a9333d879b1f?auto=format&fit=crop&w=1400&q=80',
                'heading'    => 'We\'re Here <span>24/7</span> For Your Pet',
                'summary'    => 'Round-the-clock emergency and critical care for life-threatening situations.',
                'paragraphs' => [
                    'Emergencies don\'t follow business hours. Our 24/7 emergency and critical care unit is always staffed with experienced veterinarians and technicians ready to handle any life-threatening situation your pet may face.',
                    'From traumatic injuries to sudden illness, we provide rapid stabilization, intensive monitoring, and expert treatment around the clock.',
                ],
                'features' => [
                    'Dedicated emergency triage and stabilization',
                    'Intensive Care Unit (ICU) for critical patients',
                    'Oxygen therapy and mechanical ventilation',
                    '24/7 specialist availability',
                    'Direct phone line: +94 777 999 000',
                ],
            ],
            'vaccination' => [
                'name'       => 'Vaccination Management',
                'icon'       => '💉',
                'image'      => 'https://images.unsplash.com/photo-1585421514284-efb74c2b69ba?auto=format&fit=crop&w=1400&q=80',
                'heading'    => 'Automated <span>Vaccination Tracking</span>',
                'summary'    => 'Never miss a vaccination with our smart reminder and tracking system.',
                'paragraphs' => [
                    'Our digital vaccination management system keeps a complete, up-to-date record of all your pet\'s immunizations. You\'ll receive automated reminders when booster shots are due, so your pet\'s protection never lapses.',
                    'Whether your pet needs core vaccines or lifestyle-based optional vaccines, our vets will build a personalized vaccination schedule tailored to their age, breed, and risk factors.',
                ],
                'features' => [
                    'Full digital vaccination history records',
                    'Automated SMS/email reminder alerts',
                    'Personalized vaccination schedules',
                    'Core and non-core vaccine administration',
                    'Integration with national pet health registries',
                ],
            ],
            'appointments' => [
                'name'       => 'Online Appointment Booking',
                'icon'       => '📅',
                'image'      => 'https://images.unsplash.com/photo-1600880292203-757bb62b4baf?auto=format&fit=crop&w=1400&q=80',
                'heading'    => 'Book Your Visit <span>Online</span> Instantly',
                'summary'    => 'Easy and convenient online appointment scheduling at any time.',
                'paragraphs' => [
                    'Skip the phone queues. With our online booking system, you can schedule appointments with your preferred vet at any time, from any device. Choose your date, time, and reason for the visit in just a few clicks.',
                    'You\'ll receive instant confirmation and reminders, ensuring you never forget an appointment. Our system also tracks your appointment history so your vet always has full context when you arrive.',
                ],
                'features' => [
                    'Book appointments 24/7 from any device',
                    'Choose your preferred veterinarian',
                    'Instant SMS and email confirmation',
                    'Easy rescheduling and cancellation',
                    'Full appointment history in your dashboard',
                ],
            ],
            'records' => [
                'name'       => 'Digital Pet Health Records',
                'icon'       => '📋',
                'image'      => 'https://images.unsplash.com/photo-1587300003388-59208cc962cb?auto=format&fit=crop&w=1400&q=80',
                'heading'    => 'Secure <span>Digital Health Records</span>',
                'summary'    => 'A complete, always-accessible digital record of your pet\'s health journey.',
                'paragraphs' => [
                    'Every visit, every diagnosis, every prescription — all stored securely in your pet\'s digital health record. Access your pet\'s full medical history at any time from any device through our secure owner portal.',
                    'No more paper records or lost documents. Share records instantly with other vets, specialists, or groomers when needed.',
                ],
                'features' => [
                    'Complete medical history and visit notes',
                    'Prescription and medication tracking',
                    'Lab results and diagnostic reports',
                    'Secure owner portal access',
                    'Easy sharing with third-party providers',
                ],
            ],
            'nutrition' => [
                'name'       => 'Nutritional Counselling',
                'icon'       => '🥗',
                'image'      => 'https://images.unsplash.com/photo-1516734212186-a967f81ad0d7?auto=format&fit=crop&w=1400&q=80',
                'heading'    => 'Expert <span>Pet Nutrition</span> Guidance',
                'summary'    => 'Personalized dietary plans to optimize your pet\'s health and weight.',
                'paragraphs' => [
                    'Nutrition is one of the most powerful tools for maintaining your pet\'s health. Our veterinary nutritionists provide individualized dietary assessments and meal planning based on your pet\'s breed, age, weight, activity level, and health conditions.',
                    'Whether your pet needs a prescription therapeutic diet or simply guidance on the best commercial food choices, we are here to help you make informed decisions.',
                ],
                'features' => [
                    'Body condition and weight assessment',
                    'Personalized meal planning',
                    'Therapeutic diet prescriptions',
                    'Puppy and kitten growth nutrition',
                    'Senior pet dietary management',
                ],
            ],
        ];

        if (!isset($services[$slug])) {
            header('Location: ?url=home/services');
            exit;
        }

        $service = $services[$slug];
        $this->view('service_detail', ['service' => $service]);
    }
}
