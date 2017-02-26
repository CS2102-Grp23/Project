<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::insert(INSERT INTO users VALUES('mother', 'mother', 'FALSE', 'mother@mother', 'mother'));
        DB::insert(INSERT INTO users VALUES('mother2', 'mother2', 'FALSE', 'mother20@mother', 'mother2'));
        DB::insert(INSERT INTO users VALUES('mother3', 'mother3', 'FALSE', 'mother2@mother', 'mother3'));
        DB::insert(INSERT INTO users VALUES('mother4', 'mother4', 'FALSE', 'mother3@mother', 'mother4'));
        DB::insert(INSERT INTO users VALUES('mother5', 'mother5', 'FALSE', 'mother4@mother', 'mother5'));
        DB::insert(INSERT INTO users VALUES('mother6', 'mother6', 'FALSE', 'mother5@mother', 'mother6'));
        DB::insert(INSERT INTO users VALUES('mother7', 'mother7', 'FALSE', 'mother6@mother', 'mother7'));
        DB::insert(INSERT INTO users VALUES('mother8', 'mother8', 'FALSE', 'mother7@mother', 'mother8'));
        DB::insert(INSERT INTO users VALUES('mother9', 'mother9', 'FALSE', 'mother8@mother', 'mother9'));
        DB::insert(INSERT INTO users VALUES('mother10', 'mother10', 'FALSE', 'mother9@mother', 'mother10'));
        DB::insert(INSERT INTO users VALUES('mother11', 'mother11', 'FALSE', 'mother10@mother', 'mother11'));
        DB::insert(INSERT INTO users VALUES('mother12', 'mother12', 'FALSE', 'mother11@mother', 'mother12'));
        DB::insert(INSERT INTO users VALUES('mother13', 'mother13', 'FALSE', 'mother12@mother', 'mother13'));
        DB::insert(INSERT INTO users VALUES('mother14', 'mother14', 'FALSE', 'mother13@mother', 'mother14'));
        DB::insert(INSERT INTO users VALUES('mother15', 'mother15', 'FALSE', 'mother14@mother', 'mother15'));
        DB::insert(INSERT INTO users VALUES('mother16', 'mother16', 'FALSE', 'mother15@mother', 'mother16'));
        DB::insert(INSERT INTO users VALUES('mother17', 'mother17', 'FALSE', 'mother16@mother', 'mother17'));
        DB::insert(INSERT INTO users VALUES('mother18', 'mother18', 'FALSE', 'mother17@mother', 'mother18'));
        DB::insert(INSERT INTO users VALUES('mother19', 'mother19', 'FALSE', 'mother18@mother', 'mother19'));
        DB::insert(INSERT INTO users VALUES('mother20', 'mother20', 'FALSE', 'mother19@mother', 'mother20'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
