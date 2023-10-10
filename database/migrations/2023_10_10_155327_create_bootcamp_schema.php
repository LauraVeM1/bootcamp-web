<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    const CLIENTS =  "clients",
    BUSINESSES = "businesses",
    FAVORITES = "favorites",
    IMAGES = "images";

    const CLIENT_ID = "client_id",
            BUSINESS_ID = "business_id";
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        self::createTables();
        self::createPolyTables();
    }
    public function createTables(){
        self::createClientsTable();
        self::createBusinessTable();
        self::createFavoritesTable();
    }
    public function createPolyTables(){
        self::createImagesTable();
    }
    public function createClientsTable(){
        Schema::create(self::CLIENTS, function (Blueprint $table) {
            $table -> id();
            $table -> string("name");
            $table -> string("email")->unique();
            $table -> string("password");
            $table -> string("active") -> default(true);
            $table -> timestamps();
        });
    }

    public function createBusinessTable(){
        Schema::create(self::BUSINESSES, function (Blueprint $table) {
            $table -> id();
            $table -> string("name");
            $table -> string("email")->unique();
            $table -> string("password");
            $table -> string("phone");
            $table -> string("active") -> default(true);
            $table -> timestamps();
        });
    }
    public function createFavoritesTable(){
        Schema::create(self::FAVORITES, function (Blueprint $table) {
            $table -> id();
            $table -> foreignId(self::CLIENT_ID) ->constrained(self::CLIENTS);
            $table -> foreignId(self::BUSINESS_ID) ->constrained(self::BUSINESSES);
        });
    }

    public function createImagesTable(){
        Schema::create(self::IMAGES, function (Blueprint $table) {
            $table -> id();
            $table -> string("url");
            $table -> morphs("imageable");
            $table -> timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $polytables = [self::IMAGES];
        $tables = [self::FAVORITES, self::BUSINESSES, self::CLIENTS];
        foreach ($polytables as $table) {
            Schema::dropIfExists($table);
        }
        foreach ($tables as $table) {
            Schema::dropIfExists($table);
        }
    }
};
