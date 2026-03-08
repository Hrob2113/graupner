<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Statamic\Facades\Collection;
use Statamic\Facades\Entry;
use Statamic\Facades\GlobalSet;

class StatamicContentSeeder extends Seeder
{
    /**
     * Seed all Statamic CMS content to match the original welcome.blade.php.
     */
    public function run(): void
    {
        $this->seedGlobals();
        $this->seedHomePage();
        $this->seedServices();
        $this->seedGallery();
        $this->seedReviews();
    }

    private function seedGlobals(): void
    {
        $set = GlobalSet::findByHandle('site');

        if (! $set) {
            $set = GlobalSet::make('site')->title('Site');
            $set->save();
        }

        $localized = $set->makeLocalization('default');
        $localized->data([
            'site_name' => 'Roman Graupner',
            'site_role' => 'Nezávislý instalatér',
            'phone' => '+420 123 456 789',
            'email' => 'roman@graupner-plumbing.cz',
            'location' => 'Louny a okolí',
            'working_hours' => 'Po–So 7:00–19:00',
            'emergency_hours' => 'Havárie 24/7',
            'facebook_url' => '#',
            'instagram_url' => '#',
            'whatsapp_url' => '#',
            'copyright_text' => '© 2026 Roman Graupner · Nezávislý instalatér · Louny',
        ]);
        $localized->save();

        $this->command->info('Seeded site globals.');
    }

    private function seedHomePage(): void
    {
        $existing = Entry::query()
            ->where('collection', 'pages')
            ->where('slug', 'home')
            ->first();

        if ($existing) {
            $existing->data(array_merge($existing->data()->all(), $this->homePageData()));
            $existing->save();
        } else {
            $entry = Entry::make()
                ->collection('pages')
                ->slug('home')
                ->blueprint('page')
                ->data(array_merge(['title' => 'Home'], $this->homePageData()));
            $entry->save();
        }

        $this->command->info('Seeded home page.');
    }

    /**
     * @return array<string, string>
     */
    private function homePageData(): array
    {
        return [
            'template' => 'home',
            'layout' => 'welcome',
            'hero_heading' => 'Váš instalatér<br>v <span class="accent-text">Lounech</span>.',
            'hero_subheading' => 'Poctivá práce, férové ceny — výsledky, na které se můžete spolehnout.',
            'hero_primary_button_text' => 'Kontaktuj mě',
            'hero_secondary_button_text' => 'Co dělám',
            'hero_badge_text' => 'Certifikovaný',
            'hero_stat_1_value' => '15+',
            'hero_stat_1_label' => 'Let',
            'hero_stat_2_value' => '2k+',
            'hero_stat_2_label' => 'Zakázek',
            'hero_stat_3_value' => '24/7',
            'hero_stat_3_label' => 'K dispozici',
            'services_title' => 'S čím vám mohu pomoci',
            'services_description' => 'Vše od rychlých oprav po kompletní instalace — provedeno osobně mnou, s péčí.',
            'gallery_title' => 'Nedávné projekty',
            'gallery_description' => 'Pohled na některé zakázky, které jsem dokončil pro klienty v Lounech a okolí.',
            'reviews_title' => 'Co o mně říkají lidé',
            'reviews_description' => 'Skutečná zpětná vazba od skutečných klientů z Lounska.',
            'contact_title' => 'Pojďme to vyřešit.',
            'contact_description' => 'Potřebujete pomoct? Napište mi zprávu nebo zavolejte přímo — odpovídám rychle.',
            'contact_subtitle' => 'Nezávislý instalatér pro Louny a okolí. K dispozici pro plánované práce i havarijní situace.',
        ];
    }

    private function seedServices(): void
    {
        if (! Collection::findByHandle('services')) {
            Collection::make('services')
                ->title('Services')
                ->template('services/show')
                ->layout('welcome')
                ->routes('/services/{slug}')
                ->sortField('order')
                ->sortDirection('asc')
                ->save();
        }

        $services = [
            [
                'slug' => 'pipe-repairs',
                'title' => 'Opravy a výměny potrubí',
                'description' => 'Rychlá diagnostika a trvalá řešení pro úniky, prasklé potrubí a zkorodované rozvody. Od drobných záplat po kompletní výměny.',
                'icon' => 'fas fa-wrench',
                'tags' => ['Detekce úniků', 'Prasklé potrubí', 'Nové rozvody'],
                'card_class' => 'srv-wide',
                'is_emergency' => false,
            ],
            [
                'slug' => 'bathroom-installations',
                'title' => 'Instalace koupelen',
                'description' => 'Kompletní montáž koupelen — sprchy, vany, toalety, umyvadla a koordinace obkladů.',
                'icon' => 'fas fa-shower',
                'tags' => ['Kompletní rekonstrukce', 'Sanita'],
                'card_class' => 'srv-narrow',
                'is_emergency' => false,
            ],
            [
                'slug' => 'emergency',
                'title' => 'Havarijní služba',
                'description' => 'Prasklé potrubí, zatopený sklep, nefunkční kotel uprostřed zimy? Jsem k dispozici kdykoliv — rychlý výjezd, non-stop.',
                'icon' => 'fas fa-bolt',
                'tags' => ['Nonstop výjezd', 'Prasklé potrubí', 'Havárie topení'],
                'card_class' => 'srv-emergency',
                'is_emergency' => true,
            ],
            [
                'slug' => 'heating-services',
                'title' => 'Topenářské práce',
                'description' => 'Instalace kotlů, montáž radiátorů, realizace podlahového topení a opravy.',
                'icon' => 'fas fa-temperature-arrow-up',
                'tags' => ['Výměna kotlů', 'Radiátory', 'Podlahové topení'],
                'card_class' => 'srv-medium',
                'is_emergency' => false,
            ],
        ];

        foreach ($services as $i => $service) {
            $slug = $service['slug'];
            unset($service['slug']);

            $existing = Entry::query()
                ->where('collection', 'services')
                ->where('slug', $slug)
                ->first();

            if (! $existing) {
                Entry::make()
                    ->collection('services')
                    ->slug($slug)
                    ->blueprint('service')
                    ->data($service)
                    ->save();
            }
        }

        $this->command->info('Seeded services.');
    }

    private function seedGallery(): void
    {
        if (! Collection::findByHandle('gallery')) {
            Collection::make('gallery')
                ->title('Gallery')
                ->template('gallery/show')
                ->layout('welcome')
                ->routes('/gallery/{slug}')
                ->sortField('order')
                ->sortDirection('asc')
                ->save();
        }

        $items = [
            [
                'slug' => 'bathroom-reconstruction',
                'title' => 'Kompletní rekonstrukce koupelny',
                'description' => 'Celková přestavba — obklady, nová sanita, instalace sprchového koutu. Louny-Jih.',
                'tag' => 'Koupelna',
                'icon' => 'fas fa-shower',
                'gradient_from' => '#1a3a5c',
                'gradient_to' => '#0d2137',
                'is_tall' => true,
            ],
            [
                'slug' => 'pipe-repair',
                'title' => 'Havarijní oprava potrubí',
                'description' => 'Prasklé potrubí ve sklepě — opraveno a vyměněno ještě téže noci.',
                'tag' => 'Oprava',
                'icon' => 'fas fa-wrench',
                'gradient_from' => '#1e3d5e',
                'gradient_to' => '#122a44',
                'is_tall' => false,
            ],
            [
                'slug' => 'boiler-replacement',
                'title' => 'Výměna kotle',
                'description' => 'Starý kotel vyměněn za energeticky úsporný kondenzační kotel.',
                'tag' => 'Topení',
                'icon' => 'fas fa-fire',
                'gradient_from' => '#162f4d',
                'gradient_to' => '#0e2035',
                'is_tall' => false,
            ],
            [
                'slug' => 'kitchen-sink',
                'title' => 'Kuchyňský dřez a myčka',
                'description' => 'Kompletní nové rozvody pod dřezem se zapojením myčky. Havířov.',
                'tag' => 'Kuchyně',
                'icon' => 'fas fa-kitchen-set',
                'gradient_from' => '#1b3754',
                'gradient_to' => '#0f2540',
                'is_tall' => false,
            ],
            [
                'slug' => 'drain-cleaning',
                'title' => 'Čištění kanalizace',
                'description' => 'Profesionální tlakové čištění ucpané hlavní kanalizační přípojky. Louny-Poruba.',
                'tag' => 'Odpady',
                'icon' => 'fas fa-faucet-drip',
                'gradient_from' => '#17334f',
                'gradient_to' => '#0b1e33',
                'is_tall' => false,
            ],
        ];

        foreach ($items as $item) {
            $slug = $item['slug'];
            unset($item['slug']);

            $existing = Entry::query()
                ->where('collection', 'gallery')
                ->where('slug', $slug)
                ->first();

            if (! $existing) {
                Entry::make()
                    ->collection('gallery')
                    ->slug($slug)
                    ->blueprint('gallery_item')
                    ->data($item)
                    ->save();
            }
        }

        $this->command->info('Seeded gallery.');
    }

    private function seedReviews(): void
    {
        if (! Collection::findByHandle('reviews')) {
            Collection::make('reviews')
                ->title('Reviews')
                ->template('reviews/show')
                ->layout('welcome')
                ->routes('/reviews/{slug}')
                ->sortField('order')
                ->sortDirection('asc')
                ->save();
        }

        $reviews = [
            [
                'slug' => 'martin-k',
                'author' => 'Martin K.',
                'location' => 'Louny-Poruba',
                'rating' => 5,
                'content' => 'Volal jsem Romanovi ve 22:00 s prasklým potrubím — byl u mě do 40 minut. Super profesionální, rychlý a s férovou cenou. Nemůžu ho dostatečně doporučit!',
            ],
            [
                'slug' => 'petra-s',
                'author' => 'Petra S.',
                'location' => 'Louny-Jih',
                'rating' => 5,
                'content' => 'Roman nám rekonstruoval celou koupelnu. Práce byla bezchybná a dokončená před termínem. Čistotný, slušný a neuvěřitelně orientovaný na detail. Pravý řemeslník.',
            ],
            [
                'slug' => 'tomas-r',
                'author' => 'Tomáš R.',
                'location' => 'Havířov',
                'rating' => 5,
                'content' => 'Konečně instalatér, který přijde včas a udělá, co slíbí. Volám Romanovi už 3 roky — jinam bych nešel.',
            ],
        ];

        foreach ($reviews as $review) {
            $slug = $review['slug'];
            $content = $review['content'];
            unset($review['slug'], $review['content']);

            $existing = Entry::query()
                ->where('collection', 'reviews')
                ->where('slug', $slug)
                ->first();

            if (! $existing) {
                $entry = Entry::make()
                    ->collection('reviews')
                    ->slug($slug)
                    ->blueprint('review')
                    ->data($review);

                $entry->save();

                // Set markdown content (review text)
                $path = $entry->path();
                $fileContent = file_get_contents($path);
                $fileContent .= $content;
                file_put_contents($path, $fileContent);
            }
        }

        $this->command->info('Seeded reviews.');
    }
}
