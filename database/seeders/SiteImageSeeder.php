<?php

namespace Database\Seeders;

use App\Models\AboutProfile;
use App\Models\GalleryItem;
use App\Models\Prefect;
use App\Models\Setting;
use App\Models\StaffMember;
use App\Support\SiteImageImporter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class SiteImageSeeder extends Seeder
{
    public function run(): void
    {
        if (! File::isDirectory(SiteImageImporter::imagesDirectory())) {
            return;
        }

        $this->seedSettings();
        $this->seedStaffPhotos();
        $this->seedAboutProfiles();
        $this->seedGallery();
        $this->seedPrefectPhotos();
    }

    private function seedSettings(): void
    {
        $settings = [
            'hero_image' => 'SchoolImage2.jpeg',
            'page_banner' => 'Building for another hero.jpeg',
            'head_teacher_photo' => 'HeadTeacherMessage.jpeg',
            'about_image' => 'SchoolImage1.jpeg',
        ];

        foreach ($settings as $key => $source) {
            $path = SiteImageImporter::import($source, 'settings', $key);

            if ($path) {
                Setting::set($key, $path);
            }
        }

        $this->seedBadgeLogo();
    }

    private function seedBadgeLogo(): void
    {
        $badgeCandidates = [
            public_path('favicon.jpeg'),
            storage_path('app/public/settings/school-badge.jpeg'),
            base_path('app/images/WhatsApp_Image_2026-06-12_at_11.59.01-removebg-preview.png'),
        ];

        $badgeSource = null;
        foreach ($badgeCandidates as $candidate) {
            if (File::exists($candidate) && File::size($candidate) > 0) {
                $badgeSource = $candidate;
                break;
            }
        }

        if (! $badgeSource) {
            return;
        }

        $badgeDir = storage_path('app/public/settings');
        File::ensureDirectoryExists($badgeDir);
        File::copy($badgeSource, $badgeDir.'/school-badge.jpeg');
        File::ensureDirectoryExists(public_path('storage/settings'));
        File::copy($badgeSource, public_path('storage/settings/school-badge.jpeg'));
        File::copy($badgeSource, public_path('favicon.jpeg'));
        Setting::set('logo', 'settings/school-badge.jpeg');
    }

    private function seedStaffPhotos(): void
    {
        $staffPhotos = [
            'Rev. Fr. Charles Muhigirwa' => 'HeadTeacher1.jpeg',
            'Ms. Namata Cissy' => 'DeputyHead1.jpeg',
            'Mr. Ibrahim Baweireyo' => 'Dos.jpeg',
            'Mr. Serubidde Joseph' => 'Dos2.jpeg',
        ];

        foreach ($staffPhotos as $name => $source) {
            $path = SiteImageImporter::import($source, 'staff', $name);

            if (! $path) {
                continue;
            }

            StaffMember::query()
                ->where('name', $name)
                ->where('category', 'administration')
                ->update(['image' => $path]);
        }
    }

    private function seedAboutProfiles(): void
    {
        $path = SiteImageImporter::import('HeadTeacher1.jpeg', 'about-profiles', 'current-head-teacher');

        if (! $path) {
            return;
        }

        AboutProfile::query()
            ->where('name', 'Rev. Fr. Charles Muhigirwa')
            ->where('category', 'head-teachers')
            ->update(['image' => $path]);
    }

    private function seedGallery(): void
    {
        $galleryItems = [
            ['title' => 'School Campus', 'source' => 'Main building for welcome hero.jpeg', 'sort_order' => 1],
            ['title' => 'School Life', 'source' => 'SChool Image2.jpeg', 'sort_order' => 2],
            ['title' => 'School Library', 'source' => 'Library2.jpeg', 'sort_order' => 3],
            ['title' => 'Science Laboratory', 'source' => 'Lab1.jpeg', 'sort_order' => 4],
        ];

        $namedGalleryFiles = File::files(SiteImageImporter::imagesDirectory());
        foreach ($namedGalleryFiles as $file) {
            if (! preg_match('/^gallery(\d+)\.(jpe?g|png|webp)$/i', $file->getFilename(), $matches)) {
                continue;
            }

            $number = (int) $matches[1];
            $galleryItems[] = [
                'title' => 'Gallery '.$number,
                'source' => $file->getFilename(),
                'sort_order' => 10 + $number,
            ];
        }

        usort($galleryItems, fn (array $a, array $b) => $a['sort_order'] <=> $b['sort_order']);

        foreach ($galleryItems as $item) {
            $path = SiteImageImporter::import($item['source'], 'gallery', $item['title']);

            if (! $path) {
                continue;
            }

            GalleryItem::updateOrCreate(
                ['title' => $item['title']],
                [
                    'image' => $path,
                    'sort_order' => $item['sort_order'],
                    'is_published' => true,
                ]
            );
        }
    }

    private function seedPrefectPhotos(): void
    {
        $prefectPhotos = [
            ['name' => 'Mark Ssebunya', 'is_current' => true, 'source' => 'Prefectsphoto1.jpeg'],
            ['name' => 'Faith Nalwanga', 'is_current' => true, 'source' => 'Prefectsphoto2.jpeg'],
            ['name' => 'Brian Mugisha', 'is_current' => true, 'source' => 'Prefectsphoto3.jpeg'],
            ['name' => 'Grace Nakato', 'is_current' => false, 'source' => 'Prefectsphoto4.jpeg'],
            ['name' => 'Daniel Okello', 'is_current' => false, 'source' => 'Prefectsphoto5.jpeg'],
        ];

        foreach ($prefectPhotos as $item) {
            $path = SiteImageImporter::import($item['source'], 'prefects', $item['name']);

            if (! $path) {
                continue;
            }

            Prefect::query()
                ->where('name', $item['name'])
                ->where('is_current', $item['is_current'])
                ->update(['image' => $path]);
        }
    }
}
