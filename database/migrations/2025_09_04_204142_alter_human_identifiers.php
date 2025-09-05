<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ledger_accounts', function (Blueprint $table) {
            $table->text('fullname')->storedAs("code || ' - ' || name")->after('code');
        });

        Schema::table('people', function (Blueprint $table) {
            $table->renameColumn('first_name', 'firstname');
            $table->renameColumn('last_name', 'lastname');
            $table->text('firstname_lastname')->storedAs("firstname || ' ' || upper(lastname)")->after('lastname');
            $table->text('lastname_firstname')->storedAs("upper(lastname) || ' ' || firstname")->after('firstname_lastname');
        });

        Schema::table('licences', function (Blueprint $table) {
            $table->renameColumn('first_name', 'firstname');
            $table->renameColumn('last_name', 'lastname');
            $table->text('firstname_lastname')->storedAs("firstname || ' ' || upper(lastname)")->after('lastname');
            $table->text('lastname_firstname')->storedAs("upper(lastname) || ' ' || firstname")->after('firstname_lastname');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ledger_accounts', function (Blueprint $table) {
            $table->dropColumn('fullname');
        });

        Schema::table('people', function (Blueprint $table) {
            $table->dropColumn('firstname_lastname');
            $table->dropColumn('lastname_firstname');
            $table->renameColumn('firstname', 'first_name');
            $table->renameColumn('lastname', 'last_name');
        });

        Schema::table('licences', function (Blueprint $table) {
            $table->dropColumn('firstname_lastname');
            $table->dropColumn('lastname_firstname');
            $table->renameColumn('firstname', 'first_name');
            $table->renameColumn('lastname', 'last_name');
        });
    }
};
