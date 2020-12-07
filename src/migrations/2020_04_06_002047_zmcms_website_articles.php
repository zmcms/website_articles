<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ZmcmsWebsiteArticles extends Migration{
	public function up(){
		$tblNamePrefix=(Config('database.prefix')??'');

		$tblName=$tblNamePrefix.'website_articles';
		Schema::create($tblName, function($table){$table->string('token', 70);});
		Schema::table($tblName, function($table){$table->integer('sort', false, true)->nullable();});	//	Sortowanie kolejności wyświetlania nawigacji
		Schema::table($tblName, function($table){$table->string('access', 70)->default('*');}); // Info, które grupy użytkowników mają dostęp do danej pozycji nawigacji. "*" -> wszyscy mają dostęp, "{'a', 'b', 'd'}" ->grupy a, b oraz d mają dostęp do artykułu
		Schema::table($tblName, function($table){$table->string('frontend_access', 70)->default('*');}); // Info, które grupy użytkowników "z frontu" mają dostęp do danej pozycji nawigacji. "*" -> wszyscy mają dostęp, "{'a', 'b', 'd'}" ->grupy a, b oraz d mają dostęp do artykułu
		Schema::table($tblName, function($table){$table->string('active', 1);}); //Aktywny - 1, Nieaktywny -0. Aktywny się wyświetla, nieaktywny nie.
		Schema::table($tblName, function($table){$table->string('ilustration', 150)->nullable();});// Ilustracja kategorii
		Schema::table($tblName, function($table){$table->text('images_resized')->nullable();});// Ilustracja kategorii
		Schema::table($tblName, function($table){$table->string('date_from', 10);}); // data od kiedy wyświetla się dana pozycja w nawigacji,
		Schema::table($tblName, function($table){$table->string('date_to', 10)->nullable();}); // data do kiedy wyświetla się dana pozycja w nawigacji, (null - wyświetla się zawsze, chyba, że active jest "0")
		Schema::table($tblName, function($table){$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));});//Imię
		Schema::table($tblName, function($table){$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));});//Imię
		Schema::table($tblName, function($table){$table->index('sort', 'zmcmswaindex1');});
		Schema::table($tblName, function($table){$table->primary('token', 'zmcmswakey1');});

		$tblName=$tblNamePrefix.'website_articles_names';
		Schema::create($tblName, function($table){$table->string('token', 70);});
		Schema::table($tblName, function($table){$table->string('langs_id', 5);});// kod języka, np. pl, en itp
		Schema::table($tblName, function($table){$table->string('title', 150);});// Nazwa (Wyświetla się jako nazwa linku <a>Nazwa linku</a>)
		Schema::table($tblName, function($table){$table->string('slug', 150);});// Nazwa (Wyświetla się jako nazwa linku <a>Nazwa linku</a>)
		Schema::table($tblName, function($table){$table->text('intro')->nullable();});// Wstęp do artykułu. Nadaje się np. do użycia, gy artykuł jest wielostronicowy
		Schema::table($tblName, function($table){$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));});//Imię
		Schema::table($tblName, function($table){$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));});//Imię
		Schema::table($tblName, function($table){$table->index(['token']);});
		Schema::table($tblName, function($table){$table->primary(['token', 'langs_id'], 'zmcmswankey1');}); // Link w ramach języka musi być niepowtarzalny
		Schema::table($tblName, function($table) use ($tblNamePrefix){$table->foreign('token')->references('token')->on($tblNamePrefix.'website_articles')->onUpdate('cascade')->onDelete('cascade');});

		$tblName=$tblNamePrefix.'website_articles_content';
		Schema::create($tblName, function($table){$table->string('token', 70);});
		Schema::table($tblName, function($table){$table->string('langs_id', 5);});// kod języka, np. pl, en itp
		Schema::table($tblName, function($table){$table->integer('page', false, true)->nullable();});// W przypadku wielostronicowego artykułu tutaj podajemy numer strony
		Schema::table($tblName, function($table){$table->string('subtitle', 150)->nullable();});// W przypadku wielostronicowego artykułu tutaj podajemy tytuł danej strony / sekcji wpisu
		Schema::table($tblName, function($table){$table->text('content');});// Treść artykułu
		Schema::table($tblName, function($table){$table->string('meta_keywords', 150)->nullable();});// Słowa kluczowe dla treści
		Schema::table($tblName, function($table){$table->string('meta_description', 150)->nullable();});// Opis w sekcji META
		Schema::table($tblName, function($table){$table->string('og_title', 150)->nullable();});// Parametry dla OpenGraph
		Schema::table($tblName, function($table){$table->string('og_type', 150)->nullable();});// Parametry dla OpenGraph
		Schema::table($tblName, function($table){$table->string('og_url', 150)->nullable();});// Parametry dla OpenGraph
		Schema::table($tblName, function($table){$table->string('og_image', 150)->nullable();});// Parametry dla OpenGraph
		Schema::table($tblName, function($table){$table->string('og_description', 150)->nullable();});// Parametry dla OpenGraph
		Schema::table($tblName, function($table){$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));});//Imię
		Schema::table($tblName, function($table){$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));});//Imię
		Schema::table($tblName, function($table){$table->primary(['token', 'langs_id', 'page'], 'zmcmswackey1');});
		Schema::table($tblName, function($table) use ($tblNamePrefix){$table->foreign('token')->references('token')->on($tblNamePrefix.'website_articles')->onUpdate('cascade')->onDelete('cascade');});

	}
	public function down(){
		
	}
}
