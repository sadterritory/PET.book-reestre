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
        Schema::create('book_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('action', 10);
            $table->jsonb('old_data')->nullable();
            $table->jsonb('new_data')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        DB::unprepared('CREATE OR REPLACE FUNCTION log_book_changes()
            RETURNS TRIGGER AS $$
            BEGIN
                IF (TG_OP = \'DELETE\') THEN
                    INSERT INTO book_audit_logs (action, old_data, created_at)
                    VALUES (\'DELETE\', to_jsonb(OLD), NOW());
                    RETURN OLD;
                ELSIF (TG_OP = \'UPDATE\') THEN
                    INSERT INTO book_audit_logs (action, old_data, new_data, created_at)
                    VALUES (\'UPDATE\', to_jsonb(OLD), to_jsonb(NEW), NOW());
                    RETURN NEW;
                ELSIF (TG_OP = \'INSERT\') THEN
                    INSERT INTO book_audit_logs (action, new_data, created_at)
                    VALUES (\'INSERT\', to_jsonb(NEW), NOW());
                    RETURN NEW;
                END IF;
                RETURN NULL;
            END;
            $$ LANGUAGE plpgsql;
        ');

        DB::unprepared('
            CREATE TRIGGER books_audit_trigger
            AFTER INSERT OR UPDATE OR DELETE ON books
            FOR EACH ROW EXECUTE FUNCTION log_book_changes();
        ');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS books_audit_trigger ON books;');
        DB::unprepared('DROP FUNCTION IF EXISTS log_book_changes();');
        Schema::dropIfExists('book_audit_logs');
    }
};
