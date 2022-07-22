<?php
/*
 * @Name: 
 * @Author: Trs
 * @Date: 2022-07-04 15:34:00
 * @LastEditTime: 2022-07-13 14:20:03
 * @Description:
 */

namespace Tests;

use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';
        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
