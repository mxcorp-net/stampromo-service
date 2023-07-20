<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        DB::unprepared("drop procedure Store_GetProducts;
create procedure Store_GetProducts(IN color int)
BEGIN
    select p.id    as id,
           p.name  as name,
           p.description  as description,
           pv.id   as provider_id,
           pv.name as provider,
           f.id as family_id,
           f.name as family,
           p.status as status
    from products p
             join families f on f.id = p.family_id
             join providers pv on pv.id = p.provider_id
             join product_children pc on p.id = pc.product_id
             join colors c on c.id = pc.color_id
    where if(color = 0, true, c.id = color)
      and p.status = 1;
END;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        DB::unprepared("drop procedure Store_GetProducts;");
    }
};
