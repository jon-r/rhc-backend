<?php

namespace App\Http\Controllers\Options;

use App\Enums\NavigationLocations;
use App\Models\SiteNavigation;
use App\Models\SiteOptions;

class SiteSettingsController
{
    private $navigationRowsCore = [
        'id',
        'name',
        'url',
        'location_id',
        'sort_order'
    ];

    public function homePageView()
    {
        $links = SiteNavigation::select('image_id', 'text_content', ...$this->navigationRowsCore)
            ->whereIn('location_id', [
                NavigationLocations::HomepageCarousel,
                NavigationLocations::HomePageButtons,
                NavigationLocations::HomepagePromoBanners
            ])
            ->orderBy('sort_order', 'asc')
            ->get();

        $settings = SiteOptions::select('id', 'name', 'value')
            ->whereIn('name', [
                'Home Page Text',
                'Home Page SEO Title',
                'Home Page SEO Text'
            ])
            ->get();

        return successResponse([
            'links' => $links,
            'settings' => $settings
        ]);
    }

    public function homePageEdit()
    {
        return successResponse([
            'endpoint' => 'homePageEdit'
        ]);
    }

    public function contactsView()
    {
        $links = SiteNavigation::select('image_id', ...$this->navigationRowsCore)
            ->where('location_id', '=', NavigationLocations::SocialIcons)
            ->get();

        $settings = SiteOptions::select('id', 'name', 'value')
            ->whereIn('name', [
                'Phone Number',
                'Email',
                'Address',
                'Opening Times',
                'Map',
                'Contact Page SEO Title',
                'Contact Page SEO Text'
            ])
            ->get();

        return successResponse([
            'links' => $links,
            'settings' => $settings
        ]);
    }

    public function contactsEdit()
    {
        return successResponse([
            'endpoint' => 'contactsEdit'
        ]);
    }

    public function siteLayoutView()
    {
        $links = SiteNavigation::select(...$this->navigationRowsCore)
            ->whereIn('location_id', [
                NavigationLocations::FeaturedMenu,
                NavigationLocations::RightMenu,
                NavigationLocations::FooterMenu1,
                NavigationLocations::FooterMenu2
            ])
            ->orderBy('sort_order', 'asc')
            ->get();

        $settings = SiteOptions::select('id', 'name', 'value')
            ->whereIn('name', [
                'Header Banner',
                'Site Logo',
                'Site Background',
                'Footer Image 1',
                'Footer Image 2',
            ]);

        return successResponse([
            'links' => $links,
            'settings' => $settings
        ]);
    }

    public function siteLayoutEdit()
    {
        return successResponse([
            'endpoint' => 'siteLayoutEdit'
        ]);
    }
}