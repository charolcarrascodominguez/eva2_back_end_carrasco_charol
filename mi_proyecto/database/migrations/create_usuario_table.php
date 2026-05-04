use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuarioTable extends Migration
{
    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->string('rut_usuario', 20)->primary();
            $table->string('nombre', 50);
            $table->string('apellido', 50);
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->string('rol', 20); // "reclutador" o "candidato"
        });
    }
    public function down()
    {
        Schema::dropIfExists('usuario');
    }
}
