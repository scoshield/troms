<?php

namespace Database\Seeders;

use App\Domains\Announcement\Models\Announcement;
use Database\Seeders\Traits\DisableForeignKeys;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Seeder;

/**
 * Class AnnouncementSeeder.
 */
class AnnouncementSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;

    /**
     * Run the database seeds.
     */
    public function run()
    {
        $this->disableForeignKeys();

        $this->truncate('announcements');

        if (app()->environment(['local', 'testing'])) {
            /*
             * Note: There is currently no UI for this feature. If you are going to build a UI, and if you are going to use a WYSIWYG editor for the message (because it supports HTML on the frontend) that you properly sanitize the input before it is stored in the database.
             */
            Announcement::updateOrCreate([
                'area' => null,
                'type' => 'info',
                'message' => '',
                'enabled' => true,
            ]);
        }

        $this->enableForeignKeys();
    }
}
