<?php

namespace App\Enums;


abstract class NavigationLocations
{
    const FeaturedMenu = 0;
    const RightMenu = 1;
    const FooterMenu1 = 2;
    const FooterMenu2 = 3;
    const HomePageButtons = 4;
    const HomepageCarousel = 5;
    const HomepagePromoBanners = 6;
    const CategoryPromoBanners = 7; // sort order = category
    const ItemPromoBanners = 8; // sort order = category
    const SocialIcons = 9;
}