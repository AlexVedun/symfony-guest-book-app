<?php

namespace App\Service;

use DeviceDetector\DeviceDetector;
use Symfony\Component\HttpFoundation\Request;

class BrowserService
{
    public function getBrowserInfo(Request $request): string
    {
        $userAgent = $request->headers->get('User-Agent');
        $deviceDetector = new DeviceDetector($userAgent);
        $deviceDetector->parse();

        return "{$deviceDetector->getClient('name')} {$deviceDetector->getClient('version')}";
    }
}
