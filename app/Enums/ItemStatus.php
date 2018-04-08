<?php

namespace App\Enums;

abstract class ItemStatus
{
    const NewItem = 0;
    const InWorkshop = 1;
    const RHCToGo = 2;
    const LiveOnRHC = 3;
    const IsSold = 4;
    const IsScrapped = 5;
}