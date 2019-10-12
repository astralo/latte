<?php

use App\Models\Eve\ContactType;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCharacterTables extends Migration
{
    protected $contactTypes;

    public function __construct()
    {
        $this->contactTypes = [
            'character',
            'corporation',
            'alliance',
            'faction'
        ];
    }

    public function up()
    {
        \Schema::disableForeignKeyConstraints();

        \DB::transaction(function () {

            \Schema::create('eve_alliances', function (Blueprint $table) {
                $table->integer('id')->unsigned();
                $table->primary('id');
                $table->string('name');
                $table->string('ticker');
                $table->integer('creator_corporation_id')->unsigned()->nullable();
                $table->integer('creator_id')->unsigned()->nullable();
                $table->integer('executor_corporation_id')->unsigned()->nullable();
                $table->timestamps();
            });

            \Schema::create('eve_corporations', function (Blueprint $table) {

                $table->integer('id')->unsigned();
                $table->primary('id');
                $table->string('name');
                $table->string('ticker');
                $table->integer('alliance_id')->unsigned()->nullable();
                $table->integer('ceo_id')->unsigned()->nullable();
                $table->integer('creator_id')->unsigned()->nullable();
                $table->timestamps();
            });

            \Schema::create('eve_characters', function (Blueprint $table) {
                $table->integer('id')->unsigned();
                $table->primary('id');
                $table->string('name');
                $table->integer('corporation_id')->unsigned()->nullable();
                $table->integer('alliance_id')->unsigned()->nullable();
                $table->timestamp('birthday');
                $table->integer('ancestry_id')->unsigned()->nullable();
                $table->double('security_status')->nullable();
                $table->timestamps();
            });

            \Schema::table('eve_alliances', function (Blueprint $table) {

                $table->foreign('creator_corporation_id')
                    ->references('id')
                    ->on('eve_corporations')
                    ->onDelete('no action');
                $table->foreign('creator_id')
                    ->references('id')
                    ->on('eve_characters')
                    ->onDelete('no action');
                $table->foreign('executor_corporation_id')
                    ->references('id')
                    ->on('eve_corporations')
                    ->onDelete('no action');
            });

            \Schema::table('eve_corporations', function (Blueprint $table) {
                $table->foreign('alliance_id')
                    ->references('id')
                    ->on('eve_alliances')
                    ->onDelete('no action');
                $table->foreign('ceo_id')
                    ->references('id')
                    ->on('eve_characters')
                    ->onDelete('no action');
                $table->foreign('creator_id')
                    ->references('id')
                    ->on('eve_characters')
                    ->onDelete('no action');
            });

            \Schema::table('eve_characters', function (Blueprint $table) {
                $table->foreign('corporation_id')
                    ->references('id')
                    ->on('eve_corporations')
                    ->onDelete('no action');
                $table->foreign('alliance_id')
                    ->references('id')
                    ->on('eve_alliances')
                    ->onDelete('no action');
            });

            \Schema::create('eve_character_corp_history', function (Blueprint $table) {

                $table->integer('id')->unsigned();
                $table->primary('id');

                $table->integer('corporation_id')->unsigned();
                $table->foreign('corporation_id')
                    ->references('id')
                    ->on('eve_corporations')
                    ->onDelete('no action');

                $table->timestamp('start_date');
                $table->timestamps();
            });

            \Schema::create('eve_character_contacts', function (Blueprint $table) {

                $table->integer('id')->unsigned();
                $table->primary('id');

                $table->integer('contact_id')->unsigned();
                $table->string('contact_type');
                $table->boolean('is_blocked')->nullable();
                $table->boolean('is_watched')->nullable();
                $table->double('standing');
                $table->timestamps();
            });

            \Schema::create('eve_corporation_alli_history', function (Blueprint $table) {

                $table->integer('id')->unsigned();
                $table->primary('id');

                $table->integer('alliance_id')->unsigned()->nullable();
                $table->foreign('alliance_id')
                    ->references('id')
                    ->on('eve_alliances')
                    ->onDelete('no action');

                $table->boolean('is_deleted')->nullable();
                $table->timestamp('start_date');
                $table->timestamps();
            });

            \Schema::create('contact_types', function (Blueprint $table) {

                $table->increments('id');
                $table->string('name');
            });

            foreach ($this->contactTypes as $contactType) {

                ContactType::create([
                    'name' => $contactType
                ]);
            }

        });

        \Schema::enableForeignKeyConstraints();
    }

    public function down()
    {
        \Schema::table('eve_characters', function (Blueprint $table) {
            $table->dropForeign('eve_characters_alliance_id_foreign');
            $table->dropForeign('eve_characters_corporation_id_foreign');
        });
        \Schema::table('eve_character_corp_history', function (Blueprint $table) {
            $table->dropForeign('eve_character_corp_history_corporation_id_foreign');
        });
        \Schema::table('eve_corporations', function (Blueprint $table) {
            $table->dropForeign('eve_corporations_alliance_id_foreign');
            $table->dropForeign('eve_corporations_ceo_id_foreign');
            $table->dropForeign('eve_corporations_creator_id_foreign');
        });
        \Schema::table('eve_corporation_alli_history', function (Blueprint $table) {
            $table->dropForeign('eve_corporation_alli_history_alliance_id_foreign');
        });
        \Schema::table('eve_alliances', function (Blueprint $table) {
            $table->dropForeign('eve_alliances_creator_corporation_id_foreign');
            $table->dropForeign('eve_alliances_creator_id_foreign');
            $table->dropForeign('eve_alliances_executor_corporation_id_foreign');
        });

        \Schema::dropIfExists('eve_characters');
        \Schema::dropIfExists('eve_character_corp_history');
        \Schema::dropIfExists('eve_character_contacts');
        \Schema::dropIfExists('eve_corporations');
        \Schema::dropIfExists('eve_corporation_alli_history');
        \Schema::dropIfExists('eve_alliances');
        \Schema::dropIfExists('contact_types');
    }
}
