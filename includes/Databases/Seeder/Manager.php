<?php

namespace Wp\OptionsBot\Databases\Seeder;

/**
 * Database Seeder class.
 *
 * It'll seed all of the seeders.
 */
class Manager {

    /**
     * Run the database seeders.
     *
     * @since 0.3.0
     *
     * @return void
     * @throws \Exception
     */
    public function run() {
        $seeder_classes = [
            \Wp\OptionsBot\Databases\Seeder\OptionsSeeder::class,
            \Wp\OptionsBot\Databases\Seeder\OrderSeeder::class,
        ];

        foreach ( $seeder_classes as $seeder_class ) {
            $seeder = new $seeder_class();
            $seeder->run();
        }
    }
}
