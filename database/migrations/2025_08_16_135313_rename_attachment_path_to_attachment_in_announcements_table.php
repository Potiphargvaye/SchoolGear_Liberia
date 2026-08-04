<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameAttachmentPathToAttachmentInAnnouncementsTable extends Migration
{
    public function up()
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->renameColumn('attachment_path', 'attachment');
        });
    }

    public function down()
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->renameColumn('attachment', 'attachment_path');
        });
    }
}