<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('logradouro', 50);
            $table->string('numero', 10);
            $table->string('complemento', 20)->nullable();
            $table->string('bairro', 30);
            $table->string('city', 50);
            $table->char('state', 2);
            $table->string('cep', 10);
            $table->string('country', 50);
            $table->string('phone', 20);
            $table->dateTime('birth_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('cpf', 11)->unique();
            $table->decimal('balance', 6, 2)->default(0);
            $table->string('img_path', 255)->nullable();
        });

        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('email', 255)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255);
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
            $table->string('logradouro', 50);
            $table->string('numero', 10);
            $table->string('complemento', 20)->nullable();
            $table->string('bairro', 30);
            $table->string('city', 50);
            $table->char('state', 2);
            $table->string('cep', 10);
            $table->string('country', 50);
            $table->string('phone', 20);
            $table->dateTime('birth_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('cpf', 11)->unique();
            $table->string('img_path', 255);
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->decimal('unit_price', 10, 2);
            $table->integer('quantity');
            $table->text('description');
            $table->string('category', 45);
            $table->string('img_path', 255);
            $table->timestamps();
            $table->foreignId('users_id')->constrained('users')->onDelete('cascade'); // Preciso entender melhor o método constrained
        });


        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->decimal('total_value', 8, 2);
            $table->enum('status', ['pending', 'completed'])->defaul('pending');
            $table->timestamps();
        });

        Schema::create('transactions_items', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->decimal('total_value', 8, 2);
            $table->foreignId('products_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('transactions_id')->constrained('transactions')->onDelete('cascade');
        });

        Schema::create('relation_transaction_users', function (Blueprint $table) {
            $table->id(); // Cria a coluna 'id' como chave primária auto-incrementável
            $table->foreignId('transactions_id')->constrained('transactions')->onDelete('cascade');
            $table->foreignId('users_id')->constrained('users')->onDelete('cascade');
            $table->string('role', 45);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['logradouro', 'numero', 'complemento', 'bairro', 'city', 'state', 'cep', 'country', 'phone', 'birth_date', 'cpf', 'balance', 'img_path']);
        });

        Schema::dropIfExists('relation_transaction_users');
        Schema::dropIfExists('transactions_items');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('products');
        Schema::dropIfExists('admins');
    }
};
