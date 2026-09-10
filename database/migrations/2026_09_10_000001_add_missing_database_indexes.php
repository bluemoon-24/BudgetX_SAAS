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
        Schema::table('categories', function (Blueprint $table) {
            $table->index(['user_id', 'type'], 'categories_user_type_index');
            $table->index('type', 'categories_type_index');
        });

        Schema::table('incomes', function (Blueprint $table) {
            $table->index(['user_id', 'date'], 'incomes_user_date_index');
            $table->index('category_id', 'incomes_category_id_index');
        });

        Schema::table('savings_goals', function (Blueprint $table) {
            $table->index('user_id', 'savings_goals_user_id_index');
            $table->index('target_date', 'savings_goals_target_date_index');
        });

        Schema::table('budget_user', function (Blueprint $table) {
            $table->unique(['budget_id', 'user_id'], 'budget_user_budget_user_unique');
            $table->index('budget_id', 'budget_user_budget_id_index');
            $table->index('user_id', 'budget_user_user_id_index');
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->index('user_id', 'subscriptions_user_id_index');
            $table->index('stripe_status', 'subscriptions_status_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex('categories_user_type_index');
            $table->dropIndex('categories_type_index');
        });

        Schema::table('incomes', function (Blueprint $table) {
            $table->dropIndex('incomes_user_date_index');
            $table->dropIndex('incomes_category_id_index');
        });

        Schema::table('savings_goals', function (Blueprint $table) {
            $table->dropIndex('savings_goals_user_id_index');
            $table->dropIndex('savings_goals_target_date_index');
        });

        Schema::table('budget_user', function (Blueprint $table) {
            $table->dropUnique('budget_user_budget_user_unique');
            $table->dropIndex('budget_user_budget_id_index');
            $table->dropIndex('budget_user_user_id_index');
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropIndex('subscriptions_user_id_index');
            $table->dropIndex('subscriptions_status_index');
        });
    }
};
