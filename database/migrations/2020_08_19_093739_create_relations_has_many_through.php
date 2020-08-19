<?php

use App\Country;
use App\Customer;
use App\Post;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelationsHasManyThrough extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->integer('country_id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('title');
            $table->timestamps();
        });

        $countriesNames = ['Russia', 'Spain', 'Mexico'];
        foreach ($countriesNames as $countriesName) {
            $country = Country::create(['name' => $countriesName]);

            $customersNames = ['Ivan', 'Juan', 'Julio'];
            foreach ($customersNames as $customersName) {
                $customer = Customer::create([
                    'country_id' => $country->id,
                    'name' => $customersName
                ]);

                $titles = ['title_1', 'title_2', 'title_3'];
                foreach ($titles as $title) {
                    Post::create([
                        'user_id' => $customer->id,
                        'title' => $title
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('countries');
    }
}
